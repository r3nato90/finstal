@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        @if(!auth()->user()->two_factor_secret)
                            <!-- Enable 2FA -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="text-center mb-4">
                                        <h5 class="text-white">{{ __('Scan QR Code') }}</h5>
                                        <p class="text-white-50">{{ __('Scan this QR code with your authenticator app') }}</p>
                                        <div class="qr-code-container mb-3">
                                            @if($qrCode)
                                                <img src="{{ $qrCode }}" alt="QR Code" class="img-fluid" style="max-width: 200px;"
                                                     onerror="this.style.display='none'; document.getElementById('qr-error').style.display='block';">
                                                <div id="qr-error" style="display: none;" class="alert alert-warning mt-2">
                                                    <strong>QR Code Error:</strong> Please use manual entry below.
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    <strong>QR Code Unavailable:</strong> Please use manual entry below.
                                                </div>
                                            @endif
                                        </div>
                                        <div class="alert alert-info">
                                            <strong class="text-dark">{{ __('Manual Entry:') }}</strong><br>
                                            <code class="text-dark">{{ $secret }}</code>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-white">{{ __('Verify Setup') }}</h5>
                                    <p class="text-white-50">{{ __('Enter the 6-digit code from your authenticator app') }}</p>

                                    <form action="{{ route('user.two.factor.enable') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="secret" value="{{ $secret }}">

                                        <div class="mb-3">
                                            <label for="code" class="form-label text-white">{{ __('Verification Code') }}</label>
                                            <input type="text" class="form-control @error('code') is-invalid @enderror"
                                                   id="code" name="code" placeholder="000000" maxlength="6" required>
                                            @error('code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="i-btn btn--primary btn--sm">
                                            <i class="bi bi-shield-check me-2"></i>{{ __('Enable Two-Factor Authentication') }}
                                        </button>
                                    </form>

                                    <div class="mt-4">
                                        <h6 class="text-white">{{ __('Recommended Apps:') }}</h6>
                                        <ul class="list-unstyled">
                                            <li><i class="bi bi-check-circle text-success me-2"></i><span class="text-white-50">Google Authenticator</span></li>
                                            <li><i class="bi bi-check-circle text-success me-2"></i><span class="text-white-50">Microsoft Authenticator</span></li>
                                            <li><i class="bi bi-check-circle text-success me-2"></i><span class="text-white-50">Authy</span></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @else
                            <!-- 2FA Already Enabled -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="alert alert-success">
                                        <i class="bi bi-shield-check me-2"></i>
                                        <strong>{{ __('Two-Factor Authentication is Enabled') }}</strong><br>
                                        {{ __('Your account is protected with two-factor authentication.') }}
                                    </div>

                                    @if($recoveryCodes)
                                        <div class="card bg-dark border-secondary">
                                            <div class="card-header bg-dark border-secondary">
                                                <h6 class="mb-0 text-white">{{ __('Recovery Codes') }}</h6>
                                            </div>
                                            <div class="card-body bg-dark">
                                                <p class="text-white-50 small">{{ __('Store these codes in a safe place. They can be used to access your account if you lose your authenticator device.') }}</p>
                                                <div class="row">
                                                    @foreach($recoveryCodes as $code)
                                                        <div class="col-6 mb-2">
                                                            <code class="text-warning">{{ $code }}</code>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <h5 class="text-white">{{ __('Disable Two-Factor Authentication') }}</h5>
                                    <p class="text-white-50">{{ __('Enter your password to disable two-factor authentication') }}</p>

                                    <form action="{{ route('user.two.factor.disable') }}" method="POST">
                                        @csrf

                                        <div class="mb-3">
                                            <label for="password" class="form-label text-white">{{ __('Current Password') }}</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" required>
                                            @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button type="submit" class="i-btn btn--danger btn--sm">
                                            <i class="bi bi-shield-x me-2"></i>{{ __('Disable Two-Factor Authentication') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
