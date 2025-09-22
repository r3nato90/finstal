<?php use App\Enums\Matrix\PinStatus; ?>

<?php $__env->startSection('panel'); ?>
    <section>
        <div class="page-header">
            <h3 class="page-title"><?php echo e(__('Pin Management')); ?></h3>
            <div class="page-links">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#pinGenerateModal">
                    <i class="las la-plus"></i> <?php echo e(__('Generate Pin')); ?>

                </button>
            </div>
        </div>

        <div class="row mb-4 mt-3">
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Pins')); ?></h6>
                        <h4 class="text--dark"><?php echo e(shortAmount($stats['totalPins'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Unused')); ?></h6>
                        <h4 class="text--warning"><?php echo e(shortAmount($stats['unusedPins'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Used')); ?></h6>
                        <h4 class="text--success"><?php echo e(shortAmount($stats['usedPins'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Admin Pins')); ?></h6>
                        <h4 class="text--info"><?php echo e(shortAmount($stats['adminPins'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('User Pins')); ?></h6>
                        <h4 class="text--primary"><?php echo e(shortAmount($stats['userPins'])); ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card">
                    <div class="card-body">
                        <h6 class="text-muted"><?php echo e(__('Total Amount')); ?></h6>
                        <h4 class="text--dark"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalPinAmount'])); ?></h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Used Pin Amount')); ?></h6>
                        <h3 class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['usedPinAmount'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Unused Pin Amount')); ?></h6>
                        <h3 class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['unusedPinAmount'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Total Charges')); ?></h6>
                        <h3 class="text--info"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalCharges'])); ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="text-muted"><?php echo e(__('Net Pin Value')); ?></h6>
                        <h3 class="text--primary"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['totalPinAmount'] - $stats['totalCharges'])); ?></h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('admin.pin.index')); ?>">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="search"><?php echo e(__('Search')); ?></label>
                                <input type="text" name="search" id="search" class="form-control"
                                       value="<?php echo e($filters['search'] ?? ''); ?>"
                                       placeholder="<?php echo e(__('UID, Pin, User...')); ?>">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="status"><?php echo e(__('Status')); ?></label>
                                <select name="status" id="status" class="form-control">
                                    <option value=""><?php echo e(__('All Status')); ?></option>
                                    <option value="1" <?php echo e(($filters['status'] ?? '') == '1' ? 'selected' : ''); ?>><?php echo e(__('Unused')); ?></option>
                                    <option value="2" <?php echo e(($filters['status'] ?? '') == '2' ? 'selected' : ''); ?>><?php echo e(__('Used')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="pin_type"><?php echo e(__('Pin Type')); ?></label>
                                <select name="pin_type" id="pin_type" class="form-control">
                                    <option value=""><?php echo e(__('All Types')); ?></option>
                                    <option value="admin" <?php echo e(($filters['pin_type'] ?? '') == 'admin' ? 'selected' : ''); ?>><?php echo e(__('Admin Generated')); ?></option>
                                    <option value="user" <?php echo e(($filters['pin_type'] ?? '') == 'user' ? 'selected' : ''); ?>><?php echo e(__('User Generated')); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="set_user"><?php echo e(__('Set By User')); ?></label>
                                <select name="set_user" id="set_user" class="form-control">
                                    <option value=""><?php echo e(__('All Users')); ?></option>
                                    <?php $__currentLoopData = $setUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userId => $userName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($userId); ?>" <?php echo e(($filters['set_user'] ?? '') == $userId ? 'selected' : ''); ?>>
                                            <?php echo e($userName); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="sort_field"><?php echo e(__('Sort By')); ?></label>
                                <select name="sort_field" id="sort_field" class="form-control">
                                    <option value="created_at" <?php echo e(($filters['sort_field'] ?? 'created_at') == 'created_at' ? 'selected' : ''); ?>><?php echo e(__('Date Created')); ?></option>
                                    <option value="uid" <?php echo e(($filters['sort_field'] ?? '') == 'uid' ? 'selected' : ''); ?>><?php echo e(__('UID')); ?></option>
                                    <option value="pin_number" <?php echo e(($filters['sort_field'] ?? '') == 'pin_number' ? 'selected' : ''); ?>><?php echo e(__('Pin Number')); ?></option>
                                    <option value="amount" <?php echo e(($filters['sort_field'] ?? '') == 'amount' ? 'selected' : ''); ?>><?php echo e(__('Amount')); ?></option>
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
                        <th><?php echo e(__('Pin Number')); ?></th>
                        <th><?php echo e(__('Used By')); ?></th>
                        <th><?php echo e(__('Generated By')); ?></th>
                        <th><?php echo e(__('Amount')); ?></th>
                        <th><?php echo e(__('Charge')); ?></th>
                        <th><?php echo e(__('Net Amount')); ?></th>
                        <th><?php echo e(__('Status')); ?></th>
                        <th><?php echo e(__('Date')); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $pins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td data-label="<?php echo e(__('UID')); ?>">
                                <strong><?php echo e($pin->uid); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Pin Number')); ?>">
                                <div class="pin-number">
                                    <strong class="text--primary"><?php echo e($pin->pin_number); ?></strong>
                                    <button class="btn btn-sm btn-outline-secondary copy-btn"
                                            onclick="copyToClipboard('<?php echo e($pin->pin_number); ?>')"
                                            title="<?php echo e(__('Copy Pin')); ?>">
                                        <i class="las la-copy"></i>
                                    </button>
                                </div>
                            </td>
                            <td data-label="<?php echo e(__('Used By')); ?>">
                                <?php if($pin->user): ?>
                                    <div class="user-info">
                                        <strong><?php echo e($pin->user->fullname ?? $pin->user->username); ?></strong>
                                        <br><small class="text-muted"><?php echo e($pin->user->email); ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="text-muted"><?php echo e(__('Not Used')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Generated By')); ?>">
                                <?php if($pin->setUser): ?>
                                    <div class="user-info">
                                        <strong><?php echo e($pin->setUser->fullname ?? $pin->setUser->username); ?></strong>
                                        <br><small class="text-muted"><?php echo e($pin->setUser->email); ?></small>
                                    </div>
                                <?php else: ?>
                                    <span class="badge badge--info"><?php echo e(__('Admin')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Amount')); ?>">
                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($pin->amount, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Charge')); ?>">
                                <span class="text--warning"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($pin->charge, 2)); ?></span>
                            </td>
                            <td data-label="<?php echo e(__('Net Amount')); ?>">
                                <strong class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($pin->amount - $pin->charge, 2)); ?></strong>
                            </td>
                            <td data-label="<?php echo e(__('Status')); ?>">
                                <?php
                                    $statusClass = PinStatus::getColor($pin->status);
                                    $statusText = PinStatus::getName($pin->status);
                                ?>
                                <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($statusText)); ?></span>
                                <?php if($pin->setUser): ?>
                                    <br><span class="mt-1 badge badge--primary-transparent">User Generated</span>
                                <?php else: ?>
                                    <br><span class="mt-1 badge badge--info-transparent">Admin Generated</span>
                                <?php endif; ?>
                            </td>
                            <td data-label="<?php echo e(__('Date')); ?>">
                                <div class="time-info">
                                    <strong><?php echo e($pin->created_at->format('M d, H:i')); ?></strong>
                                    <br><small class="text-muted"><?php echo e($pin->created_at->diffForHumans()); ?></small>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td class="text-muted text-center" colspan="10"><?php echo e(__('No pins found')); ?></td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($pins->hasPages()): ?>
                <div class="card-footer">
                    <?php echo e($pins->appends(request()->all())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Pin Generate Modal -->
    <div class="modal fade" id="pinGenerateModal" tabindex="-1" role="dialog" aria-labelledby="pinGenerateModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinGenerateModalLabel"><?php echo e(__('admin.pin.content.generated')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('admin.pin.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label" for="amount"><?php echo e(__('admin.input.amount')); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="amount" id="amount" class="form-control" placeholder="<?php echo e(__('admin.placeholder.amount')); ?>" required>
                            </div>
                            <div class="col-lg-12">
                                <label class="form-label" for="number"><?php echo e(__('admin.input.number')); ?> <sup class="text-danger">*</sup></label>
                                <input type="text" name="number" id="number" class="form-control" placeholder="<?php echo e(__('admin.placeholder.number')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn--outline btn--sm" data-bs-dismiss="modal"><?php echo e(__('admin.button.close')); ?></button>
                        <button type="submit" class="btn btn--primary btn--sm"><?php echo e(__('admin.button.save')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                console.log('Copied to clipboard: ' + text);
                showToast('Pin copied to clipboard!');
            }).catch(function(err) {
                // Fallback for older browsers
                const textArea = document.createElement('textarea');
                textArea.value = text;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                showToast('Pin copied to clipboard!');
            });
        }

        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'alert alert-success';
            toast.style.position = 'fixed';
            toast.style.top = '20px';
            toast.style.right = '20px';
            toast.style.zIndex = '9999';
            toast.innerHTML = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

        $(document).ready(function () {
            $('.reference-copy').click(function() {
                const copyText = $(this).data('pin');
                copyToClipboard(copyText);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-push'); ?>
    <style>
        .pin-number {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .copy-btn {
            padding: 2px 6px;
            font-size: 12px;
            color: black;
        }

        .user-info {
            max-width: 150px;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/admin/pin/index.blade.php ENDPATH**/ ?>