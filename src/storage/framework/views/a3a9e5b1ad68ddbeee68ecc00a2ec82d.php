<!DOCTYPE html>
<html lang="en" data-sidebar="open">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__($site_title)); ?> - <?php echo e(@$setTitle); ?></title>
    <link rel="shortcut icon" href="<?php echo e(displayImage($favicon, "592x89")); ?>" type="image/x-icon">
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::USER, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::USER, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('default_theme.partials.color', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('style-file'); ?>
    <?php echo $__env->yieldPushContent('style-push'); ?>
</head>

<body>
<div class="overlay-bg" id="overlay"></div>
    <?php echo $__env->make('user.partials.top-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="dashboard-wrapper">
        <?php echo $__env->make('user.partials.side-bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/viewport.jquery.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/aos.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/jquery.fancybox.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/odometer.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/gsap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/cursor.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/jquery.marquee.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/theme/frontend/default_theme/js/main.js')); ?>"></script>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::USER, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::USER, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('script-file'); ?>
    <?php echo $__env->yieldPushContent('script-push'); ?>
</body>
</html>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/layouts/user.blade.php ENDPATH**/ ?>