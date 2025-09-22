@extends('admin.layouts.main')
@section('panel')
    <section>
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="page-title">{{ __('Ticket') }} #{{ $ticket->ticket_number }}</h3>
                    <p class="text-muted mb-0">{{ $ticket->subject }}</p>
                </div>
                <a href="{{ route('admin.support-tickets.index') }}" class="btn btn--secondary btn--sm">
                    <i class="fas fa-arrow-left"></i> {{ __('Back to Tickets') }}
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Ticket Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Ticket Details') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="ticket-content">
                            <div class="ticket-description mb-4">
                                <h6 class="mb-2">{{ __('Description') }}</h6>
                                <div class="description-text p-3 border rounded">
                                    {!! nl2br(e($ticket->description)) !!}
                                </div>
                            </div>

                            @if($ticket->attachments && $ticket->attachments->count() > 0)
                                <div class="ticket-attachments mb-4">
                                    <h6 class="mb-2">{{ __('Attachments') }}</h6>
                                    <div class="attachments-list">
                                        @foreach($ticket->attachments as $attachment)
                                            <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                <div class="attachment-info">
                                                    <i class="fas fa-file me-2"></i>
                                                    <span>{{ $attachment->original_name }}</span>
                                                    <small class="text-muted ms-2">({{ formatBytes($attachment->file_size) }})</small>
                                                </div>
                                                <a href="{{ route('admin.support-tickets.download-attachment', $attachment) }}"
                                                   class="btn btn--primary btn--sm">
                                                    <i class="fas fa-download"></i> {{ __('Download') }}
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Conversation') }}</h4>
                        <span class="badge badge--primary">{{ $ticket->replies->count() }} {{ __('Replies') }}</span>
                    </div>
                    <div class="card-body">
                        <div class="conversation">
                            @forelse($ticket->replies as $reply)
                                <div class="reply-item {{ $reply->is_admin_reply ? 'admin-reply' : 'user-reply' }} mb-4">
                                    <div class="reply-header d-flex justify-content-between align-items-center mb-2">
                                        <div class="reply-author">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    @if($reply->is_admin_reply)
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user-shield text-white fs-14"></i>
                                                        </div>
                                                    @else
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user text-white fs-14"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        {{ $reply->is_admin_reply ? __('Support Team') : $reply->user->name }}
                                                        @if($reply->is_admin_reply)
                                                            <span class="badge badge--success badge-sm ms-1">{{ __('Staff') }}</span>
                                                        @endif
                                                    </h6>
                                                    <small class="text-muted">{{ $reply->created_at->format('M d, Y \a\t h:i A') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="reply-content {{ $reply->is_admin_reply ? 'admin-content' : 'user-content' }}">
                                        <div class="reply-message p-3 rounded">
                                            {!! nl2br(e($reply->message)) !!}
                                        </div>

                                        @if($reply->attachments && $reply->attachments->count() > 0)
                                            <div class="reply-attachments mt-2">
                                                @foreach($reply->attachments as $attachment)
                                                    <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                        <div class="attachment-info">
                                                            <i class="fas fa-file me-2"></i>
                                                            <span>{{ $attachment->original_name }}</span>
                                                            <small class="text-muted ms-2">({{ formatBytes($attachment->file_size) }})</small>
                                                        </div>
                                                        <a href="{{ route('admin.support-tickets.download-attachment', $attachment) }}"
                                                           class="btn btn--primary btn--sm">
                                                            Download
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-comments fs-32 text-muted mb-3"></i>
                                    <p class="text-muted">{{ __('No replies yet') }}</p>
                                    <small class="text-muted">{{ __('This ticket has no conversation history') }}</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Admin Reply Form -->
                @if(!in_array($ticket->status, ['closed']))
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('Add Admin Reply') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.support-tickets.reply', $ticket) }}" enctype="multipart/form-data" id="adminReplyForm">
                                @csrf

                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Your Message') }}</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              name="message" rows="6" required
                                              placeholder="{{ __('Type your reply here...') }}">{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">{{ __('Maximum 5000 characters') }}</div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">{{ __('Attachments') }} ({{ __('Optional') }})</label>
                                    <div class="file-upload-wrapper">
                                        <button type="button" class="file-upload-btn btn btn--outline btn-block d-flex align-items-center justify-content-center p-3" id="adminFileUploadBtn">
                                            <i class="fas fa-paperclip me-2"></i>
                                            <span>{{ __('Choose Files') }}</span>
                                        </button>
                                        <p class="text-muted fs-12 mb-0 mt-2">{{ __('Max 10MB per file. JPG, PNG, PDF, DOC, DOCX, TXT, ZIP') }}</p>
                                        <input type="file" class="d-none" name="attachments[]" multiple
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip" id="adminAttachmentInput">
                                    </div>
                                    <div id="adminSelectedFiles"></div>
                                    @error('attachments.*')
                                    <div class="text-danger fs-12">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="changeStatus" name="change_status" value="1">
                                        <label class="form-check-label" for="changeStatus">
                                            {{ __('Update ticket status after reply') }}
                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn--primary">
                                        <i class="fas fa-reply"></i> {{ __('Send Reply') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-lock fs-32 text-muted mb-3"></i>
                            <h5 class="text-muted">{{ __('Ticket Closed') }}</h5>
                            <p class="text-muted">{{ __('This ticket has been closed and cannot receive new replies.') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Ticket Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Ticket Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="ticket-info">
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Ticket Number') }}</label>
                                <div class="fw-bold">#{{ $ticket->ticket_number }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Status') }}</label>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge badge--{{ $statusColors[$ticket->status] ?? 'secondary' }}">
                                        {{ ucfirst(str_replace('_', ' ', $ticket->status)) }}
                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn--sm btn--outline dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('open')">
                                                    <span class="badge badge--primary me-2">{{ __('Open') }}</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('in_progress')">
                                                    <span class="badge badge--warning me-2">{{ __('In Progress') }}</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('resolved')">
                                                    <span class="badge badge--success me-2">{{ __('Resolved') }}</span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('closed')">
                                                    <span class="badge badge--secondary me-2">{{ __('Closed') }}</span>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Priority') }}</label>
                                <div>
                                    <span class="badge badge--{{ $priorityColors[$ticket->priority] ?? 'secondary' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                            </div>
                            @if($ticket->category)
                                <div class="info-item mb-3">
                                    <label class="text-muted">{{ __('Category') }}</label>
                                    <div class="fw-bold">{{ $ticket->category }}</div>
                                </div>
                            @endif
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Created') }}</label>
                                <div class="fw-bold">{{ $ticket->created_at->format('M d, Y \a\t h:i A') }}</div>
                                <small class="text-muted">{{ $ticket->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Last Updated') }}</label>
                                <div class="fw-bold">{{ $ticket->updated_at->format('M d, Y \a\t h:i A') }}</div>
                                <small class="text-muted">{{ $ticket->updated_at->diffForHumans() }}</small>
                            </div>
                            @if($ticket->resolved_at)
                                <div class="info-item">
                                    <label class="text-muted">{{ __('Resolved At') }}</label>
                                    <div class="fw-bold">{{ $ticket->resolved_at->format('M d, Y \a\t h:i A') }}</div>
                                    <small class="text-muted">{{ $ticket->resolved_at->diffForHumans() }}</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('User Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="user-info">
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Name') }}</label>
                                <div class="fw-bold">{{ $ticket->user->name ?? 'Unknown' }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Email') }}</label>
                                <div>{{ $ticket->user->email ?? 'N/A' }}</div>
                            </div>
                            @if(isset($ticket->user->phone))
                                <div class="info-item mb-3">
                                    <label class="text-muted">{{ __('Phone') }}</label>
                                    <div>{{ $ticket->user->phone ?? 'N/A' }}</div>
                                </div>
                            @endif
                            <div class="info-item">
                                <label class="text-muted">{{ __('User Since') }}</label>
                                <div>{{ $ticket->user->created_at->format('M d, Y') ?? 'N/A' }}</div>
                                <small class="text-muted">{{ $ticket->user->created_at->diffForHumans() ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('Statistics') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-info">
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Total Replies') }}</label>
                                <div class="fw-bold">{{ $ticket->replies->count() }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('Admin Replies') }}</label>
                                <div class="fw-bold">{{ $ticket->replies->where('is_admin_reply', true)->count() }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted">{{ __('User Replies') }}</label>
                                <div class="fw-bold">{{ $ticket->replies->where('is_admin_reply', false)->count() }}</div>
                            </div>
                            <div class="info-item">
                                <label class="text-muted">{{ __('Attachments') }}</label>
                                <div class="fw-bold">
                                    {{ $ticket->attachments->count() + $ticket->replies->sum(function($reply) { return $reply->attachments->count(); }) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Hidden forms for quick actions -->
    <form id="statusForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="status" id="statusInput">
    </form>

    <form id="priorityForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="priority" id="priorityInput">
    </form>

    <form id="assignForm" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="assigned_to" id="assignInput">
    </form>
@endsection

@push('style-push')
    <style>
        .ticket-description .description-text {
            background-color: rgba(255, 255, 255, 0.05);
            line-height: 1.6;
        }

        .conversation {
            max-height: 600px;
            overflow-y: auto;
            padding-right: 10px;
        }

        .reply-item {
            position: relative;
        }

        .admin-reply .reply-content .reply-message {
            background-color: rgba(var(--primary-color-rgb), 0.1);
            border-left: 3px solid var(--primary-color);
        }

        .user-reply .reply-content .reply-message {
            background-color: rgba(255, 255, 255, 0.05);
            border-left: 3px solid #6c757d;
        }

        .attachment-item {
            background-color: rgba(255, 255, 255, 0.05);
            font-size: 14px;
        }

        .file-upload-btn {
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: rgba(255, 255, 255, 0.02);
            border: 2px dashed #6c757d;
        }

        .file-upload-btn:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: var(--primary-color);
        }

        .info-item {
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .conversation::-webkit-scrollbar {
            width: 4px;
        }

        .conversation::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .conversation::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .conversation::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
        }

        .dropdown-menu {
            max-height: 200px;
            overflow-y: auto;
        }

        .dropdown-toggle::after {
            display: none;
        }
    </style>
@endpush

@push('script-push')
    <script>
        $(document).ready(function() {
            let adminSelectedFiles = [];

            // Admin file upload functionality
            $('#adminFileUploadBtn').on('click', function() {
                $('#adminAttachmentInput').click();
            });

            $('#adminAttachmentInput').on('change', function() {
                handleAdminFiles(this.files);
            });

            function handleAdminFiles(files) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf',
                    'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain', 'application/zip'];
                const maxSize = 10 * 1024 * 1024; // 10MB

                Array.from(files).forEach(file => {
                    if (!allowedTypes.includes(file.type)) {
                        alert('{{ __("File type not allowed") }}: ' + file.name);
                        return;
                    }

                    if (file.size > maxSize) {
                        alert('{{ __("File too large") }}: ' + file.name);
                        return;
                    }

                    if (adminSelectedFiles.length >= 5) {
                        alert('{{ __("Maximum 5 files allowed") }}');
                        return;
                    }

                    adminSelectedFiles.push(file);
                });

                displayAdminSelectedFiles();
            }

            function displayAdminSelectedFiles() {
                const container = $('#adminSelectedFiles');
                container.empty();

                if (adminSelectedFiles.length === 0) return;

                const fileList = $('<div class="selected-files-list mt-2"></div>');

                adminSelectedFiles.forEach((file, index) => {
                    const fileItem = $(`
                        <div class="file-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                            <div class="file-info">
                                <i class="fas fa-file me-2"></i>
                                <span class="file-name">${file.name}</span>
                                <small class="text-muted ms-2">(${formatFileSize(file.size)})</small>
                            </div>
                            <button type="button" class="btn btn--sm btn--outline-danger remove-admin-file" data-index="${index}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `);
                    fileList.append(fileItem);
                });

                container.append(fileList);
                updateAdminFileInput();
            }

            function updateAdminFileInput() {
                const dt = new DataTransfer();
                adminSelectedFiles.forEach(file => dt.items.add(file));
                document.getElementById('adminAttachmentInput').files = dt.files;
            }

            $(document).on('click', '.remove-admin-file', function() {
                const index = parseInt($(this).data('index'));
                adminSelectedFiles.splice(index, 1);
                displayAdminSelectedFiles();
            });

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            $('.conversation').animate({
                scrollTop: $('.conversation')[0].scrollHeight
            }, 1000);

            $('#adminReplyForm').on('submit', function(e) {
                const message = $('textarea[name="message"]').val().trim();

                if (!message) {
                    e.preventDefault();
                    alert('{{ __("Please enter your message") }}');
                    return false;
                }

                if (message.length > 5000) {
                    e.preventDefault();
                    alert('{{ __("Message cannot exceed 5000 characters") }}');
                    return false;
                }
            });
        });

        function updateTicketStatus(status) {
            if (confirm('Are you sure you want to change the status to ' + status.replace('_', ' ').toUpperCase() + '?')) {
                $('#statusInput').val(status);
                $('#statusForm').attr('action', '{{ route("admin.support-tickets.update-status", $ticket) }}').submit();
            }
        }
    </script>
@endpush
