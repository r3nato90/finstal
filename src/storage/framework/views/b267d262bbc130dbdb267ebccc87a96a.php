<?php
    $matrixInvestmentSetting = \App\Models\Setting::get('investment_matrix', 1);
?>
<?php if($matrixInvestmentSetting == 1): ?>
    <?php
        $fixedContent = \App\Services\FrontendService::getFrontendContent(\App\Enums\Frontend\SectionKey::MATRIX_PLAN, \App\Enums\Frontend\Content::FIXED);
    ?>
    <div class="pricing-section bg-color pt-110 pb-110">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4 mb-60">
                <div class="col-lg-5">
                    <div class="section-title style-two text-center">
                        <h2><?php echo e(getArrayFromValue($fixedContent?->meta, 'heading')); ?></h2>
                        <p><?php echo e(getArrayFromValue($fixedContent?->meta, 'sub_heading')); ?></p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <?php echo $__env->make('user.partials.matrix.plan', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="enrollMatrixModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="matrixTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="<?php echo e(route('user.matrix.store')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="uid" value="">
                    <div class="modal-body">
                        <p class="text-dark"><?php echo e(__("Are you sure you want to enroll in this matrix scheme?")); ?></p>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="i-btn btn--primary btn--sm"><?php echo e(__('Submit')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.enroll-matrix-process').click(function () {
                const uid = $(this).data('uid');
                const name = $(this).data('name');

                $('input[name="uid"]').val(uid);
                const title = " Join " + name + " Matrix Scheme";
                $('#matrixTitle').text(title);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/component/matrix_plan.blade.php ENDPATH**/ ?>