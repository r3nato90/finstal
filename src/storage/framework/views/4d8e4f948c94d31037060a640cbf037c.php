<?php use App\Enums\Payment\Deposit\Status; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Deposit Logs Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Deposits')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalDeposits'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Initiated')); ?></h6>
                        <h4 class="text--primary"><?php echo e(shortAmount($stats['initiatedDeposits'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Pending')); ?></h6>
                        <h4 class="text--info"><?php echo e(shortAmount($stats['pendingDeposits'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Success')); ?></h6>
                        <h4 class="text--success"><?php echo e(shortAmount($stats['successDeposits'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Cancelled')); ?></h6>
                        <h4 class="text--danger"><?php echo e(shortAmount($stats['cancelledDeposits'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Deposit Amount')); ?></h6>
                        <h3 class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalDepositAmount'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Charges')); ?></h6>
                        <h3 class="text--info"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalCharges'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Net Credit Amount')); ?></h6>
                        <h3 class="text--primary"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalFinalAmount'])); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.deposit.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('TRX, User, Amount...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="gateway"><?php echo e(__('Payment Gateway')); ?></label>
                                <select name="gateway" id="gateway" class="form-control">
                                    <option value=""><?php echo e(__('All Gateways')); ?></option>
                                    <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gatewayId => $gatewayName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($gatewayId); ?>" <?php echo e(($filters['gateway'] ?? '') == $gatewayId ? 'selected' : ''); ?>>
                                            <?php echo e($gatewayName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="1" <?php echo e(($filters['status'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Initiated')); ?></option>
                                    <option value="2" <?php echo e(($filters['status'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                    <option value="3" <?php echo e(($filters['status'] ?? '') == '3' ? 'selected' : ''); ?>><?php echo e(__('Success')); ?></option>
                                    <option value="4" <?php echo e(($filters['status'] ?? '') == '4' ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="wallet_type"><?php echo e(__('Wallet Type')); ?></label>
                                <select name="wallet_type" id="wallet_type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="1" <?php echo e(($filters['wallet_type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Primary Wallet')); ?></option>
                                    <option value="2" <?php echo e(($filters['wallet_type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Investment Wallet')); ?></option>
                                    <option value="3" <?php echo e(($filters['wallet_type'] ?? '') == '3' ? 'selected' : ''); ?>><?php echo e(__('Trade Wallet')); ?></option>
                                    <option value="4" <?php echo e(($filters['wallet_type'] ?? '') == '4' ? 'selected' : ''); ?>><?php echo e(__('Practice Wallet')); ?></option>
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
                                    <option value="status" <?php echo e(($filters['sort_field'] ?? '') == 'status' ? 'selected' : ''); ?>><?php echo e(__('Status')); ?></option>
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
                        <th><?php echo e(__('Gateway')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Charge')); ?></th>
                        <th><?php echo e(__('Final Amount')); ?></th>
                        <th><?php echo e(__('Net Credit')); ?></th>
                        <th><?php echo e(__('Currency')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('TRX')); ?>">
                                <strong><?php echo e($deposit->trx); ?></strong>
                                <?php if($deposit->is_crypto_payment): ?>
                                    <br><span class="badge badge--info-transparent">Crypto</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($deposit->user->fullname ?? 'Unknown'); ?></strong>
                                    <br><small class="text-muted"><?php echo e($deposit->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Gateway')); ?>">
                                <strong><?php echo e($deposit->gateway->name ?? 'N/A'); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Charge')); ?>">
                                <span class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->charge, 2)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Final Amount')); ?>">
                                <strong class="text--info"><?php echo e(shortAmount($deposit->final_amount * $deposit->rate, 2)); ?> <?php echo e($deposit->currency ?? getCurrencyName()); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Net Credit')); ?>">
                                <strong class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->final_amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Currency')); ?>">
                                <span class="badge badge--primary"><?php echo e(strtoupper($deposit->currency ?? getCurrencyName())); ?></span>
                                <?php if($deposit->rate != 1): ?>
                                    <br><small class="text-muted">Rate: <?php echo e(shortAmount($deposit->rate, 4)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php
                                    $statusClass = Status::getColor($deposit->status);
                                    $statusText = Status::getName($deposit->status);
                                ?>
                                <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($statusText)); ?></span>
                                <?php if($deposit->wallet_type): ?>
                                    <br><span class="mt-1 badge <?php echo e(\App\Enums\Transaction\WalletType::getColor($deposit->wallet_type)); ?>">
                                        <?php echo e(\App\Enums\Transaction\WalletType::getWalletName($deposit->wallet_type)); ?>

                                    </span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <div class="time-info">
                                    <strong><?php echo e($deposit->created_at->format('M d, H:i')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($deposit->created_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <a href="<?php echo e(route('admin.deposit.details', $deposit->id)); ?>" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="11"><?php echo e(__('No deposit logs found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($deposits->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($deposits->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/deposit/index.blade.php ENDPATH**/ ?>