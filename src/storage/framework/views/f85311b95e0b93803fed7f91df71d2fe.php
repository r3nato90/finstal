<header class="header">
    <div class="header_sub_content">
        <div class="topbar-left">
            <div class="sidebar-controller">
                <button class="sidebar-control-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0" y="0" viewBox="0 0 24 24" xml:space="preserve">
                        <g>
                            <path d="M2 5a1 1 0 0 1 1-1h13a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1zm19 6H3a1 1 0 1 0 0 2h18a1 1 0 1 0 0-2zm-9 7H3a1 1 0 1 0 0 2h9a1 1 0 1 0 0-2z"/>
                        </g>
                    </svg>
                </button>
            </div>
        </div>

        <div class="topbar-right d-flex align-items-center justify-content-center gap-lg-4 gap-3">
            <div class="profile-section">
                <div class="profile-dropdown dropdown">
                    <div class="profile-trigger dropdown-toggle d-flex align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="profile-info ms-2 d-none d-lg-block">
                            <span class="profile-name"><?php echo e(auth()->guard('admin')->user()->name); ?></span>
                        </div>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.profile')); ?>">
                                <i class="las la-user-circle me-2"></i><?php echo e(__('Profile Settings')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.two-factor')); ?>">
                                <i class="las la-shield-alt me-2"></i><?php echo e(__('Two Factor')); ?>

                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?php echo e(route('admin.logout')); ?>">
                                <i class="las la-sign-out-alt me-2"></i><?php echo e(__('Logout')); ?>

                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>

<?php $__env->startPush('script-push'); ?>
    <script>
        "use strict";
        const header = document.querySelector(".header");
        if (header) {
            const checkScroll = () => {
                if (window.scrollY > 0) {
                    header.classList.add("sticky");
                } else {
                    header.classList.remove("sticky");
                }
            };
            window.addEventListener("scroll", checkScroll);
            window.addEventListener("load", checkScroll);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/admin/partials/top-bar.blade.php ENDPATH**/ ?>