<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('product'))      $v .= '&product='      . $this->input->post('product');
if ($this->input->post('category'))     $v .= '&category='     . $this->input->post('category');
if ($this->input->post('subcategory'))  $v .= '&subcategory='  . $this->input->post('subcategory');
if ($this->input->post('brand'))        $v .= '&brand='        . $this->input->post('brand');
if ($this->input->post('warehouse'))    $v .= '&warehouse='    . $this->input->post('warehouse');
if ($this->input->post('user'))         $v .= '&user='         . $this->input->post('user');
if ($this->input->post('start_date'))   $v .= '&start_date='   . $this->input->post('start_date');
if ($this->input->post('end_date'))     $v .= '&end_date='     . $this->input->post('end_date');
if ($this->input->post('cf1'))          $v .= '&cf1='          . $this->input->post('cf1');
if ($this->input->post('cf2'))          $v .= '&cf2='          . $this->input->post('cf2');
if ($this->input->post('cf3'))          $v .= '&cf3='          . $this->input->post('cf3');
if ($this->input->post('cf4'))          $v .= '&cf4='          . $this->input->post('cf4');
if ($this->input->post('cf5'))          $v .= '&cf5='          . $this->input->post('cf5');
if ($this->input->post('cf6'))          $v .= '&cf6='          . $this->input->post('cf6');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-box-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('products_report') ?: 'Rapport des produits'; ?>
        <?php if ($this->input->post('start_date')): ?>
          <small class="text-muted fs-6 fw-normal">
            — <?php echo $this->input->post('start_date'); ?> &rarr; <?php echo $this->input->post('end_date'); ?>
          </small>
        <?php endif; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><span class="icon-base ri ri-home-line icon-20px"></span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('products_report') ?: 'Rapport des produits'; ?></li>
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
        <?php echo lang('show_form') ?: 'Filtres'; ?>
      </button>
    </div>
