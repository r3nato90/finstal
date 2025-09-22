@extends('layouts.user')
@section('content')
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3 class="mb-0">{{ __('Ticket') }} #{{ $ticket->ticket_number }}</h3>
                        <p class="text--muted mb-0">{{ $ticket->subject }}</p>
                    </div>
                    <a href="{{ route('user.support-tickets.index') }}" class="i-btn btn--secondary btn--sm">
                        <i class="fas fa-arrow-left"></i> {{ __('Back to Tickets') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Ticket Details -->
                <div class="i-card-sm mb-4">
                    <div class="card-body">
                        <div class="ticket-content">
                            <div class="ticket-description mb-4">
                                <h6 class="mb-2">{{ __('Description') }}</h6>
                                <div class="description-text p-3 border rounded text-white">
                                    {!! nl2br(e($ticket->description)) !!}
                                </div>
                            </div>

                            @if($ticket->attachments && $ticket->attachments->count() > 0)
                                <div class="ticket-attachments mb-4">
                                    <h6 class="mb-2 text-white">{{ __('Attachments') }}</h6>
                                    <div class="attachments-list">
                                        @foreach($ticket->attachments as $attachment)
                                            <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                <div class="attachment-info">
                                                    <i class="fas fa-file me-2"></i>
                                                    <span class="text-white">{{ $attachment->original_name }}</span>
                                                    <small class="text-white ms-2">({{ formatBytes($attachment->file_size) }})</small>
                                                </div>
                                                <a href="{{ route('user.support-tickets.attachment.download', $attachment) }}"
                                                   class="i-btn btn--primary btn--sm">
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

                <!-- Replies -->
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __('Conversation') }}</h4>
                        <span class="i-badge badge--primary">{{ $ticket->replies->count() }} {{ __('Replies') }}</span>
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
                                                    <small class="text-white">{{ $reply->created_at->format('M d, Y \a\t h:i A') }}</small>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-white">{{ $reply->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="reply-content {{ $reply->is_admin_reply ? 'admin-content' : 'user-content' }}">
                                        <div class="reply-message p-3 rounded text-white">
                                            {!! nl2br(e($reply->message)) !!}
                                        </div>

                                        @if($reply->attachments && $reply->attachments->count() > 0)
                                            <div class="reply-attachments mt-2">
                                                @foreach($reply->attachments as $attachment)
                                                    <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                        <div class="attachment-info">
                                                            <i class="fas fa-file me-2"></i>
                                                            <span class="text-white">{{ $attachment->original_name }}</span>
                                                            <small class="text-white ms-2">({{ formatBytes($attachment->file_size) }})</small>
                                                        </div>
                                                        <a href="{{ route('user.support-tickets.attachment.download', $attachment) }}"
                                                           class="i-btn btn--primary btn--sm">Download
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <i class="fas fa-comments fs-32 text--muted mb-3"></i>
                                    <p class="text--muted">{{ __('No replies yet') }}</p>
                                    <small class="text--light">{{ __('Our support team will respond soon') }}</small>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Reply Form -->
                @if(!in_array($ticket->status, ['closed']))
                    <div class="i-card-sm">
                        <div class="card-header">
                            <h4 class="title">{{ __('Add Reply') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.support-tickets.reply', $ticket) }}" enctype="multipart/form-data" id="replyForm">
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Your Message') }}</label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              name="message" rows="6" required
                                              placeholder="{{ __('Type your reply here...') }}">{{ old('message') }}</textarea>
                                    @error('message')
                                    <div class="invalid-feedback text-white">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text text-white">{{ __('Maximum 5000 characters') }}</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">{{ __('Attachments') }}</label>
                                    <div class="file-upload-wrapper">
                                        <button type="button" class="file-upload-btn btn btn-outline-secondary d-flex align-items-center justify-content-center p-3 w-100" id="replyFileUploadBtn">
                                            <i class="las la-file"></i>
                                            <span>{{ __('Choose Files') }}</span>
                                        </button>
                                        <p class="text--muted fs-12 mb-0 mt-2">{{ __('Max 10MB per file. JPG, PNG, PDF, DOC, DOCX, TXT, ZIP') }}</p>
                                        <input type="file" class="d-none" name="attachments[]" multiple
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip" id="replyAttachmentInput">
                                    </div>
                                    <div id="replySelectedFiles"></div>
                                    @error('attachments.*')
                                    <div class="text-danger fs-12">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="i-btn btn--primary btn--md">
                                        <i class="fas fa-reply"></i> {{ __('Send Reply') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="i-card-sm">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-lock fs-32 text--muted mb-3"></i>
                            <h5 class="text--muted">{{ __('Ticket Closed') }}</h5>
                            <p class="text--light">{{ __('This ticket has been closed and cannot receive new replies.') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-lg-4">
                <!-- Ticket Information -->
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title">{{ __('Ticket Information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="ticket-info">
                            <div class="info-item mb-3">
                                <label class="form-label text--muted">{{ __('Ticket Number') }}</label>
                                <div class="fw-bold">#{{ $ticket->ticket_number }}</div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text--muted">{{ __('Status') }}</label>
                                <div>
                                    <span class="badge badge--{{ $statusColors[$ticket->status] ?? 'secondary' }}">
                                        {{ ucfirst($ticket->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text--muted">{{ __('Priority') }}</label>
                                <div>
                                    <span class="badge badge--{{ $priorityColors[$ticket->priority] ?? 'secondary' }}">
                                        {{ ucfirst($ticket->priority) }}
                                    </span>
                                </div>
                            </div>
                            @if($ticket->category)
                                <div class="info-item mb-3">
                                    <label class="form-label text--muted">{{ __('Category') }}</label>
                                    <div class="fw-bold">{{ $ticket->category }}</div>
                                </div>
                            @endif
                            <div class="info-item mb-3">
                                <label class="form-label text--muted">{{ __('Created') }}</label>
                                <div class="fw-bold">{{ $ticket->created_at->format('M d, Y \a\t h:i A') }}</div>
                                <small class="text--light">{{ $ticket->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="info-item mb-3">
                                <label class="form-label text--muted">{{ __('Last Updated') }}</label>
                                <div class="fw-bold">{{ $ticket->updated_at->format('M d, Y \a\t h:i A') }}</div>
                                <small class="text--light">{{ $ticket->updated_at->diffForHumans() }}</small>
                            </div>
                            @if($ticket->assignedTo)
                                <div class="info-item">
                                    <label class="form-label text--muted">{{ __('Assigned To') }}</label>
                                    <div class="fw-bold">{{ $ticket->assignedTo->name }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title">{{ __('Quick Actions') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('user.support-tickets.create') }}" class="i-btn btn--primary btn--sm">
                                <i class="fas fa-plus"></i> {{ __('Create New Ticket') }}
                            </a>
                            <a href="{{ route('user.support-tickets.index') }}" class="i-btn btn--secondary btn--sm">
                                <i class="fas fa-list"></i> {{ __('View All Tickets') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script-push')
    <script>
        $(document).ready(function() {
            let replySelectedFiles = [];

            // Reply file upload functionality - Click only
            $('#replyFileUploadBtn').on('click', function() {
                $('#replyAttachmentInput').click();
            });

            $('#replyAttachmentInput').on('change', function() {
                handleReplyFiles(this.files);
            });

            function handleReplyFiles(files) {
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'application/pdf',
                    'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'text/plain', 'application/zip'];
                const maxSize = 10 * 1024 * 1024; // 10MB

                Array.from(files).forEach(file => {
                    if (!allowedTypes.includes(file.type)) {
                        notify('error', `{{ __('File type not allowed') }}: ${file.name}`);
                        return;
                    }

                    if (file.size > maxSize) {
                        notify('error', `{{ __('File too large') }}: ${file.name}`);
                        return;
                    }

                    if (replySelectedFiles.length >= 3) {
                        notify('error', '{{ __("Maximum 3 files allowed for replies") }}');
                        return;
                    }

                    replySelectedFiles.push(file);
                });

                displayReplySelectedFiles();
            }

            function displayReplySelectedFiles() {
                const container = $('#replySelectedFiles');
                container.empty();

                if (replySelectedFiles.length === 0) return;

                const fileList = $('<div class="selected-files-list mt-2"></div>');

                replySelectedFiles.forEach((file, index) => {
                    const fileItem = $(`
                        <div class="file-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                            <div class="file-info">
                                <i class="fas fa-file me-2"></i>
                                <span class="file-name">${file.name}</span>
                                <small class="text--muted ms-2">(${formatFileSize(file.size)})</small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger remove-reply-file" data-index="${index}">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `);
                    fileList.append(fileItem);
                });

                container.append(fileList);
                updateReplyFileInput();
            }

            function updateReplyFileInput() {
                const dt = new DataTransfer();
                replySelectedFiles.forEach(file => dt.items.add(file));
                document.getElementById('replyAttachmentInput').files = dt.files;
            }

            $(document).on('click', '.remove-reply-file', function() {
                const index = parseInt($(this).data('index'));
                replySelectedFiles.splice(index, 1);
                displayReplySelectedFiles();
            });

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Character counter for reply message
            $('textarea[name="message"]').on('input', function() {
                const current = $(this).val().length;
                const max = 5000;
                const remaining = max - current;

                let counterText = `${current}/${max} {{ __('characters') }}`;
                if (remaining < 100) {
                    counterText = `<span class="text-danger">${counterText}</span>`;
                }

                $(this).next('.form-text').html(counterText);
            });

            // Auto-scroll to bottom of conversation
            $('.conversation').animate({
                scrollTop: $('.conversation')[0].scrollHeight
            }, 1000);

            // Form validation
            $('#replyForm').on('submit', function(e) {
                const message = $('textarea[name="message"]').val().trim();

                if (!message) {
                    e.preventDefault();
                    notify('error', '{{ __("Please enter your message") }}');
                    return false;
                }

                if (message.length > 5000) {
                    e.preventDefault();
                    notify('error', '{{ __("Message cannot exceed 5000 characters") }}');
                    return false;
                }
            });
        });
    </script>
@endpush

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

        .ticket-info .info-item {
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .ticket-info .info-item:last-child {
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
    </style>
@endpush
