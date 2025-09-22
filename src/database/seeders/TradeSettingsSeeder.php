<?php

namespace Database\Seeders;

use App\Models\CryptoCurrency;
use Illuminate\Database\Seeder;
use App\Models\TradeSetting;
use Illuminate\Support\Facades\DB;

class TradeSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $currencies = CryptoCurrency::all();
            if ($currencies->isEmpty()) {
                return;
            }

            foreach ($currencies as $currency) {
                $settings = $this->getSettingsByType();
                $data = [
                    'currency_id'          => $currency->id,
                    'symbol'               => $currency->symbol,
                    'is_active'            => rand(0, 10) > 2,
                    'min_amount'           => $settings['min_amount'],
                    'max_amount'           => $settings['max_amount'],
                    'payout_rate'          => $settings['payout_rate'],
                    'durations'            => $this->getDurationsByType(),
                    'trading_hours'        => $this->getTradingHoursByType(),
                    'spread'               => $settings['spread'],
                    'max_trades_per_user'  => rand(5, 20),
                ];

                TradeSetting::updateOrCreate(
                    ['currency_id' => $currency->id, 'symbol' => $currency->symbol],
                    $data
                );
            }
        });
    }

    private function getSettingsByType(): array
    {
        return [
            'min_amount'  => 10,
            'max_amount'  => 5000,
            'payout_rate' => rand(80, 90),
            'spread'      => rand(5, 15) / 100000,
        ];
    }

    private function getDurationsByType(): array
    {
        return [30, 60, 300, 900];
    }

    private function getTradingHoursByType(): array
    {
        return [
            'monday'    => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'tuesday'   => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'wednesday' => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'thursday'  => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'friday'    => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'saturday'  => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
            'sunday'    => ['enabled' => true, 'start' => '00:00', 'end' => '23:59'],
        ];
    }
}