</div>

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
    <?php echo admin_form_open('reports/products', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
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
          $cat = ['' => lang('select') . ' ' . (lang('category') ?: 'Catégorie')];
          foreach ($categories as $category) { $cat[$category->id] = $category->name; }
          echo form_dropdown('category', $cat, isset($_POST['category']) ? $_POST['category'] : '',
            'class="form-select select2" id="category" data-placeholder="' . lang('select') . ' ' . (lang('category') ?: 'Catégorie') . '"');
          ?>
          <label for="category"><?php echo lang('category') ?: 'Catégorie'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('subcategory', isset($_POST['subcategory']) ? $_POST['subcategory'] : '', 'class="form-control" id="subcategory" placeholder="' . (lang('select_category_to_load') ?: 'Sous-catégorie') . '"'); ?>
          <label for="subcategory"><?php echo lang('subcategory') ?: 'Sous-catégorie'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $bt = ['' => lang('select') . ' ' . (lang('brand') ?: 'Marque')];
          foreach ($brands as $brand) { $bt[$brand->id] = $brand->name; }
          echo form_dropdown('brand', $bt, isset($_POST['brand']) ? $_POST['brand'] : '',
            'class="form-select select2" id="brand" data-placeholder="' . lang('select') . ' ' . (lang('brand') ?: 'Marque') . '"');
          ?>
          <label for="brand"><?php echo lang('brand') ?: 'Marque'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $wh = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
          foreach ($warehouses as $whr) { $wh[$whr->id] = $whr->name; }
          echo form_dropdown('warehouse', $wh, isset($_POST['warehouse']) ? $_POST['warehouse'] : '',
            'class="form-select select2" id="warehouse" data-placeholder="' . lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt') . '"');
          ?>
          <label for="warehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $us = ['' => lang('select') . ' ' . (lang('user') ?: 'Utilisateur')];
          foreach ($users as $user) { $us[$user->id] = $user->first_name . ' ' . $user->last_name; }
          echo form_dropdown('user', $us, isset($_POST['user']) ? $_POST['user'] : '',
            'class="form-select select2" id="user" data-placeholder="' . lang('select') . ' ' . (lang('user') ?: 'Utilisateur') . '"');
          ?>
          <label for="user"><?php echo lang('created_by') ?: 'Créé par'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('start_date', isset($_POST['start_date']) ? $_POST['start_date'] : '', 'class="form-control flatpickr-date" id="start_date" placeholder="Date début"'); ?>
          <label for="start_date"><?php echo lang('start_date') ?: 'Date début'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('end_date', isset($_POST['end_date']) ? $_POST['end_date'] : '', 'class="form-control flatpickr-date" id="end_date" placeholder="Date fin"'); ?>
          <label for="end_date"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
        </div>
      </div>
    </div>
    <div class="mt-4 d-flex gap-3">
      <?php echo form_submit('submit_report', lang('submit') ?: 'Appliquer', 'class="btn btn-primary"'); ?>
      <a href="<?php echo admin_url('reports/products'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="PrRData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('product_code') ?: 'Code'; ?></th>
          <th><?php echo lang('product_name') ?: 'Produit'; ?></th>
          <th><?php echo lang('purchased') ?: 'Acheté'; ?></th>
          <th><?php echo lang('sold') ?: 'Vendu'; ?></th>
          <th><?php echo lang('profit_loss') ?: 'Bénéfice/Perte'; ?></th>
          <th><?php echo lang('stock_in_hand') ?: 'Stock disponible'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="6" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th>
          <th></th>
          <th><?php echo lang('purchased') ?: 'Acheté'; ?></th>
          <th><?php echo lang('sold') ?: 'Vendu'; ?></th>
          <th><?php echo lang('profit_loss') ?: 'Bénéfice/Perte'; ?></th>
          <th><?php echo lang('stock_in_hand') ?: 'Stock disponible'; ?></th>
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
  <?php if (!$this->input->post('submit_report')): ?>
  filterCard.style.display = 'none';
  <?php endif; ?>

  function spb(x) {
    var v = x.split('__');
    return '(' + formatQuantity2(v[0]) + ') <strong>' + currencyFormat(v[1]) + '</strong>';
  }

  var oTable = $('#PrRData').dataTable({
    aaSorting: [[3, 'desc'], [2, 'desc']],
    aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    iDisplayLength: <?php echo (int)$Settings->rows_per_page; ?>,
    bProcessing: true,
    bServerSide: true,
    sAjaxSource: '<?php echo admin_url('reports/getProductsReport/?v=1' . $v); ?>',
    fnServerData: function (sSource, aoData, fnCallback) {
      aoData.push({
        name: '<?php echo $this->security->get_csrf_token_name(); ?>',
        value: '<?php echo $this->security->get_csrf_hash(); ?>'
      });
      $.ajax({ dataType: 'json', type: 'POST', url: sSource, data: aoData, success: fnCallback });
    },
    fnRowCallback: function (nRow, aData) {
      nRow.id = aData[6];
      nRow.className = 'product_link2';
      return nRow;
    },
    aoColumns: [
      null, null,
      { mRender: spb },
      { mRender: spb },
      { mRender: currencyFormat },
      { mRender: spb }
    ],
    fnFooterCallback: function (nRow, aaData, iStart, iEnd, aiDisplay) {
      var pq = 0, sq = 0, bq = 0, pa = 0, sa = 0, ba = 0, pl = 0;
      for (var i = 0; i < aaData.length; i++) {
        var p = (aaData[aiDisplay[i]][2]).split('__');
        var s = (aaData[aiDisplay[i]][3]).split('__');
        var b = (aaData[aiDisplay[i]][5]).split('__');
        pq += parseFloat(p[0]); pa += parseFloat(p[1]);
        sq += parseFloat(s[0]); sa += parseFloat(s[1]);
        bq += parseFloat(b[0]); ba += parseFloat(b[1]);
        pl += parseFloat(aaData[aiDisplay[i]][4]);
      }
      var cells = nRow.getElementsByTagName('th');
      cells[2].innerHTML = '<div class="text-end">(' + formatQuantity2(pq) + ') ' + currencyFormat(pa) + '</div>';
      cells[3].innerHTML = '<div class="text-end">(' + formatQuantity2(sq) + ') ' + currencyFormat(sa) + '</div>';
      cells[4].innerHTML = currencyFormat(parseFloat(pl));
      cells[5].innerHTML = '<div class="text-end">(' + formatQuantity2(bq) + ') ' + currencyFormat(ba) + '</div>';
    }
  }).fnSetFilteringDelay().dtFilter([
    { column_number: 0, filter_default_label: '[<?php echo lang('product_code'); ?>]', filter_type: 'text', data: [] },
    { column_number: 1, filter_default_label: '[<?php echo lang('product_name'); ?>]', filter_type: 'text', data: [] }
  ], 'footer');

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getProductsReport/0/xls/?v=1' . $v); ?>';
  });

  // Subcategory dynamic load
  $('#category').on('change', function () {
    var v = $(this).val();
    if (v) {
      $.ajax({
        type: 'GET', async: false,
        url: '<?php echo admin_url('products/getSubCategories'); ?>/' + v,
        dataType: 'json',
        success: function (scdata) {
          if (scdata) {
            $('#subcategory').val('').trigger('change');
          }
        }
      });
    }
  });
})();
</script>
