<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <?= lang('purchases') ?: 'Achats' ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?= $warehouse_id ? $warehouse->name : lang('all_warehouses') ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Consultez et gérez l'ensemble des achats fournisseurs</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('purchases') ?: 'Achats' ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('purchases/add') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_purchase') ?: 'Nouvel achat' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
            <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#" id="combine" data-action="combine">
            <i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i><?= lang('combine_to_pdf') ?: 'PDF groupé' ?>
          </a>
        </li>
        <?php if (!empty($warehouses)): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?= lang('warehouses') ?: 'Entrepôts' ?></h6></li>
        <li>
          <a class="dropdown-item" href="<?= admin_url('purchases') ?>">
            <i class="ri ri-building-line me-2" style="font-size:14px"></i><?= lang('all_warehouses') ?: 'Tous' ?>
          </a>
        </li>
        <?php foreach ($warehouses as $wh): ?>
        <li>
          <a class="dropdown-item<?= ($warehouse_id == $wh->id ? ' active' : '') ?>" href="<?= admin_url('purchases/' . $wh->id) ?>">
            <i class="ri ri-building-4-line me-2" style="font-size:14px"></i><?= $wh->name ?>
          </a>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger bpo" href="#"
             title="<b><?= lang('delete_purchases') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_purchases') ?: 'Supprimer' ?>
          </a>
        </li>
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
              <p class="mb-1 text-muted">Total achats</p>
              <h4 class="mb-1"><?= number_format($stats->total_purchases) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">commandes</span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-primary">
                <i class="ri ri-store-2-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Montant total</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_amount) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">tous achats</span></p>
            </div>
            <div class="avatar me-lg-6">
              <span class="avatar-initial rounded-3 bg-label-warning">
                <i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">En attente</p>
              <h4 class="mb-1 <?= $stats->pending > 0 ? 'text-warning' : '' ?>"><?= number_format($stats->pending) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">paiement en attente</span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-warning">
                <i class="ri ri-time-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Crédit fournisseur</p>
              <h4 class="mb-1 <?= $stats->credit > 0 ? 'text-danger' : '' ?>"><?= $this->sma->formatMoney($stats->credit) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-danger">restant dû</span></p>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded-3 bg-label-danger">
                <i class="ri ri-bank-card-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('purchases/purchase_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE ACHATS -->
<div class="card">

  <!-- card-header : filtres -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterPurchaseStatus" class="form-select">
          <option value="">Tout statut achat</option>
          <?php foreach ($statuses_purchase as $key => $label): ?>
            <option value="<?= htmlspecialchars($label, ENT_QUOTES) ?>"><?= htmlspecialchars($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterPaymentStatus" class="form-select">
          <option value="">Tout statut paiement</option>
          <?php foreach ($statuses_payment as $key => $label): ?>
            <option value="<?= htmlspecialchars($label, ENT_QUOTES) ?>"><?= htmlspecialchars($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterSupplier" class="form-select">
          <option value="">Tous fournisseurs</option>
          <?php if (!empty($suppliers)) foreach ($suppliers as $s): ?>
            <option value="<?= htmlspecialchars($s->company ?: ($s->name ?? ''), ENT_QUOTES) ?>"><?= htmlspecialchars($s->company ?: ($s->name ?? '')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir l'achat
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="POData" class="datatables-order table table-hover" aria-label="<?= lang('purchases') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('ref_no') ?></th>
          <th><?= lang('supplier') ?></th>
          <th><?= lang('purchase_status') ?></th>
          <th class="text-end"><?= lang('grand_total') ?></th>
          <th class="text-end"><?= lang('paid') ?></th>
          <th class="text-end"><?= lang('balance') ?></th>
          <th><?= lang('payment_status') ?></th>
          <th style="width:30px; text-align:center;"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="11" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-po-total">0</th>
          <th class="text-end" id="ft-po-paid">0</th>
          <th class="text-end" id="ft-po-balance">0</th>
          <th></th>
          <th></th>
          <th></th>
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
    if (s.indexOf('received') === 0 || s === 'paid' || s === 'payé') color = 'success';
    else if (s === 'pending' || s.indexOf('attent') === 0 || s === 'ordered') color = 'warning';
    else if (s === 'partial' || s.indexOf('partiel') === 0) color = 'info';
    else if (s === 'due' || s === 'returned' || s.indexOf('retour') === 0) color = 'danger';
    return '<span class="badge rounded-pill bg-label-' + color + '">' + status + '</span>';
  }

  function renderRef(data) {
    if (!data) return '';
    return '<span class="fw-semibold text-primary">' + data + '</span>';
  }

  function renderSupplier(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var initial = data.toString().substring(0, 2).toUpperCase();
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    var color = colors[idx];
    return '<div class="d-flex justify-content-start align-items-center">' +
             '<div class="avatar-wrapper me-3">' +
               '<div class="avatar rounded-2 bg-label-' + color + '">' +
                 '<span class="avatar-initial rounded-2">' + initial + '</span>' +
               '</div>' +
             '</div>' +
             '<span class="text-truncate">' + data + '</span>' +
           '</div>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('purchases/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" title="<?= lang('edit') ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">' +
                 '<i class="ri ri-more-2-line" style="font-size:20px"></i>' +
               '</button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('purchases/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('purchases/pdf') ?>/' + id + '"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i>PDF</a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('purchases/payments') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal2"><i class="ri ri-money-dollar-circle-line me-2" style="font-size:14px"></i><?= lang('payments') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('purchases/return_purchase') ?>/' + id + '"><i class="ri ri-arrow-go-back-line me-2" style="font-size:14px"></i>Retour</a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#POData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('purchases/getPurchases' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"mRender": typeof fld === 'function' ? fld : null},
        {"mRender": renderRef},
        {"mRender": renderSupplier},
        {"mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; }},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; }},
        {"bSortable": false, "mRender": typeof attachment === 'function' ? attachment : null},
        {"bSortable": false, "mRender": renderActions}
      ],
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "purchase_link";
        return nRow;
      },
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var total = 0, paid = 0, balance = 0;
        for (var i = 0; i < aaData.length; i++) {
          total   += parseFloat(aaData[aiDisplay[i]][5]) || 0;
          paid    += parseFloat(aaData[aiDisplay[i]][6]) || 0;
          balance += parseFloat(aaData[aiDisplay[i]][7]) || 0;
        }
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-po-total').html(fmt(total));
        $('#ft-po-paid').html(fmt(paid));
        $('#ft-po-balance').html(fmt(balance));
      }
    }).fnSetFilteringDelay();

    $('#filterPurchaseStatus').on('change', function () { $('#POData').dataTable().fnFilter($(this).val(), 4, false, false, true); });
    $('#filterPaymentStatus').on('change', function () { $('#POData').dataTable().fnFilter($(this).val(), 8, false, false, true); });
    $('#filterSupplier').on('change', function () { $('#POData').dataTable().fnFilter($(this).val(), 3, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#POData').dataTable().fnFilter($(this).val()); });

    <?php if ($this->session->userdata('remove_pols')) { ?>
    var poKeys = ['poitems','podiscount','potax2','poshipping','poref','powarehouse','ponote','posupplier','pocurrency','poextras','podate','postatus','popayment_term'];
    poKeys.forEach(function(k){ if(localStorage.getItem(k)) localStorage.removeItem(k); });
    <?php $this->sma->unset_data('remove_pols'); } ?>
  });
})();
</script>
