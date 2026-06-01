<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none!important; } }</style>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-truck-line me-2 text-primary icon-18px"></span>
        <?php echo lang('delivery') ?: 'Bon de livraison'; ?>
      </h5>
      <div class="d-flex gap-2 no-print">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <!-- Logo -->
      <?php if (!empty($logo) && !empty($biller->logo)): ?>
      <div class="text-center mb-4">
        <img src="<?php echo base_url('assets/uploads/logos/' . $biller->logo); ?>"
             alt="<?php echo htmlspecialchars($biller->company ?: $biller->name); ?>" style="max-height:60px;" />
      </div>
      <?php endif; ?>

      <!-- Delivery details table -->
      <div class="table-responsive mb-4">
        <table class="table table-bordered mb-0">
          <tbody>
            <tr>
              <td class="fw-semibold" style="width:30%;"><?php echo lang('date') ?: 'Date'; ?></td>
              <td><?php echo $this->sma->hrld($delivery->date); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('do_reference_no') ?: 'N° BL'; ?></td>
              <td><?php echo htmlspecialchars($delivery->do_reference_no ?? ''); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('sale_reference_no') ?: 'Réf. vente'; ?></td>
              <td><?php echo htmlspecialchars($delivery->sale_reference_no ?? ''); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('customer') ?: 'Client'; ?></td>
              <td><?php echo htmlspecialchars($delivery->customer ?? ''); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('address') ?: 'Adresse'; ?></td>
              <td><?php echo $this->sma->decode_html($delivery->address ?? ''); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('status') ?: 'Statut'; ?></td>
              <td>
                <span class="badge bg-label-<?php echo $delivery->status == 'delivered' ? 'success' : ($delivery->status == 'pending' ? 'warning' : 'info'); ?>">
                  <?php echo lang($delivery->status) ?: $delivery->status; ?>
                </span>
              </td>
            </tr>
            <?php if (!empty($delivery->note)): ?>
            <tr>
              <td class="fw-semibold"><?php echo lang('note') ?: 'Note'; ?></td>
              <td><?php echo $this->sma->decode_html($delivery->note); ?></td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Items -->
      <?php if (!empty($rows)): ?>
      <h6 class="fw-semibold mb-3"><?php echo lang('items') ?: 'Articles'; ?></h6>
      <div class="table-responsive">
        <table class="table table-bordered print-table">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th><?php echo lang('product') ?: 'Produit'; ?></th>
              <th class="text-center"><?php echo lang('quantity') ?: 'Quantité'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; foreach ($rows as $row): ?>
            <tr>
              <td><?php echo $i++; ?></td>
              <td><?php echo htmlspecialchars($row->product_code . ' - ' . $row->product_name); ?></td>
              <td class="text-center"><?php echo $this->sma->formatQuantity($row->quantity); ?></td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
