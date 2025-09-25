<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.frontend.fixed', [
            'key' => $key,
            'section' => $section,
            'content' => $frontend,
            'content_type' => \App\Enums\Frontend\Content::ENHANCEMENT->value
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/element.blade.php ENDPATH**/ ?>