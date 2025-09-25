<div class="row align-items-center gy-4">
    <?php $__currentLoopData = $investments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $investment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-xxl-4 col-xl-4 col-lg-6 col-md-6">
            <div class="pricing-item style-two">
                <?php if($investment->is_recommend): ?>
                    <div class="recommend">
                        <span><?php echo e(__('Recommend')); ?></span>
                    </div>
                <?php endif; ?>

                <div class="header">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="title"><?php echo e($investment->name); ?></h4>
                        <?php if($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value): ?>
                            <div class="price mt-0"><?php echo e((int)$investment->duration); ?> <?php echo e($investment->timeTable->name ?? ''); ?></div>
                        <?php else: ?>
                            <div class="price mt-0"><?php echo e(__('Lifetime')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap align-items-center gap-2">
                        <p class="text-start fs-16 mb-0"><?php echo e(__('Interest Rate')); ?>: <span> <?php echo e(shortAmount($investment->interest_rate)); ?><?php echo e(\App\Enums\Investment\InterestType::getSymbol($investment->interest_type)); ?> </span></p>
                        <button class="fs-15 terms-policy bg-transparent" type="button"
                            data-bs-toggle="modal"
                            data-bs-target="#termsModal"
                            data-terms_policy="<?php echo $investment->terms_policy ?>"
                        >
                            <i class="bi bi-info-circle me-2 color--primary"></i><?php echo e(__('Terms and Policies')); ?>

                        </button>
                    </div>
                </div>
                <div class="body">
                    <h6 class="mb-4">
                        <span class="text--light">
                            <?php echo e(__('Investment amount limit')); ?>

                        </span> : <?php if($investment->type == \App\Enums\Investment\InvestmentRage::RANGE->value): ?>
                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->minimum)); ?>

                            - <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->maximum)); ?>

                        <?php else: ?>
                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investment->amount)); ?>

                        <?php endif; ?>
                    </h6>
                    <ul class="pricing-list">
                        <?php if(!empty($investment->meta)): ?>
                            <?php $__currentLoopData = $investment->meta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <span><?php echo e($value); ?></span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                    <h6 class="mb-4">
                        <span class="text-end text--light"><?php echo e(__('Total Return')); ?></span> :
                        <?php if($investment->interest_return_type == \App\Enums\Investment\ReturnType::REPEAT->value): ?>
                            <?php echo e(totalInvestmentInterest($investment)); ?>

                        <?php else: ?>
                            <?php echo app('translator')->get('Unlimited'); ?>
                        <?php endif; ?>

                        <?php if($investment->recapture_type == \App\Enums\Investment\Recapture::HOLD->value): ?>
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" title="Hold capital & reinvest">
                                  <i class="bi bi-info-circle me-2 color--primary"></i>
                            </span>
                        <?php endif; ?>
                    </h6>
                </div>
                <div class="footer">
                    <button
                        class="i-btn btn--dark btn--lg capsuled w-100 invest-process"
                        data-bs-toggle="modal"
                        data-bs-target="#investModal"
                        data-name="<?php echo e($investment->name); ?>"
                        data-uid="<?php echo e($investment->uid); ?>"
                    ><?php echo e(__('Invest Now')); ?></button>
                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/investment/plan.blade.php ENDPATH**/ ?>