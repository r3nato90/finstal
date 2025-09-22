<div class="table-container">
    <table id="myTable" class="table">
        <thead>
        <tr>
            <th scope="col">{{ __('Rank') }}</th>
            <th scope="col">{{ __('Name') }}</th>
            <th scope="col">{{ __('Current Price') }}</th>
            <th scope="col">{{ __('24h Change') }}</th>
            <th scope="col">{{ __('Market Cap') }}</th>
            <th scope="col">{{ __('Total Volume') }}</th>
            <th scope="col">{{ __('Type') }}</th>
            <th scope="col">{{ __('Last Updated') }}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($currencyExchanges as $crypto)
            <tr>
                <td data-label="{{ __('Rank') }}">
                    <div class="rank">
                        <span class="badge bg-primary">#{{ $crypto->rank ?? 'N/A' }}</span>
                    </div>
                </td>
                <td data-label="{{ __('Name') }}">
                    <div class="our-currency-item">
                        <div class="name d-flex gap-2">
                            <div class="avatar--md">
                                <img src="{{ $crypto->image_url ?? '/default-crypto-icon.png' }}" alt="{{ __($crypto->name) }}">
                            </div>
                            <div class="content">
                                <h5>{{ __($crypto->name) }}</h5>
                                <span>{{ strtoupper($crypto->symbol) }} {{ __('Coin') }}</span>
                            </div>
                        </div>
                    </div>
                </td>
                <td data-label="{{ __('Current Price') }}">
                    <div class="amount">
                        <strong>{{ shortAmount($crypto->current_price, 8) }} {{ $crypto->base_currency ?? '$' }}</strong>
                        @if($crypto->previous_price)
                            <small class="d-block text-muted">
                                {{ __('Previous') }}: {{ shortAmount($crypto->previous_price, 8) }} {{ $crypto->base_currency ?? '$' }}
                            </small>
                        @endif
                    </div>
                </td>
                <td data-label="{{ __('24h Change') }}">
                    <div class="rate">
                        <p class="{{ $crypto->change_percent >= 0 ? 'text-success' : 'text-danger' }}">
                            <i class="fas fa-{{ $crypto->change_percent >= 0 ? 'arrow-up' : 'arrow-down' }}"></i>
                            {{ $crypto->change_percent >= 0 ? '+' : '' }}{{ shortAmount($crypto->change_percent, 2) }}%
                        </p>
                    </div>
                </td>
                <td data-label="{{ __('Market Cap') }}">
                    <div class="market_cap">
                        <p>{{ $crypto->market_cap ? '$' . shortAmount($crypto->market_cap) : 'N/A' }}</p>
                    </div>
                </td>
                <td data-label="{{ __('Total Volume') }}">
                    <div class="total_volume">
                        <p>{{ $crypto->total_volume ? '$' . shortAmount($crypto->total_volume) : 'N/A' }}</p>
                    </div>
                </td>
                <td data-label="{{ __('Type') }}">
                    <div class="type">
                        <span class="badge bg-info">{{ ucfirst($crypto->type ?? 'Unknown') }}</span>
                    </div>
                </td>
                <td data-label="{{ __('Last Updated') }}">
                    <div class="last_updated">
                        <small class="text-muted">
                            {{ $crypto->last_updated ? $crypto->last_updated->diffForHumans() : 'Never' }}
                        </small>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
