<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1"><i class="ri ri-upload-cloud-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Importer les transferts par CSV</h4>
      <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer plusieurs transferts en masse</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo admin_url('transfers'); ?>"><?php echo lang('transfers') ?: 'Transferts'; ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('import_csv') ?: 'Import CSV'; ?></li>
        </ol>
      </nav>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <a href="<?php echo admin_url('transfers'); ?>" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?php echo lang('back') ?: 'Retour'; ?>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-upload-cloud-line me-2 text-primary"></span>
        <?php echo lang('transfer_by_csv') ?: 'Import transferts CSV'; ?>
      </h5>
    </div>
    <div class="card-body">
      <?php echo admin_form_open_multipart('transfers/transfer_by_csv'); ?>
      <div class="row g-3">

        <?php if ($Owner || $Admin): ?>
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', isset($_POST['date']) ? $_POST['date'] : '', 'id="todate_csv" class="form-control flatpickr-input" placeholder="' . lang('date') . '" required="required"'); ?>
            <label for="todate_csv"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : $rnumber, 'id="toref_csv" class="form-control" placeholder="' . lang('reference_no') . '"'); ?>
            <label for="toref_csv"><?php echo lang('reference_no') ?: 'Réf'; ?></label>
          </div>
        </div>

        <?php
        $wh = ['' => ''];
        foreach ($warehouses as $warehouse) {
          $wh[$warehouse->id] = $warehouse->name;
        }
        ?>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('from_warehouse', $wh, isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] : '', 'id="from_warehouse_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('from_warehouse') . '" required="required" style="width:100%;"'); ?>
            <label for="from_warehouse_csv"><?php echo lang('from_warehouse') ?: 'Depuis'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('to_warehouse', $wh, isset($_POST['to_warehouse']) ? $_POST['to_warehouse'] : '', 'id="to_warehouse_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('to_warehouse') . '" required="required" style="width:100%;"'); ?>
            <label for="to_warehouse_csv"><?php echo lang('to_warehouse') ?: 'Vers'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <?php
          $tostatus = [
            'completed' => lang('completed'),
            'pending'   => lang('pending'),
            'sent'      => lang('sent'),
          ];
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('status', $tostatus, isset($_POST['status']) ? $_POST['status'] : '', 'id="tostatus_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('status') . '" required="required" style="width:100%;"'); ?>
            <label for="tostatus_csv"><?php echo lang('status') ?: 'Statut'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('shipping', '', 'id="toshipping_csv" class="form-control" placeholder="' . lang('shipping') . '"'); ?>
            <label for="toshipping_csv"><?php echo lang('shipping') ?: 'Livraison'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <div class="alert alert-info d-flex align-items-start">
            <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
            <div>
              <?php echo lang('csv1') ?: ''; ?><br>
              <?php echo lang('csv2') ?: 'Colonnes'; ?>:
              <strong>(<?php echo lang('product_code') . ', ' . lang('unit_cost') . ', ' . lang('quantity') . ', ' . lang('product_variant') . ', ' . lang('expiry'); ?>)</strong>
              <?php echo lang('csv3') ?: ''; ?><br>
              <strong><?php echo lang('first_2_are_required_other_optional') ?: '2 premières colonnes requises, autres optionnelles'; ?></strong>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>assets/csv/sample_transfer_products.csv" class="btn btn-outline-primary btn-sm mb-3">
            <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Télécharger exemple'; ?>
          </a>
          <div class="mb-3">
            <label class="form-label" for="csv_file_to"><?php echo lang('csv_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="csv_file_to" name="userfile" accept=".csv" required />
          </div>
          <div>
            <label class="form-label" for="document_to"><?php echo lang('document') ?: 'Document'; ?></label>
            <input type="file" class="form-control" id="document_to" name="document" />
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', isset($_POST['note']) ? $_POST['note'] : '', 'id="tonote_csv" class="form-control" placeholder="' . lang('note') . '" style="height:100px;"'); ?>
            <label for="tonote_csv"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <?php echo form_submit('add_transfer', lang('submit') ?: 'Importer', 'class="btn btn-primary"'); ?>
          <button type="reset" class="btn btn-outline-secondary ms-2"><?php echo lang('reset') ?: 'Réinitialiser'; ?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (typeof flatpickr !== 'undefined') {
    flatpickr('#todate_csv', { dateFormat: 'd-m-Y', defaultDate: 'today', allowInput: true });
  }

  // Validate that from and to warehouse differ
  var fromWh = document.getElementById('from_warehouse_csv');
  var toWh   = document.getElementById('to_warehouse_csv');
  function checkWarehouses() {
    if (fromWh.value && toWh.value && fromWh.value === toWh.value) {
      toWh.value = '';
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'warning', title: '<?php echo lang('please_select_different_warehouse'); ?>', timer: 2000, showConfirmButton: false });
      }
    }
  }
  if (fromWh) fromWh.addEventListener('change', checkWarehouses);
  if (toWh)   toWh.addEventListener('change', checkWarehouses);
});
</script>
