<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::BLOG, \App\Enums\Frontend\Content::ENHANCEMENT, 4);
?>

<div class="blog-section position-relative pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-lg-5">
                <div class="section-title text-center mb-60">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            <div class="row g-3">
                <div class="col-12">
                    <div class="swiper blog-slider">
                        <div class="swiper-wrapper">
                            <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="swiper-slide">
                                    <div class="blog-item-two">
                                        <div class="image">
                                            <img src="<?php echo e(displayImage(getArrayFromValue($enhancementContent->meta, 'thumb_image'), '800x500')); ?>" alt="<?php echo e(__('thumb Image')); ?>">
                                            <div class="date">
                                                <h5><?php echo e(showDateTime($enhancementContent->created_at, 'd')); ?></h5>
                                                <p><?php echo e(showDateTime($enhancementContent->created_at, 'M')); ?></p>
                                            </div>
                                        </div>
                                        <div class="content">
                                            <h4 class="card--title">
                                                <a href="<?php echo e(route('blog.detail', $enhancementContent->id)); ?>" data-cursor="View Details"><?php echo e(getArrayFromValue($enhancementContent->meta, 'title')); ?></a>
                                            </h4>
                                            <a href="<?php echo e(route('blog.detail', $enhancementContent->id)); ?>" class="i-btn read-more-btn"><?php echo e(__('Read More')); ?> <i class="bi bi-arrow-up-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="card-pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/blog.blade.php ENDPATH**/ ?>