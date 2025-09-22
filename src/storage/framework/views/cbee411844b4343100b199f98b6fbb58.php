<!DOCTYPE html>
<html lang="en" color-scheme="light">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__($site_title)); ?> - <?php echo e(@$setTitle); ?></title>
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="shortcut icon" href="<?php echo e(displayImage($favicon, "592x89")); ?>" type="image/x-icon">
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::FRONTEND, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::FRONTEND, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make(getActiveTheme().'.partials.color', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('style-file'); ?>
    <?php echo $__env->yieldPushContent('style-push'); ?>
</head>

<body class="tt-magic-cursor">
    <div id="magic-cursor">
        <div id="ball"></div>
    </div>
    <?php echo $__env->yieldContent('panel'); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::FRONTEND, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::FRONTEND, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.tawkto', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.google_analytics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.hoory', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('script-file'); ?>
    <?php echo $__env->yieldPushContent('script-push'); ?>
</body>
</html>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/layouts/app.blade.php ENDPATH**/ ?>