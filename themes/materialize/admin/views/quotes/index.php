<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <?= lang('quotes') ?: 'Devis' ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?= $warehouse_id ? $warehouse->name : lang('all_warehouses') ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Gérez les devis émis pour vos clients</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('quotes') ?: 'Devis' ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <?php if ($Owner || ($GP && $GP['quotes-add'])): ?>
    <a href="<?= admin_url('quotes/add') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_quote') ?: 'Nouveau devis' ?>
    </a>
    <?php endif; ?>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?></a></li>
        <li><a class="dropdown-item" href="#" id="combine" data-action="combine"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i><?= lang('combine_to_pdf') ?: 'PDF groupé' ?></a></li>
        <?php if (!empty($warehouses)): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?= lang('warehouses') ?></h6></li>
        <li><a class="dropdown-item" href="<?= admin_url('quotes') ?>"><i class="ri ri-building-line me-2" style="font-size:14px"></i><?= lang('all_warehouses') ?></a></li>
        <?php foreach ($warehouses as $wh): ?>
        <li><a class="dropdown-item<?= ($warehouse_id == $wh->id ? ' active' : '') ?>" href="<?= admin_url('quotes/' . $wh->id) ?>"><i class="ri ri-building-4-line me-2" style="font-size:14px"></i><?= $wh->name ?></a></li>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger bpo" href="#"
               title="<b><?= lang('delete_quotes') ?></b>"
               data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
               data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_quotes') ?>
        </a></li>
        <?php endif; ?>
      </ul>
    </div>
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
              <p class="mb-1 text-muted">Total devis</p>
              <h4 class="mb-1"><?= number_format($stats->total_quotes) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">émis</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-primary"><i class="ri ri-file-list-3-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Montant total</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_amount) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success">cumulé</span></p>
            </div>
            <div class="avatar me-lg-6"><span class="avatar-initial rounded-3 bg-label-success"><i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">En attente</p>
              <h4 class="mb-1 <?= $stats->pending > 0 ? 'text-warning' : '' ?>"><?= number_format($stats->pending) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">à traiter</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-warning"><i class="ri ri-time-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Validés</p>
              <h4 class="mb-1 text-success"><?= number_format($stats->completed) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success">acceptés</span></p>
            </div>
            <div class="avatar"><span class="avatar-initial rounded-3 bg-label-success"><i class="ri ri-checkbox-circle-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('quotes/quote_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE DEVIS -->
<div class="card">

  <!-- card-header : filtres -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterStatus" class="form-select">
          <option value="">Tout statut</option>
          <?php foreach ($statuses as $key => $label): ?>
            <option value="<?= htmlspecialchars($label, ENT_QUOTES) ?>"><?= htmlspecialchars($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterCustomer" class="form-select">
          <option value="">Tous clients</option>
          <?php if (!empty($customers)) foreach ($customers as $c): ?>
            <option value="<?= htmlspecialchars($c->company ?: ($c->name ?? ''), ENT_QUOTES) ?>"><?= htmlspecialchars($c->company ?: ($c->name ?? '')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterBiller" class="form-select">
          <option value="">Tous facturiers</option>
          <?php if (!empty($billers)) foreach ($billers as $b): ?>
            <option value="<?= htmlspecialchars($b->company ?: ($b->name ?? ''), ENT_QUOTES) ?>"><?= htmlspecialchars($b->company ?: ($b->name ?? '')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir le devis
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="QUData" class="datatables-order table table-hover" aria-label="<?= lang('quotes') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('reference_no') ?></th>
          <th><?= lang('biller') ?></th>
          <th><?= lang('customer') ?></th>
          <th><?= lang('warehouse') ?></th>
          <th class="text-end"><?= lang('total') ?></th>
          <th class="text-end"><?= lang('grand_total') ?></th>
          <th><?= lang('payment_status') ?></th>
          <th><?= lang('status') ?></th>
          <th style="width:30px; text-align:center;"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="12" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data') ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th><th></th><th></th><th></th><th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-qu-total">0</th>
          <th class="text-end" id="ft-qu-gtotal">0</th>
          <th></th><th></th><th></th><th></th>
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
    if (s.indexOf('compl') === 0 || s === 'sent' || s === 'paid' || s === 'payé') color = 'success';
    else if (s === 'pending' || s.indexOf('attent') === 0) color = 'warning';
    else if (s === 'partial' || s.indexOf('partiel') === 0) color = 'info';
    else if (s === 'due' || s === 'returned') color = 'danger';
    return '<span class="badge rounded-pill bg-label-' + color + '">' + status + '</span>';
  }

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderName(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var initial = data.toString().substring(0, 2).toUpperCase();
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    return '<div class="d-flex align-items-center"><div class="avatar-wrapper me-2"><div class="avatar rounded-2 bg-label-' + colors[idx] + '"><span class="avatar-initial rounded-2">' + initial + '</span></div></div><span class="text-truncate">' + data + '</span></div>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('quotes/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" title="<?= lang('edit') ?>"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('quotes/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('quotes/pdf') ?>/' + id + '"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i>PDF</a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('sales/add?quote=') ?>' + id + '"><i class="ri ri-exchange-line me-2" style="font-size:14px"></i>Convertir en vente</a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#QUData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      "bProcessing": true, "bServerSide": true,
      "sAjaxSource": "<?= admin_url('quotes/getQuotes' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "fnRowCallback": function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "quote_link";
        return nRow;
      },
      "aoColumns": [
        { "bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; } },
        { "mRender": typeof fld === 'function' ? fld : null },
        { "mRender": renderRef },
        null,
        { "mRender": renderName },
        null,
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; } },
        { "mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; } },
        { "bSortable": false, "mRender": typeof attachment2 === 'function' ? attachment2 : (typeof attachment === 'function' ? attachment : null) },
        { "bSortable": false, "mRender": renderActions }
      ],
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var total = 0, gtotal = 0;
        for (var i = 0; i < aaData.length; i++) {
          total  += parseFloat(aaData[aiDisplay[i]][6]) || 0;
          gtotal += parseFloat(aaData[aiDisplay[i]][7]) || 0;
        }
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-qu-total').html(fmt(total));
        $('#ft-qu-gtotal').html(fmt(gtotal));
      }
    }).fnSetFilteringDelay();

    $('#filterStatus').on('change', function () { $('#QUData').dataTable().fnFilter($(this).val(), 9, false, false, true); });
    $('#filterCustomer').on('change', function () { $('#QUData').dataTable().fnFilter($(this).val(), 4, false, false, true); });
    $('#filterBiller').on('change', function () { $('#QUData').dataTable().fnFilter($(this).val(), 3, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#QUData').dataTable().fnFilter($(this).val()); });

    <?php if ($this->session->userdata('remove_quls')) { ?>
    var quKeys = ['quitems','qudiscount','qutax2','qushipping','quref','quwarehouse','qunote','qusupplier','qucustomer','qubiller','qucurrency','qudate','qustatus'];
    quKeys.forEach(function (k) { if (localStorage.getItem(k)) localStorage.removeItem(k); });
    <?php $this->sma->unset_data('remove_quls'); } ?>
  });
})();
</script>
