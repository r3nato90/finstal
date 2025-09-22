<div class="filter-area">
    <form action="<?php echo e($route); ?>">
        <div class="row row-cols-lg-3 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
            <div class="col">
                <input type="text" name="search" placeholder="<?php echo e(__('Trx ID')); ?>" value="<?php echo e(request()->get('search')); ?>">
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

<div class="table-container">
    <table id="myTable" class="table">
        <thead>
            <tr>
                <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                <th scope="col"><?php echo e(__('Trx')); ?></th>
                <?php if($type != \App\Enums\CommissionType::INVESTMENT->value): ?>
                    <th scope="col"><?php echo e(__('User')); ?></th>
                <?php endif; ?>
                <th scope="col"><?php echo e(__('Amount')); ?></th>
                <th scope="col"><?php echo e(__('Details')); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $commissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $commission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td data-label="<?php echo e(__('Initiated At')); ?>">
                        <?php echo e(showDateTime($commission->created_at)); ?>

                    </td>
                    <td data-label="<?php echo e(__('Trx')); ?>">
                        <?php echo e($commission->trx); ?>

                    </td>
                    <?php if($type != \App\Enums\CommissionType::INVESTMENT->value): ?>
                        <td data-label="<?php echo e(__('User')); ?>">
                            <?php echo e($commission->fromUser->email); ?>

                        </td>
                    <?php endif; ?>
                    <td data-label="<?php echo e(__('Amount')); ?>">
                        <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($commission->amount)); ?>

                    </td>
                    <td data-label="<?php echo e(__('Details')); ?>">
                        <?php echo e($commission->details); ?>

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
<?php /**PATH /var/www/html/finfunder/src/resources/views/user/partials/matrix/commission.blade.php ENDPATH**/ ?>