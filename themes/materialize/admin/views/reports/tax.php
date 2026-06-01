<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('biller'))    $v .= '&biller='     . $this->input->post('biller');
if ($this->input->post('warehouse')) $v .= '&warehouse='  . $this->input->post('warehouse');
if ($this->input->post('start_date')) $v .= '&start_date=' . $this->input->post('start_date');
if ($this->input->post('end_date'))  $v .= '&end_date='   . $this->input->post('end_date');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-percent-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('tax_report') ?: 'Rapport de taxes'; ?>
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
        <li class="breadcrumb-item active"><?php echo lang('tax_report') ?: 'Rapport de taxes'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
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
    <?php echo admin_form_open('reports/tax', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
    <div class="row g-4">
      <div class="col-sm-6 col-md-3">
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
      <div class="col-sm-6 col-md-3">
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
      <div class="col-sm-6 col-md-3">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('start_date', isset($_POST['start_date']) ? $_POST['start_date'] : '', 'class="form-control flatpickr-date" id="start_date" placeholder="Date début"'); ?>
          <label for="start_date"><?php echo lang('start_date') ?: 'Date début'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-3">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('end_date', isset($_POST['end_date']) ? $_POST['end_date'] : '', 'class="form-control flatpickr-date" id="end_date" placeholder="Date fin"'); ?>
          <label for="end_date"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
        </div>
      </div>
    </div>
    <div class="mt-4 d-flex gap-3">
      <?php echo form_submit('submit_report', lang('submit') ?: 'Appliquer', 'class="btn btn-primary"'); ?>
      <a href="<?php echo admin_url('reports/tax'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Tabs: Sales / Purchases -->
<ul class="nav nav-tabs mb-4" id="taxTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="sales-tax-tab" data-bs-toggle="tab" data-bs-target="#sales-tax-con" type="button" role="tab">
      <span class="icon-base ri ri-shopping-cart-line me-1 icon-16px"></span>
      <?php echo lang('sales') ?: 'Ventes'; ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="purchases-tax-tab" data-bs-toggle="tab" data-bs-target="#purchases-tax-con" type="button" role="tab">
      <span class="icon-base ri ri-shopping-bag-3-line me-1 icon-16px"></span>
      <?php echo lang('purchases') ?: 'Achats'; ?>
    </button>
  </li>
</ul>

<div class="tab-content">

  <!-- ===== SALES TAX ===== -->
  <div class="tab-pane fade show active" id="sales-tax-con" role="tabpanel">

    <!-- Summary cards -->
    <div class="row g-4 mb-4">
      <div class="col-sm-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div>
                <p class="text-muted mb-1"><?php echo lang('sales_amount') ?: 'Montant ventes'; ?></p>
                <h5 class="fw-semibold text-primary mb-0"><?php echo isset($sale_tax->grand_total) ? $this->sma->mf($sale_tax->grand_total) : '0.00'; ?></h5>
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
                <p class="text-muted mb-1"><?php echo lang('total_product_tax') ?: 'Taxe produit'; ?></p>
                <h5 class="fw-semibold text-warning mb-0"><?php echo isset($sale_tax->product_tax) ? $this->sma->mf($sale_tax->product_tax) : '0.00'; ?></h5>
              </div>
              <div class="avatar avatar-sm bg-label-warning">
                <span class="icon-base ri ri-percent-line icon-20px"></span>
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
                <p class="text-muted mb-1"><?php echo lang('total_order_tax') ?: 'Taxe commande'; ?></p>
                <h5 class="fw-semibold text-info mb-0"><?php echo isset($sale_tax->order_tax) ? $this->sma->mf($sale_tax->order_tax) : '0.00'; ?></h5>
              </div>
              <div class="avatar avatar-sm bg-label-info">
                <span class="icon-base ri ri-file-list-3-line icon-20px"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-4 d-flex flex-row justify-content-end px-3 py-2 gap-2">
      <a href="#" id="xls-sales" class="btn btn-outline-success btn-sm">
        <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
        <?php echo lang('download_xls') ?: 'Excel'; ?>
      </a>
    </div>

    <div class="card">
      <div class="card-datatable table-responsive">
        <table id="TAXData" class="table datatables-ajax border-top">
          <thead>
            <tr>
              <th><?php echo lang('date') ?: 'Date'; ?></th>
              <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
              <th><?php echo lang('status') ?: 'Statut'; ?></th>
              <th><?php echo lang('warehouse') ?: 'Entrepôt'; ?></th>
              <th><?php echo lang('biller') ?: 'Factureur'; ?></th>
              <?php if ($Settings->indian_gst): ?>
              <th><?php echo lang('igst') ?: 'IGST'; ?></th>
              <th><?php echo lang('cgst') ?: 'CGST'; ?></th>
              <th><?php echo lang('sgst') ?: 'SGST'; ?></th>
              <?php endif; ?>
              <th><?php echo lang('product_tax') ?: 'Taxe produit'; ?></th>
              <th><?php echo lang('order_tax') ?: 'Taxe ordre'; ?></th>
              <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="<?php echo $Settings->indian_gst ? 11 : 8; ?>" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
          </tbody>
          <tfoot class="dtFilter">
            <tr>
              <th></th><th></th><th></th><th></th><th></th>
              <?php if ($Settings->indian_gst): ?>
              <th></th><th></th><th></th>
              <?php endif; ?>
              <th><?php echo lang('product_tax') ?: 'Taxe produit'; ?></th>
              <th><?php echo lang('order_tax') ?: 'Taxe ordre'; ?></th>
              <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

  <!-- ===== PURCHASES TAX ===== -->
  <div class="tab-pane fade" id="purchases-tax-con" role="tabpanel">

    <!-- Summary cards -->
    <div class="row g-4 mb-4 mt-1">
      <div class="col-sm-6 col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
              <div>
                <p class="text-muted mb-1"><?php echo lang('purchase_amount') ?: 'Montant achats'; ?></p>
                <h5 class="fw-semibold text-primary mb-0"><?php echo isset($purchase_tax->grand_total) ? $this->sma->mf($purchase_tax->grand_total) : '0.00'; ?></h5>
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
                <p class="text-muted mb-1"><?php echo lang('total_product_tax') ?: 'Taxe produit'; ?></p>
                <h5 class="fw-semibold text-warning mb-0"><?php echo isset($purchase_tax->product_tax) ? $this->sma->mf($purchase_tax->product_tax) : '0.00'; ?></h5>
              </div>
              <div class="avatar avatar-sm bg-label-warning">
                <span class="icon-base ri ri-percent-line icon-20px"></span>
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
                <p class="text-muted mb-1"><?php echo lang('total_order_tax') ?: 'Taxe commande'; ?></p>
                <h5 class="fw-semibold text-info mb-0"><?php echo isset($purchase_tax->order_tax) ? $this->sma->mf($purchase_tax->order_tax) : '0.00'; ?></h5>
              </div>
              <div class="avatar avatar-sm bg-label-info">
                <span class="icon-base ri ri-file-list-3-line icon-20px"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-4 d-flex flex-row justify-content-end px-3 py-2 gap-2">
      <a href="#" id="xls-purchases" class="btn btn-outline-success btn-sm">
        <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span>
        <?php echo lang('download_xls') ?: 'Excel'; ?>
      </a>
    </div>

    <div class="card">
      <div class="card-datatable table-responsive">
        <table id="PTAXData" class="table datatables-ajax border-top">
          <thead>
            <tr>
              <th><?php echo lang('date') ?: 'Date'; ?></th>
              <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
              <th><?php echo lang('status') ?: 'Statut'; ?></th>
              <th><?php echo lang('warehouse') ?: 'Entrepôt'; ?></th>
              <th><?php echo lang('supplier') ?: 'Fournisseur'; ?></th>
              <?php if ($Settings->indian_gst): ?>
              <th><?php echo lang('igst') ?: 'IGST'; ?></th>
              <th><?php echo lang('cgst') ?: 'CGST'; ?></th>
              <th><?php echo lang('sgst') ?: 'SGST'; ?></th>
              <?php endif; ?>
              <th><?php echo lang('product_tax') ?: 'Taxe produit'; ?></th>
              <th><?php echo lang('order_tax') ?: 'Taxe ordre'; ?></th>
              <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="<?php echo $Settings->indian_gst ? 11 : 8; ?>" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
          </tbody>
          <tfoot class="dtFilter">
            <tr>
              <th></th><th></th><th></th><th></th><th></th>
              <?php if ($Settings->indian_gst): ?>
              <th></th><th></th><th></th>
              <?php endif; ?>
              <th><?php echo lang('product_tax') ?: 'Taxe produit'; ?></th>
              <th><?php echo lang('order_tax') ?: 'Taxe ordre'; ?></th>
              <th><?php echo lang('grand_total') ?: 'Total'; ?></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div><!-- /.tab-content -->

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

  function makeTaxFooterCallback(ptaxIdx, otaxIdx, gtotalIdx) {
    return function (row, data, start, end, display) {
      var ptax = 0, otax = 0, gtotal = 0, igst = 0, cgst = 0, sgst = 0;
      for (var i = 0; i < data.length; i++) {
        <?php if ($Settings->indian_gst): ?>
        igst   += parseFloat(data[display[i]][5]) || 0;
        cgst   += parseFloat(data[display[i]][6]) || 0;
        sgst   += parseFloat(data[display[i]][7]) || 0;
        <?php endif; ?>
        ptax   += parseFloat(data[display[i]][ptaxIdx]) || 0;
        otax   += parseFloat(data[display[i]][otaxIdx]) || 0;
        gtotal += parseFloat(data[display[i]][gtotalIdx]) || 0;
      }
      var cells = row.getElementsByTagName('th');
      <?php if ($Settings->indian_gst): ?>
      cells[5].innerHTML = currencyFormat(igst);
      cells[6].innerHTML = currencyFormat(cgst);
      cells[7].innerHTML = currencyFormat(sgst);
      <?php endif; ?>
      cells[ptaxIdx].innerHTML = '<strong>' + currencyFormat(ptax) + '</strong>';
      cells[otaxIdx].innerHTML = '<strong>' + currencyFormat(otax) + '</strong>';
      cells[gtotalIdx].innerHTML = '<strong>' + currencyFormat(gtotal) + '</strong>';
    };
  }

  var colDefs = [
    { render: function (d) { return d; } },
    null,
    { render: function (d) { return typeof row_status === 'function' ? row_status(d) : d; } },
    null, null,
    <?php if ($Settings->indian_gst): ?>
    { render: function (d) { return currencyFormat(parseFloat(d)); } },
    { render: function (d) { return currencyFormat(parseFloat(d)); } },
    { render: function (d) { return currencyFormat(parseFloat(d)); } },
    <?php endif; ?>
    { render: function (d) { return currencyFormat(parseFloat(d)); } },
    { render: function (d) { return currencyFormat(parseFloat(d)); } },
    { render: function (d) { return '<strong>' + currencyFormat(parseFloat(d)) + '</strong>'; } }
  ];

  <?php $ptaxIdx = $Settings->indian_gst ? 8 : 5; $otaxIdx = $Settings->indian_gst ? 9 : 6; $gtotalIdx = $Settings->indian_gst ? 10 : 7; ?>

  $('#TAXData').DataTable({
    processing: true, serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/get_sale_taxes/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) { d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: colDefs,
    rowCallback: function (row, data) {
      row.id = data[<?php echo $Settings->indian_gst ? 11 : 8; ?>];
      row.className += data[2] === 'completed' ? ' invoice_link2' : ' invoice_link2 table-warning';
    },
    footerCallback: makeTaxFooterCallback(<?php echo $ptaxIdx; ?>, <?php echo $otaxIdx; ?>, <?php echo $gtotalIdx; ?>),
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  $('#PTAXData').DataTable({
    processing: true, serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/get_purchase_taxes/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) { d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: colDefs,
    rowCallback: function (row, data) {
      row.id = data[<?php echo $Settings->indian_gst ? 11 : 8; ?>];
      row.className += data[2] === 'received' ? ' purchase_link' : ' purchase_link table-warning';
    },
    footerCallback: makeTaxFooterCallback(<?php echo $ptaxIdx; ?>, <?php echo $otaxIdx; ?>, <?php echo $gtotalIdx; ?>),
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  // Reinit purchases table when tab shown
  document.getElementById('purchases-tax-tab').addEventListener('shown.bs.tab', function () {
    $('#PTAXData').DataTable().columns.adjust().draw();
  });

  document.getElementById('xls-sales').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/get_sale_taxes/0/xls/?v=1' . $v); ?>';
  });
  document.getElementById('xls-purchases').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/get_purchase_taxes/0/xls/?v=1' . $v); ?>';
  });
})();
</script>
