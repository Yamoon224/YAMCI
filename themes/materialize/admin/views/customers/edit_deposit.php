<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-edit-line me-2"></span>
        <?php echo (lang('edit_deposit') ?: 'Modifier le dépôt') . ' (' . htmlspecialchars($customer->name) . ')'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close') ?: 'Fermer'; ?>"></button>
    </div>

    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'editDepositForm'];
    echo admin_form_open_multipart('customers/edit_deposit/' . $deposit->id, $attrib);
    ?>

    <div class="modal-body">
      <div class="row g-3">

        <?php if ($Owner || $Admin): ?>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', set_value('date', $this->sma->hrld($deposit->date)),
              'class="form-control" id="dep_date" placeholder="Date" required="required"'); ?>
            <label for="dep_date"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', set_value('reference_no', $deposit->reference_no ?? ''),
              'class="form-control" id="dep_ref" placeholder="REF-000"'); ?>
            <label for="dep_ref"><?php echo lang('reference_no') ?: 'Référence'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('amount', set_value('amount', $this->sma->formatMoney($deposit->amount)),
              'class="form-control" id="dep_amount" placeholder="0.00" required="required"'); ?>
            <label for="dep_amount"><?php echo lang('amount') ?: 'Montant'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', $deposit->note,
              'class="form-control" id="dep_note" placeholder="Note" style="height:90px;"'); ?>
            <label for="dep_note"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label" for="dep_attachment">
            <?php echo lang('attach_document') ?: 'Pièce jointe'; ?>
          </label>
          <input type="file" class="form-control" name="attachment" id="dep_attachment" />
          <?php if (!empty($deposit->attachment)): ?>
          <div class="mt-1 small text-muted">
            <span class="icon-base ri ri-attachment-2 me-1 icon-14px"></span>
            <a href="<?php echo $deposit->attachment; ?>" target="_blank">
              <?php echo lang('current_attachment') ?: 'Pièce jointe actuelle'; ?>
            </a>
          </div>
          <?php endif; ?>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <?php echo form_submit('edit_deposit', lang('edit_deposit') ?: 'Enregistrer', 'class="btn btn-primary"'); ?>
    </div>

    <?php echo form_close(); ?>
  </div>
</div>

<?php echo $modal_js; ?>
