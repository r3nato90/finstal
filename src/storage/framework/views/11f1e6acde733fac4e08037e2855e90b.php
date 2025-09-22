<?php $__env->startSection('panel'); ?>
    <section>
        <!-- Page Header -->
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Login Attempts')); ?></h3>
        </div>

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0"><?php echo e(__('Total Attempts')); ?></p>
                                <h6 class="font-weight-bold mb-0"><?php echo e($statistics['total_attempts'] ?? 0); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0"><?php echo e(__('Successful')); ?></p>
                                <h6 class="font-weight-bold mb-0 text--success"><?php echo e($statistics['successful_attempts'] ?? 0); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0"><?php echo e(__('Failed')); ?></p>
                                <h6 class="font-weight-bold mb-0 text--danger"><?php echo e($statistics['failed_attempts'] ?? 0); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <p class="card-title text-muted mb-0"><?php echo e(__('Success Rate')); ?></p>
                                <h6 class="font-weight-bold mb-0 text--info"><?php echo e($statistics['success_rate'] ?? 0); ?>%</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.login-attempts.index')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" class="form-control" value="<?php echo e(request('search')); ?>" placeholder="<?php echo e(__('Email, IP, Location...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('Status')); ?></label>
                                <select name="successful" class="form-control">
                                    <option value=""><?php echo e(__('All')); ?></option>
                                    <option value="1" <?php echo e(request('successful') == '1' ? 'selected' : ''); ?>><?php echo e(__('Successful')); ?></option>
                                    <option value="0" <?php echo e(request('successful') == '0' ? 'selected' : ''); ?>><?php echo e(__('Failed')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('Device Type')); ?></label>
                                <select name="device_type" class="form-control">
                                    <option value=""><?php echo e(__('All')); ?></option>
                                    <?php $__currentLoopData = $filterOptions['device_types'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deviceType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($deviceType); ?>" <?php echo e(request('device_type') == $deviceType ? 'selected' : ''); ?>>
                                            <?php echo e(ucfirst($deviceType)); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('Date From')); ?></label>
                                <input type="date" name="date_from" class="form-control" value="<?php echo e(request('date_from')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label><?php echo e(__('Date To')); ?></label>
                                <input type="date" name="date_to" class="form-control" value="<?php echo e(request('date_to')); ?>">
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn--primary w-100">
                                    <i class="las la-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="filter-action mb-4">
            <button type="button" class="i-btn btn--danger btn--md" data-bs-toggle="modal" data-bs-target="#clearOldModal">
                <i class="las la-trash"></i> <?php echo e(__('Clear Old Records')); ?>

            </button>
        </div>

        <!-- Login Attempts Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0"><?php echo e(__('Login Attempts')); ?></h5>
                <div class="card-tools">
                    <span class="text-muted">
                        Showing <?php echo e($loginAttempts->firstItem() ?? 0); ?> to <?php echo e($loginAttempts->lastItem() ?? 0); ?>

                        of <?php echo e($loginAttempts->total() ?? 0); ?> login attempts
                    </span>
                </div>
            </div>

            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('IP & Location')); ?></th>
                        <th><?php echo e(__('Device Info')); ?></th>
                        <th>  <?php echo e(__('Status')); ?></th>
                        <th> <?php echo e(__('Date')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $loginAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <h6 class="mb-1"><?php echo e($attempt->user ? $attempt->user->fullname : __('Unknown')); ?></h6>
                                    <small class="text-muted"><?php echo e($attempt->email); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('IP & Location')); ?>">
                                <div class="location-info">
                                    <strong><?php echo e($attempt->ip_address); ?></strong>
                                    <?php if($attempt->location): ?>
                                        <br><small class="text-muted"><?php echo e($attempt->location); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Device Info')); ?>">
                                <div class="device-info">
                                    <?php if($attempt->device_type): ?>
                                        <span class="badge badge--info"><?php echo e(ucfirst($attempt->device_type)); ?></span>
                                    <?php endif; ?>
                                    <?php if($attempt->browser): ?>
                                        <br><small class="text-muted"><?php echo e($attempt->browser); ?></small>
                                    <?php endif; ?>
                                    <?php if($attempt->platform): ?>
                                        <br><small class="text-muted"><?php echo e($attempt->platform); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($attempt->successful): ?>
                                    <span class="badge badge--success"><?php echo e(__('Success')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge--danger"><?php echo e(__('Failed')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <div class="date-info">
                                    <strong><?php echo e($attempt->attempted_at->format('d M Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($attempt->attempted_at->format('H:i:s')); ?></small>
                                    <br><small class="text-muted"><?php echo e($attempt->attempted_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="5"><?php echo e(__('No login attempts found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">
            <?php echo e($loginAttempts->appends(request()->all())->links()); ?>

        </div>
    </section>

    <div class="modal fade" id="clearOldModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Clear Old Login Attempts')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.login-attempts.clear-old')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo e(__('Delete attempts older than (days)')); ?></label>
                            <input type="number" name="days" class="form-control" value="30" min="1" max="365" required>
                            <small class="form-text text-muted"><?php echo e(__('This action cannot be undone')); ?></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--secondary" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                        <button type="submit" class="btn btn--danger"><?php echo e(__('Delete Records')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/login_attempts/index.blade.php ENDPATH**/ ?>