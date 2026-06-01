<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-notification-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('notifications') ?: 'Notifications'; ?></h4>
    <p class="mb-0 text-muted">Annonces et messages diffusés aux utilisateurs</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('notifications') ?: 'Notifications'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('notifications/add'); ?>"
       class="btn btn-primary"
       data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_notification') ?: 'Ajouter une notification'; ?>
    </a>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0"><?php echo lang('list_results') ?: 'Liste des notifications'; ?></h5>
  </div>
  <div class="card-datatable table-responsive">
    <table id="NTTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('notification') ?: 'Notification'; ?></th>
          <th style="width:140px;"><?php echo lang('submitted_at') ?: 'Créée le'; ?></th>
          <th style="width:140px;"><?php echo lang('from') ?: 'Du'; ?></th>
          <th style="width:140px;"><?php echo lang('till') ?: 'Au'; ?></th>
          <th style="width:80px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="5" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  $('#NTTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[1, 'asc'], [2, 'asc']],
    ajax: {
      url: '<?php echo admin_url('notifications/getNotifications'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null,
      { render: function (d) { return d ? '<span class="text-body">' + d + '</span>' : '—'; } },
      { render: function (d) { return d ? '<span class="text-body">' + d + '</span>' : '—'; } },
      { render: function (d) { return d ? '<span class="text-body">' + d + '</span>' : '—'; } },
      { orderable: false, className: 'text-center' }
    ],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
