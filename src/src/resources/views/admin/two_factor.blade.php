@extends('admin.layouts.main')

@section('panel')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">{{ __('Two Factor Authentication') }}</h5>
                </div>
                <div class="card-body">
                    @if(!auth('admin')->user()->two_factor_secret)
                        <!-- Enable 2FA Section -->
                        <div class="alert alert-info">
                            <i class="las la-info-circle"></i>
                            Two-factor authentication adds an extra layer of security to your account.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Step 1: Scan QR Code</h6>
                                <p class="text-muted">Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.)</p>
                                @if($qrCode)
                                    <img src="{{ $qrCode }}" alt="QR Code" class="img-fluid mb-3">
                                @endif

                                <p class="small text-muted">
                                    <strong>Secret Key:</strong><br>
                                    <code>{{ $secret }}</code>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>Step 2: Verify Code</h6>
                                <p class="text-muted">Enter the 6-digit code from your authenticator app</p>

                                <form action="{{ route('admin.two-factor.enable') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="secret" value="{{ $secret }}">

                                    <div class="mb-3">
                                        <label class="form-label">Verification Code</label>
                                        <input type="text" name="code" class="form-control" maxlength="6" placeholder="000000" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">
                                        <i class="las la-check"></i> Enable Two Factor
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <!-- 2FA Enabled Section -->
                        <div class="alert alert-success">
                            <i class="las la-check-circle"></i>
                            Two-factor authentication is enabled on your account.
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h6>Recovery Codes</h6>
                                <p class="text-muted">Save these recovery codes in a safe place. They can be used to access your account if you lose your authenticator device.</p>

                                @if($recoveryCodes)
                                    <div class="bg-light p-3 rounded">
                                        @foreach($recoveryCodes as $code)
                                            <code class="d-block">{{ $code }}</code>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6>Disable Two Factor</h6>
                                <p class="text-muted">Enter your password to disable two-factor authentication.</p>

                                <form action="{{ route('admin.two-factor.disable') }}" method="POST" onsubmit="return confirm('Are you sure you want to disable two-factor authentication?')">
                                    @csrf
                                    @method('DELETE')

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-danger">
                                        <i class="las la-times"></i> Disable Two Factor
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
