<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-gift-line me-2 text-primary icon-18px"></span>
        <?php echo lang('edit_gift_card') ?: 'Modifier la carte cadeau'; ?>
        <span class="text-muted fw-normal">(<?php echo htmlspecialchars($card->card_no ?? ''); ?>)</span>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('sales/edit_gift_card/' . ($card->id ?? '')); ?>
    <div class="modal-body">
      <div class="row g-3">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="gcEdit_card_no" name="card_no"
                   placeholder="N° carte" value="<?php echo htmlspecialchars($card->card_no ?? ''); ?>" required />
            <label for="gcEdit_card_no"><?php echo lang('card_no') ?: 'N° de carte'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="gcEdit_value" name="value"
                   placeholder="Valeur" step="0.01" min="0" value="<?php echo (float)($card->value ?? 0); ?>" required />
            <label for="gcEdit_value"><?php echo lang('value') ?: 'Valeur initiale'; ?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="gcEdit_balance" name="balance"
                   placeholder="Solde" step="0.01" min="0" value="<?php echo (float)($card->balance ?? 0); ?>" required />
            <label for="gcEdit_balance"><?php echo lang('balance') ?: 'Solde actuel'; ?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php
            $c_opts = ['' => lang('select') . ' ' . (lang('customer') ?: 'Client')];
            if (isset($customers)) foreach ($customers as $c) $c_opts[$c->id] = $c->name;
            echo form_dropdown('customer_id', $c_opts, $card->customer_id ?? '',
              'class="form-select select2" id="gcEditCustomer"');
            ?>
            <label for="gcEditCustomer"><?php echo lang('customer') ?: 'Client'; ?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="gcEdit_expiry" name="expiry"
                   placeholder="Expiration"
                   value="<?php echo !empty($card->expiry) ? $this->sma->hrsd($card->expiry) : ''; ?>" />
            <label for="gcEdit_expiry"><?php echo lang('expiry_date') ?: 'Date d\'expiration'; ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('edit_gift_card', lang('update') ?: 'Mettre à jour', 'class="btn btn-warning"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
