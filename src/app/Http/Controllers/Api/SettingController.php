<?php

namespace App\Http\Controllers\Api;

use App\Enums\Trade\TradeOutcome;
use App\Enums\Trade\TradeParameterStatus;
use App\Enums\Trade\TradeStatus;
use App\Enums\Trade\TradeType;
use App\Enums\Trade\TradeVolume;
use App\Enums\Transaction\BalanceType;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\SettingService;
use App\Utilities\Api\ApiJsonResponse;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        $setting = SettingService::getSetting();

        return ApiJsonResponse::success('Setting api', [
            'site_title' => Setting::get('site_title', 'FinFunder'),
            'white_logo' => displayImage(Setting::get('logo_white', 'white_logo.png')),
            'dark_logo' => displayImage(Setting::get('logo_dark', 'dark_logo.png')),
            'trade_practice_balance' => 500,
            'currency_name'=> getCurrencyName(),
            'currency_symbol'=> getCurrencySymbol(),
            'investment_matrix' => Setting::get('investment_matrix', 1),
            'investment_ico_token' => Setting::get('investment_ico_token', 1),
            'investment_investment' => Setting::get('investment_investment', 1),
            'investment_trade_prediction' => Setting::get('investment_trade_prediction', 1),
            'investment_staking_investment' => Setting::get('investment_staking_investment', 1),
            'sign_up_content' => [
                'title' => 'Step into the world of smart trading',
                'content' => [
                    [
                        'title' => 'Secure Investment',
                        'details' => 'Invest with confidence in a platform that prioritizes security and stability. We offer advanced tools to protect your assets and ensure maximum returns.'
                    ],
                    [
                        'title' => 'Referral Rewards',
                        'details' => 'Earn rewards by referring friends and family to our platform. The more people you invite, the more you can benefit through our tiered referral program.'
                    ],
                    [
                        'title' => 'Community Support',
                        'details' => 'Join a vibrant community of traders and investors. Access support, share strategies, and grow your trading knowledge with expert guidance available at all times.'
                    ]
                ]
            ],
            'enums' => [
                'transaction' => [
                    'type' => Type::toArray(),
                    'source' => Source::toArray(),
                    'wallet_type' => WalletType::toArray(),
                    'balance_type' => BalanceType::toArray(),
                ],
                'trade' => [
                    'trade_outcome' => TradeOutcome::toArray(),
                    'trade_parameter' => TradeParameterStatus::toArray(),
                    'trade_status' => TradeStatus::toArray(),
                    'trade_type' => TradeType::toArray(),
                    'trade_volume' => TradeVolume::toArray(),
                ],
            ],
        ]);
    }
}
