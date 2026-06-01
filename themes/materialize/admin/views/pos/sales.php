<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-barcode-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('pos_sales') ?: 'Ventes POS' ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?= $warehouse_id ? $warehouse->name : lang('all_warehouses') ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Liste des ventes effectuées via la caisse POS</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Accueil</a></li>
        <li class="breadcrumb-item">POS</li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('sales') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('pos') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_sale') ?: 'Nouvelle vente POS' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?></a></li>
        <?php if (!empty($warehouses)): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?= lang('warehouses') ?></h6></li>
        <li><a class="dropdown-item<?= !$warehouse_id ? ' active' : '' ?>" href="<?= admin_url('pos/sales') ?>"><i class="ri ri-building-line me-2" style="font-size:14px"></i><?= lang('all_warehouses') ?></a></li>
        <?php foreach ($warehouses as $wh): ?>
        <li><a class="dropdown-item<?= $warehouse_id == $wh->id ? ' active' : '' ?>" href="<?= admin_url('pos/sales/' . $wh->id) ?>"><i class="ri ri-building-4-line me-2" style="font-size:14px"></i><?= $wh->name ?></a></li>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="#" id="delete_pos_sales"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_sales') ?></a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])):
  echo admin_form_open('sales/sale_actions', 'id="action-form"');
endif; ?>

<!-- CARTE LISTE POS SALES -->
<div class="card">

  <!-- toolbar : custom search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir le reçu
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="POSData" class="datatables-pos table table-hover" aria-label="<?= lang('pos_sales') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('reference_no') ?></th>
          <th><?= lang('biller') ?></th>
          <th><?= lang('customer') ?></th>
          <th class="text-end"><?= lang('grand_total') ?></th>
          <th class="text-end"><?= lang('paid') ?></th>
          <th class="text-end"><?= lang('balance') ?></th>
          <th><?= lang('payment_status') ?></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="10" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data') ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th><th></th><th></th><th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-pos-total">0</th>
          <th class="text-end" id="ft-pos-paid">0</th>
          <th class="text-end" id="ft-pos-balance">0</th>
          <th></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php endif; ?>

<script>
(function () {
  'use strict';

  function balance(x, number) {
    if (!x) return number === 'number' ? 0 : '0.00';
    var b = x.split('__');
    var total = parseFloat(b[0]);
    var rounding = parseFloat(b[1]);
    var paid = parseFloat(b[2]);
    var bal = total + rounding - paid;
    return number === 'number' ? bal : (typeof currencyFormat === 'function' ? currencyFormat(bal) : bal.toFixed(2));
  }

  function statusBadge(status) {
    if (!status) return '<span class="text-muted">—</span>';
    var s = String(status).toLowerCase();
    var color = 'secondary';
    if (s.indexOf('paid') === 0 || s === 'payé') color = 'success';
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
    return '<div class="d-flex align-items-center"><div class="avatar-wrapper me-2"><div class="avatar avatar-sm rounded-circle bg-label-' + colors[idx] + '"><span class="avatar-initial rounded-circle">' + initial + '</span></div></div><span class="text-truncate">' + data + '</span></div>';
  }

  var oTable;
  $(document).ready(function () {
    oTable = $('#POSData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      "bProcessing": true, "bServerSide": true,
      "sAjaxSource": "<?= admin_url('pos/getSales' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "fnRowCallback": function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "receipt_link";
        return nRow;
      },
      "aoColumns": [
        { "bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; } },
        { "mRender": typeof fld === 'function' ? fld : null },
        { "mRender": renderRef },
        null,
        { "mRender": renderName },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": function (data, t) { return t === 'display' ? balance(data) : balance(data, 'number'); } },
        { "mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; } },
        { "bSortable": false }
      ],
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var gtotal = 0, paid = 0, bal = 0;
        for (var i = 0; i < aaData.length; i++) {
          gtotal += parseFloat(aaData[aiDisplay[i]][5]) || 0;
          paid   += parseFloat(aaData[aiDisplay[i]][6]) || 0;
          bal    += parseFloat(balance(aaData[aiDisplay[i]][7], 'number')) || 0;
        }
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-pos-total').html(fmt(gtotal));
        $('#ft-pos-paid').html(fmt(paid));
        $('#ft-pos-balance').html(fmt(bal));
      }
    }).fnSetFilteringDelay();

    $('#customDtSearch').on('keyup input', function () { $('#POSData').dataTable().fnFilter($(this).val()); });

    $(document).on('click', '.email_receipt', function (e) {
      e.preventDefault();
      var sid = $(this).attr('data-id');
      var ea = $(this).attr('data-email-address');
      if (typeof Swal !== 'undefined') {
        Swal.fire({
          title: '<?= lang('email_address') ?>',
          input: 'email',
          inputValue: ea,
          showCancelButton: true,
          confirmButtonText: '<?= lang('send') ?>'
        }).then(function (result) {
          if (result.value) {
            $.ajax({
              type: "post",
              url: "<?= admin_url('pos/email_receipt') ?>/" + sid,
              data: { <?= $this->security->get_csrf_token_name() ?>: "<?= $this->security->get_csrf_hash() ?>", email: result.value, id: sid },
              dataType: "json",
              success: function (data) { Swal.fire({ icon: 'success', title: data.msg, timer: 2500, showConfirmButton: false }); },
              error: function () { Swal.fire({ icon: 'error', title: '<?= lang('ajax_request_failed') ?>' }); }
            });
          }
        });
      }
    });
  });
})();
</script>
