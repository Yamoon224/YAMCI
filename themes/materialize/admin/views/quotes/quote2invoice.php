<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-file-transfer-line me-2 text-success icon-18px"></span>
        <?php echo lang('convert_to_sale') ?: 'Convertir en vente'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('quotes/quote2invoice/' . $inv->id); ?>
    <div class="modal-body">
      <div class="alert alert-info d-flex align-items-center gap-2 mb-4">
        <span class="icon-base ri ri-information-line icon-20px"></span>
        <span><?php echo lang('quote2invoice_confirm') ?: 'Ce devis va être converti en vente. Cette action est irréversible.'; ?></span>
      </div>

      <div class="bg-light rounded p-3 mb-3">
        <div class="row g-2 small">
          <div class="col-6">
            <span class="text-muted"><?php echo lang('reference_no') ?: 'Référence'; ?>:</span>
            <strong><?php echo htmlspecialchars($inv->reference_no); ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted"><?php echo lang('customer') ?: 'Client'; ?>:</span>
            <strong><?php echo htmlspecialchars($inv->customer ?? ''); ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted"><?php echo lang('date') ?: 'Date'; ?>:</span>
            <strong><?php echo $this->sma->hrld($inv->date); ?></strong>
          </div>
          <div class="col-6">
            <span class="text-muted"><?php echo lang('total') ?: 'Total'; ?>:</span>
            <strong><?php echo $this->sma->formatMoney($inv->grand_total ?? 0); ?></strong>
          </div>
        </div>
      </div>

      <div class="form-floating form-floating-outline">
        <input type="text" class="form-control" id="q2iRef" name="new_reference_no"
               placeholder="Nouvelle référence"
               value="<?php echo htmlspecialchars($new_reference ?? ''); ?>" />
        <label for="q2iRef"><?php echo lang('sale_reference_no') ?: 'Référence de la vente'; ?></label>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('convert', lang('convert_to_sale') ?: 'Convertir', 'class="btn btn-success"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
