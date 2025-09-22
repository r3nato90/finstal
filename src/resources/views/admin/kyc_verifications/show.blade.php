@extends('admin.layouts.main')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-header d-flex flex-wrap align-items-center justify-content-between">
                    <h6 class="card-title mb-0">{{ __('KYC Verification Details') }}</h6>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.kyc-verifications.index') }}" class="btn btn-sm btn--secondary">
                            <i class="la la-arrow-left"></i> {{ __('Back') }}
                        </a>
                        <a href="{{ route('admin.kyc-verifications.download', $kycVerification->id) }}" class="btn btn-sm btn--primary">
                            <i class="la la-download"></i> {{ __('Download') }}
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ __('User Information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p><strong>{{ __('Name:') }}</strong> {{ @$kycVerification->user->name ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Email:') }}</strong> {{ @$kycVerification->user->email ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Mobile:') }}</strong> {{ @$kycVerification->user->mobile ?? 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><strong>{{ __('Status:') }}</strong>
                                                @if($kycVerification->status == 'pending')
                                                    <span class="badge badge--warning">{{ __('Pending') }}</span>
                                                @elseif($kycVerification->status == 'approved')
                                                    <span class="badge badge--success">{{ __('Approved') }}</span>
                                                @elseif($kycVerification->status == 'rejected')
                                                    <span class="badge badge--danger">{{ __('Rejected') }}</span>
                                                @endif
                                            </p>
                                            <p><strong>{{ __('Submitted:') }}</strong> {{ showDateTime($kycVerification->submitted_at) }}</p>
                                            @if($kycVerification->reviewed_at)
                                                <p><strong>{{ __('Reviewed:') }}</strong> {{ showDateTime($kycVerification->reviewed_at) }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($kycVerification->rejection_reason)
                                        <div class="alert alert-danger mt-3">
                                            <strong>{{ __('Rejection Reason:') }}</strong><br>
                                            {{ $kycVerification->rejection_reason }}
                                        </div>
                                    @endif

                                    <!-- Status Action Buttons -->
                                    @if($kycVerification->status == 'pending')
                                        <div class="mt-3">
                                            <button type="button" class="btn btn--success btn-sm" onclick="updateStatus({{ $kycVerification->id }}, 'approved')">
                                                <i class="la la-check"></i> {{ __('Approve') }}
                                            </button>
                                            <button type="button" class="btn btn--danger btn-sm" onclick="rejectVerification({{ $kycVerification->id }})">
                                                <i class="la la-times"></i> {{ __('Reject') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Personal Information -->
                        <div class="col-lg-6">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ __('Personal Information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <p><strong>{{ __('First Name:') }}</strong> {{ $kycVerification->first_name ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Last Name:') }}</strong> {{ $kycVerification->last_name ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Phone:') }}</strong> {{ $kycVerification->phone ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Date of Birth:') }}</strong> {{ $kycVerification->date_of_birth ? showDateTime($kycVerification->date_of_birth, 'd M, Y') : 'N/A' }}</p>
                                        </div>
                                        <div class="col-6">
                                            <p><strong>{{ __('City:') }}</strong> {{ $kycVerification->city ?? 'N/A' }}</p>
                                            <p><strong>{{ __('State:') }}</strong> {{ $kycVerification->state ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Country:') }}</strong> {{ $kycVerification->country ?? 'N/A' }}</p>
                                            <p><strong>{{ __('Postal Code:') }}</strong> {{ $kycVerification->postal_code ?? 'N/A' }}</p>
                                        </div>
                                    </div>

                                    @if($kycVerification->address)
                                        <p><strong>{{ __('Address:') }}</strong> {{ $kycVerification->address }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Information -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card border mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">{{ __('Document Information') }}</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p><strong>{{ __('Document Type:') }}</strong>
                                                <span class="badge badge--primary">{{ __(ucfirst(str_replace('_', ' ', $kycVerification->document_type))) }}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>{{ __('Document Number:') }}</strong> {{ $kycVerification->document_number ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Update Status') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="status" id="statusInput">
                        <p id="statusMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn--primary">{{ __('Update') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rejection Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{ __('Reject Verification') }}</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" name="status" value="rejected">
                        <div class="form-group">
                            <label class="form-label required">{{ __('Rejection Reason') }}</label>
                            <textarea name="rejection_reason" class="form-control" rows="3" placeholder="{{ __('Enter reason...') }}" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn--danger">{{ __('Reject') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        function updateStatus(id, status) {
            const form = document.getElementById('statusForm');
            const statusInput = document.getElementById('statusInput');
            const statusMessage = document.getElementById('statusMessage');

            form.action = `{{ route('admin.kyc-verifications.index') }}/${id}/status`;
            statusInput.value = status;

            statusMessage.textContent = '{{ __("Are you sure you want to approve this verification?") }}';

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        function rejectVerification(id) {
            const form = document.getElementById('rejectForm');
            form.action = `{{ route('admin.kyc-verifications.index') }}/${id}/status`;

            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    </script>
@endpush
