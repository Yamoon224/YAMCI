<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-arrow-up-down-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('quantity_adjustments') ?: 'Ajustements de stock'; ?>
      <?php if (isset($warehouse) && $warehouse): ?>
        <span class="text-muted fw-normal ms-1 fs-6">(<?php echo htmlspecialchars($warehouse->name); ?>)</span>
      <?php endif; ?>
    </h4>
    <p class="mb-0 text-muted">Ajustez manuellement les quantités en stock</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('quantity_adjustments') ?: 'Ajustements'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if (!empty($GP['adjustments']['add']) || $Owner || $Admin): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('products/add_adjustment'); ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_adjustment') ?: 'Nouvel ajustement'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<!-- CARTE LISTE AJUSTEMENTS -->
<div class="card">

  <?php if (isset($warehouses) && count($warehouses) > 1): ?>
  <!-- card-header : filtre entrepôt -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?php echo lang('filter') ?: 'Filtre'; ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-12">
        <select id="filterWarehouse" class="form-select" onchange="if(this.value){window.location.href=this.value;}">
          <option value="<?php echo admin_url('products/quantity_adjustments'); ?>" <?php echo !isset($warehouse) ? 'selected' : ''; ?>>Tous les entrepôts</option>
          <?php foreach ($warehouses as $wh): ?>
            <option value="<?php echo admin_url('products/quantity_adjustments/' . $wh->id); ?>" <?php echo (isset($warehouse) && $warehouse->id == $wh->id) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($wh->name); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>
  <?php endif; ?>

  <!-- toolbar : custom search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?php echo lang('search') ?: 'Rechercher'; ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir l'ajustement
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="dmpData" class="datatables-adjustments table table-hover">
      <thead>
        <tr>
          <th style="width:30px;" class="text-center"><input class="form-check-input checkbox checkth" type="checkbox" /></th>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('warehouse') ?: 'Entrepôt'; ?></th>
          <th><?php echo lang('created_by') ?: 'Créé par'; ?></th>
          <th><?php echo lang('note') ?: 'Note'; ?></th>
          <th style="width:40px;" class="text-center"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="8" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?php echo lang('loading_data_from_server') ?: 'Chargement…'; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  if (localStorage.getItem('remove_qals')) {
    ['qaitems','qaref','qawarehouse','qanote','qadate'].forEach(function(k){ localStorage.removeItem(k); });
    localStorage.removeItem('remove_qals');
  }

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderWarehouse(data) {
    if (!data) return '<span class="text-muted">—</span>';
    return '<span class="d-inline-flex align-items-center"><i class="ri ri-building-4-line me-1 text-muted" style="font-size:14px"></i>' + data + '</span>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?php echo admin_url('products/edit_adjustment'); ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('products/view_adjustment'); ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?php echo lang('view'); ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?php echo lang('delete'); ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  var dtable = $('#dmpData').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'desc']],
    ajax: {
      url: '<?php echo admin_url('products/getadjustments/' . (isset($warehouse) ? $warehouse->id : '')); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { orderable: false, render: function (d, t, r) { return '<input type="checkbox" class="form-check-input checkbox" name="ids[]" value="' + r[0] + '">'; } },
      null,
      { render: function (d, t) { return t === 'display' ? renderRef(d) : (d || ''); } },
      { render: function (d, t) { return t === 'display' ? renderWarehouse(d) : (d || ''); } },
      null,
      { render: function (d) { return d ? '<span class="text-body small">' + d + '</span>' : '<span class="text-muted">—</span>'; } },
      { orderable: false, className: 'text-center', render: function (d) {
          return d ? '<a href="' + d + '" target="_blank" class="btn btn-icon btn-text-secondary rounded-pill"><i class="ri ri-attachment-2" style="font-size:18px"></i></a>' : '<span class="text-muted">—</span>';
        }
      },
      { orderable: false, className: 'text-center', render: renderActions }
    ],
    rowCallback: function (row, data) {
      row.id = data[0];
      row.className += ' adjustment_link';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>"
  });

  $('#customDtSearch').on('keyup input', function () { dtable.search($(this).val()).draw(); });
  $('.checkth').on('change', function () { $('.checkbox').prop('checked', this.checked); });
})();
</script>
