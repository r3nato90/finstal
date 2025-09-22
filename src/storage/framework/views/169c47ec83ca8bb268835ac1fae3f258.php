<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
           'is_filter' => false,
           'is_modal' => true,
           'urls' => [
               [
                   'type' => 'modal',
                   'id' => 'holidaySettingModal',
                   'name' => __('Add New'),
                   'icon' => "<i class='las la-plus'></i>"
               ],
               [
                   'type' => 'modal',
                   'id' => 'weeklySettingModal',
                   'name' => __('Weekly Holiday'),
                   'icon' => "<i class='las la-cog'></i>"
               ],
           ],
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'name' => __('admin.table.name'),
                 'holiday_date' => __('Date'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $holidays,
             'page_identifier' => \App\Enums\PageIdentifier::HOLIDAY_SETTING->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="weeklySettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Weekly Holiday Setting')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.holiday-setting.setting')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label"><?php echo e(__('Select weekly holidays')); ?></label>
                                <?php $__currentLoopData = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="form-check">
                                        <input class="form-check-input" <?php if(in_array($value, (array)\App\Models\Setting::get('holiday_setting', []))): ?> checked <?php endif; ?> type="checkbox" id="<?php echo e($value); ?>" name="holidays[]" value="<?php echo e($value); ?>">
                                        <label class="form-check-label" for="<?php echo e($value); ?>"><?php echo e(__(ucfirst($value))); ?></label>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

    <div class="modal fade" id="holidaySettingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Add Holiday')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.holiday-setting.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('admin.input.name')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo e(__('admin.placeholder.name')); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('Date')); ?><sup class="text-danger">*</sup></label>
                                <input type="date" name="date" id="date" class="form-control">
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
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Update Holiday')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.binary.holiday-setting.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('admin.input.name')); ?><sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo e(__('admin.placeholder.name')); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo e(__('Date')); ?><sup class="text-danger">*</sup></label>
                                <input type="date" name="date" id="date" class="form-control">
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
                const date = $(this).data('date');

                const modal = $('#updateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=date]').val(date);
                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/holiday/index.blade.php ENDPATH**/ ?>