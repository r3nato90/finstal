@php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SIGN_UP, \App\Enums\Frontend\Content::FIXED);
    $referral = null;
    if(request()->get('ref')) {
        $referral = \App\Models\User::where('uuid', request()->get('ref'))->first();
    }
@endphp

@extends('layouts.auth')
@section('content')
    <main>
        <div class="form-section white img-adjust">
            <div class="form-bg">
                <img src="{{ displayImage(getArrayFromValue($fixedContent?->meta, 'background_image'), "1920x1080") }}" alt="{{ __('Background image') }}">
            </div>
            <div class="linear-center"></div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-left">
                            <a href="{{route('home')}}" class="logo" data-cursor="Home">
                                <img src="{{ displayImage($logo_white, "592x89") }}" alt="{{ __("Logo") }}">
                            </a>
                            <h1>{{ getArrayFromValue($fixedContent?->meta, 'title') }}</h1>
                            <p> {{ getArrayFromValue($fixedContent?->meta, 'details') }} </p>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative">
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
                        <div class="form-wrapper2 login-form">
                            <h4 class="form-title">{{ __('Sign Up Your Account') }}</h4>
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                @if(request()->get('ref'))
                                    <input type="hidden" name="ref" value="{{ request()->get('ref') }}">
                                @endif

                                <div class="row">
                                    @if($referral)
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                {{ __("You are registering with referral from") }} <strong>{{ $referral->fullname }}</strong>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="name">{{ (__('Name')) }}</label>
                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="{{ __('Enter Name') }}"
                                                   class="@error('name') is-invalid @enderror"
                                                   required>
                                            @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="email">{{ __('Email') }}</label>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="{{ __('Enter Email') }}"
                                                   class="@error('email') is-invalid @enderror"
                                                   required>
                                            @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password">{{ __('Password') }}</label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   autocomplete="new-password"
                                                   placeholder="{{ __('Enter Password (min 8 characters)') }}"
                                                   class="@error('password') is-invalid @enderror"
                                                   required>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                                            <input type="password"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   autocomplete="new-password"
                                                   placeholder="{{ __('Enter Confirm Password') }}"
                                                   class="@error('password_confirmation') is-invalid @enderror"
                                                   required>
                                            @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button type="submit" value="Register" class="i-btn btn--lg btn--primary w-100">
                                            {{ __('Sign Up') }}
                                        </button>
                                    </div>
                                </div>

                                <div class="have-account">
                                    <p class="mb-0">{{ __('Already registered?') }} <a href="{{route('login')}}"> {{ __('Sign In') }}</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
