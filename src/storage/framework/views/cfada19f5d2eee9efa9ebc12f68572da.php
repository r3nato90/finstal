<?php $__env->startSection('panel'); ?>
    <section>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo app('translator')->get('Cron Job Setting'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-8 pe-lg-5">
                            <div class="mb-3 col-lg-12">
                                <label for="cron" class="form-label"><?php echo e(__('Cron Job')); ?></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="curl -s <?php echo e(route('cron.run')); ?>" id="cron" aria-describedby="basic-addon-cron" readonly="">
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end cron-copy" id="basic-addon-cron"><?php echo app('translator')->get('Copy'); ?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 col-lg-12">
                                <label for="cron" class="form-label"><?php echo e(__('Queue Work')); ?></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" value="curl -s <?php echo e(route('queue.work')); ?>" id="work" aria-describedby="basic-addon-cron" readonly="">
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end queue-work" id="basic-addon-cron"><?php echo app('translator')->get('Copy'); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body bg--light">
                                <p class="text--light mb-2">
                                    <?php echo e(__('Set the cron job to run once every minute for optimal efficiency and precision. This frequency ensures timely execution and responsiveness to any scheduled tasks or processes. By configuring the cron to activate every minute, you guarantee that no critical actions or updates are missed, thereby maintaining system reliability and performance at its peak.')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo app('translator')->get('API Base URL'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-lg-8 pe-lg-5">
                            <div class="mb-3 col-lg-12">
                                <label for="apiBaseUrl" class="form-label"><?php echo e(__('API Base URL')); ?></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="apiBaseUrl" value="<?php echo e(URL::to('/').'/api'); ?>" aria-describedby="basic-addon-api" readonly>
                                    <div class="input-group-append pointer">
                                        <span class="input-group-text bg--linear-success text-light rounded-end api-copy based-url" id="basic-addon-api"><?php echo app('translator')->get('Copy'); ?></span>
                                    </div>
                                </div>
                                <small class="text-muted">
                                    <?php echo app('translator')->get('Use this API Base URL to connect your React and Flutter applications.'); ?>
                                </small>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card-body bg--light">
                                <p class="text-muted mb-2">
                                    <?php echo app('translator')->get('This URL ensures seamless integration between your frontend applications and the backend.'); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <?php echo $__env->make('admin.partials.filter', [
                 'is_filter' => false,
                 'is_modal' => false,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin.partials.table', [
                 'columns' => [
                     'created_at' => __('admin.table.created_at'),
                     'name' => __('admin.table.name'),
                     'ideal_time' => __('Ideal Time'),
                     'last_run' => __('Last Run'),
                 ],
                 'rows' => $cron,
                 'page_identifier' => \App\Enums\PageIdentifier::CRON->value,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.based-url').click(function() {
                const copyText = $('#apiBaseUrl').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });

            $('.cron-copy').click(function() {
                const copyText = $('#cron').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });

            $('.queue-work').click(function() {
                const copyText = $('#work').val();
                const textArea = document.createElement('textarea');
                textArea.value = copyText;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                notify('success', 'Copied to clipboard!');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/settings/automation.blade.php ENDPATH**/ ?>