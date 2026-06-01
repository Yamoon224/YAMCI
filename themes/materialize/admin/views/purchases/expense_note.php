<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none!important; } }</style>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-receipt-line me-2 text-primary icon-18px"></span>
        <?php echo lang('expense_note') ?: 'Reçu de dépense'; ?>
      </h5>
      <div class="d-flex gap-2 no-print">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <?php if (!empty($Settings->logo)): ?>
      <div class="text-center mb-3">
        <img src="<?php echo base_url('assets/uploads/logos/' . $Settings->logo); ?>" style="max-height:50px;" alt="" />
      </div>
      <?php endif; ?>

      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <td class="fw-semibold" style="width:40%;"><?php echo lang('date') ?: 'Date'; ?></td>
            <td><?php echo $this->sma->hrsd($expense->date ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('reference_no') ?: 'Référence'; ?></td>
            <td><?php echo htmlspecialchars($expense->reference_no ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('category') ?: 'Catégorie'; ?></td>
            <td><?php echo htmlspecialchars($expense->expense_category ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></td>
            <td><?php echo htmlspecialchars($expense->warehouse_name ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('amount') ?: 'Montant'; ?></td>
            <td><strong class="text-danger"><?php echo $this->sma->formatMoney($expense->amount ?? 0); ?></strong></td>
          </tr>
          <?php if (!empty($expense->note)): ?>
          <tr>
            <td class="fw-semibold"><?php echo lang('note') ?: 'Note'; ?></td>
            <td><?php echo $this->sma->decode_html($expense->note); ?></td>
          </tr>
          <?php endif; ?>
          <tr>
            <td class="fw-semibold"><?php echo lang('created_by') ?: 'Créé par'; ?></td>
            <td><?php echo htmlspecialchars($expense->created_by ?? ''); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
