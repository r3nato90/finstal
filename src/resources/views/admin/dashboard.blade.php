@extends('admin.layouts.main')
@section('panel')
    <div class="container-fluid px-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark mb-0">Dashboard</h3>
            <div class="d-flex gap-3">
                <button type="button" class="btn btn--primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    <i class="bi bi-gear"></i> Setup Instructions
                </button>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-xl-8 col-lg-7">
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-1 fw-medium">Total Payable</p>
                                        <h3 class="fw-bold text-dark mb-0">{{ getCurrencySymbol() }}{{ shortAmount($investment->payable) }}</h3>
                                        <small class="text-muted">{{ __('admin.dashboard.content.invest.payable_title', ['amount' => shortAmount($investment->payable)]) }}</small>
                                    </div>
                                    <div class="bg-warning bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-bell-fill text-warning fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <p class="text-muted mb-1 fw-medium">Total Investment</p>
                                        <h3 class="fw-bold text-dark mb-0">{{ getCurrencySymbol() }}{{ shortAmount($investment->total) }}</h3>
                                        <a href="{{ route('admin.investment.index') }}" class="btn btn-sm btn-outline-primary mt-2">
                                            View Details <i class="bi bi-arrow-right"></i>
                                        </a>
                                    </div>
                                    <div class="bg-primary bg-opacity-10 p-3 rounded-3">
                                        <i class="bi bi-graph-up text-primary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Investment Details -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="fw-bold mb-0">Investment Breakdown</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            @php
                                $investments = [
                                    'running' => ['Running Investment', 'success', 'bi-play-circle'],
                                    'profit' => ['Total Profit', 'info', 'bi-graph-up-arrow'],
                                    'closed' => ['Closed Investment', 'warning', 'bi-x-circle'],
                                    're_invest' => ['Re-Investment', 'primary', 'bi-arrow-repeat'],
                                ];
                            @endphp
                            @foreach($investments as $key => $details)
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center p-3 bg-light rounded-3">
                                        <div class="bg-{{ $details[1] }} bg-opacity-10 p-2 rounded-2 me-3">
                                            <i class="{{ $details[2] }} text--{{ $details[1] }} fs-5"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 small">{{ $details[0] }}</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount($investment->$key) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="row g-3 mb-4">
                    @foreach($cards as $card)
                        <div class="col-sm-6 col-lg-4">
                            <a href="{{ $card[4] }}" class="card border-0 shadow-sm text-decoration-none h-100 card-hover">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-{{ $card[3] }} bg-opacity-10 p-3 rounded-3 me-3">
                                            <i class="las la-{{ $card[2] }} text--{{ $card[3] }} fs-3"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-1 small">{{ $card[0] }}</p>
                                            <h5 class="fw-bold text-dark mb-0">{{ $card[1] }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Charts Row -->
                <div class="row g-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0">{{ __('admin.dashboard.content.deposit.title') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="bg-success bg-opacity-10 p-4 rounded-3 d-inline-block">
                                        <h4 class="fw-bold text--success mb-1">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'total')) }}</h4>
                                        <p class="text-muted mb-0">Total Deposits</p>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-info bg-opacity-10 rounded-3">
                                            <p class="text-info mb-1 small">Primary</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'primary.amount')) }}</h6>
                                            <small class="text--success">{{ shortAmount(getArrayFromValue($deposit, 'primary.percentage')) }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-primary bg-opacity-10 rounded-3">
                                            <p class="text-primary mb-1 small">Investment</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'investment.amount')) }}</h6>
                                            <small class="text--success">{{ shortAmount(getArrayFromValue($deposit, 'investment.percentage')) }}%</small>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-warning bg-opacity-10 rounded-3">
                                            <p class="text-warning mb-1 small">Trade</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount(getArrayFromValue($deposit, 'trade.amount')) }}</h6>
                                            <small class="text--success">{{ shortAmount(getArrayFromValue($deposit, 'trade.percentage')) }}%</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0">{{ __('admin.dashboard.content.withdraw.title') }}</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="bg-danger bg-opacity-10 p-4 rounded-3 d-inline-block">
                                        <h4 class="fw-bold text-danger mb-1">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->total) }}</h4>
                                        <p class="text-muted mb-0">Total Withdrawals</p>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-light rounded-3">
                                            <p class="text-muted mb-1 small">Pending</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->pending) }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-pink bg-opacity-10 rounded-3">
                                            <p class="text-white mb-1 small">Rejected</p>
                                            <h6 class="fw-bold mb-0 text-white">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->rejected) }}</h6>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="text-center p-3 bg-warning bg-opacity-10 rounded-3">
                                            <p class="text-dark mb-1 small">Charges</p>
                                            <h6 class="fw-bold mb-0">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->charge) }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Sections -->
                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0">{{ __('admin.dashboard.content.statistic.deposit') }}</h6>
                            </div>
                            <div class="card-body">
                                <div id="monthlyChart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-0 py-3">
                                <h6 class="fw-bold mb-0">{{ __('admin.report.statistics.investment.five') }}</h6>
                            </div>
                            <div class="card-body">
                                <div id="investProfitChart" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="col-xl-4 col-lg-5">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0">{{ __('admin.dashboard.content.statistic.transactions') }}</h6>
                    </div>
                    <div class="card-body">
                        @forelse($transactions as $transaction)
                            <div class="d-flex align-items-center mb-3">
                                <div class="bg-primary bg-opacity-10 p-2 rounded-2 me-3">
                                    <i class="bi bi-arrow-{{ \App\Enums\Transaction\Type::getTextColor($transaction->type) == 'success' ? 'down' : 'up' }}-right text-{{ \App\Enums\Transaction\Type::getTextColor($transaction->type) }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-medium">{{ $transaction->details }}</h6>
                                    <small class="text-muted">{{ showDateTime($transaction->created_at) }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0 text-{{ \App\Enums\Transaction\Type::getTextColor($transaction->type) }}">
                                        {{ getCurrencySymbol() }}{{ shortAmount($transaction->amount) }}
                                    </h6>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-inbox text-muted fs-2"></i>
                                <p class="text-muted mt-2">{{ __('No Data Found') }}</p>
                            </div>
                        @endforelse

                        @if(count($transactions) != 0)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.report.transactions') }}" class="btn btn-outline-primary btn-sm">
                                    {{ __('admin.button.view') }} All
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0">{{ __('admin.dashboard.content.statistic.trade') }}</h6>
                    </div>
                    <div class="card-body">
                        @forelse($tradeActivity as $key => $trade)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $trade?->setting->currency?->image_url }}" alt="{{ $trade?->setting?->currency->name }}" class="rounded-circle me-3" style="width: 40px; height: 40px;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1 fw-medium">{{ __($trade?->setting?->currency->name) }}</h6>
                                    <small class="text-muted">{{ __(strtoupper( $trade?->setting?->currency->name)) }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">{{ shortAmount($trade->open_price)  }} {{  $trade?->setting?->currency->base_currency }}</h6>
                                    <small class="text-success">{{ getCurrencySymbol() }}{{ shortAmount($trade->amount) }}</small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-graph-up text-muted fs-2"></i>
                                <p class="text-muted mt-2">{{ __('No Data Found') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Crypto Currencies -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white border-0 py-3">
                        <h6 class="fw-bold mb-0">Crypto Prices</h6>
                    </div>
                    <div class="card-body">
                        @foreach($cryptoCurrencies as $crypto)
                            <div class="d-flex align-items-center mb-3">
                                <img src="{{ $crypto->image_url }}" class="rounded-circle me-3" alt="{{ __($crypto->name) }}" style="width: 32px; height: 32px;">
                                <div class="flex-grow-1">
                                    <h6 class="mb-0 fw-medium">{{ __($crypto->name) }}</h6>
                                    <small class="text-muted">{{ __(strtoupper($crypto->symbol)) }}</small>
                                </div>
                                <div class="text-end">
                                    <h6 class="mb-0">{{ shortAmount($crypto->current_price) }} {{ $crypto->base_currency }}</h6>
                                    @if($crypto->change_percent !== null)
                                        <span class="badge {{ $crypto->change_percent >= 0 ? 'badge--success' : 'badge--danger' }}">
                                        {{ getAmount($crypto->change_percent, 2) }}%
                                    </span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Setup Instructions Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="exampleModalLabel">{{ __('Setup Instructions') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info border-0">
                        <i class="bi bi-info-circle me-2"></i>
                        {{ __('To ensure your application runs smoothly, make sure you have the necessary settings configured') }}:
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border border-primary border-opacity-25">
                                <div class="card-body">
                                    <h6 class="fw-bold text-primary mb-3">{{ __('Application Settings') }}</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.investment.setting.index') }}" class="text-decoration-none">
                                                {{ __('Investment Setting') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.matrix.index') }}" class="text-decoration-none">
                                                {{ __('Matrix Parameters') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.binary.holiday-setting.index') }}" class="text-decoration-none">
                                                {{ __('Investment Holiday Setting') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.binary.referral.index') }}" class="text-decoration-none">
                                                {{ __('Referral Setting') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('Appearance') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('Finance') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('General') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.automation') }}" class="text-decoration-none">
                                                {{ __('Automation') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('SEO') }}
                                            </a>
                                        </li>
                                        <li>
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('Security') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border border-info border-opacity-25">
                                <div class="card-body">
                                    <h6 class="fw-bold text-info mb-3">{{ __('Notifications Settings') }}</h6>
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.notifications.template') }}" class="text-decoration-none">
                                                {{ __('Notification Templates') }}
                                            </a>
                                        </li>
                                        <li class="mb-2">
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('Setup Mail Gateway') }}
                                            </a>
                                        </li>
                                        <li>
                                            <i class="bi bi-check-circle text-success me-2"></i>
                                            <a href="{{ route('admin.settings.index') }}" class="text-decoration-none">
                                                {{ __('Sms Gateways') }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-warning border-0 mt-4">
                        <h6 class="fw-bold">{{ __('Complete Application Settings') }}:</h6>
                        <p class="mb-0">{{ __('Ensure all other application settings are properly configured before running your site') }}.</p>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('Got it!') }}</button>
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

            // Monthly Chart
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
                    height: 300,
                    type: 'line',
                    toolbar: false,
                    zoom: {
                        enabled: false
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                colors: ['#0d6efd', '#dc3545'],
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: months,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return currency + val;
                        }
                    }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 3
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#monthlyChart"), options);
            chart.render();

            // Investment Profit Chart
            const invest = @json($invest);
            const profit = @json($profit);

            const investmentOptions = {
                series: [{
                    name: 'Profit',
                    data: profit
                }, {
                    name: 'Invest',
                    data: invest
                }],
                chart: {
                    height: 300,
                    type: 'line',
                    toolbar: false,
                    zoom: {
                        enabled: false
                    }
                },
                colors: ['#198754', '#0d6efd'],
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    categories: months,
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                grid: {
                    borderColor: '#f1f1f1',
                    strokeDashArray: 3
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return currency + val
                        }
                    }
                }
            };

            const investmentProfit = new ApexCharts(document.querySelector("#investProfitChart"), investmentOptions);
            investmentProfit.render();
        });
    </script>

    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .bg-pink {
            background-color: #e91e63;
        }
        .bg-pink-light {
            background-color: rgba(233, 30, 99, 0.1);
        }
        .text-pink {
            color: #e91e63;
        }
    </style>
@endpush
