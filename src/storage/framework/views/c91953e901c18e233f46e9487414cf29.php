<div class="filter-area">
    <form action="<?php echo e(route('user.transaction')); ?>">
        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
            <div class="col">
                <input type="text" name="search" placeholder="<?php echo e(__('Trx ID')); ?>" value="<?php echo e(request()->get('search')); ?>">
            </div>
            <div class="col">
                <select class="select2-js" name="wallet_type" >
                    <?php $__currentLoopData = App\Enums\Transaction\WalletType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if (! ($status->value == App\Enums\Transaction\WalletType::PRACTICE->value)): ?>
                            <option value="<?php echo e($status->value); ?>" <?php if($status->value == request()->wallet_type): ?> selected <?php endif; ?>><?php echo e($status->name); ?></option>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col">
                <select class="select2-js" name="source" >
                    <?php $__currentLoopData = App\Enums\Transaction\Source::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($source->value); ?>" <?php if($source->value == request()->source): ?> selected <?php endif; ?>><?php echo e($source->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col">
                <input type="text" id="date" class="form-control datepicker-here" name="date"
                   value="<?php echo e(request()->get('date')); ?>" data-range="true" data-multiple-dates-separator=" - "
                   data-language="en" data-position="bottom right" autocomplete="off"
                   placeholder="<?php echo e(__('Date')); ?>">
            </div>
            <div class="col">
                <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i><?php echo e(__('Search')); ?></button>
            </div>
        </div>
    </form>
</div>

<div class="card-body">
    <div class="row align-items-center gy-4 mb-3">
        <div class="table-container">
            <table id="myTable" class="table">
                <thead>
                    <tr>
                        <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                        <th scope="col"><?php echo e(__('Trx')); ?></th>
                        <th scope="col"><?php echo e(__('Amount')); ?></th>
                        <th scope="col"><?php echo e(__('Post Balance')); ?></th>
                        <th scope="col"><?php echo e(__('Charge')); ?></th>
                        <th scope="col"><?php echo e(__('Source')); ?></th>
                        <th scope="col"><?php echo e(__('Wallet')); ?></th>
                        <th scope="col"><?php echo e(__('Details')); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('Initiated At')); ?>"><?php echo e(showDateTime($item->created_at)); ?></td>
                            <td data-label="<?php echo e(__('Trx')); ?>"><?php echo e($item->trx); ?></td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <span class="text--<?php echo e(\App\Enums\Transaction\Type::getTextColor((int)$item->type)); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->amount)); ?>

                                </span>
                            </td>
                            <td data-label="<?php echo e(__('Post Balance')); ?>">
                                <?php echo e(\App\Enums\Transaction\WalletType::getName((int)$item->wallet_type)); ?> : <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->post_balance)); ?>

                            </td>
                            <td data-label="<?php echo e(__('Charge')); ?>">
                                <?php if($item->charge != 0): ?>
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->charge)); ?>

                                <?php else: ?>
                                    <span>N/A</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Source')); ?>">
                                <span class="i-badge <?php echo e(\App\Enums\Transaction\Source::getColor((int)$item->source)); ?>">
                                    <?php echo e(\App\Enums\Transaction\Source::getName((int)$item->source)); ?>

                                </span>
                            </td>
                            <td data-label="<?php echo e(__('Wallet')); ?>">
                                <span class="i-badge <?php echo e(\App\Enums\Transaction\WalletType::getColor((int)$item->wallet_type)); ?>">
                                    <?php echo e(\App\Enums\Transaction\WalletType::getWalletName((int)$item->wallet_type)); ?>

                                </span>
                            </td>
                            <td data-label="<?php echo e(__('Details')); ?>">
                                <?php echo e($item->details); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-white text-center" colspan="100%"><?php echo e(__('No Data Found')); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if($is_paginate): ?>
    <div class="mt-4"><?php echo e($transactions->links()); ?></div>
<?php endif; ?>



<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/transaction.blade.php ENDPATH**/ ?>