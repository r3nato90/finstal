<?php use App\Enums\Payment\Withdraw\Status; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Withdraw Logs Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Withdraws')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalWithdraws'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Initiated')); ?></h6>
                        <h4 class="text--primary"><?php echo e(shortAmount($stats['initiatedWithdraws'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Pending')); ?></h6>
                        <h4 class="text--info"><?php echo e(shortAmount($stats['pendingWithdraws'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Success')); ?></h6>
                        <h4 class="text--success"><?php echo e(shortAmount($stats['successWithdraws'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Cancelled')); ?></h6>
                        <h4 class="text--danger"><?php echo e(shortAmount($stats['cancelledWithdraws'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Withdraw Amount')); ?></h6>
                        <h3 class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalWithdrawAmount'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Charges')); ?></h6>
                        <h3 class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalCharges'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Final Amount')); ?></h6>
                        <h3 class="text--info"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalFinalAmount'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total After Charge')); ?></h6>
                        <h3 class="text--primary"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalAfterCharge'])); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.withdraw.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('UID, TRX, User, Amount...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="method"><?php echo e(__('Withdraw Method')); ?></label>
                                <select name="method" id="method" class="form-control">
                                    <option value=""><?php echo e(__('All Methods')); ?></option>
                                    <?php $__currentLoopData = $withdrawMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $methodId => $methodName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($methodId); ?>" <?php echo e(($filters['method'] ?? '') == $methodId ? 'selected' : ''); ?>>
                                            <?php echo e($methodName); ?>

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
                                <label for="currency"><?php echo e(__('Currency')); ?></label>
                                <select name="currency" id="currency" class="form-control">
                                    <option value=""><?php echo e(__('All Currencies')); ?></option>
                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencyCode => $currencyName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($currencyCode); ?>" <?php echo e(($filters['currency'] ?? '') == $currencyCode ? 'selected' : ''); ?>>
                                            <?php echo e(strtoupper($currencyName)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="uid" <?php echo e(($filters['sort_field'] ?? '') == 'uid' ? 'selected' : ''); ?>><?php echo e(__('UID')); ?></option>
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
                        <th><?php echo e(__('UID')); ?></th>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Method')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Charge')); ?></th>
                        <th><?php echo e(__('Final Amount')); ?></th>
                        <th><?php echo e(__('After Charge')); ?></th>
                        <th><?php echo e(__('Currency')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $withdrawLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('UID')); ?>">
                                <strong><?php echo e($withdraw->uid); ?></strong>
                                <?php if($withdraw->trx): ?>
                                    <br><small class="text-muted">TRX: <?php echo e($withdraw->trx); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($withdraw->user->fullname ?? 'Unknown'); ?></strong>
                                    <br><small class="text-muted"><?php echo e($withdraw->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Method')); ?>">
                                <strong><?php echo e($withdraw->withdrawMethod->name ?? 'N/A'); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Charge')); ?>">
                                <span class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdraw->charge, 2)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Final Amount')); ?>">
                                <strong class="text--info"><?php echo e(shortAmount($withdraw->final_amount, 2)); ?> <?php echo e($withdraw->currency ?? getCurrencyName()); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('After Charge')); ?>">
                                <strong class="text--success"><?php echo e(shortAmount($withdraw->after_charge, 2)); ?> <?php echo e($withdraw->currency ?? getCurrencyName()); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Currency')); ?>">
                                <span class="badge badge--primary"><?php echo e(strtoupper($withdraw->currency ?? getCurrencyName())); ?></span>
                                <?php if($withdraw->rate != 1): ?>
                                    <br><small class="text-muted">Rate: <?php echo e(shortAmount($withdraw->rate, 4)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php
                                    $statusClass = Status::getColor($withdraw->status);
                                    $statusText = Status::getName($withdraw->status);
                                ?>
                                <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($statusText)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <div class="time-info">
                                    <strong><?php echo e($withdraw->created_at->format('M d, H:i')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($withdraw->created_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <a href="<?php echo e(route('admin.withdraw.details', $withdraw->id)); ?>" class="btn btn-sm btn-outline-primary">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="11"><?php echo e(__('No withdraw logs found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($withdrawLogs->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($withdrawLogs->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/withdraw/index.blade.php ENDPATH**/ ?>