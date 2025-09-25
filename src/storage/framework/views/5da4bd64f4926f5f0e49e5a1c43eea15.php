<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                 [
                   'type' => 'modal',
                   'id' => 'stakingPlanModal',
                   'name' => __('Add Plan'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'duration' => __('Duration'),
                 'interest_rate' => __('Interest'),
                 'staking_amount' => __('Amount'),
                 'status' => __('admin.table.status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $stakingPlans,
             'page_identifier' => \App\Enums\PageIdentifier::STAKING_PLAN->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="stakingPlanModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Add New Staking Plan')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.staking.plan.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="duration"><?php echo e(__('Duration')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="duration" id="duration" class="form-control" placeholder="<?php echo e(__('Enter Duration')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(__('Days')); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_rate"><?php echo e(__('Interest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" name="interest_rate" id="interest_rate" class="form-control" placeholder="<?php echo e(__('Enter Interest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(__('%')); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="minimum_amount"><?php echo e(__('Minimum')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" name="minimum_amount" id="minimum_amount" class="form-control" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="maximum_amount"><?php echo e(__('Maximum')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="text" name="maximum_amount" id="maximum_amount" class="form-control" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo e(__('admin.button.close')); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('admin.button.save')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Update Staking Plan')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.staking.plan.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="duration"><?php echo e(__('Duration')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="duration" id="duration" class="form-control" placeholder="<?php echo e(__('Enter Duration')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(__('Days')); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="interest_rate"><?php echo e(__('Interest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="interest_rate" id="interest_rate" class="form-control" placeholder="<?php echo e(__('Enter Interest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(__('%')); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="minimum_amount"><?php echo e(__('Minimum')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="minimum_amount" id="minimum_amount" class="form-control" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="maximum_amount"><?php echo e(__('Maximum')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="maximum_amount" id="maximum_amount" class="form-control" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo e(__('admin.button.close')); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('admin.button.update')); ?></button>
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
            $('.updateBtn').on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const duration = $(this).data('duration');
                const interest_rate = $(this).data('interest_rate');
                const minimum_amount = $(this).data('interest_rate');
                const maximum_amount = $(this).data('maximum_amount');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=duration]').val(duration);
                modal.find('input[name=interest_rate]').val(interest_rate);
                modal.find('input[name=minimum_amount]').val(minimum_amount);
                modal.find('input[name=maximum_amount]').val(maximum_amount);
                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/investment/staking/index.blade.php ENDPATH**/ ?>