<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none !important; } }</style>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-store-2-line me-2 text-primary icon-18px"></span>
        <?php echo lang('sales') ?: 'Ventes'; ?>
        <small class="text-muted fw-normal fs-6">
          (<?php echo $this->sma->hrld($this->session->userdata('register_open_time') ?? ''); ?>
          — <?php echo $this->sma->hrld(date('Y-m-d H:i:s')); ?>)
        </small>
      </h5>
      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <p class="text-muted small mb-3"><?php echo lang('register_total_tip') ?: 'Totaux par mode de paiement (Payé / Total).'; ?></p>

      <table class="table table-bordered mb-0">
        <tbody>
          <?php
          $rows = [
            'cash_in_hand' => $this->session->userdata('cash_in_hand'),
            'cash_sale'    => isset($cashsales)   ? ($cashsales->paid  ?? 0)  . ' / ' . ($cashsales->total  ?? 0)  : '—',
            'ch_sale'      => isset($chsales)    ? ($chsales->paid   ?? 0)   . ' / ' . ($chsales->total   ?? 0)   : '—',
            'cc_sale'      => isset($ccsales)    ? ($ccsales->paid   ?? 0)   . ' / ' . ($ccsales->total   ?? 0)   : '—',
            'gc_sale'      => isset($gcsales)    ? ($gcsales->paid   ?? 0)   . ' / ' . ($gcsales->total   ?? 0)   : '—',
            'other'        => isset($othersales) ? ($othersales->paid ?? 0)  . ' / ' . ($othersales->total ?? 0)  : '—',
          ];
          foreach ($rows as $key => $val):
          ?>
          <tr>
            <td class="fw-semibold"><?php echo lang($key) ?: $key; ?></td>
            <td class="text-end">
              <?php if (is_numeric(str_replace(' / ', '', $val ?? ''))): ?>
                <strong><?php echo $this->sma->formatMoney($val ?? 0); ?></strong>
              <?php else: ?>
                <?php echo $val; ?>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
          <?php if (!empty($pos_settings->paypal_pro) && isset($pppsales)): ?>
          <tr>
            <td class="fw-semibold"><?php echo lang('paypal_pro') ?: 'PayPal Pro'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($pppsales->paid ?? 0); ?> /
              <?php echo $this->sma->formatMoney($pppsales->total ?? 0); ?>
            </td>
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
