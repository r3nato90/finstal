@php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
@endphp

@extends('layouts.auth')
@section('content')
    <main>
        <div class="form-section white img-adjust">
            <div class="linear-center"></div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-10 position-relative">
                        <div class="eth-icon">
                            <img src="{{ displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'first_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="bnb-icon">
                            <img src="{{ displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'second_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="ada-icon">
                            <img src="{{ displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'third_crypto_coin'), "450X450") }}" alt="image">
                        </div>
                        <div class="sol-icon">
                            <img src="{{ displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'fourth_crypto_coin'), "450X450") }}" alt="image">
                        </div>

                        <div class="form-wrapper">
                            <h5 class="form-title">{{ __('Two Factor Authentication') }}</h5>
                            <p class="text-muted mb-4">{{ __('Please enter the 6-digit code from your authenticator app') }}</p>

                            <form method="POST" action="{{ route('auth.2fa.verify.post') }}" id="totpForm">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="code">{{ __('Authentication Code') }}</label>
                                            <input type="text"
                                                   id="code"
                                                   name="code"
                                                   placeholder="000000"
                                                   maxlength="6"
                                                   class="text-center"
                                                   style="letter-spacing: 3px; font-size: 18px;"
                                                   autocomplete="one-time-code"
                                                   required
                                                   autofocus>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="i-btn btn--lg btn--primary w-100" type="submit">
                                            {{ __('Verify') }}
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="text-center mt-4 pt-3 border-top">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-muted text-decoration-none p-0">
                                        <i class="fas fa-sign-out-alt me-1"></i>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
