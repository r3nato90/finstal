<?php

namespace App\Providers;

use App\Enums\MenuStatus;
use App\Enums\PluginCode;
use App\Enums\Status;
use App\Models\CryptoCurrency;
use App\Models\Menu;
use App\Models\Notification;
use App\Models\PinGenerate;
use App\Models\PluginConfiguration;
use App\Services\Investment\InvestmentPlanService;
use App\Services\Investment\MatrixService;
use App\Services\Investment\Staking\PlanService;
use App\Services\SettingService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        try {
            DB::connection()->getPdo();
            $activeTheme = 'default_theme';
            View::composer('admin.partials.top-bar', function ($view) {
                $view->with([
                    'notifications' => Notification::latest()->whereNull('read_at')->get(),
                ]);
            });

            View::composer('admin.pin_generate.index', function ($view) {
                $view->with([
                    'total_pin' => PinGenerate::count(),
                    'total_utilized_pin' => PinGenerate::utilized()->count(),
                    'total_unused_pin' => PinGenerate::unused()->count(),
                    'total_users_pin' => PinGenerate::users()->count(),
                    'total_admins_pin' => PinGenerate::admins()->count(),
                ]);
            });

            View::composer(["$activeTheme.partials.header", "$activeTheme.partials.footer"], function ($view) {
                $view->with([
                    'menus' => Menu::with(['children'])->where('status', MenuStatus::ENABLE->value)->get(),
                ]);
            });

            View::composer("$activeTheme.component.crypto_currency", function ($view) {
                $view->with([
                    'cryptos' => CryptoCurrency::limit(14)->get(),
                ]);
            });

            View::composer("$activeTheme.component.crypto_pairs", function ($view) {
                $view->with([
                    'cryptoConversions' => CryptoCurrency::limit(9)->get(),
                ]);
            });

            View::composer("$activeTheme.component.currency_exchange", function ($view) {
                $view->with([
                    'currencyExchanges' => CryptoCurrency::whereIn('symbol', ['btc', 'eth', 'ltc', 'xrp', 'bch', 'ada', 'dot', 'bnb', 'link'])
                        ->get(),
                ]);
            });

            View::composer(['user.partials.matrix.plan', 'user.partials.matrix.blue_plan'], function ($view) {
                $view->with([
                    'matrix' => resolve(MatrixService::class)->getActivePlan(),
                ]);
            });

            View::composer(['user.partials.investment.plan', 'user.partials.investment.blue_plan', "$activeTheme.component.investment-profit-calculation"], function ($view) {
                $view->with([
                    'investments' => resolve(InvestmentPlanService::class)->fetchActivePlan(),
                ]);
            });

            View::composer(["$activeTheme.component.staking-investment"], function ($view) {
                $view->with([
                    'stakingInvestments' => resolve(PlanService::class)->getActivePlans(),
                ]);
            });


            View::composer("$activeTheme.partials.header", function ($view) {
                $view->with([
                    'cryptoCurrencies' => CryptoCurrency::get(),
                ]);
            });

            View::composer('partials.tawkto', function ($view) {
                $view->with([
                    'tawkto' => PluginConfiguration::where('code', PluginCode::TAWK->value)->first(),
                ]);
            });

            View::composer('partials.hoory', function ($view) {
                $view->with([
                    'hoory' => PluginConfiguration::where('code', PluginCode::HOORY->value)->first(),
                ]);
            });

            View::composer('partials.google_analytics', function ($view) {
                $view->with([
                    'analytics' => PluginConfiguration::where('code', PluginCode::GOOGLE_ANALYTICS->value)->first(),
                ]);
            });
        } catch (\Exception $exception){

        }

    }
}
