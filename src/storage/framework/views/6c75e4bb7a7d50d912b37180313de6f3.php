<header class="d-header">
    <div class="container-fluid px-0">
        <div class="row align-items-center">
            <div class="col-lg-5 col-6 d-flex align-items-center">
                <div class="d-header-left">
                    <div class="sidebar-button" id="dash-sidebar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-6">
                <div class="d-header-right">
                    <div class="i-dropdown user-dropdown dropdown">
                        <div class="user-dropdown-meta dropdown-toggle hide-arrow d-flex align-items-center text-white" data-bs-toggle="dropdown">
                            <div class="user-icon me-2">
                                <i class="bi bi-person-circle fs-4"></i>
                            </div>
                            <div class="user-dropdown-info d-none d-sm-block">
                                <p class="mb-0"><?php echo e(Auth::user()->name); ?></p>
                            </div>
                            <div class="d-sm-none">
                                <i class="bi bi-chevron-down"></i>
                            </div>
                        </div>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-header"><?php echo e(__('Welcome')); ?>!</span>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('user.wallet.index')); ?>">
                                    <?php echo e(__('Wallet Top-Up')); ?>

                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <?php echo e(__('Log Out')); ?>

                                </a>

                                <form id="logout-form" method="POST" action="<?php echo e(route('logout')); ?>" class="d-none">
                                    <?php echo csrf_field(); ?>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<?php $__env->startPush('style-push'); ?>
    <style>
        /* Header responsive improvements */
        .d-header {
            position: sticky;
            top: 0;
            z-index: 1020;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .d-header-right {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .user-dropdown-meta {
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 0.375rem;
            transition: background-color 0.15s ease-in-out;
        }

        .user-dropdown-meta:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .user-icon {
            color: #6c757d;
        }

        /* Sidebar responsive improvements */
        @media (max-width: 991.98px) {
            .d-sidebar {
                position: fixed;
                left: -100%;
                top: 0;
                height: 100vh;
                transition: left 0.3s ease;
                z-index: 1030;
                background: #fff;
                box-shadow: 2px 0 5px rgba(0,0,0,0.1);
            }

            .d-sidebar.show {
                left: 0;
            }

            .sidebar-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 1025;
                display: none;
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Mobile-first dropdown improvements */
        @media (max-width: 575.98px) {
            .dropdown-menu {
                min-width: 200px;
                right: 0 !important;
                left: auto !important;
            }

            .user-dropdown-info p {
                font-size: 0.875rem;
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }
        }

        /* Improved sidebar menu text wrapping */
        .sidebar-menu-item p {
            margin: 0;
            font-size: 0.9rem;
            line-height: 1.4;
            word-break: break-word;
        }

        @media (max-width: 767.98px) {
            .sidebar-menu-item p {
                font-size: 0.85rem;
            }
        }

        /* Better alignment for icons and text */
        .sidebar-menu-link {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: inherit;
            transition: all 0.15s ease-in-out;
        }

        .sidebar-menu-link span {
            margin-right: 0.75rem;
            display: flex;
            align-items: center;
            min-width: 20px;
        }

        /* Dropdown menu improvements */
        .dropdown-item {
            padding: 0.5rem 1rem;
            transition: background-color 0.15s ease-in-out;
        }

        .dropdown-item:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .dropdown-header {
            padding: 0.5rem 1rem;
            margin-bottom: 0;
            font-size: 0.875rem;
            color: #6c757d;
            font-weight: 600;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-push'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarBtn = document.getElementById('dash-sidebar-btn');
            const sidebar = document.getElementById('user-sidebar');

            // Create overlay for mobile
            const overlay = document.createElement('div');
            overlay.className = 'sidebar-overlay';
            document.body.appendChild(overlay);

            // Toggle sidebar on mobile
            if (sidebarBtn) {
                sidebarBtn.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    overlay.classList.toggle('show');
                });
            }

            // Close sidebar when clicking overlay
            overlay.addEventListener('click', function() {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            });

            // Close sidebar on window resize if desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth > 991) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/u864690811/domains/nextbroker.online/public_html/src/resources/views/user/partials/top-bar.blade.php ENDPATH**/ ?>