<?php $__env->startSection('panel'); ?>
    <section>
        <div class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo e(ucfirst($paymentGateway->name)); ?> <?php echo e($setTitle); ?></h4>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('admin.payment.gateway.update', $paymentGateway->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="currency_name" class="form-label"> <?php echo e(__('admin.input.currency_name')); ?> <sup class="text--danger">*</sup></label>
                            <input type="text" name="currency" value="<?php echo e($paymentGateway->currency); ?>" id="currency_name" class="form-control">
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="image" class="form-label"> <?php echo e(__('admin.input.image')); ?> <sup class="text--danger">*</sup></label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="minimum" class="form-label"> <?php echo e(__('Minimum Amount')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="minimum" name="minimum" value="<?php echo e(getAmount($paymentGateway->minimum)); ?>" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="maximum" class="form-label"> <?php echo e(__('Maximum Amount')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="maximum" name="maximum" value="<?php echo e(getAmount($paymentGateway->maximum)); ?>" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="percent_charge" class="form-label"> <?php echo e(__('admin.input.percent_charge')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="percent_charge" name="percent_charge" value="<?php echo e(getAmount($paymentGateway->percent_charge)); ?>" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">%</span>
                            </div>
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="rate" class="form-label"> <?php echo e(__('admin.input.rate')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><?php echo e(getCurrencySymbol()); ?>1 = </span>
                                <input type="text" name="rate" id="rate" value="<?php echo e(getAmount($paymentGateway->rate)); ?>" class="method-rate form-control" aria-label="Amount (to the nearest dollar)">
                                <span class="input-group-text limit-text"></span>
                            </div>
                        </div>


                        <?php $__currentLoopData = $paymentGateway->parameter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $parameter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="mb-3 col-lg-12">
                                <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?> <sup class="text--danger">*</sup></label>
                                <input type="text" name="method[<?php echo e($key); ?>]" id="<?php echo e($key); ?>" value="<?php echo e($parameter); ?>" class="form-control" placeholder=" <?php echo e(__('Give Valid Data')); ?>" required>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="mb-3 col-lg-12">
                            <label for="status" class="form-label"> <?php echo e(__('admin.input.status')); ?> <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="status" id="status" required>
                                <?php $__currentLoopData = \App\Enums\Status::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>" <?php if($status == $paymentGateway->status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--md mt-3"> <?php echo e(__('admin.button.save')); ?></button>
                </form>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $("#currency_id").on('change', function(){
                const value = $(this).find("option:selected").text();
                $(".limit-text").text(value);
                $(".method-rate").val($('select[name=currency_id] :selected').data('rate_value'));
            }).change();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/payment_gateway/edit.blade.php ENDPATH**/ ?>