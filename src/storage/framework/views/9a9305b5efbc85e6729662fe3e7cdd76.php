<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::ABOUT, \App\Enums\Frontend\Content::ENHANCEMENT);
?>

<div class="about-us-section pt-110 pb-110">
    <div class="linear-left"></div>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7 col-md-9 pe-lg-5">
                <div class="section-title text-start mb-40">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
                <div class="about-content">
                    <ul class="about-list">
                        <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <?php echo getArrayFromValue($enhancementContent->meta, 'icon') ?>
                                <span> <?php echo e(getArrayFromValue($enhancementContent->meta, 'title')); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>

                <div class="row counter-wrap mt-5 g-3">
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="167"> <?php echo e(getArrayFromValue($fixedContent?->meta, 'first_item_count')); ?></h3>
                                </div>
                                <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'first_item_title')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="312"><?php echo e(getArrayFromValue($fixedContent?->meta, 'second_item_count')); ?></h3>
                                </div>
                                <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'second_item_title')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="counter-single text-center d-flex flex-column">
                            <div class="coundown d-flex flex-column">
                                <div class="d-flex flex-row justify-content-center align-items-center gap-2">
                                    <h3 class="odometer" data-odometer-final="154"><?php echo e(getArrayFromValue($fixedContent?->meta, 'third_item_count')); ?></h3>
                                </div>
                                <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'third_item_title')); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 pe-lg-5">
                <div class="about-image">
                    <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent?->meta, 'first_image'), "650x600")); ?>" class="about-single" alt="<?php echo e(__('About Us Image')); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('style-push'); ?>
    <style>
        .about-image img {
            max-width: 100%;
            height: auto;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/component/about.blade.php ENDPATH**/ ?>