<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
?>
<?php $__currentLoopData = $matrix; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
        <div class="pricing-item card-style">
            <?php if($plan->is_recommend): ?>
                <div class="recommend">
                    <span><?php echo e(__('Recommend')); ?></span>
                </div>
            <?php endif; ?>
            <div class="icon">
                <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'award_image'))); ?>" alt="<?php echo e(__('Award Image')); ?>" border="0">
            </div>
            <div class="header">
                <div class="price"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->amount)); ?></div>
                <h4 class="title"><?php echo e($plan->name); ?></h4>
                <div class="price-info">
                    <h6 class="mb-1"><?php echo e(__('Straightforward Referral Reward')); ?>: <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->referral_reward)); ?></h6>
                    <h6 class="mb-2"><?php echo e(__('Aggregate Level Commission')); ?>: <?php echo e(getCurrencySymbol()); ?><?php echo e(\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id)); ?></h6>
                    <p class="mb-0"><?php echo e(__('Get back')); ?> <span><?php echo e(shortAmount((\App\Services\Investment\MatrixService::calculateAggregateCommission((int)$plan->id) / $plan->amount) * 100)); ?>%</span> <?php echo e(__('of what you invested')); ?></p>
                </div>
            </div>
            <div class="body">
                <ul class="pricing-list">
                    <?php $__currentLoopData = \App\Services\Investment\MatrixService::calculateTotalLevel($plan->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $matrix = pow(\App\Services\Investment\MatrixService::getMatrixWidth(), $loop->iteration)
                        ?>
                        <li>
                            <?php echo e(__('Level')); ?>-<?php echo e($loop->iteration); ?> <span class="px-2">>></span>
                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($value->amount)); ?>x<?php echo e($matrix); ?> =
                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($value->amount * $matrix)); ?>

                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <div class="footer">
                <button class="i-btn btn--primary btn--lg capsuled w-100 enroll-matrix-process"
                    data-bs-toggle="modal"
                    data-bs-target="#enrollMatrixModal"
                    data-uid="<?php echo e($plan->uid); ?>"
                    data-name="<?php echo e($plan->name); ?>"
                ><?php echo e(__('Start Investing Now')); ?></button>
            </div>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/matrix/plan.blade.php ENDPATH**/ ?>