<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<div class="row mb-4">
  <div class="col-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-2">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('site_logs') ?: 'Journaux système'; ?></li>
      </ol>
    </nav>
    <h4 class="fw-semibold mb-1">
      <span class="icon-base ri ri-file-text-line me-2 text-primary icon-20px"></span>
      <?php echo lang('site_logs') ?: 'Journaux système'; ?>
    </h4>
  </div>
</div>

<div class="card">
  <div class="card-header">
    <h5 class="card-title mb-0"><?php echo lang('list_results') ?: 'Liste des journaux'; ?></h5>
  </div>
  <div class="card-datatable table-responsive">
    <table id="LogsData" class="table datatables-ajax border-top" style="width:100%;">
      <thead>
        <tr>
          <th style="width:10%;"><?php echo lang('date') ?: 'Date'; ?></th>
          <th style="width:20%;"><?php echo lang('detail') ?: 'Détail'; ?></th>
          <th style="width:70%;"><?php echo lang('model') ?: 'Modèle'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="3" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  $('#LogsData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('site_logs/getLogs'); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      { render: function (d) { return '<span class="text-body small">' + d + '</span>'; } },
      { render: function (d) { return '<div style="max-width:200px;word-break:break-word;" class="small">' + d + '</div>'; } },
      { orderable: false, searchable: false, render: function (d) { return '<pre style="min-width:200px;white-space:pre-wrap;margin:0;font-size:0.75rem;" class="bg-light p-2 rounded">' + d + '</pre>'; } }
    ],
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    scrollX: true,
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
