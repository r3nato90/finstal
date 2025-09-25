@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Trade Settings Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Symbols') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['totalSymbols']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Symbols') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['activeSymbols']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Trades') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['totalActiveTrades']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Volume') }}</h6>
                        <h4 class="text-dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalVolume']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.trade-settings.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Currency Symbol...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Active') }}</option>
                                    <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>{{ __('Inactive') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="payout_range">{{ __('Payout Range') }}</label>
                                <select name="payout_range" id="payout_range" class="form-control">
                                    <option value="">{{ __('All Ranges') }}</option>
                                    <option value="0-50" {{ ($filters['payout_range'] ?? '') == '0-50' ? 'selected' : '' }}>{{ __('0% - 50%') }}</option>
                                    <option value="51-75" {{ ($filters['payout_range'] ?? '') == '51-75' ? 'selected' : '' }}>{{ __('51% - 75%') }}</option>
                                    <option value="76-90" {{ ($filters['payout_range'] ?? '') == '76-90' ? 'selected' : '' }}>{{ __('76% - 90%') }}</option>
                                    <option value="91-100" {{ ($filters['payout_range'] ?? '') == '91-100' ? 'selected' : '' }}>{{ __('91%+') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="symbol" {{ ($filters['sort_field'] ?? '') == 'symbol' ? 'selected' : '' }}>{{ __('Symbol') }}</option>
                                    <option value="payout_rate" {{ ($filters['sort_field'] ?? '') == 'payout_rate' ? 'selected' : '' }}>{{ __('Payout Rate') }}</option>
                                    <option value="min_amount" {{ ($filters['sort_field'] ?? '') == 'min_amount' ? 'selected' : '' }}>{{ __('Min Amount') }}</option>
                                    <option value="max_amount" {{ ($filters['sort_field'] ?? '') == 'max_amount' ? 'selected' : '' }}>{{ __('Max Amount') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_direction">{{ __('Order') }}</label>
                                <select name="sort_direction" id="sort_direction" class="form-control">
                                    <option value="desc" {{ ($filters['sort_direction'] ?? 'desc') == 'desc' ? 'selected' : '' }}>{{ __('Descending') }}</option>
                                    <option value="asc" {{ ($filters['sort_direction'] ?? '') == 'asc' ? 'selected' : '' }}>{{ __('Ascending') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-1 mt-3">
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
                <h5 class="card-title mb-0">{{ __('Trade Settings') }}</h5>
                <div class="card-tools">
                    <a href="{{ route('admin.trade-settings.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa fa-plus"></i> {{ __('Add New Setting') }}
                    </a>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('Symbol') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Payout Rate') }}</th>
                        <th>{{ __('Amount Range') }}</th>
                        <th>{{ __('Durations') }}</th>
                        <th>{{ __('Trade Stats') }}</th>
                        <th>{{ __('Volume') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($tradeSettings as $setting)
                        <tr>
                            <td data-label="{{ __('Symbol') }}">
                                <span class="text-uppercase">{{ $setting->symbol }}</span>
                            </td>
                            <td data-label="{{ __('Currency') }}">
                                @if($setting->currency)
                                    <div class="currency-info">
                                       {{ $setting->currency->name ?? $setting->currency->symbol }}
                                        <br><small class="text-muted">{{ $setting->currency->type ?? 'N/A' }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('N/A') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($setting->is_active)
                                    <span class="badge badge--success">{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge--danger">{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Payout Rate') }}">
                                <strong>{{ shortAmount($setting->payout_rate, 2) }}%</strong>
                            </td>
                            <td data-label="{{ __('Amount Range') }}">
                                <div class="amount-range">
                                    <strong>{{ getCurrencySymbol() }}{{ shortAmount($setting->min_amount, 2) }}</strong>
                                    <br><small class="text-muted">to {{ getCurrencySymbol() }}{{ shortAmount($setting->max_amount, 2) }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Durations') }}">
                                @if($setting->formatted_durations)
                                    <div class="durations">
                                        @foreach(array_slice($setting->formatted_durations, 0, 3) as $duration)
                                            <span class="badge badge--primary badge--sm">{{ $duration }}</span>
                                        @endforeach
                                        @if(count($setting->formatted_durations) > 3)
                                            <small class="text-muted">+{{ count($setting->formatted_durations) - 3 }} more</small>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('N/A') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Trade Stats') }}">
                                <div class="trade-stats">
                                    <strong>{{ shortAmount($setting->trade_count) }}</strong> {{ __('Total') }}
                                    <br><small class="text-info">{{ shortAmount($setting->active_trades) }} {{ __('Active') }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Volume') }}">
                                <strong>{{ shortAmount($setting->total_volume) }}</strong>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <a href="{{ route('admin.trade-settings.edit', $setting->id) }}"
                                   class="badge badge--primary-transparent">
                                   edit
                                </a>

                                <a href="javascript:void(0)"
                                   data-id="{{ $setting->id }}"
                                   class="badge badge--danger-transparent tradeSettingDelete">{{ __('delete') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="9">{{ __('No trade settings found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($tradeSettings->hasPages())
                <div class="card-footer">
                    {{ $tradeSettings->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>


    <div class="modal fade" id="tradeDeleteModal" tabindex="-1" role="dialog" aria-labelledby="tradeDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Delete Trade Setting')</h5>
                </div>
                <form action="{{route('admin.trade-settings.destroy')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <p>@lang('Are you sure you want to delete this trade setting?')</p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn--danger btn--sm">@lang('Delete')</button>
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
            $(document).on('click', '.tradeSettingDelete', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#tradeDeleteModal');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });
        });
    </script>
@endpush
