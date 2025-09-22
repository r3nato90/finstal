<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="filter-area">
                        <form action="<?php echo e(route('user.investment.funds')); ?>">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="<?php echo e(__('Trx ID')); ?>" value="<?php echo e(request()->get('search')); ?>">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status" >
                                        <?php $__currentLoopData = App\Enums\Investment\Status::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status->value); ?>" <?php if($status->value == request()->status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($status->name)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="date" class="form-control datepicker-here" name="date"
                                       value="<?php echo e(request()->get('date')); ?>" data-range="true" data-multiple-dates-separator=" - "
                                       data-language="en" data-position="bottom right" autocomplete="off"
                                       placeholder="<?php echo e(__('Date')); ?>">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100"><i class="bi bi-search me-3"></i><?php echo e(__('Search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-container">
                                    <table id="myTable" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                                                <th scope="col"><?php echo e(__('Trx')); ?></th>
                                                <th scope="col"><?php echo e(__('Plan')); ?></th>
                                                <th scope="col"><?php echo e(__('Amount')); ?></th>
                                                <th scope="col"><?php echo e(__('Interest')); ?></th>
                                                <th scope="col"><?php echo e(__('Should Pay')); ?></th>
                                                <th scope="col"><?php echo e(__('Paid')); ?></th>
                                                <th scope="col"><?php echo e(__('Upcoming Payment')); ?></th>
                                                <th scope="col"><?php echo e(__('Status')); ?></th>
                                                <th scope="col"><?php echo e(__('Action')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $investmentLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $investLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <tr>
                                                    <td data-label="<?php echo e(__('Initiated At')); ?>">
                                                        <?php echo e(showDateTime($investLog->created_at)); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Trx')); ?>">
                                                        <?php echo e($investLog->trx); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Plan')); ?>">
                                                        <?php echo e(__($investLog->plan_name)); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Amount')); ?>">
                                                        <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investLog->amount)); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Interest')); ?>">
                                                        <?php if(@$investLog->interest_type == \App\Enums\Investment\InterestType::PERCENT->value): ?>
                                                            <?php echo e(shortAmount($investLog->interest_rate)); ?> %
                                                        <?php else: ?>
                                                            <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investLog->interest_rate)); ?>

                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="<?php echo e(__('Should Pay')); ?>">
                                                        <?php echo e($investLog->should_pay != -1 ? getCurrencySymbol(). shortAmount($investLog->should_pay) : '****'); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Paid')); ?>">
                                                        <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($investLog->profit)); ?>

                                                    </td>
                                                    <td data-label="<?php echo e(__('Upcoming Payment	')); ?>">
                                                        <?php if($investLog->status == \App\Enums\Investment\Status::INITIATED->value): ?>
                                                            <div data-profit-time="<?php echo e(\Carbon\Carbon::parse($investLog->profit_time)->toIso8601String()); ?>" class="payment_time"></div>
                                                        <?php else: ?>
                                                            <span><?php echo e(__('N/A')); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td data-label="<?php echo e(__('Status')); ?>">
                                                        <span
                                                            class="i-badge <?php echo e(\App\Enums\Investment\Status::getColor((int)$investLog->status)); ?> capsuled">
                                                           <?php echo e(\App\Enums\Investment\Status::getName((int)$investLog->status)); ?>

                                                        </span>
                                                    </td>
                                                    <td data-label="Action">
                                                        <?php if($investLog->status == \App\Enums\Investment\Status::PROFIT_COMPLETED->value || ($investLog->status == \App\Enums\Investment\Status::INITIATED->value && $investLog->profit == 0) ): ?>
                                                            <div class="table-action">
                                                                <div class="i-dropdown">
                                                                    <button class="dropdown-toggle style-2 p-0 text-white"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false"><?php echo e(__('Action')); ?></button>
                                                                    <ul class="dropdown-menu">
                                                                        <?php if($investLog->status === \App\Enums\Investment\Status::PROFIT_COMPLETED->value): ?>
                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning re-investment-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#reInvestModal"
                                                                                   data-name="<?php echo e($investLog->plan->name); ?>"
                                                                                   data-uid="<?php echo e($investLog->uid); ?>">
                                                                                    <i class="bi bi-credit-card"></i> <?php echo e(__('Re-Investment')); ?>

                                                                                </a>
                                                                            </li>

                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning transfer-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#transferModal"
                                                                                   data-uid="<?php echo e($investLog->uid); ?>"
                                                                                   data-deducted_amount="<?php echo e(shortAmount($investLog->amount)); ?>"
                                                                                >
                                                                                    <i class="bi bi-credit-card-fill"></i> <?php echo e(__('Investment Transfer')); ?>

                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>

                                                                        <?php if($investLog->status == \App\Enums\Investment\Status::INITIATED->value && $investLog->profit == 0): ?>
                                                                            <li>
                                                                                <a class="dropdown-item icon-btn warning cancel-process"
                                                                                   href="javascript:void(0)"
                                                                                   data-bs-toggle="modal"
                                                                                   data-bs-target="#cancelModal"
                                                                                   data-uid="<?php echo e($investLog->uid); ?>"
                                                                                ><i class="bi bi-trash"></i> <?php echo e(__('Cancel')); ?>

                                                                                </a>
                                                                            </li>
                                                                        <?php endif; ?>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <span>N/A</span>
                                                        <?php endif; ?>
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
                    </div>
                </div>
                <div class="mt-4"><?php echo e($investmentLogs->links()); ?></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="reInvestModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title"><?php echo e(__('Confirmed Re-Investment Process')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="<?php echo e(route('user.investment.make.re-investment')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p><?php echo e(__("You're reinvesting in your current plan. Add more funds by including a new amount")); ?></p>
                        <div class="mb-3">
                            <label for="amount" class="col-form-label"><?php echo e(__("Amount")); ?></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount"
                                       placeholder="<?php echo e(__('Enter investment amount')); ?>"
                                       aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title"><?php echo e(__('Confirmed Cancellation of Investment Process')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="<?php echo e(route('user.investment.cancel')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p><?php echo e(__("Are you sure you want to cancel this investment?")); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--md"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title"><?php echo e(__('Confirm Investment Transfer')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="POST" action="<?php echo e(route('user.investment.complete.profitable')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p>
                            <span class="deducted_amount"></span> <?php echo e(__('Transferred to Your Investment Wallet')); ?>

                        </p>
                    </div>

                    <div class="modal-footer">
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
        $(document).ready(function () {
            $('.re-investment-process').click(function () {
                const name = $(this).data('name');
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);
            });

            $('.cancel-process').click(function () {
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);
            });

            $('.transfer-process').click(function () {
                const uid = $(this).data('uid');
                const currency = "<?php echo e(getCurrencySymbol()); ?>"
                const deductedAmount = $(this).data('deducted_amount');
                $('input[name="uid"]').val(uid);
                $('.deducted_amount').text(currency + deductedAmount);
            });
        });


        function upcomingPaymentCount() {
            const elements = document.querySelectorAll('.payment_time');
            elements.forEach(function(element) {
                var profitTime = element.getAttribute('data-profit-time');
                var countDownDate = new Date(profitTime).getTime();

                var x = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = countDownDate - now;

                    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    element.innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

                    if (distance < 0) {
                        clearInterval(x);
                        element.innerHTML = "EXPIRED";
                    }
                }, 1000);
            });
        }

        document.addEventListener('DOMContentLoaded', upcomingPaymentCount);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/investment/funds.blade.php ENDPATH**/ ?>