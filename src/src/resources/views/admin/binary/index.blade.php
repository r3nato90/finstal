@php use App\Enums\Investment\Status; @endphp
@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title">{{ __('Investment Plans Management') }}</h3>
                <a href="{{ route('admin.binary.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Create Plan') }}
                </a>
            </div>
        </div>

        <div class="row mb-4 mt-2">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Plans') }}</h6>
                        <h4 class="text--dark">{{ $stats['totalPlans'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Plans') }}</h6>
                        <h4 class="text--success">{{ $stats['activePlans'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Recommended Plans') }}</h6>
                        <h4 class="text--info">{{ $stats['recommendedPlans'] }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Investments') }}</h6>
                        <h4 class="text--primary">{{ $stats['totalInvestments'] }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.binary.index') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Name, UID...') }}">
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
                                <label for="type">{{ __('Type') }}</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="1" {{ ($filters['type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                    <option value="2" {{ ($filters['type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Flexible') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="interest_type">{{ __('Interest Type') }}</label>
                                <select name="interest_type" id="interest_type" class="form-control">
                                    <option value="">{{ __('All Types') }}</option>
                                    <option value="1" {{ ($filters['interest_type'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Percentage') }}</option>
                                    <option value="2" {{ ($filters['interest_type'] ?? '') == '2' ? 'selected' : '' }}>{{ __('Fixed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Created') }}</option>
                                    <option value="name" {{ ($filters['sort_field'] ?? '') == 'name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                                    <option value="interest_rate" {{ ($filters['sort_field'] ?? '') == 'interest_rate' ? 'selected' : '' }}>{{ __('Interest Rate') }}</option>
                                    <option value="minimum" {{ ($filters['sort_field'] ?? '') == 'minimum' ? 'selected' : '' }}>{{ __('Minimum Amount') }}</option>
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
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Amount Range') }}</th>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Interest Rate') }}</th>
                        <th>{{ __('Duration') }}</th>
                        <th>{{ __('Return Type') }}</th>
                        <th>{{ __('Total Investments') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($investmentPlans as $plan)
                        <tr>
                            <td data-label="{{ __('UID') }}">
                                <strong>{{ $plan->uid }}</strong>
                            </td>
                            <td data-label="{{ __('Name') }}">
                                <strong>{{ $plan->name }}</strong>
                                @if($plan->is_recommend)
                                    <br><span class="badge badge--warning-transparent">{{ __('Recommended') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Amount Range') }}">
                                <div class="amount-range">
                                    @if($plan->type == 2)
                                        <strong>{{ getCurrencySymbol() }}{{ shortAmount($plan->amount, 2) }}</strong>
                                    @else
                                        <strong>{{ getCurrencySymbol() }}{{ shortAmount($plan->minimum, 2) }}</strong>
                                        <br><small class="text-muted">to {{ getCurrencySymbol() }}{{ shortAmount($plan->maximum, 2) }}</small>
                                    @endif
                                </div>
                            </td>
                            <td data-label="{{ __('Type') }}">
                                @if($plan->type == 1)
                                    <span class="badge badge--success">{{ __('Fixed') }}</span>
                                @elseif($plan->type == 2)
                                    <span class="badge badge--info">{{ __('Flexible') }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Interest Rate') }}">
                                <span class="badge badge--info">{{ shortAmount($plan->interest_rate, 2) }} @if($plan->interest_type == 2){{ getCurrencyName() }} @else %@endif</span>
                            </td>
                            <td data-label="{{ __('Duration') }}">
                                @if($plan->timeTable)
                                    <span class="badge badge--primary">{{ $plan->duration }} {{ $plan->timeTable->name }}</span>
                                @else
                                    <span class="text-muted">{{ $plan->duration }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Return Type') }}">
                                @if($plan->interest_return_type == 1)
                                    <span class="badge badge--primary">{{ __('Lifetime') }}</span>
                                @elseif($plan->interest_return_type == 2)
                                    <span class="badge badge--info">{{ __('Repeat') }}</span>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Total Investments') }}">
                                <strong class="text--primary">{{ $plan->investmentLogs->count() }}</strong>
                                @if($plan->investmentLogs->sum('amount') > 0)
                                    <br><small class="text-muted">{{ getCurrencySymbol() }}{{ shortAmount($plan->investmentLogs->sum('amount'), 2) }}</small>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($plan->status == 1)
                                    <span class="badge badge--success">{{ __('ACTIVE') }}</span>
                                @else
                                    <span class="badge badge--danger">{{ __('INACTIVE') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.binary.edit', $plan->uid) }}" class="btn btn-sm btn-outline-primary">
                                        {{ __('Edit') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="10">{{ __('No investment plans found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($investmentPlans->hasPages())
            <div class="card-footer">
                {{ $investmentPlans->appends(request()->all())->links() }}
            </div>
        @endif
    </section>
@endsection
