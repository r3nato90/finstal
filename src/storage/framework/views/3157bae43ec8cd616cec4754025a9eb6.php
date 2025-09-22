<?php $__env->startSection('content'); ?>
    <style>
        .bg--dark {
            background-color: #1a1a1a;
            color: #ffffff;
        }

        .bg--dark .main-content {
            background-color: #1a1a1a;
        }

        .bg--dark .page-title {
            color: #ffffff;
        }

        .bg--dark .i-card-sm {
            background-color: #000000;
            border: 1px solid #404040;
        }

        .bg--dark .list-group-item {
            background-color: #000000;
            border-color: #4a4a4a;
            color: #ffffff;
        }

        .bg--dark .gateway-image {
            max-width: 120px;
            height: auto;
            border-radius: 8px;
            margin: 0 auto 20px auto;
            border: 1px solid #404040;
            display: block;
        }

        .bg--dark .card-header {
            background-color: #000000;
            border-color: #4a4a4a;
            color: #ffffff;
        }

        .bg--dark .gateway-details {
            background-color: #111111;
            border: 1px solid #404040;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .bg--dark .gateway-info {
            background-color: #0d1117;
            border-left: 4px solid #efefef;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 0 6px 6px 0;
            text-align: center;
        }

        .bg--dark .gateway-info h6 {
            color: #dadada;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .bg--dark .gateway-info p {
            color: #cccccc;
            margin: 8px 0;
            line-height: 1.5;
        }
    </style>

    <div class="main-content bg--dark" data-simplebar>
        <h3 class="page-title"><?php echo e(__($setTitle)); ?></h3>
        <div class="i-card-sm">
            <div class="row">
                <div class="user-form">
                    <h5 class="card-header text-center text-white mb-4"><?php echo e(__('Payment Details')); ?></h5>
                    <div class="text-center mb-4">
                        <img src="<?php echo e(displayImage($gateway->file, '200x150')); ?>"
                             alt="<?php echo e($gateway->name); ?>"
                             class="gateway-image">
                    </div>

                    <div class="gateway-info">
                        <h6><?php echo e(__('Gateway Information')); ?></h6>
                        <p><strong><?php echo e(__('Name')); ?>:</strong> <?php echo e($gateway->name); ?></p>
                        <p><strong><?php echo e(__('Code')); ?>:</strong> <?php echo e($gateway->code); ?></p>
                        <p><strong><?php echo e(__('Currency')); ?>:</strong> <?php echo e($gateway->currency ?? getCurrencyName()); ?></p>
                        <p><strong><?php echo e(__('Type')); ?>:</strong> <?php echo e($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value ? 'Manual' : 'Automatic'); ?></p>
                        <?php if($gateway->details): ?>
                            <p><strong><?php echo e(__('Details')); ?>:</strong> <?php echo e($gateway->details); ?></p>
                        <?php endif; ?>
                    </div>

                    <?php if($gateway->type == \App\Enums\Payment\GatewayType::MANUAL->value): ?>
                        <div class="col-lg-12 mb-4">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('Rate')); ?>

                                    <span><?php echo e(getCurrencySymbol()); ?>1 =  <?php echo e(shortAmount($payment->rate)); ?> <?php echo e($gateway->currency ?? getCurrencyName()); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('TRX')); ?>

                                    <span><?php echo e($payment->trx); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('Deposit Amount')); ?>

                                    <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($payment->amount)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('Charge')); ?>

                                    <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($payment->charge)); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('Final Amount')); ?>

                                    <span><?php echo e(shortAmount($payment->final_amount * $payment->rate )); ?> <?php echo e($payment->currency); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e(__('Net Credit')); ?>

                                    <span><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($payment->final_amount)); ?></span>
                                </li>
                            </ul>
                        </div>

                        <form method="POST" action="<?php echo e(route('user.payment.traditional')); ?>" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <input type="hidden" name="payment_intent" value="<?php echo e($payment->trx); ?>">
                            <input type="hidden" name="gateway_code" value="<?php echo e($gateway->code); ?>">
                            <div class="row">
                                <?php $__currentLoopData = $gateway->parameter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $parameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $parameter = is_array($parameter) ? $parameter : [];
                                    ?>
                                    <div class="col-lg-12">
                                        <div class="form-inner">
                                            <label for="<?php echo e(getArrayFromValue($parameter,'field_label')); ?>"><?php echo e(__(getArrayFromValue($parameter,'field_label'))); ?></label>
                                            <?php if(getArrayFromValue($parameter,'field_type') == 'file'): ?>
                                                <input type="file" id="<?php echo e(getArrayFromValue($parameter,'field_label')); ?>" name="<?php echo e(getArrayFromValue($parameter,'field_name')); ?>" required>
                                            <?php elseif(getArrayFromValue($parameter,'field_type') == 'text'): ?>
                                                <input type="text" id="<?php echo e(getArrayFromValue($parameter,'field_label')); ?>" name="<?php echo e(getArrayFromValue($parameter,'field_name')); ?>" placeholder="<?php echo e(__("Enter ". getArrayFromValue($parameter,'field_label'))); ?>" required>
                                            <?php elseif(getArrayFromValue($parameter,'field_type') == 'textarea'): ?>
                                                <textarea id="<?php echo e(getArrayFromValue($parameter,'field_label')); ?>" name="<?php echo e(getArrayFromValue($parameter,'field_name')); ?>" placeholder="<?php echo e(__("Enter ". getArrayFromValue($parameter,'field_label'))); ?>" required></textarea>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="i-btn btn--primary btn--lg"><?php echo e(__('Save')); ?></button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/payment/preview.blade.php ENDPATH**/ ?>