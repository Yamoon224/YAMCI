<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-exchange-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('transfers') ?: 'Transferts' ?></h4>
    <p class="mb-0 text-muted">Gérez les transferts de stock entre entrepôts</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('transfers') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <?php if ($Owner || ($GP && $GP['transfers-add'])): ?>
    <a href="<?= admin_url('transfers/add') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_transfer') ?: 'Nouveau transfert' ?>
    </a>
    <?php endif; ?>
    <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel">
          <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?>
        </a></li>
        <li><a class="dropdown-item" href="#" id="combine" data-action="combine">
          <i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i><?= lang('combine_to_pdf') ?: 'PDF groupé' ?>
        </a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger bpo"
             title="<b><?= lang('delete_transfers') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
          <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_transfers') ?: 'Supprimer' ?>
        </a></li>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- STATS WIDGETS -->
<div class="card mb-6">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Total transferts</p>
              <h4 class="mb-1"><?= number_format($stats->total ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">tous</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-primary"><i class="ri ri-exchange-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Validés</p>
              <h4 class="mb-1 text-success"><?= number_format($stats->completed ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success">terminés</span></p>
            </div>
            <div class="avatar me-lg-6"><span class="avatar-initial rounded-3 bg-label-success"><i class="ri ri-check-double-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">En attente</p>
              <h4 class="mb-1 <?= ($stats->pending ?? 0) > 0 ? 'text-warning' : '' ?>"><?= number_format($stats->pending ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">en cours</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-warning"><i class="ri ri-time-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Valeur totale</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_amount ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-info">cumulé</span></p>
            </div>
            <div class="avatar"><span class="avatar-initial rounded-3 bg-label-info"><i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('transfers/transfer_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE TRANSFERTS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterFromWarehouse" class="form-select">
          <option value="">Tout entrepôt source</option>
          <?php if (!empty($warehouses_list)) foreach ($warehouses_list as $w): ?>
            <option value="<?= htmlspecialchars($w->name, ENT_QUOTES) ?>"><?= htmlspecialchars($w->name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterToWarehouse" class="form-select">
          <option value="">Tout entrepôt destination</option>
          <?php if (!empty($warehouses_list)) foreach ($warehouses_list as $w): ?>
            <option value="<?= htmlspecialchars($w->name, ENT_QUOTES) ?>"><?= htmlspecialchars($w->name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterStatus" class="form-select">
          <option value="">Tout statut</option>
          <option value="completed">Validé</option>
          <option value="pending">En attente</option>
          <option value="sent">Envoyé</option>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar : custom search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir le transfert
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="TOData" class="datatables-transfers table table-hover" aria-label="<?= lang('transfers') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('ref_no') ?></th>
          <th><?= lang('warehouse') . ' (' . lang('from') . ')' ?></th>
          <th><?= lang('warehouse') . ' (' . lang('to') . ')' ?></th>
          <th class="text-end"><?= lang('total') ?></th>
          <th class="text-end"><?= lang('product_tax') ?></th>
          <th class="text-end"><?= lang('grand_total') ?></th>
          <th><?= lang('status') ?></th>
          <th style="width:30px; text-align:center;"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="11" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?: 'Chargement…' ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th><th></th><th></th><th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-to-total">0</th>
          <th class="text-end" id="ft-to-tax">0</th>
          <th class="text-end" id="ft-to-gtotal">0</th>
          <th></th><th></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) { ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php } ?>

<script>
(function () {
  'use strict';
  var oTable;

  function statusBadge(status) {
    if (!status) return '<span class="text-muted">—</span>';
    var s = String(status).toLowerCase();
    var color = 'secondary';
    if (s.indexOf('compl') === 0 || s === 'sent' || s === 'received') color = 'success';
    else if (s === 'pending' || s.indexOf('attent') === 0) color = 'warning';
    else if (s === 'partial') color = 'info';
    return '<span class="badge rounded-pill bg-label-' + color + '">' + status + '</span>';
  }

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderWarehouse(data) {
    if (!data) return '<span class="text-muted">—</span>';
    return '<span class="d-inline-flex align-items-center"><i class="ri ri-building-4-line me-1 text-muted" style="font-size:14px"></i>' + data + '</span>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('transfers/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" title="<?= lang('edit') ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('transfers/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('transfers/pdf') ?>/' + id + '"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i>PDF</a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#TOData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('transfers/getTransfers') ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"mRender": typeof fld === 'function' ? fld : null},
        {"mRender": renderRef},
        {"mRender": function(d, t){ return t === 'display' ? renderWarehouse(d) : (d || ''); }},
        {"mRender": function(d, t){ return t === 'display' ? renderWarehouse(d) : (d || ''); }},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; }},
        {"bSortable": false, "mRender": typeof attachment === 'function' ? attachment : null},
        {"bSortable": false, "mRender": renderActions}
      ],
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "transfer_link";
        return nRow;
      },
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var total = 0, tax = 0, gtotal = 0;
        for (var i = 0; i < aaData.length; i++) {
          total  += parseFloat(aaData[aiDisplay[i]][5]) || 0;
          tax    += parseFloat(aaData[aiDisplay[i]][6]) || 0;
          gtotal += parseFloat(aaData[aiDisplay[i]][7]) || 0;
        }
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-to-total').html(fmt(total));
        $('#ft-to-tax').html(fmt(tax));
        $('#ft-to-gtotal').html(fmt(gtotal));
      }
    }).fnSetFilteringDelay();

    $('#filterFromWarehouse').on('change', function () { $('#TOData').dataTable().fnFilter($(this).val(), 3, false, false, true); });
    $('#filterToWarehouse').on('change', function ()   { $('#TOData').dataTable().fnFilter($(this).val(), 4, false, false, true); });
    $('#filterStatus').on('change', function ()        { $('#TOData').dataTable().fnFilter($(this).val(), 8, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#TOData').dataTable().fnFilter($(this).val()); });
  });
})();
</script>
