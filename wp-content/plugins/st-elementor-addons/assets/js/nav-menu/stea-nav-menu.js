document.addEventListener('DOMContentLoaded', function () {
    // Helper: Toggle class
    function toggleClass(el, className) {
        if (el.classList.contains(className)) {
            el.classList.remove(className);
        } else {
            el.classList.add(className);
        }
    }
  
    // Add responsive class to menu containers
    document.querySelectorAll('.stea-menu-container').forEach(function (container) {
        if (container.getAttribute('steam-dom-added') !== 'yes') {
            if (!container.closest('.elementor-widget-steam-nav-menu')) {
                const parent = container.closest('.steam-wid-con');
                if (parent) {
                    parent.classList.add('setam_menu_responsive_tablet');
                }
            }
            container.setAttribute('steam-dom-added', 'yes');
        }
    });
  
    // Toggle submenu on click
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.stea-dropdown-has > a');
        if (!link) return;
  
        const menuContainer = link.closest('.stea-navbar-nav, .steam-vertical-navbar-nav');
        const widgetContainer = link.closest('.steam-wid-con');
        const breakpoint = parseInt(widgetContainer?.dataset.responsiveBreakpoint || '0', 10);
        const isIconClick = e.target.classList.contains('stea-submenu-indicator');
        const isAboveBreakpoint = window.innerWidth > breakpoint;
        const clickOnIconOnly = menuContainer?.classList.contains('submenu-click-on-icon');
        const clickOnSetting = menuContainer?.classList.contains('submenu-click-on-');
  
        if ((!clickOnIconOnly || isIconClick) && (!isAboveBreakpoint || isIconClick)) {
            e.preventDefault();
  
            const submenu = link.parentElement.querySelector('.stea-dropdown, .stea-megamenu-panel');
            if (submenu) {
                submenu.querySelectorAll('.stea-dropdown-open').forEach(el => {
                    el.classList.remove('stea-dropdown-open');
                });
                toggleClass(submenu, 'stea-dropdown-open');
            }
        }
    });
  
    // Toggle off-canvas menu
    document.addEventListener('click', function (e) {
        const toggler = e.target.closest('.stea-menu-toggler');
        if (!toggler) return;
  
        e.preventDefault();
  
        let container = toggler.closest('.stea-menu-container')?.parentElement;
        if (!container) container = toggler.parentElement;
  
        const offcanvas = container.querySelector('.stea-menu-offcanvas-elements');
        if (offcanvas) {
            toggleClass(offcanvas, 'active');
        }
    });
  
    // Close menu on anchor click for one-page nav
    document.querySelectorAll('.stea-navbar-nav li a').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            const href = anchor.getAttribute('href');
            const target = e.target;
            const isIndicatorClick = target.classList.contains('stea-submenu-indicator');
            const isAnchorLink = href && href.includes('#');
            const isSamePath = anchor.pathname === window.location.pathname;
  
            const container = anchor.closest('.stea-menu-container');
            const isOnePage = container?.classList.contains('steam-nav-menu-one-page-yes');
  
            if (!isIndicatorClick && isAnchorLink && href.length > 1 && isOnePage && isSamePath) {
                const wrapper = anchor.closest('.steam-wid-con');
                const closeBtn = wrapper?.querySelector('.stea-menu-close');
                if (closeBtn) closeBtn.click();
            }
        });
    });
  });
  