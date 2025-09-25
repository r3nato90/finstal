<?php $__env->startSection('panel'); ?>
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e(__($setTitle)); ?></h4>
                </div>

                <div class="card-body">
                    <div class="text-center mb-4">
                        <p><strong><?php echo e(__('Current Version')); ?></strong> : <?php echo e(config('app.app_version')); ?></p>
                        <p><strong><?php echo e(__('New Version')); ?></strong> : <?php echo e(config('app.migrate_version')); ?></p>
                    </div>

                    <?php if(version_compare(config('app.migrate_version'), config('app.app_version'), '>')): ?>
                        <div class="border p-4 mb-4">
                            <h5 class="text-center mb-4">
                                Important System Upgrade Notice - Version 5.0.1
                            </h5>

                            <div class="mt-4 text-center">
                                <button type="button" class="btn btn-primary btn-lg" id="upgradeButton">
                                    <?php echo e(__('Update System to Version 5')); ?>

                                </button>
                            </div>
                        </div>

                    <?php else: ?>
                        <div class="text-center border p-4">
                            <h5>System is up to date!</h5>
                            <p>You are running the latest version of the system.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="upgradeConfirmModal" tabindex="-1" role="dialog" aria-labelledby="upgradeConfirmModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Confirm System Upgrade'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.settings.migrate')); ?>" method="POST" id="upgradeForm">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirmUpgrade" required>
                            <label class="form-check-label" for="confirmUpgrade">
                                <strong><?php echo app('translator')->get('I agree to proceed with this upgrade'); ?></strong>
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Cancel'); ?></button>
                        <button type="submit" class="btn btn--danger btn--sm" id="confirmUpgradeButton" disabled>
                            <?php echo app('translator')->get('Proceed with Upgrade'); ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('#upgradeButton').on('click', function(event) {
                event.preventDefault();
                $('#upgradeConfirmModal').modal('show');
            });

            $('#confirmUpgrade').on('change', function() {
                $('#confirmUpgradeButton').prop('disabled', !this.checked);
            });

            $('#upgradeForm').on('submit', function(e) {
                if (!$('#confirmUpgrade').is(':checked')) {
                    e.preventDefault();
                    alert('<?php echo app('translator')->get("Please confirm that you agree to proceed with the upgrade."); ?>');
                    return false;
                }

                $('#confirmUpgradeButton').html('<?php echo app('translator')->get("Upgrading System..."); ?>').prop('disabled', true);
                $('#upgradeButton').html('<?php echo app('translator')->get("Upgrading System..."); ?>').prop('disabled', true);
            });

            $('#upgradeConfirmModal').on('hidden.bs.modal', function () {
                $('#confirmUpgrade').prop('checked', false);
                $('#confirmUpgradeButton').prop('disabled', true);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/settings/system_update.blade.php ENDPATH**/ ?>