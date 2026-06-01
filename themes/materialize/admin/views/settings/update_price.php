<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-price-tag-3-line me-2 text-primary icon-18px"></span>
        <?php echo lang('update_prices_csv') ?: 'Import prix CSV'; ?> (<?php echo htmlspecialchars($group->name ?? ''); ?>)
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open_multipart('system_settings/update_prices_csv/' . ($group->id ?? '')); ?>
    <div class="modal-body">
      <div class="alert alert-warning d-flex align-items-start mb-3">
        <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
        <div>
          <?php echo lang('csv1') ?: ''; ?><br>
          <?php echo lang('csv2') ?: 'Colonnes'; ?>: <strong>(<?php echo lang('product_code') . ', ' . lang('product_price'); ?>)</strong>
        </div>
      </div>
      <a href="<?php echo base_url(); ?>assets/csv/sample_product_price.csv" class="btn btn-sm btn-outline-primary mb-3">
        <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Exemple'; ?>
      </a>
      <div>
        <label class="form-label" for="csv_file_grp"><?php echo lang('upload_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span></label>
        <input type="file" class="form-control" id="csv_file_grp" name="userfile" accept=".csv" required />
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('update_price', lang('update_price') ?: 'Mettre à jour', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
