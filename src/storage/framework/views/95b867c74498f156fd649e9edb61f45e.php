<?php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SIGN_IN, \App\Enums\Frontend\Content::FIXED);
?>

<?php $__env->startSection('content'); ?>
    <main>
        <div class="form-section white img-adjust">
            <div class="linear-center"></div>
            <div class="form-bg2">
                <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'background_image'), "1920x1080")); ?>" alt="<?php echo e(__('Background image')); ?>">
            </div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xl-6 col-lg-6 col-md-8 col-sm-10 position-relative">
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
                        <div class="form-wrapper2">
                            <h4 class="form-title"><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h4>
                            <form method="POST" action="<?php echo e(route('login')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="email"><?php echo e(__('Email')); ?></label>
                                            <input type="email"
                                                   name="email"
                                                   id="email"
                                                   value="<?php echo e(env('APP_MODE') == 'demo' ? env('APP_DEMO_USER') : old('email')); ?>"
                                                   placeholder="<?php echo e(__('Enter Email')); ?>"
                                                   class="<?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   required>
                                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password"><?php echo e(__('Password')); ?></label>
                                            <input type="password"
                                                   id="password"
                                                   name="password"
                                                   value="<?php echo e(env('APP_MODE') == 'demo' ? env('APP_DEMO_USER_PASS') : ''); ?>"
                                                   autocomplete="current-password"
                                                   placeholder="<?php echo e(__('Enter Password')); ?>"
                                                   class="<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   required>
                                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <div class="col-sm-6">
                                            <div class="form-inner mb-sm-0 mb-3">
                                                <div class="form-group">
                                                    <input type="checkbox" id="remember_me" name="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                    <label for="remember_me"><?php echo e(__('Remember me')); ?></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-6 text-sm-end text-start d-flex justify-content-sm-end justify-content-start">
                                            <div class="forgot-pass">
                                                <a href="<?php echo e(route('forgot-password')); ?>"><?php echo e(__('Forgot your password?')); ?></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="i-btn btn--lg btn--primary w-100" type="submit"><?php echo e(__('Sign In')); ?></button>
                                    </div>
                                </div>

                                <?php if(\App\Services\SettingService::isRegistrationEnabled()): ?>
                                    <div class="have-account">
                                        <p class="mb-0"><?php echo e(__("Don't have an account?")); ?> <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Sign Up')); ?></a></p>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-left">
                            <a href="<?php echo e(route('home')); ?>" class="logo" data-cursor="Home">
                                <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__('Logo')); ?>">
                            </a>
                            <h1><?php echo e(getArrayFromValue($fixedContent?->meta, 'title')); ?></h1>
                            <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'details')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/auth/login.blade.php ENDPATH**/ ?>