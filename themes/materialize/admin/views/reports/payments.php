<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('payment_ref'))  $v .= '&payment_ref='  . $this->input->post('payment_ref');
if ($this->input->post('paid_by'))      $v .= '&paid_by='       . $this->input->post('paid_by');
if ($this->input->post('sale_ref'))     $v .= '&sale_ref='      . $this->input->post('sale_ref');
if ($this->input->post('purchase_ref')) $v .= '&purchase_ref='  . $this->input->post('purchase_ref');
if ($this->input->post('supplier'))     $v .= '&supplier='      . $this->input->post('supplier');
if ($this->input->post('biller'))       $v .= '&biller='        . $this->input->post('biller');
if ($this->input->post('customer'))     $v .= '&customer='      . $this->input->post('customer');
if ($this->input->post('user'))         $v .= '&user='          . $this->input->post('user');
if ($this->input->post('start_date'))   $v .= '&start_date='    . $this->input->post('start_date');
if ($this->input->post('end_date'))     $v .= '&end_date='      . $this->input->post('end_date');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-bank-card-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('payments_report') ?: 'Rapport des paiements'; ?>
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
        <li class="breadcrumb-item active"><?php echo lang('payments_report') ?: 'Rapport des paiements'; ?></li>
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
    <?php echo admin_form_open('reports/payments', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
    <div class="row g-4">
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('payment_ref', isset($_POST['payment_ref']) ? $_POST['payment_ref'] : '', 'class="form-control" id="payment_ref" placeholder="Réf. paiement"'); ?>
          <label for="payment_ref"><?php echo lang('payment_ref') ?: 'Réf. paiement'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <select name="paid_by" id="paid_by" class="form-select select2" data-placeholder="<?php echo lang('paid_by') ?: 'Mode de paiement'; ?>">
            <?php echo $this->sma->paid_opts(isset($_POST['paid_by']) ? $_POST['paid_by'] : '', false, true); ?>
            <?php echo (isset($pos_settings) && $pos_settings && $pos_settings->paypal_pro) ? '<option value="ppp">' . (lang('paypal_pro') ?: 'PayPal Pro') . '</option>' : ''; ?>
            <?php echo (isset($pos_settings) && $pos_settings && $pos_settings->stripe) ? '<option value="stripe">' . (lang('stripe') ?: 'Stripe') . '</option>' : ''; ?>
            <?php echo (isset($pos_settings) && $pos_settings && $pos_settings->authorize) ? '<option value="authorize">' . (lang('authorize') ?: 'Authorize.net') . '</option>' : ''; ?>
          </select>
          <label for="paid_by"><?php echo lang('paid_by') ?: 'Mode de paiement'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('sale_ref', isset($_POST['sale_ref']) ? $_POST['sale_ref'] : '', 'class="form-control" id="sale_ref" placeholder="Réf. vente"'); ?>
          <label for="sale_ref"><?php echo lang('sale_ref') ?: 'Réf. vente'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('purchase_ref', isset($_POST['purchase_ref']) ? $_POST['purchase_ref'] : '', 'class="form-control" id="purchase_ref" placeholder="Réf. achat"'); ?>
          <label for="purchase_ref"><?php echo lang('purchase_ref') ?: 'Réf. achat'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('customer', isset($_POST['customer']) ? $_POST['customer'] : '', 'class="form-control" id="rcustomer" placeholder="Client"'); ?>
          <label for="rcustomer"><?php echo lang('customer') ?: 'Client'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $bl = ['' => ''];
          foreach ($billers as $biller) {
              $bl[$biller->id] = ($biller->company && $biller->company != '-') ? $biller->company : $biller->name;
          }
          echo form_dropdown('biller', $bl, isset($_POST['biller']) ? $_POST['biller'] : '',
            'class="form-select select2" id="rbiller" data-placeholder="' . lang('select') . ' ' . (lang('biller') ?: 'Factureur') . '"');
          ?>
          <label for="rbiller"><?php echo lang('biller') ?: 'Factureur'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('supplier', isset($_POST['supplier']) ? $_POST['supplier'] : '', 'class="form-control" id="rsupplier" placeholder="Fournisseur"'); ?>
          <label for="rsupplier"><?php echo lang('supplier') ?: 'Fournisseur'; ?></label>
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
      <a href="<?php echo admin_url('reports/payments'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="PayRData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('payment_ref') ?: 'Réf. paiement'; ?></th>
          <th><?php echo lang('sale_ref') ?: 'Réf. vente'; ?></th>
          <th><?php echo lang('purchase_ref') ?: 'Réf. achat'; ?></th>
          <th><?php echo lang('paid_by') ?: 'Mode'; ?></th>
          <th><?php echo lang('amount') ?: 'Montant'; ?></th>
          <th><?php echo lang('type') ?: 'Type'; ?></th>
          <th style="display:none;"><?php echo lang('id') ?: 'ID'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="7" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th><th></th><th></th><th></th><th></th>
          <th><?php echo lang('amount') ?: 'Montant'; ?></th>
          <th></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  var pb = <?php echo json_encode($pb); ?>;
  function paid_by_label(x) {
    if (x == null) return '';
    var label = pb[x] ? pb[x] : x;
    var colorMap = {
      'cash': 'success',
      'cheque': 'warning',
      'card': 'info',
      'bank': 'primary',
      'stripe': 'secondary',
      'paypal': 'secondary',
      'ppp': 'secondary',
      'authorize': 'secondary'
    };
    var color = colorMap[x] || 'secondary';
    return '<span class="badge bg-label-' + color + '">' + label + '</span>';
  }
  function ref_or_empty(x) { return x ? x : '—'; }

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

  var oTable = $('#PayRData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getPaymentsReport/?v=1' . $v); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { render: function (d) { return d; } },
      null,
      { render: ref_or_empty },
      { render: ref_or_empty },
      { render: paid_by_label },
      { render: function (d) { return '<strong>' + currencyFormat(parseFloat(d)) + '</strong>'; } },
      { render: function (d) { return typeof row_status === 'function' ? row_status(d) : d; } },
      { visible: false }
    ],
    rowCallback: function (row, data) {
      row.id = data[7];
      if (data[6] === 'sent') {
        row.className += ' payment_link2 table-warning';
      } else if (data[6] === 'returned') {
        row.className += ' payment_link table-danger';
      } else {
        row.className += ' payment_link';
      }
    },
    footerCallback: function (row, data, start, end, display) {
      var total = 0;
      for (var i = 0; i < data.length; i++) {
        if (data[display[i]][6] === 'sent') {
          total -= parseFloat(data[display[i]][5]) || 0;
        } else {
          total += parseFloat(data[display[i]][5]) || 0;
        }
      }
      var cells = row.getElementsByTagName('th');
      cells[5].innerHTML = '<strong>' + currencyFormat(total) + '</strong>';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getPaymentsReport/0/xls/?v=1' . $v); ?>';
  });
})();
</script>
