<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CHOOSE_US, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
?>

<div class="predict-section bg-color pt-110 pb-110" id="prediction">
    <div class="container">
        <div class="row align-items-center gy-5">
            <div class="col-xl-5 col-md-9">
                <div class="section-title style-two text-start">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
                <div class="bet-vecotr">
                    <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'vector_image'), "512x450")); ?>" alt="<?php echo e(__('Vector Image')); ?>">
                </div>
            </div>
            <div class="col-xl-7 ps-lg-5">
                <div class="choose-wrapper">
                    <div class="row g-lg-5 g-4">
                        <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="choose-item">
                                    <div class="icon">
                                        <?php echo getArrayFromValue($enhancementContent->meta, 'icon') ?>
                                    </div>
                                    <div class="content">
                                        <h4><?php echo e(getArrayFromValue($enhancementContent->meta, 'title')); ?></h4>
                                        <p><?php echo e(getArrayFromValue($enhancementContent->meta, 'details')); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/choose_us.blade.php ENDPATH**/ ?>