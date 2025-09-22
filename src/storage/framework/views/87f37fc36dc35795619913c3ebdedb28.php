<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>

                    <div class="table-container">
                        <table id="myTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo e(__('Asset')); ?></th>
                                <th scope="col"><?php echo e(__('Price')); ?></th>
                                <th scope="col"><?php echo e(__('24h Change')); ?></th>
                                <th scope="col"><?php echo e(__('Type')); ?></th>
                                <th scope="col"><?php echo e(__('Last Updated')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td data-label="<?php echo e(__('Asset')); ?>">
                                        <div class="name d-flex align-items-center justify-content-md-start justify-content-end gap-lg-3 gap-2">
                                            <div class="icon">
                                                <?php if($currency['image_url']): ?>
                                                    <img src="<?php echo e($currency['image_url']); ?>" class="avatar--sm" alt="<?php echo e($currency['name']); ?>" onerror="this.style.display='none'">
                                                <?php else: ?>
                                                    <div class="avatar--sm bg-primary text-white d-flex align-items-center justify-content-center rounded-circle">
                                                        <?php echo e(substr($currency['symbol'], 0, 2)); ?>

                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="content">
                                                <h6 class="fs-14 mb-0"><?php echo e($currency['symbol']); ?></h6>
                                                <span class="fs-13 text--light"><?php echo e($currency['name']); ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td data-label="<?php echo e(__('Price')); ?>">
                                        <span class="fw-bold">$<?php echo e(number_format($currency['current_price'], 8)); ?></span>
                                    </td>
                                    <td data-label="<?php echo e(__('24h Change')); ?>">
                                        <?php if($currency['change_percent'] !== null): ?>
                                            <span class="i-badge <?php echo e($currency['change_percent'] >= 0 ? 'badge--success' : 'badge--danger'); ?>">
                                                <i class="fas <?php echo e($currency['change_percent'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down'); ?>"></i>
                                                <?php echo e($currency['change_percent'] >= 0 ? '+' : ''); ?><?php echo e(number_format($currency['change_percent'], 2)); ?>%
                                            </span>
                                        <?php else: ?>
                                            <span class="text--muted"><?php echo e(__('No Data')); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td data-label="<?php echo e(__('Type')); ?>">
                                        <span class="i-badge badge--primary"><?php echo e(ucfirst($currency['type'])); ?></span>
                                    </td>
                                    <td data-label="<?php echo e(__('Last Updated')); ?>">
                                        <?php if($currency['last_updated']): ?>
                                            <?php echo e(\Carbon\Carbon::parse($currency['last_updated'])->diffForHumans()); ?>

                                        <?php else: ?>
                                            <?php echo e(__('Not Available')); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-white"><?php echo e($currencies->links()); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/trades/market.blade.php ENDPATH**/ ?>