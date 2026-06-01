<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-image-2-line me-2 text-primary icon-18px"></span>
        <?php echo lang('change_logo') ?: 'Changer le logo'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open_multipart('system_settings/change_logo', ['id' => 'changeLogoForm']); ?>
    <div class="modal-body">
      <p class="text-primary small mb-4"><?php echo lang('logo_image_tip') ?: 'Format recommandé : PNG transparent, 300x80px.'; ?></p>

      <div class="mb-4">
        <label class="form-label" for="site_logo"><?php echo lang('site_logo') ?: 'Logo du site'; ?></label>
        <input type="file" class="form-control" id="site_logo" name="site_logo" accept="image/*" />
      </div>
      <div class="mb-4">
        <label class="form-label" for="login_logo"><?php echo lang('login_logo') ?: 'Logo de connexion'; ?></label>
        <input type="file" class="form-control" id="login_logo" name="login_logo" accept="image/*" />
      </div>
      <div class="mb-2">
        <label class="form-label" for="biller_logo"><?php echo lang('biller_logo') ?: 'Logo factureur'; ?></label>
        <input type="file" class="form-control" id="biller_logo" name="biller_logo" accept="image/*" />
        <small class="text-muted"><?php echo lang('biller_logo_tip') ?: 'Logo affiché sur les factures.'; ?></small>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('upload_logo', lang('upload_logo') ?: 'Téléverser le logo', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
