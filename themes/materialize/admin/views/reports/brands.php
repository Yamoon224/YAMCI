<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-price-tag-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('brands_report') ?: 'Rapport par Marques'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('brands_report') ?: 'Rapport Marques'; ?></li>
      </ol>
    </nav>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-filter-line me-2 text-primary icon-18px"></span>
      <?php echo lang('filter') ?: 'Filtres'; ?>
    </h5>
    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#brandFilter">
      <span class="icon-base ri ri-equalizer-line me-1 icon-14px"></span><?php echo lang('toggle_filter') ?: 'Afficher / Masquer'; ?>
    </button>
  </div>
  <div class="collapse show" id="brandFilter">
    <div class="card-body border-top">
      <?php echo admin_form_open('reports/brands', ['id' => 'brandFilterForm', 'method' => 'post']); ?>
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <?php
            $wh_opts = ['' => lang('all_warehouses') ?: 'Tous les entrepôts'];
            if (isset($warehouses)) foreach ($warehouses as $wh) $wh_opts[$wh->id] = $wh->name;
            echo form_dropdown('warehouse', $wh_opts, $this->input->post('warehouse') ?: '',
              'class="form-select select2" id="rptWarehouse"');
            ?>
            <label for="rptWarehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="rptStart" name="start_date"
                   placeholder="Start" value="<?php echo $this->input->post('start_date') ?: ''; ?>" />
            <label for="rptStart"><?php echo lang('start_date') ?: 'Date début'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="rptEnd" name="end_date"
                   placeholder="End" value="<?php echo $this->input->post('end_date') ?: ''; ?>" />
            <label for="rptEnd"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
          </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-fill">
            <span class="icon-base ri ri-search-line me-1 icon-16px"></span><?php echo lang('search') ?: 'Rechercher'; ?>
          </button>
          <a href="<?php echo admin_url('reports/brands'); ?>" class="btn btn-outline-secondary">
            <span class="icon-base ri ri-refresh-line icon-16px"></span>
          </a>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<!-- Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="brandsTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('brand') ?: 'Marque'; ?></th>
          <th class="text-end"><?php echo lang('purchased_qty') ?: 'Qté achetée'; ?></th>
          <th class="text-end"><?php echo lang('sold_qty') ?: 'Qté vendue'; ?></th>
          <th class="text-end"><?php echo lang('purchase_amount') ?: 'Montant achats'; ?></th>
          <th class="text-end"><?php echo lang('sale_amount') ?: 'Montant ventes'; ?></th>
          <th class="text-end"><?php echo lang('profit_loss') ?: 'Profit/Perte'; ?></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-end"></th>
          <th class="text-end"></th>
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
  var csrf_name  = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrf_hash  = '<?php echo $this->security->get_csrf_hash(); ?>';

  <?php
  $v = '';
  if ($this->input->post('warehouse'))   $v .= '&warehouse='   . $this->input->post('warehouse');
  if ($this->input->post('start_date'))  $v .= '&start_date='  . $this->input->post('start_date');
  if ($this->input->post('end_date'))    $v .= '&end_date='    . $this->input->post('end_date');
  ?>

  $('#brandsTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'asc']],
    ajax: {
      url: '<?php echo admin_url('reports/getBrandsReport/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) { d[csrf_name] = csrf_hash; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null,
      { className: 'text-end', render: function(d){ return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2}); } },
      { className: 'text-end', render: function(d){ return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2}); } },
      { className: 'text-end', render: function(d){ return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2}); } },
      { className: 'text-end', render: function(d){ return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2}); } },
      { className: 'text-end', render: function(d){
          var v = parseFloat(d||0);
          return '<span class="' + (v>=0?'text-success':'text-danger') + '">' + v.toLocaleString(undefined,{minimumFractionDigits:2}) + '</span>';
        }
      }
    ],
    footerCallback: function(row, data) {
      var cols = [1,2,3,4,5];
      var totals = [0,0,0,0,0];
      data.forEach(function(r){ cols.forEach(function(c,i){ totals[i] += parseFloat(r[c]||0); }); });
      var cells = row.querySelectorAll('th');
      cells[1].innerHTML = totals[0].toLocaleString(undefined,{minimumFractionDigits:2});
      cells[2].innerHTML = totals[1].toLocaleString(undefined,{minimumFractionDigits:2});
      cells[3].innerHTML = totals[2].toLocaleString(undefined,{minimumFractionDigits:2});
      cells[4].innerHTML = totals[3].toLocaleString(undefined,{minimumFractionDigits:2});
      cells[5].innerHTML = '<span class="' + (totals[4]>=0?'text-success':'text-danger') + '">' + totals[4].toLocaleString(undefined,{minimumFractionDigits:2}) + '</span>';
    },
    lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'<?php echo lang('all')?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
