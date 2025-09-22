<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div id="tsparticles"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="i-card-sm mb-4 p-3">
                    <label for="referral-url" class="form-label">Referral URL</label>
                    <div class="input-group">
                        <input type="text" id="referral-url" class="form-control reference-url" value="<?php echo e(route('register', ['ref' => \Illuminate\Support\Facades\Auth::user()->uuid])); ?>" aria-label="Recipient's username" aria-describedby="reference-copy" readonly>
                        <span class="input-group-text bg--primary text-white" id="reference-copy"><?php echo e(__('Copy')); ?><i class="las la-copy ms-2"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="i-card-sm mb-4 p-3">
                    <label for="user-uid" class="form-label">UID</label>
                    <div class="input-group">
                        <input type="text" id="user-uid" class="form-control user-uid" value="<?php echo e(\Illuminate\Support\Facades\Auth::user()->uuid); ?>" aria-label="Recipient's username" aria-describedby="user-uid-copy" readonly>
                        <span class="input-group-text bg--primary text-white" id="user-uid-copy"><?php echo e(__('Copy')); ?><i class="las la-copy ms-2"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="i-card-sm mb-4">
            <div class="row g-4">
                <?php if($investment_investment == 1): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title text--purple mb-4"><?php echo e(__('frontend.dashboard.investment.index')); ?></h5>
                                <div class="avatar--lg bg--pink">
                                    <i class="bi bi-credit-card text-white"></i>
                                </div>
                            </div>

                            <div class="card-info text-center">
                                <ul class="user-card-list w-100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.investment.total')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentReport->total)); ?></span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.investment.profit')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentReport->profit)); ?></span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold"><?php echo e(__('frontend.dashboard.investment.running')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investmentReport->running)); ?></span>
                                    </li>
                                </ul>
                                <a href="<?php echo e(route('user.investment.index')); ?>" class="btn--white"><?php echo e(__('frontend.dashboard.investment.now')); ?><i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($investment_matrix == 1): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title text--blue mb-4"><?php echo e(__('frontend.dashboard.matrix.index')); ?></h5>
                                <div class="avatar--lg bg--blue">
                                    <i class="bi bi-wallet text-white"></i>
                                </div>
                            </div>
                            <div class="card-info text-center">
                                <ul class="user-card-list mb-4 w -100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.matrix.total')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(@$matrixInvest->referral_commissions + @$matrixInvest->level_commissions)); ?></span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.matrix.referral')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(@$matrixInvest->referral_commissions)); ?></span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold"><?php echo e(__('frontend.dashboard.matrix.level')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(@$matrixInvest->level_commissions)); ?></span>
                                    </li>
                                </ul>
                                <a href="<?php echo e(route('user.matrix.index')); ?>" class="btn--white"><?php echo e(__('frontend.dashboard.matrix.enrolled')); ?><i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if($investment_trade_prediction == 1): ?>
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title mb-0 text--yellow"><?php echo e(__('frontend.dashboard.trade.index')); ?></h5>
                                <div class="avatar--lg bg--yellow">
                                    <i class="bi bi-bar-chart text-white"></i>
                                </div>
                            </div>

                            <div class="card-info text-center">
                                <ul class="user-card-list w-100 mb-3">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold"><?php echo e(__('Total Trades')); ?></span>
                                        <span class="fw-bold text--dark"><?php echo e($tradeReport->total); ?></span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold"><?php echo e(__('Win Rate')); ?></span>
                                        <span class="fw-bold text--success"><?php echo e($tradeReport->win_rate); ?>%</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold"><?php echo e(__('Net P&L')); ?></span>
                                        <span class="fw-bold <?php echo e($tradeReport->net_profit_loss >= 0 ? 'text--success' : 'text--danger'); ?>">
                                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($tradeReport->net_profit_loss)); ?>

                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3">
                                        <span class="fw-bold"><?php echo e(__('Active Trades')); ?></span>
                                        <span class="fw-bold text--warning"><?php echo e($tradeReport->active); ?></span>
                                    </li>
                                </ul>
                                <a href="<?php echo e(route('user.trades.index')); ?>" class="btn--white"><?php echo e(__('Start Trading')); ?> <i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if($investment_trade_prediction == 1 && $todayTradeSummary->total_trades > 0): ?>
            <div class="row mb-4">
                <div class="col-12">
                    <div class="i-card-sm">
                        <h5 class="title mb-3"><?php echo e(__('Today\'s Trading Summary')); ?></h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1"><?php echo e($todayTradeSummary->total_trades); ?></h4>
                                    <small class="text-white">Total Trades</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 text--success"><?php echo e($todayTradeSummary->won_trades); ?></h4>
                                    <small class="text-white">Won</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 text--danger"><?php echo e($todayTradeSummary->lost_trades); ?></h4>
                                    <small class="text-white">Lost</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 <?php echo e($todayTradeSummary->today_profit >= 0 ? 'text--success' : 'text--danger'); ?>">
                                        <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($todayTradeSummary->today_profit)); ?>

                                    </h4>
                                    <small class="text-white">Today's P&L</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="i-card-sm">
                    <h5 class="title mb-4"><?php echo e(__('frontend.dashboard.deposit_withdraw.monthly_report')); ?></h5>
                    <div id="monthlyChart"></div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="i-card-sm">
                    <div class="row g-4">
                        <div class="col-xl-12 col-md-6">
                            <div class="i-card-sm style-border-blue blue border rounded-3">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="title danger mb-0"><?php echo e(__('frontend.dashboard.deposit.index')); ?></h5>
                                    <div class="avatar--lg bg--blue">
                                        <i class="bi bi-wallet text-white"></i>
                                    </div>
                                </div>
                                <div class="card-info text-center">
                                    <ul class="user-card-list w -100">
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.deposit.total')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($deposit, 'total'))); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.deposit.primary')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($deposit, 'primary.amount'))); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.deposit.investment')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($deposit, 'investment.amount'))); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold"><?php echo e(__('frontend.dashboard.deposit.trade')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($deposit, 'trade.amount'))); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6">
                            <div class="i-card-sm style-border-green green border rounded-3">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="title mb-0"><?php echo e(__('frontend.dashboard.withdraw.index')); ?></h5>
                                    <div class="avatar--lg bg--green">
                                        <i class="bi bi-credit-card text-white"></i>
                                    </div>
                                </div>

                                <div class="card-info text-center">
                                    <ul class="user-card-list w-100">
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.withdraw.total')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->total)); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.withdraw.charge')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->charge)); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.withdraw.pending')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->pending)); ?></span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold"><?php echo e(__('frontend.dashboard.withdraw.rejected')); ?></span>
                                            <span class="fw-bold text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->rejected)); ?></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Trading Performance Chart -->
        <?php if($investment_trade_prediction == 1): ?>
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="i-card-sm">
                        <h5 class="title mb-4"><?php echo e(__('Trading Performance')); ?></h5>
                        <div id="tradingChart"></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Performance Metrics and Recent Trades -->
        <?php if($investment_trade_prediction == 1): ?>
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="i-card-sm">
                        <h5 class="title mb-4"><?php echo e(__('Performance Metrics')); ?></h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="metric-card p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">This Week</h6>
                                            <small class="text-white"><?php echo e($performanceMetrics['week']['total_trades']); ?> trades</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold <?php echo e($performanceMetrics['week']['profit'] >= 0 ? 'text--success' : 'text--danger'); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($performanceMetrics['week']['profit'])); ?>

                                            </div>
                                            <small class="text-white"><?php echo e($performanceMetrics['week']['win_rate']); ?>% win rate</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="metric-card p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">This Month</h6>
                                            <small class="text-white"><?php echo e($performanceMetrics['month']['total_trades']); ?> trades</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold <?php echo e($performanceMetrics['month']['profit'] >= 0 ? 'text--success' : 'text--danger'); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($performanceMetrics['month']['profit'])); ?>

                                            </div>
                                            <small class="text-white"><?php echo e($performanceMetrics['month']['win_rate']); ?>% win rate</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="i-card-sm">
                        <h5 class="title mb-4"><?php echo e(__('Recent Trades')); ?></h5>
                        <div class="recent-trades-list">
                            <?php $__empty_1 = true; $__currentLoopData = $recentTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="trade-item d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <div class="trade-info">
                                        <div class="fw-bold text-white"><?php echo e($trade->symbol); ?></div>
                                        <small class="text-white">
                                            <?php echo e(ucfirst($trade->direction)); ?> • <?php echo e($trade->created_at->format('M j, g:i A')); ?>

                                        </small>
                                    </div>
                                    <div class="trade-result text-end">
                                        <div class="fw-bold <?php echo e($trade->profit_loss >= 0 ? 'text--success' : 'text--danger'); ?>">
                                            <?php echo e(getCurrencySymbol()); ?><?php echo e(number_format(abs($trade->profit_loss), 2)); ?>

                                        </div>
                                        <small class="badge badge-sm
                                    <?php if($trade->status == 'won'): ?> bg-success
                                    <?php elseif($trade->status == 'lost'): ?> bg-danger
                                    <?php elseif($trade->status == 'active'): ?> bg-warning
                                    <?php else: ?> bg-secondary
                                    <?php endif; ?>
                                ">
                                            <?php echo e(ucfirst($trade->status)); ?>

                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-4">
                                    <p class="text-white">No recent trades found</p>
                                    <a href="<?php echo e(route('user.trades.index')); ?>" class="i-btn btn--primary btn--sm">Start Trading</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="title"><?php echo e(__('Commissions')); ?></h5>
                            <a class="arrow--btn" href="<?php echo e(route('user.referral.index')); ?>"><?php echo e(__('Referral Program')); ?> <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="total-balance-wrapper">
                            <div class="total-balance">
                                <p><?php echo e(__('Investment Commission')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($commissions, 'investment'))); ?></h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p><?php echo e(__('Referral Commission')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($commissions, 'referral'))); ?></h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p><?php echo e(__('Level Commission')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(getArrayFromValue($commissions, 'level'))); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="title"><?php echo e(__('Wallets')); ?></h5>
                            <a class="arrow--btn" href="<?php echo e(route('user.wallet.index')); ?>"><?php echo e(__('Wallet Top Up')); ?> <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="total-balance-wrapper">
                            <div class="total-balance">
                                <p><?php echo e(__('Primary Balance')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(Auth::user()?->wallet->primary_balance)); ?></h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p><?php echo e(__('Investment Balance')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(Auth::user()?->wallet->investment_balance)); ?></h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p><?php echo e(__('Trade Balance')); ?></p>
                                <div class="d-flex gap-2">
                                    <h4><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(Auth::user()?->wallet->trade_balance)); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__("Latest Transactions")); ?></h4>
                    </div>
                    <?php echo $__env->make('user.partials.transaction', ['transactions' => $transactions, 'is_paginate' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            const depositMonthAmount = <?php echo json_encode($depositMonthAmount, 15, 512) ?>;
            const withdrawMonthAmount = <?php echo json_encode($withdrawMonthAmount, 15, 512) ?>;
            const months = <?php echo json_encode($months, 15, 512) ?>;
            const currency = "<?php echo e(getCurrencySymbol()); ?>";

            const options = {
                series: [
                    {
                        name: 'Total Deposits Amount',
                        data: depositMonthAmount
                    },
                    {
                        name: 'Total Withdraw Amount',
                        data: withdrawMonthAmount
                    }
                ],
                chart: {
                    height: 530,
                    type: 'line',
                    toolbar: false,
                    zoom: {
                        enabled: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        dataLabels: {
                            position: 'bottom',
                        },
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return '';
                    },
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                xaxis: {
                    categories: months,
                    position: 'top',
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    },
                    crosshairs: {
                        fill: {
                            type: 'gradient',
                            gradient: {
                                colorFrom: '#D8E3F0',
                                colorTo: '#BED1E6',
                                stops: [0, 100],
                                opacityFrom: 0.4,
                                opacityTo: 0.5,
                            }
                        }
                    },
                    tooltip: {
                        enabled: true,
                    },
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                yaxis: {
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false,
                    },
                    labels: {
                        show: false,
                        formatter: function (val) {
                            return currency + val;
                        },
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                title: {
                    floating: true,
                    offsetY: 340,
                    align: 'center',
                    style: {
                        color: '#222',
                        fontWeight: 600
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#monthlyChart"), options);
            chart.render();

            <?php if($investment_trade_prediction == 1): ?>
            // Trading Performance Chart
            const tradeMonths = <?php echo json_encode($tradeMonths, 15, 512) ?>;
            const tradeProfitData = <?php echo json_encode($tradeProfitData, 15, 512) ?>;
            const tradeLossData = <?php echo json_encode($tradeLossData, 15, 512) ?>;
            const tradeCountData = <?php echo json_encode($tradeCountData, 15, 512) ?>;

            const tradingOptions = {
                series: [
                    {
                        name: 'Profit',
                        type: 'column',
                        data: tradeProfitData
                    },
                    {
                        name: 'Loss',
                        type: 'column',
                        data: tradeLossData
                    },
                    {
                        name: 'Trade Count',
                        type: 'line',
                        data: tradeCountData
                    }
                ],
                chart: {
                    height: 400,
                    type: 'line',
                    toolbar: false,
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#28a745', '#dc3545', '#ffc107'],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: [0, 0, 4],
                    colors: ['transparent', 'transparent', '#ffc107']
                },
                xaxis: {
                    categories: tradeMonths,
                    labels: {
                        style: {
                            colors: '#ffffff'
                        }
                    }
                },
                yaxis: [
                    {
                        title: {
                            text: 'Profit/Loss (' + currency + ')',
                            style: {
                                color: '#ffffff'
                            }
                        },
                        labels: {
                            formatter: function (val) {
                                return currency + val.toFixed(0);
                            },
                            style: {
                                colors: '#ffffff'
                            }
                        }
                    },
                    {
                        opposite: true,
                        title: {
                            text: 'Trade Count',
                            style: {
                                color: '#ffffff'
                            }
                        },
                        labels: {
                            style: {
                                colors: '#ffffff'
                            }
                        }
                    }
                ],
                fill: {
                    opacity: [0.85, 0.85, 1]
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: [
                        {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return currency + y.toFixed(2);
                                }
                                return y;
                            }
                        },
                        {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return currency + y.toFixed(2);
                                }
                                return y;
                            }
                        },
                        {
                            formatter: function (y) {
                                if (typeof y !== "undefined") {
                                    return y + " trades";
                                }
                                return y;
                            }
                        }
                    ]
                }
            };

            const tradingChart = new ApexCharts(document.querySelector("#tradingChart"), tradingOptions);
            tradingChart.render();
            <?php endif; ?>

            // Copy functionality
            $('#reference-copy').click(function() {
                const copyText = $('.reference-url');
                copyText.select();
                document.execCommand('copy');
                copyText.blur();
                notify('success', 'Copied to clipboard!');
            });

            $('#user-uid-copy').click(function() {
                const copyTextUID = $('.user-uid');
                copyTextUID.select();
                document.execCommand('copy');
                copyTextUID.blur();
                notify('success', 'Copied to clipboard!');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/dashboard.blade.php ENDPATH**/ ?>