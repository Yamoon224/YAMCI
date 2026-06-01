<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered modal-lg">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-notification-3-line me-2 icon-18px"></span>
        <?php echo lang('edit_notification') ?: 'Modifier la notification'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <?php echo admin_form_open_multipart('notifications/edit/' . $notification->id, ['id' => 'editNotifForm']); ?>

    <div class="modal-body">
      <p class="text-muted mb-4"><?php echo lang('update_info') ?: 'Mettez à jour les informations de la notification.'; ?></p>

      <div class="row g-4">

        <!-- Title -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="notif_title" name="title"
                   value="<?php echo htmlspecialchars($notification->title ?? ''); ?>"
                   placeholder="<?php echo lang('title') ?: 'Titre'; ?>" required />
            <label for="notif_title"><?php echo lang('title') ?: 'Titre'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <!-- Message -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="notif_message" name="message"
                      placeholder="<?php echo lang('message') ?: 'Message'; ?>"
                      style="height:120px;" required><?php echo htmlspecialchars($notification->message ?? ''); ?></textarea>
            <label for="notif_message"><?php echo lang('message') ?: 'Message'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <!-- Link -->
        <div class="col-md-8">
          <div class="form-floating form-floating-outline">
            <input type="url" class="form-control" id="notif_link" name="link"
                   value="<?php echo htmlspecialchars($notification->link ?? ''); ?>"
                   placeholder="https://example.com" />
            <label for="notif_link"><?php echo lang('link') ?: 'Lien'; ?></label>
          </div>
        </div>

        <!-- Type -->
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php
            $types = [
              ''        => lang('select') . ' ' . (lang('type') ?: 'Type'),
              'info'    => 'Info',
              'success' => 'Succès',
              'warning' => 'Avertissement',
              'danger'  => 'Erreur',
            ];
            echo form_dropdown('type', $types, $notification->type ?? '',
              'class="form-select select2" id="notif_type" data-placeholder="' . (lang('select_type') ?: 'Sélectionner le type') . '"');
            ?>
            <label for="notif_type"><?php echo lang('type') ?: 'Type'; ?></label>
          </div>
        </div>

        <!-- Image upload -->
        <div class="col-12">
          <label class="form-label"><?php echo lang('image') ?: 'Image'; ?></label>
          <input type="file" class="form-control" name="image" id="notif_image"
                 accept="image/png,image/jpeg,image/gif,image/webp" />
          <?php if (!empty($notification->image)): ?>
          <div class="mt-2 d-flex align-items-center gap-2">
            <img src="<?php echo base_url($notification->image); ?>" alt="current"
                 class="rounded" style="height:48px; width:auto; object-fit:cover;" />
            <span class="text-muted small"><?php echo lang('current_image') ?: 'Image actuelle'; ?></span>
          </div>
          <?php endif; ?>
        </div>

      </div>

      <?php echo form_hidden('id', $notification->id); ?>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <button type="submit" class="btn btn-primary" id="saveNotifBtn">
        <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
        <?php echo lang('save') ?: 'Enregistrer'; ?>
      </button>
    </div>

    <?php echo form_close(); ?>
  </div>
</div>

<script>
(function () {
  'use strict';
  document.getElementById('editNotifForm').addEventListener('submit', function () {
    var btn = document.getElementById('saveNotifBtn');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span><?php echo addslashes(lang('saving') ?: 'Enregistrement...'); ?>';
  });
})();
</script>
