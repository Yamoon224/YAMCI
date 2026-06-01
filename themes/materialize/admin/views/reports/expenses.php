<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$v = '';
if ($this->input->post('reference_no')) $v .= '&reference_no=' . $this->input->post('reference_no');
if ($this->input->post('category'))     $v .= '&category='     . $this->input->post('category');
if ($this->input->post('warehouse'))    $v .= '&warehouse='    . $this->input->post('warehouse');
if ($this->input->post('note'))         $v .= '&note='         . $this->input->post('note');
if ($this->input->post('user'))         $v .= '&user='         . $this->input->post('user');
if ($this->input->post('start_date'))   $v .= '&start_date='   . $this->input->post('start_date');
if ($this->input->post('end_date'))     $v .= '&end_date='     . $this->input->post('end_date');
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-bill-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('expenses_report') ?: 'Rapport des dépenses'; ?>
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
        <li class="breadcrumb-item active"><?php echo lang('expenses_report') ?: 'Rapport des dépenses'; ?></li>
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
    <?php echo admin_form_open('reports/expenses', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
    <div class="row g-4">
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : '', 'class="form-control" id="reference_no" placeholder="Référence"'); ?>
          <label for="reference_no"><?php echo lang('reference_no') ?: 'N° de référence'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $ct = ['' => lang('select') . ' ' . (lang('category') ?: 'Catégorie')];
          foreach ($categories as $category) { $ct[$category->id] = $category->name; }
          echo form_dropdown('category', $ct, isset($_POST['category']) ? $_POST['category'] : '',
            'class="form-select select2" id="category" data-placeholder="' . lang('select') . ' ' . (lang('category') ?: 'Catégorie') . '"');
          ?>
          <label for="category"><?php echo lang('category') ?: 'Catégorie'; ?></label>
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
          <?php echo form_input('note', isset($_POST['note']) ? $_POST['note'] : '', 'class="form-control" id="note" placeholder="Note"'); ?>
          <label for="note"><?php echo lang('note') ?: 'Note'; ?></label>
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
      <a href="<?php echo admin_url('reports/expenses'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="EXPData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference') ?: 'Référence'; ?></th>
          <th><?php echo lang('category') ?: 'Catégorie'; ?></th>
          <th><?php echo lang('amount') ?: 'Montant'; ?></th>
          <th><?php echo lang('note') ?: 'Note'; ?></th>
          <th><?php echo lang('created_by') ?: 'Créé par'; ?></th>
          <th style="min-width:36px; width:36px; text-align:center;">
            <span class="icon-base ri ri-links-line icon-16px"></span>
          </th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="7" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th><?php echo lang('amount') ?: 'Montant'; ?></th>
          <th></th>
          <th></th>
          <th style="min-width:36px; width:36px; text-align:center;">
            <span class="icon-base ri ri-links-line icon-16px"></span>
          </th>
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

  function attachment(x) {
    if (x) {
      return '<a href="' + site.url + 'assets/uploads/' + x + '" target="_blank"><span class="icon-base ri ri-links-line icon-16px"></span></a>';
    }
    return '';
  }

  var oTable = $('#EXPData').dataTable({
    aaSorting: [[0, 'desc']],
    aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    iDisplayLength: <?php echo (int)$Settings->rows_per_page; ?>,
    bProcessing: true,
    bServerSide: true,
    sAjaxSource: '<?php echo admin_url('reports/getExpensesReport/?v=1' . $v); ?>',
    fnServerData: function (sSource, aoData, fnCallback) {
      aoData.push({
        name: '<?php echo $this->security->get_csrf_token_name(); ?>',
        value: '<?php echo $this->security->get_csrf_hash(); ?>'
      });
      $.ajax({ dataType: 'json', type: 'POST', url: sSource, data: aoData, success: fnCallback });
    },
    fnRowCallback: function (nRow, aData) {
      nRow.id = aData[7];
      nRow.className = 'expense_link2';
      return nRow;
    },
    aoColumns: [
      { mRender: fld },
      null, null,
      { mRender: currencyFormat },
      null, null,
      { bSortable: false, mRender: attachment }
    ],
    fnFooterCallback: function (nRow, aaData, iStart, iEnd, aiDisplay) {
      var total = 0;
      for (var i = 0; i < aaData.length; i++) {
        total += parseFloat(aaData[aiDisplay[i]][3]) || 0;
      }
      var cells = nRow.getElementsByTagName('th');
      cells[3].innerHTML = '<strong>' + currencyFormat(total) + '</strong>';
    }
  }).fnSetFilteringDelay().dtFilter([
    { column_number: 0, filter_default_label: '[<?php echo lang('date'); ?> (yyyy-mm-dd)]', filter_type: 'text', data: [] },
    { column_number: 1, filter_default_label: '[<?php echo lang('reference'); ?>]',        filter_type: 'text', data: [] },
    { column_number: 2, filter_default_label: '[<?php echo lang('category'); ?>]',         filter_type: 'text', data: [] },
    { column_number: 4, filter_default_label: '[<?php echo lang('note'); ?>]',             filter_type: 'text', data: [] },
    { column_number: 5, filter_default_label: '[<?php echo lang('created_by'); ?>]',       filter_type: 'text', data: [] }
  ], 'footer');

  document.getElementById('xls').addEventListener('click', function (e) {
    e.preventDefault();
    window.location.href = '<?php echo admin_url('reports/getExpensesReport/0/xls/?v=1' . $v); ?>';
  });
})();
</script>
