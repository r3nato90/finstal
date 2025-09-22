@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Trade Logs Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Trades') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalTrades']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Trades') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['activeTrades']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Won Trades') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['wonTrades']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Lost Trades') }}</h6>
                        <h4 class="text--danger">{{ shortAmount($stats['lostTrades']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Volume') }}</h6>
                        <h4 class="text--dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalVolume']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('P&L') }}</h6>
                        <h4 class="{{ $stats['totalProfitLoss'] >= 0 ? 'text--success' : 'text--danger' }}">
                            {{ getCurrencySymbol() }}{{ shortAmount($stats['totalProfitLoss'], 2) }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.trade-logs.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Trade ID or User...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="symbol">{{ __('Symbol') }}</label>
                                <select name="symbol" id="symbol" class="form-control">
                                    <option value="">{{ __('All Symbols') }}</option>
                                    @foreach($symbols as $sym)
                                        <option value="{{ $sym }}" {{ ($filters['symbol'] ?? '') == $sym ? 'selected' : '' }}>
                                            {{ strtoupper($sym) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="direction">{{ __('Direction') }}</label>
                                <select name="direction" id="direction" class="form-control">
                                    <option value="">{{ __('All Directions') }}</option>
                                    <option value="up" {{ ($filters['direction'] ?? '') == 'up' ? 'selected' : '' }}>{{ __('Up') }}</option>
                                    <option value="down" {{ ($filters['direction'] ?? '') == 'down' ? 'selected' : '' }}>{{ __('Down') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="active" {{ ($filters['status'] ?? '') == 'active' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="won" {{ ($filters['status'] ?? '') == 'won' ? 'selected' : '' }}>{{ __('Won') }}</option>
                                    <option value="lost" {{ ($filters['status'] ?? '') == 'lost' ? 'selected' : '' }}>{{ __('Lost') }}</option>
                                    <option value="draw" {{ ($filters['status'] ?? '') == 'draw' ? 'selected' : '' }}>{{ __('Draw') }}</option>
                                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                    <option value="expired" {{ ($filters['status'] ?? '') == 'expired' ? 'selected' : '' }}>{{ __('Expired') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="trade_id" {{ ($filters['sort_field'] ?? '') == 'trade_id' ? 'selected' : '' }}>{{ __('Trade ID') }}</option>
                                    <option value="symbol" {{ ($filters['sort_field'] ?? '') == 'symbol' ? 'selected' : '' }}>{{ __('Symbol') }}</option>
                                    <option value="amount" {{ ($filters['sort_field'] ?? '') == 'amount' ? 'selected' : '' }}>{{ __('Amount') }}</option>
                                    <option value="status" {{ ($filters['sort_field'] ?? '') == 'status' ? 'selected' : '' }}>{{ __('Status') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block">{{ __('Filter') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Trade Logs') }}</h5>
                <div class="card-tools">
                    <button type="button" class="btn btn--success btn-sm text-white" data-bs-toggle="modal" data-bs-target="#bulkActionModal">
                        <i class="fa fa-cogs"></i> {{ __('Bulk Actions') }}
                    </button>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>
                            <input type="checkbox" id="selectAll">
                        </th>
                        <th>{{ __('Trade ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Symbol') }}</th>
                        <th>{{ __('Direction') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Prices') }}</th>
                        <th>{{ __('Duration') }}</th>
                        <th>{{ __('P&L') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Time') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tradeLogs as $trade)
                        <tr>
                            <td>
                                <input type="checkbox" class="trade-checkbox" value="{{ $trade->id }}">
                            </td>
                            <td data-label="{{ __('Trade ID') }}">
                                <strong>{{ $trade->trade_id }}</strong>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $trade->user->fullname ?? 'Unknown' }}</strong>
                                    <br><small class="text-white">{{ $trade->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Symbol') }}">
                                <span class="text-uppercase fw-bold">{{ $trade->symbol }}</span>
                            </td>
                            <td data-label="{{ __('Direction') }}">
                                <span class="badge {{ $trade->direction == 'up' ? 'badge--success' : 'badge--danger' }}">
                                    {{ strtoupper($trade->direction) }}
                                </span>
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($trade->amount, 2) }}</strong>
                                <br><small class="text-muted">{{ shortAmount($trade->payout_rate, 2) }}%</small>
                            </td>
                            <td data-label="{{ __('Prices') }}">
                                <div class="price-info">
                                    <strong>Open: {{ getCurrencySymbol() }}{{ shortAmount($trade->open_price, 4) }}</strong>
                                    @if($trade->close_price)
                                        <br><small class="text-muted">Close: {{ getCurrencySymbol() }}{{ shortAmount($trade->close_price, 4) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Duration') }}">
                                <span class="badge badge--info-transparent">{{ $trade->duration_formatted }}</span>
                                @if($trade->status == 'active' && $trade->time_remaining)
                                    <br><small class="text-warning">{{ $trade->time_remaining }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('P&L') }}">
                                @if($trade->profit_loss != 0)
                                    <strong class="{{ $trade->profit_loss > 0 ? 'text--success' : 'text--danger' }}">
                                        {{ $trade->formatted_profit_loss }}
                                    </strong>
                                @else
                                    <span class="text-muted">{{ getCurrencySymbol() }}0.00</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = match($trade->status) {
                                        'active' => 'badge--primary',
                                        'won' => 'badge--success',
                                        'lost' => 'badge--danger',
                                        'draw' => 'badge--warning',
                                        'cancelled' => 'badge--secondary',
                                        'expired' => 'badge--dark',
                                        default => 'badge--secondary'
                                    };
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($trade->status) }}</span>
                            </td>
                            <td data-label="{{ __('Time') }}">
                                <div class="time-info">
                                    <strong>{{ $trade->open_time?->format('M d, H:i') ?? 'N/A' }}</strong>
                                    @if($trade->close_time)
                                        <br><small class="text-muted">{{ $trade->close_time->format('M d, H:i') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                @if(in_array($trade->status, ['active', 'expired']))
                                    <a href="javascript:void(0)"
                                       data-id="{{ $trade->id }}"
                                       class="badge badge--warning-transparent settleTradeBtn">
                                        settle
                                    </a>
                                    <a href="javascript:void(0)"
                                       data-id="{{ $trade->id }}"
                                       class="badge badge--danger-transparent cancelTradeBtn">
                                        cancel
                                    </a>
                                @else
                                    <span>N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="12">{{ __('No trade logs found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($tradeLogs->hasPages())
                <div class="card-footer">
                    {{ $tradeLogs->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>

    <div class="modal fade" id="settleTradeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Settle Trade')</h5>
                </div>
                <form action="" method="POST" id="settleTradeForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="close_price">{{ __('Close Price') }} <span class="text-danger">*</span></label>
                            <input type="number" name="close_price" id="close_price" step="0.00000001" min="0"
                                   class="form-control" placeholder="0.00000000" required>
                        </div>
                        <p class="text-muted small">@lang('Enter the closing price to settle this trade.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--success btn--sm">@lang('Settle Trade')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelTradeModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Cancel Trade')</h5>
                </div>
                <form action="" method="POST" id="cancelTradeForm">
                    @csrf
                    <div class="modal-body">
                        <p>@lang('Are you sure you want to cancel this trade? The invested amount will be refunded to the user.')</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger btn--sm">@lang('Cancel Trade')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="bulkActionModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Bulk Actions')</h5>
                </div>
                <form action="{{ route('admin.trade-logs.bulk-action') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="bulk_action">{{ __('Action') }} <span class="text-danger">*</span></label>
                            <select name="action" id="bulk_action" class="form-control" required>
                                <option value="">{{ __('Select Action') }}</option>
                                <option value="settle">{{ __('Settle Trades') }}</option>
                                <option value="cancel">{{ __('Cancel Trades') }}</option>
                            </select>
                        </div>
                        <div class="form-group" id="bulk_close_price_group" style="display: none;">
                            <label for="bulk_close_price">{{ __('Close Price') }} <span class="text-danger">*</span></label>
                            <input type="number" name="close_price" id="bulk_close_price" step="0.00000001" min="0"
                                   class="form-control" placeholder="0.00000000">
                        </div>
                        <input type="hidden" name="trade_ids" id="selected_trade_ids">
                        <p class="text-muted small">@lang('Selected trades: ') <span id="selected_count">0</span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--primary btn--sm">@lang('Execute Action')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $(document).on('click', '.settleTradeBtn', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#settleTradeModal');
                const form = $('#settleTradeForm');

                form.attr('action', "{{ route('admin.trade-logs.settle', ':id') }}".replace(':id', id));
                modal.modal('show');
            });

            $(document).on('click', '.cancelTradeBtn', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#cancelTradeModal');
                const form = $('#cancelTradeForm');

                form.attr('action', "{{ route('admin.trade-logs.cancel', ':id') }}".replace(':id', id));
                modal.modal('show');
            });

            $('#selectAll').on('change', function() {
                $('.trade-checkbox').prop('checked', this.checked);
                updateSelectedCount();
            });

            $(document).on('change', '.trade-checkbox', function() {
                updateSelectedCount();
                const totalCheckboxes = $('.trade-checkbox').length;
                const checkedCheckboxes = $('.trade-checkbox:checked').length;
                $('#selectAll').prop('checked', totalCheckboxes === checkedCheckboxes);
            });

            $('#bulk_action').on('change', function() {
                const action = $(this).val();
                const closePriceGroup = $('#bulk_close_price_group');
                const closePriceInput = $('#bulk_close_price');

                if (action === 'settle') {
                    closePriceGroup.show();
                    closePriceInput.prop('required', true);
                } else {
                    closePriceGroup.hide();
                    closePriceInput.prop('required', false);
                }
            });

            function updateSelectedCount() {
                const selectedIds = [];
                $('.trade-checkbox:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $('#selected_count').text(selectedIds.length);
                $('#selected_trade_ids').val(JSON.stringify(selectedIds));
            }

            $('#bulkActionModal form').on('submit', function(e) {
                const selectedCount = $('.trade-checkbox:checked').length;

                if (selectedCount === 0) {
                    e.preventDefault();
                    alert('{{ __("Please select at least one trade to perform bulk action.") }}');
                    return false;
                }
            });

            @if(request()->get('status') === 'active' || !request()->get('status'))
            setInterval(function() {
                if ($('.badge--primary:contains("ACTIVE")').length > 0) {
                    window.location.reload();
                }
            }, 30000);
            @endif
        });
    </script>
@endpush
