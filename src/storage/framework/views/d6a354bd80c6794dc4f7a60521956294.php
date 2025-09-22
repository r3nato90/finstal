<?php $__env->startSection('content'); ?>
    <div class="login-content row g-0 justify-content-center">
        <div class="col-xl-5 col-lg-6 order-lg-2 order-1">
            <div class="form-wrapper-one flex-column rounded-4">
                <div class="logo-area text-center mb-40">
                    <img src="<?php echo e(displayImage($logo_white ?? 'white_log.png', "592x89")); ?>" alt="Site-Logo" border="0">
                    <h4><?php echo e(__('Admin login')); ?></h4>
                </div>
                <form action="<?php echo e(route('admin.login.authenticate')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-inner email">
                        <label for="login-email"><?php echo e(__('admin.input.email')); ?></label>
                        <input type="text" id="login-email" name="email" value="<?php echo e(env('APP_MODE') == 'demo' ? env('APP_DEMO_ADMIN') : old('email')); ?>" placeholder="<?php echo e(__('admin.placeholder.email')); ?>" />
                    </div>
                    <div class="form-inner password">
                        <label for="login-password"><?php echo e(__('admin.input.password')); ?></label>
                        <input type="password" name="password" id="login-password" value="<?php echo e(env('APP_MODE') == 'demo' ? env('APP_DEMO_ADMIN_PASS') : ''); ?>" placeholder="<?php echo e(__('admin.placeholder.password')); ?>" />
                    </div>
                    <button type="submit" class="btn btn--dark btn--lg w-100"><?php echo e(__('admin.button.sign_in')); ?></button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>