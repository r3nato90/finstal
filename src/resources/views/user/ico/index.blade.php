@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="container-fluid">
            @if($activeTokens && $activeTokens->count() > 0)
                <div class="i-card-sm mb-4">
                    <h4 class="title">{{ __('ICO Investment Overview') }}</h4>
                    <div class="row g-3 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1">
                        <div class="col">
                            <div class="i-card-sm p-3 shadow-none p-3">
                                <p class="fs-15">{{ __('Total Invested') }}</p>
                                <h5 class="title-sm mb-0">{{ getCurrencySymbol() }}{{ $statistics['total_invested'] }}</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 shadow-none p-3">
                                <p class="fs-15">{{ __('Tokens Purchased') }}</p>
                                <h5 class="title-sm mb-0">{{ $statistics['total_tokens_purchased'] }}</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 shadow-none p-3">
                                <p class="fs-15">{{ __('Successful Purchases') }}</p>
                                <h5 class="title-sm mb-0">{{ $statistics['successful_purchases'] }}</h5>
                            </div>
                        </div>
                        <div class="col">
                            <div class="i-card-sm p-3 shadow-none p-3">
                                <p class="fs-15">{{ __('Pending Purchases') }}</p>
                                <h5 class="title-sm mb-0">{{ $statistics['pending_purchases'] }}</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 text-white">{{ __('Active Token Sales') }}</h4>
                            <span class="i-badge badge--primary">{{ $activeTokens->count() }} {{ __('Active') }}</span>
                        </div>

                        <div class="row align-items-center gy-4" id="tokenContainer">
                            @foreach($activeTokens as $index => $token)
                                <div class="col-xl-4 col-lg-6 token-card {{ $index >= 6 ? 'd-none' : '' }}"
                                     data-token-index="{{ $index }}">
                                    <div class="i-card-sm p-3 bg--dark">
                                        <!-- Token Header -->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <div>
                                                <h5 class="title-sm mb-0 text-white">{{ $token->name }}</h5>
                                                <small>({{ strtoupper($token->symbol) }})</small>
                                            </div>
                                            <span class="i-badge {{ $token->status == 'active' ? 'badge--success' : 'badge--warning' }}">
                                                {{ ucfirst($token->status) }}
                                            </span>
                                        </div>

                                        <!-- Token Stats Grid -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <div class="i-card-sm p-2 text-center">
                                                    <h6 class="fs-12 mb-1">{{ __('Price') }}</h6>
                                                    <span class="text-white fw-bold">${{ number_format($token->current_price, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="i-card-sm p-2 text-center">
                                                    <h6 class="fs-12 mb-1">{{ __('Raised') }}</h6>
                                                    <span class="text-white fw-bold">{{ getCurrencySymbol() }}{{ getAmount($token->tokens_sold * $token->current_price, 0) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="i-card-sm p-2 text-center">
                                                    <h6 class="fs-12 mb-1">{{ __('Sold') }}</h6>
                                                    <span class="text-white">{{ getAmount($token->tokens_sold) }}</span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="i-card-sm p-2 text-center">
                                                    <h6 class="fs-12 mb-1">{{ __('Supply') }}</h6>
                                                    <span class="text-white">{{ getAmount($token->total_supply) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Progress Bar -->
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-white">{{ __('Progress') }}</small>
                                                @php
                                                    $progress = $token->total_supply > 0 ? ($token->tokens_sold / $token->total_supply) * 100 : 0;
                                                @endphp
                                                <small class="text-success fw-bold">{{ getAmount($progress, 1) }}%</small>
                                            </div>
                                            <div class="progress bg-secondary" style="height: 8px;">
                                                <div class="progress-bar bg-success progress-bar-striped progress-bar-animated"
                                                     role="progressbar" style="width: {{ $progress }}%"></div>
                                            </div>
                                        </div>

                                        <!-- Sale Period -->
                                        @if($token->sale_start_date && $token->sale_end_date)
                                            <div class="mb-3 p-2 i-card-sm primary--light">
                                                <div class="row text-center">
                                                    <div class="col-6">
                                                        <small class="d-block text-white">{{ __('Start') }}</small>
                                                        <small class="text-white">{{ \Carbon\Carbon::parse($token->sale_start_date)->format('d M Y') }}</small>
                                                    </div>
                                                    <div class="col-6">
                                                        <small class="d-block text-white">{{ __('End') }}</small>
                                                        <small class="text-white">{{ \Carbon\Carbon::parse($token->sale_end_date)->format('d M Y') }}</small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Purchase Form -->
                                        <form method="POST" action="{{ route('user.ico.purchase') }}" class="purchase-form">
                                            @csrf
                                            <input type="hidden" name="ico_token_id" value="{{ $token->id }}">

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Purchase Amount') }}</label>
                                                <div class="input-group">
                                                    <label for="amount" class="col-form-label">{{ __('Amount') }}</label>
                                                    <div class="input-group mb-3">
                                                        <input type="number" class="form-control amount-input" step="0.01" min="1" max="999999" name="amount_usd"
                                                               placeholder="{{ __('Enter Invest amount') }}"
                                                               aria-label="Recipient's username"
                                                               aria-describedby="basic-addon2"
                                                               data-token-price="{{ $token->current_price }}"
                                                               data-token-symbol="{{ $token->symbol }}">
                                                        <span class="input-group-text" id="basic-addon2">{{ getCurrencyName() }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">{{ __('Tokens to Receive') }}</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control bg-dark border-secondary text-white tokens-display" readonly>
                                                    <span class="input-group-text bg-secondary border-secondary text-white">{{ strtoupper($token->symbol) }}</span>
                                                </div>
                                            </div>

                                            <button type="submit" class="i-btn btn--primary btn--sm w-100">
                                                {{ __('Purchase') }} {{ $token->symbol }} {{ __('Tokens') }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if($activeTokens->count() > 6)
                            <div class="text-center mt-4">
                                <button class="i-btn btn--primary btn--sm" id="showMoreTokens">
                                    <i class="bi bi-chevron-down me-1"></i>{{ __('Show More Tokens') }} ({{ $activeTokens->count() - 6 }} {{ __('remaining') }})
                                </button>
                                <button class="i-btn btn--primary btn--sm d-none" id="showLessTokens">
                                    <i class="bi bi-chevron-up me-1"></i>{{ __('Show Less') }}
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="i-card-sm mb-4">
                    <div class="card-body text-center py-5">
                        <i class="bi bi-info-circle fa-3x text-warning mb-3"></i>
                        <h4 class="text-white">{{ __('No Active ICO') }}</h4>
                        <p>{{ __('There are currently no active ICO token sales available.') }}</p>
                    </div>
                </div>
            @endif

            <!-- Purchase History - Matrix Style -->
            <div class="i-card-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-white">{{ __('Recent Purchase History') }}</h5>
                    <a href="{{ route('user.ico.history') }}" class="i-btn btn--primary btn--sm">{{ __('View All') }}</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Purchase ID') }}</th>
                                <th scope="col">{{ __('Token') }}</th>
                                <th scope="col">{{ __('Amount (USD)') }}</th>
                                <th scope="col">{{ __('Tokens') }}</th>
                                <th scope="col">{{ __('Status') }}</th>
                                <th scope="col">{{ __('Date') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($purchases as $purchase)
                                <tr>
                                    <td>#{{ $purchase->purchase_id }}</td>
                                    <td>
                                        <div>
                                            <strong class="text-white">{{ $purchase->icoToken->name }}</strong>
                                            <br><small>{{ $purchase->icoToken->symbol }}</small>
                                        </div>
                                    </td>
                                    <td class="text-white">${{ number_format($purchase->amount_usd, 2) }}</td>
                                    <td class="text-white">{{ number_format($purchase->tokens_purchased, 2) }}</td>
                                    <td>
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
                                    <td>{{ $purchase->created_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="6">{{ __('No purchases found') }}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            @if($purchases->hasPages())
                <div class="mt-4">
                    {{ $purchases->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('script-push')
        <script>
            $(document).ready(function () {
                // Show/Hide more tokens functionality
                $('#showMoreTokens').on('click', function() {
                    $('.token-card.d-none').removeClass('d-none');
                    $(this).addClass('d-none');
                    $('#showLessTokens').removeClass('d-none');
                });

                $('#showLessTokens').on('click', function() {
                    $('.token-card[data-token-index]').each(function() {
                        if ($(this).data('token-index') >= 6) {
                            $(this).addClass('d-none');
                        }
                    });
                    $(this).addClass('d-none');
                    $('#showMoreTokens').removeClass('d-none');
                });

                // Handle token calculation for each purchase form
                $('.purchase-form').each(function() {
                    const form = $(this);
                    const amountInput = form.find('.amount-input');
                    const tokensDisplay = form.find('.tokens-display');
                    const tokenPrice = parseFloat(amountInput.data('token-price'));

                    amountInput.on('input', function () {
                        const amount = parseFloat($(this).val()) || 0;
                        const tokens = tokenPrice > 0 ? amount / tokenPrice : 0;
                        tokensDisplay.val(tokens > 0 ? tokens.toFixed(6) : '0');
                    });
                });

                // Form validation
                $('.purchase-form').on('submit', function(e) {
                    const amount = parseFloat($(this).find('.amount-input').val());
                    if (!amount || amount <= 0) {
                        e.preventDefault();
                        alert('Please enter a valid purchase amount.');
                        return false;
                    }
                });

                // Input field focus styling
                $('.form-control').on('focus', function() {
                    $(this).removeClass('border-secondary').addClass('border-primary');
                });

                $('.form-control').on('blur', function() {
                    $(this).removeClass('border-primary').addClass('border-secondary');
                });
            });
        </script>
    @endpush

    @push('style-push')
        <style>
            .progress {
                background-color: #2d2d2d !important;
                border-radius: 6px;
            }

            .progress-bar {
                border-radius: 6px;
            }

            .bg-secondary {
                background-color: #2d2d2d !important;
            }

            .border-secondary {
                border-color: #2d2d2d !important;
            }


            .badge {
                border-radius: 20px;
                padding: 4px 8px;
                font-size: 0.75rem;
                font-weight: 600;
                text-transform: uppercase;
            }
        </style>
    @endpush
@endsection
