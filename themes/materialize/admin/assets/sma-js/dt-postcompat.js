/**
 * dt-postcompat.js — DataTables post-init compatibility fix for SMA
 * Loaded AFTER custom.js to override the Bootstrap 3 defaults set by it.
 *
 * custom.js sets:
 *   sDom: "..." (BS3)        → replaced with dom: "..." (BS5)
 *   sPaginationType:"bootstrap" (BS3) → replaced with pagingType:"simple_numbers"
 *   fnDrawCallback with iCheck/tooltip → made safe for BS5
 *
 * The old pagination extension ($.fn.dataTableExt.oPagination.bootstrap)
 * is left intact but we override the default pagingType so it's not used
 * by default. Individual tables can still opt-in if needed.
 */
(function ($) {
  'use strict';

  if (typeof $.fn.dataTable === 'undefined') return;

  /* ── Override unsafe defaults set by custom.js ──────────────────────── */
  $.extend(true, $.fn.dataTable.defaults, {
    /* Modern DataTables 1.10+ dom string:
       l = length control, f = filter, t = table,
       i = info, p = pagination */
    dom: "<'dt-toolbar d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-bottom gap-3'<'dt-toolbar-length'l><'dt-toolbar-search'f>>" +
         "<'dt-table-wrap'tr>" +
         "<'dt-footer d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top gap-3'<'dt-footer-info small'i><'dt-footer-pagination'p>>",

    /* Use built-in pagination — "simple_numbers" is safe for both BS5
       and older themes; change to "full_numbers" for more controls */
    pagingType: "simple_numbers",

    /* Remove the old sDom / sPaginationType keys */
    sDom: undefined,
    sPaginationType: undefined,

    /* Safe fnDrawCallback: only run things that exist */
    fnDrawCallback: function () {
      /* Initialize tooltips (BS5 uses data-bs-toggle, not data-toggle) */
      if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
          if (!bootstrap.Tooltip.getInstance(el)) {
            new bootstrap.Tooltip(el);
          }
        });
      }
      /* Initialize popovers */
      if (typeof bootstrap !== 'undefined' && bootstrap.Popover) {
        document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
          if (!bootstrap.Popover.getInstance(el)) {
            new bootstrap.Popover(el);
          }
        });
      }
    }
  });

  /* ── Make the legacy Bootstrap 3 pagination type a no-op rather than
     crashing DataTables 1.13 when it tries to use fnInit/fnUpdate ──── */
  if ($.fn.dataTableExt && $.fn.dataTableExt.oPagination) {
    /* Replace the old bootstrap pagination renderer with a safe stub.
       DataTables 1.13 uses a completely different rendering API,
       so we just remove the bootstrap entry to avoid conflicts.
       DataTables will fall back to its own renderer. */
    delete $.fn.dataTableExt.oPagination.bootstrap;
  }

  /* ── Fix: restore oStdClasses without Bootstrap 3 classes ──────────── */
  if ($.fn.dataTableExt && $.fn.dataTableExt.oStdClasses) {
    /* custom.js sets sWrapper: "dataTables_wrapper form-inline"
       BS5 doesn't use form-inline; reset to safe default */
    $.fn.dataTableExt.oStdClasses.sWrapper = "dataTables_wrapper dt-bootstrap5";
  }

  /* ── Neutralize legacy Imperavi Redactor (bundled in custom.js) ───────
     Redactor was the old SMA rich-text editor. When initialized on a
     <textarea>, it wraps it in `.redactor_box` and creates a `<ul>` toolbar
     that — without the original Redactor CSS — collapses to a column of
     empty bullets. We override $.fn.redactor with a no-op AFTER custom.js
     has registered the real one, and clean up any boxes already on the page. */
  $.fn.redactor = function (action) {
    if (action === 'get') {
      return this.length ? this.first().val() : '';
    }
    return this;
  };

  $(function () {
    // Promote textareas back out of any .redactor_box wrappers that
    // already rendered before this script ran.
    $('.redactor_box').each(function () {
      var $box = $(this);
      var $ta  = $box.find('textarea').first();
      if ($ta.length) {
        $ta.addClass('form-control')
           .removeClass('redactor-source')
           .removeAttr('style')
           .css('min-height', '100px');
        $box.replaceWith($ta);
      } else {
        $box.remove();
      }
    });
    // Also remove any orphan toolbar UL that Redactor left behind.
    $('ul.redactor_toolbar, ul.redactor-toolbar').remove();
  });

}(jQuery));
