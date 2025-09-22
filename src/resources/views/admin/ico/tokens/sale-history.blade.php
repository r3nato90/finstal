@extends('admin.layouts.main')

@section('panel')
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title">{{ __('ICO Sale History') }}</h3>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Sales') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['total_sales']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Completed') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['completed_sales']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Amount') }}</h6>
                        <h4 class="text-dark">{{ getCurrencySymbol() }}{{ shortAmount($stats['total_amount']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Tokens') }}</h6>
                        <h4 class="text-dark">{{ shortAmount($stats['total_tokens']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.ico.sale.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Sale ID, User Name, Email...') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status">{{ __('Status') }}</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">{{ __('All Status') }}</option>
                                    <option value="pending" {{ ($filters['status'] ?? '') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                    <option value="completed" {{ ($filters['status'] ?? '') == 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                                    <option value="failed" {{ ($filters['status'] ?? '') == 'failed' ? 'selected' : '' }}>{{ __('Failed') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="token">{{ __('Token') }}</label>
                                <select name="token" id="token" class="form-control">
                                    <option value="">{{ __('All Tokens') }}</option>
                                    @foreach($tokens as $token)
                                        <option value="{{ $token->id }}" {{ ($filters['token'] ?? '') == $token->id ? 'selected' : '' }}>
                                            {{ $token->name }} ({{ $token->symbol }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_from">{{ __('Date From') }}</label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                       value="{{ $filters['date_from'] ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-2">
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

        <!-- Sales Table Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Sale History') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing {{ $sales->firstItem() ?? 0 }} to {{ $sales->lastItem() ?? 0 }}
                        of {{ $sales->total() ?? 0 }} sales
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th>{{ __('Sale ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Token') }}</th>
                        <th>{{ __('Tokens Sold') }}</th>
                        <th>{{ __('Total Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($sales as $sale)
                        <tr>
                            <td data-label="{{ __('Sale ID') }}">
                                <strong>{{ $sale->sale_id }}</strong>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <h6 class="mb-1">{{ $sale->user->fullname ?? 'N/A' }}</h6>
                                    <small class="text-muted">{{ $sale->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Token') }}">
                                @if($sale->icoToken)
                                    <div class="token-info">
                                        <strong>{{ $sale->icoToken->name }}</strong>
                                        <br><small class="text-muted">{{ $sale->icoToken->symbol }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('N/A') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Tokens Sold') }}">
                                <strong>{{ shortAmount($sale->tokens_sold) }}</strong>
                                <br><small class="text-muted">@ ${{ shortAmount($sale->sale_price, 4) }}</small>
                            </td>
                            <td data-label="{{ __('Total Amount') }}">
                                <strong>${{ shortAmount($sale->total_amount) }}</strong>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($sale->status == 'completed')
                                    <span class="badge badge--success">{{ __('Completed') }}</span>
                                @elseif($sale->status == 'pending')
                                    <span class="badge badge--warning">{{ __('Pending') }}</span>
                                @elseif($sale->status == 'failed')
                                    <span class="badge badge--danger">{{ __('Failed') }}</span>
                                @else
                                    <span class="badge badge--secondary">{{ __('Unknown') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Date') }}">
                                @if($sale->sold_at)
                                    {{ showDateTime($sale->sold_at, 'd M Y H:i') }}
                                @else
                                    {{ showDateTime($sale->created_at, 'd M Y H:i') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="7">{{ __('No sales found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($sales->hasPages())
                <div class="card-footer">
                    {{ $sales->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
