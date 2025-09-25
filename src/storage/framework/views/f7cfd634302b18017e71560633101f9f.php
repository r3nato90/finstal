<?php
    $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::CRYPTO_PAIRS, \App\Enums\Frontend\Content::FIXED);
?>

<div class="conversion-section bg-color pt-110 pb-110">
    <div class="linear-right"></div>
    <div class="container">
        <div class="row justify-content-center g-4">
            <div class="col-lg-7">
                <div class="section-title style-two text-center mb-60">
                    <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                    <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <?php $__currentLoopData = $cryptoConversions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $conversion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $pair = explode('/', $conversion->pair)
                ?>
                <div class="col-xl-4 col-lg-4 col-md-6">
                    <div class="converstion-item">
                        <div class="content">
                            <h5><?php echo e(strtoupper($conversion->symbol)); ?> <i class="bi bi-arrow-right"></i> <?php echo e(strtoupper($pair[1] ?? 'USDT')); ?></h5>
                            <p>1 <?php echo e(strtoupper($conversion->symbol)); ?> = <?php echo e(getArrayFromValue($conversion->meta, 'current_price')); ?> <?php echo e(strtoupper($pair[1] ?? 'USDT')); ?></p>
                        </div>
                        <div class="icons">
                            <img src="<?php echo e($conversion->image_url); ?>" alt="<?php echo e(__('image')); ?>">
                            <img src="<?php echo e(displayImage(getArrayFromValue($fixedContent->meta, 'conversion_image'), '276x276')); ?>" alt="<?php echo e(__('image')); ?>">
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/component/crypto_pairs.blade.php ENDPATH**/ ?>