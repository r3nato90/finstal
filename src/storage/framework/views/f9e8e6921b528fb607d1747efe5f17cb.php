<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="filter-action">
                <button type="button" data-bs-toggle="modal" data-bs-target="#referralSettingModal"
                        class="i-btn btn--dark btn--md">
                    <i class="las la-cog"></i><?php echo e(__('Referral Activation')); ?>

                </button>
            </div>
            <div class="row">
                <?php $__currentLoopData = \App\Enums\Referral\ReferralCommissionType::commissionTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $commissionType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header bg--primary">
                                <h4 class="card-title text-white"><?php echo e(__($commissionType)); ?></h4>
                            </div>

                            <div class="card-body">
                                <ul class="list-group detail-list">
                                    <?php $__currentLoopData = $referrals->where('commission_type', $key); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $commissionKey => $referral): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <?php echo e(__('Level')); ?> <?php echo e($referral->level); ?>

                                            <span class="fw-bold fs-14"><?php echo e(shortAmount($referral->percent)); ?> %</span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>

                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter Number of Level"
                                           name="total-level" aria-label="Recipient's username"
                                           aria-describedby="basic-addon2">
                                    <span class="input-group-text pointer level-generate"
                                          id="basic-addon2"><?php echo e(__('Generate')); ?></span>
                                </div>

                                <form action="<?php echo e(route('admin.binary.referral.update')); ?>" method="POST"
                                      class="d-none level-setting-form">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="commission_type" value="<?php echo e($key); ?>">
                                    <h6 class="text-center"><?php echo e(__('The previous setting will be replaced when creating new')); ?></h6>
                                    <div class="referral-setting mt-2"></div>
                                    <button class="i-btn btn--primary btn--md"><?php echo e(__('admin.button.save')); ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <div class="modal fade" id="referralSettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Referral Activation Update')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.referral.setting')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <?php
                                $referralSettings = \App\Models\Setting::get('referral_setting', []);
                            ?>
                            <?php $__currentLoopData = \App\Enums\Referral\ReferralCommissionType::commissionTypes(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $commissionType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-12 mb-3">
                                    <label class="form-label" for="status"><?php echo e(__($commissionType)); ?> <sup
                                            class="text-danger">*</sup></label>
                                    <?php
                                        $columnName = \App\Enums\Referral\ReferralCommissionType::getColumnName((int) $key);
                                        $currentValue = isset($referralSettings[$columnName]) ? $referralSettings[$columnName] : null;
                                    ?>
                                    <select class="form-select" id="status"
                                            name="status[<?php echo e($columnName); ?>]">
                                        <?php $__currentLoopData = \App\Enums\Status::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $statusKey =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>"
                                                    <?php if($currentValue == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($statusKey)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm"
                                data-bs-dismiss="modal"><?php echo e(__('admin.button.close')); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('admin.button.save')); ?></button>
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
            $('.level-generate').on('click', function () {
                const totalLevel = $(this).closest('.card-body').find('input[name="total-level"]').val();
                const form = $(this).closest('.card-body').find('.level-setting-form');
                const referralSetting = $(this).closest('.card-body').find('.referral-setting');

                console.log('Total Level:', totalLevel);
                console.log('Form:', form);
                console.log('Referral Setting:', referralSetting);

                referralSetting.empty();

                if (totalLevel && totalLevel > 0) {
                    for (let i = 1; i <= totalLevel; i++) {
                        const html = `
                        <div class="row remove-field">
                            <div class="col-lg-10">
                                <div class="input-group mb-3">
                                    <span class="input-group-text" id="basic-addon1"><?php echo app('translator')->get('Level'); ?> ${i}</span>
                                    <input type="text" name="percent[]" class="form-control" placeholder="<?php echo app('translator')->get('Commission Percentage'); ?>" aria-label="Username" aria-describedby="basic-addon1">
                                </div>
                            </div>

                            <div class="col-lg-2 mt-md-0 mt-2 text-right">
                                <span class="input-group-btn">
                                    <button class="i-btn btn--danger btn--md text--white removeBtn w-100" type="button">
                                        <i class="las la-times"></i>
                                    </button>
                                </span>
                            </div>
                        </div>`;
                        referralSetting.append(html);
                    }
                    form.removeClass('d-none');
                } else {
                    form.addClass('d-none');
                }
            });

            $(document).on('click', '.removeBtn', function () {
                $(this).closest('.remove-field').remove();
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/referral/index.blade.php ENDPATH**/ ?>