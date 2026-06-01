/* main.js — Pixinvent template stub
 * The original Pixinvent main.js handles auto-initialization of UI plugins:
 *  - PerfectScrollbar on menus/dropdowns
 *  - Waves ripple on buttons
 *  - Vertical menu init
 *  - Theme color sync
 * SMA already loads these explicitly where needed, so this stub is enough to
 * prevent the 307 → SyntaxError("Unexpected token '<'") that was breaking the
 * console on every page.
 */
(function () {
  'use strict';

  // Re-init Helpers if needed (Helpers auto-init on load, but a safety call).
  if (window.Helpers && typeof window.Helpers.init === 'function') {
    try { window.Helpers.init(); } catch (e) {}
  }

  // Initialize Waves ripple if available.
  if (typeof window.Waves !== 'undefined') {
    try {
      window.Waves.init();
      window.Waves.attach('.btn[class*="btn-"]', ['waves-light']);
      window.Waves.attach('.pagination .page-item .page-link');
    } catch (e) {}
  }

  // Init password toggle (Helpers exposes this).
  // Init password toggle — guard against multiple executions (listeners would stack and cancel)
  // Init password toggle with deduplication: mark each icon to avoid stacking handlers
  if (window.Helpers && typeof window.Helpers.initPasswordToggle === 'function') {
    try {
      document.querySelectorAll('.form-password-toggle i:not([data-pw-toggle-bound])').forEach(function (icon) {
        icon.setAttribute('data-pw-toggle-bound', '1');
        icon.addEventListener('click', function (e) {
          e.stopPropagation();
          var wrapper = icon.closest('.form-password-toggle');
          var inp = wrapper ? wrapper.querySelector('input') : null;
          if (!inp) return;
          var isPassword = inp.getAttribute('type') === 'password';
          inp.setAttribute('type', isPassword ? 'text' : 'password');
          icon.classList.replace(isPassword ? 'ri-eye-off-line' : 'ri-eye-line', isPassword ? 'ri-eye-line' : 'ri-eye-off-line');
        });
      });
    } catch (e) {}
  }

  // Init sidebar toggle.
  if (window.Helpers && typeof window.Helpers.initSidebarToggle === 'function') {
    try { window.Helpers.initSidebarToggle(); } catch (e) {}
  }
})();
