<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('product'))      $v .= '&product='      . $this->input->post('product');
if ($this->input->post('reference_no')) $v .= '&reference_no=' . $this->input->post('reference_no');
if ($this->input->post('customer'))     $v .= '&customer='     . $this->input->post('customer');
if ($this->input->post('biller'))       $v .= '&biller='       . $this->input->post('biller');
if ($this->input->post('warehouse'))    $v .= '&warehouse='    . $this->input->post('warehouse');
if ($this->input->post('user'))         $v .= '&user='         . $this->input->post('user');
if ($this->input->post('start_date'))   $v .= '&start_date='   . $this->input->post('start_date');
if ($this->input->post('end_date'))     $v .= '&end_date='     . $this->input->post('end_date');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-arrow-go-back-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('returns_report') ?: 'Rapport des retours'; ?>
        <?php if ($this->input->post('start_date')): ?>
          <small class="text-muted fs-6 fw-normal">
            — <?php echo $this->input->post('start_date'); ?> → <?php echo $this->input->post('end_date'); ?>
          </small>
        <?php endif; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('returns_report') ?: 'Rapport des retours'; ?></li>
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
    <?php echo admin_form_open('reports/returns', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
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
          <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : '', 'class="form-control" id="reference_no" placeholder="Référence"'); ?>
          <label for="reference_no"><?php echo lang('reference_no') ?: 'Référence'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('customer', isset($_POST['customer']) ? $_POST['customer'] : '', 'class="form-control" id="customer" placeholder="Client"'); ?>
          <label for="customer"><?php echo lang('customer') ?: 'Client'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $bl = ['' => lang('select') . ' ' . (lang('biller') ?: 'Factureur')];
          foreach ($billers as $biller) {
              $bl[$biller->id] = ($biller->company && $biller->company != '-') ? $biller->company : $biller->name;
          }
          echo form_dropdown('biller', $bl, isset($_POST['biller']) ? $_POST['biller'] : '',
            'class="form-select select2" id="biller" data-placeholder="' . lang('select') . ' ' . (lang('biller') ?: 'Factureur') . '"');
          ?>
          <label for="biller"><?php echo lang('biller') ?: 'Factureur'; ?></label>
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
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $us = ['' => lang('select') . ' ' . (lang('user') ?: 'Utilisateur')];
          foreach ($users as $user) {
              $us[$user->id] = $user->first_name . ' ' . $user->last_name;
          }
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
      <a href="<?php echo admin_url('reports/returns'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="REData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="width:30px;"></th>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('biller') ?: 'Factureur'; ?></th>
          <th><?php echo lang('customer') ?: 'Client'; ?></th>
          <th style="width:30px;"><span class="icon-base ri ri-attachment-line icon-16px"></span></th>
          <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="7" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th><th></th><th></th><th></th><th></th><th></th>
          <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
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
  <?php if (!$this->input->post('start_date')): ?>
  filterCard.style.display = 'none';
  <?php endif; ?>

  var oTable = $('#REData').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'desc'], [2, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getReturnsReport/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { visible: false, orderable: false, render: function (d) { return d; } },
      { render: function (d) { return d; } },
      null, null, null,
      { orderable: false, render: function (d) { return d; } },
      { render: function (d) { return '<strong>' + currencyFormat(parseFloat(d)) + '</strong>'; } }
    ],
    rowCallback: function (row, data) {
      row.id = data[0];
      row.className += ' oreturn_link';
    },
    footerCallback: function (row, data, start, end, display) {
      var gtotal = 0;
      for (var i = 0; i < data.length; i++) {
        gtotal += parseFloat(data[display[i]][6]) || 0;
      }
      var cells = row.getElementsByTagName('th');
      cells[6].innerHTML = '<strong>' + currencyFormat(gtotal) + '</strong>';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getReturnsReport/0/xls/?v=1' . $v); ?>';
  });
})();
</script>
