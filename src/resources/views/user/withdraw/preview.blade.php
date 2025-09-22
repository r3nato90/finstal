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

        .bg--dark .form-inner label {
            color: #ffffff;
        }

        .bg--dark .form-inner input,
        .bg--dark .form-inner textarea {
            background-color: #000000;
            border-color: #5a5a5a;
            color: #ffffff;
        }

        .bg--dark .form-inner input::placeholder,
        .bg--dark .form-inner textarea::placeholder {
            color: #999999;
        }

        .bg--dark .form-inner input:focus,
        .bg--dark .form-inner textarea:focus {
            background-color: #525252;
            border-color: #007bff;
        }

        .bg--dark .instruction-box {
            background-color: #0d1117;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .bg--dark .instruction-box h6 {
            color: #dadada;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .bg--dark .instruction-box p {
            color: #cccccc;
            margin: 0;
            line-height: 1.6;
            white-space: pre-wrap;
        }
    </style>

    <div class="main-content bg--dark" data-simplebar>
        <h3 class="page-title">{{ __($setTitle) }}</h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">

                    <div class="gateway-info">
                        <h6>{{ __('Withdraw Method Information') }}</h6>
                        <p><strong>{{ __('Method Name') }}:</strong> {{ $withdrawLog->withdrawMethod->name }}</p>
                        <p><strong>{{ __('Currency') }}:</strong> {{ $withdrawLog->withdrawMethod->currency_name ?? getCurrencyName() }}</p>
                        <p><strong>{{ __('Min Limit') }}:</strong> {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->withdrawMethod->min_limit) }}</p>
                        <p><strong>{{ __('Max Limit') }}:</strong> {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->withdrawMethod->max_limit) }}</p>
                        <p><strong>{{ __('Fixed Charge') }}:</strong> {{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->withdrawMethod->fixed_charge) }}</p>
                        <p><strong>{{ __('Percent Charge') }}:</strong> {{ shortAmount($withdrawLog->withdrawMethod->percent_charge) }}%</p>
                    </div>

                    @if($withdrawLog->withdrawMethod->instruction)
                        <div class="instruction-box">
                            <h6>{{ __('Instructions') }}</h6>
                            <p>{{ $withdrawLog->withdrawMethod->instruction }}</p>
                        </div>
                    @endif


                    <div class="col-lg-12 mb-4">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Gateway') }}
                                <span class="fw-bold">  {{ $withdrawLog->withdrawMethod->name ?? 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Trx') }}
                                <span class="fw-bold">{{ $withdrawLog->trx }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Rate') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}1 =  {{shortAmount($withdrawLog->rate)}} {{ $withdrawLog?->withdrawMethod?->currency_name ?? getCurrencyName() }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Withdraw Amount') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{ shortAmount($withdrawLog->amount) }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Charge') }}
                                <span class="fw-bold">{{ getCurrencySymbol().shortAmount($withdrawLog->charge) }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Ico Token') }}
                                <span class="fw-bold">
                                    {{ $withdrawLog->is_ico_wallet ? shortAmount($withdrawLog->ico_token).' '.$withdrawLog->icoWallet->token->symbol ?? '' : 'N/A' }}
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Final Amount') }}
                                <span class="fw-bold">{{shortAmount($withdrawLog->final_amount)}} {{ $withdrawLog?->currency }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ __('Net Credit') }}
                                <span class="fw-bold">{{ getCurrencySymbol() }}{{shortAmount($withdrawLog->after_charge)}}</span>
                            </li>
                        </ul>
                    </div>

                    <form method="POST" action="{{route('user.withdraw.success', $uid)}}">
                        @csrf
                        @if(!is_null($withdrawLog?->withdrawMethod->parameter))
                            <div class="row">
                                @foreach($withdrawLog?->withdrawMethod->parameter as $key => $parameter)
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="{{ getArrayFromValue($parameter,'field_label') }}">{{ __(getArrayFromValue($parameter,'field_label')) }}</label>
                                            <input type="text" id="{{ getArrayFromValue($parameter,'field_label') }}" name="{{ getArrayFromValue($parameter,'field_name') }}" placeholder="{{ __("Enter ". getArrayFromValue($parameter,'field_label')) }}" required>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="col-12">
                            <button type="submit" class="i-btn btn--primary btn--lg">{{ __('Save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
