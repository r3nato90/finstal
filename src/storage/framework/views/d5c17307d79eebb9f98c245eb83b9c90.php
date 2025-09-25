<?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6">
        <div>
            <label for="<?php echo e($key); ?>" class="form-label"><?php echo e(__(replaceInputTitle($key))); ?></label>
            <input type="file" class="form-control" id="<?php echo e($key); ?>" name="images[<?php echo e($key); ?>]" value="<?php echo e($content->meta[$key] ?? ''); ?>" placeholder="<?php echo e(__(replaceInputTitle($key))); ?>">
            <small><?php echo e(__('File formats supported: jpeg, jpg, png. The image will be resized to')); ?> <?php echo e($file['size'] ?? ''); ?> <?php echo e(__('pixels')); ?>.
                <a href="<?php echo e(displayImage(@$content->meta[$key], $file['size'])); ?>" target="_blank"><?php echo e(__('view image')); ?></a>
            </small>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/upload_inputs.blade.php ENDPATH**/ ?>