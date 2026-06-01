<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-bill-line me-2 text-primary icon-18px"></span>
        <?php echo lang('add_expense_category') ?: 'Ajouter une catégorie de dépense'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open('system_settings/add_expense_category', ['id' => 'addExpCatForm']); ?>
    <div class="modal-body">
      <p class="text-muted small mb-4"><?php echo lang('enter_info') ?: 'Remplissez les informations.'; ?></p>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('code', '', 'class="form-control" id="exp_code" placeholder="Code" required'); ?>
            <label for="exp_code"><?php echo lang('category_code') ?: 'Code'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('name', '', 'class="form-control" id="exp_name" placeholder="Nom" required'); ?>
            <label for="exp_name"><?php echo lang('category_name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('add_expense_category', lang('add_expense_category') ?: 'Ajouter', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
