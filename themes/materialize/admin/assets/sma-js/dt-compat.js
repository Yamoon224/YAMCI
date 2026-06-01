/**
 * dt-compat.js — DataTables 1.9 → 1.13+ / Select2 2.x → 4.x compatibility shim for SMA
 * Safe version: NO function wrapping, uses DataTables preInit event instead.
 */
(function ($) {
  'use strict';

  /* ── 0. Select2 2.x → 4.x backward-compat shim ─────────────────────── */
  /*
   * SMA's s2_lang.js was generated for Select2 2.x which had:
   *   $.fn.select2.locales['xx'] = {...}
   *   $.extend($.fn.select2.defaults, $.fn.select2.locales['xx'])
   * Select2 4.x removed both of these.  Create stubs so the generated
   * script doesn't crash with "Cannot set properties of undefined".
   */
  if (typeof $.fn.select2 !== 'undefined') {
    if (typeof $.fn.select2.locales === 'undefined') {
      $.fn.select2.locales = {};
    }
    /* $.fn.select2.defaults doesn't exist in 4.x; $.extend() on it would crash */
    if (typeof $.fn.select2.defaults === 'undefined') {
      $.fn.select2.defaults = {};
    }
  }

  if (typeof $.fn.dataTable === 'undefined') return;

  /* ── 1. Restore $.fn.dataTableExt.oApi ─────────────────────────────── */
  if ($.fn.dataTableExt && typeof $.fn.dataTableExt.oApi === 'undefined') {
    var _oApi = {};
    if (typeof Proxy !== 'undefined') {
      $.fn.dataTableExt.oApi = new Proxy(_oApi, {
        set: function (t, k, v) { t[k] = v; return true; },
        get: function (t, k)    { return t[k]; }
      });
    } else {
      $.fn.dataTableExt.oApi = _oApi;
    }
  }

  /* ── 2. Convert sAjaxSource/fnServerData via preInit event ──────────── */
  /*
   * DataTables 1.13 removed sAjaxSource and fnServerData.
   * We intercept at preInit, before the first draw, to inject the
   * modern ajax:{} configuration from the legacy options.
   */
  $(document).on('preInit.dt.smaCompat', function (e, settings) {
    var oInit = settings.oInit || {};

    /* Only if sAjaxSource is present (legacy server-side setup) */
    if (!oInit.sAjaxSource && !settings.sAjaxSource) return;

    var url          = oInit.sAjaxSource || settings.sAjaxSource;
    var fnServerData = oInit.fnServerData || settings.fnServerData;

    if (typeof fnServerData === 'function') {
      /* Wrap old-style fnServerData into DataTables 1.10+ ajax function */
      settings.ajax = function (data, callback /*, dtSettings */) {
        /* Convert new-style params object to old-style aoData array */
        var aoData = [];
        if (data && typeof data === 'object') {
          $.each(data, function (k, v) { aoData.push({ name: k, value: v }); });
        }

        fnServerData.call(this, url, aoData, function (json) {
          /* Translate old sEcho/aaData response to new draw/data format */
          if (json && typeof json.aaData !== 'undefined') {
            callback({
              draw:            parseInt(json.sEcho, 10) || 1,
              recordsTotal:    parseInt(json.iTotalRecords, 10)       || 0,
              recordsFiltered: parseInt(json.iTotalDisplayRecords, 10) || 0,
              data:            json.aaData
            });
          } else {
            callback(json);
          }
        }, settings);
      };
    } else {
      settings.ajax = {
        url:  url,
        type: 'POST',
        data: function (d) {
          var out = {
            sEcho:          d.draw || 1,
            iDisplayStart:  d.start || 0,
            iDisplayLength: d.length || 25,
            sSearch:        (d.search && d.search.value) || '',
            bEscapeRegex:   true,
            iSortingCols:   (d.order || []).length
          };
          (d.order || []).forEach(function (o, i) {
            out['iSortCol_' + i]  = o.column;
            out['sSortDir_' + i]  = o.dir;
          });
          if (typeof csrf_token_name !== 'undefined') {
            out[csrf_token_name] = csrf_token_value;
          }
          return out;
        },
        dataSrc: function (json) {
          if (json && typeof json.aaData !== 'undefined') return json.aaData;
          if (json && typeof json.data   !== 'undefined') return json.data;
          return [];
        }
      };
    }

    /* Clear the legacy keys so DataTables doesn't choke on them */
    settings.sAjaxSource  = null;
    settings.fnServerData = null;
    delete oInit.sAjaxSource;
    delete oInit.fnServerData;
  });

  /* ── 3. $.fn.fnSettings / $.fn.fnGetData — legacy jQuery shims ────────── */
  /*
   * DataTables 1.9 exposed .fnSettings() / .fnGetData() on the jQuery object.
   * DataTables 1.10+ moved to the DataTables API object ($.fn.DataTable()).
   * Many SMA view scripts call: oTable.fnSettings(), $(table).fnGetData(row), etc.
   */
  if (typeof $.fn.fnSettings === 'undefined') {
    $.fn.fnSettings = function () {
      try {
        var api = $(this).DataTable();
        return api.settings()[0] || null;
      } catch (e) { return null; }
    };
  }

  if (typeof $.fn.fnGetData === 'undefined') {
    $.fn.fnGetData = function (node) {
      try {
        return $(this).DataTable().row(node).data();
      } catch (e) { return null; }
    };
  }

  if (typeof $.fn.fnUpdate === 'undefined') {
    $.fn.fnUpdate = function (data, node, colIdx) {
      try {
        var api = $(this).DataTable();
        if (typeof colIdx !== 'undefined') {
          api.cell(node, colIdx).data(data).draw(false);
        } else {
          api.row(node).data(data).draw(false);
        }
      } catch (e) {}
      return this;
    };
  }

  if (typeof $.fn.fnDeleteRow === 'undefined') {
    $.fn.fnDeleteRow = function (node) {
      try { $(this).DataTable().row(node).remove().draw(false); } catch (e) {}
      return this;
    };
  }

  if (typeof $.fn.fnAddData === 'undefined') {
    $.fn.fnAddData = function (data) {
      try { $(this).DataTable().row.add(data).draw(false); } catch (e) {}
      return this;
    };
  }

  if (typeof $.fn.fnClearTable === 'undefined') {
    $.fn.fnClearTable = function () {
      try { $(this).DataTable().clear().draw(false); } catch (e) {}
      return this;
    };
  }

  if (typeof $.fn.fnDraw === 'undefined') {
    $.fn.fnDraw = function (complete) {
      try { $(this).DataTable().draw(complete === false ? false : undefined); } catch (e) {}
      return this;
    };
  }

  if (typeof $.fn.fnFilter === 'undefined') {
    $.fn.fnFilter = function (str, col) {
      try {
        var api = $(this).DataTable();
        if (typeof col !== 'undefined') {
          api.column(col).search(str).draw();
        } else {
          api.search(str).draw();
        }
      } catch (e) {}
      return this;
    };
  }

  /* ── 4. Translate legacy column/init options (DT 1.9 → DT 2.x) ─────────── */
  /*
   * DT 2.x removed all Hungarian notation from column defs.
   * We translate them in preInit before DT processes oInit.
   */
  $(document).on('preInit.dt.smaOptions', function (e, settings) {
    var oInit = settings.oInit || {};

    /* Top-level init option aliases */
    var topMap = {
      bProcessing:    'processing',
      bServerSide:    'serverSide',
      bPaginate:      'paging',
      bFilter:        'searching',
      bSort:          'ordering',
      bInfo:          'info',
      bLengthChange:  'lengthChange',
      bAutoWidth:     'autoWidth',
      bDeferRender:   'deferRender',
      bScrollCollapse:'scrollCollapse',
      bStateSave:     'stateSave',
      iDisplayLength: 'pageLength',
      aaSorting:      'order',
      aLengthMenu:    'lengthMenu',
      sScrollY:       'scrollY',
      sScrollX:       'scrollX',
      sDom:           'dom'        /* handled by postcompat override too */
    };
    $.each(topMap, function (old, neo) {
      if (typeof oInit[old] !== 'undefined' && typeof oInit[neo] === 'undefined') {
        oInit[neo] = oInit[old];
        delete oInit[old];
      }
    });

    /* Column definition aliases */
    var colMap = {
      mRender:    'render',
      mData:      'data',
      bSortable:  'orderable',
      bSearchable:'searchable',
      bVisible:   'visible',
      sTitle:     'title',
      sClass:     'className',
      sWidth:     'width',
      sType:      'type',
      sDefaultContent: 'defaultContent'
    };
    var cols = oInit.aoColumns || oInit.columns;
    if (Array.isArray(cols)) {
      cols.forEach(function (col) {
        if (!col) return;
        $.each(colMap, function (old, neo) {
          if (typeof col[old] !== 'undefined' && typeof col[neo] === 'undefined') {
            col[neo] = col[old];
            delete col[old];
          }
        });
      });
    }

    /* Normalise aoColumns → columns */
    if (Array.isArray(oInit.aoColumns) && !oInit.columns) {
      oInit.columns = oInit.aoColumns;
      delete oInit.aoColumns;
    }
  });

  /* ── 6. Wrap fnRowCallback / fnCreatedRow to guard oTable.fnSettings() ── */
  /*
   * Many SMA views do: oTable.fnSettings() inside fnRowCallback.
   * At the time fnRowCallback fires, oTable is still undefined
   * (the .dataTable() call hasn't returned yet).
   *
   * In preInit the user's oInit options haven't been applied to settings yet.
   * We replace the callback functions on oInit directly with safe wrapped
   * versions — DT will then register the safe versions normally.
   */
  $(document).on('preInit.dt.smaRowCb', function (e, settings) {
    var oInit = settings.oInit || {};

    /* Wrap fnRowCallback */
    if (typeof oInit.fnRowCallback === 'function') {
      (function (orig) {
        oInit.fnRowCallback = function (nRow, aData, iDisplayIndex) {
          try { return orig.call(this, nRow, aData, iDisplayIndex) || nRow; }
          catch (err) { return nRow; }
        };
      }(oInit.fnRowCallback));
    }

    /* Wrap fnCreatedRow */
    if (typeof oInit.fnCreatedRow === 'function') {
      (function (orig) {
        oInit.fnCreatedRow = function (nRow, aData, iDataIndex) {
          try { orig.call(this, nRow, aData, iDataIndex); } catch (err) {}
        };
      }(oInit.fnCreatedRow));
    }

    /* Wrap fnDrawCallback (per-table, not the defaults) */
    if (typeof oInit.fnDrawCallback === 'function') {
      (function (orig) {
        oInit.fnDrawCallback = function (oSettings) {
          try { orig.call(this, oSettings); } catch (err) {}
        };
      }(oInit.fnDrawCallback));
    }

    /* Wrap fnInitComplete */
    if (typeof oInit.fnInitComplete === 'function') {
      (function (orig) {
        oInit.fnInitComplete = function (oSettings, json) {
          try { orig.call(this, oSettings, json); } catch (err) {}
        };
      }(oInit.fnInitComplete));
    }
  });

  /* ── 7. $.fn.fnSetFilteringDelay ─────────────────────────────────────── */
  if (typeof $.fn.fnSetFilteringDelay === 'undefined') {
    $.fn.fnSetFilteringDelay = function (iDelay) {
      iDelay = (typeof iDelay === 'undefined') ? 250 : iDelay;
      return this.each(function () {
        var $tbl = $(this);
        setTimeout(function () {
          var $wrapper = $tbl.closest('.dataTables_wrapper');
          var $input   = $('input[type=search]', $wrapper);
          if (!$input.length) $input = $('div.dataTables_filter input', $wrapper);
          var tmr;
          $input.off('keyup.dtDelay input.dtDelay').on('keyup.dtDelay input.dtDelay', function () {
            clearTimeout(tmr);
            var val = this.value;
            tmr = setTimeout(function () {
              try { $tbl.DataTable().search(val).draw(); } catch (e) {}
            }, iDelay);
            return false;
          });
        }, 150);
      });
    };
  }

  /* ── 8. $.fn.dtFilter ────────────────────────────────────────────────── */
  if (typeof $.fn.dtFilter === 'undefined') {
    $.fn.dtFilter = function (opts) {
      opts = opts || [];
      return this.each(function () {
        var $table = $(this);
        var api;
        try { api = $table.DataTable(); } catch (e) { return; }
        var $tfoot = $table.find('tfoot');
        if (!$tfoot.length) {
          var n = $table.find('thead th').length;
          var h = '<tfoot><tr>';
          for (var i = 0; i < n; i++) h += '<td></td>';
          $table.append(h + '</tr></tfoot>');
          $tfoot = $table.find('tfoot');
        }
        var $cells = $tfoot.find('tr:first td, tr:first th');
        $.each(opts, function (_, opt) {
          var $c = $cells.eq(opt.column_number);
          if (!$c.length) return;
          if (opt.filter_type === 'select') {
            var $s = $('<select class="form-select form-select-sm"><option value="">' + (opt.filter_default_label || '') + '</option></select>');
            $.each(opt.data || [], function (_, item) {
              $s.append('<option value="' + item.value + '">' + item.label + '</option>');
            });
            $s.on('change', function () { api.column(opt.column_number).search($(this).val()).draw(); });
            $c.html($s);
          } else {
            var $i = $('<input type="text" class="form-control form-control-sm" placeholder="' + (opt.filter_default_label || '') + '">');
            var t;
            $i.on('keyup input', function () {
              clearTimeout(t); var v = this.value;
              t = setTimeout(function () { api.column(opt.column_number).search(v).draw(); }, 300);
            });
            $c.html($i);
          }
        });
      });
    };
  }

}(jQuery));
