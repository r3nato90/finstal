<?php $__env->startSection('panel'); ?>
    <section>
        <div class="container-fluid px-0">
            <div class="row g-4 mb-4">
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                            <i class="las la-chart-line text--primary fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 fs-14">Total Trades</p>
                                            <h4 class="mb-0 text--dark"><?php echo e(shortAmount($trade->total)); ?></h4>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between text--muted small">
                                        <span>Completed: <?php echo e(shortAmount($trade->completed_trades)); ?></span>
                                        <span class="text-warning">Active: <?php echo e(shortAmount($trade->active)); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm rounded-circle bg--success bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                            <i class="las la-trophy text--success fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 fs-14">Win Rate</p>
                                            <h4 class="mb-0 text--success"><?php echo e($trade->win_rate); ?>%</h4>
                                        </div>
                                    </div>
                                    <div class="progress progress-sm">
                                        <div class="progress-bar bg--success" style="width: <?php echo e(min($trade->win_rate, 100)); ?>%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                            <i class="las la-wallet text--info fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 fs-14">Total Volume</p>
                                            <h4 class="mb-0 text--info"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->total_invested)); ?></h4>
                                        </div>
                                    </div>
                                    <small class="text-white">Avg: <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->average)); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm h-100 card-hover">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar-sm rounded-circle <?php echo e($trade->net_profit_loss >= 0 ? 'bg-success' : 'bg-danger'); ?> bg-opacity-10 d-flex align-items-center justify-content-center me-3">
                                            <i class="las <?php echo e($trade->net_profit_loss >= 0 ? 'la-arrow-up' : 'la-arrow-down'); ?> <?php echo e($trade->net_profit_loss >= 0 ? 'text--success' : 'text--danger'); ?> fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted mb-0 fs-14">Net P&L</p>
                                            <h4 class="mb-0 <?php echo e($trade->net_profit_loss >= 0 ? 'text--success' : 'text--danger'); ?>">
                                                <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->net_profit_loss)); ?>

                                            </h4>
                                        </div>
                                    </div>
                                    <small class="text-muted">Margin: <?php echo e($trade->profit_margin); ?>%</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom-0 pb-0">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title mb-0">Daily Trading Volume</h5>
                                <div class="d-flex gap-2">
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Last 30 Days
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="#">Last 7 Days</a></li>
                                            <li><a class="dropdown-item" href="#">Last 30 Days</a></li>
                                            <li><a class="dropdown-item" href="#">Last 90 Days</a></li>
                                        </ul>
                                    </div>
                                    <button class="btn btn-outline-primary btn-sm" id="refreshChart">
                                        <i class="las la-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="totalTrade" class="charts-height"></div>
                        </div>
                    </div>
                </div>

                <!-- Enhanced Quick Stats -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="card-title mb-0">Quick Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column gap-3">
                                <div class="stats-item p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted fs-14">Today's Volume</h6>
                                            <h5 class="mb-0 mt-1"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->today)); ?></h5>
                                        </div>
                                        <i class="las la-calendar-day text-primary fs-3"></i>
                                    </div>
                                </div>

                                <div class="stats-item p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted fs-14">This Week</h6>
                                            <h5 class="mb-0 mt-1"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->week)); ?></h5>
                                        </div>
                                        <i class="las la-calendar-week text-info fs-3"></i>
                                    </div>
                                </div>

                                <div class="stats-item p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted fs-14">This Month</h6>
                                            <h5 class="mb-0 mt-1"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->month)); ?></h5>
                                        </div>
                                        <i class="las la-calendar-alt text-success fs-3"></i>
                                    </div>
                                </div>

                                <div class="stats-item p-3 bg-light rounded">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-0 text-muted fs-14">Active Trades</h6>
                                            <h5 class="mb-0 mt-1"><?php echo e(shortAmount($trade->active)); ?></h5>
                                        </div>
                                        <i class="las la-clock text-warning fs-3"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stats-card-success">
                        <div class="card-body text-center">
                            <h3 class="text--success mb-1"><?php echo e(shortAmount($trade->won)); ?></h3>
                            <p class="text-muted mb-2">Winning Trades</p>
                            <small class="text--success"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->wining)); ?> profit</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stats-card-danger">
                        <div class="card-body text-center">
                            <h3 class="text--danger mb-1"><?php echo e(shortAmount($trade->lost)); ?></h3>
                            <p class="text-muted mb-2">Losing Trades</p>
                            <small class="text--danger"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->loss)); ?> loss</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm stats-card-warning">
                        <div class="card-body text-center">
                            <h3 class="text--warning mb-1"><?php echo e(shortAmount($trade->draw)); ?></h3>
                            <p class="text-muted mb-2">Draw Trades</p>
                            <small class="text-muted">No profit/loss</small>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(isset($topSymbols) && $topSymbols->isNotEmpty()): ?>
                <div class="row g-4 mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">Top Trading Symbols</h5>
                                <small class="text-muted">Most traded cryptocurrencies by volume</small>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <?php $__currentLoopData = $topSymbols; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $symbol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-md-2-4">
                                            <div class="text-center p-3 bg-light rounded">
                                                <h6 class="text-uppercase fw-bold mb-1"><?php echo e($symbol->symbol); ?></h6>
                                                <p class="text-muted small mb-1"><?php echo e(shortAmount($symbol->trade_count)); ?> trades</p>
                                                <h6 class="text-primary mb-0"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($symbol->volume)); ?></h6>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="card-title mb-0">Recent Trades</h5>
                                <small class="text-muted">Latest 10 trading activities</small>
                            </div>
                            <a href="<?php echo e(route('admin.trade-logs.index')); ?>" class="btn btn-outline-primary btn-sm">
                                View All <i class="las la-arrow-right ms-1"></i>
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <?php if($latestTradeLogs->isNotEmpty()): ?>
                                <div class="responsive-table">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('Trade ID')); ?></th>
                                                <th><?php echo e(__('User')); ?></th>
                                                <th><?php echo e(__('Symbol')); ?></th>
                                                <th><?php echo e(__('Direction')); ?></th>
                                                <th><?php echo e(__('Amount')); ?></th>
                                                <th><?php echo e(__('Prices')); ?></th>
                                                <th><?php echo e(__('Duration')); ?></th>
                                                <th><?php echo e(__('P&L')); ?></th>
                                                <th><?php echo e(__('Status')); ?></th>
                                                <th><?php echo e(__('Time')); ?></th>
                                                <th><?php echo e(__('Actions')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $__currentLoopData = $latestTradeLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td data-label="<?php echo e(__('Trade ID')); ?>">
                                                    <strong><?php echo e($trade->trade_id); ?></strong>
                                                </td>
                                                <td data-label="<?php echo e(__('User')); ?>">
                                                    <div class="user-info">
                                                        <strong><?php echo e($trade->user->fullname ?? 'Unknown'); ?></strong>
                                                        <br><small class="text-dark"><?php echo e($trade->user->email ?? 'N/A'); ?></small>
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo e(__('Symbol')); ?>">
                                                    <span class="text-uppercase fw-bold"><?php echo e($trade->symbol); ?></span>
                                                </td>
                                                <td data-label="<?php echo e(__('Direction')); ?>">
                                                    <span class="badge <?php echo e($trade->direction == 'up' ? 'badge--success' : 'badge--danger'); ?>">
                                                        <?php echo e(strtoupper($trade->direction)); ?>

                                                    </span>
                                                </td>
                                                <td data-label="<?php echo e(__('Amount')); ?>">
                                                    <strong><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->amount, 2)); ?></strong>
                                                    <br><small class="text-muted"><?php echo e(shortAmount($trade->payout_rate, 2)); ?>%</small>
                                                </td>
                                                <td data-label="<?php echo e(__('Prices')); ?>">
                                                    <div class="price-info">
                                                        <strong>Open: <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->open_price, 4)); ?></strong>
                                                        <?php if($trade->close_price): ?>
                                                            <br><small class="text-muted">Close: <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->close_price, 4)); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo e(__('Duration')); ?>">
                                                    <span class="badge badge--info-transparent"><?php echo e($trade->duration_formatted); ?></span>
                                                    <?php if($trade->status == 'active' && $trade->time_remaining): ?>
                                                        <br><small class="text-warning"><?php echo e($trade->time_remaining); ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="<?php echo e(__('P&L')); ?>">
                                                    <?php if($trade->profit_loss != 0): ?>
                                                        <strong class="<?php echo e($trade->profit_loss > 0 ? 'text--success' : 'text--danger'); ?>">
                                                            <?php echo e($trade->formatted_profit_loss); ?>

                                                        </strong>
                                                    <?php else: ?>
                                                        <span class="text-muted"><?php echo e(getCurrencySymbol()); ?>0.00</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td data-label="<?php echo e(__('Status')); ?>">
                                                    <?php
                                                        $statusClass = match($trade->status) {
                                                            'active' => 'badge--primary',
                                                            'won' => 'badge--success',
                                                            'lost' => 'badge--danger',
                                                            'draw' => 'badge--warning',
                                                            'cancelled' => 'badge--secondary',
                                                            'expired' => 'badge--dark',
                                                            default => 'badge--secondary'
                                                        };
                                                    ?>
                                                    <span class="badge <?php echo e($statusClass); ?>"><?php echo e(strtoupper($trade->status)); ?></span>
                                                </td>
                                                <td data-label="<?php echo e(__('Time')); ?>">
                                                    <div class="time-info">
                                                        <strong><?php echo e($trade->open_time?->format('M d, H:i') ?? 'N/A'); ?></strong>
                                                        <?php if($trade->close_time): ?>
                                                            <br><small class="text-muted"><?php echo e($trade->close_time->format('M d, H:i')); ?></small>
                                                        <?php endif; ?>
                                                    </div>
                                                </td>
                                                <td data-label="<?php echo e(__('Actions')); ?>">
                                                    <?php if(in_array($trade->status, ['active', 'expired'])): ?>
                                                        <a href="javascript:void(0)"
                                                           data-id="<?php echo e($trade->id); ?>"
                                                           class="badge badge--warning-transparent settleTradeBtn">
                                                            settle
                                                        </a>
                                                        <a href="javascript:void(0)"
                                                           data-id="<?php echo e($trade->id); ?>"
                                                           class="badge badge--danger-transparent cancelTradeBtn">
                                                            cancel
                                                        </a>
                                                    <?php else: ?>
                                                        <span>N/A</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="las la-chart-line text-muted" style="font-size: 3rem;"></i>
                                    <h6 class="text-muted mt-3">No trade data available</h6>
                                    <p class="text-muted small">Trades will appear here once users start trading</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Cryptocurrency Performance -->
            <?php if($coins->isNotEmpty()): ?>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-white border-bottom">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title mb-0">Active Trading Cryptocurrencies</h5>
                                        <small class="text-muted">Showing <?php echo e($coins->count()); ?> cryptocurrencies with trading activity</small>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button class="btn btn-outline-secondary btn-sm" id="sortByVolume">
                                            <i class="las la-sort-amount-down"></i> Volume
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" id="sortByPrice">
                                            <i class="las la-dollar-sign"></i> Price
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm" id="sortByChange">
                                            <i class="las la-chart-line"></i> Change
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-4" id="coinsList">
                                    <?php $__currentLoopData = $coins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6 coin-item"
                                             data-volume="<?php echo e($coin->total_volume ?? 0); ?>"
                                             data-name="<?php echo e($coin->name); ?>"
                                             data-price="<?php echo e($coin->current_price ?? 0); ?>"
                                             data-change="<?php echo e($coin->change_percent ?? 0); ?>">
                                            <div class="card border-0 bg-gradient-light h-100 coin-card">
                                                <div class="card-body p-4">
                                                    <div class="d-flex align-items-center mb-3">
                                                        <div class="coin-image me-3">
                                                            <?php if($coin->image_url): ?>
                                                                <img src="<?php echo e($coin->image_url); ?>" class="rounded-circle shadow-sm" width="50" height="50" alt="<?php echo e($coin->name); ?>">
                                                            <?php elseif($coin->image_url ?? false): ?>
                                                                <img src="<?php echo e($coin->image_url); ?>" class="rounded-circle shadow-sm" width="50" height="50" alt="<?php echo e($coin->name); ?>">
                                                            <?php else: ?>
                                                                <div class="rounded-circle shadow-sm bg-primary bg-opacity-10 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                                    <i class="las la-coins text-primary fs-4"></i>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0 fw-bold text-dark"><?php echo e($coin->name); ?></h6>
                                                            <small class="text-muted text-uppercase fw-medium"><?php echo e($coin->symbol); ?></small>
                                                        </div>
                                                        <div class="coin-status">
                                                            <?php if($coin->status === 'active' || $coin->is_active ?? true): ?>
                                                                <i class="las la-circle text-success" title="Active"></i>
                                                            <?php else: ?>
                                                                <i class="las la-circle text-secondary" title="Inactive"></i>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>

                                                    <!-- Current Price -->
                                                    <div class="text-center mb-3">
                                                        <small class="text-muted d-block mb-1">Current Price</small>
                                                        <h5 class="mb-0 text-primary fw-bold">
                                                            <?php echo e(getCurrencySymbol()); ?><?php echo e(number_format($coin->current_price ?? 0, 4)); ?>

                                                        </h5>
                                                    </div>

                                                    <!-- Price Change & Volume -->
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <div class="text-center">
                                                                <small class="text-muted d-block">24h Change</small>
                                                                <span class="fw-medium <?php echo e(($coin->change_percent ?? 0) >= 0 ? 'text-success' : 'text-danger'); ?> small">
                                                                    <?php echo e(($coin->change_percent ?? 0) >= 0 ? '+' : ''); ?><?php echo e(number_format($coin->change_percent ?? 0, 2)); ?>%
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="text-center">
                                                                <small class="text-muted d-block">24h Volume</small>
                                                                <span class="fw-medium text-info small">
                                                                    <?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($coin->total_volume ?? 0)); ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- High/Low if available -->
                                                    <?php if(($coin->high_24h ?? 0) > 0 || ($coin->low_24h ?? 0) > 0): ?>
                                                        <div class="d-flex justify-content-between mb-3">
                                                            <div class="text-center flex-fill">
                                                                <small class="text-success d-block mb-1">
                                                                    <i class="las la-arrow-up"></i> 24h High
                                                                </small>
                                                                <span class="fw-medium text-success small"><?php echo e(getCurrencySymbol()); ?><?php echo e(number_format($coin->high_24h ?? 0, 4)); ?></span>
                                                            </div>
                                                            <div class="border-start mx-2"></div>
                                                            <div class="text-center flex-fill">
                                                                <small class="text-danger d-block mb-1">
                                                                    <i class="las la-arrow-down"></i> 24h Low
                                                                </small>
                                                                <span class="fw-medium text-danger small"><?php echo e(getCurrencySymbol()); ?><?php echo e(number_format($coin->low_24h ?? 0, 4)); ?></span>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- Market Cap & Rank -->
                                                    <div class="row g-2">
                                                        <?php if(($coin->market_cap ?? 0) > 0): ?>
                                                            <div class="col-6">
                                                                <div class="text-center">
                                                                    <small class="text-muted d-block">Market Cap</small>
                                                                    <span class="fw-medium small"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($coin->market_cap)); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if(($coin->rank ?? 0) > 0): ?>
                                                            <div class="col-6">
                                                                <div class="text-center">
                                                                    <small class="text-muted d-block">Rank</small>
                                                                    <span class="badge bg-primary-soft">#<?php echo e($coin->rank); ?></span>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>

                                                    <!-- Performance Indicator -->
                                                    <div class="mt-3">
                                                        <?php
                                                            $performance = $coin->change_percent ?? 0;
                                                        ?>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">24h Performance</small>
                                                            <small class="badge bg-<?php echo e($performance >= 0 ? 'success' : 'danger'); ?>-soft">
                                                                <?php echo e($performance >= 0 ? '+' : ''); ?><?php echo e(number_format($performance, 1)); ?>%
                                                            </small>
                                                        </div>
                                                        <div class="progress progress-xs mt-1">
                                                            <div class="progress-bar bg-<?php echo e($performance >= 0 ? 'success' : 'danger'); ?>"
                                                                 style="width: <?php echo e(min(abs($performance), 100)); ?>%"></div>
                                                        </div>
                                                    </div>

                                                    <!-- Last Updated -->
                                                    <?php if($coin->last_updated): ?>
                                                        <div class="mt-2 text-center">
                                                            <small class="text-muted">
                                                                Updated: <?php echo e($coin->last_updated->diffForHumans()); ?>

                                                            </small>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Performance Summary -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white border-bottom">
                            <h5 class="card-title mb-0">Performance Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <div class="performance-circle mx-auto mb-2" data-percentage="<?php echo e(min($trade->win_rate, 100)); ?>">
                                            <span class="percentage"><?php echo e($trade->win_rate); ?>%</span>
                                        </div>
                                        <h6 class="mb-0">Win Rate</h6>
                                        <small class="text-muted">Success percentage</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text--primary mb-1"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->high)); ?></h4>
                                        <h6 class="mb-0">Highest Trade</h6>
                                        <small class="text-muted">Maximum investment</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="text--info mb-1"><?php echo e(getCurrencySymbol()); ?><?php echo e(shortAmount($trade->average)); ?></h4>
                                        <h6 class="mb-0">Average Trade</h6>
                                        <small class="text-muted">Mean investment</small>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="text-center">
                                        <h4 class="<?php echo e($trade->profit_margin >= 0 ? 'text--success' : 'text--danger'); ?> mb-1"><?php echo e($trade->profit_margin); ?>%</h4>
                                        <h6 class="mb-0">Profit Margin</h6>
                                        <small class="text-muted">Overall profitability</small>
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

