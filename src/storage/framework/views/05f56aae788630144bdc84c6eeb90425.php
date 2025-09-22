<?php
    $fixedCryptoCoinContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_COIN, \App\Enums\Frontend\Content::FIXED);
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SIGN_UP, \App\Enums\Frontend\Content::FIXED);
    $referral = null;
    if(request()->get('ref')) {
        $referral = \App\Models\User::where('uuid', request()->get('ref'))->first();
    }
?>


<?php $__env->startSection('content'); ?>
    <main>
        <div class="form-section white img-adjust">
            <div class="form-bg">
                <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'background_image'), "1920x1080")); ?>" alt="<?php echo e(__('Background image')); ?>">
            </div>
            <div class="linear-center"></div>
            <div class="container-fluid px-0">
                <div class="row justify-content-center align-items-center gy-5">
                    <div class="col-xl-6 col-lg-6">
                        <div class="form-left">
                            <a href="<?php echo e(route('home')); ?>" class="logo" data-cursor="Home">
                                <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__("Logo")); ?>">
                            </a>
                            <h1><?php echo e(getArrayFromValue($fixedContent?->meta, 'title')); ?></h1>
                            <p> <?php echo e(getArrayFromValue($fixedContent?->meta, 'details')); ?> </p>
                        </div>
                    </div>
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
                        <div class="form-wrapper2 login-form">
                            <h4 class="form-title"><?php echo e(__('Sign Up Your Account')); ?></h4>
                            <form method="POST" action="<?php echo e(route('register')); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if(request()->get('ref')): ?>
                                    <input type="hidden" name="ref" value="<?php echo e(request()->get('ref')); ?>">
                                <?php endif; ?>

                                <div class="row">
                                    <?php if($referral): ?>
                                        <div class="col-12">
                                            <div class="alert alert-info">
                                                <?php echo e(__("You are registering with referral from")); ?> <strong><?php echo e($referral->fullname); ?></strong>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="name"><?php echo e((__('Name'))); ?></label>
                                            <input type="text"
                                                   id="name"
                                                   name="name"
                                                   value="<?php echo e(old('name')); ?>"
                                                   placeholder="<?php echo e(__('Enter Name')); ?>"
                                                   class="<?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   required>
                                            <?php $__errorArgs = ['name'];
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
                                            <label for="email"><?php echo e(__('Email')); ?></label>
                                            <input type="email"
                                                   id="email"
                                                   name="email"
                                                   value="<?php echo e(old('email')); ?>"
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
                                                   autocomplete="new-password"
                                                   placeholder="<?php echo e(__('Enter Password (min 8 characters)')); ?>"
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

                                    <div class="col-12">
                                        <div class="form-inner">
                                            <label for="password_confirmation"><?php echo e(__('Confirm Password')); ?></label>
                                            <input type="password"
                                                   id="password_confirmation"
                                                   name="password_confirmation"
                                                   autocomplete="new-password"
                                                   placeholder="<?php echo e(__('Enter Confirm Password')); ?>"
                                                   class="<?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                   required>
                                            <?php $__errorArgs = ['password_confirmation'];
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
                                        <button type="submit" value="Register" class="i-btn btn--lg btn--primary w-100">
                                            <?php echo e(__('Sign Up')); ?>

                                        </button>
                                    </div>
                                </div>

                                <div class="have-account">
                                    <p class="mb-0"><?php echo e(__('Already registered?')); ?> <a href="<?php echo e(route('login')); ?>"> <?php echo e(__('Sign In')); ?></a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/auth/register.blade.php ENDPATH**/ ?>