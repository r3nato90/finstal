@php use App\Enums\Investment\Status; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('Investment Logs Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Investments') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalInvestments']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Profit Completed') }}</h6>
                        <h4 class="text--info">{{ shortAmount($stats['profitCompletedInvestments']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Completed') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['completedInvestments']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Invested') }}</h6>
                        <h4 class="text--dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalInvestedAmount']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted">{{ __('Total Profit Paid') }}</h6>
                        <h3 class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($stats['totalProfitPaid']) }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.investment.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('UID, TRX, User...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="plan">{{ __('Investment Plan') }}</label>
                                <select name="plan" id="plan" class="form-control">
                                    <option value="">{{ __('All Plans') }}</option>
                                    @foreach($plans as $planId => $planName)
                                        <option value="{{ $planId }}" {{ ($filters['plan'] ?? '') == $planId ? 'selected' : '' }}>
                                            {{ $planName }}
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
                                    <option value="2" {{ ($filters['status'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Profit Completed') }}</option>
                                    <option value="3" {{ ($filters['status'] ?? '') == '3' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="4" {{ ($filters['status'] ?? '') == '4' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="recapture_type">{{ __('Recapture Type') }}</label>
                                <select name="recapture_type" id="recapture_type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="1" {{ ($filters['recapture_type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Lifetime') }}</option>
                                    <option value="2" {{ ($filters['recapture_type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Repeat') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="uid" {{ ($filters['sort_field'] ?? '') == 'uid' ? 'selected' : '' }}>{{ __('UID') }}</option>
                                    <option value="plan_name" {{ ($filters['sort_field'] ?? '') == 'plan_name' ? 'selected' : '' }}>{{ __('Plan Name') }}</option>
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
                        <th>{{ __('Plan') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Interest Rate') }}</th>
                        <th>{{ __('Period') }}</th>
                        <th>{{ __('Profit') }}</th>
                        <th>{{ __('Should Pay') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Next Profit') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($investmentLogs as $investment)
                        <tr>
                            <td data-label="{{ __('UID') }}">
                                <strong>{{ $investment->uid }}</strong>
                                <br><small class="text-dark">TRX: {{ $investment->trx }}</small>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $investment->user->fullname ?? 'Unknown' }}</strong>
                                    <br><small class="text-muted">{{ $investment->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Plan') }}">
                                <strong>{{ $investment->plan_name ?? 'N/A' }}</strong>
                                @if($investment->time_table_name && $investment->hours)
                                    <br><small class="text-muted">{{ $investment->time_table_name }} ({{ $investment->hours }}h)</small>
                                @endif
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <strong>{{ getCurrencySymbol() }}{{ shortAmount($investment->amount, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Interest Rate') }}">
                                <span class="badge badge--info">{{ shortAmount($investment->interest_rate, 2) }}%</span>
                            </td>
                            <td data-label="{{ __('Period') }}">
                                @if($investment->period && $investment->time_table_name)
                                    <span class="badge badge--primary">{{ $investment->period }} {{ $investment->time_table_name }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                                @if($investment->return_duration_count > 0)
                                    <br><small class="text-muted">Returns: {{ $investment->return_duration_count }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('Profit') }}">
                                <strong class="text--success">{{ getCurrencySymbol() }}{{ shortAmount($investment->profit, 2) }}</strong>
                            </td>
                            <td data-label="{{ __('Should Pay') }}">
                                @if($investment->should_pay > 0)
                                    <strong class="text--warning">{{ getCurrencySymbol() }}{{ shortAmount($investment->should_pay, 2) }}</strong>
                                @else
                                    <span class="text-muted">{{ getCurrencySymbol() }}0.00</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @php
                                    $statusClass = Status::getColor($investment->status);
                                    $statusText = Status::getName($investment->status);
                                @endphp
                                <span class="badge {{ $statusClass }}">{{ strtoupper($statusText) }}</span>
                                @if($investment->is_reinvest)
                                    <br><span class="badge badge--warning-transparent">Reinvest</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Next Profit') }}">
                                @if($investment->status == 1 && $investment->profit_time)
                                    <div class="time-info">
                                        <strong>{{ $investment->profit_time->format('M d, H:i') }}</strong>
                                        <br><small class="text-muted">{{ $investment->profit_time->diffForHumans() }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Actions') }}">
                               <a href="{{ route('admin.binary.details', $investment->id) }}">Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="11">{{ __('No investment logs found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($investmentLogs->hasPages())
                <div class="card-footer">
                    {{ $investmentLogs->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

