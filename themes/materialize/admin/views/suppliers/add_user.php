<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-user-add-line me-2 text-primary icon-18px"></span>
        <?php echo lang('add_user') ?: 'Ajouter un utilisateur'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('suppliers/add_user/' . (isset($supplier) ? $supplier->id : '')); ?>
    <div class="modal-body">
      <div class="row g-3">
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="su_firstname" name="first_name"
                   placeholder="Prénom" value="<?php echo set_value('first_name'); ?>" required />
            <label for="su_firstname"><?php echo lang('first_name') ?: 'Prénom'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="su_lastname" name="last_name"
                   placeholder="Nom" value="<?php echo set_value('last_name'); ?>" required />
            <label for="su_lastname"><?php echo lang('last_name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="email" class="form-control" id="su_email" name="email"
                   placeholder="Email" value="<?php echo set_value('email'); ?>" required />
            <label for="su_email"><?php echo lang('email') ?: 'Email'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="password" class="form-control" id="su_pass" name="password" placeholder="Mot de passe" required />
            <label for="su_pass"><?php echo lang('password') ?: 'Mot de passe'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="password" class="form-control" id="su_pass2" name="password_confirm" placeholder="Confirmer" required />
            <label for="su_pass2"><?php echo lang('confirm_password') ?: 'Confirmer'; ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('add_user', lang('save') ?: 'Enregistrer', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
