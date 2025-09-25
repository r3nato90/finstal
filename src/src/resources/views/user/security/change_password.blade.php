@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mx-auto">
                                <form action="{{ route('user.update.password') }}" method="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="current_password" class="form-label text-white">{{ __('Current Password') }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                                   id="current_password" name="current_password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                                <i class="bi bi-eye text-white" id="current_password_icon"></i>
                                            </button>
                                        </div>
                                        @error('current_password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label text-white">{{ __('New Password') }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                                   id="password" name="password" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                                <i class="bi bi-eye text-white" id="password_icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text text-white-50">
                                            {{ __('Password must be at least 8 characters long') }}
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label text-white">{{ __('Confirm New Password') }}</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                   id="password_confirmation" name="password_confirmation" required>
                                            <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                                <i class="bi bi-eye text-white" id="password_confirmation_icon"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="password-strength-meter mb-3" style="display: none;">
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                        </div>
                                        <small class="text-white-50 strength-text"></small>
                                    </div>

                                    <div class="d-grid">
                                        <button type="submit" class="i-btn btn--primary btn--sm">
                                            <i class="bi bi-key me-2"></i>{{ __('Update Password') }}
                                        </button>
                                    </div>
                                </form>

                                <div class="mt-4">
                                    <div class="alert alert-info bg-dark border-info">
                                        <h6 class="alert-heading text-white">{{ __('Password Security Tips:') }}</h6>
                                        <ul class="mb-0 small text-white-50">
                                            <li>{{ __('Use at least 8 characters') }}</li>
                                            <li>{{ __('Include uppercase and lowercase letters') }}</li>
                                            <li>{{ __('Include numbers and special characters') }}</li>
                                            <li>{{ __('Avoid using personal information') }}</li>
                                            <li>{{ __('Do not reuse passwords from other accounts') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(fieldId + '_icon');

            if (field.type === 'password') {
                field.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                field.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }

        // Password strength checker
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const meter = document.querySelector('.password-strength-meter');
            const progressBar = meter.querySelector('.progress-bar');
            const strengthText = meter.querySelector('.strength-text');

            if (password.length === 0) {
                meter.style.display = 'none';
                return;
            }

            meter.style.display = 'block';

            let strength = 0;
            let text = '';
            let color = '';

            // Length check
            if (password.length >= 8) strength += 20;

            // Lowercase check
            if (/[a-z]/.test(password)) strength += 20;

            // Uppercase check
            if (/[A-Z]/.test(password)) strength += 20;

            // Number check
            if (/[0-9]/.test(password)) strength += 20;

            // Special character check
            if (/[^a-zA-Z0-9]/.test(password)) strength += 20;

            if (strength < 40) {
                text = 'Weak';
                color = 'bg-danger';
            } else if (strength < 80) {
                text = 'Medium';
                color = 'bg-warning';
            } else {
                text = 'Strong';
                color = 'bg-success';
            }

            progressBar.style.width = strength + '%';
            progressBar.className = 'progress-bar ' + color;
            strengthText.textContent = text;
        });
    </script>
@endsection
