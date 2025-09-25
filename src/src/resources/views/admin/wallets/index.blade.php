@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('User Wallets') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Wallets') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['total_wallets']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Primary Balance') }}</h6>
                        <h4 class="text-dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['total_primary_balance']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Investment Balance') }}</h6>
                        <h4 class="text-dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['total_investment_balance']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Trade Balance') }}</h6>
                        <h4 class="text-dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['total_trade_balance']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.wallets.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('User Name, Email...') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="balance_type">{{ __('Balance Type') }}</label>
                                <select name="balance_type" id="balance_type" class="form-control">
                                    <option value="">{{ __('All Balances') }}</option>
                                    <option value="primary_balance" {{ ($filters['balance_type'] ?? '') == 'primary_balance' ? 'selected' : '' }}>{{ __('Primary Balance') }}</option>
                                    <option value="investment_balance" {{ ($filters['balance_type'] ?? '') == 'investment_balance' ? 'selected' : '' }}>{{ __('Investment Balance') }}</option>
                                    <option value="trade_balance" {{ ($filters['balance_type'] ?? '') == 'trade_balance' ? 'selected' : '' }}>{{ __('Trade Balance') }}</option>
                                    <option value="practice_balance" {{ ($filters['balance_type'] ?? '') == 'practice_balance' ? 'selected' : '' }}>{{ __('Practice Balance') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from">{{ __('Date From') }}</label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                       value="{{ $filters['date_from'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to">{{ __('Date To') }}</label>
                                <input type="date" name="date_to" id="date_to" class="form-control"
                                       value="{{ $filters['date_to'] ?? '' }}">
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
                <h5 class="card-title mb-0">{{ __('Wallet List') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing {{ $wallets->firstItem() ?? 0 }} to {{ $wallets->lastItem() ?? 0 }}
                        of {{ $wallets->total() ?? 0 }} wallets
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Primary Balance') }}</th>
                        <th>{{ __('Investment Balance') }}</th>
                        <th>{{ __('Trade Balance') }}</th>
                        <th>{{ __('Practice Balance') }}</th>
                        <th>{{ __('Total Balance') }}</th>
                        <th>{{ __('Created') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($wallets as $wallet)
                        <tr>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <h6 class="mb-1">{{ $wallet->user->fullname ?? 'N/A' }}</h6>
                                    <small class="text-muted">{{ $wallet->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Primary Balance') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($wallet->primary_balance) }}
                            </td>
                            <td data-label="{{ __('Investment Balance') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($wallet->investment_balance) }}
                            </td>
                            <td data-label="{{ __('Trade Balance') }}">
                                {{ getCurrencySymbol() }}{{ shortAmount($wallet->trade_balance) }}
                            </td>
                            <td data-label="{{ __('Practice Balance') }}">
                                <strong class="{{ $wallet->practice_balance > 0 ? 'text-info' : 'text-muted' }}">
                                    {{ getCurrencySymbol() }}{{ shortAmount($wallet->practice_balance) }}
                                </strong>
                            </td>
                            <td data-label="{{ __('Total Balance') }}">
                                <div class="amount-info">
                                    <strong class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($wallet->total_balance) }}</strong>
                                    <br>
                                    @if($wallet->hasBalance())
                                        <small class="badge badge--success">{{ __('Active') }}</small>
                                    @else
                                        <small class="badge badge--secondary">{{ __('Inactive') }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Created') }}">
                                {{ showDateTime($wallet->created_at, 'd M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="8">{{ __('No wallets found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($wallets->hasPages())
                <div class="card-footer">
                    {{ $wallets->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
