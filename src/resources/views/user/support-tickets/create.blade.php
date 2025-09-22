@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('Create Support Ticket') }}</h3>
                    <a href="{{ route('user.support-tickets.index') }}" class="i-btn btn--secondary btn--sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Tickets') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Ticket Details') }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('user.support-tickets.store') }}" enctype="multipart/form-data" id="createTicketForm">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label required">{{ __('Subject') }}</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                               name="subject" value="{{ old('subject') }}"
                                               placeholder="{{ __('Brief description of your issue') }}" required>
                                        @error('subject')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">{{ __('Category') }}</label>
                                        <select name="category" class="form-control @error('category') is-invalid @enderror">
                                            <option value="">{{ __('Select Category') }}</option>
                                            <option value="Technical Issue" {{ old('category') == 'Technical Issue' ? 'selected' : '' }}>{{ __('Technical Issue') }}</option>
                                            <option value="Account" {{ old('category') == 'Account' ? 'selected' : '' }}>{{ __('Account') }}</option>
                                            <option value="Billing" {{ old('category') == 'Billing' ? 'selected' : '' }}>{{ __('Billing') }}</option>
                                            <option value="Trading" {{ old('category') == 'Trading' ? 'selected' : '' }}>{{ __('Trading') }}</option>
                                            <option value="Deposit/Withdrawal" {{ old('category') == 'Deposit/Withdrawal' ? 'selected' : '' }}>{{ __('Deposit/Withdrawal') }}</option>
                                            <option value="General Inquiry" {{ old('category') == 'General Inquiry' ? 'selected' : '' }}>{{ __('General Inquiry') }}</option>
                                            <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                        </select>
                                        @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">{{ __('Priority') }}</label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityLow" value="low"
                                            {{ old('priority', 'medium') == 'low' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-secondary w-100" for="priorityLow">
                                            <i class="fas fa-circle text-secondary"></i>
                                            {{ __('Low') }}
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityMedium" value="medium"
                                            {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-primary w-100" for="priorityMedium">
                                            <i class="fas fa-circle text-primary"></i>
                                            {{ __('Medium') }}
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityHigh" value="high"
                                            {{ old('priority') == 'high' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-warning w-100" for="priorityHigh">
                                            <i class="fas fa-circle text-warning"></i>
                                            {{ __('High') }}
                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityUrgent" value="urgent"
                                            {{ old('priority') == 'urgent' ? 'checked' : '' }}>
                                        <label class="btn btn-outline-danger w-100" for="priorityUrgent">
                                            <i class="fas fa-circle text-danger"></i>
                                            {{ __('Urgent') }}
                                        </label>
                                    </div>
                                </div>
                                @error('priority')
                                <div class="text-danger fs-12 mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label required">{{ __('Description') }}</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          name="description" rows="8" required
                                          placeholder="{{ __('Please provide detailed information about your issue, including any error messages or steps to reproduce the problem.') }}">{{ old('description') }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-white">{{ __('Maximum 5000 characters') }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">{{ __('Attachments') }}</label>
                                <input type="file" class="form-control @error('attachments.*') is-invalid @enderror" name="attachments[]" multiple
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip" id="attachmentInput">
                                <div class="form-text text-white">{{ __('Maximum file size: 10MB. Allowed formats: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP. Maximum 5 files.') }}</div>
                                @error('attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <a href="{{ route('user.support-tickets.index') }}" class="i-btn btn--danger btn--md me-2">
                                    {{ __('Cancel') }}
                                </a>
                                <button type="submit" class="i-btn btn--light btn--md">
                                    <i class="fas fa-paper-plane"></i> {{ __('Create Ticket') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __('Tips for Better Support') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="support-tips">
                            <div class="tip-item mb-3">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span class="ms-2">{{ __('Be specific and detailed about your issue') }}</span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-images text-info"></i>
                                <span class="ms-2">{{ __('Include screenshots if applicable') }}</span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-list-ol text-success"></i>
                                <span class="ms-2">{{ __('List steps to reproduce the problem') }}</span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                <span class="ms-2">{{ __('Include any error messages') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Response Times') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="response-times">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--secondary">{{ __('Low') }}</span>
                                <span>24-48 hours</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--primary">{{ __('Medium') }}</span>
                                <span>12-24 hours</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--warning">{{ __('High') }}</span>
                                <span>4-12 hours</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="badge badge--danger">{{ __('Urgent') }}</span>
                                <span>1-4 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('script-push')
        <script>
            $(document).ready(function() {
                // Form validation
                $('#createTicketForm').on('submit', function(e) {
                    const subject = $('input[name="subject"]').val().trim();
                    const description = $('textarea[name="description"]').val().trim();
                    const priority = $('input[name="priority"]:checked').val();

                    if (!subject || !description || !priority) {
                        e.preventDefault();
                        notify('error', '{{ __("Please fill in all required fields") }}');
                        return false;
                    }

                    if (description.length > 5000) {
                        e.preventDefault();
                        notify('error', '{{ __("Description cannot exceed 5000 characters") }}');
                        return false;
                    }

                    // Validate file count
                    const files = document.getElementById('attachmentInput').files;
                    if (files.length > 5) {
                        e.preventDefault();
                        notify('error', '{{ __("Maximum 5 files allowed") }}');
                        return false;
                    }

                    // Validate file sizes
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            e.preventDefault();
                            notify('error', `{{ __('File too large') }}: ${files[i].name}`);
                            return false;
                        }
                    }
                });

                // Character counter for description
                $('textarea[name="description"]').on('input', function() {
                    const current = $(this).val().length;
                    const max = 5000;
                    const remaining = max - current;

                    let counterText = `${current}/${max} {{ __('characters') }}`;
                    if (remaining < 100) {
                        counterText = `<span class="text-danger">${counterText}</span>`;
                    }

                    $(this).next('.form-text').html(counterText);
                });
            });
        </script>
    @endpush

    @push('style-push')
        <style>
            .support-tips .tip-item {
                display: flex;
                align-items-center;
                font-size: 14px;
            }
            .response-times {
                font-size: 14px;
            }
            .required::after {
                content: ' *';
                color: #dc3545;
            }
        </style>
    @endpush
@endsection
