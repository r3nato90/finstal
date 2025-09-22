<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">

                            <?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $gateway): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="i-card-sm card--dark shadow-none rounded-3">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <div class="col-12">
                                                <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3 gap-3" >
                                                    <h5 class="title-sm mb-0"><?php echo e(__($gateway->name)); ?></h5>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                                <button class="i-btn btn--primary btn--md capsuled deposit-process"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#exampleModal"
                                                        data-name="<?php echo e($gateway->name); ?>"
                                                        data-code="<?php echo e($gateway->code); ?>"
                                                        data-minimum="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($gateway->minimum)); ?>"
                                                        data-maximum="<?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($gateway->maximum)); ?>"
                                                ><?php echo e(__('Deposit Now')); ?><i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Deposit Logs')); ?></h4>
                    </div>

                    <div class="filter-area">
                        <form action="<?php echo e(route('user.payment.index')); ?>">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text" name="search" placeholder="<?php echo e(__('Trx ID')); ?>" value="<?php echo e(request()->get('search')); ?>">
                                </div>
                                <div class="col">
                                    <select class="select2-js" name="status" >
                                        <?php $__currentLoopData = App\Enums\Payment\Deposit\Status::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (! ($status->value == App\Enums\Payment\Deposit\Status::INITIATED->value)): ?>
                                                <option value="<?php echo e($status->value); ?>" <?php if($status->value == request()->status): ?> selected <?php endif; ?>><?php echo e($status->name); ?></option>
                                            <?php endif; ?>
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
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="myTable" class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                                        <th scope="col"><?php echo e(__('Trx')); ?></th>
                                        <th scope="col"><?php echo e(__('Gateway')); ?></th>
                                        <th scope="col"><?php echo e(__('Amount')); ?></th>
                                        <th scope="col"><?php echo e(__('Charge')); ?></th>
                                        <th scope="col"><?php echo e(__('Conversion')); ?></th>
                                        <th scope="col"><?php echo e(__('Payable Amount')); ?></th>
                                        <th scope="col"><?php echo e(__('Net Credit')); ?></th>
                                        <th scope="col"><?php echo e(__('Crypto Payment')); ?></th>
                                        <th scope="col"><?php echo e(__('Wallet')); ?></th>
                                        <th scope="col"><?php echo e(__('Status')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('Initiated At')); ?>">
                                                <?php echo e(showDateTime($deposit->created_at)); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Trx')); ?>">
                                                <?php echo e($deposit->trx); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Gateway')); ?>">
                                                <?php echo e($deposit?->gateway?->name ?? 'N/A'); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Amount')); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->amount)); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Charge')); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->charge)); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Conversion')); ?>">
                                                <?php echo e(getCurrencySymbol()); ?>1 = <?php echo e(shortAmount($deposit->rate)); ?>  <?php echo e($deposit?->currency); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Payable Amount')); ?>">
                                                <?php echo e(shortAmount($deposit->final_amount * $deposit->rate )); ?> <?php echo e($deposit->currency); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Net Credit')); ?>">
                                               <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($deposit->final_amount)); ?>

                                            </td>

                                            <td data-label="<?php echo e(__('Crypto')); ?>">
                                                <?php if($deposit->is_crypto_payment): ?>
                                                    <a href="javascript:void(0)" class="i-badge badge--primary show-crypto-info"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#cryptoInfoModal"
                                                       data-address="<?php echo e(getArrayFromValue($deposit->crypto_meta, 'payment_info.pay_address') ?? 'N/A'); ?>"
                                                       data-amount="<?php echo e(getArrayFromValue($deposit->crypto_meta, 'payment_info.price_amount') ?? 'N/A'); ?>"
                                                       data-network="<?php echo e(strtoupper(getArrayFromValue($deposit->crypto_meta, 'payment_info.network')) ?? 'N/A'); ?>"
                                                       data-image="<?php echo e(getArrayFromValue($deposit->crypto_meta, 'image') ?? 'N/A'); ?>"
                                                       data-price_amount="<?php echo e(getArrayFromValue($deposit->crypto_meta, 'payment_info.price_amount'). ' '. strtoupper(getArrayFromValue($deposit->crypto_meta, 'payment_info.price_currency')) ?? 'N/A'); ?>"
                                                       data-crypto_amount="<?php echo e(getArrayFromValue($deposit->crypto_meta, 'payment_info.pay_amount'). ' '. strtoupper(getArrayFromValue($deposit->crypto_meta, 'payment_info.pay_currency')) ?? 'N/A'); ?>"
                                                    >
                                                        <?php echo e(__('Crypto Info')); ?>

                                                    </a>
                                                <?php else: ?>
                                                    <span><?php echo e(__('N/A')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="<?php echo e(__('Wallet')); ?>">
                                                <?php echo e(__(\App\Enums\Transaction\WalletType::getWalletName($deposit->wallet_type))); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Status')); ?>">
                                                <span class="i-badge <?php echo e(App\Enums\Payment\Deposit\Status::getColor($deposit->status)); ?>"><?php echo e(App\Enums\Payment\Deposit\Status::getName($deposit->status)); ?></span>
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

                <div class="mt-4">
                    <?php echo e($deposits->links()); ?>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="gatewayTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('user.payment.process')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="code" value="">
                    <div class="modal-body">
                        <h6 id="paymentLimitTitle" class="mb-1 mt-1 text-center"></h6>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="amount" name="amount" placeholder="<?php echo e(__('Enter Amount')); ?>" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="col-form-label"><?php echo e(__('Wallet')); ?></label>
                            <select class="form-control" name="wallet" >
                                <?php $__currentLoopData = App\Enums\Transaction\WalletType::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (! ($status->value == \App\Enums\Transaction\WalletType::PRACTICE->value)): ?>
                                        <option value="<?php echo e($status->value); ?>"><?php echo e(\App\Enums\Transaction\WalletType::getWalletName($status->value)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
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

    <div class="modal fade" id="cryptoInfoModal" tabindex="-1" aria-labelledby="cryptoInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cryptoInfoModalLabel"><?php echo e(__('Crypto Information')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong><?php echo e(__('Pay Address')); ?>:</strong> <span id="cryptoAddress"></span></p>
                    <p><strong><?php echo e(__('Price Amount')); ?>:</strong> <span id="priceAmount"></span></p>
                    <p><strong><?php echo e(__('Crypto Amount')); ?>:</strong> <span id="cryptoCryptoAmount"></span></p>
                    <p><strong><?php echo e(__('Network')); ?>:</strong> <span id="network"></span></p>
                    <p><strong><?php echo e(__('Pay Image')); ?>:</strong> <img id="cryptoPayImage" alt="Crypto Pay Image"  /></p>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function() {
            $('.deposit-process').click(function() {
                const name = $(this).data('name');
                const code = $(this).data('code');
                const minimum = $(this).data('minimum');
                const maximum = $(this).data('maximum');
                $('input[name="code"]').val(code);

                const gatewayTitle = "Deposit with " + name + " now";
                const paymentLimit = `Deposit Amount Limit ${minimum} - ${maximum}`;
                $('#paymentLimitTitle').text(paymentLimit);
                $('#gatewayTitle').text(gatewayTitle);

                if (code == "<?php echo e(\App\Enums\Payment\GatewayCode::NOW_PAYMENT->value); ?>") {
                    $("#currency-container").show();
                } else {
                    $("#currency-container").hide();
                }
            });
        });

        $('.show-crypto-info').click(function() {
            const address = $(this).data('address');
            const cryptoAmount = $(this).data('crypto_amount');
            const priceAmount = $(this).data('price_amount');
            const network = $(this).data('network');
            const image = $(this).data('image');

            $('#cryptoAddress').text(address);
            $('#cryptoCryptoAmount').text(cryptoAmount);
            $('#priceAmount').text(priceAmount);
            $('#network').text(network);
            $('#cryptoPayImage').attr('src', image);
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/payment/process.blade.php ENDPATH**/ ?>