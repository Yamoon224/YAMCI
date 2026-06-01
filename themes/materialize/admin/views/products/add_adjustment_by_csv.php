<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-upload-cloud-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Importer ajustements CSV</h4>
    <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer plusieurs ajustements en masse</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products/quantity_adjustments'); ?>"><?php echo lang('quantity_adjustments') ?: 'Ajustements'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('import_csv') ?: 'Import CSV'; ?></li>
      </ol>
    </nav>
  </div>
</div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-upload-cloud-line me-2 text-primary"></span>
        <?php echo lang('add_adjustment_by_csv') ?: 'Import ajustements CSV'; ?>
      </h5>
    </div>
    <div class="card-body">
      <?php echo admin_form_open_multipart('products/add_adjustment_by_csv'); ?>
      <div class="row g-3">
        <?php if ($Owner || $Admin): ?>
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', isset($_POST['date']) ? $_POST['date'] : '', 'id="qadate_csv" class="form-control flatpickr-input" placeholder="' . lang('date') . '" required'); ?>
            <label for="qadate_csv"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : '', 'id="qaref_csv" class="form-control" placeholder="' . lang('reference_no') . '"'); ?>
            <label for="qaref_csv"><?php echo lang('reference_no') ?: 'Réf'; ?></label>
          </div>
        </div>
        <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')): ?>
        <div class="col-md-4">
          <?php $wh = ['' => '']; foreach ($warehouses as $wrow): $wh[$wrow->id] = $wrow->name; endforeach; ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('warehouse', $wh, isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse, 'id="qawarehouse_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" style="width:100%;"'); ?>
            <label for="qawarehouse_csv"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
          </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="warehouse" value="<?php echo $this->session->userdata('warehouse_id'); ?>" />
        <?php endif; ?>

        <div class="col-12">
          <div class="alert alert-info d-flex align-items-start">
            <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
            <div>
              <?php echo lang('csv1') ?: ''; ?><br>
              <?php echo lang('csv2') ?: 'Colonnes'; ?>: <strong>(<?php echo lang('product_code') . ', ' . lang('quantity') . ', ' . lang('variant'); ?>)</strong>
              <?php echo lang('csv3') ?: ''; ?>
              <?php if ($msg = lang('quantity_colum_tip')): ?><br><strong><?php echo $msg; ?></strong><?php endif; ?>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>assets/csv/sample_adjustments.csv" class="btn btn-outline-primary btn-sm mb-3">
            <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Télécharger exemple'; ?>
          </a>
          <div>
            <label class="form-label" for="csv_file_adj"><?php echo lang('upload_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="csv_file_adj" name="csv_file" accept=".csv" required />
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', isset($_POST['note']) ? $_POST['note'] : '', 'id="qanote_csv" class="form-control" placeholder="' . lang('note') . '" style="height:100px;"'); ?>
            <label for="qanote_csv"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <?php echo form_submit('add_adjustment', lang('submit') ?: 'Importer', 'class="btn btn-primary"'); ?>
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
    flatpickr('#qadate_csv', { dateFormat: 'd-m-Y', defaultDate: 'today', allowInput: true });
  }
});
</script>
