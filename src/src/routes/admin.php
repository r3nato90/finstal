<?php

use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepositController;
use App\Http\Controllers\Admin\FrontendController;
use App\Http\Controllers\Admin\Ico\IcoPurchaseController;
use App\Http\Controllers\Admin\Ico\IcoSaleController;
use App\Http\Controllers\Admin\Ico\TokenController;
use App\Http\Controllers\Admin\Investment\HolidayController;
use App\Http\Controllers\Admin\Investment\InvestmentController;
use App\Http\Controllers\Admin\Investment\InvestmentLogController;
use App\Http\Controllers\Admin\Investment\InvestmentSettingController;
use App\Http\Controllers\Admin\Investment\MatrixController;
use App\Http\Controllers\Admin\Investment\ReferralController;
use App\Http\Controllers\Admin\Investment\RewardController;
use App\Http\Controllers\Admin\Investment\Staking\StakingInvestmentController;
use App\Http\Controllers\Admin\Investment\TimetableController;
use App\Http\Controllers\Admin\KycVerificationController;
use App\Http\Controllers\Admin\ManualPaymentGatewayController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentGatewayController;
use App\Http\Controllers\Admin\PinGenerateController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\Trade\CryptoCurrencyController;
use App\Http\Controllers\Admin\Trade\TradeLogController;
use App\Http\Controllers\Admin\Trade\TradeSettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WalletController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\WithdrawMethodController;
use Illuminate\Support\Facades\Route;

