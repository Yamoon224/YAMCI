<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-trophy-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('best_sellers') ?: 'Meilleures ventes'); ?></h4>
    <p class="mb-0 text-muted">Classement des produits les plus vendus par quantité, montant et profit.</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo $page_title ?? (lang('best_sellers') ?: 'Meilleures ventes'); ?></li>
      </ol>
    </nav>
  </div>
</div>

<!-- Filter -->
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <h5 class="card-title mb-0"><span class="icon-base ri ri-filter-line me-2 icon-18px"></span><?php echo lang('filter') ?: 'Filtres'; ?></h5>
    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#bsFilter">
      <span class="icon-base ri ri-equalizer-line me-1 icon-14px"></span>Filtres
    </button>
  </div>
  <div class="collapse show" id="bsFilter">
    <div class="card-body border-top">
      <?php echo admin_form_open('reports/best_sellers', ['method' => 'post']); ?>
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <?php
            $wh_opts = ['' => lang('all_warehouses') ?: 'Tous les entrepôts'];
            if (isset($warehouses)) foreach ($warehouses as $wh) $wh_opts[$wh->id] = $wh->name;
            echo form_dropdown('warehouse', $wh_opts, $this->input->post('warehouse') ?: '', 'class="form-select select2" id="bsWh"');
            ?>
            <label for="bsWh"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" name="start_date" id="bsStart"
                   placeholder="Start" value="<?php echo $this->input->post('start_date') ?: ''; ?>" />
            <label for="bsStart"><?php echo lang('start_date') ?: 'Date début'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" name="end_date" id="bsEnd"
                   placeholder="End" value="<?php echo $this->input->post('end_date') ?: ''; ?>" />
            <label for="bsEnd"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
          </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-fill">
            <span class="icon-base ri ri-search-line me-1 icon-16px"></span><?php echo lang('search') ?: 'Rechercher'; ?>
          </button>
          <a href="<?php echo admin_url('reports/best_sellers'); ?>" class="btn btn-outline-secondary">
            <span class="icon-base ri ri-refresh-line icon-16px"></span>
          </a>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Chart -->
<?php if (!empty($m2bs)): ?>
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-bar-chart-2-line me-2 text-primary icon-18px"></span>
      <?php echo lang('best_sellers') ?: 'Top produits vendus'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div id="bestSellersChart"></div>
  </div>
</div>
<?php endif; ?>

<!-- Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="bsTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th>#</th>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th class="text-end"><?php echo lang('sold_qty') ?: 'Qté vendue'; ?></th>
          <th class="text-end"><?php echo lang('sale_amount') ?: 'Montant'; ?></th>
          <th class="text-end"><?php echo lang('profit') ?: 'Profit'; ?></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th colspan="2"><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-end"></th>
          <th class="text-end"></th>
          <th class="text-end"></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  <?php
  $v = '';
  if ($this->input->post('warehouse'))   $v .= '&warehouse='   . $this->input->post('warehouse');
  if ($this->input->post('start_date'))  $v .= '&start_date='  . $this->input->post('start_date');
  if ($this->input->post('end_date'))    $v .= '&end_date='    . $this->input->post('end_date');
  ?>
  <?php if (!empty($m2bs)): ?>
  // ApexCharts bar chart
  var chartLabels = [<?php foreach ($m2bs as $r) { if ($r->quantity > 0) echo '"' . addslashes($r->product_name) . '",'; } ?>];
  var chartData   = [<?php foreach ($m2bs as $r) { if ($r->quantity > 0) echo (float)$r->quantity . ','; } ?>];

  if (typeof ApexCharts !== 'undefined' && chartLabels.length > 0) {
    new ApexCharts(document.querySelector('#bestSellersChart'), {
      chart: { type: 'bar', height: 300, toolbar: { show: false } },
      series: [{ name: '<?php echo addslashes(lang('sold') ?: 'Vendu'); ?>', data: chartData }],
      xaxis: { categories: chartLabels, labels: { rotate: -45, style: { fontSize: '11px' } } },
      colors: ['#666cff'],
      dataLabels: { enabled: true },
      grid: { strokeDashArray: 5 }
    }).render();
  }
  <?php endif; ?>

  $('#bsTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[2, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getBestSellers/?v=1' . $v); ?>',
      type: 'POST',
      data: function(d){ d['<?php echo $this->security->get_csrf_token_name();?>'] = '<?php echo $this->security->get_csrf_hash();?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { render: function(d,t,r,m){ return m.row+1; } },
      null,
      { className:'text-end', render:function(d){return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2});} },
      { className:'text-end', render:function(d){return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2});} },
      { className:'text-end', render:function(d){
          var v=parseFloat(d||0);
          return '<span class="'+(v>=0?'text-success':'text-danger')+'">'+v.toLocaleString(undefined,{minimumFractionDigits:2})+'</span>';
        }
      }
    ],
    footerCallback: function(row, data) {
      var t2=0,t3=0,t4=0;
      data.forEach(function(r){t2+=parseFloat(r[2]||0);t3+=parseFloat(r[3]||0);t4+=parseFloat(r[4]||0);});
      var cells=row.querySelectorAll('th');
      cells[2].innerHTML=t2.toLocaleString(undefined,{minimumFractionDigits:2});
      cells[3].innerHTML=t3.toLocaleString(undefined,{minimumFractionDigits:2});
      cells[4].innerHTML='<span class="'+(t4>=0?'text-success':'text-danger')+'">'+t4.toLocaleString(undefined,{minimumFractionDigits:2})+'</span>';
    },
    lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'<?php echo lang('all')?>']],
    dom:'<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
