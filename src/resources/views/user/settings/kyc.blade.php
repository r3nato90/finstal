@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title text-white">{{ __($setTitle) }}</h4>
                    </div>
                    <div class="card-body">
                        @if(!$kyc)
                            <div class="text-center mb-4">
                                <i class="bi bi-shield-check fs-1 text-primary"></i>
                                <h5 class="mt-3 text-white">{{ __('Verify Your Identity') }}</h5>
                                <p class="text-white-50">{{ __('Complete KYC verification to unlock all features and increase your account limits.') }}</p>
                            </div>

                            <form action="{{ route('user.kyc.submit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('user.settings.partials.kyc_form', ['isResubmission' => false])
                            </form>

                        @elseif($kyc->status == 'pending')
                            <div class="alert alert-warning bg-dark border-warning">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history fs-3 text-warning me-3"></i>
                                    <div>
                                        <h6 class="text-warning mb-1">{{ __('Verification Pending') }}</h6>
                                        <p class="mb-0 text-white-50">{{ __('Your documents are under review. We will notify you within 2-3 business days.') }}</p>
                                        <small class="text-white-50">{{ __('Submitted on:') }} {{ $kyc->submitted_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                </div>
                            </div>

                            @include('user.settings.partials.kyc_details')

                        @elseif($kyc->status == 'approved')
                            <div class="alert alert-success bg-dark border-success">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                    <div>
                                        <h6 class="text-success mb-1">{{ __('Identity Verified') }}</h6>
                                        <p class="mb-0 text-white-50">{{ __('Your identity has been successfully verified. You now have access to all platform features.') }}</p>
                                        <small class="text-white-50">{{ __('Approved on:') }} {{ $kyc->reviewed_at->format('M d, Y h:i A') }}</small>
                                    </div>
                                </div>
                            </div>

                            @include('user.settings.partials.kyc_details')
                        @elseif($kyc->status == 'rejected')
                            <div class="alert alert-danger bg-dark border-danger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-x-circle-fill fs-3 text-danger me-3"></i>
                                    <div>
                                        <h6 class="text-danger mb-1">{{ __('Verification Rejected') }}</h6>
                                        <p class="mb-0 text-white-50">{{ __('Your KYC verification was rejected. Please review the reason below and resubmit with correct information.') }}</p>
                                        @if($kyc->rejection_reason)
                                            <div class="mt-2 p-2 bg-danger bg-opacity-10 rounded">
                                                <strong class="text-danger">{{ __('Rejection Reason:') }}</strong>
                                                <p class="mb-0 text-white-50">{{ $kyc->rejection_reason }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('user.kyc.resubmit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @include('user.settings.partials.kyc_form', ['isResubmission' => true])
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