Route::namespace('Admin')->prefix('admin')->name('admin.')->middleware(['security.headers', 'xss'])->group(function () {
    Route::namespace('Auth')->group(function () {
        Route::get('/', [LoginController::class, 'login'])->name('login');
        Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
        Route::get('/logout',  [LoginController::class, 'logout'])->name('logout');
    });

    Route::get('/two-factor/verify', [App\Http\Controllers\Admin\TwoFactorController::class, 'showVerify'])->name('two-factor.verify');
    Route::post('/two-factor/verify', [App\Http\Controllers\Admin\TwoFactorController::class, 'verify']);
    Route::post('/two-factor/recovery', [App\Http\Controllers\Admin\TwoFactorController::class, 'recovery'])->name('two-factor.recovery');

    Route::middleware(['admin', 'demo', 'admin-two-factor'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

        //Admin Profile
        Route::prefix('profile')->group(function () {
            Route::get('/', [DashboardController::class, 'profile'])->name('profile');
            Route::post('/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
            Route::get('/password', [DashboardController::class, 'password'])->name('password');
            Route::post('/password/update', [DashboardController::class, 'passwordUpdate'])->name('password.update');
            Route::get('/notifications/', [DashboardController::class, 'notifications'])->name('notification');
        });

        // Login Attempts Management
        Route::get('/login-attempts', [App\Http\Controllers\Admin\LoginAttemptController::class, 'index'])->name('login-attempts.index');
        Route::post('/login-attempts/clear-old', [App\Http\Controllers\Admin\LoginAttemptController::class, 'clearOld'])->name('login-attempts.clear-old');

        // Two Factor
        Route::get('/two-factor', [App\Http\Controllers\Admin\TwoFactorController::class, 'index'])->name('two-factor');
        Route::post('/two-factor/enable', [App\Http\Controllers\Admin\TwoFactorController::class, 'enable'])->name('two-factor.enable');
        Route::delete('/two-factor/disable', [App\Http\Controllers\Admin\TwoFactorController::class, 'disable'])->name('two-factor.disable');

        //Statistic - Reports
        Route::prefix('statistic-reports')->name('report.')->group(function () {
            Route::get('/transactions', [StatisticController::class, 'transactions'])->name('transactions');
            Route::get('/investments', [StatisticController::class, 'investment'])->name('investment');
            Route::get('/investments/{planId}/plans', [StatisticController::class, 'investmentLogsByPlan'])->name('investment.plans');
            Route::get('/trades/{cryptoId}/crypto-currencies', [StatisticController::class, 'tradeLogsByCrypto'])->name('trade.crypto');
            Route::get('/trades', [StatisticController::class, 'trade'])->name('trade');
            Route::get('/matrix', [StatisticController::class, 'matrix'])->name('matrix');
        });

        //User
        Route::prefix('users')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::put('/identity-update', [UserController::class, 'identityUpdate'])->name('identity.update');
            Route::put('/{uid}/update', [UserController::class, 'update'])->name('update');
            Route::get('/{id}/detail', [UserController::class, 'details'])->name('details');
            Route::put('/add-subtract/balance', [UserController::class, 'saveAddSubtractBalance'])->name('add-subtract.balance');
            Route::get('/login-users/{id}',[UserController::class, 'loginAsUser'])->name('login');
            Route::get('/investments/{id}',[UserController::class, 'investment'])->name('investment');
            Route::get('/trades/{id}',[UserController::class, 'trade'])->name('trade');
            Route::get('/matrix-enrolled/{id}',[UserController::class, 'matrix'])->name('matrix.enrolled');
            Route::get('/deposits/{id}',[UserController::class, 'deposit'])->name('deposit');
            Route::get('/withdraws/{id}',[UserController::class, 'withdraw'])->name('withdraw');
            Route::get('/level-commissions/{id}',[UserController::class, 'level'])->name('level');
            Route::get('/referral-commissions/{id}',[UserController::class, 'referral'])->name('referral');
            Route::get('/referral/tree-views/{id}',[UserController::class, 'referralTree'])->name('referral.tree');
            Route::get('/investment-network/statistics/{id}',[UserController::class, 'statistic'])->name('statistic');
            Route::get('/transactions/{id}',[UserController::class, 'transactions'])->name('transaction');
        });

        Route::prefix('kyc-verifications')->name('kyc-verifications.')->group(function () {
            Route::get('/', [KycVerificationController::class, 'index'])->name('index');
            Route::get('/{kycVerification}', [KycVerificationController::class, 'show'])->name('show');
            Route::put('/{kycVerification}/status', [KycVerificationController::class, 'updateStatus'])->name('update-status');
            Route::get('/{kycVerification}/download', [KycVerificationController::class, 'downloadAllDocuments'])->name('download');
        });

        Route::get('/wallets', [WalletController::class, 'index'])->name('wallets.index');

        //Ico
        Route::prefix('ico')->name('ico.')->group(function () {
            Route::prefix('tokens')->name('token.')->group(function () {
                Route::get('/', [TokenController::class, 'index'])->name('index');
                Route::get('/create', [TokenController::class, 'create'])->name('create');
                Route::get('/{id}/edit', [TokenController::class, 'edit'])->name('edit');
                Route::put('/{id}/update', [TokenController::class, 'update'])->name('update');
                Route::post('/store', [TokenController::class, 'store'])->name('store');
            });
        });

        // Purchases
        Route::get('/ico/purchases', [IcoPurchaseController::class, 'index'])->name('ico.purchase.index');
        Route::get('/ico/sales', [IcoSaleController::class, 'index'])->name('ico.sale.index');

        //Matrix
        Route::prefix('matrix')->name('matrix.')->group(function () {
            Route::get('/', [MatrixController::class, 'index'])->name('index');
            Route::get('/create', [MatrixController::class, 'create'])->name('create');
            Route::get('/{uid}/edit', [MatrixController::class, 'edit'])->name('edit');
            Route::post('/{uid}/update', [MatrixController::class, 'update'])->name('update');
            Route::post('/store', [MatrixController::class, 'store'])->name('store');
            Route::post('/parameters', [MatrixController::class, 'matrixParameters'])->name('parameters');
            Route::get('/enrolled', [MatrixController::class, 'matrixEnrol'])->name('enrol');
            Route::get('/level-commissions', [MatrixController::class, 'levelCommissions'])->name('level.commissions');
            Route::get('/referral-commissions', [MatrixController::class, 'referralCommissions'])->name('referral.commissions');
        });

        //Binary
        Route::prefix('investments')->name('binary.')->group(function () {
            Route::get('/plans', [InvestmentController::class, 'index'])->name('index');
            Route::get('/create', [InvestmentController::class, 'create'])->name('create');
            Route::get('/{uid}/edit', [InvestmentController::class, 'edit'])->name('edit');
            Route::post('/update', [InvestmentController::class, 'update'])->name('update');
            Route::post('/store', [InvestmentController::class, 'store'])->name('store');
            Route::get('/commissions', [InvestmentController::class, 'dailyCommissions'])->name('daily.commissions');
            Route::get('/details/{id}', [InvestmentController::class, 'details'])->name('details');

            //Referrals
            Route::prefix('referrals')->name('referral.')->group(function (){
                Route::get('/', [ReferralController::class, 'index'])->name('index');
                Route::post('/update', [ReferralController::class, 'update'])->name('update');
                Route::post('/setting', [ReferralController::class, 'setting'])->name('setting');
            });

            // Timetables
            Route::prefix('time-tables/')->name('timetable.')->group(function () {
                Route::get('/', [TimetableController::class, 'index'])->name('index');
                Route::post('/store', [TimetableController::class, 'store'])->name('store');
                Route::post('/update', [TimetableController::class, 'update'])->name('update');
            });

            // Holiday-settings
            Route::prefix('holiday-settings/')->name('holiday-setting.')->group(function () {
                Route::get('/', [HolidayController::class, 'index'])->name('index');
                Route::post('/store', [HolidayController::class, 'store'])->name('store');
                Route::post('/update', [HolidayController::class, 'update'])->name('update');
                Route::post('/setting', [HolidayController::class, 'setting'])->name('setting');
            });

            // Staking Investment
            Route::prefix('staking-plans/')->name('staking.plan.')->group(function () {
                Route::get('/', [StakingInvestmentController::class, 'index'])->name('index');
                Route::post('/store', [StakingInvestmentController::class, 'store'])->name('store');
                Route::post('/update', [StakingInvestmentController::class, 'update'])->name('update');
            });

            //Rewards
            Route::prefix('rewards/')->name('reward.')->group(function () {
                Route::get('/', [RewardController::class, 'index'])->name('index');
                Route::post('/store', [RewardController::class, 'store'])->name('store');
                Route::post('/update', [RewardController::class, 'update'])->name('update');
            });

            Route::get('/staking-investments', [StakingInvestmentController::class, 'investment'])->name('staking.investment');
        });


        Route::prefix('investment-logs')->name('investment.')->group(function () {
            Route::get('/', [InvestmentLogController::class, 'investment'])->name('index');
        });

        // Investment Setting
        Route::name('investment.setting.')->group(function () {
            Route::get('/investments-setting', [InvestmentSettingController::class, 'index'])->name('index');
            Route::post('/investments-setting/update', [InvestmentSettingController::class, 'update'])->name('update');
        });

        //Pin generate
        Route::prefix('pin-generate')->name('pin.')->group(function () {
            Route::get('/', [PinGenerateController::class, 'index'])->name('index');
            Route::post('/store', [PinGenerateController::class, 'store'])->name('store');
        });

        //Trade Logs
        Route::group(['prefix' => 'trade-logs', 'as' => 'trade-logs.'], function () {
            Route::get('/', [TradeLogController::class, 'index'])->name('index');
            Route::get('/{id}', [TradeLogController::class, 'show'])->name('show');
            Route::post('/{id}/settle', [TradeLogController::class, 'settle'])->name('settle');
            Route::post('/{id}/cancel', [TradeLogController::class, 'cancel'])->name('cancel');
            Route::post('/bulk-action', [TradeLogController::class, 'bulkAction'])->name('bulk-action');
        });

        // Trade Settings
        Route::prefix('trade-settings')->name('trade-settings.')->group(function () {
            Route::get('/', [TradeSettingsController::class, 'index'])->name('index');
            Route::get('/create', [TradeSettingsController::class, 'create'])->name('create');
            Route::post('/store', [TradeSettingsController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [TradeSettingsController::class, 'edit'])->name('edit');
            Route::put('/{id}', [TradeSettingsController::class, 'update'])->name('update');
            Route::post('/destroy', [TradeSettingsController::class, 'destroy'])->name('destroy');
        });

        //Crypto-currencies
        Route::prefix('crypto-currencies')->name('crypto-currencies.')->group(function () {
            Route::get('/', [CryptoCurrencyController::class, 'index'])->name('index');
            Route::post('/update', [CryptoCurrencyController::class, 'update'])->name('update');
        });

        //Deposits
        Route::prefix('deposits')->name('deposit.')->group(function () {
            Route::get('/',[DepositController::class, 'index'])->name('index');
            Route::get('/{trx}/details',[DepositController::class, 'details'])->name('details');
            Route::put('/update/{id}',[DepositController::class, 'update'])->name('update');
            Route::get('/commissions',[DepositController::class, 'commissions'])->name('commission');
            Route::get('/download/{fileName}',[DepositController::class, 'download'])->name('download');
        });

        //Payment Method
        Route::prefix('automatic-gateways')->name('payment.gateway.')->group(function () {
            Route::get('/',[PaymentGatewayController::class, 'index'])->name('index');
            Route::get('/edit/{id}',[PaymentGatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}',[PaymentGatewayController::class, 'update'])->name('update');
        });

        //Manual Payment Method
        Route::prefix('traditional-gateways')->name('manual.gateway.')->group(function () {
            Route::get('/', [ManualPaymentGatewayController::class, 'index'])->name('index');
            Route::get('/create', [ManualPaymentGatewayController::class, 'create'])->name('create');
            Route::post('/store', [ManualPaymentGatewayController::class, 'store'])->name('store');
            Route::get('edit/{id}', [ManualPaymentGatewayController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [ManualPaymentGatewayController::class, 'update'])->name('update');
        });

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::get('/settings/automation', [SettingsController::class, 'automation'])->name('settings.automation');
        Route::get('/settings/system-updates', [SettingsController::class, 'systemUpdate'])->name('settings.system-update');
        Route::post('/settings/system-migrate', [SettingsController::class, 'systemMigrate'])->name('settings.migrate');

        // Manage Withdraw
        Route::prefix('withdraws')->name('withdraw.')->group(function () {
            Route::get('/', [WithdrawController::class, 'index'])->name('index');
            Route::get('/{id}/details', [WithdrawController::class, 'details'])->name('details');
            Route::post('/{id}/update', [WithdrawController::class, 'update'])->name('update');
        });

        //Withdraw Method
        Route::prefix('withdraw-gateways')->name('withdraw.method.')->group(function () {
            Route::get('/', [WithdrawMethodController::class, 'index'])->name('index');
            Route::get('/create', [WithdrawMethodController::class, 'create'])->name('create');
            Route::get('/{id}/edit', [WithdrawMethodController::class, 'edit'])->name('edit');
            Route::post('/store', [WithdrawMethodController::class, 'store'])->name('store');
            Route::post('/update/{id}', [WithdrawMethodController::class, 'update'])->name('update');
        });

        //Email
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/', [NotificationController::class, 'index'])->name('index');
            Route::post('/save', [NotificationController::class, 'save'])->name('save');
            Route::get('/templates', [NotificationController::class, 'template'])->name('template');
            Route::get('/templates/edit/{id}', [NotificationController::class, 'edit'])->name('edit');
            Route::post('/templates/update/{id}', [NotificationController::class, 'update'])->name('update');
        });

        //Pages
        Route::prefix('pages')->name('pages.')->group(function () {
            //Menus
            Route::get('/', [MenuController::class, 'index'])->name('index');
            Route::post('/store', [MenuController::class, 'store'])->name('store');
            Route::post('/update', [MenuController::class, 'update'])->name('update');
            Route::post('/delete', [MenuController::class, 'delete'])->name('delete');
            Route::get('/{url}/sections', [MenuController::class, 'sectionSortable'])->name('section.sortable');
            Route::post('/{id}/sections/update', [MenuController::class, 'updateSection'])->name('section.update');
        });

        //Frontend Sections
        Route::prefix('frontend-sections')->name('frontend.section.')->group(function () {
            Route::get('{key}', [FrontendController::class, 'index'])->name('index');
            Route::post('/save/{key}', [FrontendController::class, 'save'])->name('save');
            Route::get('/contents/{key}/{id?}', [FrontendController::class, 'getContent'])->name('content');
            Route::post('/delete/', [FrontendController::class, 'delete'])->name('delete');
        });

        //Subscribers
        Route::prefix('subscribers')->name('subscriber.')->group(function () {
            Route::get('/', [SubscriberController::class, 'index'])->name('index');
            Route::get('/contacts', [SubscriberController::class, 'contacts'])->name('contact');
            Route::post('/send', [SubscriberController::class, 'send'])->name('send');
        });

        //Languages
        Route::controller('LanguageController')->prefix('languages')->name('language.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
            Route::post('/delete', 'delete')->name('delete');
            Route::post('/update', 'update')->name('update');
            Route::get('/edit/{id}', 'edit')->name('edit');
            Route::post('/import/{id}', 'import')->name('import');
            Route::post('/store/key/{id}', 'storeLanguageJsonFile')->name('store.key');
            Route::post('/delete/key/{id}', 'deleteLanguageJsonFile')->name('delete.key');
            Route::post('/update/key/{id}', 'updateLanguageJsonFile')->name('update.key');
        });
    });
});




