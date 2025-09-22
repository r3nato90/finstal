<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => false,
            'is_modal' => false,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.partials.table', [
            'columns' => [
                'payment_gateway_name' => __('admin.table.name'),
                'created_at' => __('admin.table.created_at'),
                'payment_limit' => __('Payment Limit'),
                'percent_charge' => __('admin.table.percent_charge'),
                'rate' => __('admin.table.method_currency'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action')
            ],
            'rows' => $gateways,
            'page_identifier' => \App\Enums\PageIdentifier::PAYMENT_GATEWAY->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/payment_gateway/index.blade.php ENDPATH**/ ?>