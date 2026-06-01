<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-team-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('view_report_staff') ?: 'Rapport Utilisateurs / Personnel'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('users') ?: 'Utilisateurs'; ?></li>
      </ol>
    </nav>
    </div>
</div>

<?php if ($Owner): ?>
<?php echo admin_form_open('auth/user_actions', ['id' => 'action-form', 'autocomplete' => 'off']); ?>
<?php endif; ?>

<div class="card">
  <?php if ($Owner): ?>
  <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
    <h5 class="card-title mb-0"><?php echo lang('users') ?: 'Utilisateurs'; ?></h5>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <select name="action" class="form-select form-select-sm" style="width:auto;">
        <option value=""><?php echo lang('bulk_actions') ?: 'Actions groupées'; ?></option>
        <option value="activate"><?php echo lang('activate') ?: 'Activer'; ?></option>
        <option value="deactivate"><?php echo lang('deactivate') ?: 'Désactiver'; ?></option>
        <option value="delete"><?php echo lang('delete') ?: 'Supprimer'; ?></option>
      </select>
      <button type="submit" class="btn btn-sm btn-outline-secondary">
        <?php echo lang('apply') ?: 'Appliquer'; ?>
      </button>
    </div>
  </div>
  <?php endif; ?>
  <div class="card-datatable table-responsive">
    <table id="staffTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <?php if ($Owner): ?><th style="width:30px;"><input type="checkbox" class="form-check-input checkth" /></th><?php endif; ?>
          <th><?php echo lang('first_name') ?: 'Prénom'; ?></th>
          <th><?php echo lang('last_name') ?: 'Nom'; ?></th>
          <th><?php echo lang('email') ?: 'Email'; ?></th>
          <th><?php echo lang('company') ?: 'Société'; ?></th>
          <th><?php echo lang('group') ?: 'Groupe'; ?></th>
          <th style="width:100px;" class="text-center"><?php echo lang('status') ?: 'Statut'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="<?php echo $Owner ? 8 : 7; ?>" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <?php if ($Owner): ?><th></th><?php endif; ?>
          <th></th><th></th><th></th><th></th><th></th>
          <th class="text-center"></th>
          <th class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
<?php if ($Owner): ?>
<?php echo form_close(); ?>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var isOwner = <?php echo $Owner ? 'true' : 'false'; ?>;
  var colOffset = isOwner ? 1 : 0;

  $('#staffTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[colOffset + 2, 'asc'], [colOffset + 3, 'asc']],
    ajax: {
      url: '<?php echo admin_url('reports/getUsers'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: (function () {
      var cols = [];
      if (isOwner) cols.push({ orderable: false, render: function(d,t,r){ return '<input type="checkbox" class="form-check-input checkbox" name="ids[]" value="'+r[0]+'">'; } });
      cols = cols.concat([
        null, null, null, null, null,
        { className: 'text-center', render: function (d) {
            var v = parseInt(d);
            return v ? '<span class="badge bg-label-success"><?php echo lang('active') ?: 'Actif'; ?></span>'
                     : '<span class="badge bg-label-danger"><?php echo lang('inactive') ?: 'Inactif'; ?></span>';
          }
        },
        { orderable: false, className: 'text-center' }
      ]);
      return cols;
    })(),
    rowCallback: function (row, data) { row.id = data[0]; },
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all'); ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  if (isOwner) {
    $('.checkth').on('change', function () { $('.checkbox').prop('checked', this.checked); });
  }
})();
</script>
