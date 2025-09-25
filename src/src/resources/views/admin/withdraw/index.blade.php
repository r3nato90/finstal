@php use App\Enums\Payment\Withdraw\Status; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Withdraw Logs Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Withdraws') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalWithdraws']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Initiated') }}</h6>
                        <h4 class="text--primary">{{ shortAmount($stats['initiatedWithdraws']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Pending') }}</h6>
                        <h4 class="text--info">{{ shortAmount($stats['pendingWithdraws']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Success') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['successWithdraws']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Cancelled') }}</h6>
                        <h4 class="text--danger">{{ shortAmount($stats['cancelledWithdraws']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Withdraw Amount') }}</h6>
                        <h3 class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalWithdrawAmount']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Charges') }}</h6>
                        <h3 class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalCharges']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Final Amount') }}</h6>
                        <h3 class="text--info">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalFinalAmount']) }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total After Charge') }}</h6>
                        <h3 class="text--primary">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalAfterCharge']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.withdraw.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('UID, TRX, User, Amount...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="method">{{ __('Withdraw Method') }}</label>
                                <select name="method" id="method" class="form-control">
                                    <option value="">{{ __('All Methods') }}</option>
                                    @foreach($withdrawMethods as $methodId => $methodName)
                                        <option value="{{ $methodId }}" {{ ($filters['method'] ?? '') == $methodId ? 'selected' : '' }}>
                                            {{ $methodName }}
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
                                <label for="currency">{{ __('Currency') }}</label>
                                <select name="currency" id="currency" class="form-control">
                                    <option value="">{{ __('All Currencies') }}</option>
                                    @foreach($currencies as $currencyCode => $currencyName)
                                        <option value="{{ $currencyCode }}" {{ ($filters['currency'] ?? '') == $currencyCode ? 'selected' : '' }}>
                                            {{ strtoupper($currencyName) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="uid" {{ ($filters['sort_field'] ?? '') == 'uid' ? 'selected' : '' }}>{{ __('UID') }}</option>
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
                        <th>{{ __('UID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Method') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Charge') }}</th>
                        <th>{{ __('Final Amount') }}</th>
                        <th>{{ __('After Charge') }}</th>
                        <th>{{ __('Currency') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($withdrawLogs as $withdraw)
                        <tr>
                            <td data-label="{{ __('UID') }}">
                                <strong>{{ $withdraw->uid }}</strong>
                                @if($withdraw->trx)
                                    <br><small class="text-muted">TRX: {{ $withdraw->trx }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $withdraw->user->fullname ?? 'Unknown' }}</strong>
                                    <br><small class="text-muted">{{ $withdraw->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Method') }}">
                                <strong>{{ $withdraw->withdrawMethod->name ?? 'N/A' }}</strong>
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($withdraw->amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Charge') }}">
                                <span class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($withdraw->charge, 2) }}</span>
                            </td>
                            <td data-label="{{ __('Final Amount') }}">
                                <strong class="text--info">{{ shortAmount($withdraw->final_amount, 2) }} {{ $withdraw->currency ?? getCurrencyName() }}</strong>
                            </td>
                            <td data-label="{{ __('After Charge') }}">
                                <strong class="text--success">{{ shortAmount($withdraw->after_charge, 2) }} {{ $withdraw->currency ?? getCurrencyName() }}</strong>
                            </td>
                            <td data-label="{{ __('Currency') }}">
                                <span class="badge badge--primary">{{ strtoupper($withdraw->currency ?? getCurrencyName()) }}</span>
                                @if($withdraw->rate != 1)
                                    <br><small class="text-muted">Rate: {{ shortAmount($withdraw->rate, 4) }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = Status::getColor($withdraw->status);
                                    $statusText = Status::getName($withdraw->status);
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($statusText) }}</span>
                            </td>
                            <td data-label="{{ __('Date') }}">
                                <div class="time-info">
                                    <strong>{{ $withdraw->created_at->format('M d, H:i') }}</strong>
                                    <br><small class="text-muted">{{ $withdraw->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <a href="{{ route('admin.withdraw.details', $withdraw->id) }}" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="11">{{ __('No withdraw logs found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($withdrawLogs->hasPages())
                <div class="card-footer">
                    {{ $withdrawLogs->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
