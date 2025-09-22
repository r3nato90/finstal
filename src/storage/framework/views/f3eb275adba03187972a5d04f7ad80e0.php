<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0"><?php echo e(__('KYC Verifications')); ?></h5>
                </div>

                <div class="responsive-table">
                    <table>
                        <thead>
                        <tr>
                            <th><?php echo e(__('User')); ?></th>
                            <th><?php echo e(__('Full Name')); ?></th>
                            <th><?php echo e(__('Document Type')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Submitted')); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $verifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <span class="name">
                                        <?php echo e(@$verification->user->name ?? 'N/A'); ?><br>
                                        <small class="text-muted"><?php echo e(@$verification->user->email ?? 'N/A'); ?></small>
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold"><?php echo e($verification->first_name.' '.$verification->last_name); ?></span><br>
                                    <small class="text-muted"><?php echo e($verification->phone ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <span class="badge badge--primary"><?php echo e(__(ucfirst(str_replace('_', ' ', $verification->document_type)))); ?></span>
                                </td>
                                <td>
                                    <?php if($verification->status == 'pending'): ?>
                                        <span class="badge badge--warning"><?php echo e(__('Pending')); ?></span>
                                    <?php elseif($verification->status == 'approved'): ?>
                                        <span class="badge badge--success"><?php echo e(__('Approved')); ?></span>
                                    <?php elseif($verification->status == 'rejected'): ?>
                                        <span class="badge badge--danger"><?php echo e(__('Rejected')); ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php echo e(showDateTime($verification->submitted_at)); ?><br>
                                    <small class="text-muted"><?php echo e(diffForHumans($verification->submitted_at)); ?></small>
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="<?php echo e(route('admin.kyc-verifications.show', $verification->id)); ?>" class="btn btn-sm btn--secondary">
                                            <i class="la la-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('admin.kyc-verifications.download', $verification->id)); ?>" class="btn btn-sm btn--info">
                                            <i class="la la-download"></i>
                                        </a>
                                        <?php if($verification->status == 'pending'): ?>
                                            <button type="button" class="btn btn-sm btn--success" onclick="updateStatus(<?php echo e($verification->id); ?>, 'approved')">
                                                <i class="la la-check"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn--danger" onclick="rejectVerification(<?php echo e($verification->id); ?>)">
                                                <i class="la la-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td class="text-muted text-center" colspan="100%"><?php echo e(__('No KYC verifications found')); ?></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <?php echo e($verifications->appends(request()->all())->links()); ?>

            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(__('Update Status')); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <input type="hidden" name="status" id="statusInput">
                        <p id="statusMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn--primary"><?php echo e(__('Update')); ?></button>
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
                    <h4 class="modal-title"><?php echo e(__('Reject Verification')); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rejectForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="modal-body">
                        <input type="hidden" name="status" value="rejected">
                        <div class="form-group">
                            <label class="form-label required"><?php echo e(__('Rejection Reason')); ?></label>
                            <textarea name="rejection_reason" class="form-control" rows="3" placeholder="<?php echo e(__('Enter reason...')); ?>" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--dark" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn--danger"><?php echo e(__('Reject')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        function updateStatus(id, status) {
            const form = document.getElementById('statusForm');
            const statusInput = document.getElementById('statusInput');
            const statusMessage = document.getElementById('statusMessage');

            form.action = `<?php echo e(route('admin.kyc-verifications.index')); ?>/${id}/status`;
            statusInput.value = status;

            const messages = {
                'approved': '<?php echo e(__("Are you sure you want to approve this verification?")); ?>',
                'pending': '<?php echo e(__("Are you sure you want to set this to pending?")); ?>'
            };

            statusMessage.textContent = messages[status];

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        function rejectVerification(id) {
            const form = document.getElementById('rejectForm');
            form.action = `<?php echo e(route('admin.kyc-verifications.index')); ?>/${id}/status`;

            const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
            modal.show();
        }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/kyc_verifications/index.blade.php ENDPATH**/ ?>