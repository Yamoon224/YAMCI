<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
  @media print {
    .no-print { display: none !important; }
    .modal-footer { display: none !important; }
  }
</style>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header no-print">
      <h5 class="modal-title">
        <span class="icon-base ri ri-receipt-line me-2 text-primary icon-18px"></span>
        <?php echo lang('deposit_note') ?: 'Reçu de dépôt'; ?>
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
      <!-- Logo -->
      <div class="text-center mb-4">
        <?php if (!empty($Settings->logo)): ?>
          <img src="<?php echo base_url('assets/uploads/logos/' . $Settings->logo); ?>"
               alt="<?php echo htmlspecialchars($Settings->site_name); ?>" style="max-height:60px;" />
        <?php else: ?>
          <h5><?php echo htmlspecialchars($Settings->site_name); ?></h5>
        <?php endif; ?>
      </div>

      <!-- Customer info -->
      <div class="bg-light rounded p-3 mb-4">
        <h6 class="fw-semibold mb-1">
          <?php echo htmlspecialchars($customer->company ?: $customer->name); ?>
        </h6>
        <?php if ($customer->company): ?>
          <div class="text-muted small"><?php echo htmlspecialchars($customer->name); ?></div>
        <?php endif; ?>
        <div class="text-muted small">
          <?php echo htmlspecialchars(trim($customer->address . ', ' . $customer->city . ' ' . $customer->postal_code . ' ' . $customer->state . ', ' . $customer->country, ', ')); ?>
        </div>
        <?php if ($customer->phone): ?>
          <div class="text-muted small"><span class="icon-base ri ri-phone-line me-1 icon-12px"></span><?php echo htmlspecialchars($customer->phone); ?></div>
        <?php endif; ?>
      </div>

      <!-- Deposit details -->
      <table class="table table-bordered mb-4">
        <tbody>
          <tr>
            <td class="fw-semibold" style="width:40%;"><?php echo lang('date') ?: 'Date'; ?></td>
            <td><?php echo $this->sma->hrsd($deposit->date); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('reference_no') ?: 'Référence'; ?></td>
            <td><?php echo htmlspecialchars($deposit->reference_no ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('amount') ?: 'Montant'; ?></td>
            <td><strong class="text-success"><?php echo $this->sma->formatMoney($deposit->amount); ?></strong></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('paid_by') ?: 'Payé par'; ?></td>
            <td><?php echo htmlspecialchars($deposit->paid_by ?? ''); ?></td>
          </tr>
          <?php if (!empty($deposit->note)): ?>
          <tr>
            <td class="fw-semibold"><?php echo lang('note') ?: 'Note'; ?></td>
            <td><?php echo $this->sma->decode_html($deposit->note); ?></td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>

      <!-- Signature line -->
      <div class="row mt-4">
        <div class="col-sm-5">
          <div style="border-top: 1px solid #aaa; padding-top: 4px; margin-top: 40px;">
            <small class="text-muted"><?php echo lang('stamp_sign') ?: 'Signature & Cachet'; ?></small>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
