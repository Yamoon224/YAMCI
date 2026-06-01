<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-bank-card-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('deposits') ?: 'Dépôts'; ?></h4>
    <p class="mb-0 text-muted">Client : <span class="text-primary fw-semibold"><?php echo htmlspecialchars($customer->name); ?></span></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers'); ?>"><?php echo lang('customers') ?: 'Clients'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers/view/' . $customer->id); ?>"><?php echo htmlspecialchars($customer->name); ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('deposits') ?: 'Dépôts'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin || !empty($GP['deposits']['add'])): ?>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('customers/add_deposit/' . $customer->id); ?>"
       class="btn btn-primary"
       data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_deposit') ?: 'Ajouter un dépôt'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table id="DepData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th class="text-end"><?php echo lang('amount') ?: 'Montant'; ?></th>
          <th><?php echo lang('note') ?: 'Note'; ?></th>
          <th style="width:40px;" class="text-center"><?php echo lang('attachment') ?: 'PJ'; ?></th>
          <th style="width:100px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="6" class="dataTables_empty text-center py-4 text-muted">
            <span class="icon-base ri ri-loader-4-line me-1"></span>
            <?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?>
          </td>
        </tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  var oTable = $('#DepData').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('customers/getDeposits/' . $customer->id); ?>',
      type: 'POST',
      data: function (d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    columns: [
      { render: function (d) { return d ? '<span>' + d + '</span>' : '—'; } },
      null,
      { className: 'text-end', render: function (d) { return d ? '<strong>' + d + '</strong>' : '—'; } },
      { render: function (d) { return d ? d : '—'; } },
      { orderable: false, className: 'text-center',
        render: function (d) {
          return d ? '<a href="' + d + '" target="_blank" class="btn btn-sm btn-icon btn-outline-secondary"><span class="icon-base ri ri-attachment-2 icon-14px"></span></a>' : '—';
        }
      },
      { orderable: false, className: 'text-center' }
    ],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  $('#myModal').on('hidden.bs.modal', function () {
    oTable.ajax.reload(null, false);
  });
})();
</script>
