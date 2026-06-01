<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-calendar-event-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('daily_sales') ?: 'Ventes journalières'; ?></h4>
    <p class="mb-0 text-muted"><?php echo isset($sel_warehouse) ? $sel_warehouse->name : (lang('all_warehouses') ?: 'Tous les entrepôts'); ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('daily_sales') ?: 'Ventes journalières'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <!-- Warehouse switcher -->
    <?php if (!empty($warehouses) && !$this->session->userdata('warehouse_id')): ?>
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <span class="icon-base ri ri-store-2-line me-1 icon-16px"></span>
        <?php echo lang('warehouses') ?: 'Entrepôts'; ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?php echo admin_url('reports/daily_sales/0/' . $year . '/' . $month); ?>">
          <span class="icon-base ri ri-global-line me-1 icon-16px"></span><?php echo lang('all_warehouses') ?: 'Tous'; ?>
        </a></li>
        <li><hr class="dropdown-divider"></li>
        <?php foreach ($warehouses as $warehouse): ?>
        <li><a class="dropdown-item" href="<?php echo admin_url('reports/daily_sales/' . $warehouse->id . '/' . $year . '/' . $month); ?>">
          <span class="icon-base ri ri-store-2-line me-1 icon-16px"></span><?php echo $warehouse->name; ?>
        </a></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Month navigation -->
<div class="card mb-4">
  <div class="card-body py-3">
    <div class="d-flex align-items-center gap-3">
      <a href="<?php
        $pm = (int)$month - 1;
        $py = (int)$year;
        if ($pm < 1) { $pm = 12; $py--; }
        echo admin_url('reports/daily_sales/' . (isset($warehouse_id) ? $warehouse_id : 0) . '/' . $py . '/' . str_pad($pm, 2, '0', STR_PAD_LEFT));
      ?>" class="btn btn-outline-secondary btn-sm">
        <span class="icon-base ri ri-arrow-left-s-line icon-16px"></span>
      </a>
      <h6 class="mb-0 fw-semibold">
        <?php
        $months_names = [
          1 => lang('cal_january'), 2 => lang('cal_february'), 3 => lang('cal_march'),
          4 => lang('cal_april'), 5 => lang('cal_may'), 6 => lang('cal_june'),
          7 => lang('cal_july'), 8 => lang('cal_august'), 9 => lang('cal_september'),
          10 => lang('cal_october'), 11 => lang('cal_november'), 12 => lang('cal_december')
        ];
        echo $months_names[(int)$month] . ' ' . $year;
        ?>
      </h6>
      <a href="<?php
        $nm = (int)$month + 1;
        $ny = (int)$year;
        if ($nm > 12) { $nm = 1; $ny++; }
        echo admin_url('reports/daily_sales/' . (isset($warehouse_id) ? $warehouse_id : 0) . '/' . $ny . '/' . str_pad($nm, 2, '0', STR_PAD_LEFT));
      ?>" class="btn btn-outline-secondary btn-sm">
        <span class="icon-base ri ri-arrow-right-s-line icon-16px"></span>
      </a>
    </div>
  </div>
</div>

<!-- Calendar / day grid -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-calendar-2-line me-2 text-primary icon-18px"></span>
      <?php echo lang('get_day_profit') ?: 'Profit journalier'; ?>
    </h5>
    <p class="text-muted mt-1 mb-0 fs-small"><?php echo lang('reports_calendar_text') ?: 'Cliquez sur un jour pour les détails.'; ?></p>
  </div>
  <div class="card-body">
    <?php echo $calender; ?>
  </div>
</div>

<!-- ApexCharts hourly / daily bar chart placeholder -->
<?php if (isset($daily_data) && !empty($daily_data)): ?>
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-bar-chart-2-line me-2 text-primary icon-18px"></span>
      <?php echo lang('sales') ?: 'Ventes'; ?> — <?php echo $year . '/' . $month; ?>
    </h5>
  </div>
  <div class="card-body">
    <div id="dailySalesChart" style="min-height: 300px;"></div>
  </div>
</div>
<?php endif; ?>

