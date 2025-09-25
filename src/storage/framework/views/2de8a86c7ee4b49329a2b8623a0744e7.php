<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($setTitle); ?></h4>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('admin.matrix.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="text-center mb-2">
                            <div class="admin-commission"></div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-xl-6">
                                <label class="form-label" for="name"><?php echo e(__('admin.input.name')); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" placeholder="<?php echo e(__('admin.placeholder.name')); ?>" class="form-control" required="">
                            </div>

                            <div class="col-xl-6">
                                <label class="form-label" for="amount"><?php echo e(__('admin.input.amount')); ?> <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <?php echo e(getCurrencySymbol()); ?>

                                    </div>
                                    <input type="number" class="form-control" id="amount" name="amount"  placeholder="<?php echo e(__('admin.placeholder.number')); ?>" step="any" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label" for="referral-reward"><?php echo e(__('admin.input.referral')); ?> <sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <div class="input-group-text">
                                        <?php echo e(getCurrencySymbol()); ?>

                                    </div>
                                    <input type="number" class="form-control" id="referral-reward" name="referral_reward" step="any" placeholder="<?php echo e(__('admin.placeholder.referral')); ?>" required>
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <label class="form-label" for="status"><?php echo e(__('admin.input.status')); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected><?php echo e(__('admin.filter.placeholder.select')); ?></option>
                                    <?php $__currentLoopData = \App\Enums\Matrix\PlanStatus::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>"><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label for="duration" class="form-label"><?php echo app('translator')->get('Is Recommend'); ?> <sup class="text-danger">*</sup></label>
                                <div class="border px-2 py-2 rounded">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="checkbox" value="1" name="is_recommend" id="flexCheckChecked" >
                                        <label class="form-check-label" for="flexCheckChecked"><?php echo e(__('Yes')); ?></label>
                                    </div>
                                </div>
                            </div>

                            <h5 class="mt-5 mb-0"><?php echo e(__('admin.input.referral_commission')); ?></h5>

                            <?php for($i = 0; $i < $matrixHeight; $i++): ?>
                                <div class="col-lg-6">
                                    <label for="<?php echo e($i); ?>" class="form-label"><?php echo app('translator')->get('Level '); ?><?php echo e($i + 1); ?></label>
                                    <div class="input-group">
                                        <div class="input-group-text">
                                            <?php echo e(getCurrencySymbol()); ?>

                                        </div>
                                        <input type="number" class="form-control referral-commission-amount" id="<?php echo e($i); ?>" name="matrix_levels[<?php echo e($i+1); ?>]" placeholder="<?php echo e(__('admin.placeholder.number')); ?>" step="any" required>
                                    </div>
                                </div>
                            <?php endfor; ?>
                        </div>
                        <button class="i-btn btn--primary btn--lg"><?php echo e(__('admin.button.save')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            function calculateAdminGainLoss() {
                const referralCommissionInputs = $('.referral-commission-amount');
                const planAmountInput = $('#amount');
                const referralRewardInput = $('#referral-reward');

                let referralCommissionTotal = 0;
                referralCommissionInputs.each(function calculateReferralCommissionTotal() {
                    if ($(this).val() !== '') {
                        referralCommissionTotal += +$(this).val();
                    }
                });

                const planAmount = Number(planAmountInput.val());
                const referralReward = Number(referralRewardInput.val());
                const totalAmount = referralCommissionTotal + referralReward;
                const currency = "<?php echo e(getCurrencyName()); ?>";
                const finalAmount = planAmount - totalAmount;

                if (planAmount > totalAmount) {
                    $('.admin-commission').html(`<span class="text--success"><?php echo e(__('admin.placeholder.take_commission')); ?> : ${parseFloat(finalAmount).toFixed(2)} ${currency}</span>`);

                } else {
                    $('.admin-commission').html(`<span class="text--danger"><?php echo e(__('admin.placeholder.loss_commission')); ?> : ${parseFloat(finalAmount).toFixed(2)} ${currency}</span>`);
                }
            }

            $(document).on('keyup', '.referral-commission-amount, #amount, #referral-reward', function onInputChange() {
                calculateAdminGainLoss();
            });
        });
    </script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/matrix/create.blade.php ENDPATH**/ ?>