<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'exampleModal',
                    'name' => __('admin.filter.parameter'),
                    'icon' => "<i class='fas fa-plus'></i>"
                ],
                 [
                     'type' => 'url',
                     'url' => route('admin.matrix.create'),
                     'name' => __('admin.filter.add_plan'),
                     'icon' => "<i class='fas fa-plus'></i>"
                ]
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'name' => __('admin.table.name'),
                 'amount' => __('admin.table.amount'),
                 'referral_reward' => __('admin.table.referral_bonus'),
                 'plan_profit_loss' => __('admin.table.profit_loss'),
                 'status' => __('admin.table.status'),
                 'action' => __('admin.table.action'),
             ],
             'rows' => $plans,
             'page_identifier' => \App\Enums\PageIdentifier::MATRIX->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('admin.matrix.content.parameter')); ?></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.matrix.parameters')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <label for="height" class="form-label"><?php echo e(__('admin.input.height')); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="height" id="height" value="<?php echo e($matrixHeight); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Enter Height'); ?>">
                            </div>

                            <div class="mb-3">
                                <label for="width" class="form-label"><?php echo e(__('admin.input.width')); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="width" id="width" value="<?php echo e($matrixWidth); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Enter Width'); ?>">
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/matrix/index.blade.php ENDPATH**/ ?>