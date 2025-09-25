<?php if($item == \App\Enums\Frontend\InputField::ICON->value): ?>
    <div class="col-md-6">
        <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?> <sup class="text--danger">*</sup></label>
        <input type="text" class="form-control iconpicker icon" autocomplete="off" name="<?php echo e($key); ?>" value="<?php echo e($content->meta[$key] ?? ''); ?>" required>
        <small><?php echo e(__('Here are some Bootstrap icons you can use')); ?>: <a href="https://icons.getbootstrap.com/#icons" target="_blank"><?php echo e(__('Bootstrap Icons')); ?></a></small>
    </div>
<?php elseif($item == \App\Enums\Frontend\InputField::TEXT->value): ?>
    <div class="col-md-6">
        <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?> <sup class="text--danger">*</sup></label>
        <input type="text" class="form-control" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>" value="<?php echo e($content->meta[$key] ?? ''); ?>" placeholder="<?php echo e(__(replaceInputTitle($key))); ?>" required>
    </div>
<?php endif; ?>


<?php if($item == \App\Enums\Frontend\InputField::TEXTAREA->value): ?>
    <div class="col-md-12">
        <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?> <sup class="text--danger">*</sup></label>
        <textarea class="form-control" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>" placeholder="<?php echo e(__(replaceInputTitle($key))); ?>" required><?php echo e($content->meta[$key] ?? ''); ?></textarea>
    </div>
<?php elseif($item == \App\Enums\Frontend\InputField::TEXTAREA_EDITOR->value): ?>
    <div class="col-md-12">
        <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?> <sup class="text--danger">*</sup></label>
        <textarea class="summernote" id="<?php echo e($key); ?>" name="<?php echo e($key); ?>" required><?php echo $content->meta[$key] ?? '' ?></textarea>
    </div>
<?php endif; ?>


<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.summernote').summernote({
                height: 300,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['fullscreen'],
                    ['insert', ['picture', 'link', 'video']],
                ],
                callbacks: {
                    onInit: function() {
                    }
                }
            });
            $(".note-image-input").removeAttr('name');
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/standard_inputs.blade.php ENDPATH**/ ?>