<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-add-circle-line me-2"></span>
        <?php echo (lang('add_deposit') ?: 'Ajouter un dépôt') . ' (' . htmlspecialchars($customer->name) . ')'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close') ?: 'Fermer'; ?>"></button>
    </div>

    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'addDepositForm'];
    echo admin_form_open_multipart('customers/add_deposit/' . $customer->id, $attrib);
    ?>

    <div class="modal-body">
      <div class="row g-3">

        <?php if ($Owner || $Admin): ?>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', set_value('date', date($dateFormats['php_ldate'])),
              'class="form-control" id="dep_date" placeholder="Date" required="required"'); ?>
            <label for="dep_date"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', set_value('reference_no'),
              'class="form-control" id="dep_ref" placeholder="REF-000"'); ?>
            <label for="dep_ref"><?php echo lang('reference_no') ?: 'Référence'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('amount', set_value('amount'),
              'class="form-control" id="dep_amount" placeholder="0.00" required="required"'); ?>
            <label for="dep_amount"><?php echo lang('amount') ?: 'Montant'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', set_value('note'),
              'class="form-control" id="dep_note" placeholder="Note" style="height:90px;"'); ?>
            <label for="dep_note"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <label class="form-label" for="dep_attachment">
            <?php echo lang('attach_document') ?: 'Pièce jointe'; ?>
          </label>
          <input type="file" class="form-control" name="attachment" id="dep_attachment" />
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <?php echo form_submit('add_deposit', lang('add_deposit') ?: 'Ajouter', 'class="btn btn-primary"'); ?>
    </div>

    <?php echo form_close(); ?>
  </div>
</div>

<?php echo $modal_js; ?>
