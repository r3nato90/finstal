@php use App\Enums\Transaction\Type; use App\Enums\Transaction\WalletType; use App\Enums\Transaction\Source; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Transaction Logs Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Transactions') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalTransactions']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Credit') }}</h6>
                        <h4 class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalCredit']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Debit') }}</h6>
                        <h4 class="text--danger">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalDebit']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Charge') }}</h6>
                        <h4 class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalCharge']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Today Transactions') }}</h6>
                        <h3 class="text--info">{{ shortAmount($stats['todayTransactions']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.report.transactions') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('TRX, User, Details...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type">{{ __('Transaction Type') }}</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="1" {{ ($filters['type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Add Balance') }}</option>
                                    <option value="2" {{ ($filters['type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Subtract Balance') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="wallet_type">{{ __('Wallet Type') }}</label>
                                <select name="wallet_type" id="wallet_type" class="form-control">
                                    <option value="">{{ __('All Wallets') }}</option>
                                    <option value="1" {{ ($filters['wallet_type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Primary Balance') }}</option>
                                    <option value="2" {{ ($filters['wallet_type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Investment Balance') }}</option>
                                    <option value="3" {{ ($filters['wallet_type'] ?? '') == '3' ? 'selected' : '' }}>{{ __('Trade Balance') }}</option>
                                    <option value="4" {{ ($filters['wallet_type'] ?? '') == '4' ? 'selected' : '' }}>{{ __('Practice Balance') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="source">{{ __('Source') }}</label>
                                <select name="source" id="source" class="form-control">
                                    <option value="">{{ __('All Sources') }}</option>
                                    <option value="1" {{ ($filters['source'] ?? '') == '1' ? 'selected' : '' }}>{{ __('All') }}</option>
                                    <option value="2" {{ ($filters['source'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Matrix') }}</option>
                                    <option value="3" {{ ($filters['source'] ?? '') == '3' ? 'selected' : '' }}>{{ __('Investment') }}</option>
                                    <option value="4" {{ ($filters['source'] ?? '') == '4' ? 'selected' : '' }}>{{ __('Trade') }}</option>
                                    <option value="5" {{ ($filters['source'] ?? '') == '5' ? 'selected' : '' }}>{{ __('ICO') }}</option>
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
                                    <option value="type" {{ ($filters['sort_field'] ?? '') == 'type' ? 'selected' : '' }}>{{ __('Type') }}</option>
                                    <option value="wallet_type" {{ ($filters['sort_field'] ?? '') == 'wallet_type' ? 'selected' : '' }}>{{ __('Wallet Type') }}</option>
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
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Post Balance') }}</th>
                        <th>{{ __('Charge') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Wallet Type') }}</th>
                        <th>{{ __('Source') }}</th>
                        <th>{{ __('Details') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($transactionLogs as $transaction)
                        <tr>
                            <td data-label="{{ __('TRX') }}">
                                <strong>{{ $transaction->trx ?? 'N/A' }}</strong>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $transaction->user->fullname ?? 'Unknown' }}</strong>
                                    <br><small class="text-muted">{{ $transaction->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                @php
                                    $amountClass = $transaction->type == Type::PLUS->value ? 'text--success' : 'text--danger';
                                    $amountSign = $transaction->type == Type::PLUS->value ? '+' : '-';
                                @endphp
                                <strong class="{{ $amountClass }}">{{ $amountSign }}{{ getCurrencySymbol() }}{{ shortAmount($transaction->amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Post Balance') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($transaction->post_balance, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Charge') }}">
                                @if($transaction->charge > 0)
                                    <strong class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($transaction->charge, 2) }}</strong>
                                @else
                                    <span class="text-muted">{{ getCurrencySymbol() }}0.00</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Type') }}">
                                @php
                                    $typeClass = Type::getTextColor($transaction->type);
                                    $typeName = Type::getName($transaction->type);
                                @endphp
                                <span class="badge badge--{{ $typeClass }}">{{ $typeName }}</span>
                            </td>
                            <td data-label="{{ __('Wallet Type') }}">
                                @php
                                    $walletClass = WalletType::getColor($transaction->wallet_type);
                                    $walletName = WalletType::getName($transaction->wallet_type);
                                @endphp
                                <span class="badge {{ $walletClass }}">{{ $walletName }}</span>
                            </td>
                            <td data-label="{{ __('Source') }}">
                                @php
                                    $sourceClass = Source::getColor($transaction->source);
                                    $sourceName = Source::getName($transaction->source);
                                @endphp
                                <span class="badge {{ $sourceClass }}">{{ $sourceName }}</span>
                            </td>
                            <td data-label="{{ __('Details') }}">
                                <span class="text-muted">{{ Str::limit($transaction->details ?? 'N/A', 30) }}</span>
                            </td>
                            <td data-label="{{ __('Date') }}">
                                <div class="time-info">
                                    <strong>{{ $transaction->created_at->format('M d, H:i') }}</strong>
                                    <br><small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="10">{{ __('No transaction logs found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($transactionLogs->hasPages())
                <div class="card-footer">
                    {{ $transactionLogs->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
