<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h3 class="page-title"><?php echo e(__('Ticket')); ?> #<?php echo e($ticket->ticket_number); ?></h3>
                    <p class="text-muted mb-0"><?php echo e($ticket->subject); ?></p>
                </div>
                <a href="<?php echo e(route('admin.support-tickets.index')); ?>" class="btn btn--secondary btn--sm">
                    <i class="fas fa-arrow-left"></i> <?php echo e(__('Back to Tickets')); ?>

                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Ticket Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('Ticket Details')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="ticket-content">
                            <div class="ticket-description mb-4">
                                <h6 class="mb-2"><?php echo e(__('Description')); ?></h6>
                                <div class="description-text p-3 border rounded">
                                    <?php echo nl2br(e($ticket->description)); ?>

                                </div>
                            </div>

                            <?php if($ticket->attachments && $ticket->attachments->count() > 0): ?>
                                <div class="ticket-attachments mb-4">
                                    <h6 class="mb-2"><?php echo e(__('Attachments')); ?></h6>
                                    <div class="attachments-list">
                                        <?php $__currentLoopData = $ticket->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                <div class="attachment-info">
                                                    <i class="fas fa-file me-2"></i>
                                                    <span><?php echo e($attachment->original_name); ?></span>
                                                    <small class="text-muted ms-2">(<?php echo e(formatBytes($attachment->file_size)); ?>)</small>
                                                </div>
                                                <a href="<?php echo e(route('admin.support-tickets.download-attachment', $attachment)); ?>"
                                                   class="btn btn--primary btn--sm">
                                                    <i class="fas fa-download"></i> <?php echo e(__('Download')); ?>

                                                </a>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('Conversation')); ?></h4>
                        <span class="badge badge--primary"><?php echo e($ticket->replies->count()); ?> <?php echo e(__('Replies')); ?></span>
                    </div>
                    <div class="card-body">
                        <div class="conversation">
                            <?php $__empty_1 = true; $__currentLoopData = $ticket->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="reply-item <?php echo e($reply->is_admin_reply ? 'admin-reply' : 'user-reply'); ?> mb-4">
                                    <div class="reply-header d-flex justify-content-between align-items-center mb-2">
                                        <div class="reply-author">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm me-2">
                                                    <?php if($reply->is_admin_reply): ?>
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user-shield text-white fs-14"></i>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                            <i class="fas fa-user text-white fs-14"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">
                                                        <?php echo e($reply->is_admin_reply ? __('Support Team') : $reply->user->name); ?>

                                                        <?php if($reply->is_admin_reply): ?>
                                                            <span class="badge badge--success badge-sm ms-1"><?php echo e(__('Staff')); ?></span>
                                                        <?php endif; ?>
                                                    </h6>
                                                    <small class="text-muted"><?php echo e($reply->created_at->format('M d, Y \a\t h:i A')); ?></small>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo e($reply->created_at->diffForHumans()); ?></small>
                                    </div>
                                    <div class="reply-content <?php echo e($reply->is_admin_reply ? 'admin-content' : 'user-content'); ?>">
                                        <div class="reply-message p-3 rounded">
                                            <?php echo nl2br(e($reply->message)); ?>

                                        </div>

                                        <?php if($reply->attachments && $reply->attachments->count() > 0): ?>
                                            <div class="reply-attachments mt-2">
                                                <?php $__currentLoopData = $reply->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attachment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="attachment-item border rounded p-2 mb-2 d-flex justify-content-between align-items-center">
                                                        <div class="attachment-info">
                                                            <i class="fas fa-file me-2"></i>
                                                            <span><?php echo e($attachment->original_name); ?></span>
                                                            <small class="text-muted ms-2">(<?php echo e(formatBytes($attachment->file_size)); ?>)</small>
                                                        </div>
                                                        <a href="<?php echo e(route('admin.support-tickets.download-attachment', $attachment)); ?>"
                                                           class="btn btn--primary btn--sm">
                                                            Download
                                                        </a>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="text-center py-4">
                                    <i class="fas fa-comments fs-32 text-muted mb-3"></i>
                                    <p class="text-muted"><?php echo e(__('No replies yet')); ?></p>
                                    <small class="text-muted"><?php echo e(__('This ticket has no conversation history')); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Admin Reply Form -->
                <?php if(!in_array($ticket->status, ['closed'])): ?>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"><?php echo e(__('Add Admin Reply')); ?></h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo e(route('admin.support-tickets.reply', $ticket)); ?>" enctype="multipart/form-data" id="adminReplyForm">
                                <?php echo csrf_field(); ?>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Your Message')); ?></label>
                                    <textarea class="form-control <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              name="message" rows="6" required
                                              placeholder="<?php echo e(__('Type your reply here...')); ?>"><?php echo e(old('message')); ?></textarea>
                                    <?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text"><?php echo e(__('Maximum 5000 characters')); ?></div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label"><?php echo e(__('Attachments')); ?> (<?php echo e(__('Optional')); ?>)</label>
                                    <div class="file-upload-wrapper">
                                        <button type="button" class="file-upload-btn btn btn--outline btn-block d-flex align-items-center justify-content-center p-3" id="adminFileUploadBtn">
                                            <i class="fas fa-paperclip me-2"></i>
                                            <span><?php echo e(__('Choose Files')); ?></span>
                                        </button>
                                        <p class="text-muted fs-12 mb-0 mt-2"><?php echo e(__('Max 10MB per file. JPG, PNG, PDF, DOC, DOCX, TXT, ZIP')); ?></p>
                                        <input type="file" class="d-none" name="attachments[]" multiple
                                               accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip" id="adminAttachmentInput">
                                    </div>
                                    <div id="adminSelectedFiles"></div>
                                    <?php $__errorArgs = ['attachments.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger fs-12"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="changeStatus" name="change_status" value="1">
                                        <label class="form-check-label" for="changeStatus">
                                            <?php echo e(__('Update ticket status after reply')); ?>

                                        </label>
                                    </div>
                                    <button type="submit" class="btn btn--primary">
                                        <i class="fas fa-reply"></i> <?php echo e(__('Send Reply')); ?>

                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="card">
                        <div class="card-body text-center py-4">
                            <i class="fas fa-lock fs-32 text-muted mb-3"></i>
                            <h5 class="text-muted"><?php echo e(__('Ticket Closed')); ?></h5>
                            <p class="text-muted"><?php echo e(__('This ticket has been closed and cannot receive new replies.')); ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <!-- Ticket Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('Ticket Information')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="ticket-info">
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Ticket Number')); ?></label>
                                <div class="fw-bold">#<?php echo e($ticket->ticket_number); ?></div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Status')); ?></label>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge badge--<?php echo e($statusColors[$ticket->status] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $ticket->status))); ?>

                                    </span>
                                    <div class="dropdown">
                                        <button class="btn btn--sm btn--outline dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="las la-edit"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('open')">
                                                    <span class="badge badge--primary me-2"><?php echo e(__('Open')); ?></span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('in_progress')">
                                                    <span class="badge badge--warning me-2"><?php echo e(__('In Progress')); ?></span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('resolved')">
                                                    <span class="badge badge--success me-2"><?php echo e(__('Resolved')); ?></span>
                                                </a></li>
                                            <li><a class="dropdown-item" href="javascript:void(0)" onclick="updateTicketStatus('closed')">
                                                    <span class="badge badge--secondary me-2"><?php echo e(__('Closed')); ?></span>
                                                </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Priority')); ?></label>
                                <div>
                                    <span class="badge badge--<?php echo e($priorityColors[$ticket->priority] ?? 'secondary'); ?>">
                                        <?php echo e(ucfirst($ticket->priority)); ?>

                                    </span>
                                </div>
                            </div>
                            <?php if($ticket->category): ?>
                                <div class="info-item mb-3">
                                    <label class="text-muted"><?php echo e(__('Category')); ?></label>
                                    <div class="fw-bold"><?php echo e($ticket->category); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Created')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->created_at->format('M d, Y \a\t h:i A')); ?></div>
                                <small class="text-muted"><?php echo e($ticket->created_at->diffForHumans()); ?></small>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Last Updated')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->updated_at->format('M d, Y \a\t h:i A')); ?></div>
                                <small class="text-muted"><?php echo e($ticket->updated_at->diffForHumans()); ?></small>
                            </div>
                            <?php if($ticket->resolved_at): ?>
                                <div class="info-item">
                                    <label class="text-muted"><?php echo e(__('Resolved At')); ?></label>
                                    <div class="fw-bold"><?php echo e($ticket->resolved_at->format('M d, Y \a\t h:i A')); ?></div>
                                    <small class="text-muted"><?php echo e($ticket->resolved_at->diffForHumans()); ?></small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('User Information')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="user-info">
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Name')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->user->name ?? 'Unknown'); ?></div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Email')); ?></label>
                                <div><?php echo e($ticket->user->email ?? 'N/A'); ?></div>
                            </div>
                            <?php if(isset($ticket->user->phone)): ?>
                                <div class="info-item mb-3">
                                    <label class="text-muted"><?php echo e(__('Phone')); ?></label>
                                    <div><?php echo e($ticket->user->phone ?? 'N/A'); ?></div>
                                </div>
                            <?php endif; ?>
                            <div class="info-item">
                                <label class="text-muted"><?php echo e(__('User Since')); ?></label>
                                <div><?php echo e($ticket->user->created_at->format('M d, Y') ?? 'N/A'); ?></div>
                                <small class="text-muted"><?php echo e($ticket->user->created_at->diffForHumans() ?? 'N/A'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('Statistics')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-info">
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Total Replies')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->replies->count()); ?></div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('Admin Replies')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->replies->where('is_admin_reply', true)->count()); ?></div>
                            </div>
                            <div class="info-item mb-3">
                                <label class="text-muted"><?php echo e(__('User Replies')); ?></label>
                                <div class="fw-bold"><?php echo e($ticket->replies->where('is_admin_reply', false)->count()); ?></div>
                            </div>
                            <div class="info-item">
                                <label class="text-muted"><?php echo e(__('Attachments')); ?></label>
                                <div class="fw-bold">
                                    <?php echo e($ticket->attachments->count() + $ticket->replies->sum(function($reply) { return $reply->attachments->count(); })); ?>

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
        <?php echo csrf_field(); ?>
        <input type="hidden" name="status" id="statusInput">
    </form>

    <form id="priorityForm" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="priority" id="priorityInput">
    </form>

    <form id="assignForm" method="POST" style="display: none;">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="assigned_to" id="assignInput">
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-push'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
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
                        alert('<?php echo e(__("File type not allowed")); ?>: ' + file.name);
                        return;
                    }

                    if (file.size > maxSize) {
                        alert('<?php echo e(__("File too large")); ?>: ' + file.name);
                        return;
                    }

                    if (adminSelectedFiles.length >= 5) {
                        alert('<?php echo e(__("Maximum 5 files allowed")); ?>');
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
                    alert('<?php echo e(__("Please enter your message")); ?>');
                    return false;
                }

                if (message.length > 5000) {
                    e.preventDefault();
                    alert('<?php echo e(__("Message cannot exceed 5000 characters")); ?>');
                    return false;
                }
            });
        });

        function updateTicketStatus(status) {
            if (confirm('Are you sure you want to change the status to ' + status.replace('_', ' ').toUpperCase() + '?')) {
                $('#statusInput').val(status);
                $('#statusForm').attr('action', '<?php echo e(route("admin.support-tickets.update-status", $ticket)); ?>').submit();
            }
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/support-tickets/show.blade.php ENDPATH**/ ?>