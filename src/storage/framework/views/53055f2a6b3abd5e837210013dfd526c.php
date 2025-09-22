<?php use App\Enums\Investment\Status; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="page-title"><?php echo e(__('Investment Plans Management')); ?></h3>
                <a href="<?php echo e(route('admin.binary.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus"></i> <?php echo e(__('Create Plan')); ?>

                </a>
            </div>
        </div>

        <div class="row mb-4 mt-2">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Plans')); ?></h6>
                        <h4 class="text--dark"><?php echo e($stats['totalPlans']); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Active Plans')); ?></h6>
                        <h4 class="text--success"><?php echo e($stats['activePlans']); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Recommended Plans')); ?></h6>
                        <h4 class="text--info"><?php echo e($stats['recommendedPlans']); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Investments')); ?></h6>
                        <h4 class="text--primary"><?php echo e($stats['totalInvestments']); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.binary.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('Name, UID...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="1" <?php echo e(($filters['status'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Active')); ?></option>
                                    <option value="0" <?php echo e(($filters['status'] ?? '') == '0' ? 'selected' : ''); ?>><?php echo e(__('Inactive')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="type"><?php echo e(__('Type')); ?></label>
                                <select name="type" id="type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="1" <?php echo e(($filters['type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Fixed')); ?></option>
                                    <option value="2" <?php echo e(($filters['type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Flexible')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="interest_type"><?php echo e(__('Interest Type')); ?></label>
                                <select name="interest_type" id="interest_type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="1" <?php echo e(($filters['interest_type'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Percentage')); ?></option>
                                    <option value="2" <?php echo e(($filters['interest_type'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Fixed')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="name" <?php echo e(($filters['sort_field'] ?? '') == 'name' ? 'selected' : ''); ?>><?php echo e(__('Name')); ?></option>
                                    <option value="interest_rate" <?php echo e(($filters['sort_field'] ?? '') == 'interest_rate' ? 'selected' : ''); ?>><?php echo e(__('Interest Rate')); ?></option>
                                    <option value="minimum" <?php echo e(($filters['sort_field'] ?? '') == 'minimum' ? 'selected' : ''); ?>><?php echo e(__('Minimum Amount')); ?></option>
                                    <option value="status" <?php echo e(($filters['sort_field'] ?? '') == 'status' ? 'selected' : ''); ?>><?php echo e(__('Status')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-3">
                            <div class="form-group">
                                <label>&nbsp;</label>
                                <button type="submit" class="btn btn-primary btn-block"><?php echo e(__('Filter')); ?></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="responsive-table">
                <table>
                    <thead>
                    <tr>
                        <th><?php echo e(__('UID')); ?></th>
                        <th><?php echo e(__('Name')); ?></th>
                        <th><?php echo e(__('Amount Range')); ?></th>
                        <th><?php echo e(__('Type')); ?></th>
                        <th><?php echo e(__('Interest Rate')); ?></th>
                        <th><?php echo e(__('Duration')); ?></th>
                        <th><?php echo e(__('Return Type')); ?></th>
                        <th><?php echo e(__('Total Investments')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $investmentPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('UID')); ?>">
                                <strong><?php echo e($plan->uid); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Name')); ?>">
                                <strong><?php echo e($plan->name); ?></strong>
                                <?php if($plan->is_recommend): ?>
                                    <br><span class="badge badge--warning-transparent"><?php echo e(__('Recommended')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Amount Range')); ?>">
                                <div class="amount-range">
                                    <?php if($plan->type == 2): ?>
                                        <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->amount, 2)); ?></strong>
                                    <?php else: ?>
                                        <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->minimum, 2)); ?></strong>
                                        <br><small class="text-muted">to <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->maximum, 2)); ?></small>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Type')); ?>">
                                <?php if($plan->type == 1): ?>
                                    <span class="badge badge--success"><?php echo e(__('Fixed')); ?></span>
                                <?php elseif($plan->type == 2): ?>
                                    <span class="badge badge--info"><?php echo e(__('Flexible')); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Interest Rate')); ?>">
                                <span class="badge badge--info"><?php echo e(shortAmount($plan->interest_rate, 2)); ?> <?php if($plan->interest_type == 2): ?><?php echo e(getCurrencyName()); ?> <?php else: ?> %<?php endif; ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Duration')); ?>">
                                <?php if($plan->timeTable): ?>
                                    <span class="badge badge--primary"><?php echo e($plan->duration); ?> <?php echo e($plan->timeTable->name); ?></span>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e($plan->duration); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Return Type')); ?>">
                                <?php if($plan->interest_return_type == 1): ?>
                                    <span class="badge badge--primary"><?php echo e(__('Lifetime')); ?></span>
                                <?php elseif($plan->interest_return_type == 2): ?>
                                    <span class="badge badge--info"><?php echo e(__('Repeat')); ?></span>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Total Investments')); ?>">
                                <strong class="text--primary"><?php echo e($plan->investmentLogs->count()); ?></strong>
                                <?php if($plan->investmentLogs->sum('amount') > 0): ?>
                                    <br><small class="text-muted"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($plan->investmentLogs->sum('amount'), 2)); ?></small>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($plan->status == 1): ?>
                                    <span class="badge badge--success"><?php echo e(__('ACTIVE')); ?></span>
                                <?php else: ?>
                                    <span class="badge badge--danger"><?php echo e(__('INACTIVE')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <div class="d-flex gap-2">
                                    <a href="<?php echo e(route('admin.binary.edit', $plan->uid)); ?>" class="btn btn-sm btn-outline-primary">
                                        <?php echo e(__('Edit')); ?>

                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="10"><?php echo e(__('No investment plans found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php if($investmentPlans->hasPages()): ?>
            <div class="card-footer">
                <?php echo e($investmentPlans->appends(request()->all())->links()); ?>

            </div>
        <?php endif; ?>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/binary/index.blade.php ENDPATH**/ ?>