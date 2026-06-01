<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-arrow-up-down-line me-2 text-primary icon-18px"></span>
        <?php echo lang('quantity_adjustment') ?: 'Ajustement de stock'; ?> — <?php echo htmlspecialchars($inv->reference_no); ?>
      </h5>
      <div class="d-flex gap-2">
        <button type="button" class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span>
          <?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    </div>
    <div class="modal-body">

      <!-- Logo & info -->
      <div class="text-center mb-4">
        <?php if (!empty($Settings->logo)): ?>
          <img src="<?php echo base_url('assets/uploads/logos/' . $Settings->logo); ?>"
               alt="<?php echo htmlspecialchars($Settings->site_name); ?>"
               style="max-height:60px;" />
        <?php else: ?>
          <h5><?php echo htmlspecialchars($Settings->site_name); ?></h5>
        <?php endif; ?>
      </div>

      <div class="row mb-4">
        <div class="col-sm-6">
          <div class="bg-light rounded p-3">
            <p class="mb-1"><strong><?php echo lang('date') ?: 'Date'; ?>:</strong> <?php echo $this->sma->hrld($inv->date); ?></p>
            <p class="mb-1"><strong><?php echo lang('ref') ?: 'Réf.'; ?>:</strong> <?php echo htmlspecialchars($inv->reference_no); ?></p>
            <p class="mb-0"><strong><?php echo lang('warehouse') ?: 'Entrepôt'; ?>:</strong> <?php echo htmlspecialchars($inv->warehouse_name ?? ''); ?></p>
          </div>
        </div>
        <div class="col-sm-6 text-end order_barcodes">
          <img src="<?php echo admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1'); ?>"
               alt="<?php echo htmlspecialchars($inv->reference_no); ?>" class="bcimg img-fluid" style="max-height:50px;" />
          <div class="mt-1">
            <?php echo $this->sma->qrcode('link', urlencode(admin_url('products/view_adjustment/' . $inv->id)), 2); ?>
          </div>
        </div>
      </div>

      <!-- Items table -->
      <div class="table-responsive">
        <table class="table table-bordered print-table order-table">
          <thead class="table-light">
            <tr>
              <th style="width:40px;" class="text-center"><?php echo lang('no') ?: '#'; ?></th>
              <th><?php echo lang('description') ?: 'Description'; ?></th>
              <th style="width:120px;"><?php echo lang('type') ?: 'Type'; ?></th>
              <th style="width:100px;" class="text-center"><?php echo lang('quantity') ?: 'Quantité'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $r = 1; foreach ($rows as $row): ?>
              <tr>
                <td class="text-center align-middle"><?php echo $r; ?></td>
                <td class="align-middle">
                  <?php echo htmlspecialchars($row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?>
                  <?php if ($row->serial_no): ?>
                    <br><small class="text-muted"><?php echo htmlspecialchars($row->serial_no); ?></small>
                  <?php endif; ?>
                </td>
                <td class="align-middle">
                  <?php
                  $type_label = $row->type === 'addition'
                    ? '<span class="badge bg-label-success">' . (lang('addition') ?: 'Ajout') . '</span>'
                    : '<span class="badge bg-label-danger">' . (lang('subtraction') ?: 'Soustraction') . '</span>';
                  echo $type_label;
                  ?>
                </td>
                <td class="text-center align-middle">
                  <strong><?php echo $this->sma->formatQuantity($row->quantity); ?></strong>
                </td>
              </tr>
              <?php $r++; endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Note -->
      <?php if (!empty($inv->note)): ?>
      <div class="bg-light rounded p-3 mt-3">
        <p class="fw-semibold mb-1"><?php echo lang('note') ?: 'Note'; ?>:</p>
        <div><?php echo $this->sma->decode_html($inv->note); ?></div>
      </div>
      <?php endif; ?>

    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
      <?php if (!empty($GP['adjustments']['edit']) || $Owner || $Admin): ?>
        <a href="<?php echo admin_url('products/edit_adjustment/' . $inv->id); ?>" class="btn btn-warning">
          <span class="icon-base ri ri-edit-line me-1 icon-14px"></span>
          <?php echo lang('edit') ?: 'Modifier'; ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>
