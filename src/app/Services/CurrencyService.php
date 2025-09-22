<?php

namespace App\Services;

use App\Models\CryptoCurrency;
use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CurrencyService
{
    private const REQUEST_TIMEOUT = 30;


    public function getTopCurrencies()
    {
        return CryptoCurrency::where('type', 'crypto')
            ->where('rank', '>', 0)
            ->orderBy('rank', 'asc')
            ->limit(15)
            ->get([
                'id',
                'symbol',
                'name',
                'current_price',
                'previous_price',
                'change_percent',
                'market_cap',
                'total_volume',
                'rank',
                'image_url',
                'tradingview_symbol',
                'last_updated'
            ]);
    }

    public function getActiveCryptoCurrencyByPaginate()
    {

        return CryptoCurrency::where('type', 'crypto')
            ->where('rank', '>', 0)
            ->orderBy('rank', 'asc')
            ->paginate(10, [
                'id',
                'symbol',
                'name',
                'current_price',
                'previous_price',
                'change_percent',
                'market_cap',
                'total_volume',
                'rank',
                'image_url',
                'tradingview_symbol',
                'last_updated'
            ]);
    }


    /**
     * @return void
     */
    public function updateAllPrices(): void
    {
        if(CryptoCurrency::count() == 0){
            $this->seedTopCryptos();
        }

        $this->updateCryptoPrices();
    }


    /**
     * @return void
     */
    public function seedTopCryptos(): void
    {
        $cryptoData = [
            ['symbol' => 'BTC', 'name' => 'Bitcoin'],
            ['symbol' => 'ETH', 'name' => 'Ethereum'],
            ['symbol' => 'USDT', 'name' => 'Tether'],
            ['symbol' => 'BNB', 'name' => 'BNB'],
            ['symbol' => 'SOL', 'name' => 'Solana'],
            ['symbol' => 'USDC', 'name' => 'USD Coin'],
            ['symbol' => 'STETH', 'name' => 'Lido Staked ETH'],
            ['symbol' => 'DOGE', 'name' => 'Dogecoin'],
            ['symbol' => 'ADA', 'name' => 'Cardano'],
            ['symbol' => 'TRX', 'name' => 'TRON'],
            ['symbol' => 'AVAX', 'name' => 'Avalanche'],
            ['symbol' => 'LINK', 'name' => 'Chainlink'],
            ['symbol' => 'SHIB', 'name' => 'Shiba Inu'],
            ['symbol' => 'BCH', 'name' => 'Bitcoin Cash'],
            ['symbol' => 'DOT', 'name' => 'Polkadot'],
            ['symbol' => 'NEAR', 'name' => 'NEAR Protocol'],
            ['symbol' => 'LTC', 'name' => 'Litecoin'],
            ['symbol' => 'ICP', 'name' => 'Internet Computer'],
            ['symbol' => 'DAI', 'name' => 'Dai'],
            ['symbol' => 'UNI', 'name' => 'Uniswap'],
            ['symbol' => 'LEO', 'name' => 'UNUS SED LEO'],
            ['symbol' => 'ETC', 'name' => 'Ethereum Classic'],
            ['symbol' => 'RNDR', 'name' => 'Render Token'],
            ['symbol' => 'HBAR', 'name' => 'Hedera'],
            ['symbol' => 'KAS', 'name' => 'Kaspa'],
            ['symbol' => 'TAO', 'name' => 'Bittensor'],
            ['symbol' => 'ARB', 'name' => 'Arbitrum'],
            ['symbol' => 'XLM', 'name' => 'Stellar'],
            ['symbol' => 'OKB', 'name' => 'OKB'],
            ['symbol' => 'MNT', 'name' => 'Mantle'],
            ['symbol' => 'FIL', 'name' => 'Filecoin'],
            ['symbol' => 'ATOM', 'name' => 'Cosmos'],
            ['symbol' => 'VET', 'name' => 'VeChain'],
            ['symbol' => 'XMR', 'name' => 'Monero'],
            ['symbol' => 'INJ', 'name' => 'Injective'],
            ['symbol' => 'TON', 'name' => 'The Open Network'],
            ['symbol' => 'SUI', 'name' => 'Sui'],
            ['symbol' => 'AAVE', 'name' => 'Aave'],
        ];

        foreach ($cryptoData as $crypto) {
            CryptoCurrency::updateOrCreate(
                ['symbol' => $crypto['symbol']],
                [
                    'name' => $crypto['name'],
                    'type' => 'crypto',
                    'current_price' => 0,
                    'previous_price' => 0,
                    'base_currency' => 'USD',
                    'tradingview_symbol' => $this->getTradingViewSymbol($crypto['symbol'])
                ]
            );
        }

        $this->updateCryptoPrices();

        Log::info("Seeded " . count($cryptoData) . " crypto currencies with TradingView symbols, prices and images");
    }


    /**
     * @return void
     */
    public function updateCryptoPrices(): void
    {
        $currencies = CryptoCurrency::where('type', 'crypto')->get();

        if ($currencies->isEmpty()) {
            Log::info("No crypto currencies found in database");
            return;
        }

        $coinIds = $currencies->pluck('symbol')->map(function ($symbol) {
            return $this->getCoinGeckoId($symbol);
        })->filter()->unique()->toArray();

        if (empty($coinIds)) {
            Log::warning("No valid coin IDs found for crypto currencies");
            return;
        }
        $url = "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=" . implode(',', $coinIds) . "&order=market_cap_desc&per_page=250&page=1&price_change_percentage=24h";
        $response = $this->makeHttpRequest($url);

        if (!$response) {
            Log::error("Crypto API request failed");
            return;
        }

        try {
            $coinsData = $response->json();
            $this->processCryptoPriceData($coinsData, $currencies);
            Log::info("Successfully updated " . count($currencies) . " crypto prices and images");
        } catch (\Exception $e) {
            Log::error("Crypto price processing failed: " . $e->getMessage());
        }
    }


    /**
     * @param array $coinsData
     * @param $currencies
     * @return void
     */
    private function processCryptoPriceData(array $coinsData, $currencies): void
    {
        $coinDataMap = [];
        foreach ($coinsData as $coinInfo) {
            $coinDataMap[$coinInfo['id']] = $coinInfo;
        }

        foreach ($currencies as $currency) {
            $coinId = $this->getCoinGeckoId($currency->symbol);

            if (!$coinId || !isset($coinDataMap[$coinId])) {
                continue;
            }

            $coinInfo = $coinDataMap[$coinId];
            $newPrice = $coinInfo['current_price'] ?? 0;
            $changePercent = $coinInfo['price_change_percentage_24h'] ?? null;
            $imageUrl = $coinInfo['image'] ?? null;
            $tradingViewSymbol = $this->getTradingViewSymbol($currency->symbol);

            $updateData = [
                'total_volume' => $coinInfo['total_volume'] ?? 0,
                'market_cap' => $coinInfo['market_cap'] ?? 0,
                'rank' => $coinInfo['market_cap_rank'] ?? 0,
                'previous_price' => $currency->current_price,
                'current_price' => $newPrice,
                'change_percent' => $changePercent,
                'last_updated' => Carbon::now(),
            ];

            if ($imageUrl) {
                $updateData['image_url'] = $imageUrl;
            }

            if ($tradingViewSymbol && $currency->tradingview_symbol !== $tradingViewSymbol) {
                $updateData['tradingview_symbol'] = $tradingViewSymbol;
            }

            $currency->update($updateData);
        }
    }

    /**
     * @param string $symbol
     * @return string|null
     */
    private function getCoinGeckoId(string $symbol): ?string
    {
        $symbolMap = [
            'BTC' => 'bitcoin',
            'ETH' => 'ethereum',
            'USDT' => 'tether',
            'BNB' => 'binancecoin',
            'SOL' => 'solana',
            'USDC' => 'usd-coin',
            'XRP' => 'xrp',
            'STETH' => 'staked-ether',
            'DOGE' => 'dogecoin',
            'ADA' => 'cardano',
            'TRX' => 'tron',
            'AVAX' => 'avalanche-2',
            'LINK' => 'chainlink',
            'SHIB' => 'shiba-inu',
            'BCH' => 'bitcoin-cash',
            'DOT' => 'polkadot',
            'NEAR' => 'near',
            'MATIC' => 'polygon',
            'LTC' => 'litecoin',
            'ICP' => 'internet-computer',
            'DAI' => 'dai',
            'UNI' => 'uniswap',
            'LEO' => 'leo-token',
            'ETC' => 'ethereum-classic',
            'RNDR' => 'render-token',
            'HBAR' => 'hedera-hashgraph',
            'KAS' => 'kaspa',
            'TAO' => 'bittensor',
            'ARB' => 'arbitrum',
            'XLM' => 'stellar',
            'CRO' => 'cronos',
            'OKB' => 'okb',
            'MNT' => 'mantle',
            'FIL' => 'filecoin',
            'ATOM' => 'cosmos',
            'VET' => 'vechain',
            'XMR' => 'monero',
            'INJ' => 'injective-protocol',
            'TON' => 'the-open-network',
            'SUI' => 'sui',
            'AAVE' => 'aave',
            'OP' => 'optimism',
            'IMX' => 'immutable-x',
            'FDUSD' => 'first-digital-usd',
            'MKR' => 'maker',
            'RETH' => 'rocket-pool-eth',
            'FTM' => 'fantom',
            'BONK' => 'bonk',
            'ALGO' => 'algorand',
            'THETA' => 'theta-token'
        ];

        return $symbolMap[strtoupper($symbol)] ?? null;
    }

    /**
     * @param string $symbol
     * @return string|null
     */
    private function getTradingViewSymbol(string $symbol): ?string
    {
        $tradingViewMap = [
            'BTC' => 'CRYPTOCAP:BTC',
            'ETH' => 'CRYPTOCAP:ETH',
            'USDT' => 'CRYPTOCAP:USDT',
            'BNB' => 'CRYPTOCAP:BNB',
            'SOL' => 'CRYPTOCAP:SOL',
            'USDC' => 'CRYPTOCAP:USDC',
            'XRP' => 'CRYPTOCAP:XRP',
            'STETH' => 'CRYPTOCAP:STETH',
            'DOGE' => 'CRYPTOCAP:DOGE',
            'ADA' => 'CRYPTOCAP:ADA',
            'TRX' => 'CRYPTOCAP:TRX',
            'AVAX' => 'CRYPTOCAP:AVAX',
            'LINK' => 'CRYPTOCAP:LINK',
            'SHIB' => 'CRYPTOCAP:SHIB',
            'BCH' => 'CRYPTOCAP:BCH',
            'DOT' => 'CRYPTOCAP:DOT',
            'NEAR' => 'CRYPTOCAP:NEAR',
            'MATIC' => 'CRYPTOCAP:MATIC',
            'LTC' => 'CRYPTOCAP:LTC',
            'ICP' => 'CRYPTOCAP:ICP',
            'DAI' => 'CRYPTOCAP:DAI',
            'UNI' => 'CRYPTOCAP:UNI',
            'LEO' => 'CRYPTOCAP:LEO',
            'ETC' => 'CRYPTOCAP:ETC',
            'RNDR' => 'CRYPTOCAP:RNDR',
            'HBAR' => 'CRYPTOCAP:HBAR',
            'KAS' => 'CRYPTOCAP:KAS',
            'TAO' => 'CRYPTOCAP:TAO',
            'ARB' => 'CRYPTOCAP:ARB',
            'XLM' => 'CRYPTOCAP:XLM',
            'CRO' => 'CRYPTOCAP:CRO',
            'OKB' => 'CRYPTOCAP:OKB',
            'MNT' => 'CRYPTOCAP:MNT',
            'FIL' => 'CRYPTOCAP:FIL',
            'ATOM' => 'CRYPTOCAP:ATOM',
            'VET' => 'CRYPTOCAP:VET',
            'XMR' => 'CRYPTOCAP:XMR',
            'INJ' => 'CRYPTOCAP:INJ',
            'TON' => 'CRYPTOCAP:TON',
            'SUI' => 'CRYPTOCAP:SUI',
            'AAVE' => 'CRYPTOCAP:AAVE',
            'OP' => 'CRYPTOCAP:OP',
            'IMX' => 'CRYPTOCAP:IMX',
            'FDUSD' => 'CRYPTOCAP:FDUSD',
            'MKR' => 'CRYPTOCAP:MKR',
            'RETH' => 'CRYPTOCAP:RETH',
            'FTM' => 'CRYPTOCAP:FTM',
            'BONK' => 'CRYPTOCAP:BONK',
            'ALGO' => 'CRYPTOCAP:ALGO',
            'THETA' => 'CRYPTOCAP:THETA'
        ];

        return $tradingViewMap[strtoupper($symbol)] ?? null;
    }

    /**
     * @param string $url
     * @return Response|null
     */
    private function makeHttpRequest(string $url): Response|null
    {
        try {
            $response = Http::timeout(self::REQUEST_TIMEOUT)->get($url);
            return $response->successful() ? $response : null;
        } catch (\Exception $e) {
            Log::error("HTTP request failed for {$url}: " . $e->getMessage());
            return null;
        }
    }


}
