<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-truck-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('deliveries') ?: 'Livraisons' ?></h4>
    <p class="mb-0 text-muted">Gérez les livraisons liées aux ventes</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('sales') ?>"><?= lang('sales') ?></a></li>
        <li class="breadcrumb-item active"><?= lang('deliveries') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('sales/add_delivery') ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_delivery') ?: 'Nouvelle livraison' ?>
    </a>
    <?php if ($Owner): ?>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="btn-excel-do"><i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?></a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="#" id="btn-delete-do"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_deliveries') ?></a></li>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</div>

<?php if ($Owner): echo admin_form_open('sales/delivery_actions', 'id="action-form"'); endif; ?>

<!-- CARTE LISTE LIVRAISONS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-12">
        <select id="filterDelivStatus" class="form-select">
          <option value="">Tout statut</option>
          <option value="packing"><?= lang('packing') ?: 'Emballage' ?></option>
          <option value="delivering"><?= lang('delivering') ?: 'En cours' ?></option>
          <option value="delivered"><?= lang('delivered') ?: 'Livré' ?></option>
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
      <?= lang('list_results') ?>
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="DOData" class="datatables-deliveries table table-hover" aria-label="<?= lang('deliveries') ?>">
      <thead>
        <tr>
          <th style="width:32px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('do_reference_no') ?: 'Référence' ?></th>
          <th><?= lang('sale_reference_no') ?: 'Réf. vente' ?></th>
          <th><?= lang('customer') ?></th>
          <th><?= lang('address') ?></th>
          <th><?= lang('status') ?></th>
          <th style="width:32px; text-align:center;"><i class="ri ri-links-line" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="9" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data') ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php if ($Owner): ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?= form_submit('perform_action', 'perform_action', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var dss = <?= json_encode(['packing'=>lang('packing'),'delivering'=>lang('delivering'),'delivered'=>lang('delivered')]); ?>;

  function ds(x) {
    if (x == 'delivered')  return '<span class="badge rounded-pill bg-label-success">' + (dss[x] || x) + '</span>';
    if (x == 'delivering') return '<span class="badge rounded-pill bg-label-info">'    + (dss[x] || x) + '</span>';
    if (x == 'packing')    return '<span class="badge rounded-pill bg-label-warning">' + (dss[x] || x) + '</span>';
    return '<span class="badge rounded-pill bg-label-secondary">' + (x || '—') + '</span>';
  }

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderCustomer(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var initial = data.toString().substring(0, 2).toUpperCase();
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    return '<div class="d-flex align-items-center"><div class="avatar-wrapper me-2"><div class="avatar avatar-sm rounded-circle bg-label-' + colors[idx] + '"><span class="avatar-initial rounded-circle">' + initial + '</span></div></div><span class="text-truncate">' + data + '</span></div>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('sales/edit_delivery') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('sales/view_delivery') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('sales/pdf_delivery') ?>/' + id + '"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i>PDF</a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    var doTable = $('#DOData').dataTable({
      "aaSorting": [[1, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('sales/getDeliveries') ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = 'delivery_link';
        return nRow;
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"mRender": typeof fld === 'function' ? fld : null},
        {"mRender": renderRef},
        {"mRender": renderRef},
        {"mRender": renderCustomer},
        null,
        {"mRender": function(d, t){ return t === 'display' ? ds(d) : d; }},
        {"bSortable": false, "mRender": typeof attachment2 === 'function' ? attachment2 : (typeof attachment === 'function' ? attachment : null)},
        {"bSortable": false, "mRender": renderActions}
      ]
    });

    $('#filterDelivStatus').on('change', function () { $('#DOData').dataTable().fnFilter($(this).val(), 6, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#DOData').dataTable().fnFilter($(this).val()); });

    <?php if ($Owner): ?>
    $(document).on('click', '#btn-delete-do', function (e) { e.preventDefault(); $('#form_action').val('delete'); $('#action-form-submit').trigger('click'); });
    $(document).on('click', '#btn-excel-do', function (e) { e.preventDefault(); $('#form_action').val('export_excel'); $('#action-form-submit').trigger('click'); });
    <?php endif; ?>
  });
})();
</script>
