<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-lock-password-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Changer le mot de passe</h4>
    <p class="mb-0 text-muted">Modifiez votre mot de passe pour sécuriser votre compte</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active">Changer le mot de passe</li>
      </ol>
    </nav>
  </div>
</div>

<div class="row justify-content-center">
  <div class="col-md-6">
    <div class="card">
      <div class="card-header d-flex align-items-center">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-shield-keyhole-line me-2 text-primary icon-18px"></span>
          <?php echo lang('change_password_heading') ?: 'Nouveau mot de passe'; ?>
        </h5>
      </div>
      <div class="card-body">
        <?php echo admin_form_open('auth/change_password', ['id' => 'changePasswordForm']); ?>

          <div class="mb-4">
            <label class="form-label" for="old_password">
              <?php echo lang('change_password_old_password_label') ?: 'Mot de passe actuel'; ?> <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <?php
                $op = $old_password;
                $op['class'] = 'form-control';
                $op['id'] = 'old_password';
                $op['placeholder'] = '············';
                echo form_input($op);
                ?>
                <label for="old_password"><?php echo lang('change_password_old_password_label') ?: 'Mot de passe actuel'; ?></label>
              </div>
              <span class="input-group-text cursor-pointer toggle-pwd">
                <i class="icon-base ri ri-eye-off-line icon-20px"></i>
              </span>
            </div>
          </div>

          <div class="mb-4">
            <label class="form-label" for="new_password">
              <?php echo sprintf(lang('change_password_new_password_label') ?: 'Nouveau mot de passe (min %s caractères)', $min_password_length); ?> <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <?php
                $np = $new_password;
                $np['class'] = 'form-control';
                $np['id'] = 'new_password';
                $np['placeholder'] = '············';
                echo form_input($np);
                ?>
                <label for="new_password"><?php echo lang('new_password') ?: 'Nouveau mot de passe'; ?></label>
              </div>
              <span class="input-group-text cursor-pointer toggle-pwd">
                <i class="icon-base ri ri-eye-off-line icon-20px"></i>
              </span>
            </div>
          </div>

          <div class="mb-5">
            <label class="form-label" for="new_password_confirm">
              <?php echo lang('change_password_new_password_confirm_label') ?: 'Confirmer le nouveau mot de passe'; ?> <span class="text-danger">*</span>
            </label>
            <div class="input-group input-group-merge">
              <div class="form-floating form-floating-outline">
                <?php
                $npc = $new_password_confirm;
                $npc['class'] = 'form-control';
                $npc['id'] = 'new_password_confirm';
                $npc['placeholder'] = '············';
                echo form_input($npc);
                ?>
                <label for="new_password_confirm"><?php echo lang('confirm_password') ?: 'Confirmer le mot de passe'; ?></label>
              </div>
              <span class="input-group-text cursor-pointer toggle-pwd">
                <i class="icon-base ri ri-eye-off-line icon-20px"></i>
              </span>
            </div>
          </div>

          <?php echo form_input($user_id); ?>

          <div class="d-flex gap-3">
            <button type="submit" class="btn btn-primary">
              <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
              <?php echo lang('change_password_submit_btn') ?: 'Mettre à jour'; ?>
            </button>
            <a href="<?php echo admin_url(); ?>" class="btn btn-outline-secondary">
              <?php echo lang('cancel') ?: 'Annuler'; ?>
            </a>
          </div>

        <?php echo form_close(); ?>
      </div>
    </div>
  </div>
</div>

<script>
document.querySelectorAll('.toggle-pwd').forEach(function(btn) {
  btn.addEventListener('click', function() {
    var input = this.closest('.input-group').querySelector('input');
    var icon = this.querySelector('i');
    if (input.type === 'password') {
      input.type = 'text';
      icon.className = 'icon-base ri ri-eye-line icon-20px';
    } else {
      input.type = 'password';
      icon.className = 'icon-base ri ri-eye-off-line icon-20px';
    }
  });
});
</script>
