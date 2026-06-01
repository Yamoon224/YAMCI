<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-store-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('open_registers') ?: 'Caisses ouvertes' ?></h4>
    <p class="mb-0 text-muted">Gestion des caisses POS actuellement ouvertes</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Accueil</a></li>
        <li class="breadcrumb-item">POS</li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('registers') ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('pos/add_register') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_register') ?: 'Nouvelle caisse' ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table id="RegistersData" class="table table-hover" aria-label="<?= lang('registers'); ?>">
      <thead class="table-light">
        <tr>
          <th><?= lang('name'); ?></th>
          <th><?= lang('status'); ?></th>
          <th class="text-end"><?= lang('current_balance'); ?></th>
          <th><?= lang('cashier'); ?></th>
          <th><?= lang('warehouse'); ?></th>
          <th style="width:120px; text-align:center;"><?= lang('actions'); ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6" class="text-center dataTables_empty">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
            <?= lang('loading_data'); ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
(function () {
  $(document).ready(function () {
    $('#RegistersData').dataTable({
      "aaSorting": [[0, "asc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all'); ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page; ?>,
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?= admin_url('pos/getRegisters'); ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({
          "name": "<?= $this->security->get_csrf_token_name(); ?>",
          "value": "<?= $this->security->get_csrf_hash(); ?>"
        });
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "aoColumns": [
        null,
        { "mRender": function (data) {
            if (data == 'open') {
              return '<span class="badge bg-label-success"><?= lang('open'); ?></span>';
            }
            return '<span class="badge bg-label-danger"><?= lang('closed'); ?></span>';
          }
        },
        { "mRender": function (data) { return '<span class="fw-semibold">' + (typeof currencyFormat === 'function' ? currencyFormat(data) : data) + '</span>'; } },
        null,
        null,
        { "bSortable": false }
      ]
    }).fnSetFilteringDelay();
  });
})();
</script>
