<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0"><?php echo e(__('Create Support Ticket')); ?></h3>
                    <a href="<?php echo e(route('user.support-tickets.index')); ?>" class="i-btn btn--secondary btn--sm">
                        <i class="fas fa-arrow-left"></i> <?php echo e(__('Back to Tickets')); ?>

                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Ticket Details')); ?></h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="<?php echo e(route('user.support-tickets.store')); ?>" enctype="multipart/form-data" id="createTicketForm">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label required"><?php echo e(__('Subject')); ?></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               name="subject" value="<?php echo e(old('subject')); ?>"
                                               placeholder="<?php echo e(__('Brief description of your issue')); ?>" required>
                                        <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label"><?php echo e(__('Category')); ?></label>
                                        <select name="category" class="form-control <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('Select Category')); ?></option>
                                            <option value="Technical Issue" <?php echo e(old('category') == 'Technical Issue' ? 'selected' : ''); ?>><?php echo e(__('Technical Issue')); ?></option>
                                            <option value="Account" <?php echo e(old('category') == 'Account' ? 'selected' : ''); ?>><?php echo e(__('Account')); ?></option>
                                            <option value="Billing" <?php echo e(old('category') == 'Billing' ? 'selected' : ''); ?>><?php echo e(__('Billing')); ?></option>
                                            <option value="Trading" <?php echo e(old('category') == 'Trading' ? 'selected' : ''); ?>><?php echo e(__('Trading')); ?></option>
                                            <option value="Deposit/Withdrawal" <?php echo e(old('category') == 'Deposit/Withdrawal' ? 'selected' : ''); ?>><?php echo e(__('Deposit/Withdrawal')); ?></option>
                                            <option value="General Inquiry" <?php echo e(old('category') == 'General Inquiry' ? 'selected' : ''); ?>><?php echo e(__('General Inquiry')); ?></option>
                                            <option value="Other" <?php echo e(old('category') == 'Other' ? 'selected' : ''); ?>><?php echo e(__('Other')); ?></option>
                                        </select>
                                        <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required"><?php echo e(__('Priority')); ?></label>
                                <div class="row g-2">
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityLow" value="low"
                                            <?php echo e(old('priority', 'medium') == 'low' ? 'checked' : ''); ?>>
                                        <label class="btn btn-outline-secondary w-100" for="priorityLow">
                                            <i class="fas fa-circle text-secondary"></i>
                                            <?php echo e(__('Low')); ?>

                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityMedium" value="medium"
                                            <?php echo e(old('priority', 'medium') == 'medium' ? 'checked' : ''); ?>>
                                        <label class="btn btn-outline-primary w-100" for="priorityMedium">
                                            <i class="fas fa-circle text-primary"></i>
                                            <?php echo e(__('Medium')); ?>

                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityHigh" value="high"
                                            <?php echo e(old('priority') == 'high' ? 'checked' : ''); ?>>
                                        <label class="btn btn-outline-warning w-100" for="priorityHigh">
                                            <i class="fas fa-circle text-warning"></i>
                                            <?php echo e(__('High')); ?>

                                        </label>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="radio" class="btn-check" name="priority" id="priorityUrgent" value="urgent"
                                            <?php echo e(old('priority') == 'urgent' ? 'checked' : ''); ?>>
                                        <label class="btn btn-outline-danger w-100" for="priorityUrgent">
                                            <i class="fas fa-circle text-danger"></i>
                                            <?php echo e(__('Urgent')); ?>

                                        </label>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger fs-12 mt-1"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="mb-3">
                                <label class="form-label required"><?php echo e(__('Description')); ?></label>
                                <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                          name="description" rows="8" required
                                          placeholder="<?php echo e(__('Please provide detailed information about your issue, including any error messages or steps to reproduce the problem.')); ?>"><?php echo e(old('description')); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text text-white"><?php echo e(__('Maximum 5000 characters')); ?></div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label"><?php echo e(__('Attachments')); ?></label>
                                <input type="file" class="form-control <?php $__errorArgs = ['attachments.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="attachments[]" multiple
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.txt,.zip" id="attachmentInput">
                                <div class="form-text text-white"><?php echo e(__('Maximum file size: 10MB. Allowed formats: JPG, PNG, PDF, DOC, DOCX, TXT, ZIP. Maximum 5 files.')); ?></div>
                                <?php $__errorArgs = ['attachments.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="text-end">
                                <a href="<?php echo e(route('user.support-tickets.index')); ?>" class="i-btn btn--danger btn--md me-2">
                                    <?php echo e(__('Cancel')); ?>

                                </a>
                                <button type="submit" class="i-btn btn--light btn--md">
                                    <i class="fas fa-paper-plane"></i> <?php echo e(__('Create Ticket')); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Tips for Better Support')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="support-tips">
                            <div class="tip-item mb-3">
                                <i class="fas fa-lightbulb text-warning"></i>
                                <span class="ms-2"><?php echo e(__('Be specific and detailed about your issue')); ?></span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-images text-info"></i>
                                <span class="ms-2"><?php echo e(__('Include screenshots if applicable')); ?></span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-list-ol text-success"></i>
                                <span class="ms-2"><?php echo e(__('List steps to reproduce the problem')); ?></span>
                            </div>
                            <div class="tip-item mb-3">
                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                <span class="ms-2"><?php echo e(__('Include any error messages')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Response Times')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="response-times">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--secondary"><?php echo e(__('Low')); ?></span>
                                <span>24-48 hours</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--primary"><?php echo e(__('Medium')); ?></span>
                                <span>12-24 hours</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge badge--warning"><?php echo e(__('High')); ?></span>
                                <span>4-12 hours</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="badge badge--danger"><?php echo e(__('Urgent')); ?></span>
                                <span>1-4 hours</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script-push'); ?>
        <script>
            $(document).ready(function() {
                // Form validation
                $('#createTicketForm').on('submit', function(e) {
                    const subject = $('input[name="subject"]').val().trim();
                    const description = $('textarea[name="description"]').val().trim();
                    const priority = $('input[name="priority"]:checked').val();

                    if (!subject || !description || !priority) {
                        e.preventDefault();
                        notify('error', '<?php echo e(__("Please fill in all required fields")); ?>');
                        return false;
                    }

                    if (description.length > 5000) {
                        e.preventDefault();
                        notify('error', '<?php echo e(__("Description cannot exceed 5000 characters")); ?>');
                        return false;
                    }

                    // Validate file count
                    const files = document.getElementById('attachmentInput').files;
                    if (files.length > 5) {
                        e.preventDefault();
                        notify('error', '<?php echo e(__("Maximum 5 files allowed")); ?>');
                        return false;
                    }

                    // Validate file sizes
                    const maxSize = 10 * 1024 * 1024; // 10MB
                    for (let i = 0; i < files.length; i++) {
                        if (files[i].size > maxSize) {
                            e.preventDefault();
                            notify('error', `<?php echo e(__('File too large')); ?>: ${files[i].name}`);
                            return false;
                        }
                    }
                });

                // Character counter for description
                $('textarea[name="description"]').on('input', function() {
                    const current = $(this).val().length;
                    const max = 5000;
                    const remaining = max - current;

                    let counterText = `${current}/${max} <?php echo e(__('characters')); ?>`;
                    if (remaining < 100) {
                        counterText = `<span class="text-danger">${counterText}</span>`;
                    }

                    $(this).next('.form-text').html(counterText);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('style-push'); ?>
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
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/support-tickets/create.blade.php ENDPATH**/ ?>