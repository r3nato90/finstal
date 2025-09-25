<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.matrix.enrol'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Matrix\InvestmentStatus::toArrayByKey(),
                    'name' => 'status',
                ],
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
                'name' => __('admin.table.name'),
                'user_id' => __('admin.table.user'),
                'price' => __('admin.table.price'),
                'referral_commissions' => __('admin.user.content.referral'),
                'level_commissions' => __('admin.user.content.level'),
                'status' => __('admin.table.status'),
            ],
            'rows' => $matrixEnrolled,
            'page_identifier' => \App\Enums\PageIdentifier::MATRIX_ENROLLED->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/matrix/enrol.blade.php ENDPATH**/ ?>