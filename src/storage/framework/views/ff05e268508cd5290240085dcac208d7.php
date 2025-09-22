<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4><?php echo e(__($setTitle)); ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.manual.gateway.update', $traditionalGateway->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-wrapper">
                            <div class="row mb-3 g-3">
                                <div class="mb-3 col-lg-6">
                                    <label for="name" class="form-label"> <?php echo e(__('admin.input.name')); ?> <sup class="text--danger">*</sup></label>
                                    <input type="text" name="name" id="name" value="<?php echo e($traditionalGateway->name); ?>" class="form-control" placeholder=" <?php echo e(__('Enter Name')); ?>" required="">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="percent_charge" class="form-label"> <?php echo e(__('admin.input.percent_charge')); ?> <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="percent_charge" value="<?php echo e(getAmount($traditionalGateway->percent_charge)); ?>" name="percent_charge" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="currency_name" class="form-label"> <?php echo e(__('admin.input.currency_name')); ?> <sup class="text--danger">*</sup></label>
                                    <input type="text" name="currency" value="<?php echo e($traditionalGateway->currency); ?>" id="currency_name" class="form-control" placeholder="<?php echo e(__('Enter Currency Name')); ?>">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="rate" class="form-label"> <?php echo e(__('admin.input.rate')); ?> <sup class="text--danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><?php echo e(getCurrencySymbol()); ?>1 = </span>
                                        <input type="text" name="rate" id="rate" value="<?php echo e(getAmount($traditionalGateway->rate)); ?>" class="method-rate form-control" aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>


                                <div class="mb-3 col-lg-6">
                                    <label for="minimum" class="form-label"> <?php echo e(__('Minimum Amount')); ?> <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="minimum" name="minimum" value="<?php echo e(getAmount($traditionalGateway->minimum)); ?>" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="maximum" class="form-label"> <?php echo e(__('Maximum Amount')); ?> <sup class="text--danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="maximum" name="maximum" value="<?php echo e(getAmount($traditionalGateway->maximum)); ?>" placeholder="<?php echo e(__('Enter Number')); ?>" aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="image" class="form-label"> <?php echo e(__('admin.input.image')); ?> <sup class="text--danger">*</sup></label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="status" class="form-label"> <?php echo e(__('admin.input.status')); ?> <sup class="text--danger">*</sup></label>
                                    <select class="form-select" name="status" id="status" required>
                                        <?php $__currentLoopData = \App\Enums\Status::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php if($traditionalGateway->status == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <label for="details" class="form-label">
                                        <?php echo e(__('Details')); ?> <sup class="text--danger">*</sup>
                                    </label>
                                    <textarea class="form-control" name="details" id="details" rows="4" required><?php echo e(old('details', $traditionalGateway->details)); ?></textarea>
                                </div>

                            </div>
                        </div>
                        <?php echo $__env->make('admin.partials.custom-field', [
                            'parameter' => $traditionalGateway->parameter,
                            'title' => __('admin.content.gateway'),
                            'details' => __('admin.content.gateway_details')
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <button type="submit" class="i-btn btn--primary btn--md text--white"> <?php echo e(__('admin.button.update')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('script-push'); ?>
    <script>
        'use strict'
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 300,
                placeholder: 'Enter Payment Details',
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/payment_gateway/manual/edit.blade.php ENDPATH**/ ?>