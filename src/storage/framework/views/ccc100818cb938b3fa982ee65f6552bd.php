<div class="table-container">
    <table id="myTable" class="table">
        <thead>
        <tr>
            <th scope="col"><?php echo e(__('Rank')); ?></th>
            <th scope="col"><?php echo e(__('Name')); ?></th>
            <th scope="col"><?php echo e(__('Current Price')); ?></th>
            <th scope="col"><?php echo e(__('24h Change')); ?></th>
            <th scope="col"><?php echo e(__('Market Cap')); ?></th>
            <th scope="col"><?php echo e(__('Total Volume')); ?></th>
            <th scope="col"><?php echo e(__('Type')); ?></th>
            <th scope="col"><?php echo e(__('Last Updated')); ?></th>
        </tr>
        </thead>
        <tbody>
        <?php $__currentLoopData = $currencyExchanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crypto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td data-label="<?php echo e(__('Rank')); ?>">
                    <div class="rank">
                        <span class="badge bg-primary">#<?php echo e($crypto->rank ?? 'N/A'); ?></span>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Name')); ?>">
                    <div class="our-currency-item">
                        <div class="name d-flex gap-2">
                            <div class="avatar--md">
                                <img src="<?php echo e($crypto->image_url ?? '/default-crypto-icon.png'); ?>" alt="<?php echo e(__($crypto->name)); ?>">
                            </div>
                            <div class="content">
                                <h5><?php echo e(__($crypto->name)); ?></h5>
                                <span><?php echo e(strtoupper($crypto->symbol)); ?> <?php echo e(__('Coin')); ?></span>
                            </div>
                        </div>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Current Price')); ?>">
                    <div class="amount">
                        <strong><?php echo e(shortAmount($crypto->current_price, 8)); ?> <?php echo e($crypto->base_currency ?? '$'); ?></strong>
                        <?php if($crypto->previous_price): ?>
                            <small class="d-block text-muted">
                                <?php echo e(__('Previous')); ?>: <?php echo e(shortAmount($crypto->previous_price, 8)); ?> <?php echo e($crypto->base_currency ?? '$'); ?>

                            </small>
                        <?php endif; ?>
                    </div>
                </td>
                <td data-label="<?php echo e(__('24h Change')); ?>">
                    <div class="rate">
                        <p class="<?php echo e($crypto->change_percent >= 0 ? 'text-success' : 'text-danger'); ?>">
                            <i class="fas fa-<?php echo e($crypto->change_percent >= 0 ? 'arrow-up' : 'arrow-down'); ?>"></i>
                            <?php echo e($crypto->change_percent >= 0 ? '+' : ''); ?><?php echo e(shortAmount($crypto->change_percent, 2)); ?>%
                        </p>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Market Cap')); ?>">
                    <div class="market_cap">
                        <p><?php echo e($crypto->market_cap ? '$' . shortAmount($crypto->market_cap) : 'N/A'); ?></p>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Total Volume')); ?>">
                    <div class="total_volume">
                        <p><?php echo e($crypto->total_volume ? '$' . shortAmount($crypto->total_volume) : 'N/A'); ?></p>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Type')); ?>">
                    <div class="type">
                        <span class="badge bg-info"><?php echo e(ucfirst($crypto->type ?? 'Unknown')); ?></span>
                    </div>
                </td>
                <td data-label="<?php echo e(__('Last Updated')); ?>">
                    <div class="last_updated">
                        <small class="text-muted">
                            <?php echo e($crypto->last_updated ? $crypto->last_updated->diffForHumans() : 'Never'); ?>

                        </small>
                    </div>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/partials/cryptos.blade.php ENDPATH**/ ?>