<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(__(@$site_title)); ?> - <?php echo e(@$setTitle); ?></title>
    <link rel="shortcut icon" href="<?php echo e(displayImage($favicon ?? '', "592x89")); ?>" type="image/x-icon">
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::ADMIN, \App\Enums\Theme\FileType::CSS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::ADMIN, \App\Enums\Theme\FileType::CSS, $themeFile)); ?>" />
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->yieldPushContent('style-include'); ?>
    <?php echo $__env->yieldPushContent('style-push'); ?>
</head>
<body>

    <?php echo $__env->yieldContent('content'); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::ADMIN, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::ADMIN, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldPushContent('script-include'); ?>
    <?php echo $__env->yieldPushContent('script-push'); ?>
</body>
</html>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/layouts/admin.blade.php ENDPATH**/ ?>