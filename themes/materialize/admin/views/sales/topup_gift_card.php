<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-gift-line me-2 text-primary icon-18px"></span>
        <?php echo lang('topup_gift_card') ?: 'Recharger la carte cadeau'; ?>
        <span class="text-muted fw-normal">(<?php echo htmlspecialchars($card->card_no ?? ''); ?>)</span>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('sales/topup_gift_card/' . $card->id); ?>
    <div class="modal-body">
      <div class="row g-3">
        <div class="col-12">
          <div class="bg-light rounded p-3 mb-2">
            <div class="row g-2 small">
              <div class="col-6">
                <span class="text-muted"><?php echo lang('card_no') ?: 'N° carte'; ?>:</span>
                <strong><?php echo htmlspecialchars($card->card_no ?? ''); ?></strong>
              </div>
              <div class="col-6">
                <span class="text-muted"><?php echo lang('balance') ?: 'Solde'; ?>:</span>
                <strong class="text-success"><?php echo $this->sma->formatMoney($card->balance ?? 0); ?></strong>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="gcAmount" name="amount"
                   placeholder="Montant" step="0.01" min="0.01" required />
            <label for="gcAmount"><?php echo lang('amount') ?: 'Montant'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="gcExpiry" name="expiry"
                   placeholder="Date d'expiration"
                   value="<?php echo $this->sma->hrsd(date('Y-m-d', strtotime('+2 year'))); ?>" />
            <label for="gcExpiry"><?php echo lang('expiry_date') ?: 'Date d\'expiration'; ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('topup', lang('topup_gift_card') ?: 'Recharger', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
