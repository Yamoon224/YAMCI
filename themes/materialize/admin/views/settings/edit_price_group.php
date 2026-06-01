<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-price-tag-3-line me-2 text-primary icon-18px"></span>
        <?php echo lang('edit_price_group') ?: 'Modifier le groupe de prix'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open('system_settings/edit_price_group/' . ($price_group->id ?? $id ?? ''), ['id' => 'editPriceGroupForm']); ?>
    <div class="modal-body">
      <div class="form-floating form-floating-outline">
        <?php echo form_input('name', set_value('name', $price_group->name ?? ''), 'class="form-control" id="pg_name" placeholder="Nom" required'); ?>
        <label for="pg_name"><?php echo lang('name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('edit_price_group', lang('save') ?: 'Enregistrer', 'class="btn btn-warning"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
