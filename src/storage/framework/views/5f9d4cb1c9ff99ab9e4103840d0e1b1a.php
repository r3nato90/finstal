<?php
    $tradeInvestmentSetting = \App\Models\Setting::get('investment_trade_prediction', 1);
    $moduleLanguage = \App\Models\Setting::get('module_language', 1);
?>

<section class="topbar">
    <div class="container-fluid px-0">
        <div class="marquee marquee-one" data-gap='10' data-duplicated='true'>
            <div class="marquee-items">
               <?php $__currentLoopData = $cryptoCurrencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                   <li class="marquee-item">
                       <div class="marquee-item-img">
                           <img src="<?php echo e($currency->image_url ?? '/default-crypto-icon.png'); ?>" alt="<?php echo e(__($currency->name)); ?>" />
                       </div>
                       <h6><?php echo e(__($currency->name)); ?></h6>
                       <span> <?php echo e($currency->base_currency ?? '$'); ?><?php echo e(number_format($currency->current_price, 8)); ?> (   <?php echo e($currency->change_percent >= 0 ? '+' : ''); ?><?php echo e(number_format($currency->change_percent, 2)); ?>%)</span>
                   </li>
               <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>


<header class="header-area style-1">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="header-left">
            <button class="header-item-btn sidebar-btn d-lg-none d-block">
                <i class="bi bi-bars"></i>
            </button>

            <div class="header-logo">
                <a href="<?php echo e(route('home')); ?>">
                    <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__('White Logo')); ?>">
                </a>
            </div>
        </div>

        <div class="main-nav">
            <div class="mobile-logo-area d-xl-none d-flex justify-content-between align-items-center">
                <div class="mobile-logo-wrap">
                    <img src="<?php echo e(displayImage($logo_white, "592x89")); ?>" alt="<?php echo e(__('White Logo')); ?>">
                </div>
                <div class="menu-close-btn">
                    <i class="bi bi-x-lg"></i>
                </div>
            </div>
            <ul class="menu-list">
                <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($menu->name == 'Home'): ?>
                        <li class="menu-item-has-children">
                            <a href="<?php echo e(route('home')); ?>" class="drop-down <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>"><?php echo e($menu->name); ?></a>
                        </li>
                    <?php elseif($menu->name == 'Trade'): ?>

                        <?php if($tradeInvestmentSetting == 1): ?>
                            <li class="menu-item-has-children">
                                <a href="<?php echo e(route('trade')); ?>" class="drop-down <?php echo e(request()->routeIs('trade') ? 'active' : ''); ?>"><?php echo e($menu->name); ?></a>
                            </li>
                        <?php endif; ?>
                    <?php elseif($menu->children->isEmpty()): ?>
                        <li><a href="<?php echo e(route('dynamic.page', $menu->url)); ?>"><?php echo e($menu->name); ?></a></li>
                    <?php elseif($menu->children->isNotEmpty()): ?>
                        <li class="menu-item-has-children">
                            <a href="<?php echo e($menu->url); ?>" class="drop-down"><?php echo e($menu->name); ?></a>
                            <i class="bi bi-chevron-down dropdown-icon"></i>
                            <ul class="sub-menu">
                                <?php $__currentLoopData = $menu->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e($subMenu->url); ?>"><?php echo e($subMenu->name); ?></a></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <li><a href="<?php echo e(route('contact')); ?>" class="<?php echo e(request()->routeIs('contact') ? 'active' : ''); ?>"><?php echo e(__('Contact')); ?></a></li>
            </ul>

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary"><?php echo app('translator')->get('Sign In'); ?></a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="i-btn btn--md d-xl-none d-flex capsuled btn--primary"><?php echo app('translator')->get('Dashboard'); ?></a>
            <?php endif; ?>
        </div>

        <div class="nav-right">
            <?php if($moduleLanguage == \App\Enums\Status::ACTIVE->value): ?>
                <div class="dropdown-language">
                    <select class="language">
                        <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($lang->code); ?>" <?php if(session('lang') == $lang->code): ?> selected <?php endif; ?>><?php echo e($lang?->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            <?php endif; ?>

            <?php if(auth()->guard()->guest()): ?>
                <a href="<?php echo e(route('login')); ?>" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline"><?php echo app('translator')->get('Sign In'); ?></a>
            <?php endif; ?>

            <?php if(auth()->guard()->check()): ?>
                <a href="<?php echo e(route('user.dashboard')); ?>" class="i-btn btn--md d-xl-flex d-none capsuled btn--primary-outline"><?php echo app('translator')->get('Dashboard'); ?></a>
            <?php endif; ?>

            <div class="sidebar-btn d-xl-none d-flex">
                <i class="bi bi-list"></i>
            </div>
        </div>
    </div>
</header>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        $(document).ready(function () {
            $('.language').on('change', function () {
                const languageCode = $(this).val();
                changeLanguage(languageCode);
            });

            function changeLanguage(languageCode) {
                $.ajax({
                    url: "<?php echo e(route('home')); ?>/language-change/" + languageCode,
                    method: 'GET',
                    success: function (response) {
                        notify('success', response.message);
                        location.reload();
                    },
                    error: function (error) {
                        console.error('Error changing language', error);
                    }
                });
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/default_theme/partials/header.blade.php ENDPATH**/ ?>