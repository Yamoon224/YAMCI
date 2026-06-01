<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-price-tag-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('stock_value') ?: 'Rapport de valeur du stock'; ?>
        <?php if (isset($warehouse) && $warehouse): ?>
          <small class="text-muted fs-6 fw-normal">— <?php echo $warehouse->name; ?></small>
        <?php endif; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('stock_value') ?: 'Valeur du stock'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <a href="#" id="xls" class="btn btn-outline-success btn-sm">
        <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
        <?php echo lang('download_xls') ?: 'Excel'; ?>
      </a>
    </div>
</div>

<!-- Warehouse selector -->
<?php if (!empty($warehouses)): ?>
<div class="card mb-4">
  <div class="card-body py-3">
    <div class="d-flex flex-wrap gap-2 align-items-center">
      <span class="text-muted me-2">
        <span class="icon-base ri ri-store-2-line me-1 icon-16px"></span>
        <?php echo lang('warehouse') ?: 'Entrepôt'; ?> :
      </span>
      <a href="<?php echo admin_url('reports/warehouse_stock'); ?>"
         class="btn btn-sm <?php echo !isset($warehouse_id) || !$warehouse_id ? 'btn-primary' : 'btn-outline-secondary'; ?>">
        <?php echo lang('all_warehouses') ?: 'Tous les entrepôts'; ?>
      </a>
      <?php foreach ($warehouses as $wh): ?>
      <a href="<?php echo admin_url('reports/warehouse_stock/' . $wh->id); ?>"
         class="btn btn-sm <?php echo isset($warehouse_id) && $warehouse_id == $wh->id ? 'btn-primary' : 'btn-outline-secondary'; ?>">
        <?php echo $wh->name; ?>
      </a>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Summary Cards -->
<?php if (isset($stock)): ?>
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <p class="text-muted mb-1"><?php echo lang('stock_value_by_cost') ?: 'Valeur au coût'; ?></p>
            <h4 class="mb-0 fw-semibold text-primary"><?php echo $this->sma->mf($stock->stock_by_cost); ?></h4>
          </div>
          <div class="avatar avatar-sm bg-label-primary">
            <span class="icon-base ri ri-money-dollar-circle-line icon-20px"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <p class="text-muted mb-1"><?php echo lang('stock_value_by_price') ?: 'Valeur au prix de vente'; ?></p>
            <h4 class="mb-0 fw-semibold text-success"><?php echo $this->sma->mf($stock->stock_by_price); ?></h4>
          </div>
          <div class="avatar avatar-sm bg-label-success">
            <span class="icon-base ri ri-price-tag-3-line icon-20px"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-4">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <p class="text-muted mb-1"><?php echo lang('profit_estimate') ?: 'Bénéfice estimé'; ?></p>
            <h4 class="mb-0 fw-semibold text-warning"><?php echo $this->sma->mf($stock->stock_by_price - $stock->stock_by_cost); ?></h4>
          </div>
          <div class="avatar avatar-sm bg-label-warning">
            <span class="icon-base ri ri-line-chart-line icon-20px"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Pie Chart -->
<?php if (isset($stock)): ?>
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-pie-chart-line me-2 text-primary icon-18px"></span>
      <?php echo lang('stock_value') ?: 'Valeur du stock'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div id="stockValueChart" style="min-height:300px;"></div>
  </div>
</div>
<?php endif; ?>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="StockValData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('product_code') ?: 'Code'; ?></th>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th><?php echo lang('category') ?: 'Catégorie'; ?></th>
          <th><?php echo lang('current_stock') ?: 'Stock actuel'; ?></th>
          <th><?php echo lang('unit_cost') ?: 'Coût unitaire'; ?></th>
          <th><?php echo lang('unit_price') ?: 'Prix unitaire'; ?></th>
          <th><?php echo lang('stock_value_by_cost') ?: 'Valeur (coût)'; ?></th>
          <th><?php echo lang('stock_value_by_price') ?: 'Valeur (prix)'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="8" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3"><?php echo lang('total') ?: 'Total'; ?></th>
          <th id="footQty"></th>
          <th></th><th></th>
          <th id="footCost"></th>
          <th id="footPrice"></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  <?php if (isset($stock)): ?>
  // ApexCharts Pie
  var stockChartOptions = {
    chart: { type: 'pie', height: 300 },
    labels: [
      '<?php echo lang('stock_value_by_price') ?: 'Valeur prix'; ?>',
      '<?php echo lang('stock_value_by_cost') ?: 'Valeur coût'; ?>',
      '<?php echo lang('profit_estimate') ?: 'Bénéfice'; ?>'
    ],
    series: [
      <?php echo (float)$stock->stock_by_price; ?>,
      <?php echo (float)$stock->stock_by_cost; ?>,
      <?php echo (float)($stock->stock_by_price - $stock->stock_by_cost); ?>
    ],
    colors: ['#28c76f', '#7367f0', '#ff9f43'],
    legend: { position: 'bottom' },
    dataLabels: { enabled: true },
    tooltip: {
      y: { formatter: function (v) { return currencyFormat(v); } }
    }
  };
  new ApexCharts(document.getElementById('stockValueChart'), stockChartOptions).render();
  <?php endif; ?>

  var oTable = $('#StockValData').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'asc']],
    ajax: {
      url: '<?php echo admin_url('reports/getStockValue' . (isset($warehouse_id) && $warehouse_id ? '/' . $warehouse_id : '')); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null, null, null,
      { render: function (d) { return typeof formatQuantity === 'function' ? formatQuantity(d) : d; } },
      { searchable: false, render: function (d) { return currencyFormat(parseFloat(d)); } },
      { searchable: false, render: function (d) { return currencyFormat(parseFloat(d)); } },
      { searchable: false, render: function (d) { return '<span class="text-primary fw-semibold">' + currencyFormat(parseFloat(d)) + '</span>'; } },
      { searchable: false, render: function (d) { return '<span class="text-success fw-semibold">' + currencyFormat(parseFloat(d)) + '</span>'; } }
    ],
    footerCallback: function (row, data, start, end, display) {
      var qty = 0, cost = 0, price = 0;
      for (var i = 0; i < data.length; i++) {
        qty   += parseFloat(data[display[i]][3]) || 0;
        cost  += parseFloat(data[display[i]][6]) || 0;
        price += parseFloat(data[display[i]][7]) || 0;
      }
      document.getElementById('footQty').innerHTML   = qty;
      document.getElementById('footCost').innerHTML  = '<strong>' + currencyFormat(cost) + '</strong>';
      document.getElementById('footPrice').innerHTML = '<strong>' + currencyFormat(price) + '</strong>';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getStockValue' . (isset($warehouse_id) && $warehouse_id ? '/' . $warehouse_id : '') . '/0/xls'); ?>';
  });
})();
</script>
