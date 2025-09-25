
    <div class="card mb-3">
        <div class="card-header">
            <h4 class="card-title"><?php echo e(__($setTitle)); ?></h4>
            <?php if(isset($section[\App\Enums\Frontend\Content::ENHANCEMENT->value])): ?>
                <a href="<?php echo e(route('admin.frontend.section.content',$key)); ?>" class="i-btn btn--primary btn--sm">
                    <i class="las la-plus"></i>
                    <?php echo app('translator')->get('Add New'); ?>
                </a>
            <?php endif; ?>
        </div>
        
        
        <?php if(isset($section[$content_type])): ?>
            <div class="card-body">
                <form action="<?php echo e(route('admin.frontend.section.save', $key)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="content" value="<?php echo e($content_type); ?>">
    
                    <?php if($content): ?>
                        <input type="hidden" name="id" value="<?php echo e($content->id); ?>">
                    <?php endif; ?>
    
                    <div class="row g-3 mb-3">
                        <?php $__currentLoopData = $section[$content_type]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key == 'images'): ?>
                                <?php echo $__env->make('admin.frontend.upload_inputs', ['item' => $item, 'key' => $key, 'content' => $content], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php else: ?>
                                <?php echo $__env->make('admin.frontend.standard_inputs',['item' => $item, 'key' => $key, 'content' => $content], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <button type="submit" class="i-btn btn--primary btn--md"><?php echo e(__("admin.button.save")); ?></button>
                </form>
            </div>
        <?php endif; ?>
    </div>

<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/fixed.blade.php ENDPATH**/ ?>