<?php
    $stakingInvestmentSetting = \App\Models\Setting::get('investment_staking_investment', 1);
?>

<?php if($stakingInvestmentSetting == 1): ?>
    <?php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::STAKING_INVESTMENT, \App\Enums\Frontend\Content::FIXED);
    ?>
    <div class="investment-section pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center g-4">
                <div class="col-lg-7">
                    <div class="section-title text-center mb-60">
                        <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading') ?? ''); ?></h2>
                        <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading') ?? ''); ?></p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <?php $__currentLoopData = $stakingInvestments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stakingInvestment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-6">
                        <div class="invest-card">
                            <div class="interest">
                                <h4><?php echo e(shortAmount($stakingInvestment->interest_rate)); ?>%</h4>
                                <span><?php echo e(__('Interest')); ?></span>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-sm-4">
                                    <div class="info-item">
                                        <span><?php echo e(__('Duration')); ?></span>
                                        <span><?php echo e($stakingInvestment->duration); ?> <?php echo e(__('Days')); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="info-item">
                                        <span><?php echo e(__('Capital Limit')); ?></span>
                                        <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stakingInvestment->minimum_amount)); ?> - <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stakingInvestment->maximum_amount)); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="text-end">
                                        <button class="i-btn btn--primary btn--md capsuled invest-process staking-investment-process" data-bs-toggle="modal" data-bs-target="#staking-investment"
                                                data-min="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stakingInvestment->minimum_amount)); ?>"
                                                data-max="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stakingInvestment->maximum_amount)); ?>"
                                                data-interest="<?php echo e($stakingInvestment->interest_rate); ?>"
                                                data-plan_id="<?php echo e($stakingInvestment->id); ?>"
                                        ><?php echo e(__('Invest Now')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staking-investment" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title"><?php echo e(__('Staking Invest Now')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="<?php echo e(route('user.staking-investment.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="plan_id" id="plan_id" value="">

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="staking-amount" class="col-form-label"><?php echo e(__('Amount')); ?> (<span id="min-amount"></span> - <span id="max-amount"></span>)</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="staking-amount" name="amount" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-label="Amount" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                            <small id="staking-total-return"></small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="i-btn btn--light btn--md" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                        <button type="submit" class="i-btn btn--primary btn--md"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script-push'); ?>
        <script>
            "use strict";
            $(".staking-investment-process").click(function() {
                var minAmount = $(this).data('min');
                var maxAmount = $(this).data('max');
                var interestRate = $(this).data('interest');
                var planId = $(this).data('plan_id');

                $('#min-amount').text(minAmount);
                $('#max-amount').text(maxAmount);
                $('#plan_id').val(planId);


                function updateTotalReturn(amount) {
                    var parsedAmount = parseFloat(amount.replace(/[^0-9.-]+/g,""));
                    if (isNaN(parsedAmount)) {
                        $("#staking-total-return").text("");
                        return;
                    }
                    var returnAmount = parsedAmount * interestRate / 100 + parsedAmount;
                    $("#staking-total-return").text("Total Return: <?php echo e(getCurrencySymbol()); ?>" + returnAmount.toFixed(2) + " after the complete investment period");
                }

                $('#staking-amount').off('keyup').on('keyup', function() {
                    var amount = $(this).val();
                    updateTotalReturn(amount);
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php endif; ?>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/staking-investment.blade.php ENDPATH**/ ?>