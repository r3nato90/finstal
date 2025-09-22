@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <h3 class="page-title">{{ __('User Management') }}</h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Total Users') }}</h6>
                        <h4 class="text--dark">{{ shortAmount($stats['totalUsers']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Active Users') }}</h6>
                        <h4 class="text--success">{{ shortAmount($stats['activeUsers']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('Verified Users') }}</h6>
                        <h4 class="text--info">{{ shortAmount($stats['verifiedUsers']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted">{{ __('KYC Approved') }}</h6>
                        <h4 class="text--warning">{{ shortAmount($stats['kycApprovedUsers']) }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.user.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search">{{ __('Search') }}</label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="{{ $filters['search'] ?? '' }}"
                                       placeholder="{{ __('Name, Email, UUID...') }}">
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
                                <label for="kyc_status">{{ __('KYC Status') }}</label>
                                <select name="kyc_status" id="kyc_status" class="form-control">
                                    <option value="">{{ __('All KYC') }}</option>
                                    <option value="1" {{ ($filters['kyc_status'] ?? '') == '1' ? 'selected' : '' }}>{{ __('Approved') }}</option>
                                    <option value="0" {{ ($filters['kyc_status'] ?? '') == '0' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sort_field">{{ __('Sort By') }}</label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" {{ ($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : '' }}>{{ __('Date Joined') }}</option>
                                    <option value="first_name" {{ ($filters['sort_field'] ?? '') == 'first_name' ? 'selected' : '' }}>{{ __('Name') }}</option>
                                    <option value="email" {{ ($filters['sort_field'] ?? '') == 'email' ? 'selected' : '' }}>{{ __('Email') }}</option>
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
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Wallet') }}</th>
                        <th>{{ __('KYC Status') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Joined') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td data-label="{{ __('User') }}">
                                <div class="user-info">
                                    <strong>{{ $user->full_name }}</strong>
                                    <br><small class="text-muted">ID: {{ $user->uuid }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Email') }}">
                                <span>{{ $user->email }}</span>
                                @if($user->email_verified_at)
                                    <br><span class="badge badge--success-transparent">Verified</span>
                                @else
                                    <br><span class="badge badge--warning-transparent">Unverified</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Wallet') }}">
                                @if($user->wallet)
                                    <button class="btn btn--primary btn--sm wallets" data-id="{{ json_encode($user->wallet) }}">
                                        {{ __('View Wallet') }}
                                    </button>
                                @else
                                    <span class="text-muted">No Wallet</span>
                                @endif
                            </td>
                            <td data-label="{{ __('KYC Status') }}">
                                @if($user->kyc_status == 1)
                                    <span class="badge badge--success">Approved</span>
                                @else
                                    <span class="badge badge--warning">Pending</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Status') }}">
                                @if($user->status == 1)
                                    <span class="badge badge--success">Active</span>
                                @else
                                    <span class="badge badge--danger">Inactive</span>
                                @endif
                            </td>
                            <td data-label="{{ __('Joined') }}">
                                <div class="time-info">
                                    <strong>{{ $user->created_at->format('M d, Y') }}</strong>
                                    <br><small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td data-label="{{ __('Actions') }}">
                                <button class="btn btn--warning btn--sm created-update" data-id="{{ $user->id }}">
                                    {{ __('Add/Subtract') }}
                                </button>
                                <a href="{{ route('admin.user.details', $user->id) }}" class="btn btn--primary btn--sm">
                                    {{ __('Details') }}
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-muted text-center" colspan="7">{{ __('No users found') }}</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="card-footer">
                    {{ $users->appends(request()->all())->links() }}
                </div>
            @endif
        </div>
    </section>

    <!-- Add/Subtract Balance Modal -->
    <div class="modal fade" id="credit-add-return" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Add/Subtract Balance')}}</h5>
                </div>
                <form action="{{route('admin.user.add-subtract.balance')}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Type')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="type" id="type" required>
                                @foreach(\App\Enums\Transaction\Type::toArray() as $status)
                                    <option value="{{ $status }}">{{ \App\Enums\Transaction\Type::getName($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wallet_type" class="form-label">{{ __('Select Wallet')}} <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="wallet_type" id="wallet_type" required>
                                @foreach(\App\Enums\Transaction\WalletType::toArray() as $status)
                                    <option value="{{ $status }}">{{ \App\Enums\Transaction\WalletType::getName($status) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label">{{ __('Amount')}} <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" name="amount"
                                       placeholder="Enter amount" aria-label="Amount" step="0.01" min="0.01">
                                <span class="input-group-text">{{getCurrencyName()}}</span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal">{{ __('Cancel')}}</button>
                            <button type="submit" class="btn btn--primary btn--sm">{{ __('Save')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Wallet Details Modal -->
    <div class="modal fade" id="list-wallet" tabindex="-1" aria-labelledby="list-wallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('User Wallet Details') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="modal-pay-list"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            $('.created-update').on('click', function () {
                const modal = $('#credit-add-return');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.wallets').on('click', function () {
                $('.modal-pay-list').empty();
                const modal = $('#list-wallet');
                const walletData = $(this).data('id');
                const currency = "{{ getCurrencySymbol() }}";
                const walletProperties = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];

                walletProperties.forEach(property => {
                    const propertyName = property.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const balanceValue = currency + parseFloat(walletData[property] || 0).toFixed(2);
                    const listItem = `<li>
                            <span>${propertyName}</span>
                            <span>${balanceValue}</span>
                          </li>`;

                    modal.find('.modal-pay-list').append(listItem);
                });

                modal.modal('show');
            });
        });
    </script>
@endpush
