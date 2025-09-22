<?php
    $enhancementContents = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::PROCESS, \App\Enums\Frontend\Content::ENHANCEMENT);
?>

<div class="process-section bg-color pt-110 pb-110" id="process">
    <div class="container">
        <div class="row g-0">
            <?php $__currentLoopData = $enhancementContents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $enhancementContent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-4 col-lg-4">
                    <div class="process-item">
                        <span class="serial"><?php echo e($loop->iteration); ?></span>
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
<?php /**PATH /var/www/html/finfunder/src/resources/views/default_theme/component/process.blade.php ENDPATH**/ ?>