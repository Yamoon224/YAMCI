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
    <?php echo admin_form_open_multipart('quotes/update_status/' . $inv->id); ?>
    <div class="modal-body">
      <!-- Quote info -->
      <div class="bg-light rounded p-3 mb-4">
        <div class="row g-2">
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('reference_no') ?: 'Référence'; ?></div>
            <div class="fw-semibold"><?php echo htmlspecialchars($inv->reference_no); ?></div>
          </div>
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('customer') ?: 'Client'; ?></div>
            <div class="fw-semibold"><?php echo htmlspecialchars($inv->customer ?? ''); ?></div>
          </div>
          <div class="col-6">
            <div class="small text-muted"><?php echo lang('status') ?: 'Statut'; ?></div>
            <span class="badge bg-label-info"><?php echo lang($inv->sale_status ?? $inv->status ?? '') ?: ($inv->sale_status ?? ''); ?></span>
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
              'cancelled' => lang('cancelled') ?: 'Annulé',
            ];
            $current = $inv->sale_status ?? $inv->status ?? 'pending';
            echo form_dropdown('status', $opts, $current, 'class="form-select select2" id="quoteStatus"');
            ?>
            <label for="quoteStatus"><?php echo lang('status') ?: 'Statut'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <textarea class="form-control" id="quoteNote" name="note" placeholder="Note" style="height:80px;"><?php echo $this->sma->decode_html($inv->note ?? ''); ?></textarea>
            <label for="quoteNote"><?php echo lang('note') ?: 'Note'; ?></label>
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
