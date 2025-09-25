@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>

                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Asset') }}</th>
                                <th scope="col">{{ __('Price') }}</th>
                                <th scope="col">{{ __('24h Change') }}</th>
                                <th scope="col">{{ __('Type') }}</th>
                                <th scope="col">{{ __('Last Updated') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($currencies as $currency)
                                <tr>
                                    <td data-label="{{ __('Asset') }}">
                                        <div class="name d-flex align-items-center justify-content-md-start justify-content-end gap-lg-3 gap-2">
                                            <div class="icon">
                                                @if($currency['image_url'])
                                                    <img src="{{ $currency['image_url'] }}" class="avatar--sm" alt="{{ $currency['name'] }}" onerror="this.style.display='none'">
                                                @else
                                                    <div class="avatar--sm bg-primary text-white d-flex align-items-center justify-content-center rounded-circle">
                                                        {{ substr($currency['symbol'], 0, 2) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="content">
                                                <h6 class="fs-14 mb-0">{{ $currency['symbol'] }}</h6>
                                                <span class="fs-13 text--light">{{ $currency['name'] }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="{{ __('Price') }}">
                                        <span class="fw-bold">${{ number_format($currency['current_price'], 8) }}</span>
                                    </td>
                                    <td data-label="{{ __('24h Change') }}">
                                        @if($currency['change_percent'] !== null)
                                            <span class="i-badge {{ $currency['change_percent'] >= 0 ? 'badge--success' : 'badge--danger' }}">
                                                <i class="fas {{ $currency['change_percent'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                                                {{ $currency['change_percent'] >= 0 ? '+' : '' }}{{ number_format($currency['change_percent'], 2) }}%
                                            </span>
                                        @else
                                            <span class="text--muted">{{ __('No Data') }}</span>
                                        @endif
                                    </td>
                                    <td data-label="{{ __('Type') }}">
                                        <span class="i-badge badge--primary">{{ ucfirst($currency['type']) }}</span>
                                    </td>
                                    <td data-label="{{ __('Last Updated') }}">
                                        @if($currency['last_updated'])
                                            {{ \Carbon\Carbon::parse($currency['last_updated'])->diffForHumans() }}
                                        @else
                                            {{ __('Not Available') }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-white">{{ $currencies->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
