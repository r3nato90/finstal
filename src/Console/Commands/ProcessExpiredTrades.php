<?php

namespace App\Console\Commands;

use App\Models\TradeLog;
use App\Models\CryptoCurrency;
use App\Models\Transaction;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ProcessExpiredTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trade:process-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process expired trade trades and determine win/loss/draw results';

    /**
     * Configuration for different server environments
     */
    private array $config = [
        'binance_timeout' => 5,
        'max_retries' => 2,
        'fallback_enabled' => true,
        'cache_duration' => 300,
    ];

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $expiredTrades = TradeLog::with(['user'])
            ->where('status', 'active')
            ->where('expiry_time', '<=', now())
            ->get();

        if ($expiredTrades->isEmpty()) {
            $this->info('No expired trades found.');
            return;
        }

        $this->info("Found {$expiredTrades->count()} expired trades to process.");

        $processedCount = 0;
        $wonCount = 0;
        $lostCount = 0;
        $drawCount = 0;
        $errors = 0;

        foreach ($expiredTrades as $trade) {
            try {
                $result = $this->processTrade($trade);

                if ($result) {
                    $processedCount++;

                    switch ($result['status']) {
                        case 'won':
                            $wonCount++;
                            break;
                        case 'lost':
                            $lostCount++;
                            break;
                        case 'draw':
                            $drawCount++;
                            break;
                    }

                    $this->line(sprintf(
                        'Trade #%s (%s): %s - Open: %s, Close: %s, P&L: %s',
                        $trade->trade_id,
                        $trade->symbol,
                        strtoupper($result['status']),
                        $trade->open_price,
                        $result['close_price'],
                        $result['profit_loss']
                    ));
                }

            } catch (Exception $e) {
                $errors++;
                $this->error("Error processing trade #{$trade->trade_id}: " . $e->getMessage());
                Log::error("Trade processing error", [
                    'trade_id' => $trade->trade_id,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);
            }
        }

        $this->newLine();
        $this->info('=== Processing Summary ===');
        $this->info("Total processed: {$processedCount}");
        $this->info("Won: {$wonCount}");
        $this->info("Lost: {$lostCount}");
        $this->info("Draw: {$drawCount}");

        if ($errors > 0) {
            $this->error("Errors: {$errors}");
        }
    }

    /**
     * @param TradeLog $trade
     * @param bool $isDryRun
     * @return array|null
     * @throws Exception
     */
    private function processTrade(TradeLog $trade, bool $isDryRun = false): ?array
    {
        $startTime = microtime(true);

        try {
            $priceData = $this->getCurrentPriceCompatible($trade->symbol);

            if (!$priceData || !$priceData['price']) {
                throw new Exception("Could not retrieve price for {$trade->symbol} from any source");
            }

            $closePrice = $priceData['price'];
            $priceSource = $priceData['source'];

            $this->line("Price source for {$trade->symbol}: {$priceSource} = {$closePrice}");

            $openPrice = (float) $trade->open_price;
            $amount = (float) $trade->amount;
            $payoutRate = (float) $trade->payout_rate;

            $status = $this->determineTradeResult($trade->direction, $openPrice, $closePrice);
            $profitLoss = $this->calculateProfitLoss($status, $amount, $payoutRate);

            $updateData = [
                'close_price' => $closePrice,
                'close_time' => now(),
                'status' => $status,
                'profit_loss' => $profitLoss,
            ];

            $updateAmount = $updateData['profit_loss'];
            if ($updateData['status'] === 'draw') {
                $updateAmount = $amount;
            }

            if (!(false)) {
                DB::transaction(function () use ($trade, $updateData, $updateAmount) {
                    $trade->update($updateData);

                    if ($updateData['status'] === 'won' || $updateData['status'] === 'draw') {
                        $trade->refresh();
                        $this->updateUserBalance($trade->user_id, $updateAmount, $trade);
                    }
                });
            }

            $this->cachePriceSafely($trade->symbol, $closePrice);
            $processingTime = (microtime(true) - $startTime) * 1000;
            Log::info("Trade processed", [
                'trade_id' => $trade->trade_id,
                'processing_time_ms' => round($processingTime, 2),
                'price_source' => $priceSource
            ]);

            return array_merge($updateData, ['trade_id' => $trade->trade_id]);

        } catch (Exception $e) {
            Log::error("Trade processing failed", [
                'trade_id' => $trade->trade_id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }


    /**
     * @param string $symbol
     * @return array|null
     */
    private function getCurrentPriceCompatible(string $symbol): ?array
    {
        $methods = [
            'binance_curl' => [$this, 'getBinancePriceCurl'],
            'cache_laravel' => [$this, 'getCachedPriceLaravel'],
            'database' => [$this, 'getDatabasePrice'],
        ];

        foreach ($methods as $methodName => $method) {
            try {
                $price = call_user_func($method, $symbol);

                if ($price !== null && $price > 0) {
                    return [
                        'price' => $price,
                        'source' => $methodName
                    ];
                }
            } catch (Exception $e) {
                Log::debug("Price method '{$methodName}' failed for {$symbol}: " . $e->getMessage());
                continue;
            }
        }

        return null;
    }

    /**
     * @param string $symbol
     * @return float|null
     */
    private function getDatabasePrice(string $symbol): ?float
    {
        try {
            $currency = CryptoCurrency::where('symbol', $symbol)->first();
            if (!$currency || !$currency->current_price) {
                return null;
            }

            return (float) $currency->current_price;
        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * @param string $symbol
     * @return float|null
     */
    private function getCachedPriceLaravel(string $symbol): ?float
    {
        try {
            $cacheKey = "price_{$symbol}";
            $cachedData = Cache::get($cacheKey);

            if ($cachedData && is_array($cachedData)) {
                $cacheAge = time() - $cachedData['timestamp'];

                if ($cacheAge < $this->config['cache_duration']) {
                    return (float) $cachedData['price'];
                }
            }
        } catch (Exception $e) {
        }

        return null;
    }


    /**
     * @param string $symbol
     * @return float|null
     */
    private function getBinancePriceCurl(string $symbol): ?float
    {
        if (!function_exists('curl_init')) {
            return null;
        }

        $binanceSymbol = $symbol.'USDT';
        $url = "https://api.binance.com/api/v3/ticker/price?symbol={$binanceSymbol}";


        for ($attempt = 1; $attempt <= $this->config['max_retries']; $attempt++) {
            $ch = curl_init();

            curl_setopt_array($ch, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->config['binance_timeout'],
                CURLOPT_CONNECTTIMEOUT => 3,
                CURLOPT_USERAGENT => 'Mozilla/5.0 (compatible; TradingBot/1.0)',
                CURLOPT_HTTPHEADER => ['Accept: application/json'],
                CURLOPT_FOLLOWLOCATION => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_FAILONERROR => false,
            ]);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $error = curl_error($ch);
            curl_close($ch);

            if ($response && !$error && $httpCode === 200) {
                $data = json_decode($response, true);
                if (json_last_error() === JSON_ERROR_NONE && isset($data['price'])) {
                    $price = (float) $data['price'];

                    $this->cachePriceSafely($symbol, $price);
                    return $price;
                }
            }

            if ($attempt < $this->config['max_retries']) {
                usleep(100000);
            }
        }

        return null;
    }


    /**
     * @param string $symbol
     * @param float $price
     * @return void
     */
    private function cachePriceSafely(string $symbol, float $price): void
    {
        try {
            $cacheKey = "price_{$symbol}";
            $data = [
                'price' => $price,
                'timestamp' => time()
            ];

            Cache::put($cacheKey, $data, now()->addMinutes(5));

        } catch (Exception $e) {
        }
    }


    /**
     * @param string $direction
     * @param float $openPrice
     * @param float $closePrice
     * @return string
     */
    private function determineTradeResult(string $direction, float $openPrice, float $closePrice): string
    {
        if ($openPrice == $closePrice) {
            return 'draw';
        }

        $priceIncreased = $closePrice > $openPrice;

        if ($direction === 'up') {
            return $priceIncreased ? 'won' : 'lost';
        } else {
            return $priceIncreased ? 'lost' : 'won';
        }
    }


    /**
     * @param string $status
     * @param float $amount
     * @param float $payoutRate
     * @return float
     */
    private function calculateProfitLoss(string $status, float $amount, float $payoutRate): float
    {
        return match ($status) {
            'won' => ($amount * $payoutRate) / 100,
            'lost' => -$amount,
            default => 0,
        };
    }


    /**
     * @param int $userId
     * @param float $amount
     * @param TradeLog $trade
     * @return void
     * @throws Exception
     */
    private function updateUserBalance(int $userId, float $amount, TradeLog $trade): void
    {
        $user = \App\Models\User::find($userId);

        if (!$user) {
            throw new Exception("User with ID {$userId} not found");
        }

        $wallet = $user->wallet;
        if (!$wallet) {
            throw new Exception("Wallet not found for user {$userId}");
        }

        $previousBalance = $wallet->trade_balance;

        if ($trade->status === 'won') {
            $totalAmount = $trade->amount + $amount;
            $wallet->increment('trade_balance', $totalAmount);
            $postBalance = $previousBalance + $totalAmount;

            Transaction::create([
                'user_id' => $user->id,
                'type' => Type::PLUS->value,
                'wallet_type' => WalletType::TRADE->value,
                'amount' => $totalAmount,
                'trx' => Str::random(16),
                'post_balance' => $postBalance,
                'source' => Source::TRADE->value,
                'details' => "Trade won for {$trade->symbol} ({$trade->direction}) - Investment return: " . number_format($trade->amount, 2) . " + Profit: " . number_format($amount, 2) . " = Total: " . number_format($totalAmount, 2),
            ]);

        } elseif ($trade->status === 'draw') {
            $wallet->increment('trade_balance', $amount);
            $postBalance = $previousBalance + $amount;

            Transaction::create([
                'user_id' => $user->id,
                'type' => Type::PLUS->value,
                'wallet_type' => WalletType::TRADE->value,
                'amount' => $amount,
                'trx' => Str::random(16),
                'post_balance' => $postBalance,
                'source' => Source::TRADE->value,
                'details' => "Trade draw for {$trade->symbol} ({$trade->direction}) - Investment refund: " . number_format($amount, 2),
            ]);
        }
    }
}
