<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo e($setTitle); ?></h4>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <form action="<?php echo e(route('admin.ico.token.store')); ?>" method="POST" enctype="multipart/form-data" id="tokenForm">
                                <?php echo csrf_field(); ?>

                                <!-- Basic Information Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5><?php echo app('translator')->get('Basic Information'); ?></h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="name"><?php echo app('translator')->get('Token Name'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="text" name="name" id="name" value="<?php echo e(old('name')); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Enter Name'); ?>" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="symbol"><?php echo app('translator')->get('Symbol'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="text" name="symbol" id="symbol" value="<?php echo e(old('symbol')); ?>" class="form-control" placeholder="<?php echo app('translator')->get('Enter Symbol'); ?>" required>
                                        </div>
                                    </div>

                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-12">
                                            <label class="form-label" for="description"><?php echo app('translator')->get('Description'); ?></label>
                                            <textarea name="description" id="description" class="form-control" rows="4" placeholder="<?php echo app('translator')->get('Enter token description'); ?>"><?php echo e(old('description')); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Token Economics Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5><?php echo app('translator')->get('Token Economics'); ?></h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="price"><?php echo app('translator')->get('Initial Price'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="text" name="price" id="price" value="<?php echo e(old('price')); ?>" class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter Initial Price'); ?>" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="current_price"><?php echo app('translator')->get('Current Price'); ?></label>
                                            <input type="text" name="current_price" id="current_price" value="<?php echo e(old('current_price', 0)); ?>" class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter Current Price'); ?>">
                                        </div>


                                    </div>

                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="total_supply"><?php echo app('translator')->get('Total Supply'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="text" name="total_supply" id="total_supply" value="<?php echo e(old('total_supply')); ?>" class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter Total Supply'); ?>" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="tokens_sold"><?php echo app('translator')->get('Tokens Sold'); ?></label>
                                            <input type="number" name="tokens_sold" id="tokens_sold" value="<?php echo e(old('tokens_sold', 0)); ?>" class="form-control"
                                                   placeholder="<?php echo app('translator')->get('Enter Tokens Sold'); ?>" min="0">
                                        </div>

                                    </div>
                                </div>

                                <!-- Sale Period Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5><?php echo app('translator')->get('Sale Period'); ?></h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="sale_start_date"><?php echo app('translator')->get('Sale Start Date'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="date" name="sale_start_date" id="sale_start_date" value="<?php echo e(old('sale_start_date')); ?>" class="form-control" required>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label" for="sale_end_date"><?php echo app('translator')->get('Sale End Date'); ?> <sup class="text-danger">*</sup></label>
                                            <input type="date" name="sale_end_date" id="sale_end_date" value="<?php echo e(old('sale_end_date')); ?>" class="form-control" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Settings Section -->
                                <div class="shadow-md border p-3 bg-body rounded mb-3">
                                    <h5><?php echo app('translator')->get('Settings'); ?></h5>
                                    <hr>
                                    <div class="row g-4 mb-3">
                                        <div class="col-lg-6">
                                            <label class="form-label" for="status"><?php echo app('translator')->get('Status'); ?> <sup class="text-danger">*</sup></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="active" <?php echo e(old('status') == 'active' ? 'selected' : ''); ?>><?php echo app('translator')->get('Active'); ?></option>
                                                <option value="paused" <?php echo e(old('status') == 'paused' ? 'selected' : ''); ?>><?php echo app('translator')->get('Paused'); ?></option>
                                                <option value="completed" <?php echo e(old('status') == 'completed' ? 'selected' : ''); ?>><?php echo app('translator')->get('Completed'); ?></option>
                                                <option value="cancelled" <?php echo e(old('status') == 'cancelled' ? 'selected' : ''); ?>><?php echo app('translator')->get('Cancelled'); ?></option>
                                            </select>
                                        </div>

                                        <div class="col-lg-6">
                                            <label class="form-label">&nbsp;</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                                                <label class="form-check-label" for="is_featured">
                                                    <?php echo app('translator')->get('Featured Token'); ?>
                                                </label>
                                                <small class="form-text text-muted"><?php echo app('translator')->get('Display prominently on homepage'); ?></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="i-btn btn--primary btn--lg"><?php echo app('translator')->get('Submit'); ?></button>
                            </form>
                        </div>

                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="preview-section bg-light p-3 rounded">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-primary mb-0"><?php echo app('translator')->get('Token Preview'); ?></h6>
                                            <button type="button" class="btn btn-dark btn-sm"><?php echo app('translator')->get('Create ICO Token'); ?></button>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary"><?php echo app('translator')->get('Token Name'); ?>:</span>
                                            <span id="preview-name" class="text-primary fw-bold">-</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary"><?php echo app('translator')->get('Symbol'); ?>:</span>
                                            <span id="preview-symbol" class="text-primary fw-bold">-</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary"><?php echo app('translator')->get('Total Supply'); ?>:</span>
                                            <span id="preview-supply" class="text-primary fw-bold">-</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary"><?php echo app('translator')->get('Price per Token'); ?>:</span>
                                            <span id="preview-price" class="text-primary fw-bold">-</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between mb-2">
                                            <span class="text-primary"><?php echo app('translator')->get('Current Price'); ?>:</span>
                                            <span id="preview-current-price" class="text-primary fw-bold">$0</span>
                                        </div>

                                        <div class="preview-item d-flex justify-content-between">
                                            <span class="text-primary"><?php echo app('translator')->get('Maximum Possible Raise'); ?>:</span>
                                            <span id="preview-max-raise" class="text-primary fw-bold">$0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            function updatePreview() {
                var name = $('#name').val() || '-';
                var symbol = $('#symbol').val() || '-';
                var totalSupply = $('#total_supply').val() || '0';
                var price = $('#price').val() || '0';
                var currentPrice = $('#current_price').val() || '0';

                $('#preview-name').text(name);
                $('#preview-symbol').text(symbol);
                $('#preview-supply').text(totalSupply ? totalSupply + ' tokens' : '-');
                $('#preview-price').text(price ? '$' + price : '-');
                $('#preview-current-price').text(currentPrice ? '$' + currentPrice : '$0');

                if (totalSupply && price) {
                    var maxRaise = parseFloat(totalSupply) * parseFloat(price);
                    $('#preview-max-raise').text('$' + maxRaise.toLocaleString());
                } else {
                    $('#preview-max-raise').text('$0');
                }
            }

            $('#name, #symbol, #total_supply, #price, #current_price').on('keyup input', function() {
                updatePreview();
            });

            $('#sale_start_date').on('change', function() {
                var startDate = $(this).val();
                $('#sale_end_date').attr('min', startDate);

                var endDate = $('#sale_end_date').val();
                if (endDate && endDate < startDate) {
                    $('#sale_end_date').val('');
                }
            });

            $('#sale_end_date').on('change', function() {
                var endDate = $(this).val();
                var startDate = $('#sale_start_date').val();

                if (startDate && endDate < startDate) {
                    alert('<?php echo app('translator')->get("End date cannot be earlier than start date"); ?>');
                    $(this).val('');
                }
            });

            updatePreview();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/ico/tokens/create.blade.php ENDPATH**/ ?>