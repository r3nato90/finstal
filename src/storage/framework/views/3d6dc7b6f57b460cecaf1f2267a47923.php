<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'languageModel',
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.partials.table', [
            'columns' => [
                'created_at' => __('Initiated At'),
                'name' => __('Name'),
                'code' => __('Code'),
                'language_is_default' => __('Default'),
                'language_action' => __('Action'),
            ],
            'rows' => $languages,
            'page_identifier' => \App\Enums\PageIdentifier::LANGUAGE->value,
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="languageModel" tabindex="-1" role="dialog" aria-labelledby="languageModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><?php echo app('translator')->get('Add New Language'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo app('translator')->get('Name'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo app('translator')->get('Enter Name'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="code"><?php echo app('translator')->get('Code'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="code" id="code" class="form-control" placeholder="<?php echo app('translator')->get('Enter Code'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="is_default"><?php echo app('translator')->get('Default'); ?></label>
                                <select class="form-select" id="is_default" name="is_default">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                                    <option value="<?php echo e(\App\Enums\Status::ACTIVE->value); ?>"><?php echo app('translator')->get('Yes'); ?></option>
                                    <option value="<?php echo e(\App\Enums\Status::INACTIVE->value); ?>"><?php echo app('translator')->get('No'); ?></option>
                                </select>
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

    <div class="modal fade" id="languageUpdateModal" tabindex="-1" role="dialog" aria-labelledby="languageUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Update Language'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>

                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo app('translator')->get('Name'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo app('translator')->get('Enter Name'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="is_default"><?php echo app('translator')->get('Default'); ?></label>
                                <select class="form-select" id="is_default" name="is_default">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                                    <option value="<?php echo e(\App\Enums\Status::ACTIVE->value); ?>"><?php echo app('translator')->get('Yes'); ?></option>
                                    <option value="<?php echo e(\App\Enums\Status::INACTIVE->value); ?>"><?php echo app('translator')->get('No'); ?></option>
                                </select>
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

    <div class="modal fade" id="languageDeleteModal" tabindex="-1" role="dialog" aria-labelledby="languageDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Confirm Language Deletion'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.language.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <p><?php echo app('translator')->get('Are you sure you want to delete this Language?'); ?></p>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $(".languageUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                const isDefault = $(this).data('is_default');

                const modal = $('#languageUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('select[name=is_default]').val(isDefault);
                modal.modal('show');
            });

            $('.languageDeleteBtn').on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#languageDeleteModal');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/language/index.blade.php ENDPATH**/ ?>