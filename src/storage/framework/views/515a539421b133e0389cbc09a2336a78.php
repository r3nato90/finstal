<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($setTitle); ?></h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <h5 class="mb-2"><?php echo e(__('All Sections')); ?></h5>
                            <ul id="list" class="list-group gap-2 dragable-list">
                                <?php $__empty_1 = true; $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sectionKey): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <li class="list-group-item bg--light rounded-1 cursor-pointer" data-section_key="<?php echo e($sectionKey); ?>">
                                        <p><?php echo e(ucfirst(replaceInputTitle($sectionKey))); ?></p>

                                        <span class="dragable-icon">
                                            <i class="bi bi-arrows-move"></i>
                                        </span>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <li class="list-group-item no-sections-message">No sections found</li>
                                <?php endif; ?>
                            </ul>
                        </div>

                        <div class="col-lg-6">
                            <h5 class="mb-2"><?php echo e(__($menu->name)); ?> Sections</h5>
                            <form id="submitForm" method="post" action="<?php echo e(route('admin.pages.section.update', ['id' => $menu->id])); ?>">
                                <?php echo csrf_field(); ?>
                                <ul id="list2" class="list-group gap-2 dragable-list" data-menu-id="<?php echo e($menu->id); ?>">
                                    <?php $__empty_1 = true; $__currentLoopData = $menu->section_key ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <li class="list-group-item bg--light rounded-1 cursor-pointer" data-section_key="<?php echo e($section); ?>">
                                            <p>
                                                <?php echo e(replaceInputTitle($section)); ?>

                                            </p>

                                            <span class="dragable-icon">
                                                <i class="bi bi-arrows-move"></i>
                                            </span>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <li class="list-group-item bg--light rounded-1 cursor-pointer"></li>
                                    <?php endif; ?>
                                </ul>
                                <button class="i-btn btn--primary btn--md" type="button" onclick="submitForm()">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-push'); ?>
    <style>
        ul:empty {
            padding: 20px;
            background: pink;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-include'); ?>
    <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::ADMIN, \App\Enums\Theme\FileType::JS, 'sortable.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        function submitForm() {
            const sectionKeys = $('#list2 li').map(function () {
                return $(this).data('section_key');
            }).get();

            $.ajax({
                method: 'POST',
                url: $('#submitForm').attr('action'),
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    section_keys: sectionKeys
                },
                success: function (response) {
                    notify('success', response);
                },
                error: function (error) {
                    notify('error', error);
                }
            });
        }

        $(document).ready(function () {
            new Sortable(document.getElementById('list'), {
                group: 'shared',
                animation: 100
            });

            new Sortable(document.getElementById('list2'), {
                group: 'shared',
                animation: 100,
                emptyInsertThreshold: 0
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/menu/sections.blade.php ENDPATH**/ ?>