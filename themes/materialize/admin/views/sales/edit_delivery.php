<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-truck-line me-2 text-primary icon-18px"></span>
        <?php echo lang('edit_delivery') ?: 'Modifier la livraison'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open_multipart('sales/edit_delivery/' . $delivery->id); ?>
    <div class="modal-body">
      <div class="row g-3">
        <?php if ($Owner || $Admin): ?>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="del_date" name="date"
                   placeholder="Date"
                   value="<?php echo $this->sma->hrld($delivery->date); ?>" required />
            <label for="del_date"><?php echo lang('date') ?: 'Date'; ?></label>
          </div>
        </div>
        <?php endif; ?>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="del_ref" name="do_reference_no"
                   placeholder="BL-000"
                   value="<?php echo set_value('do_reference_no', $delivery->do_reference_no); ?>" required />
            <label for="del_ref"><?php echo lang('do_reference_no') ?: 'N° BL'; ?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="del_saleref" name="sale_reference_no"
                   placeholder="VT-000"
                   value="<?php echo set_value('sale_reference_no', $delivery->sale_reference_no); ?>" required />
            <label for="del_saleref"><?php echo lang('sale_reference_no') ?: 'Réf. vente'; ?></label>
          </div>
          <?php echo form_hidden('sale_id', $delivery->sale_id); ?>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="del_customer" name="customer"
                   placeholder="Client"
                   value="<?php echo set_value('customer', $delivery->customer); ?>" required />
            <label for="del_customer"><?php echo lang('customer') ?: 'Client'; ?></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php
            $status_opts = [
              'pending'   => lang('pending')   ?: 'En attente',
              'sent'      => lang('sent')       ?: 'Envoyé',
              'delivered' => lang('delivered')  ?: 'Livré',
            ];
            echo form_dropdown('status', $status_opts, $delivery->status,
              'class="form-select select2" id="del_status"');
            ?>
            <label for="del_status"><?php echo lang('status') ?: 'Statut'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="del_address" name="address" placeholder="Adresse" style="height:80px;"
            ><?php echo set_value('address', $delivery->address); ?></textarea>
            <label for="del_address"><?php echo lang('address') ?: 'Adresse'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="del_note" name="note" placeholder="Note" style="height:60px;"
            ><?php echo $this->sma->decode_html($delivery->note ?? ''); ?></textarea>
            <label for="del_note"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <label class="form-label"><?php echo lang('attachment') ?: 'Pièce jointe'; ?></label>
          <input type="file" class="form-control" name="document" />
          <?php if (!empty($delivery->document)): ?>
            <small class="text-muted mt-1 d-block">
              <span class="icon-base ri ri-attachment-2 me-1 icon-12px"></span>
              <?php echo htmlspecialchars($delivery->document); ?>
            </small>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('edit_delivery', lang('update') ?: 'Mettre à jour', 'class="btn btn-warning"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
