<?php

use App\Http\Controllers\Payment\PaymentController;
use App\Http\Controllers\User\CommissionsController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\IcoController;
use App\Http\Controllers\User\InvestmentController;
use App\Http\Controllers\User\MatrixController;
use App\Http\Controllers\User\PortfolioController;
use App\Http\Controllers\User\RechargeController;
use App\Http\Controllers\User\ReferralController;
use App\Http\Controllers\User\SecurityController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\StakingInvestmentController;
use App\Http\Controllers\User\SupportTicketController;
use App\Http\Controllers\User\TradeController;
use App\Http\Controllers\User\WalletController;
use App\Http\Controllers\User\WithdrawController;
use Illuminate\Support\Facades\Route;

Route::prefix('users/')->name('user.')->middleware(['auth','xss','security.headers', 'two-factor'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/settings', [HomeController::class, 'setting'])->name('setting');
    Route::get('/transactions',[HomeController::class, 'transactions'])->name('transaction');
    Route::get('/find',[HomeController::class, 'findUser'])->name('find.user');
    Route::get('/investment-rewards',[InvestmentController::class, 'investmentReward'])->name('reward');

    //Identity
    Route::get('/verify-identity', [HomeController::class, 'verifyIdentity'])->name('verify.identity');
    Route::post('/store-identity', [HomeController::class, 'storeIdentity'])->name('store.identity');

    //Referrals
    Route::prefix('referrals')->name('referral.')->group(function () {
        Route::get('', [ReferralController::class, 'index'])->name('index');
    });

    //Referrals
    Route::prefix('commissions')->name('commission.')->group(function () {
        Route::get('', [CommissionsController::class, 'index'])->name('index');
        Route::get('referral-rewards', [CommissionsController::class, 'rewards'])->name('rewards');
    });

    // Wallet
    Route::prefix('wallet-top-up')->name('wallet.')->group(function () {
        Route::get('', [WalletController::class, 'index'])->name('index');
        Route::post('own-account/transfer', [WalletController::class, 'transferWithinOwnAccount'])->name('transfer.own-account');
        Route::post('other-account/transfer', [WalletController::class, 'transferToOtherUser'])->name('transfer.other-account');
    });

    Route::group(['prefix' => 'trading', 'as' => 'trades.'], function () {
        Route::get('/', [TradeController::class, 'index'])->name('index');
        Route::get('/live', [TradeController::class, 'index'])->name('live');
        Route::get('/market', [TradeController::class, 'market'])->name('market');
        Route::get('/history', [TradeController::class, 'history'])->name('history');
        Route::post('/', [TradeController::class, 'store'])->name('store');
        Route::post('/{trade}/cancel', [TradeController::class, 'cancel'])->name('cancel');
    });

    //Investments
    Route::prefix('investments')->name('investment.')->group(function () {
        Route::get('', [InvestmentController::class, 'index'])->name('index');
        Route::get('funds', [InvestmentController::class, 'funds'])->name('funds');
        Route::get('profit-statistics', [InvestmentController::class, 'profitStatistics'])->name('profit.statistics');
        Route::post('store', [InvestmentController::class, 'store'])->name('store');
        Route::post('make/re-investment', [InvestmentController::class, 'makeReinvestment'])->name('make.re-investment');
        Route::post('cancel', [InvestmentController::class, 'cancel'])->name('cancel');
        Route::post('complete-profitable', [InvestmentController::class, 'completeInvestmentTransfer'])->name('complete.profitable');
    });

    // Staking
    Route::prefix('staking-investment')->name('staking-investment.')->group(function () {
        Route::get('', [StakingInvestmentController::class, 'index'])->name('index');
        Route::post('/store', [StakingInvestmentController::class, 'store'])->name('store');
    });

    // Matrix
    Route::prefix('matrix')->name('matrix.')->group(function () {
        Route::get('', [MatrixController::class, 'index'])->name('index');
        Route::post('enroll-matrix', [MatrixController::class, 'store'])->name('store');
    });

    //Withdraw
    Route::prefix('cash-out')->name('withdraw.')->group(function () {
        Route::get('/', [WithdrawController::class, 'index'])->name('index');
        Route::post('/process', [WithdrawController::class, 'process'])->name('process');
        Route::get('/preview/{uid}', [WithdrawController::class, 'preview'])->name('preview');
        Route::post('/make-success/{uid}', [WithdrawController::class, 'makeSuccess'])->name('success');
    });

    // Pin Recharge
    Route::prefix('insta-pin-recharge')->name('recharge.')->group(function () {
        Route::get('/', [RechargeController::class, 'index'])->name('index');
        Route::post('/save', [RechargeController::class, 'save'])->name('save');
        Route::post('/generate', [RechargeController::class, 'generate'])->name('generate');
    });

    //payment-process
    Route::prefix('payment/')->name('payment.')->group(function () {
        Route::get('deposits', [PaymentController::class, 'index'])->name('index');
        Route::get('deposits-commissions', [PaymentController::class, 'commission'])->name('commission');
        Route::post('process', [PaymentController::class, 'process'])->name('process');
        Route::get('success', [PaymentController::class, 'success'])->name('success');
        Route::get('cancel', [PaymentController::class, 'cancel'])->name('cancel');
        Route::get('preview', [PaymentController::class, 'preview'])->name('preview');
        Route::put('traditional', [PaymentController::class, 'traditional'])->name('traditional');
    });

    // Ico Tokens
    Route::prefix('ico-tokens')->name('ico.')->group(function () {
        Route::get('/', [IcoController::class, 'index'])->name('index');
        Route::post('/purchase', [IcoController::class, 'purchase'])->name('purchase');
        Route::get('/history', [IcoController::class, 'history'])->name('history');
        Route::post('/portfolio/sell', [PortfolioController::class, 'sell'])->name('portfolio.sell');
        Route::get('/portfolio', [PortfolioController::class, 'index'])->name('portfolio');
    });

    // Security routes
    Route::get('/login-history', [SecurityController::class, 'loginHistory'])->name('login.history');
    Route::get('/two-factor', [SecurityController::class, 'twoFactor'])->name('two.factor');
    Route::post('/two-factor/enable', [SecurityController::class, 'enableTwoFactor'])->name('two.factor.enable');
    Route::post('/two-factor/disable', [SecurityController::class, 'disableTwoFactor'])->name('two.factor.disable');
    Route::get('/change-password', [SecurityController::class, 'changePassword'])->name('change.password');
    Route::post('/update-password', [SecurityController::class, 'updatePassword'])->name('update.password');

    // KYC routes
    Route::get('/kyc', [SettingsController::class, 'kycIndex'])->name('kyc.index');
    Route::post('/kyc/submit', [SettingsController::class, 'submitKyc'])->name('kyc.submit');
    Route::post('/kyc/resubmit', [SettingsController::class, 'resubmitKyc'])->name('kyc.resubmit');


    Route::group(['prefix' => 'support-tickets', 'as' => 'support-tickets.'], function () {
        Route::get('/', [SupportTicketController::class, 'index'])->name('index');
        Route::get('/create', [SupportTicketController::class, 'create'])->name('create');
        Route::post('/', [SupportTicketController::class, 'store'])->name('store');
        Route::get('/{ticket}', [SupportTicketController::class, 'show'])->name('show');
        Route::post('/{ticket}/reply', [SupportTicketController::class, 'reply'])->name('reply');
        Route::get('/attachment/{attachment}/download', [SupportTicketController::class, 'downloadAttachment'])->name('attachment.download');
    });
});
