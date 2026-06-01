<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('product'))   $v .= '&product='   . $this->input->post('product');
if ($this->input->post('category'))  $v .= '&category='  . $this->input->post('category');
if ($this->input->post('brand'))     $v .= '&brand='      . $this->input->post('brand');
if ($this->input->post('warehouse')) $v .= '&warehouse=' . $this->input->post('warehouse');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-store-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('warehouse_stock') ?: 'Stock par entrepôt'; ?>
        <?php if (isset($warehouse) && $warehouse): ?>
          <small class="text-muted fs-6 fw-normal">— <?php echo $warehouse->name; ?></small>
        <?php else: ?>
          <small class="text-muted fs-6 fw-normal">— <?php echo lang('all_warehouses') ?: 'Tous les entrepôts'; ?></small>
        <?php endif; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('warehouse_stock') ?: 'Stock par entrepôt'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <a href="#" id="xls" class="btn btn-outline-success btn-sm">
        <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
        <?php echo lang('download_xls') ?: 'Excel'; ?>
      </a>
      <button class="btn btn-outline-secondary btn-sm" id="toggleFilterBtn" type="button">
        <span class="icon-base ri ri-filter-3-line me-1 icon-16px"></span>
        <?php echo lang('filters') ?: 'Filtres'; ?>
      </button>
    </div>
</div>

<!-- Summary Cards -->
<?php if (isset($totals) && $totals): ?>
<div class="row g-4 mb-4">
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <p class="text-muted mb-1"><?php echo lang('total_items') ?: 'Total articles'; ?></p>
            <h4 class="mb-0 fw-semibold text-primary"><?php echo $this->sma->formatQuantity($totals->total_items); ?></h4>
          </div>
          <div class="avatar avatar-sm bg-label-primary">
            <span class="icon-base ri ri-list-check icon-20px"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-xl-3">
    <div class="card">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between">
          <div>
            <p class="text-muted mb-1"><?php echo lang('total_quantity') ?: 'Quantité totale'; ?></p>
            <h4 class="mb-0 fw-semibold text-success"><?php echo $this->sma->formatQuantity($totals->total_quantity); ?></h4>
          </div>
          <div class="avatar avatar-sm bg-label-success">
            <span class="icon-base ri ri-stack-line icon-20px"></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Filter Card -->
<div class="card mb-4" id="filterCard">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-filter-3-line me-2 text-primary icon-18px"></span>
      <?php echo lang('customize_report') ?: 'Personnaliser le rapport'; ?>
    </h5>
    <button type="button" class="btn-close" id="closeFilterBtn" aria-label="Close"></button>
  </div>
  <div class="card-body">
    <?php echo admin_form_open('reports/warehouse_stock', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
    <div class="row g-4">
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('sproduct', isset($_POST['sproduct']) ? $_POST['sproduct'] : '', 'class="form-control" id="suggest_product" placeholder="Produit"'); ?>
          <input type="hidden" name="product" value="<?php echo isset($_POST['product']) ? $_POST['product'] : ''; ?>" id="report_product_id" />
          <label for="suggest_product"><?php echo lang('product') ?: 'Produit'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $cats = ['' => lang('select') . ' ' . (lang('category') ?: 'Catégorie')];
          if (!empty($categories)) {
              foreach ($categories as $cat) {
                  $cats[$cat->id] = $cat->name;
              }
          }
          echo form_dropdown('category', $cats, isset($_POST['category']) ? $_POST['category'] : '',
            'class="form-select select2" id="category" data-placeholder="' . (lang('category') ?: 'Catégorie') . '"');
          ?>
          <label for="category"><?php echo lang('category') ?: 'Catégorie'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $brands = ['' => lang('select') . ' ' . (lang('brand') ?: 'Marque')];
          if (!empty($product_brands)) {
              foreach ($product_brands as $brand) {
                  $brands[$brand->id] = $brand->name;
              }
          }
          echo form_dropdown('brand', $brands, isset($_POST['brand']) ? $_POST['brand'] : '',
            'class="form-select select2" id="brand" data-placeholder="' . (lang('brand') ?: 'Marque') . '"');
          ?>
          <label for="brand"><?php echo lang('brand') ?: 'Marque'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $wh = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
          foreach ($warehouses as $warehouse) {
              $wh[$warehouse->id] = $warehouse->name;
          }
          echo form_dropdown('warehouse', $wh, isset($_POST['warehouse']) ? $_POST['warehouse'] : '',
            'class="form-select select2" id="warehouse" data-placeholder="' . lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt') . '"');
          ?>
          <label for="warehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
        </div>
      </div>
    </div>
    <div class="mt-4 d-flex gap-3">
      <?php echo form_submit('submit_report', lang('submit') ?: 'Appliquer', 'class="btn btn-primary"'); ?>
      <a href="<?php echo admin_url('reports/warehouse_stock'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="WStockData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('product_code') ?: 'Code'; ?></th>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th><?php echo lang('category') ?: 'Catégorie'; ?></th>
          <th><?php echo lang('brand') ?: 'Marque'; ?></th>
          <?php if (!empty($warehouses)): ?>
            <?php foreach ($warehouses as $wh): ?>
            <th><?php echo $wh->name; ?></th>
            <?php endforeach; ?>
          <?php endif; ?>
          <th><?php echo lang('total') ?: 'Total'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="10" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot>
        <tr>
          <th colspan="4"><?php echo lang('total') ?: 'Total'; ?></th>
          <?php if (!empty($warehouses)): ?>
            <?php foreach ($warehouses as $wh): ?>
            <th></th>
            <?php endforeach; ?>
          <?php endif; ?>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  var filterCard = document.getElementById('filterCard');
  document.getElementById('toggleFilterBtn').addEventListener('click', function () {
    filterCard.style.display = filterCard.style.display === 'none' ? '' : 'none';
  });
  document.getElementById('closeFilterBtn').addEventListener('click', function () {
    filterCard.style.display = 'none';
  });
  <?php if (!$this->input->post('warehouse') && !$this->input->post('product')): ?>
  filterCard.style.display = 'none';
  <?php endif; ?>

  var oTable = $('#WStockData').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'asc']],
    ajax: {
      url: '<?php echo admin_url('reports/getWarehouseStock/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getWarehouseStock/0/xls/?v=1' . $v); ?>';
  });
})();
</script>
