<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-truck-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('suppliers') ?: 'Fournisseurs' ?></h4>
    <p class="mb-0 text-muted">Annuaire fournisseurs et historique d'achats</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('suppliers') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('suppliers/add') ?>" id="add" class="btn btn-primary"
       data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_supplier') ?: 'Nouveau fournisseur' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="<?= admin_url('suppliers/import_csv') ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="ri ri-upload-2-line me-2" style="font-size:14px"></i><?= lang('import_by_csv') ?: 'Importer CSV' ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
            <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?>
          </a>
        </li>
        <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger bpo"
             title="<b><?= lang('delete_suppliers') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_suppliers') ?: 'Supprimer' ?>
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
              <p class="mb-1 text-muted">Total fournisseurs</p>
              <h4 class="mb-1"><?= number_format($stats->total ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">référencés</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-primary"><i class="ri ri-truck-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Achats effectués</p>
              <h4 class="mb-1"><?= number_format($stats->purchases_count ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success">commandes</span></p>
            </div>
            <div class="avatar me-lg-6"><span class="avatar-initial rounded-3 bg-label-success"><i class="ri ri-store-2-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Total achats</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_purchases ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-info">cumulé</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-info"><i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Crédit dû</p>
              <h4 class="mb-1 <?= ($stats->credit ?? 0) > 0 ? 'text-danger' : '' ?>"><?= $this->sma->formatMoney($stats->credit ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-danger">restant à payer</span></p>
            </div>
            <div class="avatar"><span class="avatar-initial rounded-3 bg-label-danger"><i class="ri ri-bank-card-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('suppliers/supplier_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE FOURNISSEURS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-6">
        <select id="filterCountry" class="form-select">
          <option value="">Tous pays</option>
          <?php if (!empty($filter_countries)) foreach ($filter_countries as $c): ?>
            <option value="<?= htmlspecialchars($c->country, ENT_QUOTES) ?>"><?= htmlspecialchars($c->country) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <select id="filterCity" class="form-select">
          <option value="">Toutes villes</option>
          <?php if (!empty($filter_cities)) foreach ($filter_cities as $c): ?>
            <option value="<?= htmlspecialchars($c->city, ENT_QUOTES) ?>"><?= htmlspecialchars($c->city) ?></option>
          <?php endforeach; ?>
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
      Cliquez sur une ligne pour ouvrir la fiche fournisseur
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="SupData" class="datatables-suppliers table table-hover" aria-label="<?= lang('suppliers') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkth" type="checkbox" name="check" />
          </th>
          <th style="display:none;">company</th>
          <th><?= lang('supplier') ?: 'Fournisseur' ?></th>
          <th style="display:none;">email</th>
          <th><?= lang('phone') ?></th>
          <th><?= lang('city') ?></th>
          <th><?= lang('country') ?></th>
          <th style="display:none;">vat</th>
          <th style="display:none;">gst</th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="10" class="dataTables_empty text-center py-5">
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
  var sTable;

  /* ─── Renderer "Fournisseur" : avatar initiales + nom + société/email ─── */
  function renderSupplier(data, type, row) {
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
    return '<div class="d-flex justify-content-start align-items-center supplier-name">' +
             '<div class="avatar-wrapper me-3">' +
               '<div class="avatar rounded-circle bg-label-' + color + '">' +
                 '<span class="avatar-initial rounded-circle">' + initials + '</span>' +
               '</div>' +
             '</div>' +
             '<div class="d-flex flex-column">' +
               '<h6 class="text-nowrap mb-0">' + (name || company || '—') + '</h6>' +
               '<small class="text-muted">' + (company && name ? company + ' · ' : '') + (email || '') + '</small>' +
             '</div>' +
           '</div>';
  }

  /* ─── Renderer "Ville/Pays" avec icône ─── */
  function renderLocation(data, icon) {
    if (!data) return '<span class="text-muted">—</span>';
    return '<span class="d-inline-flex align-items-center"><i class="ri ' + icon + ' me-1 text-muted" style="font-size:14px"></i>' + data + '</span>';
  }

  /* ─── Renderer "Actions" : icône edit + dropdown 3-dots ─── */
  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('suppliers/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('edit') ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">' +
                 '<i class="ri ri-more-2-line" style="font-size:20px"></i>' +
               '</button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('suppliers/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('products') ?>?supplier=' + id + '"><i class="ri ri-list-check me-2" style="font-size:14px"></i><?= lang('list_products') ?: 'Produits' ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?= admin_url('suppliers/users') ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-user-line me-2" style="font-size:14px"></i><?= lang('list_users') ?: 'Utilisateurs' ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    sTable = $('#SupData').dataTable({
      "aaSorting": [[2, "asc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('suppliers/getSuppliers') ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "supplier_details_link";
        return nRow;
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"bVisible": false},                                                    /* company */
        {"mRender": renderSupplier},
        {"bVisible": false},                                                    /* email */
        null,                                                                    /* phone */
        {"mRender": function(d, t){ return t === 'display' ? renderLocation(d, 'ri-map-pin-2-line') : (d || ''); }},
        {"mRender": function(d, t){ return t === 'display' ? renderLocation(d, 'ri-earth-line') : (d || ''); }},
        {"bVisible": false},                                                    /* vat */
        {"bVisible": false},                                                    /* gst */
        {"bSortable": false, "mRender": renderActions}
      ]
    }).fnSetFilteringDelay();

    /* ─── Filtres custom (header dropdowns) ─── */
    $('#filterCountry').on('change', function () {
      $('#SupData').dataTable().fnFilter($(this).val(), 6, false, false, true);
    });
    $('#filterCity').on('change', function () {
      $('#SupData').dataTable().fnFilter($(this).val(), 5, false, false, true);
    });
    $('#customDtSearch').on('keyup input', function () {
      $('#SupData').dataTable().fnFilter($(this).val());
    });

    $('#myModal').on('hidden.bs.modal', function () { sTable.fnDraw(false); });
  });
})();
</script>
