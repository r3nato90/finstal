<?php $__env->startSection('content'); ?>
    <?php echo $__env->make(getActiveTheme().'.partials.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="privacy-policy pt-110 pb-110">
        <div class="container">
            <?php echo getArrayFromValue($content?->meta, 'descriptions') ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(getActiveTheme().'.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/policy.blade.php ENDPATH**/ ?>