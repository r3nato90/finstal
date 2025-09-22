<?php $__env->startSection('panel'); ?>
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('ICO Sale History')); ?></h3>
        </div>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Sales')); ?></h6>
                        <h4 class="text-dark"><?php echo e(shortAmount($stats['total_sales'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Completed')); ?></h6>
                        <h4 class="text-dark"><?php echo e(shortAmount($stats['completed_sales'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Amount')); ?></h6>
                        <h4 class="text-dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_amount'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Tokens')); ?></h6>
                        <h4 class="text-dark"><?php echo e(shortAmount($stats['total_tokens'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.ico.sale.index')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('Sale ID, User Name, Email...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="pending" <?php echo e(($filters['status'] ?? '') == 'pending' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                    <option value="completed" <?php echo e(($filters['status'] ?? '') == 'completed' ? 'selected' : ''); ?>><?php echo e(__('Completed')); ?></option>
                                    <option value="failed" <?php echo e(($filters['status'] ?? '') == 'failed' ? 'selected' : ''); ?>><?php echo e(__('Failed')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="token"><?php echo e(__('Token')); ?></label>
                                <select name="token" id="token" class="form-control">
                                    <option value=""><?php echo e(__('All Tokens')); ?></option>
                                    <?php $__currentLoopData = $tokens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($token->id); ?>" <?php echo e(($filters['token'] ?? '') == $token->id ? 'selected' : ''); ?>>
                                            <?php echo e($token->name); ?> (<?php echo e($token->symbol); ?>)
                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="date_from"><?php echo e(__('Date From')); ?></label>
                                <input type="date" name="date_from" id="date_from" class="form-control"
                                       value="<?php echo e($filters['date_from'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
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

        <!-- Sales Table Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('Sale History')); ?></h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing <?php echo e($sales->firstItem() ?? 0); ?> to <?php echo e($sales->lastItem() ?? 0); ?>

                        of <?php echo e($sales->total() ?? 0); ?> sales
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('Sale ID')); ?></th>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Token')); ?></th>
                        <th><?php echo e(__('Tokens Sold')); ?></th>
                        <th><?php echo e(__('Total Amount')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('Sale ID')); ?>">
                                <strong><?php echo e($sale->sale_id); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <h6 class="mb-1"><?php echo e($sale->user->fullname ?? 'N/A'); ?></h6>
                                    <small class="text-muted"><?php echo e($sale->user->email ?? 'N/A'); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Token')); ?>">
                                <?php if($sale->icoToken): ?>
                                    <div class="token-info">
                                        <strong><?php echo e($sale->icoToken->name); ?></strong>
                                        <br><small class="text-muted"><?php echo e($sale->icoToken->symbol); ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('N/A')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Tokens Sold')); ?>">
                                <strong><?php echo e(shortAmount($sale->tokens_sold)); ?></strong>
                                <br><small class="text-muted">@ $<?php echo e(shortAmount($sale->sale_price, 4)); ?></small>
                            </td>
                            <td data-label="<?php echo e(__('Total Amount')); ?>">
                                <strong>$<?php echo e(shortAmount($sale->total_amount)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($sale->status == 'completed'): ?>
                                    <span class="badge badge--success"><?php echo e(__('Completed')); ?></span>
                                <?php elseif($sale->status == 'pending'): ?>
                                    <span class="badge badge--warning"><?php echo e(__('Pending')); ?></span>
                                <?php elseif($sale->status == 'failed'): ?>
                                    <span class="badge badge--danger"><?php echo e(__('Failed')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge--secondary"><?php echo e(__('Unknown')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <?php if($sale->sold_at): ?>
                                    <?php echo e(showDateTime($sale->sold_at, 'd M Y H:i')); ?>

                                <?php else: ?>
                                    <?php echo e(showDateTime($sale->created_at, 'd M Y H:i')); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="7"><?php echo e(__('No sales found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($sales->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($sales->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/ico/tokens/sale-history.blade.php ENDPATH**/ ?>