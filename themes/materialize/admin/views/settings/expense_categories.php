<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-bill-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('expense_categories') ?: 'Catégories de dépenses'); ?></h4>
    <p class="mb-0 text-muted">Classez vos dépenses selon des catégories métier</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('system_settings'); ?>"><?php echo lang('settings') ?: 'Paramètres'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo $page_title ?? (lang('expense_categories') ?: 'Catégories dépenses'); ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('system_settings/add_expense_category'); ?>"
       class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_expense_category') ?: 'Ajouter une catégorie'; ?>
    </a>
  </div>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table id="ECData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="width:30px;" class="text-center"><input class="form-check-input checkbox checkth" type="checkbox" /></th>
          <th><?php echo lang('name') ?: 'Nom'; ?></th>
          <th><?php echo lang('description') ?: 'Description'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="4" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  $('#ECData').DataTable({
    processing: true, serverSide: true, order: [[1, 'asc']],
    ajax: {
      url: '<?php echo admin_url('system_settings/getExpenseCategories'); ?>',
      type: 'POST',
      data: function (d) { d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { orderable: false, render: function (d, t, r) { return '<input type="checkbox" class="form-check-input checkbox" name="ids[]" value="' + r[0] + '">'; } },
      null, null,
      { orderable: false, className: 'text-center' }
    ],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
