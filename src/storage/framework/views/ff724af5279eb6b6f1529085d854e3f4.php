<?php $__env->startSection('panel'); ?>
    <section>
         <?php echo $__env->make('admin.partials.filter', [
             'is_filter' => true,
             'is_modal' => false,
             'route' => request()->routeIs('admin.matrix.level.commissions') ? route('admin.matrix.level.commissions') : route('admin.matrix.referral.commissions'),
             'btn_name' => __('admin.filter.search'),
             'filters' => [
                 [
                     'type' => \App\Enums\FilterType::TEXT->value,
                     'name' => 'search',
                     'placeholder' => __('admin.filter.placeholder.user_trx')
                 ],
                 [
                     'type' => \App\Enums\FilterType::DATE_RANGE->value,
                     'name' => 'date',
                     'placeholder' => __('admin.filter.placeholder.date')
                 ]
             ],
         ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php echo $__env->make('admin.partials.table', [
             'columns' => [
                 'created_at' => __('admin.table.created_at'),
                 'trx' => __('admin.table.trx'),
                 'user_id' => __('admin.table.user'),
                 'from_user_id' => __('admin.table.from_user'),
                 'amount' => __('admin.table.amount'),
                 'post_balance' => __('admin.table.post_balance'),
                 'details' => __('admin.table.details'),
             ],
             'rows' => $commissions,
             'page_identifier' => \App\Enums\PageIdentifier::COMMISSIONS->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/matrix/commissions.blade.php ENDPATH**/ ?>