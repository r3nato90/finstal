<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'rankModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
            ],
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'level' => __('Level'),
                 'invest' => __('Invest'),
                 'team_invest' => __('Team Invest'),
                 'deposit' => __('Deposit'),
                 'referral_count' => __('Referral Count'),
                 'reward' => __('Reward'),
                 'status' => __('Status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $rewards,
             'page_identifier' => \App\Enums\PageIdentifier::REWARD->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="rankModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Add User Reward Setting')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.reward.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('admin.input.name')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo e(__('admin.placeholder.name')); ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="level"><?php echo e(__('Level')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="level" id="level" class="form-control" placeholder="<?php echo e(__('Enter Level Name')); ?>">
                            </div>


                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="invest"><?php echo e(__('Invest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="invest" id="invest" class="form-control" placeholder="<?php echo e(__('Minimum Invest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="team_invest"><?php echo e(__('Team Invest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="team_invest" id="team_invest" class="form-control" placeholder="<?php echo e(__('Minimum Team Invest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="deposit"><?php echo e(__('Deposit')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="deposit" id="deposit" class="form-control" placeholder="<?php echo e(__('Minimum Deposit')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="referral_count"><?php echo e(__('Referral Count')); ?><sup class="text-danger">*</sup></label>
                                <input type="number" name="referral_count" id="referral_count" class="form-control" placeholder="<?php echo e(__('Minimum Referral Count')); ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="reward"><?php echo e(__('Reward')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="reward" id="reward" class="form-control" placeholder="<?php echo e(__('Enter Reward Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status"><?php echo e(__('admin.input.status')); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected><?php echo e(__('admin.filter.placeholder.select')); ?></option>
                                    <?php $__currentLoopData = \App\Enums\Trade\TradeParameterStatus::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>"><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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

    <div class="modal fade" id="rewardUpdateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Update Timetable')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.reward.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('admin.input.name')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo e(__('admin.placeholder.name')); ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="level"><?php echo e(__('Level')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="level" id="level" class="form-control" placeholder="<?php echo e(__('Enter Level Name')); ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="invest"><?php echo e(__('Invest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="invest" id="invest" class="form-control" placeholder="<?php echo e(__('Minimum Invest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="team_invest"><?php echo e(__('Team Invest')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="team_invest" id="team_invest" class="form-control" placeholder="<?php echo e(__('Minimum Team Invest')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="deposit"><?php echo e(__('Deposit')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="deposit" id="deposit" class="form-control" placeholder="<?php echo e(__('Minimum Deposit')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="referral_count"><?php echo e(__('Referral Count')); ?><sup class="text-danger">*</sup></label>
                                <input type="number" name="referral_count" id="referral_count" class="form-control" placeholder="<?php echo e(__('Minimum Referral Count')); ?>">
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="reward"><?php echo e(__('Reward')); ?><sup class="text-danger">*</sup></label>
                                <div class="input-group">
                                    <input type="number" name="reward" id="reward" class="form-control" placeholder="<?php echo e(__('Enter Reward Amount')); ?>" aria-describedby="basic-addon1">
                                    <span class="input-group-text" id="basic-addon1"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label class="form-label" for="status"><?php echo e(__('admin.input.status')); ?> <sup class="text-danger">*</sup></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected><?php echo e(__('admin.filter.placeholder.select')); ?></option>
                                    <?php $__currentLoopData = \App\Enums\Trade\TradeParameterStatus::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>"><?php echo e(replaceInputTitle($key)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
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
                const name = $(this).data('name');
                const level = $(this).data('level');
                const invest = $(this).data('invest');
                const team_invest = $(this).data('team_invest');
                const deposit = $(this).data('deposit');
                const referral_count = $(this).data('referral_count');
                const reward = $(this).data('reward');
                const status = $(this).data('status');

                const modal = $('#rewardUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=level]').val(level);
                modal.find('input[name=invest]').val(invest);
                modal.find('input[name=team_invest]').val(team_invest);
                modal.find('input[name=deposit]').val(deposit);
                modal.find('input[name=referral_count]').val(referral_count);
                modal.find('input[name=reward]').val(reward);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/investment/reward.blade.php ENDPATH**/ ?>