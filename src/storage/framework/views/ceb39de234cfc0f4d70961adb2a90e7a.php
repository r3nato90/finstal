<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($userBalance, 2)); ?></h4>
                            <p class="card-info__text"><?php echo e(__('Account Balance')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title"><?php echo e($statistics['total_trades'] ?? 0); ?></h4>
                            <p class="card-info__text"><?php echo e(__('Total Trades')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title"><?php echo e(count($activeTrades)); ?></h4>
                            <p class="card-info__text"><?php echo e(__('Active Trades')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas <?php echo e(($statistics['total_profit'] ?? 0) >= 0 ? 'fa-arrow-up text--success' : 'fa-arrow-down text--danger'); ?>"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title <?php echo e(($statistics['total_profit'] ?? 0) >= 0 ? 'text--success' : 'text--danger'); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($statistics['total_profit'] ?? 0, 2)); ?>

                            </h4>
                            <p class="card-info__text"><?php echo e(__('Total P&L')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-lg-4">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Select Asset')); ?></h4>
                        <span class="badge badge--primary"><?php echo e(count($availableSymbols)); ?> <?php echo e(__('Available')); ?></span>
                    </div>
                    <div class="card-body">
                        <div class="search-box mb-3">
                            <input type="text" id="symbolSearch" class="form-control" placeholder="<?php echo e(__('Search symbols...')); ?>">
                        </div>
                        <div id="symbolsList" class="symbols-list" style="max-height: 400px; overflow-y: auto;">
                            <?php $__currentLoopData = $availableSymbols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $symbol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="symbol-item p-3 border rounded mb-2 cursor-pointer" data-symbol="<?php echo e(json_encode($symbol)); ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1 symbol-title text-white"><?php echo e(strtoupper($symbol['symbol'])); ?></h6>
                                            <span class="symbol-payout text-white"><?php echo e(__('Payout')); ?>: <?php echo e($symbol['payout_rate']); ?>%</span>
                                        </div>
                                        <div class="text-end">
                                            <div class="badge badge-success symbol-badge"><?php echo e($symbol['payout_rate']); ?>%</div>
                                            <div class="fs-12 symbol-amount text-white">$<?php echo e($symbol['min_amount']); ?> - $<?php echo e($symbol['max_amount']); ?></div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-lg-8">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Chart')); ?></h4>
                        <div class="d-flex align-items-center gap-2">
                            <span id="selectedSymbolName"><?php echo e(__('Select an asset to view chart')); ?></span>
                            <div id="marketStatus"></div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div id="tradingview_widget" style="height: 500px; background: #1a1a1a;">
                            <div class="d-flex align-items-center justify-content-center h-100">
                                <div class="text-center">
                                    <i class="fas fa-chart-area fs-48 text--muted mb-3"></i>
                                    <h5 class="text--muted"><?php echo e(__('Select an asset to view chart')); ?></h5>
                                    <p class="text--light"><?php echo e(__('Choose an asset from the left panel')); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3">
                <div class="i-card-sm mb-4">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Place Order')); ?></h4>
                    </div>
                    <div class="card-body">
                        <form id="tradeForm" method="POST" action="<?php echo e(route('user.trades.store')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="symbol" id="tradeSymbol">

                            <!-- Direction Selection -->
                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('Direction')); ?></label>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="direction" id="directionUp" value="up" autocomplete="off" checked>
                                        <label class="btn btn-outline-success up w-100 text-white" for="directionUp">
                                            <i class="fas fa-arrow-up"></i><br>
                                            <span class="fw-bold text-white"><?php echo e(__('CALL')); ?></span><br>
                                            <small class="text-white"><?php echo e(__('Price will rise')); ?></small>
                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <input type="radio" class="btn-check" name="direction" id="directionDown" value="down" autocomplete="off">
                                        <label class="btn btn-outline-danger down w-100" for="directionDown">
                                            <i class="fas fa-arrow-down"></i><br>
                                            <span class="fw-bold text-white"><?php echo e(__('PUT')); ?></span><br>
                                            <small class="text-white"><?php echo e(__('Price will fall')); ?></small>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('Investment Amount')); ?></label>
                                <div class="input-group">
                                    <span class="input-group-text"><?php echo e(getCurrencySymbol()); ?></span>
                                    <input type="number" class="form-control" name="amount" id="tradeAmount"
                                           step="0.01" min="1" max="10000" value="10" required>
                                </div>
                                <div class="d-flex justify-content-between fs-12 text--muted mt-1">
                                    <span id="minAmount" class="text-white"><?php echo e(__('Min')); ?>: <?php echo e(getCurrencySymbol()); ?>1</span>
                                    <span id="maxAmount" class="text-white"><?php echo e(__('Max')); ?>: <?php echo e(getCurrencySymbol()); ?>10000</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><?php echo e(__('Duration')); ?></label>
                                <select class="form-control" name="duration" id="tradeDuration" required>
                                    <option value=""><?php echo e(__('Select duration')); ?></option>
                                </select>
                            </div>

                            <div id="tradeSummary" class="border rounded p-3 mb-3" style="display: none;">
                                <h6 class="mb-2"><?php echo e(__('Trade Summary')); ?></h6>
                                <div class="d-flex justify-content-between fs-13">
                                    <span class="text-white"><?php echo e(__('Investment')); ?>:</span>
                                    <span id="summaryAmount" class="text-white"><?php echo e(getCurrencySymbol()); ?>0.00</span>
                                </div>
                                <div class="d-flex justify-content-between fs-13">
                                    <span class="text-white"><?php echo e(__('Payout Rate')); ?>:</span>
                                    <span id="summaryPayout" class="text--success">0%</span>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between fw-bold">
                                    <span class="text-white"><?php echo e(__('Potential Profit')); ?>:</span>
                                    <span id="summaryProfit" class="text--success"><?php echo e(getCurrencySymbol()); ?>0.00</span>
                                </div>
                            </div>

                            <button type="submit" id="submitTrade" class="i-btn btn--primary btn--sm w-100" disabled>
                                <i class="fas fa-chart-line"></i> <?php echo e(__('Place Trade')); ?>

                            </button>
                        </form>
                    </div>
                </div>

                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Active Trades')); ?></h4>
                        <span class="badge badge--warning"><?php echo e(count($activeTrades)); ?> <?php echo e(__('Active')); ?></span>
                    </div>
                    <div class="card-body">
                        <?php $__empty_1 = true; $__currentLoopData = $activeTrades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="active-trade-item border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1"><?php echo e($trade['symbol']); ?></h6>
                                        <span class="badge <?php echo e($trade['direction'] === 'up' ? 'badge--success' : 'badge--danger'); ?>">
                                            <?php echo e($trade['direction'] === 'up' ? __('CALL') : __('PUT')); ?>

                                        </span>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold">$<?php echo e(number_format($trade['amount'], 2)); ?></div>
                                        <small class="text--muted"><?php echo e($trade['time_remaining'] ?? __('Calculating...')); ?></small>
                                    </div>
                                </div>
                                <div class="progress mb-2" style="height: 4px;">
                                    <div class="progress-bar bg--primary progress-bar-animated" role="progressbar" style="width: 50%"></div>
                                </div>
                                <?php if(\Carbon\Carbon::now()->diffInSeconds(\Carbon\Carbon::parse($trade['open_time'])) <= 30): ?>
                                    <button class="i-btn btn--danger btn--sm cancel-trade-btn" data-trade-id="<?php echo e($trade['id']); ?>">
                                        <?php echo e(__('Cancel')); ?>

                                    </button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-4">
                                <i class="fas fa-clock fs-32 text--muted mb-3"></i>
                                <p class="text--muted"><?php echo e(__('No active trades')); ?></p>
                                <small class="text--light"><?php echo e(__('Place a trade to get started')); ?></small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelTradeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo e(__('Cancel Trade')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                        <?php echo e(__('Are you sure you want to cancel this trade? This action cannot be undone.')); ?>

                    </div>
                    <p><?php echo e(__('You can only cancel trades within 30 seconds of opening.')); ?></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Keep Trade')); ?></button>
                    <form id="cancelTradeForm" method="POST" style="display: inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-danger"><?php echo e(__('Yes, Cancel Trade')); ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script-file'); ?>
        <script src="https://s3.tradingview.com/tv.js"></script>
    <?php $__env->stopPush(); ?>
    <?php $__env->startPush('script-push'); ?>
        <script>
            let selectedSymbol = null;
            let tradingViewWidget = null;
            let userBalance = <?php echo e($userBalance); ?>;

            $(document).ready(function() {
                const symbolItems = $('.symbol-item');
                const searchInput = $('#symbolSearch');

                searchInput.on('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    symbolItems.each(function() {
                        const symbolData = JSON.parse($(this).attr('data-symbol'));
                        const visible = symbolData.symbol.toLowerCase().includes(searchTerm);
                        $(this).css('display', visible ? 'block' : 'none');
                    });
                });

                symbolItems.on('click', function() {
                    symbolItems.each(function() {
                        $(this).removeClass('border-primary bg-light');
                        const titleElement = $(this).find('.symbol-title');
                        const payoutSpan = $(this).find('.symbol-payout');
                        const amountDiv = $(this).find('.symbol-amount');
                        const badgeDiv = $(this).find('.symbol-badge');

                        if (titleElement.length) {
                            titleElement.css('color', 'white').attr('class', 'mb-1 symbol-title');
                        }
                        if (payoutSpan.length) {
                            payoutSpan.css('color', 'white').attr('class', 'symbol-payout');
                        }
                        if (amountDiv.length) {
                            amountDiv.css('color', 'white').attr('class', 'fs-12 symbol-amount');
                        }
                        if (badgeDiv.length) {
                            badgeDiv.css('color', 'white').attr('class', 'badge badge-success symbol-badge');
                        }
                    });

                    $(this).addClass('border-primary bg-light');
                    const titleElement = $(this).find('.symbol-title');
                    const payoutSpan = $(this).find('.symbol-payout');
                    const amountDiv = $(this).find('.symbol-amount');
                    const badgeDiv = $(this).find('.symbol-badge');

                    if (titleElement.length) {
                        titleElement.css('color', '#333').attr('class', 'mb-1 symbol-title');
                    }
                    if (payoutSpan.length) {
                        payoutSpan.css('color', '#333').attr('class', 'symbol-payout');
                    }
                    if (amountDiv.length) {
                        amountDiv.css('color', '#333').attr('class', 'fs-12 symbol-amount');
                    }
                    if (badgeDiv.length) {
                        badgeDiv.css('color', '#333').attr('class', 'badge badge-dark symbol-badge');
                    }

                    selectedSymbol = JSON.parse($(this).attr('data-symbol'));
                    selectSymbol(selectedSymbol);
                });

                $('.amount-btn').on('click', function() {
                    const percent = parseInt($(this).data('percent'));
                    if (selectedSymbol) {
                        const maxAmount = Math.min(selectedSymbol.max_amount, userBalance);
                        const amount = (maxAmount * percent) / 100;
                        const finalAmount = Math.max(selectedSymbol.min_amount, amount);
                        $('#tradeAmount').val(finalAmount.toFixed(2));
                        updateTradeSummary();
                    }
                });

                $('#tradeForm').on('submit', function(e) {
                    if (!selectedSymbol) {
                        e.preventDefault();
                        notify('error','<?php echo e(__("Please select an asset")); ?>');
                        return;
                    }

                    const amount = parseFloat($('#tradeAmount').val());
                    if (amount > userBalance) {
                        e.preventDefault();
                        notify('error','<?php echo e(__("Insufficient balance")); ?>');
                    }
                });

                $('.cancel-trade-btn').on('click', function() {
                    const tradeId = $(this).data('trade-id');
                    $('#cancelTradeForm').attr('action', `/user/trading/${tradeId}/cancel`);
                    $('#cancelTradeModal').modal('show');
                });

                setInterval(function() {
                    if ($('.active-trade-item').length > 0) {
                        location.reload();
                    }
                }, 30000);
            });

            function selectSymbol(symbol) {
                selectedSymbol = symbol;

                $('#tradeSymbol').val(symbol.symbol);
                $('#selectedSymbolName').text(symbol.symbol);
                const maxAmount = Math.min(symbol.max_amount, userBalance);
                $('#tradeAmount').attr('min', symbol.min_amount);
                $('#tradeAmount').attr('max', maxAmount);
                $('#minAmount').text(`<?php echo e(__('Min')); ?>: ${symbol.min_amount}`);
                $('#maxAmount').text(`<?php echo e(__('Max')); ?>: ${maxAmount}`);

                const durationSelect = $('#tradeDuration');
                durationSelect.html('<option value=""><?php echo e(__("Select duration")); ?></option>');
                if (symbol.durations) {
                    symbol.durations.forEach(function(duration) {
                        const option = $('<option></option>');
                        option.val(duration);
                        option.text(formatDuration(duration));
                        durationSelect.append(option);
                    });
                }

                $('#marketStatus').html('<span class="badge badge--success"><i class="fas fa-circle"></i> <?php echo e(__("Live")); ?></span>');
                $('#submitTrade').prop('disabled', false);
                initTradingView(symbol);
                updateTradeSummary();
            }

            function initTradingView(symbol) {
                const container = $('#tradingview_widget');
                container.html('');

                if (symbol.currency && symbol.currency.tradingview_symbol) {
                    tradingViewWidget = new TradingView.widget({
                        autosize: true,
                        symbol: symbol.currency.tradingview_symbol,
                        interval: "1",
                        timezone: "<?php echo e($serverTimezone ?? 'Asia/Dhaka'); ?>",
                        theme: "dark",
                        style: "1",
                        locale: "en",
                        toolbar_bg: "#1a1a1a",
                        enable_publishing: false,
                        hide_top_toolbar: false,
                        hide_legend: true,
                        save_image: false,
                        container_id: "tradingview_widget"
                    });
                } else {
                    container.html(`
                    <div class="d-flex align-items-center justify-content-center h-100">
                        <div class="text-center">
                            <i class="fas fa-chart-area fs-48 text--muted mb-3"></i>
                            <h5 class="text--muted">${symbol.symbol} <?php echo e(__('Chart')); ?></h5>
                            <p class="text--light"><?php echo e(__('Payout Rate')); ?>: ${symbol.payout_rate}%</p>
                        </div>
                    </div>
                `);
                }
            }

            function updateTradeSummary() {
                if (!selectedSymbol) return;

                const amount = parseFloat($('#tradeAmount').val()) || 0;
                const duration = $('#tradeDuration').val();

                if (amount > 0 && duration) {
                    $('#tradeSummary').show();
                    $('#summaryAmount').text(`$${amount.toFixed(2)}`);
                    $('#summaryPayout').text(`${selectedSymbol.payout_rate}%`);

                    const profit = (amount * selectedSymbol.payout_rate) / 100;
                    $('#summaryProfit').text(`$${profit.toFixed(2)}`);
                } else {
                    $('#tradeSummary').hide();
                }
            }

            function formatDuration(seconds) {
                if (seconds < 60) return `${seconds}s`;
                if (seconds < 3600) return `${Math.floor(seconds / 60)}m`;
                return `${Math.floor(seconds / 3600)}h`;
            }

            $('#tradeAmount').on('input', updateTradeSummary);
            $('#tradeDuration').on('change', updateTradeSummary);
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/trades/index.blade.php ENDPATH**/ ?>