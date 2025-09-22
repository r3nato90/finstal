@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('ICO Purchase History') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Purchases') }}</h6>
                        <h4 class="text-dark">{{ number_format($stats['total_purchases']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Completed') }}</h6>
                        <h4 class="text-dark">{{ number_format($stats['completed_purchases']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Amount') }}</h6>
                        <h4 class="text-dark">${{ shortAmount($stats['total_amount']) }}</h4>
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

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.ico.purchase.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Purchase ID, User Name, Email...') }}">
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
                                    <option value="cancelled" {{ ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
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

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">{{ __('Purchase History') }}</h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing {{ $purchases->firstItem() ?? 0 }} to {{ $purchases->lastItem() ?? 0 }}
                        of {{ $purchases->total() ?? 0 }} purchases
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th> {{ __('Purchase ID') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Token') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Tokens') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($purchases as $purchase)
                        <tr>
                            <td data-label="{{ __('Purchase ID') }}">
                                <strong>{{ $purchase->purchase_id }}</strong>
                            </td>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <h6 class="mb-1">{{ $purchase->user->fullname ?? 'N/A' }}</h6>
                                    <small class="text-muted">{{ $purchase->user->email ?? 'N/A' }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Token') }}">
                                @if($purchase->icoToken)
                                    <div class="token-info">
                                        <strong>{{ $purchase->icoToken->name }}</strong>
                                        <br><small class="text-muted">{{ $purchase->icoToken->symbol }}</small>
                                    </div>
                                @else
                                    <span class="text-muted">{{ __('N/A') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Amount') }}">
                                <div class="amount-info">
                                    <strong>${{ shortAmount($purchase->amount_usd) }}</strong>
                                    <br><small class="text-muted">@ ${{ shortAmount($purchase->token_price, 4) }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Tokens') }}">
                                <strong>{{ shortAmount($purchase->tokens_purchased) }}</strong>
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($purchase->status == 'completed')
                                    <span class="badge badge--success">{{ __('Completed') }}</span>
                                @elseif($purchase->status == 'pending')
                                    <span class="badge badge--warning">{{ __('Pending') }}</span>
                                @elseif($purchase->status == 'failed')
                                    <span class="badge badge--danger">{{ __('Failed') }}</span>
                                @elseif($purchase->status == 'cancelled')
                                    <span class="badge badge--secondary">{{ __('Cancelled') }}</span>
                                @else
                                    <span class="badge badge--secondary">{{ __('Unknown') }}</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Date') }}">
                                @if($purchase->purchased_at)
                                    {{ showDateTime($purchase->purchased_at, 'd M Y H:i') }}
                                @else
                                    {{ showDateTime($purchase->created_at, 'd M Y H:i') }}
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="7">{{ __('No purchases found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($purchases->hasPages())
                <div class="card-footer">
                    {{ $purchases->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
