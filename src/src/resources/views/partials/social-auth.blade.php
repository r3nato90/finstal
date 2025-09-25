@php
    $googleLoginActive = \App\Models\Setting::get('google_status', 1) ;
@endphp

<div class="another-singup">
    <div class="or">{{ __('OR') }}</div>
    <h6>{{ __('Sign Up with') }}</h6>

    <div class="form-social-two">
        @if($googleLoginActive)
            <a href="{{route('google.login')}}" class="google"><i class="bi bi-google"></i>{{ __(ucfirst('google')) }}</a>
        @endif
    </div>
</div>



