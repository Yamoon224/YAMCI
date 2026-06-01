<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none!important; } }</style>
<div class="modal-dialog modal-dialog-centered modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-archive-line me-2 text-primary icon-18px"></span>
        <?php echo lang('packaging') ?: 'Emballage'; ?>
        — <span class="text-muted fw-normal"><?php echo htmlspecialchars($inv->reference_no ?? ''); ?></span>
      </h5>
      <div class="d-flex gap-2 no-print">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <!-- Customer & Biller info -->
      <div class="row mb-4">
        <div class="col-sm-6">
          <div class="bg-light rounded p-3">
            <h6 class="fw-semibold mb-2"><?php echo lang('ship_to') ?: 'Destinataire'; ?></h6>
            <div class="fw-semibold"><?php echo htmlspecialchars($inv->customer ?? ''); ?></div>
            <?php if (!empty($inv->customer_address)): ?>
              <div class="text-muted small"><?php echo $this->sma->decode_html($inv->customer_address); ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="bg-light rounded p-3">
            <h6 class="fw-semibold mb-2"><?php echo lang('from') ?: 'Expéditeur'; ?></h6>
            <div class="fw-semibold"><?php echo htmlspecialchars($inv->biller ?? ''); ?></div>
            <div class="text-muted small"><?php echo htmlspecialchars($inv->warehouse_name ?? ''); ?></div>
          </div>
        </div>
      </div>

      <!-- Items -->
      <div class="table-responsive">
        <table class="table table-bordered print-table">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th><?php echo lang('product') ?: 'Produit'; ?></th>
              <th class="text-center"><?php echo lang('quantity') ?: 'Quantité'; ?></th>
              <th><?php echo lang('unit') ?: 'Unité'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach ($rows as $row): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td>
                <?php echo htmlspecialchars($row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?>
                <?php if (!empty($row->serial_no)): ?>
                  <br><small class="text-muted"><?php echo htmlspecialchars($row->serial_no); ?></small>
                <?php endif; ?>
              </td>
              <td class="text-center"><?php echo $this->sma->formatQuantity($row->quantity); ?></td>
              <td><?php echo htmlspecialchars($row->unit_name ?? ''); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <?php if (!empty($inv->note)): ?>
      <div class="bg-light rounded p-3 mt-3">
        <p class="fw-semibold mb-1"><?php echo lang('note') ?: 'Note'; ?>:</p>
        <div><?php echo $this->sma->decode_html($inv->note); ?></div>
      </div>
      <?php endif; ?>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
