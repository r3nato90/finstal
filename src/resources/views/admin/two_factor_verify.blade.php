@extends('admin.layouts.auth')
@section('content')
    <div class="login-content row g-0 justify-content-center">
        <div class="col-xl-5 col-lg-6 order-lg-2 order-1">
            <div class="form-wrapper-one flex-column rounded-4">
                <div class="logo-area text-center mb-40">
                    <img src="{{ displayImage($logo_white, "592x89") }}" alt="Site-Logo" border="0">
                    <h4>{{__('Two Factor Authentication')}}</h4>
                    <p class="text-muted">{{__('Please enter the 6-digit code from your authenticator app')}}</p>
                </div>
                <form action="{{route('admin.two-factor.verify')}}" method="POST">
                    @csrf
                    <div class="form-inner">
                        <label for="code">{{__('Verification Code')}}</label>
                        <input type="text" id="code" name="code" placeholder="000000" maxlength="6" class="text-center" style="letter-spacing: 3px; font-size: 18px;" required />
                    </div>
                    <button type="submit" class="btn btn--dark btn--lg w-100">{{__('Verify')}}</button>
                </form>

                <div class="text-center mt-3">
                    <p class="text-muted">{{__('Lost your device?')}}</p>
                    <a href="#" onclick="toggleRecoveryForm()" class="text-decoration-none">{{__('Use recovery code')}}</a>
                </div>

                <!-- Recovery Code Form (Hidden by default) -->
                <div id="recoveryForm" style="display: none;" class="mt-3">
                    <form action="{{route('admin.two-factor.recovery')}}" method="POST">
                        @csrf
                        <div class="form-inner">
                            <label for="recovery_code">{{__('Recovery Code')}}</label>
                            <input type="text" id="recovery_code" name="recovery_code" placeholder="XXXX-XXXX" class="text-center" required />
                        </div>
                        <button type="submit" class="btn btn--secondary btn--lg w-100">{{__('Use Recovery Code')}}</button>
                    </form>
                    <div class="text-center mt-2">
                        <a href="#" onclick="toggleRecoveryForm()" class="text-decoration-none">{{__('Back to authenticator')}}</a>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <a href="{{route('admin.logout')}}" class="text-decoration-none text-muted">{{__('Logout')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        function toggleRecoveryForm() {
            const recoveryForm = document.getElementById('recoveryForm');
            const isHidden = recoveryForm.style.display === 'none';
            recoveryForm.style.display = isHidden ? 'block' : 'none';
        }
    </script>
@endpush
