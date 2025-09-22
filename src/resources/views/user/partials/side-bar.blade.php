<div class="d-sidebar" id="user-sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('home') }}">
            <img src="{{ displayImage($logo_white, "592x89") }}" alt="{{ __('logo') }}">
        </a>
    </div>
    <div class="main-nav sidebar-menu-container">
        <ul class="sidebar-menu">
            <!-- DASHBOARD -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.dashboard') ? "active" :""}}" href="{{ route('user.dashboard') }}" aria-expanded="false">
                    <span><i class="bi bi-speedometer2"></i></span>
                    <p>{{ __('frontend.menu.dashboard') }}</p>
                </a>
            </li>

            <!-- TRANSACTION HISTORY -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.transaction') ? "active" :""}}" href="{{ route('user.transaction') }}" aria-expanded="false">
                    <span><i class="bi bi-credit-card-fill"></i></span>
                    <p>{{ __('frontend.menu.transaction') }}</p>
                </a>
            </li>

            <!-- INVESTMENT & TRADING SECTION -->
            @if($investment_matrix == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseMatrix" role="button" aria-expanded="false" aria-controls="collapseMatrix">
                        <span><i class="bi bi-diagram-3"></i></span>
                        <p>{{ __('frontend.menu.matrix') }}<small><i class="las la-angle-{{ request()->routeIs(['user.matrix.index', 'user.commission.rewards','user.commission.index']) ? 'up' : 'down' }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs(['user.matrix.index', 'user.commission.rewards', 'user.commission.index']) ? 'show' : '' }}" id="collapseMatrix">
                        <ul class="sub-menu {{ request()->routeIs(['user.matrix.index','user.commission.rewards','user.commission.index']) ? 'open-slide' : '' }}">
                            @foreach(['matrix.index' => __('frontend.menu.scheme'), 'commission.rewards' => __('frontend.menu.referral_reward'), 'commission.index' => __('frontend.menu.commission'),] as $route => $label)
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{ request()->routeIs("user.$route") ? 'active' : '' }}"  href="{{ route("user.$route") }}" aria-expanded="false">
                                        <p>{{ __($label) }}</p>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif

            @if($investment_investment == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs(['user.investment.*', 'user.reward']) ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseInvestment" role="button" aria-expanded="false" aria-controls="collapseInvestment">
                        <span><i class="bi bi-wallet-fill"></i></span>
                        <p>{{ __('frontend.menu.investment') }}  <small><i class="las la-angle-{{ request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics', 'user.reward']) ? "up" : "down" }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs(['user.investment.*', 'user.reward']) ? 'show' : '' }}" id="collapseInvestment">
                        <ul class="sub-menu  {{ request()->routeIs(['user.investment.index','user.investment.funds','user.investment.profit.statistics', 'user.reward']) ? "open-slide" : "" }}">
                            @foreach(['index' => __('frontend.menu.scheme'), 'funds' => __('frontend.menu.fund'), 'profit.statistics' => __('frontend.menu.profit_statistics')] as $route => $label)
                                <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{ request()->routeIs("user.investment.$route") ? 'active' : '' }}"  href="{{ route("user.investment.$route") }}" aria-expanded="false">
                                        <p>{{ __($label) }}</p>
                                    </a>
                                </li>
                            @endforeach
                            @if ($module_investment_reward == \App\Enums\Status::ACTIVE->value)
                                    <li class="sub-menu-item">
                                    <a class="sidebar-menu-link {{ request()->routeIs('user.reward') ? "active" :""}}" href="{{ route('user.reward') }}" aria-expanded="false">
                                        <p>{{ __('frontend.menu.reward_badge') }}</p>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </li>
            @endif

            @if($investment_staking_investment == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link {{ request()->routeIs('user.staking-investment.index') ? "active" :""}}"  href="{{ route('user.staking-investment.index') }}" aria-expanded="false">
                        <span><i class="bi bi-currency-euro"></i></span>
                        <p>{{ __('frontend.menu.staking_investment') }}</p>
                    </a>
                </li>
            @endif

            @if($investment_trade_prediction == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.trades.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseTrade" role="button" aria-expanded="false" aria-controls="collapseTrade">
                        <span><i class="bi bi-bar-chart"></i></span>
                        <p>{{ __('frontend.menu.trades')  }}  <small><i class="las la-angle-{{ request()->routeIs('user.trades.*') ? "up" : "down" }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs('user.trades.*') ? 'show' : '' }}" id="collapseTrade">
                        <ul class="sub-menu {{ request()->routeIs('user.trades.*') ? "open-slide" : "" }}">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.trades.index') || request()->routeIs('user.trades.live') ? 'active' : '' }}" href="{{ route('user.trades.index') }}" aria-expanded="false">
                                    <p>{{ __('Trade Now') }}</p>
                                </a>
                            </li>
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.trades.market') ? 'active' : '' }}" href="{{ route('user.trades.market') }}" aria-expanded="false">
                                    <p>{{ __('Market Data') }}</p>
                                </a>
                            </li>
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.trades.history') ? 'active' : '' }}" href="{{ route('user.trades.history') }}" aria-expanded="false">
                                    <p>{{ __('Trade History') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if($investment_ico_token == 1)
                <li class="sidebar-menu-item">
                    <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.ico.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseIco" role="button" aria-expanded="false" aria-controls="collapseIco">
                        <span><i class="bi bi-coin"></i></span>
                        <p>{{ __('ICO') }}  <small><i class="las la-angle-{{ request()->routeIs('user.ico.index') ? "up" : "down" }}"></i></small></p>
                    </a>
                    <div class="side-menu-dropdown collapse {{ request()->routeIs('user.ico.*') ? 'show' : '' }}" id="collapseIco">
                        <ul class="sub-menu  {{ request()->routeIs('user.ico.*') ? "open-slide" : "" }}">
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.ico.index') ? 'active' : '' }}"  href="{{ route('user.ico.index') }}" aria-expanded="false">
                                    <p>{{ __('Token') }}</p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.ico.history') ? 'active' : '' }}"  href="{{ route('user.ico.history') }}" aria-expanded="false">
                                    <p>{{ __('My Purchases') }}</p>
                                </a>
                            </li>

                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs('user.ico.portfolio') ? 'active' : '' }}"  href="{{ route('user.ico.portfolio') }}" aria-expanded="false">
                                    <p>{{ __('Portfolio') }}</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            <!-- FINANCIAL SECTION -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.payment.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseDeposit" role="button" aria-expanded="false" aria-controls="collapseDeposit">
                    <span><i class="bi bi-wallet2"></i></span>
                    <p>{{ __('frontend.menu.deposit') }}  <small><i class="las la-angle-{{ request()->routeIs('user.payment.*') ? "up" : "down" }}"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse {{ request()->routeIs('user.payment.*') ? 'show' : '' }}" id="collapseDeposit">
                    <ul class="sub-menu  {{ request()->routeIs('user.payment.*') ? "open-slide" : "" }}">
                        @foreach(['index' => __('frontend.menu.instant'), 'commission' => __('frontend.menu.commission')] as $deposit => $label)
                            <li class="sub-menu-item">
                                <a class="sidebar-menu-link {{ request()->routeIs("user.payment.$deposit") ? 'active' : '' }}"  href="{{ route("user.payment.$deposit") }}" aria-expanded="false">
                                    <p>{{ __($label) }}</p>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseFinancial" role="button" aria-expanded="false" aria-controls="collapseFinancial">
                    <span><i class="bi bi-cash-stack"></i></span>
                    <p>{{ __('Withdraw') }}  <small><i class="las la-angle-{{ request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? "up" : "down" }}"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse {{ request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? 'show' : '' }}" id="collapseFinancial">
                    <ul class="sub-menu {{ request()->routeIs(['user.withdraw.index', 'user.recharge.index']) ? "open-slide" : "" }}">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.withdraw.index') ? 'active' : '' }}" href="{{ route('user.withdraw.index') }}" aria-expanded="false">
                                <p>{{ __('Withdraw') }}</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.recharge.index') ? 'active' : '' }}" href="{{ route('user.recharge.index') }}" aria-expanded="false">
                                <p>{{ __('frontend.menu.instapin_recharge') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- REFERRAL & SOCIAL -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link {{ request()->routeIs('user.referral.index') ? "active" :""}}"  href="{{ route('user.referral.index') }}" aria-expanded="false">
                    <span><i class="bi bi-command"></i></span>
                    <p>{{ __('frontend.menu.referrals') }}</p>
                </a>
            </li>

            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseSetting" role="button" aria-expanded="false" aria-controls="collapseSetting">
                    <span><i class="bi bi-gear"></i></span>
                    <p>{{ __('Setting') }}  <small><i class="las la-angle-{{ request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? "up" : "down" }}"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse {{ request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? 'show' : '' }}" id="collapseSetting">
                    <ul class="sub-menu {{ request()->routeIs(['user.login.history', 'user.two.factor', 'user.change.password', 'user.profile.index', 'user.kyc.index']) ? "open-slide" : "" }}">

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.kyc.index') ? 'active' : '' }}" href="{{ route('user.kyc.index') }}" aria-expanded="false">
                                <p>{{ __('KYC Verification') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.login.history') ? 'active' : '' }}" href="{{ route('user.login.history') }}" aria-expanded="false">
                                <p>{{ __('Login History') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.two.factor') ? 'active' : '' }}" href="{{ route('user.two.factor') }}" aria-expanded="false">
                                <p>{{ __('Two Factor') }}</p>
                            </a>
                        </li>

                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.change.password') ? 'active' : '' }}" href="{{ route('user.change.password') }}" aria-expanded="false">
                                <p>{{ __('Change Password') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- SUPPORT SECTION -->
            <li class="sidebar-menu-item">
                <a class="sidebar-menu-link collapsed {{ request()->routeIs('user.support-tickets.*') ? 'active' : '' }}" data-bs-toggle="collapse" href="#collapseSupport" role="button" aria-expanded="false" aria-controls="collapseSupport">
                    <span><i class="bi bi-headset"></i></span>
                    <p>{{ __('Support') }}  <small><i class="las la-angle-{{ request()->routeIs('user.support-tickets.*') ? "up" : "down" }}"></i></small></p>
                </a>
                <div class="side-menu-dropdown collapse {{ request()->routeIs('user.support-tickets.*') ? 'show' : '' }}" id="collapseSupport">
                    <ul class="sub-menu {{ request()->routeIs('user.support-tickets.*') ? "open-slide" : "" }}">
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.support-tickets.index') ? 'active' : '' }}" href="{{ route('user.support-tickets.index') }}" aria-expanded="false">
                                <p>{{ __('My Tickets') }}</p>
                            </a>
                        </li>
                        <li class="sub-menu-item">
                            <a class="sidebar-menu-link {{ request()->routeIs('user.support-tickets.create') ? 'active' : '' }}" href="{{ route('user.support-tickets.create') }}" aria-expanded="false">
                                <p>{{ __('Create Ticket') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
