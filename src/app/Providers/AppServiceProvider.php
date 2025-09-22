<?php

namespace App\Providers;

use App\Enums\Payment\GatewayCode;
use App\Enums\Status;
use App\Models\Language;
use App\Models\PaymentGateway;
use App\Models\Setting;
use App\Services\MailConfigService;
use App\Services\SettingService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Stripe\Util\Set;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {

        Paginator::useBootstrapFive();

        try {
            DB::connection()->getPdo();

            view()->share([
                'languages' => Language::get(),
                'logo_white' => Setting::get('logo_white', 'white_logo.png'),
                'favicon' => Setting::get('logo_favicon', 'favicon.png'),
                'site_title' => Setting::get('site_title', 'FinFunder'),
                'seo_title' => Setting::get('seo_title', 'FinFunder'),
                'seo_description' => Setting::get('seo_description', 'FinFunder'),
                'seo_image' => Setting::get('seo_image', 'seo_image.png'),
                'seo_keywords' => Setting::get('seo_keywords', []),
                'primary_color' => Setting::get('primary_color', '#fe710d'),
                'secondary_color' => Setting::get('secondary_color', '#fe710d'),
                'primary_text_color' => Setting::get('primary_text_color', '#150801'),
                'secondary_text_color' => Setting::get('primary_text_color', '#6a6a6a'),
                'investment_matrix' => Setting::get('investment_matrix', 1),
                'investment_ico_token' => Setting::get('investment_ico_token', 1),
                'investment_investment' => Setting::get('investment_investment', 1),
                'investment_trade_prediction' => Setting::get('investment_trade_prediction', 1),
                'investment_staking_investment' => Setting::get('investment_staking_investment', 1),
                'module_investment_reward' => Setting::get('module_investment_reward', 1),
                'module_withdraw_request' => Setting::get('module_withdraw_request', 1),
                'module_e_pin' => Setting::get('module_e_pin', 1),
                'copy_right_text' => Setting::get('copy_right_text', ''),
                'module_balance_transfer' => Setting::get('module_balance_transfer', 1),
            ]);

//            if ($setting) {
//                $this->configureSocialLogin($setting);
//                $this->firewall($setting);
//                $this->recaptcha($setting);
//            }

            $this->paymentGateway();

        } catch (\Exception $exception) {
            Log::error('AppServiceProvider boot error: ' . $exception->getMessage());
        }
    }

    /**
     * Configure social login services
     *
     * @param Setting $setting
     * @return void
     */
    protected function configureSocialLogin(Setting $setting): void
    {
        $socialLogin = $setting->social_login ?? [];

        if (!empty($socialLogin)) {
            $services = [];

            foreach ($socialLogin as $provider => $config) {
                if (isset($config['status']) && $config['status'] == Status::ACTIVE->value) {
                    $services[$provider] = Arr::except($config, 'status');
                }
            }

            Config::set('services', array_merge(Config::get('services', []), $services));
        }
    }

    /**
     * Configure firewall settings
     *
     * @param Setting|null $setting
     * @return void
     */
    protected function firewall(?Setting $setting): void
    {
        if (!$setting || !$setting->security) {
            return;
        }

        $security = $setting->security;
        $firewallConfig = $security['application_firewall'] ?? [];

        $firewallStatus = ($firewallConfig['status'] ?? 0) == Status::ACTIVE->value;
        $attempts = $firewallConfig['attempts'] ?? 5;
        $frequency = $firewallConfig['frequency'] ?? 60;
        $period = ((int) ($firewallConfig['period'] ?? 30)) * 60;

        // Main firewall settings
        Config::set('firewall.enabled', $firewallStatus);
        Config::set('firewall.middleware.ip.enabled', $firewallStatus);

        // Configure all middleware types
        $middlewareTypes = [
            'agent', 'bot', 'geo', 'lfi', 'login', 'referrer', 'rfi',
            'sqli', 'swear', 'url', 'php', 'xss'
        ];

        foreach ($middlewareTypes as $type) {
            Config::set("firewall.middleware.{$type}.auto_block.attempts", $attempts);
            Config::set("firewall.middleware.{$type}.auto_block.frequency", $frequency);
            Config::set("firewall.middleware.{$type}.auto_block.period", $period);
            Config::set("firewall.middleware.{$type}.enabled", $firewallStatus);
        }
    }

    /**
     * Configure payment gateways
     *
     * @return void
     */
    public function paymentGateway(): void
    {
        $paypal = PaymentGateway::where('code', GatewayCode::PAYPAL)->first();
        $coinbaseCommerce = PaymentGateway::where('code', GatewayCode::COINBASE_COMMERCE)->first();
        $flutterWave = PaymentGateway::where('code', GatewayCode::FLUTTER_WAVE)->first();
        $payStack = PaymentGateway::where('code', GatewayCode::PAY_STACK)->first();

        if ($coinbaseCommerce) {
            Config::set('coinbase.apiKey', Arr::get($coinbaseCommerce->parameter, 'api_key'));
        }

        if ($payStack) {
            Config::set('paystack', [
                'publicKey' => Arr::get($payStack->parameter, 'public_key', ''),
                'secretKey' => Arr::get($payStack->parameter, 'secret_key', ''),
                'paymentUrl' => Arr::get($payStack->parameter, 'payment_url', ''),
                'merchantEmail' => Arr::get($payStack->parameter, 'merchant_email', ''),
            ]);
        }

        if ($flutterWave) {
            Config::set('flutterwave', [
                'publicKey' => Arr::get($flutterWave->parameter, 'public_key', ''),
                'secretKey' => Arr::get($flutterWave->parameter, 'secret_key', ''),
                'secretHash' => Arr::get($flutterWave->parameter, 'secret_hash', ''),
            ]);
        }

        if ($paypal) {
            $paymentParameter = (array) $paypal->parameter ?? [];
            $config = [
                'mode' => Arr::get($paymentParameter, 'environment', 'sandbox'),
                'sandbox' => [
                    'client_id' => Arr::get($paymentParameter, 'client_id', ''),
                    'client_secret' => Arr::get($paymentParameter, 'secret', ''),
                    'app_id' => Arr::get($paymentParameter, 'app_id', ''),
                ],
                'live' => [
                    'client_id' => Arr::get($paymentParameter, 'client_id', ''),
                    'client_secret' => Arr::get($paymentParameter, 'secret', ''),
                    'app_id' => Arr::get($paymentParameter, 'app_id', ''),
                ],
                'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),
                'currency' => env('PAYPAL_CURRENCY', 'USD'),
                'notify_url' => env('PAYPAL_NOTIFY_URL', ''),
                'locale' => env('PAYPAL_LOCALE', 'en_US'),
                'validate_ssl' => env('PAYPAL_VALIDATE_SSL', true),
            ];

            Config::set('paypal', $config);
        }
    }
}
