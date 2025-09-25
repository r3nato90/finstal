<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => true,
            'urls' => [
                 [
                     'type' => 'url',
                     'url' => route('admin.withdraw.method.create'),
                     'name' => __('Add New Method'),
                     'icon' => "<i class='fas fa-plus'></i>"
                ]
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'name' => __('Name'),
                 'created_at' => __('Initiated At'),
                 'withdraw_rate' => __('Method Currency'),
                 'withdraw_limit' => __('Withdrawal Limit'),
                 'withdraw_charges' => __('Charges'),
                 'status' => __('Status'),
                 'action' => __('Action'),
             ],
             'rows' => $withdrawMethods,
             'page_identifier' => \App\Enums\PageIdentifier::WITHDRAW_METHOD->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/withdraw_method/index.blade.php ENDPATH**/ ?>