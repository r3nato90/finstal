@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ $setTitle }}</h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form action="{{route('admin.ico.token.update', $token->id)}}" method="POST" enctype="multipart/form-data" id="tokenForm">
                                @csrf
                                @method('PUT')

                                <!-- Basic Information Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5>@lang('Basic Information')</h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="name">@lang('Token Name') <sup class="text-danger">*</sup></label>
                                            <input type="text" name="name" id="name" value="{{ old('name', $token->name) }}" class="form-control" placeholder="@lang('Enter Name')" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="symbol">@lang('Symbol') <sup class="text-danger">*</sup></label>
                                            <input type="text" name="symbol" id="symbol" value="{{ old('symbol', $token->symbol) }}" class="form-control" placeholder="@lang('Enter Symbol')" required>
                                        </div>
                                    </div>

                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-12">
                                            <label class="form-label" for="description">@lang('Description')</label>
                                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="@lang('Enter token description')">{{ old('description', $token->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Token Economics Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5>@lang('Token Economics')</h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="price">@lang('Initial Price') <sup class="text-danger">*</sup></label>
                                            <input type="text" name="price" id="price" value="{{ old('price', getAmount($token->price)) }}" class="form-control"
                                                   placeholder="@lang('Enter Initial Price')" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="current_price">@lang('Current Price')</label>
                                            <input type="text" name="current_price" id="current_price" value="{{ old('current_price', getAmount($token->current_price)) }}" class="form-control"
                                                   placeholder="@lang('Enter Current Price')">
                                        </div>
                                    </div>

                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="total_supply">@lang('Total Supply') <sup class="text-danger">*</sup></label>
                                            <input type="text" name="total_supply" id="total_supply" value="{{ old('total_supply', getAmount($token->total_supply)) }}" class="form-control"
                                                   placeholder="@lang('Enter Total Supply')" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="tokens_sold">@lang('Tokens Sold')</label>
                                            <input type="number" name="tokens_sold" id="tokens_sold" value="{{ old('tokens_sold', $token->tokens_sold) }}" class="form-control"
                                                   placeholder="@lang('Enter Tokens Sold')" min="0">
                                        </div>
                                    </div>
                                </div>

                                <!-- Sale Period Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5>@lang('Sale Period')</h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="sale_start_date">@lang('Sale Start Date') <sup class="text-danger">*</sup></label>
                                            <input type="date" name="sale_start_date" id="sale_start_date" value="{{ old('sale_start_date', $token->sale_start_date ? date('Y-m-d', strtotime($token->sale_start_date)) : '') }}" class="form-control" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="sale_end_date">@lang('Sale End Date') <sup class="text-danger">*</sup></label>
                                            <input type="date" name="sale_end_date" id="sale_end_date" value="{{ old('sale_end_date', $token->sale_end_date ? date('Y-m-d', strtotime($token->sale_end_date)) : '') }}" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5>@lang('Settings')</h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="status">@lang('Status') <sup class="text-danger">*</sup></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="active" {{ old('status', $token->status) == 'active' ? 'selected' : '' }}>@lang('Active')</option>
                                                <option value="paused" {{ old('status', $token->status) == 'paused' ? 'selected' : '' }}>@lang('Paused')</option>
                                                <option value="completed" {{ old('status', $token->status) == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                                <option value="cancelled" {{ old('status', $token->status) == 'cancelled' ? 'selected' : '' }}>@lang('Cancelled')</option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $token->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    @lang('Featured Token')
                                                </label>
                                                <small class="form-text text-muted">@lang('Display prominently on homepage')</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="i-btn btn--primary btn--lg">@lang('Submit')</button>
                            </form>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="preview-section bg-light p-3 rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-primary mb-0">@lang('Token Preview')</h6>
                                            <button type="button" class="btn btn-dark btn-sm">@lang('Create ICO Token')</button>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary">@lang('Token Name'):</span>
                                            <span id="preview-name" class="text-primary fw-bold">{{ $token->name }}</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary">@lang('Symbol'):</span>
                                            <span id="preview-symbol" class="text-primary fw-bold">{{ $token->symbol }}</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary">@lang('Total Supply'):</span>
                                            <span id="preview-supply" class="text-primary fw-bold">{{ getAmount($token->total_supply) }} tokens</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary">@lang('Price per Token'):</span>
                                            <span id="preview-price" class="text-primary fw-bold">${{ getAmount($token->price) }}</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary">@lang('Current Price'):</span>
                                            <span id="preview-current-price" class="text-primary fw-bold">${{ getAmount($token->current_price) }}</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between">
                                            <span class="text-primary">@lang('Maximum Possible Raise'):</span>
                                            <span id="preview-max-raise" class="text-primary fw-bold">${{ number_format($token->total_supply * $token->price) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('script-push')
    <script>
        "use strict";
        $(document).ready(function () {
            function updatePreview() {
                var name = $('#name').val() || '-';
                var symbol = $('#symbol').val() || '-';
                var totalSupply = $('#total_supply').val() || '0';
                var price = $('#price').val() || '0';
                var currentPrice = $('#current_price').val() || '0';

                $('#preview-name').text(name);
                $('#preview-symbol').text(symbol);
                $('#preview-supply').text(totalSupply ? totalSupply + ' tokens' : '-');
                $('#preview-price').text(price ? '$' + price : '-');
                $('#preview-current-price').text(currentPrice ? '$' + currentPrice : '$0');

                if (totalSupply && price) {
                    var maxRaise = parseFloat(totalSupply) * parseFloat(price);
                    $('#preview-max-raise').text('$' + maxRaise.toLocaleString());
                } else {
                    $('#preview-max-raise').text('$0');
                }
            }

            $('#name, #symbol, #total_supply, #price, #current_price').on('keyup input', function() {
                updatePreview();
            });

            $('#sale_start_date').on('change', function() {
                var startDate = $(this).val();
                $('#sale_end_date').attr('min', startDate);

                var endDate = $('#sale_end_date').val();
                if (endDate && endDate < startDate) {
                    $('#sale_end_date').val('');
                }
            });

            $('#sale_end_date').on('change', function() {
                var endDate = $(this).val();
                var startDate = $('#sale_start_date').val();

                if (startDate && endDate < startDate) {
                    alert('@lang("End date cannot be earlier than start date")');
                    $(this).val('');
                }
            });

            updatePreview();
        });
    </script>
@endpush
