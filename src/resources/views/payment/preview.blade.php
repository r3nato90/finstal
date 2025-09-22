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

        .bg--dark .gateway-image {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            margin: 0 auto 20px auto;
            border: 1px solid #404040;
            display: block;
        }

        .bg--dark .card-header {
            background-color: #000000;
            border-color: #4a4a4a;
            color: #ffffff;
        }

        .bg--dark .gateway-details {
            background-color: #111111;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .bg--dark .gateway-info {
            background-color: #0d1117;
            border-left: 4px solid #efefef;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 6px 6px 0;
            text-align: center;
        }

        .bg--dark .gateway-info h6 {
            color: #dadada;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .bg--dark .gateway-info p {
            color: #cccccc;
            margin: 8px 0;
            line-height: 1.5;
        }
    </style>

    <div class="main-content bg--dark" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <h5 class="card-header text-center text-white mb-4">{{ __('Payment Details') }}</h5>
                    <div class="text-center mb-4">
                        <img src="{{ displayImage($gateway->file, '200x150') }}"
                             alt="{{ $gateway->name }}"
                             class="gateway-image">
                    </div>

                    <div class="gateway-info">
                        <h6>{{ __('Gateway Information') }}</h6>
                        <p><strong>{{ __('Name') }}:</strong> {{ $gateway->name }}</p>
                        <p><strong>{{ __('Code') }}:</strong> {{ $gateway->code }}</p>
                        <p><strong>{{ __('Currency') }}:</strong> {{ $gateway->currency ?? getCurrencyName() }}</p>
                        <p><strong>{{ __('Type') }}:</strong> {{ $gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value ? 'Manual' : 'Automatic' }}</p>
                        @if($gateway->details)
                            <p><strong>{{ __('Details') }}:</strong> {{ $gateway->details }}</p>
                        @endif
                    </div>

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
