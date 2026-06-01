<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-cash-register-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('register_report') ?: 'Rapport Caisse POS'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('register_report') ?: 'Rapport Caisse'; ?></li>
      </ol>
    </nav>
    </div>
</div>

<!-- Filter -->
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
    <h5 class="card-title mb-0"><span class="icon-base ri ri-filter-line me-2 icon-18px"></span><?php echo lang('filter') ?: 'Filtres'; ?></h5>
    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#regFilter">
      <span class="icon-base ri ri-equalizer-line me-1 icon-14px"></span>Filtres
    </button>
  </div>
  <div class="collapse show" id="regFilter">
    <div class="card-body border-top">
      <?php echo admin_form_open('reports/register', ['method' => 'post']); ?>
      <div class="row g-3 align-items-end">
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <?php
            $u_opts = ['' => lang('all') ?: 'Tous'];
            if (isset($users)) foreach ($users as $u) $u_opts[$u->id] = $u->first_name . ' ' . $u->last_name;
            echo form_dropdown('user', $u_opts, $this->input->post('user') ?: '', 'class="form-select select2" id="regUser"');
            ?>
            <label for="regUser"><?php echo lang('user') ?: 'Utilisateur'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" name="start_date" id="regStart"
                   placeholder="Start" value="<?php echo $this->input->post('start_date') ?: ''; ?>" />
            <label for="regStart"><?php echo lang('start_date') ?: 'Date début'; ?></label>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" name="end_date" id="regEnd"
                   placeholder="End" value="<?php echo $this->input->post('end_date') ?: ''; ?>" />
            <label for="regEnd"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
          </div>
        </div>
        <div class="col-md-3 d-flex gap-2">
          <button type="submit" class="btn btn-primary flex-fill">
            <span class="icon-base ri ri-search-line me-1 icon-16px"></span><?php echo lang('search') ?: 'Rechercher'; ?>
          </button>
          <a href="<?php echo admin_url('reports/register'); ?>" class="btn btn-outline-secondary">
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
    <table id="registerTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('opened') ?: 'Ouverture'; ?></th>
          <th><?php echo lang('closed') ?: 'Fermeture'; ?></th>
          <th><?php echo lang('user') ?: 'Utilisateur'; ?></th>
          <th class="text-end"><?php echo lang('cash_in_hand') ?: 'Fonds caisse'; ?></th>
          <th class="text-end"><?php echo lang('cc_slips') ?: 'CB'; ?></th>
          <th class="text-end"><?php echo lang('cheque_slips') ?: 'Chèques'; ?></th>
          <th class="text-end"><?php echo lang('cash_sale') ?: 'Ventes espèces'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th><th></th><th></th><th></th><th></th><th></th><th></th>
          <th class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
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
  if ($this->input->post('user'))       $v .= '&user='       . $this->input->post('user');
  if ($this->input->post('start_date')) $v .= '&start_date=' . $this->input->post('start_date');
  if ($this->input->post('end_date'))   $v .= '&end_date='   . $this->input->post('end_date');
  ?>
  $('#registerTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getRrgisterlogs/?v=1' . $v); ?>',
      type: 'POST',
      data: function(d){ d['<?php echo $this->security->get_csrf_token_name();?>'] = '<?php echo $this->security->get_csrf_hash();?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null, null, null,
      { className: 'text-end', render: function(d){ return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2}); } },
      { className: 'text-end', render: function(d){ return d ? d.replace(' (', '<br><small class="text-success">')+' / <span class="text-danger">'+'</span></small>' : '—'; } },
      { className: 'text-end' },
      { className: 'text-end' },
      { orderable: false, className: 'text-center' }
    ],
    lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'<?php echo lang('all')?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
