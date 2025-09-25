<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::FIXED);
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::TESTIMONIAL, \App\Enums\Frontend\Content::ENHANCEMENT);
?>

<div class="testimonial-section pt-110 pb-110">
    <div class="quote">
        <i class="bi bi-quote"></i>
    </div>
    <div class="linear-left"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="section-title text-center mb-60">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center align-items-center gy-5 mb-30">
            <div class="col-xl-3">
                <div class="testimonial-card">
                    <h5><?php echo e(getArrayFromValue($fixedContent?->meta, 'title')); ?></h5>
                    <ul>
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <?php if($i <= (int)getArrayFromValue($fixedContent?->meta, 'avg_rating')): ?>
                                <li><i class="bi bi-star-fill"></i></li>
                            <?php else: ?>
                                <li><i class="bi bi-star"></i></li>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </ul>
                    <p><span><?php echo e(getArrayFromValue($fixedContent?->meta, 'total_reviews')); ?></span></p>
                </div>
            </div>

            <div class="col-xl-9">
                <div class="swiper testimonial-slider">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <div class="testimonial-item">
                                    <div class="content">
                                        <p><?php echo e(getArrayFromValue($enhancementContent->meta, 'testimonial')); ?></p>
                                        <div class="designation">
                                            <h6><?php echo e(getArrayFromValue($enhancementContent->meta, 'name')); ?></h6>
                                            <span><?php echo e(getArrayFromValue($enhancementContent->meta, 'designation')); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div
                class="slider-arrows arrows-style-1 text-center d-flex flex-row justify-content-center align-items-center gap-3 w-100">
                <div class="testi-prev swiper-arrow" tabindex="0" role="button" aria-label="Previous slide">
                    <i class="bi bi-arrow-left"></i>
                </div>
                <div class="testi-next swiper-arrow" tabindex="0" role="button" aria-label="Next slide">
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/component/testimonial.blade.php ENDPATH**/ ?>