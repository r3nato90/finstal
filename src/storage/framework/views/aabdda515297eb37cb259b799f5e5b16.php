<meta name="title" Content="<?php echo e($site_title.' - '. @$setTitle); ?>">
<meta name="description" content="<?php echo e($seo_description); ?>">
<meta name="keywords" content="<?php echo e(implode(',',$seo_keywords)); ?>">
<link rel="shortcut icon" href="<?php echo e(displayImage($seo_image)); ?>" type="image/x-icon">

<link rel="apple-touch-icon" href="<?php echo e(displayImage($logo_white, "592x89")); ?>">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="<?php echo e($site_title.' - '. @$setTitle); ?>">

<meta itemprop="name" content="<?php echo e($site_title.' - '. @$setTitle); ?>">
<meta itemprop="description" content="<?php echo e($seo_description); ?>">
<meta itemprop="image" content="<?php echo e(displayImage($seo_image)); ?>">

<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo e($seo_title); ?>">
<meta property="og:description" content="<?php echo e($seo_description); ?>">
<meta property="og:image" content="<?php echo e(displayImage($seo_image)); ?>"/>
<meta property="og:url" content="<?php echo e(url()->current()); ?>">

<?php /**PATH /var/www/html/finfunder/src/resources/views/partials/seo.blade.php ENDPATH**/ ?>