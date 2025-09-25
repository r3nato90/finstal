<?php use App\Enums\Investment\Status; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Investment Logs Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Investments')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalInvestments'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Profit Completed')); ?></h6>
                        <h4 class="text--info"><?php echo e(shortAmount($stats['profitCompletedInvestments'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Completed')); ?></h6>
                        <h4 class="text--success"><?php echo e(shortAmount($stats['completedInvestments'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Invested')); ?></h6>
                        <h4 class="text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalInvestedAmount'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Profit Paid')); ?></h6>
                        <h3 class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalProfitPaid'])); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.investment.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('UID, TRX, User...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="plan"><?php echo e(__('Investment Plan')); ?></label>
                                <select name="plan" id="plan" class="form-control">
                                    <option value=""><?php echo e(__('All Plans')); ?></option>
                                    <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $planId => $planName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($planId); ?>" <?php echo e(($filters['plan'] ?? '') == $planId ? 'selected' : ''); ?>>
                                            <?php echo e($planName); ?>

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
                                    <option value="2" <?php echo e(($filters['status'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Profit Completed')); ?></option>
                                    <option value="3" <?php echo e(($filters['status'] ?? '') == '3' ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
                                    <option value="4" <?php echo e(($filters['status'] ?? '') == '4' ? 'selected' : ''); ?>><?php echo e(__('Cancelled')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="recapture_type"><?php echo e(__('Recapture Type')); ?></label>
                                <select name="recapture_type" id="recapture_type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="1" <?php echo e(($filters['recapture_type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Lifetime')); ?></option>
                                    <option value="2" <?php echo e(($filters['recapture_type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Repeat')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="uid" <?php echo e(($filters['sort_field'] ?? '') == 'uid' ? 'selected' : ''); ?>><?php echo e(__('UID')); ?></option>
                                    <option value="plan_name" <?php echo e(($filters['sort_field'] ?? '') == 'plan_name' ? 'selected' : ''); ?>><?php echo e(__('Plan Name')); ?></option>
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
                        <th><?php echo e(__('Plan')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Interest Rate')); ?></th>
                        <th><?php echo e(__('Period')); ?></th>
                        <th><?php echo e(__('Profit')); ?></th>
                        <th><?php echo e(__('Should Pay')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Next Profit')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $investmentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('UID')); ?>">
                                <strong><?php echo e($investment->uid); ?></strong>
                                <br><small class="text-dark">TRX: <?php echo e($investment->trx); ?></small>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($investment->user->fullname ?? 'Unknown'); ?></strong>
                                    <br><small class="text-muted"><?php echo e($investment->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Plan')); ?>">
                                <strong><?php echo e($investment->plan_name ?? 'N/A'); ?></strong>
                                <?php if($investment->time_table_name && $investment->hours): ?>
                                    <br><small class="text-muted"><?php echo e($investment->time_table_name); ?> (<?php echo e($investment->hours); ?>h)</small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Interest Rate')); ?>">
                                <span class="badge badge--info"><?php echo e(shortAmount($investment->interest_rate, 2)); ?>%</span>
                            </td>
                            <td data-label="<?php echo e(__('Period')); ?>">
                                <?php if($investment->period && $investment->time_table_name): ?>
                                    <span class="badge badge--primary"><?php echo e($investment->period); ?> <?php echo e($investment->time_table_name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                                <?php if($investment->return_duration_count > 0): ?>
                                    <br><small class="text-muted">Returns: <?php echo e($investment->return_duration_count); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Profit')); ?>">
                                <strong class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->profit, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Should Pay')); ?>">
                                <?php if($investment->should_pay > 0): ?>
                                    <strong class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->should_pay, 2)); ?></strong>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(getCurrencySymbol()); ?>0.00</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php
                                    $statusClass = Status::getColor($investment->status);
                                    $statusText = Status::getName($investment->status);
                                ?>
                                <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($statusText)); ?></span>
                                <?php if($investment->is_reinvest): ?>
                                    <br><span class="badge badge--warning-transparent">Reinvest</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Next Profit')); ?>">
                                <?php if($investment->status == 1 && $investment->profit_time): ?>
                                    <div class="time-info">
                                        <strong><?php echo e($investment->profit_time->format('M d, H:i')); ?></strong>
                                        <br><small class="text-muted"><?php echo e($investment->profit_time->diffForHumans()); ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                               <a href="<?php echo e(route('admin.binary.details', $investment->id)); ?>">Details</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="11"><?php echo e(__('No investment logs found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($investmentLogs->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($investmentLogs->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/investment/index.blade.php ENDPATH**/ ?>