<?php $__env->startPush('style-push'); ?>
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
        }

        .stats-item {
            transition: all 0.3s ease;
        }

        .stats-item:hover {
            background: #f8f9fa !important;
            transform: scale(1.02);
        }

        .stats-card-success {
            border-left: 4px solid #28a745;
        }

        .stats-card-danger {
            border-left: 4px solid #dc3545;
        }

        .stats-card-warning {
            border-left: 4px solid #ffc107;
        }

        .coin-card {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        .coin-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .coin-image img {
            transition: transform 0.3s ease;
        }

        .coin-card:hover .coin-image img {
            transform: scale(1.1);
        }

        .progress-xs {
            height: 3px;
        }

        .performance-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: conic-gradient(#28a745 var(--percentage), #e9ecef 0);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .performance-circle::before {
            content: '';
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: white;
            position: absolute;
        }

        .percentage {
            z-index: 1;
            font-weight: bold;
            color: #28a745;
        }

        .trade-row {
            transition: all 0.2s ease;
        }

        .trade-row:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }

        .bg-primary-soft {
            background-color: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
        }

        .bg-success-soft {
            background-color: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }

        .bg-danger-soft {
            background-color: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }

        .badge-soft-warning {
            background-color: rgba(255, 193, 7, 0.1);
            color: #856404;
        }

        .coin-status i {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .col-md-2-4 {
            flex: 0 0 20%;
            max-width: 20%;
        }

        @media (max-width: 768px) {
            .col-md-2-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            const amount = <?php echo json_encode($amount, 15, 512) ?>;
            const days = <?php echo json_encode($days, 15, 512) ?>;
            const currency = "<?php echo e(getCurrencySymbol()); ?>";

            // Enhanced chart options
            const options = {
                series: [{
                    name: 'Trading Volume',
                    data: amount
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: true,
                            zoomin: true,
                            zoomout: true,
                            pan: false,
                        }
                    },
                    zoom: {
                        enabled: true
                    },
                    animations: {
                        enabled: true,
                        easing: 'easeinout',
                        speed: 800
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.8,
                        opacityTo: 0.1,
                        stops: [0, 90, 100],
                        colorStops: [
                            {
                                offset: 0,
                                color: '#0d6efd',
                                opacity: 0.8
                            },
                            {
                                offset: 100,
                                color: '#0d6efd',
                                opacity: 0.1
                            }
                        ]
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                xaxis: {
                    categories: days,
                    labels: {
                        style: {
                            fontSize: '12px',
                            colors: '#6c757d'
                        }
                    }
                },
                yaxis: {
                    title: {
                        text: 'Amount (' + currency + ')',
                        style: {
                            color: '#6c757d'
                        }
                    },
                    labels: {
                        formatter: function(value) {
                            return currency + value.toFixed(0);
                        },
                        style: {
                            colors: '#6c757d'
                        }
                    }
                },
                grid: {
                    borderColor: '#e7e7e7',
                    strokeDashArray: 5,
                    xaxis: {
                        lines: {
                            show: false
                        }
                    }
                },
                colors: ['#0d6efd'],
                tooltip: {
                    theme: 'light',
                    y: {
                        formatter: function (val) {
                            return currency + val.toFixed(2);
                        }
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#totalTrade"), options);
            chart.render();

            // Initialize performance circles
            $('.performance-circle').each(function() {
                const percentage = $(this).data('percentage');
                $(this).css('--percentage', percentage + '%');
            });

            // Coin sorting functionality
            $('#sortByVolume').click(function() {
                sortCoins('volume');
                updateSortButtons($(this));
            });

            $('#sortByPrice').click(function() {
                sortCoins('price');
                updateSortButtons($(this));
            });

            $('#sortByChange').click(function() {
                sortCoins('change');
                updateSortButtons($(this));
            });

            function updateSortButtons(activeBtn) {
                $('.btn-primary').addClass('btn-outline-secondary').removeClass('btn-primary');
                activeBtn.addClass('btn-primary').removeClass('btn-outline-secondary');
            }

            function sortCoins(type) {
                const container = $('#coinsList');
                const items = container.children('.coin-item').get();

                items.sort(function(a, b) {
                    if (type === 'volume') {
                        return $(b).data('volume') - $(a).data('volume');
                    } else if (type === 'price') {
                        return $(b).data('price') - $(a).data('price');
                    } else if (type === 'change') {
                        return $(b).data('change') - $(a).data('change');
                    } else {
                        return $(a).data('name').localeCompare($(b).data('name'));
                    }
                });

                container.append(items);
            }

            // Refresh chart functionality
            $('#refreshChart').click(function() {
                $(this).addClass('loading');
                chart.updateSeries([{
                    name: 'Trading Volume',
                    data: amount
                }]);
                setTimeout(() => {
                    $(this).removeClass('loading');
                }, 1000);
            });

            // Auto-refresh active trades every 30 seconds
            <?php if($trade->active > 0): ?>
            setInterval(function() {
                // Only refresh if there are active trades
                const activeBadges = $('.badge:contains("Active")');
                if (activeBadges.length > 0) {
                    // Add subtle notification
                    $('.card-title:contains("Recent Trades")').append(' <i class="las la-sync-alt text-muted" style="font-size: 12px;"></i>');
                }
            }, 30000);
            <?php endif; ?>
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/statistic/trade.blade.php ENDPATH**/ ?>