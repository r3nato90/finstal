<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="i-card-sm">
            <div class="row align-items-center gy-5">
                <div class="col-xxl-12 col-xl-12 col-lg-12 order-lg-1 order-2">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="tree-view-container">
                                    <ul class="treeview">
                                        <li class="items-expanded"> <?php echo e($user->fullname); ?> ( <?php echo e($user->email); ?> )  <span><i class="bi bi-activity"></i> <?php echo e(__('Referral Pool')); ?> <i class="bi bi-arrow-right"></i> <?php echo e($user->referredUsers->count()); ?></span>
                                            <?php echo $__env->make('user.partials.tree-view', [ 'user' => $user,'step' => 0,'isFirst'=>true ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style-file'); ?>
    <link rel="stylesheet" href="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::CSS, 'tree-view.css')); ?>" />
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-file'); ?>
    <script src="<?php echo e(getAssetPath(\App\Enums\Theme\ThemeAsset::GLOBAL, \App\Enums\Theme\FileType::JS, 'tree-view.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.tree-view').treeView();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/referral/index.blade.php ENDPATH**/ ?>