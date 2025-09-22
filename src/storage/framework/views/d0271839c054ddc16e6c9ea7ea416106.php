<?php use App\Enums\Transaction\Type; use App\Enums\Transaction\WalletType; use App\Enums\Transaction\Source; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Transaction Logs Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Transactions')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalTransactions'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Credit')); ?></h6>
                        <h4 class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalCredit'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Debit')); ?></h6>
                        <h4 class="text--danger"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalDebit'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Charge')); ?></h6>
                        <h4 class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalCharge'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Today Transactions')); ?></h6>
                        <h3 class="text--info"><?php echo e(shortAmount($stats['todayTransactions'])); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.report.transactions')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('TRX, User, Details...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type"><?php echo e(__('Transaction Type')); ?></label>
                                <select name="type" id="type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="1" <?php echo e(($filters['type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Add Balance')); ?></option>
                                    <option value="2" <?php echo e(($filters['type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Subtract Balance')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="wallet_type"><?php echo e(__('Wallet Type')); ?></label>
                                <select name="wallet_type" id="wallet_type" class="form-control">
                                    <option value=""><?php echo e(__('All Wallets')); ?></option>
                                    <option value="1" <?php echo e(($filters['wallet_type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Primary Balance')); ?></option>
                                    <option value="2" <?php echo e(($filters['wallet_type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Investment Balance')); ?></option>
                                    <option value="3" <?php echo e(($filters['wallet_type'] ?? '') == '3' ? 'selected' : ''); ?>><?php echo e(__('Trade Balance')); ?></option>
                                    <option value="4" <?php echo e(($filters['wallet_type'] ?? '') == '4' ? 'selected' : ''); ?>><?php echo e(__('Practice Balance')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="source"><?php echo e(__('Source')); ?></label>
                                <select name="source" id="source" class="form-control">
                                    <option value=""><?php echo e(__('All Sources')); ?></option>
                                    <option value="1" <?php echo e(($filters['source'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('All')); ?></option>
                                    <option value="2" <?php echo e(($filters['source'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Matrix')); ?></option>
                                    <option value="3" <?php echo e(($filters['source'] ?? '') == '3' ? 'selected' : ''); ?>><?php echo e(__('Investment')); ?></option>
                                    <option value="4" <?php echo e(($filters['source'] ?? '') == '4' ? 'selected' : ''); ?>><?php echo e(__('Trade')); ?></option>
                                    <option value="5" <?php echo e(($filters['source'] ?? '') == '5' ? 'selected' : ''); ?>><?php echo e(__('ICO')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="trx" <?php echo e(($filters['sort_field'] ?? '') == 'trx' ? 'selected' : ''); ?>><?php echo e(__('TRX')); ?></option>
                                    <option value="amount" <?php echo e(($filters['sort_field'] ?? '') == 'amount' ? 'selected' : ''); ?>><?php echo e(__('Amount')); ?></option>
                                    <option value="type" <?php echo e(($filters['sort_field'] ?? '') == 'type' ? 'selected' : ''); ?>><?php echo e(__('Type')); ?></option>
                                    <option value="wallet_type" <?php echo e(($filters['sort_field'] ?? '') == 'wallet_type' ? 'selected' : ''); ?>><?php echo e(__('Wallet Type')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
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
            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('TRX')); ?></th>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Post Balance')); ?></th>
                        <th><?php echo e(__('Charge')); ?></th>
                        <th><?php echo e(__('Type')); ?></th>
                        <th><?php echo e(__('Wallet Type')); ?></th>
                        <th><?php echo e(__('Source')); ?></th>
                        <th><?php echo e(__('Details')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $transactionLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('TRX')); ?>">
                                <strong><?php echo e($transaction->trx ?? 'N/A'); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($transaction->user->fullname ?? 'Unknown'); ?></strong>
                                    <br><small class="text-muted"><?php echo e($transaction->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <?php
                                    $amountClass = $transaction->type == Type::PLUS->value ? 'text--success' : 'text--danger';
                                    $amountSign = $transaction->type == Type::PLUS->value ? '+' : '-';
                                ?>
                                <strong class="<?php echo e($amountClass); ?>"><?php echo e($amountSign); ?><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($transaction->amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Post Balance')); ?>">
                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($transaction->post_balance, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Charge')); ?>">
                                <?php if($transaction->charge > 0): ?>
                                    <strong class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($transaction->charge, 2)); ?></strong>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(getCurrencySymbol()); ?>0.00</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Type')); ?>">
                                <?php
                                    $typeClass = Type::getTextColor($transaction->type);
                                    $typeName = Type::getName($transaction->type);
                                ?>
                                <span class="badge badge--<?php echo e($typeClass); ?>"><?php echo e($typeName); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Wallet Type')); ?>">
                                <?php
                                    $walletClass = WalletType::getColor($transaction->wallet_type);
                                    $walletName = WalletType::getName($transaction->wallet_type);
                                ?>
                                <span class="badge <?php echo e($walletClass); ?>"><?php echo e($walletName); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Source')); ?>">
                                <?php
                                    $sourceClass = Source::getColor($transaction->source);
                                    $sourceName = Source::getName($transaction->source);
                                ?>
                                <span class="badge <?php echo e($sourceClass); ?>"><?php echo e($sourceName); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Details')); ?>">
                                <span class="text-muted"><?php echo e(Str::limit($transaction->details ?? 'N/A', 30)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <div class="time-info">
                                    <strong><?php echo e($transaction->created_at->format('M d, H:i')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($transaction->created_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="10"><?php echo e(__('No transaction logs found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($transactionLogs->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($transactionLogs->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/statistic/transaction.blade.php ENDPATH**/ ?>