@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Crypto Currency Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Currencies') }}</h6>
                        <h4 class="text-dark">{{ getAmount($stats['totalCurrencies']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Currencies') }}</h6>
                        <h4 class="text-dark">{{ getAmount($stats['activeCurrencies']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Market Cap') }}</h6>
                        <h4 class="text-dark">${{ getAmount($stats['totalMarketCap']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Volume') }}</h6>
                        <h4 class="text-dark">${{ getAmount($stats['totalVolume']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.crypto-currencies.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Symbol or Name...') }}">
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
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="rank" {{ ($filters['sort_field'] ?? 'rank') == 'rank' ? 'selected' : '' }}>{{ __('Rank') }}</option>
                                    <option value="symbol" {{ ($filters['sort_field'] ?? '') == 'symbol' ? 'selected' : '' }}>{{ __('Symbol') }}</option>
                                    <option value="name" {{ ($filters['sort_field'] ?? '') == 'name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                                    <option value="current_price" {{ ($filters['sort_field'] ?? '') == 'current_price' ? 'selected' : '' }}>{{ __('Price') }}</option>
                                    <option value="market_cap" {{ ($filters['sort_field'] ?? '') == 'market_cap' ? 'selected' : '' }}>{{ __('Market Cap') }}</option>
                                    <option value="change_percent" {{ ($filters['sort_field'] ?? '') == 'change_percent' ? 'selected' : '' }}>{{ __('Change %') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_direction">{{ __('Order') }}</label>
                                <select name="sort_direction" id="sort_direction" class="form-control">
                                    <option value="asc" {{ ($filters['sort_direction'] ?? 'asc') == 'asc' ? 'selected' : '' }}>{{ __('Ascending') }}</option>
                                    <option value="desc" {{ ($filters['sort_direction'] ?? '') == 'desc' ? 'selected' : '' }}>{{ __('Descending') }}</option>
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
                <h5 class="card-title mb-0">{{ __('Crypto Currencies') }}</h5>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('Rank') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Symbol') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Change %') }}</th>
                        <th>{{ __('Market Cap') }}</th>
                        <th>{{ __('Volume') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($cryptoCurrencies as $crypto)
                        <tr>
                            <td data-label="{{ __('Rank') }}">
                                <strong>#{{ $crypto->rank ?: 'N/A' }}</strong>
                            </td>
                            <td data-label="{{ __('Currency') }}">
                                <div class="currency-info d-flex align-items-center">
                                    @if($crypto->image_url)
                                        <img src="{{ $crypto->image_url }}" alt="{{ $crypto->symbol }}"
                                             class="crypto-icon me-2" style="width: 24px; height: 24px;">
                                    @endif
                                    <div>
                                        <strong>{{ $crypto->name }}</strong>
                                        <br><small class="text-muted">{{ $crypto->type }}</small>
                                    </div>
                                </div>
                            </td>
                            <td data-label="{{ __('Symbol') }}">
                                <span class="text-uppercase fw-bold">{{ $crypto->symbol }}</span>
                            </td>
                            <td data-label="{{ __('Price') }}">
                                <strong>${{ getAmount($crypto->current_price, 8) }}</strong>
                                <br><small class="text-muted">{{ $crypto->base_currency }}</small>
                            </td>
                            <td data-label="{{ __('Change %') }}">
                                @if($crypto->change_percent !== null)
                                    <span class="badge {{ $crypto->change_percent >= 0 ? 'badge--success' : 'badge--danger' }}">
                                        {{ getAmount($crypto->change_percent, 2) }}%
                                    </span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Market Cap') }}">
                                <strong>${{ shortAmount($crypto->market_cap) }}</strong>
                            </td>
                            <td data-label="{{ __('Volume') }}">
                                <strong>${{ shortAmount($crypto->total_volume) }}</strong>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                <form method="POST" action="{{ route('admin.crypto-currencies.update') }}" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $crypto->id }}">
                                    <input type="hidden" name="status" value="{{ $crypto->status ? 0 : 1 }}">
                                    <button type="submit" class="badge {{ $crypto->status ? 'badge--success' : 'badge--danger' }} border-0">
                                        {{ $crypto->status ? __('Active') : __('Inactive') }}
                                    </button>
                                </form>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                @if($crypto->tradingview_symbol)
                                    <a href="https://tradingview.com/symbols/{{ $crypto->tradingview_symbol }}"
                                       target="_blank" class="badge badge--info-transparent">
                                        chart
                                    </a>
                                @endif
                                <span class="badge badge--primary-transparent">
                                    {{ $crypto->last_updated ? $crypto->last_updated->diffForHumans() : 'Never' }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="9">{{ __('No crypto currencies found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($cryptoCurrencies->hasPages())
                <div class="card-footer">
                    {{ $cryptoCurrencies->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
