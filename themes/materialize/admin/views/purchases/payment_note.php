<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none!important; } }</style>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-receipt-line me-2 text-primary icon-18px"></span>
        <?php echo lang('payment_note') ?: 'Reçu de paiement'; ?>
      </h5>
      <div class="d-flex gap-2 no-print">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <?php if (!empty($logo) && !empty($biller->logo)): ?>
      <div class="text-center mb-3">
        <img src="<?php echo base_url('assets/uploads/logos/' . $biller->logo); ?>" style="max-height:50px;" alt="" />
      </div>
      <?php endif; ?>

      <div class="row mb-3">
        <div class="col-6">
          <div class="small text-muted"><?php echo lang('biller') ?: 'Factureur'; ?></div>
          <div class="fw-semibold small"><?php echo htmlspecialchars($biller->company ?: $biller->name ?? ''); ?></div>
        </div>
        <div class="col-6 text-end">
          <div class="small text-muted"><?php echo lang('supplier') ?: 'Fournisseur'; ?></div>
          <div class="fw-semibold small"><?php echo htmlspecialchars($supplier->company ?: $supplier->name ?? ''); ?></div>
        </div>
      </div>

      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <td class="fw-semibold" style="width:40%;"><?php echo lang('date') ?: 'Date'; ?></td>
            <td><?php echo $this->sma->hrsd($payment->date ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('reference_no') ?: 'Référence'; ?></td>
            <td><?php echo htmlspecialchars($payment->reference_no ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('purchase_reference_no') ?: 'Réf. achat'; ?></td>
            <td><?php echo htmlspecialchars($payment->purchase_reference_no ?? $inv->reference_no ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('amount') ?: 'Montant'; ?></td>
            <td><strong class="text-success"><?php echo $this->sma->formatMoney($payment->amount ?? 0); ?></strong></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('paid_by') ?: 'Mode de paiement'; ?></td>
            <td><?php echo htmlspecialchars($payment->paid_by ?? ''); ?></td>
          </tr>
          <?php if (!empty($payment->note)): ?>
          <tr>
            <td class="fw-semibold"><?php echo lang('note') ?: 'Note'; ?></td>
            <td><?php echo $this->sma->decode_html($payment->note); ?></td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
