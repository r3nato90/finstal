<?php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
?>


<?php $__env->startSection('content'); ?>
<main>
    <div class="form-section white img-adjust">
        <div class="linear-center"></div>
        <div class="container-fluid px-0">
            <div class="row justify-content-center align-items-center gy-5">
                <div class="col-xxl-4 col-xl-5 col-lg-6 col-md-8 col-sm-10 position-relative">
                    <div class="eth-icon">
                        <img src="<?php echo e(displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'first_crypto_coin'), "450X450")); ?>" alt="image">
                    </div>
                    <div class="bnb-icon">
                        <img src="<?php echo e(displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'second_crypto_coin'), "450X450")); ?>" alt="image">
                    </div>
                    <div class="ada-icon">
                        <img src="<?php echo e(displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'third_crypto_coin'), "450X450")); ?>" alt="image">
                    </div>
                    <div class="sol-icon">
                        <img src="<?php echo e(displayImage(getArrayFromValue($fixedCryptoCoinContent?->meta, 'fourth_crypto_coin'), "450X450")); ?>" alt="image">
                    </div>

                    <div class="form-wrapper">
                        <p><?php echo e(__('Forgot your password? Enter your email, and we’ll send a link to reset it.')); ?></p>
                        <form method="POST" action="<?php echo e(route('forgot-password')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-inner">
                                        <label for="email"><?php echo e(__('Email')); ?></label>
                                        <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" placeholder="<?php echo e(__('Enter Email')); ?>" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="i-btn btn--lg btn--primary w-100" type="submit"><?php echo e(__('Email Password Reset Link')); ?></button>
                                </div>
                            </div>

                            <div class="have-account">
                                <p class="mb-0"><?php echo e(__('Remembered your password?')); ?> <a href="<?php echo e(route('login')); ?>"><?php echo e(__('Sign In')); ?></a> <?php echo e(__('here')); ?>.</p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>