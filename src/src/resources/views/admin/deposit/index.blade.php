@php use App\Enums\Payment\Deposit\Status; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Deposit Logs Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Deposits') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalDeposits']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Initiated') }}</h6>
                        <h4 class="text--primary">{{ shortAmount($stats['initiatedDeposits']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Pending') }}</h6>
                        <h4 class="text--info">{{ shortAmount($stats['pendingDeposits']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Success') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['successDeposits']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Cancelled') }}</h6>
                        <h4 class="text--danger">{{ shortAmount($stats['cancelledDeposits']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Deposit Amount') }}</h6>
                        <h3 class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalDepositAmount']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Charges') }}</h6>
                        <h3 class="text--info">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalCharges']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Net Credit Amount') }}</h6>
                        <h3 class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalFinalAmount']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.deposit.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('TRX, User, Amount...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gateway">{{ __('Payment Gateway') }}</label>
                                <select name="gateway" id="gateway" class="form-control">
                                    <option value="">{{ __('All Gateways') }}</option>
                                    @foreach($gateways as $gatewayId => $gatewayName)
                                        <option value="{{ $gatewayId }}" {{ ($filters['gateway'] ?? '') == $gatewayId ? 'selected' : '' }}>
                                            {{ $gatewayName }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Initiated') }}</option>
                                    <option value="2" {{ ($filters['status'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="3" {{ ($filters['status'] ?? '') == '3' ? 'selected' : '' }}>{{ __('Success') }}</option>
                                    <option value="4" {{ ($filters['status'] ?? '') == '4' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="wallet_type">{{ __('Wallet Type') }}</label>
                                <select name="wallet_type" id="wallet_type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="1" {{ ($filters['wallet_type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Primary Wallet') }}</option>
                                    <option value="2" {{ ($filters['wallet_type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Investment Wallet') }}</option>
                                    <option value="3" {{ ($filters['wallet_type'] ?? '') == '3' ? 'selected' : '' }}>{{ __('Trade Wallet') }}</option>
                                    <option value="4" {{ ($filters['wallet_type'] ?? '') == '4' ? 'selected' : '' }}>{{ __('Practice Wallet') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="trx" {{ ($filters['sort_field'] ?? '') == 'trx' ? 'selected' : '' }}>{{ __('TRX') }}</option>
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
            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('TRX') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Gateway') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Charge') }}</th>
                        <th>{{ __('Final Amount') }}</th>
                        <th>{{ __('Net Credit') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($deposits as $deposit)
                        <tr>
                            <td data-label="{{ __('TRX') }}">
                                <strong>{{ $deposit->trx }}</strong>
                                @if($deposit->is_crypto_payment)
                                    <br><span class="badge badge--info-transparent">Crypto</span>
                                @endif
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $deposit->user->fullname ?? 'Unknown' }}</strong>
                                    <br><small class="text-muted">{{ $deposit->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Gateway') }}">
                                <strong>{{ $deposit->gateway->name ?? 'N/A' }}</strong>
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($deposit->amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Charge') }}">
                                <span class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($deposit->charge, 2) }}</span>
                            </td>
                            <td data-label="{{ __('Final Amount') }}">
                                <strong class="text--info">{{ shortAmount($deposit->final_amount * $deposit->rate, 2) }} {{ $deposit->currency ?? getCurrencyName() }}</strong>
                            </td>
                            <td data-label="{{ __('Net Credit') }}">
                                <strong class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($deposit->final_amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Currency') }}">
                                <span class="badge badge--primary">{{ strtoupper($deposit->currency ?? getCurrencyName()) }}</span>
                                @if($deposit->rate != 1)
                                    <br><small class="text-muted">Rate: {{ shortAmount($deposit->rate, 4) }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = Status::getColor($deposit->status);
                                    $statusText = Status::getName($deposit->status);
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($statusText) }}</span>
                                @if($deposit->wallet_type)
                                    <br><span class="mt-1 badge {{ \App\Enums\Transaction\WalletType::getColor($deposit->wallet_type) }}">
                                        {{ \App\Enums\Transaction\WalletType::getWalletName($deposit->wallet_type) }}
                                    </span>
                                @endif
                            </td>
                            <td data-label="{{ __('Date') }}">
                                <div class="time-info">
                                    <strong>{{ $deposit->created_at->format('M d, H:i') }}</strong>
                                    <br><small class="text-muted">{{ $deposit->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <a href="{{ route('admin.deposit.details', $deposit->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="11">{{ __('No deposit logs found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($deposits->hasPages())
                <div class="card-footer">
                    {{ $deposits->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
