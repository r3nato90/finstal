<?php

namespace App\Console\Commands;

use App\Services\CurrencyService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CryptoCurrencyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:update-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cryptocurrency prices from external API';

    /**
     * The currency service instance.
     *
     * @var CurrencyService
     */
    protected CurrencyService $currencyService;

    /**
     * Create a new command instance.
     *
     * @param CurrencyService $currencyService
     */
    public function __construct(CurrencyService $currencyService)
    {
        parent::__construct();
        $this->currencyService = $currencyService;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {
        $this->info('Starting cryptocurrency price update...');

        try {
            $startTime = microtime(true);
            $this->currencyService->updateAllPrices();
            $endTime = microtime(true);
            $executionTime = round(($endTime - $startTime), 2);

            $this->info("Cryptocurrency prices updated successfully in {$executionTime} seconds");

            Log::info("Crypto prices updated via console command", [
                'execution_time' => $executionTime,
                'timestamp' => now()
            ]);

            return;

        } catch (\Exception $e) {
            $this->error('Failed to update cryptocurrency prices: ' . $e->getMessage());

            Log::error('Crypto price update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'timestamp' => now()
            ]);

            return;
        }
    }
}
