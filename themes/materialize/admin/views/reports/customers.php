<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-user-star-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('customers') ?: 'Rapport clients'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><span class="icon-base ri ri-home-line icon-20px"></span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('customers_report') ?: 'Rapport clients'; ?></li>
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

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="CusData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('company') ?: 'Société'; ?></th>
          <th><?php echo lang('name') ?: 'Nom'; ?></th>
          <th><?php echo lang('phone') ?: 'Téléphone'; ?></th>
          <th><?php echo lang('email_address') ?: 'Email'; ?></th>
          <th><?php echo lang('total_sales') ?: 'Total ventes'; ?></th>
          <th><?php echo lang('total_amount') ?: 'Montant total'; ?></th>
          <th><?php echo lang('paid') ?: 'Payé'; ?></th>
          <th><?php echo lang('balance') ?: 'Solde'; ?></th>
          <th style="width:85px;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="9" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th class="text-center"><?php echo lang('total_sales') ?: 'Total ventes'; ?></th>
          <th class="text-center"><?php echo lang('total_amount') ?: 'Montant total'; ?></th>
          <th class="text-center"><?php echo lang('paid') ?: 'Payé'; ?></th>
          <th class="text-center"><?php echo lang('balance') ?: 'Solde'; ?></th>
          <th style="width:85px;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';

  var oTable = $('#CusData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'asc'], [1, 'asc']],
    ajax: {
      url: '<?php echo admin_url('reports/getCustomers'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null, null, null, null,
      { searchable: false, render: function (d) { return decimalFormat(d); } },
      { searchable: false, render: function (d) { return currencyFormat(d); } },
      { searchable: false, render: function (d) { return currencyFormat(d); } },
      { searchable: false, render: function (d) { return d > 0 ? '<span class="text-danger">' + currencyFormat(d) + '</span>' : '<span class="text-success">' + currencyFormat(0) + '</span>'; } },
      { sortable: false }
    ],
    footerCallback: function (row, data, start, end, display) {
      var purchases = 0, total = 0, paid = 0, balance = 0;
      for (var i = 0; i < data.length; i++) {
        purchases += parseFloat(data[display[i]][4]) || 0;
        total     += parseFloat(data[display[i]][5]) || 0;
        paid      += parseFloat(data[display[i]][6]) || 0;
        balance   += parseFloat(data[display[i]][7]) || 0;
      }
      var cells = row.getElementsByTagName('th');
      cells[4].innerHTML = decimalFormat(purchases);
      cells[5].innerHTML = currencyFormat(total);
      cells[6].innerHTML = currencyFormat(paid);
      cells[7].innerHTML = balance > 0
        ? '<span class="text-danger">' + currencyFormat(balance) + '</span>'
        : '<span class="text-success">' + currencyFormat(0) + '</span>';
    },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  // Client-side column filters in footer
  $('#CusData tfoot th').each(function (i) {
    if (i < 4) {
      var input = $('<input type="text" class="form-control form-control-sm" placeholder="' + $(this).text() + '" />');
      $(this).html(input);
      input.on('keyup change', function () {
        if (oTable.column(i).search() !== this.value) {
          oTable.column(i).search(this.value).draw();
        }
      });
    }
  });

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getCustomers/0/xls'); ?>';
  });
})();
</script>
