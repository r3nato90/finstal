<div class="row">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Personal Information') }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="first_name" class="form-label text-white">{{ __('First Name') }}</label>
        <input type="text" class="form-control @error('first_name') is-invalid @enderror"
               id="first_name" name="first_name"
               value="{{ old('first_name', $isResubmission && $kyc ? $kyc->first_name : '') }}" required>
        @error('first_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="last_name" class="form-label text-white">{{ __('Last Name') }}</label>
        <input type="text" class="form-control @error('last_name') is-invalid @enderror"
               id="last_name" name="last_name"
               value="{{ old('last_name', $isResubmission && $kyc ? $kyc->last_name : '') }}" required>
        @error('last_name')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="date_of_birth" class="form-label text-white">{{ __('Date of Birth') }}</label>
        <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
               id="date_of_birth" name="date_of_birth"
               value="{{ old('date_of_birth', $isResubmission && $kyc ? $kyc->date_of_birth->format('Y-m-d') : '') }}" required>
        @error('date_of_birth')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="phone" class="form-label text-white">{{ __('Phone Number') }}</label>
        <input type="tel" class="form-control @error('phone') is-invalid @enderror"
               id="phone" name="phone"
               value="{{ old('phone', $isResubmission && $kyc ? $kyc->phone : '') }}" required>
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Address Information') }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-12 mb-3">
        <label for="address" class="form-label text-white">{{ __('Street Address') }}</label>
        <textarea class="form-control @error('address') is-invalid @enderror"
                  id="address" name="address" rows="3" required>{{ old('address', $isResubmission && $kyc ? $kyc->address : '') }}</textarea>
        @error('address')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="city" class="form-label text-white">{{ __('City') }}</label>
        <input type="text" class="form-control @error('city') is-invalid @enderror"
               id="city" name="city"
               value="{{ old('city', $isResubmission && $kyc ? $kyc->city : '') }}" required>
        @error('city')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="state" class="form-label text-white">{{ __('State/Province') }}</label>
        <input type="text" class="form-control @error('state') is-invalid @enderror"
               id="state" name="state"
               value="{{ old('state', $isResubmission && $kyc ? $kyc->state : '') }}" required>
        @error('state')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="country" class="form-label text-white">{{ __('Country') }}</label>
        <select class="form-control @error('country') is-invalid @enderror" id="country" name="country" required>
            <option value="">{{ __('Select Country') }}</option>
            @foreach($countries as $country)
                <option value="{{ $country }}"
                    {{ old('country', $isResubmission && $kyc ? $kyc->country : '') == $country ? 'selected' : '' }}>
                    {{ $country }}
                </option>
            @endforeach
        </select>
        @error('country')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="postal_code" class="form-label text-white">{{ __('Postal Code') }}</label>
        <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
               id="postal_code" name="postal_code"
               value="{{ old('postal_code', $isResubmission && $kyc ? $kyc->postal_code : '') }}" required>
        @error('postal_code')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Identity Document') }}</h6>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label for="document_type" class="form-label text-white">{{ __('Document Type') }}</label>
        <select class="form-control @error('document_type') is-invalid @enderror" id="document_type" name="document_type" required>
            <option value="">{{ __('Select Document Type') }}</option>
            <option value="passport"
                {{ old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'passport' ? 'selected' : '' }}>
                {{ __('Passport') }}
            </option>
            <option value="driver_license"
                {{ old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'driver_license' ? 'selected' : '' }}>
                {{ __('Driver License') }}
            </option>
            <option value="national_id"
                {{ old('document_type', $isResubmission && $kyc ? $kyc->document_type : '') == 'national_id' ? 'selected' : '' }}>
                {{ __('National ID') }}
            </option>
        </select>
        @error('document_type')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label for="document_number" class="form-label text-white">{{ __('Document Number') }}</label>
        <input type="text" class="form-control @error('document_number') is-invalid @enderror"
               id="document_number" name="document_number"
               value="{{ old('document_number', $isResubmission && $kyc ? $kyc->document_number : '') }}" required>
        @error('document_number')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <h6 class="text-white mb-3">{{ __('Document Upload') }}</h6>
        <p class="text-white-50 small">{{ __('Please upload clear, high-quality images. Maximum file size: 10MB per image.') }}</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label for="document_front" class="form-label text-white">
            {{ __('Document Front') }} <span class="text-danger">*</span>
        </label>
        <input type="file" class="form-control @error('document_front') is-invalid @enderror"
               id="document_front" name="document_front" accept="image/*" {{ !$isResubmission ? 'required' : '' }}>
        @error('document_front')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if($isResubmission && $kyc && $kyc->document_front_path)
            <div class="mt-2">
                <small class="text-white-50">{{ __('Current file uploaded') }}</small>
            </div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="document_back" class="form-label text-white">
            {{ __('Document Back') }} <span class="text-white-50">({{ __('If applicable') }})</span>
        </label>
        <input type="file" class="form-control @error('document_back') is-invalid @enderror"
               id="document_back" name="document_back" accept="image/*">
        @error('document_back')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if($isResubmission && $kyc && $kyc->document_back_path)
            <div class="mt-2">
                <small class="text-white-50">{{ __('Current file uploaded') }}</small>
            </div>
        @endif
    </div>

    <div class="col-md-4 mb-3">
        <label for="selfie" class="form-label text-white">
            {{ __('Selfie with Document') }} <span class="text-danger">*</span>
        </label>
        <input type="file" class="form-control @error('selfie') is-invalid @enderror"
               id="selfie" name="selfie" accept="image/*" {{ !$isResubmission ? 'required' : '' }}>
        @error('selfie')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        @if($isResubmission && $kyc && $kyc->selfie_path)
            <div class="mt-2">
                <small class="text-white-50">{{ __('Current file uploaded') }}</small>
            </div>
        @endif
    </div>
</div>

<div class="row mt-3">
    <div class="col-12">
        <div class="alert alert-info bg-dark border-info">
            <h6 class="text-info">{{ __('Upload Guidelines:') }}</h6>
            <ul class="mb-0 small text-white-50">
                <li>{{ __('Ensure all text on the document is clearly readable') }}</li>
                <li>{{ __('Document should be well-lit and in focus') }}</li>
                <li>{{ __('For selfie: Hold your document next to your face') }}</li>
                <li>{{ __('Accepted formats: JPG, JPEG, PNG') }}</li>
                <li>{{ __('Maximum file size: 10MB per image') }}</li>
            </ul>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-shield-check me-2"></i>
                {{ $isResubmission ? __('Resubmit KYC Verification') : __('Submit KYC Verification') }}
            </button>
        </div>
    </div>
</div>
