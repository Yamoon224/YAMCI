<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-printer-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('printers') ?: 'Imprimantes' ?></h4>
    <p class="mb-0 text-muted">Configuration des imprimantes thermiques pour les reçus POS</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Accueil</a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('pos/settings') ?>">POS</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('printers') ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('pos/add_printer') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_printer') ?: 'Nouvelle imprimante' ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table id="PData" class="table table-hover" aria-label="<?= lang('printers'); ?>">
      <thead class="table-light">
        <tr>
          <th><?= lang('title'); ?></th>
          <th><?= lang('type'); ?></th>
          <th><?= lang('profile'); ?></th>
          <th><?= lang('path'); ?></th>
          <th><?= lang('ip_address'); ?></th>
          <th><?= lang('port'); ?></th>
          <th><?= lang('status'); ?></th>
          <th style="width:80px; text-align:center;"><?= lang('actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="8" class="text-center dataTables_empty">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
            <?= lang('loading_data_from_server'); ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function () {
  $('#PData').dataTable({
    "aaSorting": [[0, "asc"]],
    "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all'); ?>"]],
    "iDisplayLength": <?= $Settings->rows_per_page; ?>,
    "bProcessing": true,
    "bServerSide": true,
    "sAjaxSource": "<?= admin_url('pos/get_printers'); ?>",
    "fnServerData": function (sSource, aoData, fnCallback) {
      aoData.push({
        "name": "<?= $this->security->get_csrf_token_name(); ?>",
        "value": "<?= $this->security->get_csrf_hash(); ?>"
      });
      $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
    },
    "aoColumns": [
      null, null, null, null, null, null,
      { "mRender": function (data) {
          if (data == 1 || data == 'active') {
            return '<span class="badge bg-label-success"><?= lang('active'); ?></span>';
          }
          return '<span class="badge bg-label-secondary"><?= lang('inactive'); ?></span>';
        }
      },
      { "bSortable": false, "bSearchable": false }
    ]
  }).fnSetFilteringDelay();
});
</script>
