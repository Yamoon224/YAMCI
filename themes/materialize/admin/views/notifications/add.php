<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Notification Add Modal Content (loaded into #myModal via AJAX) -->
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-notification-3-line me-2 text-primary icon-18px"></span>
        <?php echo lang('add_notification') ?: 'Ajouter une notification'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <?php echo admin_form_open('notifications/add', ['id' => 'notifForm']); ?>
    <div class="modal-body">
      <p class="text-muted small mb-4"><?php echo lang('enter_info') ?: 'Remplissez les informations ci-dessous.'; ?></p>

      <div class="row g-4 mb-4">
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('from_date', '', 'class="form-control flatpickr-datetime" id="from_date" placeholder="Début" required'); ?>
            <label for="from_date"><?php echo lang('from') ?: 'Du'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('to_date', '', 'class="form-control flatpickr-datetime" id="to_date" placeholder="Fin" required'); ?>
            <label for="to_date"><?php echo lang('till') ?: 'Au'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <div class="form-floating form-floating-outline">
          <?php
          $cmt = $comment;
          $cmt['class'] = 'form-control';
          $cmt['id'] = 'comment';
          $cmt['placeholder'] = 'Message de la notification';
          $cmt['style'] = 'height:120px';
          echo form_textarea($cmt);
          ?>
          <label for="comment"><?php echo lang('comment') ?: 'Message'; ?></label>
        </div>
      </div>

      <div class="mb-2">
        <label class="form-label fw-semibold"><?php echo lang('audience') ?: 'Audience'; ?></label>
        <div class="d-flex gap-4">
          <div class="form-check">
            <input type="radio" class="form-check-input" name="scope" value="1" id="scopeCustomer" />
            <label class="form-check-label" for="scopeCustomer">
              <?php echo lang('for_customers_only') ?: 'Clients uniquement'; ?>
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="scope" value="2" id="scopeStaff" />
            <label class="form-check-label" for="scopeStaff">
              <?php echo lang('for_staff_only') ?: 'Personnel uniquement'; ?>
            </label>
          </div>
          <div class="form-check">
            <input type="radio" class="form-check-input" name="scope" value="3" id="scopeBoth" checked />
            <label class="form-check-label" for="scopeBoth">
              <?php echo lang('for_both') ?: 'Les deux'; ?>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <?php echo form_submit('add_notification', lang('add_notification') ?: 'Ajouter', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
