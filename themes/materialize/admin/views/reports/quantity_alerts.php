<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <span class="icon-base ri ri-alert-line me-2 text-danger icon-20px"></span>
        <?php echo lang('product_quantity_alerts') . ' (' . ($warehouse_id ? htmlspecialchars($warehouse->name) : lang('all_warehouses')) . ')'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><span class="icon-base ri ri-home-line icon-20px"></span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('product_quantity_alerts') ?: 'Alertes de stock'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <a href="#" id="xls" class="btn btn-outline-success btn-sm">
        <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
        <?php echo lang('download_xls') ?: 'Excel'; ?>
      </a>
      <?php if (!empty($warehouses)): ?>
      <div class="dropdown">
        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="icon-base ri ri-building-line me-1 icon-16px"></span>
          <?php echo lang('warehouses') ?: 'Entrepôts'; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="<?php echo admin_url('reports/quantity_alerts'); ?>">
              <span class="icon-base ri ri-building-line me-2 icon-16px"></span>
              <?php echo lang('all_warehouses') ?: 'Tous les entrepôts'; ?>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <?php foreach ($warehouses as $whr): ?>
          <li>
            <a class="dropdown-item<?php echo ($warehouse_id && $warehouse_id == $whr->id) ? ' active' : ''; ?>"
               href="<?php echo admin_url('reports/quantity_alerts/' . $whr->id); ?>">
              <span class="icon-base ri ri-building-4-line me-2 icon-16px"></span>
              <?php echo htmlspecialchars($whr->name); ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>
    </div>
</div>

<!-- Alert Banner -->
<div class="alert alert-warning d-flex align-items-center gap-2 mb-4" role="alert">
  <span class="icon-base ri ri-error-warning-line icon-20px flex-shrink-0"></span>
  <div><?php echo lang('list_results') ?: 'Produits dont le stock est inférieur ou égal au niveau de réapprovisionnement.'; ?></div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="PQData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="min-width:50px; width:50px; text-align:center;"><?php echo lang('image') ?: 'Image'; ?></th>
          <th><?php echo lang('product_code') ?: 'Code'; ?></th>
          <th><?php echo lang('product_name') ?: 'Produit'; ?></th>
          <th><?php echo lang('quantity') ?: 'Qté actuelle'; ?></th>
          <th><?php echo lang('alert_quantity') ?: 'Qté alerte'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="5" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th style="min-width:50px; width:50px; text-align:center;"><?php echo lang('image') ?: 'Image'; ?></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  var oTable = $('#PQData').dataTable({
    aaSorting: [[1, 'desc']],
    aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    iDisplayLength: <?php echo (int)$Settings->rows_per_page; ?>,
    bProcessing: true,
    bServerSide: true,
    sAjaxSource: '<?php echo admin_url('reports/getQuantityAlerts' . ($warehouse_id ? '/' . $warehouse_id : '')); ?>',
    fnServerData: function (sSource, aoData, fnCallback) {
      aoData.push({
        name: '<?php echo $this->security->get_csrf_token_name(); ?>',
        value: '<?php echo $this->security->get_csrf_hash(); ?>'
      });
      $.ajax({ dataType: 'json', type: 'POST', url: sSource, data: aoData, success: fnCallback });
    },
    aoColumns: [
      { bSortable: false, mRender: img_hl },
      null,
      null,
      {
        mRender: function (d) {
          return '<span class="badge bg-label-danger">' + formatQuantity(d) + '</span>';
        }
      },
      {
        mRender: function (d) {
          return '<span class="badge bg-label-warning">' + formatQuantity(d) + '</span>';
        }
      }
    ]
  }).fnSetFilteringDelay().dtFilter([
    { column_number: 1, filter_default_label: '[<?php echo lang('product_code'); ?>]', filter_type: 'text', data: [] },
    { column_number: 2, filter_default_label: '[<?php echo lang('product_name'); ?>]', filter_type: 'text', data: [] },
    { column_number: 3, filter_default_label: '[<?php echo lang('quantity'); ?>]',     filter_type: 'text', data: [] },
    { column_number: 4, filter_default_label: '[<?php echo lang('alert_quantity'); ?>]', filter_type: 'text', data: [] }
  ], 'footer');

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getQuantityAlerts/' . ($warehouse_id ? $warehouse_id : '0') . '/0/xls'); ?>';
  });
})();
</script>
