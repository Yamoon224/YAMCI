/**
 * menu-init.js — SMA Materialize menu & layout initialization
 * Extracted from Pixinvent main.js — only the parts needed for the SMA admin.
 * Must be loaded AFTER: helpers.js, menu.js, bootstrap.js, popper.js
 */
(function () {
  'use strict';

  window.isRtl        = window.Helpers.isRtl();
  window.isDarkStyle  = window.Helpers.isDarkStyle();

  var menu = null;
  var isHorizontalLayout = document.getElementById('layout-menu') &&
    document.getElementById('layout-menu').classList.contains('menu-horizontal');

  /* ── 1. Menu accordion & scroll ───────────────────────────────────────── */
  document.querySelectorAll('#layout-menu').forEach(function (el) {
    menu = new Menu(el, {
      orientation:         isHorizontalLayout ? 'horizontal' : 'vertical',
      closeChildren:       !!isHorizontalLayout,
      showDropdownOnHover: false
    });
    window.Helpers.scrollToActive(false);
    window.Helpers.mainMenu = menu;
  });

  /* ── 2. Sidebar collapse toggle ───────────────────────────────────────── */
  document.querySelectorAll('.layout-menu-toggle').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      window.Helpers.toggleCollapsed();
      if (window.config && window.config.enableMenuLocalStorage && !window.Helpers.isSmallScreen() && window.templateName) {
        try {
          localStorage.setItem(
            'templateCustomizer-' + window.templateName + '--LayoutCollapsed',
            String(window.Helpers.isCollapsed())
          );
        } catch (_) {}
      }
    });
  });

  /* ── 3. Mobile swipe-in / swipe-out ───────────────────────────────────── */
  window.Helpers.swipeIn('.drag-target', function () {
    window.Helpers.setCollapsed(false);
  });
  window.Helpers.swipeOut('#layout-menu', function () {
    if (window.Helpers.isSmallScreen()) {
      window.Helpers.setCollapsed(true);
    }
  });

  /* ── 4. Layout overlay tap (mobile close) ─────────────────────────────── */
  var overlay = document.querySelector('.layout-overlay');
  if (overlay) {
    overlay.addEventListener('click', function () {
      window.Helpers.setCollapsed(true);
    });
  }

  /* ── 5. Scroll-state class on layout page ─────────────────────────────── */
  function updateScrollState() {
    var lp = document.querySelector('.layout-page');
    if (lp) {
      window.scrollY > 0
        ? lp.classList.add('window-scrolled')
        : lp.classList.remove('window-scrolled');
    }
  }
  setTimeout(updateScrollState, 200);
  window.addEventListener('scroll', updateScrollState);

  /* ── 6. Restore collapse state from localStorage ─────────────────────── */
  if (!isHorizontalLayout && !window.Helpers.isSmallScreen()) {
    var storedCollapsed = localStorage.getItem(
      'templateCustomizer-' + window.templateName + '--LayoutCollapsed'
    );
    if (storedCollapsed !== null) {
      window.Helpers.setCollapsed(storedCollapsed === 'true', false);
    }
  }

  /* ── 7. Auto-update layout on resize ─────────────────────────────────── */
  window.Helpers.setAutoUpdate(true);

  /* ── 8. Password toggle (login / profile forms) ──────────────────────── */
  window.Helpers.initPasswordToggle();

  /* ── 9. Navbar dropdown scrollbar ────────────────────────────────────── */
  window.Helpers.initNavbarDropdownScrollbar();

  /* ── 10. Semi-dark sidebar if preference stored ──────────────────────── */
  var semiDarkKey = 'templateCustomizer-' + window.templateName + '--SemiDark';
  if (localStorage.getItem(semiDarkKey) === 'true') {
    var lm = document.querySelector('#layout-menu');
    if (lm) { lm.setAttribute('data-bs-theme', 'dark'); }
  }

  /* ── 11. Tooltips ────────────────────────────────────────────────────── */
  document.addEventListener('DOMContentLoaded', function () {
    [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).forEach(function (el) {
      new bootstrap.Tooltip(el);
    });
  });

}());
