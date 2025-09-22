@extends('layouts.user')

@section('content')
    <div class="main-content" data-simplebar>
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title">{{ $stats['total_trades'] ?? 0 }}</h4>
                            <p class="card-info__text">{{ __('Total Trades') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title text--success">{{ $stats['win_rate'] ?? 0 }}%</h4>
                            <p class="card-info__text">{{ __('Win Rate') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas {{ ($stats['total_profit'] ?? 0) >= 0 ? 'fa-arrow-up text--success' : 'fa-arrow-down text--danger' }}"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title {{ ($stats['total_profit'] ?? 0) >= 0 ? 'text--success' : 'text--danger' }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($stats['total_profit'] ?? 0, 2) }}
                            </h4>
                            <p class="card-info__text">{{ __('Total P&L') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title">{{ getCurrencySymbol() }}{{ shortAmount($stats['total_volume'] ?? 0, 2) }}</h4>
                            <p class="card-info__text">{{ __('Total Volume') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Filters') }}</h4>
                        <button class="i-btn btn--success btn--sm" onclick="location.reload()" title="{{ __('Refresh') }}">
                            <i class="fas fa-sync-alt"></i> {{ __('Refresh') }}
                        </button>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('user.trades.history') }}">
                            <div class="row g-3">
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('Search') }}</label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="{{ __('Trade ID, Symbol...') }}"
                                           value="{{ $filters['search'] ?? '' }}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('Symbol') }}</label>
                                    <select name="symbol" class="form-select">
                                        <option value="">{{ __('All Symbols') }}</option>
                                        @foreach($symbols as $symbol)
                                            <option value="{{ $symbol }}" {{ ($filters['symbol'] ?? '') == $symbol ? 'selected' : '' }}>
                                                {{ $symbol }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('Direction') }}</label>
                                    <select name="direction" class="form-select">
                                        <option value="">{{ __('All Directions') }}</option>
                                        <option value="up" {{ ($filters['direction'] ?? '') == 'up' ? 'selected' : '' }}>{{ __('Call') }}</option>
                                        <option value="down" {{ ($filters['direction'] ?? '') == 'down' ? 'selected' : '' }}>{{ __('Put') }}</option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('Status') }}</label>
                                    <select name="status" class="form-select">
                                        <option value="">{{ __('All Statuses') }}</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status }}" {{ ($filters['status'] ?? '') == $status ? 'selected' : '' }}>
                                                {{ ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('Start Date') }}</label>
                                    <input type="date" name="start_date" class="form-control"
                                           value="{{ $filters['start_date'] ?? '' }}">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label">{{ __('End Date') }}</label>
                                    <input type="date" name="end_date" class="form-control"
                                           value="{{ $filters['end_date'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="i-btn btn--primary btn--sm">
                                        <i class="fas fa-filter"></i> {{ __('Apply Filters') }}
                                    </button>
                                    <a href="{{ route('user.trades.history') }}" class="i-btn btn--dark btn--sm">
                                        <i class="fas fa-times"></i> {{ __('Clear') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="table-container">
                        <table id="tradesTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Trade ID') }}</th>
                                <th scope="col">{{ __('Symbol') }}</th>
                                <th scope="col">{{ __('Direction') }}</th>
                                <th scope="col">{{ __('Amount') }}</th>
                                <th scope="col">{{ __('Payout Rate') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('P&L') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($trades as $trade)
                                <tr>
                                    <td data-label="{{ __('Trade ID') }}">
                                        <span class="fs-13 fw-bold font-monospace">{{ $trade->trade_id }}</span>
                                    </td>
                                    <td data-label="{{ __('Symbol') }}">
                                        <span class="fw-bold">{{ $trade->symbol }}</span>
                                    </td>
                                    <td data-label="{{ __('Direction') }}">
                                        <span class="badge {{ $trade->direction === 'up' ? 'badge--success' : 'badge--danger' }}">
                                            <i class="fas {{ $trade->direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                            {{ $trade->direction === 'up' ? __('CALL') : __('PUT') }}
                                        </span>
                                    </td>
                                    <td data-label="{{ __('Amount') }}">
                                        <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($trade->amount) }}</span>
                                    </td>
                                    <td data-label="{{ __('Payout Rate') }}">
                                        <span class="text--success fw-bold">{{ $trade->payout_rate }}%</span>
                                    </td>
                                    <td data-label="{{ __('Status') }}">
                                        @php
                                            $statusClass = match($trade->status) {
                                                'won' => 'badge--success',
                                                'lost' => 'badge--danger',
                                                'active' => 'badge--primary',
                                                'cancelled' => 'badge--secondary',
                                                'expired' => 'badge--warning',
                                                default => 'badge--secondary'
                                            };
                                        @endphp
                                        <span class="i-badge {{ $statusClass }}">
                                            {{ ucfirst($trade->status) }}
                                        </span>
                                    </td>
                                    <td data-label="{{ __('P&L') }}">
                                        @php
                                            $profitLoss = $trade->profit_loss ?? 0;
                                            $textClass = $profitLoss > 0 ? 'text--success' : ($profitLoss < 0 ? 'text--danger' : 'text--muted');
                                            $prefix = $profitLoss > 0 ? '+' : '';
                                        @endphp
                                        <span class="fw-bold {{ $textClass }}">
                                            {{ $prefix }}{{ getCurrencySymbol() }}{{ shortAmount(abs($profitLoss)) }}
                                        </span>
                                    </td>
                                    <td data-label="{{ __('Date') }}">
                                        <div>{{ $trade->open_time->format('M d, Y') }}</div>
                                        <small class="text--muted">{{ $trade->open_time->format('H:i:s') }}</small>
                                    </td>
                                    <td data-label="{{ __('Action') }}">
                                        <div class="d-flex gap-2">
                                            <button class="i-btn btn--primary btn--sm view-trade-details"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tradeDetailsModal"
                                                    data-trade-id="{{ $trade->id }}"
                                                    data-trade-ref="{{ $trade->trade_id }}"
                                                    data-symbol="{{ $trade->symbol }}"
                                                    data-direction="{{ $trade->direction }}"
                                                    data-amount="{{ $trade->amount }}"
                                                    data-duration="{{ $trade->duration_seconds }}"
                                                    data-duration-formatted="{{ $trade->duration_formatted }}"
                                                    data-payout-rate="{{ $trade->payout_rate }}"
                                                    data-open-price="{{ $trade->open_price }}"
                                                    data-close-price="{{ $trade->close_price ?? '' }}"
                                                    data-status="{{ $trade->status }}"
                                                    data-profit-loss="{{ $trade->profit_loss ?? 0 }}"
                                                    data-open-time="{{ $trade->open_time->toISOString() }}"
                                                    data-close-time="{{ $trade->close_time ? $trade->close_time->toISOString() : '' }}"
                                                    data-expiry-time="{{ $trade->expiry_time ? $trade->expiry_time->toISOString() : '' }}"
                                                    title="{{ __('View Details') }}">
                                                <i class="fas fa-eye"></i> {{ __('Details') }}
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-chart-line fs-48 text--muted mb-3"></i>
                                            <h5 class="text--muted">{{ __('No Trades Found') }}</h5>
                                            <p class="text--light">{{ __('You haven\'t placed any trades yet') }}</p>
                                            <a href="{{ route('user.trades.index') }}" class="i-btn btn--primary btn--sm">
                                                <i class="fas fa-plus"></i> {{ __('Start Trading') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($trades->hasPages())
                        <div class="mt-4">
                            {{ $trades->appends(request()->query())->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Trade Details Modal -->
    <div class="modal fade" id="tradeDetailsModal" tabindex="-1" aria-labelledby="tradeDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tradeDetailsModalLabel">{{ __('Trade Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg--dark">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Trade ID') }}</p>
                                <h6 class="title-sm mb-0" id="modalTradeId">#</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Symbol') }}</p>
                                <h6 class="title-sm mb-0" id="modalSymbol">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Direction') }}</p>
                                <h6 class="title-sm mb-0" id="modalDirection">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Investment Amount') }}</p>
                                <h6 class="title-sm mb-0" id="modalAmount">{{ getCurrencySymbol() }}0.00</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Open Price') }}</p>
                                <h6 class="title-sm mb-0" id="modalOpenPrice">{{ getCurrencySymbol() }}0.00</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Close Price') }}</p>
                                <h6 class="title-sm mb-0" id="modalClosePrice">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Payout Rate') }}</p>
                                <h6 class="title-sm mb-0" id="modalPayoutRate">0%</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Duration') }}</p>
                                <h6 class="title-sm mb-0" id="modalDuration">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Open Time') }}</p>
                                <h6 class="title-sm mb-0" id="modalOpenTime">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Close Time') }}</p>
                                <h6 class="title-sm mb-0" id="modalCloseTime">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Status') }}</p>
                                <h6 class="title-sm mb-0" id="modalStatus">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1">{{ __('Profit/Loss') }}</p>
                                <h6 class="title-sm mb-0" id="modalProfitLoss">{{ getCurrencySymbol() }}0.00</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--danger btn--sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <div id="modalTradeActions">
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script-push')
        <script>
            "use strict";
            $(document).ready(function() {
                $('.view-trade-details').on('click', function() {
                    const button = $(this);

                    const tradeId = button.data('trade-id');
                    const tradeRef = button.data('trade-ref');
                    const symbol = button.data('symbol');
                    const direction = button.data('direction');
                    const amount = button.data('amount');
                    const duration = button.data('duration');
                    const durationFormatted = button.data('duration-formatted');
                    const payoutRate = button.data('payout-rate');
                    const openPrice = button.data('open-price');
                    const closePrice = button.data('close-price');
                    const status = button.data('status');
                    const profitLoss = button.data('profit-loss');
                    const openTime = button.data('open-time');
                    const closeTime = button.data('close-time');
                    const expiryTime = button.data('expiry-time');

                    $('#modalTradeId').text('#' + tradeRef);
                    $('#modalSymbol').text(symbol);

                    const directionBadge = direction === 'up'
                        ? '<span class="badge badge--success"><i class="fas fa-arrow-up"></i> {{ __("CALL") }}</span>'
                        : '<span class="badge badge--danger"><i class="fas fa-arrow-down"></i> {{ __("PUT") }}</span>';
                    $('#modalDirection').html(directionBadge);

                    $('#modalAmount').text('{{ getCurrencySymbol() }}' + parseFloat(amount).toFixed(2));
                    $('#modalOpenPrice').text('$' + parseFloat(openPrice).toFixed(8));
                    $('#modalClosePrice').text(closePrice ? '$' + parseFloat(closePrice).toFixed(8) : '{{ __("Not Available") }}');
                    $('#modalPayoutRate').text(payoutRate + '%');
                    $('#modalDuration').text(durationFormatted || formatDuration(duration));

                    if (openTime) {
                        const openDate = new Date(openTime);
                        $('#modalOpenTime').html('<div>' + openDate.toLocaleDateString() + '</div><small class="text--muted">' + openDate.toLocaleTimeString() + '</small>');
                    }

                    if (closeTime) {
                        const closeDate = new Date(closeTime);
                        $('#modalCloseTime').html('<div>' + closeDate.toLocaleDateString() + '</div><small class="text--muted">' + closeDate.toLocaleTimeString() + '</small>');
                    } else {
                        $('#modalCloseTime').text('{{ __("Not Available") }}');
                    }

                    const statusBadge = getStatusBadge(status);
                    $('#modalStatus').html(statusBadge);

                    const profitLossValue = parseFloat(profitLoss);
                    const profitLossClass = profitLossValue > 0 ? 'text--success' : (profitLossValue < 0 ? 'text--danger' : 'text--muted');
                    const profitLossPrefix = profitLossValue > 0 ? '+' : '';
                    $('#modalProfitLoss').html('<span class="' + profitLossClass + '">' + profitLossPrefix + '$' + Math.abs(profitLossValue).toFixed(2) + '</span>');

                    // Handle action buttons
                    $('#modalTradeActions').html('');
                    if (status === 'active') {
                        const openDate = new Date(openTime);
                        const timeSinceOpen = (Date.now() - openDate.getTime()) / 1000;

                        if (timeSinceOpen <= 30) {
                            $('#modalTradeActions').html(`
                                <form method="POST" action="{{ route('user.trades.cancel', '') }}/${tradeId}" style="display: inline;">
                                    @csrf
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('{{ __('Are you sure you want to cancel this trade?') }}')">
                                        <i class="fas fa-times"></i> {{ __('Cancel Trade') }}
                            </button>
                        </form>
`);
                        }
                    }
                });

                const hasActiveTrades = $('.badge--primary').length > 0;
                if (hasActiveTrades) {
                    setInterval(function() {
                        if (!document.hidden) {
                            location.reload();
                        }
                    }, 30000);
                }
            });

            function getStatusBadge(status) {
                const statusClasses = {
                    'won': 'badge--success',
                    'lost': 'badge--danger',
                    'active': 'badge--primary',
                    'cancelled': 'badge--secondary',
                    'expired': 'badge--warning'
                };

                const badgeClass = statusClasses[status] || 'badge--secondary';
                const statusText = status.charAt(0).toUpperCase() + status.slice(1);

                return `<span class="badge ${badgeClass}">${statusText}</span>`;
            }

            function formatDuration(seconds) {
                seconds = parseInt(seconds);
                if (seconds < 60) return seconds + 's';
                if (seconds < 3600) return Math.floor(seconds / 60) + 'm';
                return Math.floor(seconds / 3600) + 'h';
            }
        </script>
    @endpush
@endsection
