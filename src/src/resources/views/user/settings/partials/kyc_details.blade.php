<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Submitted Information') }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Full Name') }}</label>
        <p class="text-white mb-0">{{ $kyc->first_name }} {{ $kyc->last_name }}</p>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Date of Birth') }}</label>
        <p class="text-white mb-0">{{ $kyc->date_of_birth->format('M d, Y') }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Phone Number') }}</label>
        <p class="text-white mb-0">{{ $kyc->phone }}</p>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Document Type') }}</label>
        <p class="text-white mb-0">{{ ucwords(str_replace('_', ' ', $kyc->document_type)) }}</p>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label class="form-label text-white-50">{{ __('Address') }}</label>
        <p class="text-white mb-0">
            {{ $kyc->address }}<br>
            {{ $kyc->city }}, {{ $kyc->state }} {{ $kyc->postal_code }}<br>
            {{ $kyc->country }}
        </p>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Document Number') }}</label>
        <p class="text-white mb-0">{{ $kyc->document_number }}</p>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label text-white-50">{{ __('Submission Date') }}</label>
        <p class="text-white mb-0">{{ $kyc->submitted_at->format('M d, Y h:i A') }}</p>
    </div>
</div>

@if($kyc->status == 'approved' && $kyc->reviewed_at)
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label text-white-50">{{ __('Approved Date') }}</label>
            <p class="text-white mb-0">{{ $kyc->reviewed_at->format('M d, Y h:i A') }}</p>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Uploaded Documents') }}</h6>
    </div>
</div>

<div class="row">
    @if($kyc->document_front_path)
        <div class="col-md-4 mb-3">
            <div class="card bg-dark border-secondary">
                <div class="card-body text-center">
                    <h6 class="text-white mb-3 mt-3">{{ __('Document Front') }}</h6>
                    <a target="_blank" class="i-btn btn--primary btn--sm"
                       href="{{ asset('assets/files/'.$kyc->document_front_path) }}">
                        {{ __('View') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($kyc->document_back_path)
        <div class="col-md-4 mb-3">
            <div class="card bg-dark border-secondary">
                <div class="card-body text-center">
                    <h6 class="text-white mb-3 mt-3">{{ __('Document Back') }}</h6>
                    <a target="_blank" class="i-btn btn--primary btn--sm"
                       href="{{ asset('assets/files/'.$kyc->document_back_path) }}">
                        {{ __('View') }}
                    </a>
                </div>
            </div>
        </div>
    @endif

    @if($kyc->selfie_path)
        <div class="col-md-4 mb-3">
            <div class="card bg-dark border-secondary">
                <div class="card-body text-center">
                    <h6 class="text-white mb-3 mt-3">{{ __('Selfie with Document') }}</h6>
                    <a target="_blank" class="i-btn btn--primary btn--sm"
                            href="{{ asset('assets/files/'.$kyc->selfie_path) }}">
                        {{ __('View') }}
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="modal fade" id="documentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bg-dark">
            <div class="modal-header border-secondary">
                <h5 class="modal-title text-white" id="documentModalLabel"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="documentImage" src="" alt="Document" class="img-fluid rounded">
            </div>
        </div>
    </div>
</div>
