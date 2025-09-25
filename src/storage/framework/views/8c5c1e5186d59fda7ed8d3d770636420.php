<?php $__env->startSection('panel'); ?>
    <section>
         <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => true,
            'route' => route('admin.report.transactions'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Transaction\WalletType::toArrayByKey(),
                    'name' => 'wallet_type',
                ],
                 [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' =>  \App\Enums\Transaction\Type::toArrayByKey(),
                    'name' => 'type',
                ],
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\Transaction\Source::toArrayByKey(),
                    'name' => 'source',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.trx')
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
                 'transaction_amount' => __('admin.table.amount'),
                 'transaction_post_balance' => __('admin.table.post_balance'),
                 'transaction_charge' => __('admin.table.charge'),
                 'transaction_wallet_type' => __('admin.table.wallet'),
                 'transaction_source' => __('admin.table.source'),
                 'details' => __('admin.table.details'),
             ],
            'rows' => $transactions,
            'page_identifier' => \App\Enums\PageIdentifier::TRANSACTIONS->value,
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/statistic/transaction.blade.php ENDPATH**/ ?>