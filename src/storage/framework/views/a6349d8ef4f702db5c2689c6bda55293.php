<h3 class="page-title"><?php echo e(__($setTitle)); ?></h3>
<?php if($is_filter): ?>
    <div class="filter-wrapper">
        <div class="card-filter">
            <form action="<?php echo e($route); ?>" method="GET">
                <div class="filter-form">
                    <?php $__currentLoopData = $filters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::SELECT_OPTIONS->value): ?>
                            <div class="filter-item">
                                <select name="<?php echo e(getArrayFromValue($filter, 'name')); ?>" class="form-select" id="<?php echo e(getArrayFromValue($filter, 'name')); ?>">
                                    <option value=""><?php echo e(__('admin.filter.placeholder.select')); ?></option>
                                    <?php $__currentLoopData = $filter['value'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php if((int)request(getArrayFromValue($filter, 'name')) == $key): ?> selected <?php endif; ?>><?php echo e(replaceInputTitle($option)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        <?php elseif(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::TEXT->value): ?>
                            <div class="filter-item">
                                <input type="text" name="<?php echo e(getArrayFromValue($filter, 'name')); ?>" placeholder="<?php echo e(getArrayFromValue($filter, 'placeholder')); ?>" class="form-control" id="<?php echo e(getArrayFromValue($filter, 'name')); ?>" value="<?php echo e(request(getArrayFromValue($filter, 'name'))); ?>">
                            </div>
                        <?php elseif(getArrayFromValue($filter, 'type') == \App\Enums\FilterType::DATE_RANGE->value): ?>
                            <div class="filter-item">
                                <input type="text" id="<?php echo e(getArrayFromValue($filter, 'name')); ?>" class="form-control datepicker-here" name="<?php echo e(getArrayFromValue($filter, 'name')); ?>"
                                   value="<?php echo e(request(getArrayFromValue($filter, 'name'))); ?>" data-range="true" data-multiple-dates-separator=" - "
                                   data-language="en" data-position="bottom right" autocomplete="off"
                                   placeholder="<?php echo e(getArrayFromValue($filter, 'placeholder')); ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <button class="i-btn btn--primary btn--md" type="submit">
                        <i class="fas fa-search"></i> <?php echo e($btn_name); ?>

                    </button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>

<?php if($is_modal): ?>
    <div class="filter-action">
        <?php $__currentLoopData = $urls ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $navigation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(getArrayFromValue($navigation, 'type') == 'modal'): ?>
                <button type="button" data-bs-toggle="modal" data-bs-target="#<?php echo e(getArrayFromValue($navigation, 'id')); ?>"
                        class="i-btn btn--dark btn--md"><?php echo getArrayFromValue($navigation, 'icon')  ?> <?php echo e(getArrayFromValue($navigation, 'name')); ?>

                </button>
            <?php else: ?>
                <a href="<?php echo e(getArrayFromValue($navigation, 'url')); ?>" class="i-btn btn--primary btn--md"><?php echo getArrayFromValue($navigation, 'icon')  ?> <?php echo e(getArrayFromValue($navigation, 'name')); ?> </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/partials/filter.blade.php ENDPATH**/ ?>