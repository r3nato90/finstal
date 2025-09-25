<div class="d-sidebar" id="user-sidebar">
    <div class="sidebar-logo">
        <a href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__('logo')); ?>">
        </a>
    </div>
    <div class="main-nav sidebar-menu-container">
        <ul class="sidebar-menu">
            <!-- DASHBOARD -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.dashboard') ? "active" :""); ?>" href="<?php echo e(route('user.dashboard')); ?>" aria-expanded="false">
                    <span><i class="bi bi-speedometer2"></i></span>
                    <p><?php echo e(__('frontend.menu.dashboard')); ?></p>
                </a>
            </li>

            <!-- TRANSACTION HISTORY -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.transaction') ? "active" :""); ?>" href="<?php echo e(route('user.transaction')); ?>" aria-expanded="false">
                    <span><i class="bi bi-credit-card-fill"></i></span>
                    <p><?php echo e(__('frontend.menu.transaction')); ?></p>
                </a>
            </li>

            <!-- INVESTMENT & TRADING SECTION -->
            <?php if($investment_matrix == 1): ?>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseMatrix" role="button" aria-expanded="false" aria-controls="collapseMatrix">
                        <span><i class="bi bi-diagram-3"></i></span>
                        <p><?php echo e(__('frontend.menu.matrix')); ?><small><i class="las la-angle-<?php echo e(request()->routeIs(['user.matrix.index', 'user.commission.rewards','user.commission.index']) ? 'up' : 'down'); ?>"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'show' : ''); ?>" id="collapseMatrix">
                        <ul class="sub-menu <?php echo e(request()->routeIs(['user.matrix.index','user.commission.rewards','user.commission.index']) ? 'open-slide' : ''); ?>">
                            <?php $__currentLoopData = ['matrix.index' => __('frontend.menu.scheme'), 'commission.rewards' => __('frontend.menu.referral_reward'), 'commission.index' => __('frontend.menu.commission'),]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link <?php echo e(request()->routeIs("user.$route") ? 'active' : ''); ?>"  href="<?php echo e(route("user.$route")); ?>" aria-expanded="false">
                                        <p><?php echo e(__($label)); ?></p>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($investment_investment == 1): ?>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs(['user.investment.*', 'user.reward']) ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseInvestment" role="button" aria-expanded="false" aria-controls="collapseInvestment">
                        <span><i class="bi bi-wallet-fill"></i></span>
                        <p><?php echo e(__('frontend.menu.investment')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics', 'user.reward']) ? "up" : "down"); ?>"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs(['user.investment.*', 'user.reward']) ? 'show' : ''); ?>" id="collapseInvestment">
                        <ul class="sub-menu  <?php echo e(request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics', 'user.reward']) ? "open-slide" : ""); ?>">
                            <?php $__currentLoopData = ['index' => __('frontend.menu.scheme'), 'funds' => __('frontend.menu.fund'), 'profit.statistics' => __('frontend.menu.profit_statistics')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $route => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link <?php echo e(request()->routeIs("user.investment.$route") ? 'active' : ''); ?>"  href="<?php echo e(route("user.investment.$route")); ?>" aria-expanded="false">
                                        <p><?php echo e(__($label)); ?></p>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($module_investment_reward == \App\Enums\Status::ACTIVE->value): ?>
                                    <li class="sub-menu-item">
                                    <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.reward') ? "active" :""); ?>" href="<?php echo e(route('user.reward')); ?>" aria-expanded="false">
                                        <p><?php echo e(__('frontend.menu.reward_badge')); ?></p>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($investment_staking_investment == 1): ?>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.staking-investment.index') ? "active" :""); ?>"  href="<?php echo e(route('user.staking-investment.index')); ?>" aria-expanded="false">
                        <span><i class="bi bi-currency-euro"></i></span>
                        <p><?php echo e(__('frontend.menu.staking_investment')); ?></p>
                    </a>
                </li>
            <?php endif; ?>

            <?php if($investment_trade_prediction == 1): ?>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs('user.trades.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseTrade" role="button" aria-expanded="false" aria-controls="collapseTrade">
                        <span><i class="bi bi-bar-chart"></i></span>
                        <p><?php echo e(__('frontend.menu.trades')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs('user.trades.*') ? "up" : "down"); ?>"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs('user.trades.*') ? 'show' : ''); ?>" id="collapseTrade">
                        <ul class="sub-menu <?php echo e(request()->routeIs('user.trades.*') ? "open-slide" : ""); ?>">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.trades.index') || request()->routeIs('user.trades.live') ? 'active' : ''); ?>" href="<?php echo e(route('user.trades.index')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('Trade Now')); ?></p>
                                </a>
                            </li>
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.trades.market') ? 'active' : ''); ?>" href="<?php echo e(route('user.trades.market')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('Market Data')); ?></p>
                                </a>
                            </li>
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.trades.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.trades.history')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('Trade History')); ?></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <?php if($investment_ico_token == 1): ?>
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs('user.ico.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseIco" role="button" aria-expanded="false" aria-controls="collapseIco">
                        <span><i class="bi bi-coin"></i></span>
                        <p><?php echo e(__('ICO')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs('user.ico.index') ? "up" : "down"); ?>"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs('user.ico.*') ? 'show' : ''); ?>" id="collapseIco">
                        <ul class="sub-menu  <?php echo e(request()->routeIs('user.ico.*') ? "open-slide" : ""); ?>">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.ico.index') ? 'active' : ''); ?>"  href="<?php echo e(route('user.ico.index')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('Token')); ?></p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.ico.history') ? 'active' : ''); ?>"  href="<?php echo e(route('user.ico.history')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('My Purchases')); ?></p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.ico.portfolio') ? 'active' : ''); ?>"  href="<?php echo e(route('user.ico.portfolio')); ?>" aria-expanded="false">
                                    <p><?php echo e(__('Portfolio')); ?></p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            <?php endif; ?>

            <!-- FINANCIAL SECTION -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs('user.payment.*') ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseDeposit" role="button" aria-expanded="false" aria-controls="collapseDeposit">
                    <span><i class="bi bi-wallet2"></i></span>
                    <p><?php echo e(__('frontend.menu.deposit')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs('user.payment.*') ? "up" : "down"); ?>"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs('user.payment.*') ? 'show' : ''); ?>" id="collapseDeposit">
                    <ul class="sub-menu  <?php echo e(request()->routeIs('user.payment.*') ? "open-slide" : ""); ?>">
                        <?php $__currentLoopData = ['index' => __('frontend.menu.instant'), 'commission' => __('frontend.menu.commission')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link <?php echo e(request()->routeIs("user.payment.$deposit") ? 'active' : ''); ?>"  href="<?php echo e(route("user.payment.$deposit")); ?>" aria-expanded="false">
                                    <p><?php echo e(__($label)); ?></p>
                                </a>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseFinancial" role="button" aria-expanded="false" aria-controls="collapseFinancial">
                    <span><i class="bi bi-cash-stack"></i></span>
                    <p><?php echo e(__('Withdraw')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? "up" : "down"); ?>"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? 'show' : ''); ?>" id="collapseFinancial">
                    <ul class="sub-menu <?php echo e(request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? "open-slide" : ""); ?>">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.withdraw.index') ? 'active' : ''); ?>" href="<?php echo e(route('user.withdraw.index')); ?>" aria-expanded="false">
                                <p><?php echo e(__('Withdraw')); ?></p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.recharge.index') ? 'active' : ''); ?>" href="<?php echo e(route('user.recharge.index')); ?>" aria-expanded="false">
                                <p><?php echo e(__('frontend.menu.instapin_recharge')); ?></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- REFERRAL & SOCIAL -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.referral.index') ? "active" :""); ?>"  href="<?php echo e(route('user.referral.index')); ?>" aria-expanded="false">
                    <span><i class="bi bi-command"></i></span>
                    <p><?php echo e(__('frontend.menu.referrals')); ?></p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed <?php echo e(request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? 'active' : ''); ?>" data-bs-toggle="collapse" href="#collapseSetting" role="button" aria-expanded="false" aria-controls="collapseSetting">
                    <span><i class="bi bi-gear"></i></span>
                    <p><?php echo e(__('Setting')); ?>  <small><i class="las la-angle-<?php echo e(request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? "up" : "down"); ?>"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse <?php echo e(request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? 'show' : ''); ?>" id="collapseSetting">
                    <ul class="sub-menu <?php echo e(request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? "open-slide" : ""); ?>">

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.kyc.index') ? 'active' : ''); ?>" href="<?php echo e(route('user.kyc.index')); ?>" aria-expanded="false">
                                <p><?php echo e(__('KYC Verification')); ?></p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.login.history') ? 'active' : ''); ?>" href="<?php echo e(route('user.login.history')); ?>" aria-expanded="false">
                                <p><?php echo e(__('Login History')); ?></p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.two.factor') ? 'active' : ''); ?>" href="<?php echo e(route('user.two.factor')); ?>" aria-expanded="false">
                                <p><?php echo e(__('Two Factor')); ?></p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link <?php echo e(request()->routeIs('user.change.password') ? 'active' : ''); ?>" href="<?php echo e(route('user.change.password')); ?>" aria-expanded="false">
                                <p><?php echo e(__('Change Password')); ?></p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/side-bar.blade.php ENDPATH**/ ?>