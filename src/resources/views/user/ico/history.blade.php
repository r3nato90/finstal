@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="container-fluid">
            <div class="i-card-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-white">{{ __('Recent Purchase History') }}</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center gy-4 mb-3">
                        <div class="table-container">
                            <table id="myTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Purchase ID') }}</th>
                                    <th scope="col">{{ __('Token') }}</th>
                                    <th scope="col">{{ __('Invest Amount') }}</th>
                                    <th scope="col">{{ __('Tokens') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Date') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($purchases as $key => $purchase)
                                    <tr>
                                        <td data-label="{{ __('Purchase ID') }}">#{{ $purchase->purchase_id }}</td>
                                        <td data-label="{{ __('Token') }}">
                                            <div>
                                                <strong class="text-white">{{ $purchase->icoToken->name }}</strong>
                                                <br><small>{{ $purchase->icoToken->symbol }}</small>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Invest Amount') }}">${{ number_format($purchase->amount_usd, 2) }}</td>
                                        <td data-label="{{ __('Tokens') }}">{{ number_format($purchase->tokens_purchased, 2) }}</td>
                                        <td data-label="{{ __('Status') }}">
                                            @if($purchase->status == 'completed')
                                                <span class="i-badge badge--success">{{ __('Completed') }}</span>
                                            @elseif($purchase->status == 'pending')
                                                <span class="i-badge badge--primary">{{ __('Pending') }}</span>
                                            @elseif($purchase->status == 'failed')
                                                <span class="i-badge badge--danger">{{ __('Failed') }}</span>
                                            @else
                                                <span class="i-badge badge--info">{{ ucfirst($purchase->status) }}</span>
                                            @endif
                                        </td>
                                        <td data-label="{{ __('Date') }}">{{ $purchase->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-white text-center" colspan="100%">{{ __('No Data Found')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-4">{{ $purchases->links() }}</div>
            </div>
        </div>
    </div>
@endsection
