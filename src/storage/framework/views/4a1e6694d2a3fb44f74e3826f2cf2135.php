
<ul class="<?php echo e($isFirst ? 'firstList' : ''); ?> sub-menu side-menu-dropdown collapse show">
    <?php $__currentLoopData = $user->recursiveReferrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $positionedAbove): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first): ?>
            <?php ++$step ?>
        <?php endif; ?>
        <li class="sub-menu-item">
            <a class="referral-single-link" href="javascript:void(0)">
                <p class="node-element" type="button" data-bs-toggle="collapse" data-bs-target="#node-ul-<?php echo e($positionedAbove->id); ?>" aria-expanded="true" aria-controls="node-ul-<?php echo e($positionedAbove->id); ?>">
                    <span><i class="bi bi-person"></i> <?php echo e($positionedAbove->fullname); ?></span>
                    <span><i class="bi bi-envelope"></i> <?php echo e($positionedAbove->email); ?></span>
                    <span><i class="bi bi-activity"></i> <?php echo e(__('Referral Pool')); ?> <i class="bi bi-arrow-right"></i> <?php echo e($positionedAbove->referredUsers->count()); ?></span>
                </p>
            <?php if($positionedAbove->recursiveReferrals->count() > 0 && ($step < \App\Services\Investment\MatrixService::getMatrixHeight())): ?>
                <?php echo $__env->make('user.partials.tree-view',['user'=> $positionedAbove,'step'=> $step,'isFirst'=>false], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/tree-view.blade.php ENDPATH**/ ?>