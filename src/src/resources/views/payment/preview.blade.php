@extends('layouts.user')
@section('content')
    <style>
        .bg--dark {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .bg--dark .main-content {
            background-color: #1a1a1a;
        }

        .bg--dark .page-title {
            color: #ffffff;
        }

        .bg--dark .i-card-sm {
            background-color: #000000;
            border: 1px solid #404040;
        }

        .bg--dark .list-group-item {
            background-color: #000000;
            border-color: #4a4a4a;
            color: #ffffff;
        }

        .bg--dark .form-inner label {
            color: #ffffff;
        }

        .bg--dark .form-inner input {
            background-color: #000000;
            border-color: #5a5a5a;
            color: #ffffff;
        }

        .bg--dark .form-inner input::placeholder {
            color: #999999;
        }

        .bg--dark .form-inner input:focus {
            background-color: #525252;
            border-color: #007bff;
        }

        .bg--dark .form-inner textarea {
            background-color: #000000;
            border-color: #5a5a5a;
            color: #ffffff;
        }

        .bg--dark .form-inner textarea::placeholder {
            color: #999999;
        }

        .bg--dark .form-inner textarea:focus {
            background-color: #525252;
            border-color: #007bff;
        }

        .bg--dark .card-header {
            background-color: #000000;
            border-color: #4a4a4a;
            color: #ffffff;
        }

        .bg--dark .card-body {
            background-color: #000000;
            color: #ffffff;
        }

        .bg--dark .card-body-deposit {
            background-color: #000000;
        }
    </style>

    <div class="main-content bg--dark" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <h5 class="card-header text-center text-white mb-4">{{ __('Payment Details') }}</h5>
                    @if($gateway->type == \App\Enums\Payment\GatewayType::AUTOMATIC->value && $gateway->code == \App\Enums\Payment\GatewayCode::BLOCK_CHAIN->value)
                        <div class="card-body card-body-deposit text-center">
                            <h4 class="my-2"> @lang('PLEASE SEND EXACTLY') <span class="text-success"> {{ $payment->btc_amount }}</span> @lang('BTC')</h4>
                            <h5 class="mb-2">@lang('TO') <span class="text-success"> {{ $payment->btc_wallet ?? '' }}</span></h5>
                            <img src="{{ cryptoQRCode($payment->btc_wallet ?? '') }}" alt="@lang('Image')">
                            <h4 class="text-white bold my-4">@lang('SCAN TO SEND')</h4>
                        </div>
                    @endif

                    @if($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value)
                        <div class="col-lg-12 mb-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Rate') }}
                                    <span>{{ getCurrencySymbol() }}1 =  {{shortAmount($payment->rate)}} {{ $gateway->currency ?? getCurrencyName() }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('TRX') }}
                                    <span>{{ $payment->trx }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Deposit Amount') }}
                                    <span>{{ getCurrencySymbol() }}{{shortAmount($payment->amount)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Charge') }}
                                    <span>{{ getCurrencySymbol() }}{{shortAmount($payment->charge)}}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Final Amount') }}
                                    <span>{{ shortAmount($payment->final_amount * $payment->rate )}} {{ $payment->currency }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ __('Net Credit') }}
                                    <span>{{ getCurrencySymbol() }}{{  shortAmount($payment->final_amount) }}</span>
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="{{ route('user.payment.traditional') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="payment_intent" value="{{ $payment->trx }}">
                            <input type="hidden" name="gateway_code" value="{{ $gateway->code }}">
                            <div class="row">
                                @foreach($gateway->parameter as $key => $parameter)
                                    @php
                                        $parameter = is_array($parameter) ? $parameter : [];
                                    @endphp
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="{{ getArrayFromValue($parameter,'field_label') }}">{{ __(getArrayFromValue($parameter,'field_label')) }}</label>
                                            @if(getArrayFromValue($parameter,'field_type') == 'file')
                                                <input type="file" id="{{ getArrayFromValue($parameter,'field_label') }}" name="{{ getArrayFromValue($parameter,'field_name') }}" required>
                                            @elseif(getArrayFromValue($parameter,'field_type') == 'text')
                                                <input type="text" id="{{ getArrayFromValue($parameter,'field_label') }}" name="{{ getArrayFromValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayFromValue($parameter,'field_label')) }}" required>
                                            @elseif(getArrayFromValue($parameter,'field_type') == 'textarea')
                                                <textarea id="{{ getArrayFromValue($parameter,'field_label') }}" name="{{ getArrayFromValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayFromValue($parameter,'field_label')) }}" required></textarea>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-12">
                                <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
