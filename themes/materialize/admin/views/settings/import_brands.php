<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-upload-cloud-line me-2 text-primary icon-18px"></span>
        <?php echo lang('import_brands') ?: 'Importer marques'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open_multipart('system_settings/import_brands'); ?>
    <div class="modal-body">
      <div class="alert alert-info d-flex align-items-start mb-3">
        <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
        <div>
          <?php echo lang('csv2') ?: 'Colonnes'; ?>: <strong>(<?php echo lang('name'); ?>)</strong>
        </div>
      </div>
      <a href="<?php echo base_url(); ?>assets/csv/sample_brands.csv" class="btn btn-sm btn-outline-primary mb-3">
        <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Exemple'; ?>
      </a>
      <div>
        <label class="form-label" for="csv_file_brands"><?php echo lang('upload_file') ?: 'Fichier'; ?> <span class="text-danger">*</span></label>
        <input type="file" class="form-control" id="csv_file_brands" name="csv_file" accept=".csv" required />
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('import', lang('import') ?: 'Importer', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
