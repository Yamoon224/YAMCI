<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-map-pin-line me-2 text-primary icon-18px"></span>
        <?php echo htmlspecialchars($product->name ?? ''); ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('products/set_rack/' . ($product->id ?? '') . '/' . ($warehouse_id ?? '')); ?>
    <div class="modal-body">
      <div class="form-floating form-floating-outline">
        <?php echo form_input('rack', $rack ?? '', 'id="rack_loc" class="form-control" placeholder="A1-B2" required="required"'); ?>
        <label for="rack_loc"><?php echo lang('rack_location') ?: 'Emplacement rack'; ?></label>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('set_rack', lang('set_rack') ?: 'Définir', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
