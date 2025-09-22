<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('User Wallets')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Wallets')); ?></h6>
                        <h4 class="text-dark"><?php echo e(shortAmount($stats['total_wallets'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Primary Balance')); ?></h6>
                        <h4 class="text-dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_primary_balance'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Investment Balance')); ?></h6>
                        <h4 class="text-dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_investment_balance'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Trade Balance')); ?></h6>
                        <h4 class="text-dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_trade_balance'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.wallets.index')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('User Name, Email...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="balance_type"><?php echo e(__('Balance Type')); ?></label>
                                <select name="balance_type" id="balance_type" class="form-control">
                                    <option value=""><?php echo e(__('All Balances')); ?></option>
                                    <option value="primary_balance" <?php echo e(($filters['balance_type'] ?? '') == 'primary_balance' ? 'selected' : ''); ?>><?php echo e(__('Primary Balance')); ?></option>
                                    <option value="investment_balance" <?php echo e(($filters['balance_type'] ?? '') == 'investment_balance' ? 'selected' : ''); ?>><?php echo e(__('Investment Balance')); ?></option>
                                    <option value="trade_balance" <?php echo e(($filters['balance_type'] ?? '') == 'trade_balance' ? 'selected' : ''); ?>><?php echo e(__('Trade Balance')); ?></option>
                                    <option value="practice_balance" <?php echo e(($filters['balance_type'] ?? '') == 'practice_balance' ? 'selected' : ''); ?>><?php echo e(__('Practice Balance')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_from"><?php echo e(__('Date From')); ?></label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                       value="<?php echo e($filters['date_from'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="date_to"><?php echo e(__('Date To')); ?></label>
                                <input type="date" name="date_to" id="date_to" class="form-control"
                                       value="<?php echo e($filters['date_to'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-1 mt-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><?php echo e(__('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('Wallet List')); ?></h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing <?php echo e($wallets->firstItem() ?? 0); ?> to <?php echo e($wallets->lastItem() ?? 0); ?>

                        of <?php echo e($wallets->total() ?? 0); ?> wallets
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Primary Balance')); ?></th>
                        <th><?php echo e(__('Investment Balance')); ?></th>
                        <th><?php echo e(__('Trade Balance')); ?></th>
                        <th><?php echo e(__('Practice Balance')); ?></th>
                        <th><?php echo e(__('Total Balance')); ?></th>
                        <th><?php echo e(__('Created')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <h6 class="mb-1"><?php echo e($wallet->user->fullname ?? 'N/A'); ?></h6>
                                    <small class="text-muted"><?php echo e($wallet->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Primary Balance')); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($wallet->primary_balance)); ?>

                            </td>
                            <td data-label="<?php echo e(__('Investment Balance')); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($wallet->investment_balance)); ?>

                            </td>
                            <td data-label="<?php echo e(__('Trade Balance')); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($wallet->trade_balance)); ?>

                            </td>
                            <td data-label="<?php echo e(__('Practice Balance')); ?>">
                                <strong class="<?php echo e($wallet->practice_balance > 0 ? 'text-info' : 'text-muted'); ?>">
                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($wallet->practice_balance)); ?>

                                </strong>
                            </td>
                            <td data-label="<?php echo e(__('Total Balance')); ?>">
                                <div class="amount-info">
                                    <strong class="text--primary"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($wallet->total_balance)); ?></strong>
                                    <br>
                                    <?php if($wallet->hasBalance()): ?>
                                        <small class="badge badge--success"><?php echo e(__('Active')); ?></small>
                                    <?php else: ?>
                                        <small class="badge badge--secondary"><?php echo e(__('Inactive')); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Created')); ?>">
                                <?php echo e(showDateTime($wallet->created_at, 'd M Y H:i')); ?>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="8"><?php echo e(__('No wallets found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($wallets->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($wallets->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/wallets/index.blade.php ENDPATH**/ ?>