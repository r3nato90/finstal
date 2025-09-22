<?php $__env->startSection('content'); ?>
    <div class="main-content" data-simplebar>
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title"><?php echo e($stats['total_trades'] ?? 0); ?></h4>
                            <p class="card-info__text"><?php echo e(__('Total Trades')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title text--success"><?php echo e($stats['win_rate'] ?? 0); ?>%</h4>
                            <p class="card-info__text"><?php echo e(__('Win Rate')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas <?php echo e(($stats['total_profit'] ?? 0) >= 0 ? 'fa-arrow-up text--success' : 'fa-arrow-down text--danger'); ?>"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title <?php echo e(($stats['total_profit'] ?? 0) >= 0 ? 'text--success' : 'text--danger'); ?>">
                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_profit'] ?? 0, 2)); ?>

                            </h4>
                            <p class="card-info__text"><?php echo e(__('Total P&L')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-sm-6">
                <div class="i-card-sm">
                    <div class="card-info">
                        <div class="card-info__icon">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="card-info__content">
                            <h4 class="card-info__title"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($stats['total_volume'] ?? 0, 2)); ?></h4>
                            <p class="card-info__text"><?php echo e(__('Total Volume')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <div class="i-card-sm">
                    <div class="card-header">
                        <h4 class="title"><?php echo e(__('Filters')); ?></h4>
                        <button class="i-btn btn--success btn--sm" onclick="location.reload()" title="<?php echo e(__('Refresh')); ?>">
                            <i class="fas fa-sync-alt"></i> <?php echo e(__('Refresh')); ?>

                        </button>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('user.trades.history')); ?>">
                            <div class="row g-3">
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('Search')); ?></label>
                                    <input type="text" name="search" class="form-control"
                                           placeholder="<?php echo e(__('Trade ID, Symbol...')); ?>"
                                           value="<?php echo e($filters['search'] ?? ''); ?>">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('Symbol')); ?></label>
                                    <select name="symbol" class="form-select">
                                        <option value=""><?php echo e(__('All Symbols')); ?></option>
                                        <?php $__currentLoopData = $symbols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $symbol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($symbol); ?>" <?php echo e(($filters['symbol'] ?? '') == $symbol ? 'selected' : ''); ?>>
                                                <?php echo e($symbol); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('Direction')); ?></label>
                                    <select name="direction" class="form-select">
                                        <option value=""><?php echo e(__('All Directions')); ?></option>
                                        <option value="up" <?php echo e(($filters['direction'] ?? '') == 'up' ? 'selected' : ''); ?>><?php echo e(__('Call')); ?></option>
                                        <option value="down" <?php echo e(($filters['direction'] ?? '') == 'down' ? 'selected' : ''); ?>><?php echo e(__('Put')); ?></option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('Status')); ?></label>
                                    <select name="status" class="form-select">
                                        <option value=""><?php echo e(__('All Statuses')); ?></option>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php echo e(($filters['status'] ?? '') == $status ? 'selected' : ''); ?>>
                                                <?php echo e(ucfirst($status)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('Start Date')); ?></label>
                                    <input type="date" name="start_date" class="form-control"
                                           value="<?php echo e($filters['start_date'] ?? ''); ?>">
                                </div>
                                <div class="col-lg-2 col-md-4 col-sm-6">
                                    <label class="form-label"><?php echo e(__('End Date')); ?></label>
                                    <input type="date" name="end_date" class="form-control"
                                           value="<?php echo e($filters['end_date'] ?? ''); ?>">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="i-btn btn--primary btn--sm">
                                        <i class="fas fa-filter"></i> <?php echo e(__('Apply Filters')); ?>

                                    </button>
                                    <a href="<?php echo e(route('user.trades.history')); ?>" class="i-btn btn--dark btn--sm">
                                        <i class="fas fa-times"></i> <?php echo e(__('Clear')); ?>

                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="i-card-sm mb-4">
                    <div class="table-container">
                        <table id="tradesTable" class="table">
                            <thead>
                            <tr>
                                <th scope="col"><?php echo e(__('Trade ID')); ?></th>
                                <th scope="col"><?php echo e(__('Symbol')); ?></th>
                                <th scope="col"><?php echo e(__('Direction')); ?></th>
                                <th scope="col"><?php echo e(__('Amount')); ?></th>
                                <th scope="col"><?php echo e(__('Payout Rate')); ?></th>
                                <th scope="col"><?php echo e(__('Status')); ?></th>
                                <th scope="col"><?php echo e(__('P&L')); ?></th>
                                <th scope="col"><?php echo e(__('Date')); ?></th>
                                <th scope="col"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $trades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td data-label="<?php echo e(__('Trade ID')); ?>">
                                        <span class="fs-13 fw-bold font-monospace"><?php echo e($trade->trade_id); ?></span>
                                    </td>
                                    <td data-label="<?php echo e(__('Symbol')); ?>">
                                        <span class="fw-bold"><?php echo e($trade->symbol); ?></span>
                                    </td>
                                    <td data-label="<?php echo e(__('Direction')); ?>">
                                        <span class="badge <?php echo e($trade->direction === 'up' ? 'badge--success' : 'badge--danger'); ?>">
                                            <i class="fas <?php echo e($trade->direction === 'up' ? 'fa-arrow-up' : 'fa-arrow-down'); ?>"></i>
                                            <?php echo e($trade->direction === 'up' ? __('CALL') : __('PUT')); ?>

                                        </span>
                                    </td>
                                    <td data-label="<?php echo e(__('Amount')); ?>">
                                        <span class="fw-bold"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->amount)); ?></span>
                                    </td>
                                    <td data-label="<?php echo e(__('Payout Rate')); ?>">
                                        <span class="text--success fw-bold"><?php echo e($trade->payout_rate); ?>%</span>
                                    </td>
                                    <td data-label="<?php echo e(__('Status')); ?>">
                                        <?php
                                            $statusClass = match($trade->status) {
                                                'won' => 'badge--success',
                                                'lost' => 'badge--danger',
                                                'active' => 'badge--primary',
                                                'cancelled' => 'badge--secondary',
                                                'expired' => 'badge--warning',
                                                default => 'badge--secondary'
                                            };
                                        ?>
                                        <span class="i-badge <?php echo e($statusClass); ?>">
                                            <?php echo e(ucfirst($trade->status)); ?>

                                        </span>
                                    </td>
                                    <td data-label="<?php echo e(__('P&L')); ?>">
                                        <?php
                                            $profitLoss = $trade->profit_loss ?? 0;
                                            $textClass = $profitLoss > 0 ? 'text--success' : ($profitLoss < 0 ? 'text--danger' : 'text--muted');
                                            $prefix = $profitLoss > 0 ? '+' : '';
                                        ?>
                                        <span class="fw-bold <?php echo e($textClass); ?>">
                                            <?php echo e($prefix); ?><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount(abs($profitLoss))); ?>

                                        </span>
                                    </td>
                                    <td data-label="<?php echo e(__('Date')); ?>">
                                        <div><?php echo e($trade->open_time->format('M d, Y')); ?></div>
                                        <small class="text--muted"><?php echo e($trade->open_time->format('H:i:s')); ?></small>
                                    </td>
                                    <td data-label="<?php echo e(__('Action')); ?>">
                                        <div class="d-flex gap-2">
                                            <button class="i-btn btn--primary btn--sm view-trade-details"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#tradeDetailsModal"
                                                    data-trade-id="<?php echo e($trade->id); ?>"
                                                    data-trade-ref="<?php echo e($trade->trade_id); ?>"
                                                    data-symbol="<?php echo e($trade->symbol); ?>"
                                                    data-direction="<?php echo e($trade->direction); ?>"
                                                    data-amount="<?php echo e($trade->amount); ?>"
                                                    data-duration="<?php echo e($trade->duration_seconds); ?>"
                                                    data-duration-formatted="<?php echo e($trade->duration_formatted); ?>"
                                                    data-payout-rate="<?php echo e($trade->payout_rate); ?>"
                                                    data-open-price="<?php echo e($trade->open_price); ?>"
                                                    data-close-price="<?php echo e($trade->close_price ?? ''); ?>"
                                                    data-status="<?php echo e($trade->status); ?>"
                                                    data-profit-loss="<?php echo e($trade->profit_loss ?? 0); ?>"
                                                    data-open-time="<?php echo e($trade->open_time->toISOString()); ?>"
                                                    data-close-time="<?php echo e($trade->close_time ? $trade->close_time->toISOString() : ''); ?>"
                                                    data-expiry-time="<?php echo e($trade->expiry_time ? $trade->expiry_time->toISOString() : ''); ?>"
                                                    title="<?php echo e(__('View Details')); ?>">
                                                <i class="fas fa-eye"></i> <?php echo e(__('Details')); ?>

                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center py-5">
                                        <div class="empty-state">
                                            <i class="fas fa-chart-line fs-48 text--muted mb-3"></i>
                                            <h5 class="text--muted"><?php echo e(__('No Trades Found')); ?></h5>
                                            <p class="text--light"><?php echo e(__('You haven\'t placed any trades yet')); ?></p>
                                            <a href="<?php echo e(route('user.trades.index')); ?>" class="i-btn btn--primary btn--sm">
                                                <i class="fas fa-plus"></i> <?php echo e(__('Start Trading')); ?>

                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if($trades->hasPages()): ?>
                        <div class="mt-4">
                            <?php echo e($trades->appends(request()->query())->links()); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Trade Details Modal -->
    <div class="modal fade" id="tradeDetailsModal" tabindex="-1" aria-labelledby="tradeDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tradeDetailsModalLabel"><?php echo e(__('Trade Details')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body bg--dark">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Trade ID')); ?></p>
                                <h6 class="title-sm mb-0" id="modalTradeId">#</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Symbol')); ?></p>
                                <h6 class="title-sm mb-0" id="modalSymbol">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Direction')); ?></p>
                                <h6 class="title-sm mb-0" id="modalDirection">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Investment Amount')); ?></p>
                                <h6 class="title-sm mb-0" id="modalAmount"><?php echo e(getCurrencySymbol()); ?>0.00</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Open Price')); ?></p>
                                <h6 class="title-sm mb-0" id="modalOpenPrice"><?php echo e(getCurrencySymbol()); ?>0.00</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Close Price')); ?></p>
                                <h6 class="title-sm mb-0" id="modalClosePrice">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Payout Rate')); ?></p>
                                <h6 class="title-sm mb-0" id="modalPayoutRate">0%</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Duration')); ?></p>
                                <h6 class="title-sm mb-0" id="modalDuration">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Open Time')); ?></p>
                                <h6 class="title-sm mb-0" id="modalOpenTime">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Close Time')); ?></p>
                                <h6 class="title-sm mb-0" id="modalCloseTime">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Status')); ?></p>
                                <h6 class="title-sm mb-0" id="modalStatus">-</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="i-card-sm p-3 shadow-none">
                                <p class="fs-15 mb-1"><?php echo e(__('Profit/Loss')); ?></p>
                                <h6 class="title-sm mb-0" id="modalProfitLoss"><?php echo e(getCurrencySymbol()); ?>0.00</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="i-btn btn--danger btn--sm" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <div id="modalTradeActions">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('script-push'); ?>
        <script>
            "use strict";
            $(document).ready(function() {
                $('.view-trade-details').on('click', function() {
                    const button = $(this);

                    const tradeId = button.data('trade-id');
                    const tradeRef = button.data('trade-ref');
                    const symbol = button.data('symbol');
                    const direction = button.data('direction');
                    const amount = button.data('amount');
                    const duration = button.data('duration');
                    const durationFormatted = button.data('duration-formatted');
                    const payoutRate = button.data('payout-rate');
                    const openPrice = button.data('open-price');
                    const closePrice = button.data('close-price');
                    const status = button.data('status');
                    const profitLoss = button.data('profit-loss');
                    const openTime = button.data('open-time');
                    const closeTime = button.data('close-time');
                    const expiryTime = button.data('expiry-time');

                    $('#modalTradeId').text('#' + tradeRef);
                    $('#modalSymbol').text(symbol);

                    const directionBadge = direction === 'up'
                        ? '<span class="badge badge--success"><i class="fas fa-arrow-up"></i> <?php echo e(__("CALL")); ?></span>'
                        : '<span class="badge badge--danger"><i class="fas fa-arrow-down"></i> <?php echo e(__("PUT")); ?></span>';
                    $('#modalDirection').html(directionBadge);

                    $('#modalAmount').text('<?php echo e(getCurrencySymbol()); ?>' + parseFloat(amount).toFixed(2));
                    $('#modalOpenPrice').text('$' + parseFloat(openPrice).toFixed(8));
                    $('#modalClosePrice').text(closePrice ? '$' + parseFloat(closePrice).toFixed(8) : '<?php echo e(__("Not Available")); ?>');
                    $('#modalPayoutRate').text(payoutRate + '%');
                    $('#modalDuration').text(durationFormatted || formatDuration(duration));

                    if (openTime) {
                        const openDate = new Date(openTime);
                        $('#modalOpenTime').html('<div>' + openDate.toLocaleDateString() + '</div><small class="text--muted">' + openDate.toLocaleTimeString() + '</small>');
                    }

                    if (closeTime) {
                        const closeDate = new Date(closeTime);
                        $('#modalCloseTime').html('<div>' + closeDate.toLocaleDateString() + '</div><small class="text--muted">' + closeDate.toLocaleTimeString() + '</small>');
                    } else {
                        $('#modalCloseTime').text('<?php echo e(__("Not Available")); ?>');
                    }

                    const statusBadge = getStatusBadge(status);
                    $('#modalStatus').html(statusBadge);

                    const profitLossValue = parseFloat(profitLoss);
                    const profitLossClass = profitLossValue > 0 ? 'text--success' : (profitLossValue < 0 ? 'text--danger' : 'text--muted');
                    const profitLossPrefix = profitLossValue > 0 ? '+' : '';
                    $('#modalProfitLoss').html('<span class="' + profitLossClass + '">' + profitLossPrefix + '$' + Math.abs(profitLossValue).toFixed(2) + '</span>');

                    // Handle action buttons
                    $('#modalTradeActions').html('');
                    if (status === 'active') {
                        const openDate = new Date(openTime);
                        const timeSinceOpen = (Date.now() - openDate.getTime()) / 1000;

                        if (timeSinceOpen <= 30) {
                            $('#modalTradeActions').html(`
                                <form method="POST" action="<?php echo e(route('user.trades.cancel', '')); ?>/${tradeId}" style="display: inline;">
                                    <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('<?php echo e(__('Are you sure you want to cancel this trade?')); ?>')">
                                        <i class="fas fa-times"></i> <?php echo e(__('Cancel Trade')); ?>

                            </button>
                        </form>
`);
                        }
                    }
                });

                const hasActiveTrades = $('.badge--primary').length > 0;
                if (hasActiveTrades) {
                    setInterval(function() {
                        if (!document.hidden) {
                            location.reload();
                        }
                    }, 30000);
                }
            });

            function getStatusBadge(status) {
                const statusClasses = {
                    'won': 'badge--success',
                    'lost': 'badge--danger',
                    'active': 'badge--primary',
                    'cancelled': 'badge--secondary',
                    'expired': 'badge--warning'
                };

                const badgeClass = statusClasses[status] || 'badge--secondary';
                const statusText = status.charAt(0).toUpperCase() + status.slice(1);

                return `<span class="badge ${badgeClass}">${statusText}</span>`;
            }

            function formatDuration(seconds) {
                seconds = parseInt(seconds);
                if (seconds < 60) return seconds + 's';
                if (seconds < 3600) return Math.floor(seconds / 60) + 'm';
                return Math.floor(seconds / 3600) + 'h';
            }
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/finfunder/src/resources/views/user/trades/history.blade.php ENDPATH**/ ?>