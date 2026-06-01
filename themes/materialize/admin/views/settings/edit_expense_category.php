<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-bill-line me-2 text-primary icon-18px"></span>
        <?php echo lang('edit_expense_category') ?: 'Modifier la catégorie de dépense'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open('system_settings/edit_expense_category/' . ($expense_category->id ?? $id ?? ''), ['id' => 'editExpCatForm']); ?>
    <div class="modal-body">
      <div class="row g-4">
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('code', set_value('code', $expense_category->code ?? ''), 'class="form-control" id="exp_code" placeholder="Code" required'); ?>
            <label for="exp_code"><?php echo lang('category_code') ?: 'Code'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('name', set_value('name', $expense_category->name ?? ''), 'class="form-control" id="exp_name" placeholder="Nom" required'); ?>
            <label for="exp_name"><?php echo lang('category_name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('edit_expense_category', lang('save') ?: 'Enregistrer', 'class="btn btn-warning"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
