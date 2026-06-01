<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-bank-card-line me-2 icon-18px"></span>
        <?php echo lang('paypal_settings') ?: 'Paramètres PayPal'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <?php echo admin_form_open('system_settings/paypal', ['id' => 'paypalForm']); ?>

    <div class="modal-body">
      <p class="text-muted mb-4"><?php echo lang('update_info') ?: 'Mettez à jour les informations PayPal.'; ?></p>

      <div class="row g-4">

        <!-- PayPal email -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="email" class="form-control" id="paypal_email" name="paypal_email"
                   value="<?php echo isset($paypal) ? htmlspecialchars($paypal->account_email ?? '') : set_value('paypal_email'); ?>"
                   placeholder="paypal@example.com" required />
            <label for="paypal_email">
              <?php echo lang('paypal_account_email') ?: 'Adresse email PayPal'; ?>
              <span class="text-danger">*</span>
            </label>
          </div>
        </div>

        <!-- Currency -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="paypal_currency" name="paypal_currency"
                   value="<?php echo isset($paypal) ? htmlspecialchars($paypal->currency ?? 'USD') : set_value('paypal_currency', 'USD'); ?>"
                   placeholder="USD" maxlength="3" />
            <label for="paypal_currency">
              <?php echo lang('currency') ?: 'Devise (ex: USD, EUR)'; ?>
            </label>
          </div>
          <div class="form-text"><?php echo lang('paypal_currency_tip') ?: 'Code devise ISO 4217, ex: USD, EUR, XOF'; ?></div>
        </div>

        <!-- Mode -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $modes = ['sandbox' => 'Sandbox (Test)', 'live' => 'Live (Production)'];
            $cur_mode = isset($paypal) ? ($paypal->mode ?? 'sandbox') : set_value('paypal_mode', 'sandbox');
            echo form_dropdown('paypal_mode', $modes, $cur_mode,
              'class="form-select" id="paypal_mode"');
            ?>
            <label for="paypal_mode"><?php echo lang('paypal_mode') ?: 'Mode'; ?></label>
          </div>
        </div>

        <!-- Active -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $yn = ['1' => lang('yes') ?: 'Oui', '0' => lang('no') ?: 'Non'];
            $cur_active = isset($paypal) ? ($paypal->active ?? '0') : set_value('active', '0');
            echo form_dropdown('active', $yn, $cur_active,
              'class="form-select" id="paypal_active"');
            ?>
            <label for="paypal_active"><?php echo lang('activate') ?: 'Activer'; ?></label>
          </div>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <button type="submit" class="btn btn-primary">
        <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
        <?php echo lang('update_settings') ?: 'Enregistrer'; ?>
      </button>
    </div>

    <?php echo form_close(); ?>
  </div>
</div>
