<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::SERVICE, \App\Enums\Frontend\Content::ENHANCEMENT);
?>

<div class="service-section pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="section-title text-center mb-60">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
            </div>
        </div>
        <div class="row align-items-center service-tab-wrapper">
            <div class="col-lg-6">
                <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="tab-pane <?php echo e($loop->first ? 'show active' : ''); ?>" id="category_tab<?php echo e($loop->iteration); ?>">
                        <img src="<?php echo e(displayImage(getArrayFromValue($enhancementContent->meta, 'service_image'), "636x477")); ?>" alt="<?php echo e(__('Service image-'. $loop->iteration )); ?>">
                    </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="col-lg-6 ps-lg-5">
                <nav id="myTab" class="nav nav-pills flex-column service-title-wrap">
                    <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="#category_tab<?php echo e($loop->iteration); ?>" data-bs-toggle="pill" data-cursor="View" class="<?php echo e($loop->first ? 'active' : ''); ?> nav-link"><span><?php echo e(getArrayFromValue($enhancementContent->meta, 'title')); ?></span>
                            <i class="bi bi-arrow-right-short"></i>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/component/service.blade.php ENDPATH**/ ?>