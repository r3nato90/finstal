<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
            'is_filter' => true,
            'is_modal' => false,
            'route' => route('admin.user.index'),
            'btn_name' => __('admin.filter.search'),
            'filters' => [
                [
                    'type' => \App\Enums\FilterType::SELECT_OPTIONS->value,
                    'value' => \App\Enums\User\Status::toArrayByKey(),
                    'name' => 'status',
                ],
                [
                    'type' => \App\Enums\FilterType::TEXT->value,
                    'name' => 'search',
                    'placeholder' => __('admin.filter.placeholder.user')
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
                'created_at' => __('admin.table.joined'),
                'full_name' => __('admin.table.name'),
                'email' => __('admin.table.email'),
                'user_wallet' => __('admin.table.wallet'),
                'user_kyc_status' => __('KYC Status'),
                'user_add_subtract' => __('admin.table.add_subtract'),
                'status' => __('admin.table.status'),
                'action' => __('admin.table.action'),
            ],
            'rows' => $users,
            'page_identifier' => \App\Enums\PageIdentifier::USER->value,
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="credit-add-return" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('admin.user.content.add_subtract')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.user.add-subtract.balance')); ?>" method="POST">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type" class="form-label"> <?php echo e(__('admin.input.type')); ?> <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="type" id="type" required>
                                <?php $__currentLoopData = \App\Enums\Transaction\Type::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(\App\Enums\Transaction\Type::getName($status)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wallet_type" class="form-label"> <?php echo e(__('admin.input.select_wallet')); ?> <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="wallet_type" id="wallet_type" required>
                                <?php $__currentLoopData = \App\Enums\Transaction\WalletType::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(\App\Enums\Transaction\WalletType::getName($status)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label"> <?php echo e(__('admin.input.amount')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" name="amount"
                                    placeholder="<?php echo e(__('admin.placeholder.number')); ?>" aria-label="Recipient's username"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"> <?php echo e(__('admin.button.cancel')); ?></button>
                            <button type="submit" class="btn btn--primary btn--sm"> <?php echo e(__('admin.button.save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="list-wallet" tabindex="-1" aria-labelledby="list-wallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('admin.user.content.wallet')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="modal-pay-list"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal"><?php echo e(__('admin.button.closed')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.created-update').on('click', function () {
                const modal = $('#credit-add-return');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.wallets').on('click', function () {
                $('.modal-pay-list').empty();
                const modal = $('#list-wallet');
                const walletData = $(this).data('id');
                const currency = "<?php echo e(getCurrencySymbol()); ?>";
                const walletProperties = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];
                walletProperties.forEach(property => {
                    const propertyName = property.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const balanceValue = currency + parseFloat(walletData[property]).toFixed(2);
                    const listItem = `<li>
                            <span>${propertyName}</span>
                            <span>${balanceValue}</span>
                          </li>`;

                    modal.find('.modal-pay-list').append(listItem);
                });

                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/user/index.blade.php ENDPATH**/ ?>