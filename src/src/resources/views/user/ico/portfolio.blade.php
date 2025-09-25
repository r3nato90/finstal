@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="container-fluid">
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="i-card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p>{{ __('Total Invested') }}</p>
                                    <h4 class="text-white mb-0">{{ getCurrencySymbol() }}{{ getAmount($portfolioStats['total_invested'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="i-card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p>{{ __('Current Value') }}</p>
                                    <h4 class="text-white mb-0">{{ getCurrencySymbol() }}{{ getAmount($portfolioStats['current_value'], 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="i-card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p>{{ __('Total P/L') }}</p>
                                    <h4 class="mb-0 {{ $portfolioStats['total_profit_loss'] >= 0 ? 'text--success' : 'text--danger' }}">
                                        {{ $portfolioStats['total_profit_loss'] >= 0 ? '+' : '' }}{{ getCurrencySymbol() }}{{ getAmount($portfolioStats['total_profit_loss'], 2) }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="i-card-sm">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <p>{{ __('Total P/L %') }}</p>
                                    <h4 class="mb-0 {{ $portfolioStats['total_profit_loss_percentage'] >= 0 ? 'text--success' : 'text--danger' }}">
                                        {{ $portfolioStats['total_profit_loss_percentage'] >= 0 ? '+' : '' }}{{ getAmount($portfolioStats['total_profit_loss_percentage'], 2) }}%
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="i-card-sm">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 text-white">{{ __('Token Holdings') }}</h5>
                    <div class="text-white small">
                        {{ $holdings->count() }} {{ __('different tokens') }}
                    </div>
                </div>
                <div class="card-body">
                    @if($holdings->count() > 0)
                        <div class="table-container">
                            <table id="portfolioTable" class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('Token') }}</th>
                                    <th scope="col">{{ __('Holdings') }}</th>
                                    <th scope="col">{{ __('Avg Price') }}</th>
                                    <th scope="col">{{ __('Current Price') }}</th>
                                    <th scope="col">{{ __('Total Invested') }}</th>
                                    <th scope="col">{{ __('Current Value') }}</th>
                                    <th scope="col">{{ __('Profit/Loss') }}</th>
                                    <th scope="col">{{ __('P/L %') }}</th>
                                    <th scope="col">{{ __('Actions') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($holdings as $holding)
                                    <tr>
                                        <td data-label="{{ __('Token') }}">
                                            <div class="d-flex align-items-center">
                                                <div class="token-avatar me-3">
                                                    <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                        <span class="text-white fw-bold">{{ substr($holding->token->symbol, 0, 2) }}</span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <strong class="text-white">{{ $holding->token->name }}</strong>
                                                    <br><small>{{ $holding->token->symbol }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Holdings') }}">
                                            <div>
                                                <strong class="text-white">{{ getAmount($holding->available_tokens, 2) }}</strong>
                                                <br>
                                                <small>
                                                    {{ $holding->purchase_count }} {{ __('purchase') }}{{ $holding->purchase_count > 1 ? 's' : '' }}
                                                    @if($holding->sold_tokens > 0)
                                                        <span>({{ getAmount($holding->sold_tokens, 2) }} {{ __('sold') }})</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Avg Price') }}">{{ getCurrencySymbol() }}{{ getAmount($holding->average_price, 4) }}</td>
                                        <td data-label="{{ __('Current Price') }}">
                                            <div>
                                                <strong class="text-white">{{ getCurrencySymbol() }}{{ getAmount($holding->token->current_price, 4) }}</strong>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Total Invested') }}">{{ getCurrencySymbol() }}{{ getAmount($holding->total_invested) }}</td>
                                        <td data-label="{{ __('Current Value') }}">
                                            <strong class="text-white">${{ getAmount($holding->current_value, 2) }}</strong>
                                        </td>
                                        <td data-label="{{ __('Profit/Loss') }}">
                                            <strong class="{{ $holding->profit_loss >= 0 ? 'text-success' : 'text-danger' }}">
                                                {{ $holding->profit_loss >= 0 ? '+' : '' }}${{ getAmount($holding->profit_loss, 2) }}
                                            </strong>
                                        </td>
                                        <td data-label="{{ __('P/L %') }}">
                                            <div class="d-flex align-items-center">
                                                <span class="{{ $holding->profit_loss_percentage >= 0 ? 'text-success' : 'text-danger' }} fw-bold">
                                                    {{ $holding->profit_loss_percentage >= 0 ? '+' : '' }}{{ getAmount($holding->profit_loss_percentage, 2) }}%
                                                </span>
                                                <i class="fas fa-{{ $holding->is_profitable ? 'check-circle text-success' : 'times-circle text-danger' }} ms-2"></i>
                                            </div>
                                        </td>
                                        <td data-label="{{ __('Actions') }}">
                                            <button
                                                class="btn btn-sm btn-outline-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#sellModal"
                                                data-token-id="{{ $holding->token->id }}"
                                                data-token-name="{{ $holding->token->name }}"
                                                data-token-symbol="{{ $holding->token->symbol }}"
                                                data-available-tokens="{{ $holding->available_tokens }}"
                                                data-current-price="{{ $holding->token->current_price }}"
                                                {{ $holding->available_tokens <= 0 ? 'disabled' : '' }}
                                            >
                                                <i class="fas fa-exchange-alt me-1"></i>{{ __('Sell') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="fas fa-chart-bar text-muted" style="font-size: 4rem;"></i>
                            </div>
                            <h5 class="text-white">{{ __('No Token Holdings Found') }}</h5>
                            <p class="text-white">{{ __('Start investing to see your portfolio') }}</p>
                            <a href="{{ route('user.ico.index') }}" class="i-btn btn--primary btn--sm">
                                <i class="fas fa-coins me-2"></i>{{ __('Browse ICO Tokens') }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Sell Token Modal -->
    <div class="modal fade" id="sellModal" tabindex="-1" aria-labelledby="sellModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg--dark border-secondary">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-white" id="sellModalLabel">{{ __('Sell Token') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('user.ico.portfolio.sell') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="ico_token_id" id="modal_token_id">

                        <!-- Token Info Card -->
                        <div class="card bg-secondary border-0 mb-4">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="token-avatar me-3">
                                        <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <span class="text-white fw-bold fs-5" id="modal_token_symbol_short"></span>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="text-white mb-1" id="modal_token_name"></h5>
                                        <small class="text-white" id="modal_token_symbol"></small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-white">{{ __('Available') }}:</small>
                                        <div class="fw-bold text-white" id="modal_available_tokens"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-white">{{ __('Current Price') }}:</small>
                                        <div class="fw-bold text-success" id="modal_current_price"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sell Form -->
                        <div class="mb-4">
                            <label for="tokens_to_sell" class="form-label text-white">{{ __('Tokens to Sell') }}</label>
                            <input type="number"
                                   class="form-control bg-dark border-secondary text-white"
                                   id="tokens_to_sell"
                                   name="tokens_to_sell"
                                   min="1"
                                   step="1"
                                   placeholder="{{ __('Enter token amount') }}"
                                   required>
                            <div class="form-text text-white">
                                {{ __('Maximum tokens:') }} <span id="max_tokens_text"></span>
                            </div>
                        </div>

                        <!-- Sale Summary -->
                        <div class="card bg-dark border-warning" id="sale_summary" style="display: none;">
                            <div class="card-body">
                                <h6 class="text-white mb-3">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>{{ __('Sale Summary') }}
                                </h6>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <small class="text-white">{{ __('Tokens to Sell') }}:</small>
                                        <div class="fw-bold text-white" id="summary_tokens"></div>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-white">{{ __('Sale Price') }}:</small>
                                        <div class="fw-bold text-white" id="summary_price"></div>
                                    </div>
                                    <div class="col-12">
                                        <hr class="border-secondary">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="text-white">{{ __('Total Amount') }}:</span>
                                            <span class="fw-bold text-success fs-5" id="summary_total"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger" id="confirm_sell_btn" disabled>
                            <i class="fas fa-exchange-alt me-2"></i>{{ __('Sell Tokens') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sellModal = document.getElementById('sellModal');
            const tokensInput = document.getElementById('tokens_to_sell');
            const confirmBtn = document.getElementById('confirm_sell_btn');
            const saleSummary = document.getElementById('sale_summary');

            let currentTokenData = {};

            // Handle modal show event
            sellModal.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;

                currentTokenData = {
                    id: button.getAttribute('data-token-id'),
                    name: button.getAttribute('data-token-name'),
                    symbol: button.getAttribute('data-token-symbol'),
                    availableTokens: parseFloat(button.getAttribute('data-available-tokens')),
                    currentPrice: parseFloat(button.getAttribute('data-current-price'))
                };

                // Populate modal fields
                document.getElementById('modal_token_id').value = currentTokenData.id;
                document.getElementById('modal_token_name').textContent = currentTokenData.name;
                document.getElementById('modal_token_symbol').textContent = currentTokenData.symbol;
                document.getElementById('modal_token_symbol_short').textContent = currentTokenData.symbol.substring(0, 2);
                document.getElementById('modal_available_tokens').textContent = formatNumber(currentTokenData.availableTokens);
                document.getElementById('modal_current_price').textContent = '$' + formatNumber(currentTokenData.currentPrice);
                document.getElementById('max_tokens_text').textContent = formatNumber(currentTokenData.availableTokens);

                // Set input constraints
                tokensInput.max = currentTokenData.availableTokens;
                tokensInput.value = '';

                // Reset form state
                confirmBtn.disabled = true;
                saleSummary.style.display = 'none';
            });

            // Handle input changes
            tokensInput.addEventListener('input', function() {
                const tokensToSell = parseFloat(this.value) || 0;
                const isValid = tokensToSell >= 1 && tokensToSell <= currentTokenData.availableTokens;

                confirmBtn.disabled = !isValid;

                if (isValid && tokensToSell > 0) {
                    const totalAmount = tokensToSell * currentTokenData.currentPrice;

                    document.getElementById('summary_tokens').textContent = formatNumber(tokensToSell);
                    document.getElementById('summary_price').textContent = '$' + formatNumber(currentTokenData.currentPrice);
                    document.getElementById('summary_total').textContent = '$' + formatNumber(totalAmount);

                    saleSummary.style.display = 'block';
                } else {
                    saleSummary.style.display = 'none';
                }
            });

            function formatNumber(num) {
                if (num >= 1000000000) {
                    return (num / 1000000000).toFixed(2) + 'B';
                } else if (num >= 1000000) {
                    return (num / 1000000).toFixed(2) + 'M';
                } else if (num >= 1000) {
                    return (num / 1000).toFixed(2) + 'K';
                } else if (Number.isInteger(num)) {
                    return num.toString();
                } else {
                    return num.toFixed(2);
                }
            }
        });
    </script>
@endpush

@push('style-push')
    <style>
        .token-avatar {
            flex-shrink: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .i-card-sm {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(10px);
        }

        .bg-gradient-primary {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        }

        .modal-content {
            backdrop-filter: blur(10px);
        }

        .card.bg-secondary {
            background-color: rgba(108, 117, 125, 0.2) !important;
        }

        .card.bg-dark {
            background-color: rgba(33, 37, 41, 0.3) !important;
        }

        @media (max-width: 768px) {
            .table-container table,
            .table-container thead,
            .table-container tbody,
            .table-container th,
            .table-container td,
            .table-container tr {
                display: block;
            }

            .table-container thead tr {
                position: absolute;
                top: -9999px;
                left: -9999px;
            }

            .table-container tr {
                border: 1px solid rgba(255, 255, 255, 0.1);
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.02);
            }

            .table-container td {
                border: none;
                position: relative;
                padding-left: 50% !important;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .table-container td:before {
                content: attr(data-label) ": ";
                position: absolute;
                left: 6px;
                width: 45%;
                padding-right: 10px;
                white-space: nowrap;
                font-weight: bold;
                color: #adb5bd;
            }
        }

        .btn-outline-danger:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .form-control:focus {
            background-color: #212529 !important;
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.2rem rgba(111, 66, 193, 0.25);
        }

        .text-success {
            color: #20c997 !important;
        }

        .text-danger {
            color: #fd7e14 !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }
    </style>
@endpush
