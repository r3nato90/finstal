<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('User Management')); ?></h3>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Users')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalUsers'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Active Users')); ?></h6>
                        <h4 class="text--success"><?php echo e(shortAmount($stats['activeUsers'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Verified Users')); ?></h6>
                        <h4 class="text--info"><?php echo e(shortAmount($stats['verifiedUsers'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('KYC Approved')); ?></h6>
                        <h4 class="text--warning"><?php echo e(shortAmount($stats['kycApprovedUsers'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.user.index')); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('Name, Email, UUID...')); ?>">
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
                                <label for="kyc_status"><?php echo e(__('KYC Status')); ?></label>
                                <select name="kyc_status" id="kyc_status" class="form-control">
                                    <option value=""><?php echo e(__('All KYC')); ?></option>
                                    <option value="1" <?php echo e(($filters['kyc_status'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Approved')); ?></option>
                                    <option value="0" <?php echo e(($filters['kyc_status'] ?? '') == '0' ? 'selected' : ''); ?>><?php echo e(__('Pending')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Joined')); ?></option>
                                    <option value="first_name" <?php echo e(($filters['sort_field'] ?? '') == 'first_name' ? 'selected' : ''); ?>><?php echo e(__('Name')); ?></option>
                                    <option value="email" <?php echo e(($filters['sort_field'] ?? '') == 'email' ? 'selected' : ''); ?>><?php echo e(__('Email')); ?></option>
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
                        <th><?php echo e(__('User')); ?></th>
                        <th><?php echo e(__('Email')); ?></th>
                        <th><?php echo e(__('Wallet')); ?></th>
                        <th><?php echo e(__('KYC Status')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Joined')); ?></th>
                        <th><?php echo e(__('Actions')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('User')); ?>">
                                <div class="user-info">
                                    <strong><?php echo e($user->full_name); ?></strong>
                                    <br><small class="text-muted">ID: <?php echo e($user->uuid); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Email')); ?>">
                                <span><?php echo e($user->email); ?></span>
                                <?php if($user->email_verified_at): ?>
                                    <br><span class="badge badge--success-transparent">Verified</span>
                                <?php else: ?>
                                    <br><span class="badge badge--warning-transparent">Unverified</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Wallet')); ?>">
                                <?php if($user->wallet): ?>
                                    <button class="btn btn--primary btn--sm wallets" data-id="<?php echo e(json_encode($user->wallet)); ?>">
                                        <?php echo e(__('View Wallet')); ?>

                                    </button>
                                <?php else: ?>
                                    <span class="text-muted">No Wallet</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('KYC Status')); ?>">
                                <?php if($user->kyc_status == 1): ?>
                                    <span class="badge badge--success">Approved</span>
                                <?php else: ?>
                                    <span class="badge badge--warning">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php if($user->status == 1): ?>
                                    <span class="badge badge--success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge--danger">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Joined')); ?>">
                                <div class="time-info">
                                    <strong><?php echo e($user->created_at->format('M d, Y')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($user->created_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Actions')); ?>">
                                <button class="btn btn--warning btn--sm created-update" data-id="<?php echo e($user->id); ?>">
                                    <?php echo e(__('Add/Subtract')); ?>

                                </button>
                                <a href="<?php echo e(route('admin.user.details', $user->id)); ?>" class="btn btn--primary btn--sm">
                                    <?php echo e(__('Details')); ?>

                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="7"><?php echo e(__('No users found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($users->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($users->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Add/Subtract Balance Modal -->
    <div class="modal fade" id="credit-add-return" tabindex="-1" aria-labelledby="credit-add-return" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Add/Subtract Balance')); ?></h5>
                </div>
                <form action="<?php echo e(route('admin.user.add-subtract.balance')); ?>" method="POST">
                    <?php echo method_field('PUT'); ?>
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="type" class="form-label"><?php echo e(__('Type')); ?> <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="type" id="type" required>
                                <?php $__currentLoopData = \App\Enums\Transaction\Type::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(\App\Enums\Transaction\Type::getName($status)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="wallet_type" class="form-label"><?php echo e(__('Select Wallet')); ?> <sup class="text--danger">*</sup></label>
                            <select class="form-select" name="wallet_type" id="wallet_type" required>
                                <?php $__currentLoopData = \App\Enums\Transaction\WalletType::toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status); ?>"><?php echo e(\App\Enums\Transaction\WalletType::getName($status)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="amount" class="form-label"><?php echo e(__('Amount')); ?> <sup class="text--danger">*</sup></label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="amount" name="amount"
                                       placeholder="Enter amount" aria-label="Amount" step="0.01" min="0.01">
                                <span class="input-group-text"><?php echo e(getCurrencyName()); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="d-flex align-items-center gap-3">
                            <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
                            <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('Save')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Wallet Details Modal -->
    <div class="modal fade" id="list-wallet" tabindex="-1" aria-labelledby="list-wallet" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('User Wallet Details')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="modal-pay-list"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn--danger btn--sm" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.created-update').on('click', function () {
                const modal = $('#credit-add-return');
                const id = $(this).data('id');
                modal.find('input[name=id]').val(id);
                modal.modal('show');
            });

            $('.wallets').on('click', function () {
                $('.modal-pay-list').empty();
                const modal = $('#list-wallet');
                const walletData = $(this).data('id');
                const currency = "<?php echo e(getCurrencySymbol()); ?>";
                const walletProperties = ['primary_balance', 'investment_balance', 'trade_balance', 'practice_balance'];

                walletProperties.forEach(property => {
                    const propertyName = property.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
                    const balanceValue = currency + parseFloat(walletData[property] || 0).toFixed(2);
                    const listItem = `<li>
                            <span>${propertyName}</span>
                            <span>${balanceValue}</span>
                          </li>`;

                    modal.find('.modal-pay-list').append(listItem);
                });

                modal.modal('show');
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/user/index.blade.php ENDPATH**/ ?>