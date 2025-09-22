<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo e(__('Terms and policy')); ?></h5>
            </div>
            <div class="modal-body">
                <div id="invest_terms" class="text-white"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="i-btn btn--danger btn--md" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="investModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investTitle"></h5>
            </div>

            <form method="POST" action="<?php echo e(route('user.investment.store')); ?>">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="uid" value="">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="col-form-label"><?php echo e(__('Amount')); ?></label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="amount" name="amount"
                                   placeholder="<?php echo e(__('Enter Invest amount')); ?>"
                                   aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <span class="input-group-text" id="basic-addon2"><?php echo e(getCurrencyName()); ?></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="i-btn btn--outline btn--md" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button type="submit" class="i-btn btn--primary btn--md"><?php echo e(__('Submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.invest-process').click(function () {
                const name = $(this).data('name');
                const uid = $(this).data('uid');
                $('input[name="uid"]').val(uid);

                const title = "Start Investing with the " + name + " Plan";
                $('#investTitle').text(title);
            });

            $('.terms-policy').click(function () {
                const terms = $(this).data('terms_policy');
                $('#invest_terms').text(terms);
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/finfunder/src/resources/views/user/partials/investment/plan_modal.blade.php ENDPATH**/ ?>