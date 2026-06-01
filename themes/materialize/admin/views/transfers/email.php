<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-mail-send-line me-2 text-primary icon-18px"></span>
        <?php echo lang('email_transfer') ?: 'Envoyer le transfert par e-mail'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('transfers/email/' . ($inv->id ?? ''), ['id' => 'emailTransferForm']); ?>
    <div class="modal-body">
      <div class="row g-3">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="email" class="form-control" id="trans_email_to" name="email_to"
                   placeholder="email@example.com"
                   value="<?php echo htmlspecialchars(isset($to_email) ? $to_email : ''); ?>" required />
            <label for="trans_email_to"><?php echo lang('email_to') ?: 'Destinataire'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="trans_email_subject" name="email_subject"
                   placeholder="Objet"
                   value="<?php echo htmlspecialchars(isset($email_subject) ? $email_subject : (lang('transfer') ?: 'Transfert') . ' ' . ($inv->transfer_no ?? $inv->reference_no ?? '')); ?>" />
            <label for="trans_email_subject"><?php echo lang('subject') ?: 'Objet'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="trans_email_msg" name="email_message"
                      placeholder="Message" style="height:100px;"><?php echo isset($email_message) ? $this->sma->decode_html($email_message) : ''; ?></textarea>
            <label for="trans_email_msg"><?php echo lang('message') ?: 'Message'; ?></label>
          </div>
        </div>
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
