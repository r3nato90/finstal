<?php
    $textValue = \App\Enums\Frontend\InputField::TEXT->value;
    $iconValue = \App\Enums\Frontend\InputField::ICON->value;
    $imagesValue = Illuminate\Support\Arr::has($section, $content_type.'.images');
    $images = null;
    if($imagesValue){
        $images = array_keys(Illuminate\Support\Arr::get($section, $content_type.'.images'));
    }
?>


<?php if(isset($section[$content_type])): ?>
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="card-title"><?php echo e(__('Enhancement Contents')); ?></h4>
        </div>
        <div class="responsive-table">
            <table>
                <thead>
                    <tr>
                        <th><?php echo e(__('#')); ?></th>
                        <?php if($imagesValue): ?>
                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th><?php echo e(__(replaceInputTitle($image ?? ''))); ?></th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php $__currentLoopData = $section[$content_type]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($item, [$textValue, $iconValue])): ?>
                                <th><?php echo e(__(replaceInputTitle($key))); ?></th>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th><?php echo e(__('admin.table.action')); ?></th>
                    </tr>
                </thead>
                <?php $__empty_1 = true; $__currentLoopData = $contents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="<?php echo e($loop->even); ?>">
                        <td data-label="<?php echo e(__('admin.table.name')); ?>"><?php echo e($loop->iteration); ?></td>
                        <?php if($imagesValue): ?>
                            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <td data-label="<?php echo e(__('admin.input.image')); ?>">
                                    <?php if(isset($content->meta[$image])): ?>
                                        <img src="<?php echo e(displayImage($content->meta[$image])); ?>" class="avatar--md" alt="<?php echo e(__($image)); ?>">
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <?php $__currentLoopData = $section[$content_type]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(in_array($item, [$textValue, $iconValue])): ?>
                                <td data-label="<?php echo e(__(replaceInputTitle($key))); ?>">
                                    <?php echo e($content->meta[$key] ?? ''); ?>

                                </td>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <td data-label="<?php echo e(__('Action')); ?>">
                            <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-3">
                                <a href="<?php echo e(route('admin.frontend.section.content', [$section_key, $content->id])); ?>" class="badge badge--primary-transparent"><i class="la la-pencil-alt"></i></a>
                                <a href="javascript:void(0)" class="badge badge--danger-transparent remove-element"
                                   data-bs-toggle="modal"
                                   data-bs-target="#delete-element"
                                   data-id="<?php echo e($content->id); ?>"
                                ><i class="las la-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td class="text-muted text-center" colspan="100%"><?php echo e(__('No Data Found')); ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/frontend/enhancement.blade.php ENDPATH**/ ?>