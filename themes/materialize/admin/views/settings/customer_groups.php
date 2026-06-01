<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-group-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('customer_groups') ?: 'Groupes clients'); ?></h4>
    <p class="mb-0 text-muted">Segmentation des clients en groupes (général, VIP, etc.)</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('system_settings'); ?>"><?php echo lang('settings') ?: 'Paramètres'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo $page_title ?? (lang('customer_groups') ?: 'Groupes clients'); ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('system_settings/add_customer_group'); ?>"
       class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_customer_group') ?: 'Ajouter un groupe'; ?>
    </a>
  </div>
</div>

<?php echo admin_form_open('system_settings/customer_group_actions', ['id' => 'action-form']); ?>
<div class="card">
  <div class="card-header d-flex justify-content-between align-items-center">
    <h5 class="card-title mb-0"><?php echo lang('list_results') ?: 'Liste'; ?></h5>
    <div class="dropdown">
      <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
        <span class="icon-base ri ri-settings-3-line me-1 icon-16px"></span>
        <?php echo lang('actions') ?: 'Actions'; ?>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" onclick="bulkAction('export_excel')">
          <span class="icon-base ri ri-file-excel-line me-2 text-success icon-16px"></span>
          <?php echo lang('export_to_excel') ?: 'Excel'; ?></a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="#" onclick="bulkAction('delete')">
          <span class="icon-base ri ri-delete-bin-line me-2 icon-16px"></span>
          <?php echo lang('delete_customer_groups') ?: 'Supprimer'; ?></a></li>
      </ul>
    </div>
  </div>
  <div class="card-datatable table-responsive">
    <table id="CGData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="width:30px;" class="text-center"><input class="form-check-input checkbox checkth" type="checkbox" /></th>
          <th><?php echo lang('name') ?: 'Nom'; ?></th>
          <th><?php echo lang('percentage') ?: 'Remise (%)'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="4" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
    </table>
  </div>
</div>
<div class="d-none">
  <input type="hidden" name="form_action" id="form_action" value="" />
  <?php echo form_submit('performAction', 'performAction', 'id="action-form-submit"'); ?>
</div>
<?php echo form_close(); ?>

<script>
(function () {
  'use strict';
  $('#CGData').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'asc']],
    ajax: {
      url: '<?php echo admin_url('system_settings/getCustomerGroups'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { orderable: false, render: function (d, t, r) {
          return '<input type="checkbox" class="form-check-input checkbox" name="ids[]" value="' + r[0] + '">';
        }
      },
      null, null,
      { orderable: false, className: 'text-center' }
    ],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
  $('.checkth').on('change', function () { $('.checkbox').prop('checked', this.checked); });
})();

function bulkAction(action) {
  var checked = $('input[name="ids[]"]:checked');
  if (!checked.length) {
    Swal.fire({ icon: 'warning', title: '<?php echo lang('no_item_selected') ?: 'Aucun élément sélectionné'; ?>', timer: 2000, showConfirmButton: false });
    return;
  }
  if (action === 'delete') {
    Swal.fire({
      title: '<?php echo lang('r_u_sure') ?: 'Êtes-vous sûr ?'; ?>',
      icon: 'warning', showCancelButton: true,
      confirmButtonColor: '#ff3e1d',
      cancelButtonText: '<?php echo lang('no') ?: 'Non'; ?>',
      confirmButtonText: '<?php echo lang('i_m_sure') ?: 'Oui'; ?>'
    }).then(function (r) {
      if (r.isConfirmed) { $('#form_action').val(action); $('#action-form-submit').click(); }
    });
  } else {
    $('#form_action').val(action);
    $('#action-form-submit').click();
  }
}
</script>
