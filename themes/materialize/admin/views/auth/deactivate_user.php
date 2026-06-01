<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-user-unfollow-line me-2 text-warning icon-18px"></span>
        <?php echo lang('deactivate') ?: 'Désactiver'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open('auth/deactivate/' . $user->id); ?>
    <div class="modal-body">
      <div class="alert alert-warning d-flex align-items-center gap-2 mb-3">
        <span class="icon-base ri ri-alert-line icon-20px"></span>
        <span><?php echo sprintf(lang('deactivate_heading') ?: 'Voulez-vous désactiver l\'utilisateur %s ?', '<strong>' . htmlspecialchars($user->username) . '</strong>'); ?></span>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="checkbox" name="confirm" value="yes" checked id="confirmDeactivate" />
        <label class="form-check-label" for="confirmDeactivate"><?php echo lang('yes') ?: 'Oui, confirmer'; ?></label>
      </div>
      <?php echo form_hidden(['id' => $user->id]); ?>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('deactivate', lang('deactivate') ?: 'Désactiver', 'class="btn btn-warning"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
