<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-gift-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('gift_cards') ?: 'Cartes cadeaux' ?></h4>
    <p class="mb-0 text-muted">Gérez les cartes cadeaux et leurs soldes</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('sales') ?>"><?= lang('sales') ?></a></li>
        <li class="breadcrumb-item active"><?= lang('gift_cards') ?: 'Cartes cadeaux' ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('sales/add_gift_card') ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_gift_card') ?: 'Nouvelle carte' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="btn-excel-gc"><i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?></a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="#" id="btn-delete-gc"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_gift_cards') ?: 'Supprimer' ?></a></li>
      </ul>
    </div>
  </div>
</div>

<?= admin_form_open('sales/gift_card_actions', 'id="action-form"') ?>

<!-- CARTE LISTE GIFT CARDS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-12">
        <select id="filterGcStatus" class="form-select">
          <option value="">Tout statut</option>
          <option value="active"><?= lang('active') ?: 'Active' ?></option>
          <option value="empty"><?= lang('empty') ?: 'Vide' ?></option>
          <option value="expired"><?= lang('expired') ?: 'Expirée' ?></option>
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
    <table id="GCData" class="datatables-giftcards table table-hover" aria-label="<?= lang('gift_cards') ?>">
      <thead>
        <tr>
          <th style="width:32px; text-align:center;">
            <input class="form-check-input checkth" type="checkbox" name="check" />
          </th>
          <th><?= lang('card_no') ?: 'N° carte' ?></th>
          <th class="text-end"><?= lang('value') ?: 'Valeur' ?></th>
          <th class="text-end"><?= lang('balance') ?: 'Solde' ?></th>
          <th><?= lang('created_by') ?: 'Créée par' ?></th>
          <th><?= lang('customer') ?></th>
          <th><?= lang('expiry') ?: 'Expiration' ?></th>
          <th><?= lang('status') ?></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="9" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>

<script>
(function () {
  'use strict';
  var gcStatusLabels = <?= json_encode(['active'=>lang('active'),'expired'=>lang('expired'),'empty'=>lang('empty')]); ?>;

  function gcStatus(x) {
    if (x == 'active')  return '<span class="badge rounded-pill bg-label-success">' + (gcStatusLabels[x] || x) + '</span>';
    if (x == 'expired') return '<span class="badge rounded-pill bg-label-danger">'  + (gcStatusLabels[x] || x) + '</span>';
    if (x == 'empty')   return '<span class="badge rounded-pill bg-label-warning">' + (gcStatusLabels[x] || x) + '</span>';
    return '<span class="badge rounded-pill bg-label-secondary">' + (x || '—') + '</span>';
  }

  function renderCardNo(d) { return d ? '<span class="fw-semibold text-primary font-monospace">' + d + '</span>' : ''; }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('sales/edit_gift_card') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('sales/view_gift_card') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('sales/topup_gift_card') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-wallet-3-line me-2" style="font-size:14px"></i><?= lang('topup_gift_card') ?: 'Recharger' ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    var gcTable = $('#GCData').dataTable({
      "aaSorting": [[3, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('sales/getGiftCards') ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"mRender": renderCardNo},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        null,
        null,
        {"mRender": typeof fsd === 'function' ? fsd : null},
        {"mRender": function(d, t){ return t === 'display' ? gcStatus(d) : d; }},
        {"bSortable": false, "mRender": renderActions}
      ]
    });

    $('#filterGcStatus').on('change', function () { $('#GCData').dataTable().fnFilter($(this).val(), 7, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#GCData').dataTable().fnFilter($(this).val()); });

    $(document).on('click', '#btn-delete-gc', function (e) { e.preventDefault(); $('#form_action').val('delete'); $('#action-form-submit').trigger('click'); });
    $(document).on('click', '#btn-excel-gc', function (e) { e.preventDefault(); $('#form_action').val('export_excel'); $('#action-form-submit').trigger('click'); });
  });
})();
</script>
