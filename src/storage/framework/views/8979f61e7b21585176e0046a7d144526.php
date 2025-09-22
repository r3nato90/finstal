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
    <link rel="stylesheet" href="<?php echo e(asset('assets/theme/admin/auth/css/style.css')); ?>" />
</head>
<body>
    <section class="admin-form">
        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </section>
    <div class="squire-container">
        <ul class="squares"></ul>
    </div>
    <?php $__currentLoopData = getThemeFiles(\App\Enums\Theme\ThemeType::GLOBAL, \App\Enums\Theme\FileType::JS); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $themeFile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, $themeFile)); ?>"></script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>
</html>
<?php /**PATH /var/www/html/finfunder/src/resources/views/admin/layouts/auth.blade.php ENDPATH**/ ?>