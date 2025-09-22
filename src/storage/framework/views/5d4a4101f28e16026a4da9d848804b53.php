<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e(__($setTitle)); ?></h4>
                </div>

                <div class="card-body">
                    <form action="<?php echo e(route('admin.withdraw.method.update', $withdrawMethod->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="form-wrapper">
                            <div class="row g-3">
                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="name" class="form-label"> <?php echo app('translator')->get('Gateway Name'); ?> <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="name" id="name" value="<?php echo e($withdrawMethod->name); ?>" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="currency_name" class="form-label"> <?php echo app('translator')->get('Currency Name'); ?> <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="currency_name" id="currency_name" value="<?php echo e($withdrawMethod->currency_name); ?>" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="min_limit" class="form-label"> <?php echo app('translator')->get('Minimum Limit'); ?> <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="min_limit" id="min_limit" value="<?php echo e(getAmount($withdrawMethod->min_limit)); ?>" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="max_limit" class="form-label"> <?php echo app('translator')->get('Maximum Limit'); ?> <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="max_limit" id="max_limit" value="<?php echo e(getAmount($withdrawMethod->max_limit)); ?>" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="percent_charge" class="form-label"><?php echo app('translator')->get('Percent Charge'); ?> <sup class="text-danger">*</sup></label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="percent_charge"
                                            name="percent_charge"
                                            value="<?php echo e(getAmount($withdrawMethod->percent_charge)); ?>"
                                            aria-describedby="basic-addon2">
                                        <span class="input-group-text" id="basic-addon2">%</span>
                                    </div>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="fixed_charge" class="form-label"> <?php echo app('translator')->get('Fixed Charge'); ?> <sup class="text-danger">*</sup></label>
                                    <input type="text" class="form-control" name="fixed_charge" id="fixed_charge" value="<?php echo e(getAmount($withdrawMethod->fixed_charge)); ?>" required>
                                </div>

                                <div class="mb-3 col-lg-6 col-md-12">
                                    <label for="rate" class="form-label"><?php echo app('translator')->get('Currency Rate'); ?> <sup class="text-danger">*</sup></label>
                                    <div class="input-group mb-3">
                                        <span class="input-group-text"><?php echo e(getCurrencySymbol()); ?>1 = </span>
                                        <input type="text" id="rate" name="rate" placeholder="<?php echo app('translator')->get('Enter Number'); ?>"
                                            value="<?php echo e(getAmount($withdrawMethod->rate)); ?>"
                                            class="method-rate form-control"
                                            aria-label="Amount (to the nearest dollar)">
                                    </div>
                                </div>

                                <div class="form-group col-lg-6">
                                    <label for="status"><?php echo app('translator')->get('Status'); ?> <sup class="text-danger">*</sup></label>
                                    <select class="form-select" name="status" id="status" required>
                                        <?php $__currentLoopData = \App\Enums\Status::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php if($withdrawMethod->status == $status): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($key)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-12 col-md-12">
                                    <label for="instructions" class="form-label"><?php echo app('translator')->get('Instructions'); ?> <sup class="text-danger">*</sup></label>
                                    <textarea id="instructions" name="instruction" placeholder="<?php echo app('translator')->get('Enter Instructions'); ?>"
                                              class="form-control" rows="4"
                                              aria-label="Instructions"><?php echo e($withdrawMethod->instruction ?? old('instructions')); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <?php echo $__env->make('admin.partials.custom-field', [
                            'parameter' => $withdrawMethod->parameter,
                            'title' => "Withdraw Information",
                            'details' => "Add information to get back from your customer withdraw method, please click add a new button on the right side"
                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <button class="w-100 btn btn-primary"><?php echo app('translator')->get('Submit'); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/withdraw_method/edit.blade.php ENDPATH**/ ?>