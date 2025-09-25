<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'keyAddModal',
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
                 [
                    'type' => 'modal',
                    'id' => 'keyImportModal',
                    'name' => 'Import Keywords',
                    'icon' => "<i class='las la-plus'></i>"
                ]
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                        <tr>
                            <th><?php echo e(__('Key')); ?></th>
                            <th><?php echo e(__($language->name)); ?></th>
                            <th><?php echo e(__('Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $json; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $jsonLanguage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="Key">
                                <?php echo e($key); ?>

                            </td>
                            <td data-label="<?php echo e(__($language->name)); ?>">
                                <?php echo e($jsonLanguage); ?>

                            </td>
                            <td data-label="Action">
                                <div class="d-flex align-items-center justify-content-md-start justify-content-end gap-1">
                                    <a href="javascript:void(0)" class="badge badge--primary-transparent keyUpdateBtn"
                                       data-toggle="modal"
                                       data-target="#keyUpdateModal"
                                       data-key="<?php echo e($key); ?>"
                                       data-value="<?php echo e($jsonLanguage); ?>"
                                    ><?php echo e(__('Edit')); ?></a>

                                    <a href="javascript:void(0)" class="badge badge--danger-transparent keyDeleteBtn"
                                       data-toggle="modal"
                                       data-target="#keyDeleteModal"
                                       data-key="<?php echo e($key); ?>"
                                       data-value="<?php echo e($jsonLanguage); ?>"
                                        ><?php echo e(__('Delete')); ?></a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="100%"><?php echo e(__('No Data Found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="keyAddModal" tabindex="-1" role="dialog" aria-labelledby="keyAddModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><?php echo app('translator')->get('Add Language Value'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.store.key', $language->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="key"><?php echo app('translator')->get('Key'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="key" id="key" class="form-control" placeholder="<?php echo app('translator')->get('Enter key'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="value"><?php echo app('translator')->get('Value'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="value" id="value" class="form-control" placeholder="<?php echo app('translator')->get('Enter value'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="keyUpdateModal" tabindex="-1" role="dialog" aria-labelledby="keyUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><?php echo app('translator')->get('Update Language Value'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.update.key', $language->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="key" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="value"><?php echo app('translator')->get('Value'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="value" id="value" class="form-control" placeholder="<?php echo app('translator')->get('Enter value'); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="keyDeleteModal" tabindex="-1" role="dialog" aria-labelledby="keyDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Confirm Language Value Deletion'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.delete.key', $language->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="key">
                    <input type="hidden" name="value">

                    <div class="modal-body">
                        <div class="row">
                            <p><?php echo app('translator')->get('Are you sure you want to delete this Language value?'); ?></p>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo app('translator')->get('Delete'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="keyImportModal" tabindex="-1" role="dialog" aria-labelledby="keyImportModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Import Language'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.import', $language->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>


                    <div class="modal-body">
                        <div class="row">
                            <p><?php echo app('translator')->get('When importing keywords, your existing ones will be removed and substituted with the imported ones'); ?></p>
                        </div>

                        <div class="col-lg-12 mb-3">
                            <label class="form-label" for="from_language"><?php echo app('translator')->get('Language'); ?></label>
                            <select class="form-select" id="from_language" name="from_language">
                                <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if (! ($data->id == $language->id)): ?>
                                        <option value="<?php echo e($data->id); ?>"><?php echo e(__($data->name)); ?></option>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo app('translator')->get('Close'); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo app('translator')->get('Submit'); ?></button>
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
            $(".keyUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const key = $(this).data('key');
                const value = $(this).data('value');

                const modal = $('#keyUpdateModal');
                modal.find('input[name=key]').val(key);
                modal.find('input[name=value]').val(value);
                modal.modal('show');
            });

            $('.keyDeleteBtn').on('click', function(event) {
                event.preventDefault();
                const key = $(this).data('key');
                const value = $(this).data('value')

                const modal = $('#keyDeleteModal');
                modal.find('input[name=key]').val(key);
                modal.find('input[name=value]').val(value);
                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/language/edit.blade.php ENDPATH**/ ?>