<!-- Today's sales DataTable -->
<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-list-unordered me-2 text-primary icon-18px"></span>
      <?php echo lang('sales') ?: 'Ventes'; ?> — <?php echo $year . '/' . $month; ?>
    </h5>
    <a href="#" id="xls" class="btn btn-outline-success btn-sm">
      <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
      <?php echo lang('download_xls') ?: 'Excel'; ?>
    </a>
  </div>
  <div class="card-datatable table-responsive">
    <table id="DailySaleData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('customer') ?: 'Client'; ?></th>
          <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
          <th><?php echo lang('paid') ?: 'Payé'; ?></th>
          <th><?php echo lang('balance') ?: 'Solde'; ?></th>
          <th><?php echo lang('payment_status') ?: 'Statut'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="7" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="3"><?php echo lang('total') ?: 'Total'; ?></th>
          <th id="footTotal"></th>
          <th id="footPaid"></th>
          <th id="footBalance"></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  <?php if (isset($daily_data) && !empty($daily_data)): ?>
  // Build chart data from PHP
  var chartDays   = [];
  var chartSales  = [];
  <?php foreach ($daily_data as $d): ?>
  chartDays.push('<?php echo $d->day; ?>');
  chartSales.push(<?php echo (float)$d->total; ?>);
  <?php endforeach; ?>

  var dailyChartOptions = {
    chart: { type: 'bar', height: 300, toolbar: { show: false } },
    plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
    dataLabels: { enabled: false },
    series: [{ name: '<?php echo lang('sales') ?: 'Ventes'; ?>', data: chartSales }],
    xaxis: { categories: chartDays },
    colors: ['#7367f0'],
    yaxis: { labels: { formatter: function (v) { return currencyFormat(v); } } },
    tooltip: { y: { formatter: function (v) { return currencyFormat(v); } } }
  };
  new ApexCharts(document.getElementById('dailySalesChart'), dailyChartOptions).render();
  <?php endif; ?>

  $('#DailySaleData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getSalesReport/?v=1&start_date=' . $year . '-' . $month . '-01&end_date=' . $year . '-' . $month . '-31' . (isset($warehouse_id) && $warehouse_id ? '&warehouse=' . $warehouse_id : '')); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { render: function (d) { return d; } },
      null, null,
      { render: function (d) { return '<strong>' + currencyFormat(parseFloat(d)) + '</strong>'; } },
      { render: function (d) { return currencyFormat(parseFloat(d)); } },
      { render: function (d) {
          var v = parseFloat(d);
          return v > 0 ? '<span class="text-danger">' + currencyFormat(v) + '</span>' : '<span class="text-success">0</span>';
        }
      },
      { render: function (d) { return typeof row_status === 'function' ? row_status(d) : d; } }
    ],
    rowCallback: function (row, data) {
      row.className += ' invoice_link2';
    },
    footerCallback: function (row, data, start, end, display) {
      var total = 0, paid = 0, balance = 0;
      for (var i = 0; i < data.length; i++) {
        total   += parseFloat(data[display[i]][3]) || 0;
        paid    += parseFloat(data[display[i]][4]) || 0;
        balance += parseFloat(data[display[i]][5]) || 0;
      }
      document.getElementById('footTotal').innerHTML   = '<strong>' + currencyFormat(total) + '</strong>';
      document.getElementById('footPaid').innerHTML    = currencyFormat(paid);
      document.getElementById('footBalance').innerHTML = balance > 0
        ? '<span class="text-danger">' + currencyFormat(balance) + '</span>'
        : '<span class="text-success">0</span>';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  // Day click → modal
  document.addEventListener('click', function (e) {
    var el = e.target.closest('.day_num');
    if (!el) return;
    var day  = el.textContent.trim();
    var date = '<?php echo $year . '-' . $month . '-'; ?>' + day;
    var href = '<?php echo admin_url('reports/profit'); ?>/' + date + '/<?php echo isset($warehouse_id) ? $warehouse_id : ''; ?>';
    $.get(href, function (data) { $('#myModal').html(data).modal('show'); });
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/daily_sales/' . (isset($warehouse_id) ? $warehouse_id : 0) . '/' . $year . '/' . $month . '/0/xls'); ?>';
  });
})();
</script>
