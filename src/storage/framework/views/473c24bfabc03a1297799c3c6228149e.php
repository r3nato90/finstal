<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <?php if($matrixLog): ?>
                    <div class="i-card-sm mb-4">
                        <h4 class="title"><?php echo e(__('Matrix Enrolled Information')); ?></h4>
                        <div class="row g-3 row-cols-xl-4 row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1">
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Initiated At')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(showDateTime($matrixLog->created_at)); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Trx')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e($matrixLog->trx); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Schema Name')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e($matrixLog->name); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Invest Amount')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($matrixLog->price)); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('User-Based Referral Bonus')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($matrixLog->referral_reward)); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Referral Commission')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($matrixLog->referral_commissions)); ?></h5>
                                </div>
                            </div>
                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Level Commission')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($matrixLog->level_commissions)); ?></h5>
                                </div>
                            </div>

                            <div class="col">
                                <div class="i-card-sm p-3 primary--light shadow-none p-3">
                                    <p class="fs-15"><?php echo e(__('Status')); ?></p>
                                    <h5 class="title-sm mb-0"><?php echo e(\App\Enums\Matrix\InvestmentStatus::getName($matrixLog->status)); ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="i-card-sm">
                    <div class="card-body">
                        <div class="row align-items-center gy-4">
                            <?php echo $__env->make('user.partials.matrix.plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrixTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('user.matrix.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p class="text-white"><?php echo e(__("Are you sure you want to enroll in this matrix scheme?")); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--sm"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.enroll-matrix-process').click(function () {
                const uid = $(this).data('uid');
                const name = $(this).data('name');

                $('input[name="uid"]').val(uid);
                const title = " Join " + name + " Matrix Scheme";
                $('#matrixTitle').text(title);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/matrix/index.blade.php ENDPATH**/ ?>