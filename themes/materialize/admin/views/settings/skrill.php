<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">

    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-bank-line me-2 icon-18px"></span>
        <?php echo lang('skrill_settings') ?: 'Paramètres Skrill'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <?php echo admin_form_open('system_settings/skrill', ['id' => 'skrillForm']); ?>

    <div class="modal-body">
      <p class="text-muted mb-4"><?php echo lang('update_info') ?: 'Mettez à jour les informations Skrill.'; ?></p>

      <div class="row g-4">

        <!-- Skrill email -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="email" class="form-control" id="skrill_email" name="skrill_email"
                   value="<?php echo isset($skrill) ? htmlspecialchars($skrill->account_email ?? '') : set_value('skrill_email'); ?>"
                   placeholder="skrill@example.com" required />
            <label for="skrill_email">
              <?php echo lang('skrill_account_email') ?: 'Adresse email Skrill'; ?>
              <span class="text-danger">*</span>
            </label>
          </div>
          <div class="form-text"><?php echo lang('skrill_email_tip') ?: 'Adresse email associée à votre compte marchand Skrill.'; ?></div>
        </div>

        <!-- Currency -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="skrill_currency" name="skrill_currency"
                   value="<?php echo isset($skrill) ? htmlspecialchars($skrill->currency ?? 'EUR') : set_value('skrill_currency', 'EUR'); ?>"
                   placeholder="EUR" maxlength="3" />
            <label for="skrill_currency">
              <?php echo lang('currency') ?: 'Devise (ex: EUR, USD)'; ?>
            </label>
          </div>
          <div class="form-text"><?php echo lang('skrill_currency_tip') ?: 'Code devise ISO 4217, ex: EUR, USD, GBP'; ?></div>
        </div>

        <!-- Active -->
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $yn = ['1' => lang('yes') ?: 'Oui', '0' => lang('no') ?: 'Non'];
            $cur_active = isset($skrill) ? ($skrill->active ?? '0') : set_value('active', '0');
            echo form_dropdown('active', $yn, $cur_active,
              'class="form-select" id="skrill_active"');
            ?>
            <label for="skrill_active"><?php echo lang('activate') ?: 'Activer'; ?></label>
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
