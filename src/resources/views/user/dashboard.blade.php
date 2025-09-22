@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div id="tsparticles"></div>
        <div class="row">
            <div class="col-md-6">
                <div class="i-card-sm mb-4 p-3">
                    <label for="referral-url" class="form-label">Referral URL</label>
                    <div class="input-group">
                        <input type="text" id="referral-url" class="form-control reference-url" value="{{ route('register', ['ref' => \Illuminate\Support\Facades\Auth::user()->uuid]) }}" aria-label="Recipient's username" aria-describedby="reference-copy" readonly>
                        <span class="input-group-text bg--primary text-white" id="reference-copy">{{ __('Copy') }}<i class="las la-copy ms-2"></i></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="i-card-sm mb-4 p-3">
                    <label for="user-uid" class="form-label">UID</label>
                    <div class="input-group">
                        <input type="text" id="user-uid" class="form-control user-uid" value="{{ \Illuminate\Support\Facades\Auth::user()->uuid }}" aria-label="Recipient's username" aria-describedby="user-uid-copy" readonly>
                        <span class="input-group-text bg--primary text-white" id="user-uid-copy">{{ __('Copy') }}<i class="las la-copy ms-2"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="i-card-sm mb-4">
            <div class="row g-4">
                @if($investment_investment == 1)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title text--purple mb-4">{{ __('frontend.dashboard.investment.index') }}</h5>
                                <div class="avatar--lg bg--pink">
                                    <i class="bi bi-credit-card text-white"></i>
                                </div>
                            </div>

                            <div class="card-info text-center">
                                <ul class="user-card-list w-100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.total') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->total) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.investment.profit') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->profit) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold">{{ __('frontend.dashboard.investment.running') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($investmentReport->running) }}</span>
                                    </li>
                                </ul>
                                <a href="{{ route('user.investment.index') }}" class="btn--white">{{ __('frontend.dashboard.investment.now') }}<i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($investment_matrix == 1)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title text--blue mb-4">{{ __('frontend.dashboard.matrix.index') }}</h5>
                                <div class="avatar--lg bg--blue">
                                    <i class="bi bi-wallet text-white"></i>
                                </div>
                            </div>
                            <div class="card-info text-center">
                                <ul class="user-card-list mb-4 w -100">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.matrix.total') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(@$matrixInvest->referral_commissions + @$matrixInvest->level_commissions) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.matrix.referral') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(@$matrixInvest->referral_commissions) }}</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold">{{ __('frontend.dashboard.matrix.level') }}</span>
                                        <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(@$matrixInvest->level_commissions) }}</span>
                                    </li>
                                </ul>
                                <a href="{{ route('user.matrix.index') }}" class="btn--white">{{ __('frontend.dashboard.matrix.enrolled') }}<i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endif

                @if($investment_trade_prediction == 1)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                        <div class="i-card-sm card-style rounded-3">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="title mb-0 text--yellow">{{ __('frontend.dashboard.trade.index') }}</h5>
                                <div class="avatar--lg bg--yellow">
                                    <i class="bi bi-bar-chart text-white"></i>
                                </div>
                            </div>

                            <div class="card-info text-center">
                                <ul class="user-card-list w-100 mb-3">
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">{{ __('Total Trades') }}</span>
                                        <span class="fw-bold text--dark">{{ $tradeReport->total }}</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">{{ __('Win Rate') }}</span>
                                        <span class="fw-bold text--success">{{ $tradeReport->win_rate }}%</span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3 mb-2">
                                        <span class="fw-bold">{{ __('Net P&L') }}</span>
                                        <span class="fw-bold {{ $tradeReport->net_profit_loss >= 0 ? 'text--success' : 'text--danger' }}">
                                            {{ getCurrencySymbol() }}{{ shortAmount($tradeReport->net_profit_loss) }}
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center justify-content-between gap-3">
                                        <span class="fw-bold">{{ __('Active Trades') }}</span>
                                        <span class="fw-bold text--warning">{{ $tradeReport->active }}</span>
                                    </li>
                                </ul>
                                <a href="{{ route('user.trades.index') }}" class="btn--white">{{ __('Start Trading') }} <i class="bi bi-box-arrow-up-right ms-2"></i></a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($investment_trade_prediction == 1 && $todayTradeSummary->total_trades > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <div class="i-card-sm">
                        <h5 class="title mb-3">{{ __('Today\'s Trading Summary') }}</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1">{{ $todayTradeSummary->total_trades }}</h4>
                                    <small class="text-white">Total Trades</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 text--success">{{ $todayTradeSummary->won_trades }}</h4>
                                    <small class="text-white">Won</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 text--danger">{{ $todayTradeSummary->lost_trades }}</h4>
                                    <small class="text-white">Lost</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="text-center p-3 rounded">
                                    <h4 class="mb-1 {{ $todayTradeSummary->today_profit >= 0 ? 'text--success' : 'text--danger' }}">
                                        {{ getCurrencySymbol() }}{{ shortAmount($todayTradeSummary->today_profit) }}
                                    </h4>
                                    <small class="text-white">Today's P&L</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-xl-8">
                <div class="i-card-sm">
                    <h5 class="title mb-4">{{ __('frontend.dashboard.deposit_withdraw.monthly_report') }}</h5>
                    <div id="monthlyChart"></div>
                </div>
            </div>
            <div class="col-xl-4">
                <div class="i-card-sm">
                    <div class="row g-4">
                        <div class="col-xl-12 col-md-6">
                            <div class="i-card-sm style-border-blue blue border rounded-3">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="title danger mb-0">{{ __('frontend.dashboard.deposit.index') }}</h5>
                                    <div class="avatar--lg bg--blue">
                                        <i class="bi bi-wallet text-white"></i>
                                    </div>
                                </div>
                                <div class="card-info text-center">
                                    <ul class="user-card-list w -100">
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.deposit.total') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'total')) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.deposit.primary') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'primary.amount')) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.deposit.investment') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'investment.amount')) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3"><span class="fw-bold">{{ __('frontend.dashboard.deposit.trade') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'trade.amount')) }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12 col-md-6">
                            <div class="i-card-sm style-border-green green border rounded-3">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="title mb-0">{{ __('frontend.dashboard.withdraw.index') }}</h5>
                                    <div class="avatar--lg bg--green">
                                        <i class="bi bi-credit-card text-white"></i>
                                    </div>
                                </div>

                                <div class="card-info text-center">
                                    <ul class="user-card-list w-100">
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.withdraw.total') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->total) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.withdraw.charge') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->charge) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.withdraw.pending') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->pending) }}</span>
                                        </li>
                                        <li class="d-flex align-items-center justify-content-between gap-3 mb-2"><span class="fw-bold">{{ __('frontend.dashboard.withdraw.rejected') }}</span>
                                            <span class="fw-bold text--dark">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->rejected) }}</span>
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
        @if($investment_trade_prediction == 1)
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="i-card-sm">
                        <h5 class="title mb-4">{{ __('Trading Performance') }}</h5>
                        <div id="tradingChart"></div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Performance Metrics and Recent Trades -->
        @if($investment_trade_prediction == 1)
            <div class="row g-4 mb-4">
                <div class="col-lg-6">
                    <div class="i-card-sm">
                        <h5 class="title mb-4">{{ __('Performance Metrics') }}</h5>
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="metric-card p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">This Week</h6>
                                            <small class="text-white">{{ $performanceMetrics['week']['total_trades'] }} trades</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold {{ $performanceMetrics['week']['profit'] >= 0 ? 'text--success' : 'text--danger' }}">
                                                {{ getCurrencySymbol() }}{{ shortAmount($performanceMetrics['week']['profit']) }}
                                            </div>
                                            <small class="text-white">{{ $performanceMetrics['week']['win_rate'] }}% win rate</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="metric-card p-3 border rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">This Month</h6>
                                            <small class="text-white">{{ $performanceMetrics['month']['total_trades'] }} trades</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold {{ $performanceMetrics['month']['profit'] >= 0 ? 'text--success' : 'text--danger' }}">
                                                {{ getCurrencySymbol() }}{{ shortAmount($performanceMetrics['month']['profit']) }}
                                            </div>
                                            <small class="text-white">{{ $performanceMetrics['month']['win_rate'] }}% win rate</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="i-card-sm">
                        <h5 class="title mb-4">{{ __('Recent Trades') }}</h5>
                        <div class="recent-trades-list">
                            @forelse($recentTrades as $trade)
                                <div class="trade-item d-flex justify-content-between align-items-center p-3 border-bottom">
                                    <div class="trade-info">
                                        <div class="fw-bold text-white">{{ $trade->symbol }}</div>
                                        <small class="text-white">
                                            {{ ucfirst($trade->direction) }} • {{ $trade->created_at->format('M j, g:i A') }}
                                        </small>
                                    </div>
                                    <div class="trade-result text-end">
                                        <div class="fw-bold {{ $trade->profit_loss >= 0 ? 'text--success' : 'text--danger' }}">
                                            {{ getCurrencySymbol() }}{{ number_format(abs($trade->profit_loss), 2) }}
                                        </div>
                                        <small class="badge badge-sm
                                    @if($trade->status == 'won') bg-success
                                    @elseif($trade->status == 'lost') bg-danger
                                    @elseif($trade->status == 'active') bg-warning
                                    @else bg-secondary
                                    @endif
                                ">
                                            {{ ucfirst($trade->status) }}
                                        </small>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <p class="text-white">No recent trades found</p>
                                    <a href="{{ route('user.trades.index') }}" class="i-btn btn--primary btn--sm">Start Trading</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h5 class="title">{{ __('Commissions') }}</h5>
                            <a class="arrow--btn" href="{{ route('user.referral.index') }}">{{ __('Referral Program') }} <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="total-balance-wrapper">
                            <div class="total-balance">
                                <p>{{ __('Investment Commission') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($commissions, 'investment')) }}</h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p>{{ __('Referral Commission') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($commissions, 'referral'))  }}</h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p>{{ __('Level Commission') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($commissions, 'level')) }}</h4>
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
                            <h5 class="title">{{ __('Wallets') }}</h5>
                            <a class="arrow--btn" href="{{ route('user.wallet.index') }}">{{ __('Wallet Top Up') }} <i class="bi bi-arrow-right-short"></i></a>
                        </div>
                        <div class="total-balance-wrapper">
                            <div class="total-balance">
                                <p>{{ __('Primary Balance') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()?->wallet->primary_balance) }}</h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p>{{ __('Investment Balance') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()?->wallet->investment_balance) }}</h4>
                                </div>
                            </div>
                            <div class="total-balance">
                                <p>{{ __('Trade Balance') }}</p>
                                <div class="d-flex gap-2">
                                    <h4>{{ getCurrencySymbol() }}{{ shortAmount(Auth::user()?->wallet->trade_balance) }}</h4>
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
                        <h4 class="title">{{ __("Latest Transactions") }}</h4>
                    </div>
                    @include('user.partials.transaction', ['transactions' => $transactions, 'is_paginate' => false])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            const depositMonthAmount = @json($depositMonthAmount);
            const withdrawMonthAmount = @json($withdrawMonthAmount);
            const months = @json($months);
            const currency = "{{ getCurrencySymbol() }}";

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

            @if($investment_trade_prediction == 1)
            // Trading Performance Chart
            const tradeMonths = @json($tradeMonths);
            const tradeProfitData = @json($tradeProfitData);
            const tradeLossData = @json($tradeLossData);
            const tradeCountData = @json($tradeCountData);

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
            @endif

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
@endpush
