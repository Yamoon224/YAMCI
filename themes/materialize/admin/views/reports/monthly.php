<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-calendar-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('monthly_sales') ?: 'Rapport mensuel'; ?>
        — <?php echo isset($sel_warehouse) ? $sel_warehouse->name : (lang('all_warehouses') ?: 'Tous les entrepôts'); ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('monthly_sales') ?: 'Ventes mensuelles'; ?></li>
      </ol>
    </nav>
    </div>
    <!-- Warehouse switcher -->
    <?php if (!empty($warehouses) && !$this->session->userdata('warehouse_id')): ?>
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <span class="icon-base ri ri-store-2-line me-1 icon-16px"></span>
        <?php echo lang('warehouses') ?: 'Entrepôts'; ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?php echo admin_url('reports/monthly_sales/0/' . $year); ?>">
          <span class="icon-base ri ri-global-line me-1 icon-16px"></span><?php echo lang('all_warehouses') ?: 'Tous'; ?>
        </a></li>
        <li><hr class="dropdown-divider"></li>
        <?php foreach ($warehouses as $warehouse): ?>
        <li><a class="dropdown-item" href="<?php echo admin_url('reports/monthly_sales/' . $warehouse->id . '/' . $year); ?>">
          <span class="icon-base ri ri-store-2-line me-1 icon-16px"></span><?php echo $warehouse->name; ?>
        </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
</div>

<!-- Year navigation -->
<div class="card mb-4">
  <div class="card-body py-3">
    <div class="d-flex align-items-center gap-3">
      <a href="<?php echo admin_url('reports/monthly_sales/' . (isset($warehouse_id) ? $warehouse_id : 0) . '/' . ($year - 1)); ?>"
         class="btn btn-outline-secondary btn-sm">
        <span class="icon-base ri ri-arrow-left-s-line icon-16px"></span>
      </a>
      <h5 class="mb-0 fw-semibold"><?php echo $year; ?></h5>
      <a href="<?php echo admin_url('reports/monthly_sales/' . (isset($warehouse_id) ? $warehouse_id : 0) . '/' . ($year + 1)); ?>"
         class="btn btn-outline-secondary btn-sm">
        <span class="icon-base ri ri-arrow-right-s-line icon-16px"></span>
      </a>
    </div>
  </div>
</div>

<!-- ApexCharts line chart of monthly totals -->
<?php
$months_keys  = [];
$months_sales = [];
if (!empty($sales)) {
    foreach ($sales as $value) {
        $months_keys[]  = $value->date;
        $months_sales[] = (float)$value->total;
    }
}
?>
<?php if (!empty($months_keys)): ?>
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-line-chart-line me-2 text-primary icon-18px"></span>
      <?php echo lang('monthly_sales') ?: 'Évolution mensuelle'; ?> <?php echo $year; ?>
    </h5>
  </div>
  <div class="card-body">
    <div id="monthlySalesChart" style="min-height: 320px;"></div>
  </div>
</div>
<?php endif; ?>

<!-- KPI Summary cards -->
<?php
$months_labels = [
  1  => lang('cal_january')   ?: 'Janvier',
  2  => lang('cal_february')  ?: 'Février',
  3  => lang('cal_march')     ?: 'Mars',
  4  => lang('cal_april')     ?: 'Avril',
  5  => lang('cal_may')       ?: 'Mai',
  6  => lang('cal_june')      ?: 'Juin',
  7  => lang('cal_july')      ?: 'Juillet',
  8  => lang('cal_august')    ?: 'Août',
  9  => lang('cal_september') ?: 'Septembre',
  10 => lang('cal_october')   ?: 'Octobre',
  11 => lang('cal_november')  ?: 'Novembre',
  12 => lang('cal_december')  ?: 'Décembre',
];

// Build indexed array of sales data
$sales_by_month = [];
if (!empty($sales)) {
    foreach ($sales as $value) {
        $sales_by_month[(int)$value->date] = $value;
    }
}
?>

<!-- Monthly grid card -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-calendar-check-line me-2 text-primary icon-18px"></span>
      <?php echo lang('monthly_summary') ?: 'Résumé mensuel'; ?> <?php echo $year; ?>
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <?php for ($m = 1; $m <= 12; $m++):
        $ms = isset($sales_by_month[$m]) ? $sales_by_month[$m] : null;
      ?>
      <div class="col-sm-6 col-md-4 col-xl-3">
        <div class="card border h-100">
          <div class="card-body p-3">
            <a href="<?php echo admin_url('reports/monthly_profit/' . $year . '/' . str_pad($m, 2, '0', STR_PAD_LEFT)); ?>"
               data-bs-toggle="modal" data-bs-target="#myModal"
               class="d-block text-decoration-none">
              <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="fw-semibold text-body"><?php echo $months_labels[$m]; ?></span>
                <span class="badge bg-label-primary"><?php echo $year; ?></span>
              </div>
              <?php if ($ms): ?>
              <div class="small text-muted mt-1">
                <div class="d-flex justify-content-between">
                  <span><?php echo lang('total') ?: 'Total'; ?></span>
                  <strong class="text-primary"><?php echo $this->sma->mf($ms->total); ?></strong>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <span><?php echo lang('product_tax') ?: 'Taxe produit'; ?></span>
                  <span><?php echo $this->sma->mf($ms->tax1); ?></span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <span><?php echo lang('order_tax') ?: 'Taxe ordre'; ?></span>
                  <span><?php echo $this->sma->mf($ms->tax2); ?></span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <span><?php echo lang('discount') ?: 'Remise'; ?></span>
                  <span><?php echo $this->sma->mf($ms->discount); ?></span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                  <span><?php echo lang('shipping') ?: 'Livraison'; ?></span>
                  <span><?php echo $this->sma->mf($ms->shipping); ?></span>
                </div>
              </div>
              <?php else: ?>
              <p class="small text-muted mb-0 mt-2"><?php echo lang('no_data') ?: 'Aucune donnée'; ?></p>
              <?php endif; ?>
            </a>
          </div>
        </div>
      </div>
      <?php endfor; ?>
    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  <?php if (!empty($months_keys)): ?>
  var monthlyChartOptions = {
    chart: {
      type: 'line',
      height: 320,
      toolbar: { show: false },
      zoom: { enabled: false }
    },
    stroke: { curve: 'smooth', width: 3 },
    series: [{
      name: '<?php echo lang('sales') ?: 'Ventes'; ?>',
      data: <?php echo json_encode($months_sales); ?>
    }],
    xaxis: {
      categories: <?php echo json_encode(array_map(function($k) use ($months_labels) { return $months_labels[(int)$k] ?? $k; }, $months_keys)); ?>
    },
    colors: ['#7367f0'],
    markers: { size: 5 },
    dataLabels: { enabled: false },
    yaxis: { labels: { formatter: function (v) { return currencyFormat(v); } } },
    tooltip: { y: { formatter: function (v) { return currencyFormat(v); } } },
    grid: { borderColor: '#e0e0e0' }
  };
  new ApexCharts(document.getElementById('monthlySalesChart'), monthlyChartOptions).render();
  <?php endif; ?>
})();
</script>
