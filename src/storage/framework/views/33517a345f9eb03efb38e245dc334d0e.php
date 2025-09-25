<?php $__env->startSection('panel'); ?>
    <section>
        <?php echo $__env->make('admin.partials.filter', [
             'is_filter' => false,
             'is_modal' => true,
             'urls' => [
                [
                    'type' => 'modal',
                    'id' => 'exampleModal',
                    'name' => 'Add New',
                    'icon' => "<i class='las la-plus'></i>"
                ],
            ],
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('admin.partials.table', [
            'columns' => [
                'created_at' => __('Initiated At'),
                'name' => __('Name'),
                'url' => __('Url'),
                'menu_parent_id' => __('Parent'),
                'menu_action' => __('Action'),
            ],
            'rows' => $paginateByMenus,
            'page_identifier' => \App\Enums\PageIdentifier::MENU->value,
       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </section>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Add New Menu'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.pages.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="name"><?php echo app('translator')->get('Name'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="<?php echo app('translator')->get('Enter Name'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="url"><?php echo app('translator')->get('Url'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="url" id="url" class="form-control" placeholder="<?php echo app('translator')->get('Enter Url'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="parent_id"><?php echo app('translator')->get('Parent'); ?></label>
                                <select class="form-select" id="parent_id" name="parent_id">
                                    <option value="" selected><?php echo app('translator')->get('None'); ?></option>
                                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($menu->id); ?>"><?php echo e(__($menu->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="status"><?php echo app('translator')->get('Status'); ?></label>
                                <select class="form-select" id="status" name="status">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select Status'); ?></option>
                                    <option value="<?php echo e(\App\Enums\MenuStatus::ENABLE->value); ?>"><?php echo app('translator')->get('Enable'); ?></option>
                                    <option value="<?php echo e(\App\Enums\MenuStatus::DISABLE->value); ?>"><?php echo app('translator')->get('Disable'); ?></option>
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

    <div class="modal fade" id="menuUpdateModal" tabindex="-1" role="dialog" aria-labelledby="menuUpdateModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" ><?php echo app('translator')->get('Update Menu'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.pages.update')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editName"><?php echo app('translator')->get('Name'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="name" id="editName" class="form-control" placeholder="<?php echo app('translator')->get('Enter Name'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editUrl"><?php echo app('translator')->get('Url'); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="url" id="editUrl" class="form-control" placeholder="<?php echo app('translator')->get('Enter Url'); ?>">
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editParent_id"><?php echo app('translator')->get('Parent'); ?></label>
                                <select class="form-select" id="editParent_id" name="parent_id">
                                    <option value="" selected><?php echo app('translator')->get('None'); ?></option>
                                    <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($menu->id); ?>"><?php echo e(__($menu->name)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>

                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="editStatus"><?php echo app('translator')->get('Status'); ?></label>
                                <select class="form-select" id="editStatus" name="status">
                                    <option value="" selected disabled><?php echo app('translator')->get('Select Status'); ?></option>
                                    <option value="<?php echo e(\App\Enums\MenuStatus::ENABLE->value); ?>"><?php echo app('translator')->get('Enable'); ?></option>
                                    <option value="<?php echo e(\App\Enums\MenuStatus::DISABLE->value); ?>"><?php echo app('translator')->get('Disable'); ?></option>
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

    <div class="modal fade" id="menuDeleteModal" tabindex="-1" role="dialog" aria-labelledby="menuDeleteModal" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo app('translator')->get('Confirm Menu Deletion'); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.pages.delete')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <p><?php echo app('translator')->get('Are you sure you want to delete this menu?'); ?></p>
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
            $(".menuUpdateBtn").on('click', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const name = $(this).data('name');
                const url = $(this).data('url');
                const status = $(this).data('status');
                const parentId = $(this).data('parent_id');

                const modal = $('#menuUpdateModal');
                modal.find('input[name=id]').val(id);
                modal.find('input[name=name]').val(name);
                modal.find('input[name=url]').val(url);
                modal.find('select[name=parent_id]').val(parentId);
                modal.find('select[name=status]').val(status);
                modal.modal('show');
            });

            $(document).on('click', '.menuDeleteBtn', function(event) {
                event.preventDefault();
                const id = $(this).data('id');
                const modal = $('#menuDeleteModal');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.select2').select2({
                tags: true,
                tokenSeparators: [',']
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/menu/index.blade.php ENDPATH**/ ?>