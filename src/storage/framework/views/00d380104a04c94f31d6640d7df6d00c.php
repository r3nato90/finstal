<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.frontend.fixed', [
            'key' => $key,
            'section' => $section,
            'content' => $getFixedContent,
            'content_type' => \App\Enums\Frontend\Content::FIXED->value
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo $__env->make('admin.frontend.enhancement', [
            'section_key' => $key,
            'section' => $section,
            'content_type' => \App\Enums\Frontend\Content::ENHANCEMENT->value,
            'contents' => $getEnhancementContents
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="delete-element" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Delete Element')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.frontend.section.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p><?php echo e(__('Are you sure to delete this section element')); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal"><?php echo e(__('admin.button.close')); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('admin.button.delete')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $('.remove-element').on('click', function () {
            const modal = $('#delete-element');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.modal('show');
        });
    </script>
<?php $__env->stopPush(); ?>




<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/index.blade.php ENDPATH**/ ?>