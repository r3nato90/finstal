<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title text-white"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if(!$kyc): ?>
                            <div class="text-center mb-4">
                                <i class="bi bi-shield-check fs-1 text-primary"></i>
                                <h5 class="mt-3 text-white"><?php echo e(__('Verify Your Identity')); ?></h5>
                                <p class="text-white-50"><?php echo e(__('Complete KYC verification to unlock all features and increase your account limits.')); ?></p>
                            </div>

                            <form action="<?php echo e(route('user.kyc.submit')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo $__env->make('user.settings.partials.kyc_form', ['isResubmission' => false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </form>

                        <?php elseif($kyc->status == 'pending'): ?>
                            <div class="alert alert-warning bg-dark border-warning">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock-history fs-3 text-warning me-3"></i>
                                    <div>
                                        <h6 class="text-warning mb-1"><?php echo e(__('Verification Pending')); ?></h6>
                                        <p class="mb-0 text-white-50"><?php echo e(__('Your documents are under review. We will notify you within 2-3 business days.')); ?></p>
                                        <small class="text-white-50"><?php echo e(__('Submitted on:')); ?> <?php echo e($kyc->submitted_at->format('M d, Y h:i A')); ?></small>
                                    </div>
                                </div>
                            </div>

                            <?php echo $__env->make('user.settings.partials.kyc_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <?php elseif($kyc->status == 'approved'): ?>
                            <div class="alert alert-success bg-dark border-success">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle-fill fs-3 text-success me-3"></i>
                                    <div>
                                        <h6 class="text-success mb-1"><?php echo e(__('Identity Verified')); ?></h6>
                                        <p class="mb-0 text-white-50"><?php echo e(__('Your identity has been successfully verified. You now have access to all platform features.')); ?></p>
                                        <small class="text-white-50"><?php echo e(__('Approved on:')); ?> <?php echo e($kyc->reviewed_at->format('M d, Y h:i A')); ?></small>
                                    </div>
                                </div>
                            </div>

                            <?php echo $__env->make('user.settings.partials.kyc_details', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php elseif($kyc->status == 'rejected'): ?>
                            <div class="alert alert-danger bg-dark border-danger">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-x-circle-fill fs-3 text-danger me-3"></i>
                                    <div>
                                        <h6 class="text-danger mb-1"><?php echo e(__('Verification Rejected')); ?></h6>
                                        <p class="mb-0 text-white-50"><?php echo e(__('Your KYC verification was rejected. Please review the reason below and resubmit with correct information.')); ?></p>
                                        <?php if($kyc->rejection_reason): ?>
                                            <div class="mt-2 p-2 bg-danger bg-opacity-10 rounded">
                                                <strong class="text-danger"><?php echo e(__('Rejection Reason:')); ?></strong>
                                                <p class="mb-0 text-white-50"><?php echo e($kyc->rejection_reason); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <form action="<?php echo e(route('user.kyc.resubmit')); ?>" method="POST" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <?php echo $__env->make('user.settings.partials.kyc_form', ['isResubmission' => true], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/settings/kyc.blade.php ENDPATH**/ ?>