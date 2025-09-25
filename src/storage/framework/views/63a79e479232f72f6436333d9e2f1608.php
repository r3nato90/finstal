<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="filter-area">
                        <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                            <div class="col">
                                <button class="i-btn btn--lg btn--primary w-100" data-bs-toggle="modal" data-bs-target="#staking-investment"><i class="bi bi-wallet me-3"></i> <?php echo e(__('Invest Now')); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                                            <th scope="col"><?php echo e(__('Amount')); ?></th>
                                            <th scope="col"><?php echo e(__('Interest')); ?></th>
                                            <th scope="col"><?php echo e(__('Total Return')); ?></th>
                                            <th scope="col"><?php echo e(__('Expiration Date')); ?></th>
                                            <th scope="col"><?php echo e(__('Status')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $stakingInvestments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('Initiated At')); ?>"><?php echo e(showDateTime($item->created_at)); ?></td>
                                            <td data-label="<?php echo e(__('Amount')); ?>"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->amount)); ?></td>
                                            <td data-label="<?php echo e(__('Interest')); ?>"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->interest)); ?></td>
                                            <td data-label="<?php echo e(__('Total Return')); ?>"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($item->amount + $item->interest)); ?></td>
                                            <td data-label="<?php echo e(__('Expiration Date')); ?>"><?php echo e(showDateTime($item->expiration_date)); ?></td>
                                            <td data-label="<?php echo e(__('Status')); ?>">
                                                <span class="i-badge <?php echo e(\App\Enums\Investment\Staking\Status::getColor((int)$item->status)); ?>"> <?php echo e(\App\Enums\Investment\Staking\Status::getName((int)$item->status)); ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td class="text-white text-center" colspan="100%"><?php echo e(__('No Data Found')); ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4"><?php echo e($stakingInvestments->links()); ?></div>
                </div>
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
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="amount" class="col-form-label"><?php echo e(__('Duration')); ?></label>
                            <select class="form-control" name="plan_id" id="plan-select">
                                <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($plan->id); ?>"
                                        data-min="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->minimum_amount)); ?>"
                                        data-max="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->maximum_amount)); ?>"
                                        data-interest="<?php echo e($plan->interest_rate); ?>"
                                    ><?php echo e($plan->duration); ?> <?php echo e(__('Days')); ?> - <?php echo e(__('Interest')); ?> <?php echo e(shortAmount($plan->interest_rate)); ?>%</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?> (<span id="min-amount"></span> - <span id="max-amount"></span>)</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-label="Amount" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                            <small id="total-return" class="text--light"></small>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function() {
            var interestRate = 0;

            function updateMinMax() {
                const selectedOption = $('#plan-select option:selected');
                const minAmount = selectedOption.data('min');
                const maxAmount = selectedOption.data('max');
                interestRate = selectedOption.data('interest');

                $('#min-amount').text(minAmount);
                $('#max-amount').text(maxAmount);
            }

            function updateTotalReturn(amount) {
                var parsedAmount = parseFloat(amount);
                if (isNaN(parsedAmount)) {
                    $("#total-return").text("");
                    return;
                }
                var returnAmount = parsedAmount * interestRate / 100 + parsedAmount;
                $("#total-return").text("Total Return: <?php echo e(getCurrencySymbol()); ?>" + returnAmount.toFixed(2) + " after the complete investment period");
            }

            updateMinMax();

            $('#plan-select').change(function() {
                updateMinMax();
            });

            $('#amount').on('keyup', function() {
                var amount = $(this).val();
                updateTotalReturn(amount);
            });
        });
    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/investment/staking/index.blade.php ENDPATH**/ ?>