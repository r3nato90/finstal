<?php $__env->startSection('panel'); ?>
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('ICO Token Management')); ?></h3>
        </div>

        <!-- Action Buttons -->
        <div class="filter-action mb-4">
            <a href="<?php echo e(route('admin.ico.token.create')); ?>" class="i-btn btn--primary btn--md">
                <i class="las la-plus"></i> <?php echo e(__('Create New Token')); ?>

            </a>
        </div>

        <!-- Tokens Table Card -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('ICO Tokens')); ?></h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing <?php echo e($tokens->firstItem() ?? 0); ?> to <?php echo e($tokens->lastItem() ?? 0); ?>

                        of <?php echo e($tokens->total() ?? 0); ?> ICO tokens
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th><?php echo e(__('Token Info')); ?></th>
                            <th><?php echo e(__('Price')); ?></th>
                            <th><?php echo e(__('Progress')); ?></th>
                            <th><?php echo e(__('Status')); ?></th>
                            <th><?php echo e(__('Sale Period')); ?></th>
                            <th><?php echo e(__('Actions')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tokens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $token): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('Token Info')); ?>">
                                <div class="token-info">
                                    <h6 class="mb-1"><?php echo e($token->name); ?> (<?php echo e($token->symbol); ?>)</h6>
                                    <small class="text-muted"><?php echo e(Str::limit($token->description, 50)); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Price')); ?>">
                                <div class="price-info">
                                    <strong>$<?php echo e(shortAmount($token->price, 4)); ?></strong>
                                    <?php if($token->current_price != $token->price): ?>
                                        <br><small class="text-muted">Current: <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($token->current_price, 4)); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Progress')); ?>">
                                <?php
                                    $progress = $token->total_supply > 0 ? ($token->tokens_sold / $token->total_supply) * 100 : 0;
                                ?>
                                <div class="progress-info">
                                    <div class="progress mb-1" style="height: 8px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($progress); ?>%"></div>
                                    </div>
                                    <small><?php echo e(shortAmount($token->tokens_sold)); ?> / <?php echo e(shortAmount($token->total_supply)); ?></small>
                                    <br><small class="text-muted"><?php echo e(shortAmount($progress, 1)); ?>% sold</small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($token->status == 'active'): ?>
                                    <span class="badge badge--success"><?php echo e(__('Active')); ?></span>
                                <?php elseif($token->status == 'paused'): ?>
                                    <span class="badge badge--warning"><?php echo e(__('Paused')); ?></span>
                                <?php elseif($token->status == 'completed'): ?>
                                    <span class="badge badge--info"><?php echo e(__('Completed')); ?></span>
                                <?php elseif($token->status == 'cancelled'): ?>
                                    <span class="badge badge--danger"><?php echo e(__('Cancelled')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge--secondary"><?php echo e(__('Unknown')); ?></span>
                                <?php endif; ?>
                                <?php if($token->is_featured): ?>
                                    <br><span class="badge badge--primary mt-1"><?php echo e(__('Featured')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Sale Period')); ?>">
                                <div class="sale-period">
                                    <?php if($token->sale_start_date): ?>
                                        <small><?php echo e(__('Start')); ?>: <?php echo e(showDateTime($token->sale_start_date, 'd M Y')); ?></small>
                                    <?php endif; ?>
                                    <?php if($token->sale_end_date): ?>
                                        <br><small><?php echo e(__('End')); ?>: <?php echo e(showDateTime($token->sale_end_date, 'd M Y')); ?></small>
                                    <?php endif; ?>
                                    <?php if(!$token->sale_start_date && !$token->sale_end_date): ?>
                                        <small class="text-muted"><?php echo e(__('Not set')); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <a href="<?php echo e(route('admin.ico.token.edit', $token->id)); ?>" class="badge badge--primary-transparent"><?php echo e(__('Edit')); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="6"><?php echo e(__('No tokens found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($tokens->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($tokens->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/ico/tokens/index.blade.php ENDPATH**/ ?>