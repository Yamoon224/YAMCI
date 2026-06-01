<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-mail-send-line me-2 text-primary icon-18px"></span>
        <?php echo lang('email_receipt') ?: 'Envoyer le reçu par e-mail'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('pos/email_receipt/' . ($inv->id ?? ''), ['id' => 'emailReceiptForm']); ?>
    <div class="modal-body">
      <p class="text-muted small mb-4">
        <?php echo lang('send_receipt_tip') ?: 'Envoyez le reçu de la vente directement par e-mail au client.'; ?>
      </p>
      <div class="form-floating form-floating-outline">
        <input type="email" class="form-control" id="receipt_email" name="email"
               placeholder="email@example.com"
               value="<?php echo htmlspecialchars($customer->email ?? ''); ?>" required />
        <label for="receipt_email"><?php echo lang('email') ?: 'Adresse e-mail'; ?> <span class="text-danger">*</span></label>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <button type="submit" class="btn btn-primary">
        <span class="icon-base ri ri-send-plane-line me-1 icon-14px"></span>
        <?php echo lang('send') ?: 'Envoyer'; ?>
      </button>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
