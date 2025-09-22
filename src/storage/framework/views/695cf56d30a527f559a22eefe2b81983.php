<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ADVERTISE, \App\Enums\Frontend\Content::ENHANCEMENT);
?>

<div class="advertise-section bg-color pt-110 pb-110">
    <div class="container">
        <div class="row align-items-center justify-content-xl-between justify-content-center gy-5">
            <div class="col-xl-6 pe-xl-5">
                <div class="introduction-wrapper">
                    <div class="section-title style-two text-start">
                        <h2 class="mb-lg-5 mb-4"><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                        <h4><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></h4>
                        <ul>
                            <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><i class="bi bi-shield-check"></i><?php echo e(getArrayFromValue($enhancementContent->meta, 'title')); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-9 col-10 offset-xl-1">
                <div class="advertise-slider-wrap">
                    <div class="swiper advertise-slider">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo e(displayImage(getArrayFromValue($enhancementContent->meta, 'advertise_image'), "800x600")); ?>" alt="<?php echo e(__('image')); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/advertise.blade.php ENDPATH**/ ?>