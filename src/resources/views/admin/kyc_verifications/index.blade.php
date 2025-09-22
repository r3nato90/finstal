@extends('admin.layouts.main')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">{{ __('KYC Verifications') }}</h5>
                </div>

                <div class="responsive-table">
                    <table>
                        <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Full Name') }}</th>
                            <th>{{ __('Document Type') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Submitted') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($verifications as $verification)
                            <tr>
                                <td>
                                    <span class="name">
                                        {{ @$verification->user->name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ @$verification->user->email ?? 'N/A' }}</small>
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold">{{ $verification->first_name.' '.$verification->last_name }}</span><br>
                                    <small class="text-muted">{{ $verification->phone ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    <span class="badge badge--primary">{{ __(ucfirst(str_replace('_', ' ', $verification->document_type))) }}</span>
                                </td>
                                <td>
                                    @if($verification->status == 'pending')
                                        <span class="badge badge--warning">{{ __('Pending') }}</span>
                                    @elseif($verification->status == 'approved')
                                        <span class="badge badge--success">{{ __('Approved') }}</span>
                                    @elseif($verification->status == 'rejected')
                                        <span class="badge badge--danger">{{ __('Rejected') }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{ showDateTime($verification->submitted_at) }}<br>
                                    <small class="text-muted">{{ diffForHumans($verification->submitted_at) }}</small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.kyc-verifications.show', $verification->id) }}" class="btn btn-sm btn--secondary">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.kyc-verifications.download', $verification->id) }}" class="btn btn-sm btn--info">
                                            <i class="la la-download"></i>
                                        </a>
                                        @if($verification->status == 'pending')
                                            <button type="button" class="btn btn-sm btn--success" onclick="updateStatus({{ $verification->id }}, 'approved')">
                                                <i class="la la-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn--danger" onclick="rejectVerification({{ $verification->id }})">
                                                <i class="la la-times"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ __('No KYC verifications found') }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $verifications->appends(request()->all())->links() }}
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

            const messages = {
                'approved': '{{ __("Are you sure you want to approve this verification?") }}',
                'pending': '{{ __("Are you sure you want to set this to pending?") }}'
            };

            statusMessage.textContent = messages[status];

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
