(function () {
    "use strict";

    const planCardSlider = document.querySelector(".plan-card-slider");
    if (planCardSlider) {
        new Swiper(planCardSlider, {
            slidesPerView: 3,
            spaceBetween: 15,
            autoplay: {
                delay: 3000,
            },
            speed: 1000,
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            // Enable scrollbar
            scrollbar: {
                el: '.swiper-scrollbar',
                draggable: true,
                hide: false,
            },
            // Enable mousewheel control
            mousewheel: {
                enabled: true,
                forceToAxis: true,
            },
            // Enable keyboard control
            keyboard: {
                enabled: true,
                onlyInViewport: true,
            },
            breakpoints: {
                320: {
                    slidesPerView: 1,
                },
                576: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                991: {
                    slidesPerView: 2,
                },
                1200: {
                    slidesPerView: 3,
                },
                1400: {
                    slidesPerView: 3,
                },
                1600: {
                    slidesPerView: 4,
                },
            }
        });
    }

    // Custom scrollbar styles for dark theme
    const customScrollbarCSS = `
        /* Main scrollbar styling */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #000000;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: #333333;
            border-radius: 4px;
            border: 1px solid #111111;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }

        ::-webkit-scrollbar-corner {
            background: #000000;
        }

        /* Sidebar specific scrollbar */
        .d-sidebar::-webkit-scrollbar,
        .sidebar::-webkit-scrollbar,
        .sidebar-menu::-webkit-scrollbar {
            width: 6px;
        }

        .d-sidebar::-webkit-scrollbar-track,
        .sidebar::-webkit-scrollbar-track,
        .sidebar-menu::-webkit-scrollbar-track {
            background: #000000;
        }

        .d-sidebar::-webkit-scrollbar-thumb,
        .sidebar::-webkit-scrollbar-thumb,
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: #333333;
            border-radius: 3px;
        }

        .d-sidebar::-webkit-scrollbar-thumb:hover,
        .sidebar::-webkit-scrollbar-thumb:hover,
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: #555555;
        }

        /* Swiper scrollbar styling */
        .swiper-scrollbar {
            background: rgba(255, 255, 255, 0.1) !important;
            border-radius: 4px !important;
        }

        .swiper-scrollbar-drag {
            background: #fe710d !important;
            border-radius: 4px !important;
        }

        /* Firefox scrollbar */
        * {
            scrollbar-width: thin;
            scrollbar-color: #333333 #000000;
        }

        .d-sidebar,
        .sidebar,
        .sidebar-menu {
            scrollbar-width: thin;
            scrollbar-color: #333333 #000000;
        }

        /* Ensure sidebar scrolling works */
        .d-sidebar,
        .sidebar {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            max-height: 100vh !important;
        }

        .sidebar-menu {
            overflow-y: auto !important;
            overflow-x: hidden !important;
            max-height: calc(100vh - 100px) !important;
        }
    `;

    // Inject custom CSS
    const styleSheet = document.createElement("style");
    styleSheet.textContent = customScrollbarCSS;
    document.head.appendChild(styleSheet);

    // Fix sidebar scrolling if needed
    const sidebar = document.querySelector('.d-sidebar') || document.querySelector('.sidebar');
    if (sidebar) {
        sidebar.style.overflowY = 'auto';
        sidebar.style.overflowX = 'hidden';
        sidebar.style.maxHeight = '100vh';

        const sidebarMenu = sidebar.querySelector('.sidebar-menu') || sidebar.querySelector('[class*="menu"]');
        if (sidebarMenu) {
            sidebarMenu.style.overflowY = 'auto';
            sidebarMenu.style.overflowX = 'hidden';
            sidebarMenu.style.maxHeight = 'calc(100vh - 100px)';
        }
    }

}())