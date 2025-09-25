<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__($setTitle)); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <?php $__currentLoopData = $withdrawMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $withdrawMethod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <div class="i-card-sm card--dark shadow-none">
                                        <div class="row justify-content-between align-items-center g-lg-2 g-1">
                                            <div class="col-12">
                                                <h5 class="title-sm border-bottom pb-3"><?php echo e(__($withdrawMethod->name)); ?></h5>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 text-end">
                                                <button class="i-btn btn--primary btn--lg capsuled cash-out-process"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#withdrawModal"
                                                        data-id="<?php echo e($withdrawMethod->id); ?>"
                                                        data-name="<?php echo e($withdrawMethod->name); ?>"
                                                        data-min_limit="<?php echo e(shortAmount($withdrawMethod->min_limit)); ?>"
                                                        data-max_limit="<?php echo e(shortAmount($withdrawMethod->max_limit)); ?>"
                                                ><?php echo e(__('Withdraw Now')); ?><i class="bi bi-box-arrow-up-right ms-2"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="filter-area">
                        <form action="<?php echo e(route('user.withdraw.index')); ?>" method="GET">
                            <div class="row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-1 g-3">
                                <div class="col">
                                    <input type="text"
                                           name="search"
                                           class="form-control"
                                           placeholder="<?php echo e(__('Search by Trx ID')); ?>"
                                           value="<?php echo e(request()->get('search')); ?>"
                                           maxlength="100">
                                </div>
                                <div class="col">
                                    <select class="form-select select2-js" name="status">
                                        <option value=""><?php echo e(__('All Status')); ?></option>
                                        <?php $__currentLoopData = App\Enums\Payment\Withdraw\Status::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if (! ($status->value == App\Enums\Payment\Withdraw\Status::INITIATED->value)): ?>
                                                <option value="<?php echo e($status->value); ?>"
                                                        <?php if($status->value == request()->status): ?> selected <?php endif; ?>>
                                                    <?php echo e($status->name); ?>

                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text"
                                           id="date"
                                           class="form-control datepicker-here"
                                           name="date"
                                           value="<?php echo e(request()->get('date')); ?>"
                                           data-range="true"
                                           data-multiple-dates-separator=" - "
                                           data-language="en"
                                           data-position="bottom right"
                                           autocomplete="off"
                                           placeholder="<?php echo e(__('Select Date Range')); ?>">
                                </div>
                                <div class="col">
                                    <button type="submit" class="i-btn btn--lg btn--primary w-100">
                                        <i class="bi bi-search me-2"></i><?php echo e(__('Search')); ?>

                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="row align-items-center gy-4 mb-3">
                            <div class="table-container">
                                <table id="withdrawTable" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col"><?php echo e(__('Initiated At')); ?></th>
                                        <th scope="col"><?php echo e(__('Trx ID')); ?></th>
                                        <th scope="col"><?php echo e(__('Gateway')); ?></th>
                                        <th scope="col"><?php echo e(__('Amount')); ?></th>
                                        <th scope="col"><?php echo e(__('Charge')); ?></th>
                                        <th scope="col"><?php echo e(__('Conversion Rate')); ?></th>
                                        <th scope="col"><?php echo e(__('Final Amount')); ?></th>
                                        <th scope="col"><?php echo e(__('Net Credit')); ?></th>
                                        <th scope="col"><?php echo e(__('Status')); ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $withdrawLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdrawLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td data-label="<?php echo e(__('Initiated At')); ?>">
                                                <?php echo e(showDateTime($withdrawLog->created_at)); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Trx ID')); ?>">
                                                <span class="text-white fw-bold"><?php echo e($withdrawLog->trx); ?></span>
                                            </td>
                                            <td data-label="<?php echo e(__('Gateway')); ?>">
                                                <?php echo e($withdrawLog?->withdrawMethod?->name ?? 'N/A'); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Amount')); ?>">
                                                <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdrawLog->amount)); ?></strong>
                                            </td>
                                            <td data-label="<?php echo e(__('Charge')); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdrawLog->charge)); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Conversion Rate')); ?>">
                                                <?php echo e(getCurrencySymbol()); ?>1 = <?php echo e(shortAmount($withdrawLog->rate)); ?> <?php echo e($withdrawLog?->currency); ?>

                                            </td>
                                            <td data-label="<?php echo e(__('Final Amount')); ?>">
                                                <strong><?php echo e(shortAmount($withdrawLog->final_amount)); ?> <?php echo e($withdrawLog?->currency); ?></strong>
                                            </td>
                                            <td data-label="<?php echo e(__('Net Credit')); ?>">
                                                <strong class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($withdrawLog->after_charge)); ?></strong>
                                            </td>
                                            <td data-label="<?php echo e(__('Status')); ?>">
                                                    <span class="i-badge <?php echo e(App\Enums\Payment\Withdraw\Status::getColor($withdrawLog->status)); ?>">
                                                        <?php echo e(App\Enums\Payment\Withdraw\Status::getName($withdrawLog->status)); ?>

                                                    </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td class="text-center text-muted" colspan="9">
                                                <div class="py-4">
                                                    <i class="bi bi-inbox display-4 text-muted"></i>
                                                    <p class="mt-2"><?php echo e(__('No withdrawal records found')); ?></p>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($withdrawLogs->hasPages()): ?>
                    <div class="mt-4"><?php echo e($withdrawLogs->links()); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Withdrawal Modal -->
    <div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg--dark">
                    <h5 class="modal-title" id="methodTitle"><?php echo e(__('Withdraw Request')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <?php if($module_withdraw_request == \App\Enums\Status::ACTIVE->value): ?>
                    <form method="POST" action="<?php echo e(route('user.withdraw.process')); ?>" id="withdrawForm">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="id" id="withdrawMethodId" value="">

                        <div class="modal-body">
                            <div class="alert alert-info">
                                <small>
                                    <i class="bi bi-info-circle me-1"></i>
                                    <span id="withdraw_limit"></span>
                                </small>
                            </div>

                            <div class="mb-3">
                                <label for="amount" class="form-label"><?php echo e(__('Withdrawal Amount')); ?></label>
                                <div class="input-group">
                                    <input type="number"
                                           class="form-control"
                                           id="amount"
                                           name="amount"
                                           placeholder="<?php echo e(__('Enter amount to withdraw')); ?>"
                                           step="0.01"
                                           min="0.01"
                                           required>
                                    <span class="input-group-text" id="currencyName"><?php echo e(getCurrencyName()); ?></span>
                                </div>
                                <div class="form-text text-white">
                                    <?php echo e(__('Available Balance: ')); ?>

                                    <span class="text-white"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(Auth::user()->wallet->primary_balance ?? 0)); ?></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center">
                                        <small class="text-white"><?php echo e(__('Processing Fee')); ?></small>
                                        <div class="fw-bold text-white" id="calculatedCharge"><?php echo e(getCurrencySymbol()); ?>0.00</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center">
                                        <small class="text-white"><?php echo e(__('You Will Receive')); ?></small>
                                        <div class="fw-bold text-white" id="netAmount"><?php echo e(getCurrencySymbol()); ?>0.00</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="i-btn btn--outline btn--sm" data-bs-dismiss="modal">
                                <?php echo e(__('Cancel')); ?>

                            </button>
                            <button type="submit" class="i-btn btn--primary btn--sm" id="submitBtn">
                                <i class="bi bi-check-circle me-1"></i><?php echo e(__('Proceed to Withdrawal')); ?>

                            </button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="modal-body text-center py-4">
                        <i class="bi bi-exclamation-triangle display-4 text-warning"></i>
                        <h5 class="mt-3"><?php echo e(__('Service Temporarily Unavailable')); ?></h5>
                        <p class="text-muted"><?php echo e(__('Withdrawal requests are currently disabled. Please try again later.')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";

        $(document).ready(function () {
            let currentMethod = null;

            // Handle withdrawal method selection
            $('.cash-out-process').click(function () {
                const name = $(this).data('name');
                const id = $(this).data('id');
                const minLimit = parseFloat($(this).data('min_limit')) || 0;
                const maxLimit = parseFloat($(this).data('max_limit')) || 999999;
                const currencySymbol = "<?php echo e(getCurrencySymbol()); ?>";

                // Store current method data
                currentMethod = {
                    id: id,
                    name: name,
                    minLimit: minLimit,
                    maxLimit: maxLimit,
                    fixedCharge: 0, // These should come from backend
                    percentCharge: 0 // These should come from backend
                };

                // Update modal content
                $('#withdrawMethodId').val(id);
                $('#methodTitle').text(`<?php echo e(__('Withdraw with')); ?> ${name}`);
                $('#withdraw_limit').text(`<?php echo e(__('Limit:')); ?> ${currencySymbol}${minLimit} - ${currencySymbol}${maxLimit}`);

                // Set input constraints
                $('#amount').attr('min', minLimit);
                $('#amount').attr('max', maxLimit);
                $('#amount').val('');

                // Reset calculations
                updateCalculations(0);
            });

            // Handle amount input changes
            $('#amount').on('input', function() {
                const amount = parseFloat($(this).val()) || 0;
                updateCalculations(amount);
                validateAmount(amount);
            });

            // Form validation before submit
            $('#withdrawForm').on('submit', function(e) {
                const amount = parseFloat($('#amount').val()) || 0;

                if (!validateAmount(amount)) {
                    e.preventDefault();
                    return false;
                }

                // Add loading state
                $('#submitBtn').prop('disabled', true).html('<i class="spinner-border spinner-border-sm me-1"></i><?php echo e(__("Processing...")); ?>');
            });

            function updateCalculations(amount) {
                if (!currentMethod || amount <= 0) {
                    $('#calculatedCharge').text("<?php echo e(getCurrencySymbol()); ?>0.00");
                    $('#netAmount').text("<?php echo e(getCurrencySymbol()); ?>0.00");
                    return;
                }

                // Calculate charges (these values should come from the backend)
                const charge = currentMethod.fixedCharge + (amount * currentMethod.percentCharge / 100);
                const netAmount = Math.max(0, amount - charge);

                $('#calculatedCharge').text("<?php echo e(getCurrencySymbol()); ?>" + charge.toFixed(2));
                $('#netAmount').text("<?php echo e(getCurrencySymbol()); ?>" + netAmount.toFixed(2));
            }

            function validateAmount(amount) {
                const amountInput = $('#amount');
                const submitBtn = $('#submitBtn');

                // Remove previous validation classes
                amountInput.removeClass('is-invalid is-valid');

                if (!currentMethod) {
                    return false;
                }

                // Check if amount is within limits
                if (amount < currentMethod.minLimit) {
                    amountInput.addClass('is-invalid');
                    showValidationError(`<?php echo e(__('Minimum amount is')); ?> <?php echo e(getCurrencySymbol()); ?>${currentMethod.minLimit}`);
                    submitBtn.prop('disabled', true);
                    return false;
                }

                if (amount > currentMethod.maxLimit) {
                    amountInput.addClass('is-invalid');
                    showValidationError(`<?php echo e(__('Maximum amount is')); ?> <?php echo e(getCurrencySymbol()); ?>${currentMethod.maxLimit}`);
                    submitBtn.prop('disabled', true);
                    return false;
                }

                // Check available balance
                const availableBalance = <?php echo e(Auth::user()->wallet->primary_balance ?? 0); ?>;
                if (amount > availableBalance) {
                    amountInput.addClass('is-invalid');
                    showValidationError('<?php echo e(__("Insufficient balance")); ?>');
                    submitBtn.prop('disabled', true);
                    return false;
                }

                // Valid amount
                amountInput.addClass('is-valid');
                hideValidationError();
                submitBtn.prop('disabled', false);
                return true;
            }

            function showValidationError(message) {
                let errorDiv = $('#amount').siblings('.invalid-feedback');
                if (errorDiv.length === 0) {
                    errorDiv = $('<div class="invalid-feedback"></div>');
                    $('#amount').after(errorDiv);
                }
                errorDiv.text(message);
            }

            function hideValidationError() {
                $('#amount').siblings('.invalid-feedback').remove();
            }

            // Reset modal when closed
            $('#withdrawModal').on('hidden.bs.modal', function () {
                $('#withdrawForm')[0].reset();
                $('#amount').removeClass('is-invalid is-valid');
                hideValidationError();
                $('#submitBtn').prop('disabled', false).html('<i class="bi bi-check-circle me-1"></i><?php echo e(__("Proceed to Withdrawal")); ?>');
                updateCalculations(0);
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/withdraw/index.blade.php ENDPATH**/ ?>