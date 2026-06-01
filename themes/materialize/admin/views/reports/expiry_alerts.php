<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <span class="icon-base ri ri-time-line me-2 text-warning icon-20px"></span>
        <?php echo lang('product_expiry_alerts') . ' (' . ($warehouse_id ? htmlspecialchars($warehouse->name) : lang('all_warehouses')) . ')'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><span class="icon-base ri ri-home-line icon-20px"></span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('product_expiry_alerts') ?: 'Alertes d\'expiration'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <?php if (!empty($warehouses)): ?>
      <div class="dropdown">
        <button type="button" class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="icon-base ri ri-building-line me-1 icon-16px"></span>
          <?php echo lang('warehouses') ?: 'Entrepôts'; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="<?php echo admin_url('reports/expiry_alerts'); ?>">
              <span class="icon-base ri ri-building-line me-2 icon-16px"></span>
              <?php echo lang('all_warehouses') ?: 'Tous les entrepôts'; ?>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <?php foreach ($warehouses as $whr): ?>
          <li>
            <a class="dropdown-item<?php echo ($warehouse_id && $warehouse_id == $whr->id) ? ' active' : ''; ?>"
               href="<?php echo admin_url('reports/expiry_alerts/' . $whr->id); ?>">
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
  <span class="icon-base ri ri-calendar-close-line icon-20px flex-shrink-0"></span>
  <div><?php echo lang('list_results') ?: 'Produits dont la date d\'expiration est proche ou dépassée.'; ?></div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="PExData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="min-width:50px; width:50px; text-align:center;"><?php echo lang('image') ?: 'Image'; ?></th>
          <th><?php echo lang('product_code') ?: 'Code'; ?></th>
          <th><?php echo lang('product_name') ?: 'Produit'; ?></th>
          <th><?php echo lang('quantity') ?: 'Quantité'; ?></th>
          <th><?php echo lang('warehouse') ?: 'Entrepôt'; ?></th>
          <th><?php echo lang('expiry_date') ?: 'Date d\'expiration'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="6" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th style="min-width:50px; width:50px; text-align:center;"><?php echo lang('image') ?: 'Image'; ?></th>
          <th></th>
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

  var oTable = $('#PExData').dataTable({
    aaSorting: [[5, 'asc']],
    aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    iDisplayLength: <?php echo (int)$Settings->rows_per_page; ?>,
    bProcessing: true,
    bServerSide: true,
    sAjaxSource: '<?php echo admin_url('reports/getExpiryAlerts' . ($warehouse_id ? '/' . $warehouse_id : '')); ?>',
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
      { mRender: formatQuantity },
      null,
      {
        mRender: function (d) {
          if (!d) return '';
          var expDate = new Date(d);
          var today   = new Date();
          var diffMs  = expDate - today;
          var diffDay = Math.ceil(diffMs / (1000 * 60 * 60 * 24));
          var badge;
          if (diffDay < 0) {
            badge = 'bg-label-danger';
          } else if (diffDay <= 30) {
            badge = 'bg-label-warning';
          } else {
            badge = 'bg-label-success';
          }
          return '<span class="badge ' + badge + '">' + fsd(d) + '</span>';
        }
      }
    ]
  }).fnSetFilteringDelay().dtFilter([
    { column_number: 1, filter_default_label: '[<?php echo lang('product_code'); ?>]',  filter_type: 'text', data: [] },
    { column_number: 2, filter_default_label: '[<?php echo lang('product_name'); ?>]',  filter_type: 'text', data: [] },
    { column_number: 3, filter_default_label: '[<?php echo lang('quantity'); ?>]',      filter_type: 'text', data: [] },
    { column_number: 4, filter_default_label: '[<?php echo lang('warehouse'); ?>]',     filter_type: 'text', data: [] },
    { column_number: 5, filter_default_label: '[<?php echo lang('date'); ?> (yyyy-mm-dd)]', filter_type: 'text', data: [] }
  ], 'footer');
})();
</script>
