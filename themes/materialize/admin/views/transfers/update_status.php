<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-refresh-line me-2 text-primary icon-18px"></span>
        <?php echo lang('update_status') ?: 'Mettre à jour le statut'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open_multipart('transfers/update_status/' . $inv->id); ?>
    <div class="modal-body">
      <!-- Transfer info -->
      <div class="bg-light rounded p-3 mb-4">
        <div class="row g-2">
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('reference_no') ?: 'Référence'; ?></div>
            <div class="fw-semibold"><?php echo htmlspecialchars($inv->transfer_no ?? $inv->reference_no ?? ''); ?></div>
          </div>
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('status') ?: 'Statut'; ?></div>
            <span class="badge bg-label-info"><?php echo lang($inv->status) ?: $inv->status; ?></span>
          </div>
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('from') ?: 'De'; ?></div>
            <div class="fw-semibold"><?php echo htmlspecialchars(($inv->from_warehouse_name ?? '') . ' (' . ($inv->from_warehouse_code ?? '') . ')'); ?></div>
          </div>
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('to') ?: 'Vers'; ?></div>
            <div class="fw-semibold"><?php echo htmlspecialchars(($inv->to_warehouse_name ?? '') . ' (' . ($inv->to_warehouse_code ?? '') . ')'); ?></div>
          </div>
        </div>
      </div>

      <div class="row g-3">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $opts = [
              'completed' => lang('completed') ?: 'Complété',
              'pending'   => lang('pending')   ?: 'En attente',
              'sent'      => lang('sent')       ?: 'Envoyé',
            ];
            echo form_dropdown('status', $opts, $inv->status, 'class="form-select select2" id="transStatus"');
            ?>
            <label for="transStatus"><?php echo lang('status') ?: 'Statut'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="transNote" name="note" placeholder="Note" style="height:90px;"><?php echo $this->sma->decode_html($inv->note ?? ''); ?></textarea>
            <label for="transNote"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('update_status', lang('update') ?: 'Mettre à jour', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<?php echo $modal_js; ?>
