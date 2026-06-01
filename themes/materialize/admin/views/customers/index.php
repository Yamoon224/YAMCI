<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-team-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('customers') ?: 'Clients' ?></h4>
    <p class="mb-0 text-muted">Gérez votre base clients, leurs paramètres et leurs dépôts</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('customers') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('customers/add') ?>" id="add" class="btn btn-primary"
       data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_customer') ?: 'Nouveau client' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="<?= admin_url('customers/import_csv') ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="ri ri-upload-2-line me-2" style="font-size:14px"></i><?= lang('import_by_csv') ?: 'Importer CSV' ?>
          </a>
        </li>
        <?php if ($Owner): ?>
        <li>
          <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
            <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?>
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger bpo"
             title="<b><?= lang('delete_customers') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_customers') ?: 'Supprimer' ?>
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
              <p class="mb-1 text-muted">Total clients</p>
              <h4 class="mb-1"><?= number_format($stats->total ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">tous</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-primary"><i class="ri ri-group-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Actifs</p>
              <h4 class="mb-1"><?= number_format($stats->active ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success">avec points</span></p>
            </div>
            <div class="avatar me-lg-6"><span class="avatar-initial rounded-3 bg-label-success"><i class="ri ri-user-star-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Avec dépôt</p>
              <h4 class="mb-1"><?= number_format($stats->with_deposit ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-info">solde positif</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-info"><i class="ri ri-wallet-3-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Total dépôts</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_deposit ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">cumulé</span></p>
            </div>
            <div class="avatar"><span class="avatar-initial rounded-3 bg-label-warning"><i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('customers/customer_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE CLIENTS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterCustomerGroup" class="form-select">
          <option value="">Tous groupes clients</option>
          <?php if (!empty($filter_customer_groups)) foreach ($filter_customer_groups as $cg): ?>
            <option value="<?= htmlspecialchars($cg->customer_group_name, ENT_QUOTES) ?>"><?= htmlspecialchars($cg->customer_group_name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterPriceGroup" class="form-select">
          <option value="">Tous groupes de prix</option>
          <?php if (!empty($filter_price_groups)) foreach ($filter_price_groups as $pg): ?>
            <option value="<?= htmlspecialchars($pg->price_group_name, ENT_QUOTES) ?>"><?= htmlspecialchars($pg->price_group_name) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterDeposit" class="form-select">
          <option value="">Tout statut dépôt</option>
          <option value="with">Avec dépôt</option>
          <option value="without">Sans dépôt</option>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar : search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir la fiche client
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="CusData" class="datatables-customers table table-hover" aria-label="<?= lang('customers') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkth" type="checkbox" name="check" />
          </th>
          <th style="display:none;">company</th>
          <th><?= lang('customer') ?: 'Client' ?></th>
          <th style="display:none;">email</th>
          <th><?= lang('phone') ?></th>
          <th><?= lang('price_group') ?></th>
          <th><?= lang('customer_group') ?></th>
          <th style="display:none;">vat</th>
          <th style="display:none;">gst</th>
          <th class="text-end"><?= lang('deposit') ?></th>
          <th class="text-end"><?= lang('award_points') ?></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="12" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?: 'Chargement…' ?>
          </td>
        </tr>
      </tbody>
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
  var cTable;

  /* ─── Renderer "Client" : avatar initiales + nom + email + société ─── */
  function renderCustomer(data, type, row) {
    if (type !== 'display') return row[2] || '';
    var company = row[1] || '';
    var name    = row[2] || '';
    var email   = row[3] || '';
    var label   = name || company || '—';
    var initials = label.toString().trim().split(/\s+/).map(function(p){ return p.charAt(0); }).slice(0,2).join('').toUpperCase() || '?';
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < label.length; i++) idx = (idx + label.charCodeAt(i)) % colors.length;
    var color = colors[idx];
    return '<div class="d-flex justify-content-start align-items-center customer-name">' +
             '<div class="avatar-wrapper me-3">' +
               '<div class="avatar rounded-circle bg-label-' + color + '">' +
                 '<span class="avatar-initial rounded-circle">' + initials + '</span>' +
               '</div>' +
             '</div>' +
             '<div class="d-flex flex-column">' +
               '<h6 class="text-nowrap mb-0">' + (name || '—') + '</h6>' +
               '<small class="text-muted">' + (company ? company + ' · ' : '') + (email || '') + '</small>' +
             '</div>' +
           '</div>';
  }

  /* ─── Renderer "Groupe" badge ─── */
  function renderGroupBadge(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var s = String(data).toLowerCase();
    var color = 'secondary';
    if (s.indexOf('vip') >= 0 || s.indexOf('premium') >= 0) color = 'warning';
    else if (s.indexOf('général') >= 0 || s.indexOf('general') >= 0 || s.indexOf('normal') >= 0) color = 'primary';
    else if (s.indexOf('gros') >= 0 || s.indexOf('whole') >= 0) color = 'info';
    return '<span class="badge rounded-pill bg-label-' + color + '">' + data + '</span>';
  }

  /* ─── Renderer "Dépôt" : montant + badge si > 0 ─── */
  function renderDeposit(data) {
    var v = parseFloat(data) || 0;
    var fmt = typeof currencyFormat === 'function' ? currencyFormat(v) : v.toFixed(2);
    if (v > 0) {
      return '<span class="fw-semibold text-success">' + fmt + '</span>';
    }
    return '<span class="text-muted">' + fmt + '</span>';
  }

  /* ─── Renderer "Actions" : icône edit + dropdown 3-dots ─── */
  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('customers/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('edit') ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">' +
                 '<i class="ri ri-more-2-line" style="font-size:20px"></i>' +
               '</button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('customers/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('customers/deposits') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-wallet-3-line me-2" style="font-size:14px"></i><?= lang('list_deposits') ?: 'Dépôts' ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('customers/add_deposit') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-add-circle-line me-2" style="font-size:14px"></i><?= lang('add_deposit') ?: 'Ajouter dépôt' ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('customers/addresses') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-map-pin-line me-2" style="font-size:14px"></i><?= lang('list_addresses') ?: 'Adresses' ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('customers/users') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-user-line me-2" style="font-size:14px"></i><?= lang('list_users') ?: 'Utilisateurs' ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    cTable = $('#CusData').dataTable({
      "aaSorting": [[2, "asc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('customers/getCustomers') ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "customer_details_link";
        return nRow;
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"bVisible": false}, /* company - hidden, used by renderCustomer */
        {"mRender": renderCustomer},
        {"bVisible": false}, /* email - hidden, used by renderCustomer */
        null,                 /* phone */
        {"mRender": renderGroupBadge},
        {"mRender": renderGroupBadge},
        {"bVisible": false}, /* vat */
        {"bVisible": false}, /* gst */
        {"mRender": renderDeposit},
        null,                 /* points */
        {"bSortable": false, "mRender": renderActions}
      ]
    }).fnSetFilteringDelay();

    /* ─── Filtres custom (header dropdowns) ─── */
    $('#filterCustomerGroup').on('change', function () {
      // colonne 6 = customer_group
      $('#CusData').dataTable().fnFilter($(this).val(), 6, false, false, true);
    });
    $('#filterPriceGroup').on('change', function () {
      // colonne 5 = price_group
      $('#CusData').dataTable().fnFilter($(this).val(), 5, false, false, true);
    });
    $('#filterDeposit').on('change', function () {
      var v = $(this).val();
      // colonne 9 = deposit_amount
      if (v === 'with') {
        // simple regex matching numbers > 0
        $('#CusData').dataTable().fnFilter('^([1-9][0-9]*)|(0\\.[0-9]*[1-9])', 9, true, false, true);
      } else if (v === 'without') {
        $('#CusData').dataTable().fnFilter('^0(\\.0+)?$', 9, true, false, true);
      } else {
        $('#CusData').dataTable().fnFilter('', 9, true, false, true);
      }
    });
    $('#customDtSearch').on('keyup input', function () {
      $('#CusData').dataTable().fnFilter($(this).val());
    });

    $('#myModal').on('hidden.bs.modal', function () { cTable.fnDraw(false); });
  });
})();
</script>

<?php if ($action && $action == 'add') {
    echo '<script>$(document).ready(function(){ $("#add").trigger("click"); });</script>';
} ?>
