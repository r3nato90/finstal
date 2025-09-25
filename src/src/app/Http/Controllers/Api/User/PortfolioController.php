<?php

namespace App\Http\Controllers\Api\User;

use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Models\IcoPurchase;
use App\Models\IcoToken;
use App\Models\TokenSale;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PortfolioController extends Controller
{
    public function __construct(
        protected WalletService $walletService,
        protected TransactionService $transactionService,
    ) {}

    /**
     * Display portfolio index page
     */
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();
            $holdings = $this->getUserTokenHoldings($user->id);
            $portfolioStats = $this->calculatePortfolioStats($holdings);

            return ApiJsonResponse::success('Portfolio data fetched successfully', [
                'holdings' => $holdings->toArray(),
                'portfolio_stats' => $portfolioStats,
                'user_balance' => [
                    'primary_balance' => (float) $user->wallet->primary_balance,
                    'trade_balance' => (float) $user->wallet->trade_balance,
                ],
            ]);

        } catch (\Exception $e) {
            Log::error('API Portfolio Error: ' . $e->getMessage(), [
                'user_id' => Auth::id()
            ]);

            return ApiJsonResponse::error('Unable to load portfolio. Please try again.');
        }
    }

    /**
     * Handle token sale
     */
    public function sell(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            $validated = $request->validate([
                'ico_token_id' => 'required|integer|exists:tokens,id',
                'tokens_to_sell' => 'required|integer|min:1'
            ]);

            $icoToken = IcoToken::findOrFail($validated['ico_token_id']);
            $tokensToSell = $validated['tokens_to_sell'];

            // Calculate available tokens
            $userTokens = IcoPurchase::where('user_id', $user->id)
                ->where('ico_token_id', $icoToken->id)
                ->where('status', 'completed')
                ->sum('tokens_purchased');

            $soldTokens = TokenSale::where('user_id', $user->id)
                ->where('ico_token_id', $icoToken->id)
                ->where('status', 'completed')
                ->sum('tokens_sold');

            $availableTokens = $userTokens - $soldTokens;

            if ($tokensToSell > $availableTokens) {
                return ApiJsonResponse::error('Insufficient tokens to sell.');
            }

            $salePrice = $icoToken->current_price ?? $icoToken->price;
            $totalAmount = $tokensToSell * $salePrice;

            DB::beginTransaction();

            try {
                $sale = TokenSale::create([
                    'user_id' => $user->id,
                    'ico_token_id' => $icoToken->id,
                    'sale_id' => TokenSale::generateSaleId(),
                    'tokens_sold' => $tokensToSell,
                    'sale_price' => $salePrice,
                    'total_amount' => $totalAmount,
                    'status' => 'completed',
                    'sold_at' => now()
                ]);

                $wallet = $user->wallet;
                $wallet->increment('primary_balance', $totalAmount);

                $this->transactionService->save($this->transactionService->prepParams([
                    'user_id' => $user->id,
                    'amount' => $totalAmount,
                    'type' => Type::PLUS,
                    'trx' => getTrx(),
                    'details' => "Token sale: {$icoToken->symbol} ({$tokensToSell} tokens)",
                    'wallet' => $this->walletService->findBalanceByWalletType(WalletType::PRIMARY->value, $wallet),
                    'source' => Source::ICO->value
                ]));

                DB::commit();

                return ApiJsonResponse::success(
                    'Successfully sold ' . getAmount($tokensToSell) . ' ' . $icoToken->symbol . ' tokens for ' . getCurrencySymbol() . getAmount($totalAmount),
                    [
                        'sale' => [
                            'id' => $sale->id,
                            'sale_id' => $sale->sale_id,
                            'tokens_sold' => (float) $sale->tokens_sold,
                            'sale_price' => (float) $sale->sale_price,
                            'total_amount' => (float) $sale->total_amount,
                            'status' => $sale->status,
                            'sold_at' => $sale->sold_at->toISOString(),
                        ],
                        'token' => [
                            'id' => $icoToken->id,
                            'name' => $icoToken->name,
                            'symbol' => $icoToken->symbol,
                            'current_price' => (float) $salePrice,
                        ]
                    ]
                );

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (\Exception $e) {
            Log::error('API Token Sale Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->only(['ico_token_id', 'tokens_to_sell'])
            ]);

            return ApiJsonResponse::error('Failed to sell tokens. Please try again.');
        }
    }

    /**
     * Get detailed holding information for a specific token
     */
    public function holding(Request $request, $tokenId): JsonResponse
    {
        try {
            $user = Auth::user();
            $icoToken = IcoToken::findOrFail($tokenId);

            $holding = $this->getUserTokenHoldings($user->id)
                ->where('token.id', $tokenId)
                ->first();

            if (!$holding) {
                return ApiJsonResponse::error('Token holding not found.');
            }

            // Get purchase history for this token
            $purchases = IcoPurchase::where('user_id', $user->id)
                ->where('ico_token_id', $tokenId)
                ->latest()
                ->get()
                ->map(function ($purchase) {
                    return [
                        'id' => $purchase->id,
                        'purchase_id' => $purchase->purchase_id,
                        'amount_usd' => (float) $purchase->amount_usd,
                        'tokens_purchased' => (float) $purchase->tokens_purchased,
                        'token_price' => (float) $purchase->token_price,
                        'status' => $purchase->status,
                        'purchased_at' => $purchase->purchased_at ? $purchase->purchased_at->toISOString() : null,
                    ];
                });

            // Get sale history for this token
            $sales = TokenSale::where('user_id', $user->id)
                ->where('ico_token_id', $tokenId)
                ->latest()
                ->get()
                ->map(function ($sale) {
                    return [
                        'id' => $sale->id,
                        'sale_id' => $sale->sale_id,
                        'tokens_sold' => (float) $sale->tokens_sold,
                        'sale_price' => (float) $sale->sale_price,
                        'total_amount' => (float) $sale->total_amount,
                        'status' => $sale->status,
                        'sold_at' => $sale->sold_at ? $sale->sold_at->toISOString() : null,
                    ];
                });

            return ApiJsonResponse::success('Token holding details fetched successfully', [
                'holding' => $holding,
                'purchases' => $purchases,
                'sales' => $sales,
                'token_info' => [
                    'id' => $icoToken->id,
                    'name' => $icoToken->name,
                    'symbol' => $icoToken->symbol,
                    'price' => (float) $icoToken->price,
                    'current_price' => (float) ($icoToken->current_price ?? $icoToken->price),
                    'description' => $icoToken->description,
                    'total_supply' => (float) $icoToken->total_supply,
                    'tokens_sold' => (float) $icoToken->tokens_sold,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('API Portfolio Holding Error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'token_id' => $tokenId
            ]);

            return ApiJsonResponse::error('Unable to load token holding details.');
        }
    }

    /**
     * Get user token holdings with calculations
     */
    private function getUserTokenHoldings($userId)
    {
        return IcoPurchase::select([
            'ico_token_id',
            DB::raw('SUM(tokens_purchased) as total_tokens'),
            DB::raw('SUM(amount_usd) as total_invested'),
            DB::raw('AVG(token_price) as average_price'),
            DB::raw('MIN(purchased_at) as first_purchase_date'),
            DB::raw('MAX(purchased_at) as last_purchase_date'),
            DB::raw('COUNT(*) as purchase_count')
        ])
            ->with(['icoToken' => function ($query) {
                $query->select('id', 'name', 'symbol', 'price', 'current_price', 'price_updated_at');
            }])
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->groupBy('ico_token_id')
            ->get()
            ->map(function ($holding) use ($userId) {
                $token = $holding->icoToken;
                $currentPrice = $token->current_price ?? $token->price;

                // Calculate sold tokens data
                $soldTokensData = TokenSale::where('user_id', $userId)
                    ->where('ico_token_id', $token->id)
                    ->where('status', 'completed')
                    ->selectRaw('SUM(tokens_sold) as total_sold, SUM(total_amount) as total_revenue')
                    ->first();

                $soldTokens = $soldTokensData->total_sold ?? 0;
                $soldRevenue = $soldTokensData->total_revenue ?? 0;

                $availableTokens = $holding->total_tokens - $soldTokens;
                $soldTokensCost = $soldTokens * $holding->average_price;
                $adjustedInvestment = $holding->total_invested - $soldTokensCost;

                $currentValue = $availableTokens * $currentPrice;
                $profitLoss = $currentValue - $adjustedInvestment;
                $realizedPL = $soldRevenue - $soldTokensCost;

                $profitLossPercentage = $adjustedInvestment > 0
                    ? (($profitLoss / $adjustedInvestment) * 100)
                    : 0;

                $priceChangePercentage = 0;
                if ($token->current_price && $token->price && $token->price > 0) {
                    $priceChangePercentage = (($token->current_price - $token->price) / $token->price) * 100;
                }

                return (object) [
                    'token' => (object) [
                        'id' => $token->id,
                        'name' => $token->name,
                        'symbol' => $token->symbol,
                        'price' => (float) $token->price,
                        'current_price' => (float) $currentPrice,
                        'price_change_percentage' => (float) $priceChangePercentage,
                    ],
                    'total_tokens' => (float) $holding->total_tokens,
                    'available_tokens' => (float) $availableTokens,
                    'sold_tokens' => (float) $soldTokens,
                    'total_invested' => (float) $holding->total_invested,
                    'adjusted_investment' => (float) $adjustedInvestment,
                    'average_price' => (float) $holding->average_price,
                    'current_value' => (float) $currentValue,
                    'profit_loss' => (float) $profitLoss,
                    'profit_loss_percentage' => (float) $profitLossPercentage,
                    'realized_pl' => (float) $realizedPL,
                    'is_profitable' => $profitLoss > 0,
                    'first_purchase_date' => $holding->first_purchase_date ? \Carbon\Carbon::parse($holding->first_purchase_date)->toISOString() : null,
                    'last_purchase_date' => $holding->last_purchase_date ? \Carbon\Carbon::parse($holding->last_purchase_date)->toISOString() : null,
                    'purchase_count' => (int) $holding->purchase_count,
                    'sold_revenue' => (float) $soldRevenue
                ];
            })
            ->filter(function ($holding) {
                return $holding->available_tokens > 0;
            })
            ->sortByDesc('current_value')
            ->values();
    }

    /**
     * Calculate portfolio statistics
     */
    private function calculatePortfolioStats($holdings): array
    {
        $totalInvested = $holdings->sum('adjusted_investment');
        $currentValue = $holdings->sum('current_value');
        $totalProfitLoss = $currentValue - $totalInvested;
        $totalRealizedPL = $holdings->sum('realized_pl');
        $totalProfitLossPercentage = $totalInvested > 0
            ? (($totalProfitLoss / $totalInvested) * 100)
            : 0;

        return [
            'total_invested' => (float) $totalInvested,
            'current_value' => (float) $currentValue,
            'total_profit_loss' => (float) $totalProfitLoss,
            'total_profit_loss_percentage' => (float) $totalProfitLossPercentage,
            'total_realized_pl' => (float) $totalRealizedPL,
            'total_tokens' => (float) $holdings->sum('available_tokens'),
            'profitable_holdings' => $holdings->where('is_profitable', true)->count(),
            'losing_holdings' => $holdings->where('is_profitable', false)->count(),
            'total_holdings' => $holdings->count()
        ];
    }
}
