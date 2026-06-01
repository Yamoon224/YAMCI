<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-bar-chart-box-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('stock_counts') ?: 'Inventaires'; ?>
      <?php if (!empty($warehouse)): ?>
        <span class="text-muted fw-normal ms-1 fs-6">(<?php echo htmlspecialchars($warehouse->name); ?>)</span>
      <?php endif; ?>
    </h4>
    <p class="mb-0 text-muted">Comptages physiques et ajustements de stock</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('stock_counts') ?: 'Inventaires'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin || !empty($GP['stock_counts']['add'])): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('products/count_stock'); ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('new_count') ?: 'Nouvel inventaire'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<!-- CARTE LISTE INVENTAIRES -->
<div class="card">

  <?php if (!empty($warehouses) && count($warehouses) > 1): ?>
  <!-- card-header : filtre entrepôt + statut -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?php echo lang('filter') ?: 'Filtre'; ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-6">
        <select id="filterWarehouse" class="form-select" onchange="if(this.value){window.location.href=this.value;}">
          <option value="<?php echo admin_url('products/stock_counts'); ?>" <?php echo empty($warehouse_id) ? 'selected' : ''; ?>>Tous les entrepôts</option>
          <?php foreach ($warehouses as $wh): ?>
            <option value="<?php echo admin_url('products/stock_counts/' . $wh->id); ?>" <?php echo (isset($warehouse_id) && $warehouse_id == $wh->id) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($wh->name); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <select id="filterStatus" class="form-select">
          <option value="">Tout statut</option>
          <option value="open"><?php echo lang('open') ?: 'En cours'; ?></option>
          <option value="completed"><?php echo lang('completed') ?: 'Terminé'; ?></option>
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
      Cliquez sur une ligne pour ouvrir l'inventaire
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="STData" class="datatables-stockcounts table table-hover">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('warehouse') ?: 'Entrepôt'; ?></th>
          <th><?php echo lang('status') ?: 'Statut'; ?></th>
          <th><?php echo lang('note') ?: 'Note'; ?></th>
          <th style="width:90px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6" class="dataTables_empty text-center py-5">
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

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderWarehouse(data) {
    if (!data) return '<span class="text-muted">—</span>';
    return '<span class="d-inline-flex align-items-center"><i class="ri ri-building-4-line me-1 text-muted" style="font-size:14px"></i>' + data + '</span>';
  }

  function renderStatus(val) {
    if (val === 'open' || val === '1' || val === 1) {
      return '<span class="badge rounded-pill bg-label-warning"><i class="ri ri-time-line me-1" style="font-size:11px"></i><?php echo addslashes(lang('open') ?: 'En cours'); ?></span>';
    } else if (val === 'completed' || val === '2' || val === 2) {
      return '<span class="badge rounded-pill bg-label-success"><i class="ri ri-checkbox-circle-line me-1" style="font-size:11px"></i><?php echo addslashes(lang('completed') ?: 'Terminé'); ?></span>';
    }
    return '<span class="badge rounded-pill bg-label-secondary">' + val + '</span>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?php echo admin_url('products/view_count'); ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill"><i class="ri ri-eye-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('products/finalize_count'); ?>/' + id + '"><i class="ri ri-check-double-line me-2" style="font-size:14px"></i><?php echo lang('finalize_count') ?: 'Finaliser'; ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?php echo lang('delete'); ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  var oTable = $('#STData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('products/getStockCounts' . (!empty($warehouse_id) ? '/' . $warehouse_id : '')); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    columns: [
      null,
      { render: function(d, t){ return t === 'display' ? renderRef(d) : (d || ''); } },
      { render: function(d, t){ return t === 'display' ? renderWarehouse(d) : (d || ''); } },
      { orderable: false, render: function(d){ return renderStatus(d); } },
      { render: function (d) { return d ? '<span class="text-body small">' + d + '</span>' : '<span class="text-muted">—</span>'; } },
      { orderable: false, className: 'text-center', render: renderActions }
    ],
    rowCallback: function (row, data) {
      row.id = data[0];
      row.className += ' count_link';
    },
    dom: "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>"
  });

  $('#customDtSearch').on('keyup input', function () { oTable.search($(this).val()).draw(); });
  $('#filterStatus').on('change', function () { oTable.column(3).search($(this).val()).draw(); });

  $('#myModal').on('hidden.bs.modal', function () { oTable.ajax.reload(null, false); });
})();
</script>
