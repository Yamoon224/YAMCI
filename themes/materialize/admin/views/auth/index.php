<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-group-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('users') ?: 'Utilisateurs'; ?></h4>
    <p class="mb-0 text-muted">Gérez les comptes, rôles et permissions des utilisateurs</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('users') ?: 'Utilisateurs'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('auth/create_user'); ?>" class="btn btn-primary">
      <i class="ri ri-user-add-line me-1" style="font-size:16px"></i><?php echo lang('add_user') ?: 'Ajouter un utilisateur'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<?php if ($Owner): echo admin_form_open('auth/user_actions', ['id' => 'action-form']); endif; ?>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
    <h5 class="card-title mb-0"><?php echo lang('list_results') ?: 'Liste des utilisateurs'; ?></h5>
    <div class="d-flex gap-2 flex-wrap">
      <?php if ($Owner): ?>
      <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
          <span class="icon-base ri ri-settings-3-line me-1 icon-16px"></span>
          <?php echo lang('actions') ?: 'Actions'; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#" onclick="bulkAction('export_excel')">
              <span class="icon-base ri ri-file-excel-line me-2 text-success icon-16px"></span>
              <?php echo lang('export_to_excel') ?: 'Exporter Excel'; ?>
            </a>
          </li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
              <span class="icon-base ri ri-delete-bin-line me-2 icon-16px"></span>
              <?php echo lang('delete_users') ?: 'Supprimer'; ?>
            </a>
          </li>
        </ul>
      </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table id="UsrTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="width:30px;" class="text-center">
            <input class="form-check-input checkbox checkth" type="checkbox" />
          </th>
          <th><?php echo lang('first_name') ?: 'Prénom'; ?></th>
          <th><?php echo lang('last_name') ?: 'Nom'; ?></th>
          <th><?php echo lang('email_address') ?: 'Email'; ?></th>
          <th><?php echo lang('company') ?: 'Société'; ?></th>
          <th><?php echo lang('award_points') ?: 'Points'; ?></th>
          <th><?php echo lang('group') ?: 'Groupe'; ?></th>
          <th style="width:100px;"><?php echo lang('status') ?: 'Statut'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="9" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th class="text-center"><input class="form-check-input checkbox checkft" type="checkbox" /></th>
          <th></th><th></th><th></th><th></th><th></th><th></th>
          <th></th>
          <th class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner): ?>
  <div class="d-none">
    <input type="hidden" name="form_action" value="" id="form_action" />
    <?php echo form_submit('performAction', 'performAction', 'id="action-form-submit"'); ?>
  </div>
  <?php echo form_close(); ?>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var oTable = $('#UsrTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '<?php echo admin_url('auth/getUsers'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { orderable: false, render: function (data, type, row) {
          return '<input type="checkbox" class="form-check-input checkbox" name="ids[]" value="' + row[0] + '">';
        }
      },
      null, null, null, null, null, null,
      { render: function (data) {
          return data == 1
            ? '<span class="badge bg-label-success"><?php echo lang('active') ?: 'Actif'; ?></span>'
            : '<span class="badge bg-label-secondary"><?php echo lang('inactive') ?: 'Inactif'; ?></span>';
        }
      },
      { orderable: false }
    ],
    order: [[2, 'asc'], [3, 'asc']],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    language: { url: '' },
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  // Bulk action checkbox
  $('.checkth, .checkft').on('change', function () {
    $('.checkbox').prop('checked', this.checked);
  });
})();

function bulkAction(action) {
  var checked = $('input[name="ids[]"]:checked');
  if (checked.length === 0) {
    Swal.fire({ icon: 'warning', title: '<?php echo lang('no_item_selected') ?: 'Aucun élément sélectionné'; ?>', timer: 2000, showConfirmButton: false });
    return;
  }
  if (action === 'delete') {
    Swal.fire({
      title: '<?php echo lang('r_u_sure') ?: 'Êtes-vous sûr ?'; ?>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#ff3e1d',
      cancelButtonText: '<?php echo lang('no') ?: 'Non'; ?>',
      confirmButtonText: '<?php echo lang('i_m_sure') ?: 'Oui, supprimer'; ?>'
    }).then(function (result) {
      if (result.isConfirmed) {
        $('#form_action').val(action);
        $('#action-form-submit').click();
      }
    });
  } else {
    $('#form_action').val(action);
    $('#action-form-submit').click();
  }
}
</script>
