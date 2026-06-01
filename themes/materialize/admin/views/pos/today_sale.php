<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none!important; } }</style>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-store-2-line me-2 text-primary icon-18px"></span>
        <?php echo lang('today_sale') ?: 'Ventes du jour'; ?>
      </h5>
      <div class="d-flex gap-2 no-print">
        <button class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <td class="fw-semibold"><?php echo lang('cash_in_hand') ?: 'Fonds de caisse'; ?></td>
            <td class="text-end fw-semibold"><?php echo $this->sma->formatMoney($this->session->userdata('cash_in_hand') ?? 0); ?></td>
          </tr>
          <tr>
            <td><?php echo lang('cash_sale') ?: 'Ventes espèces'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($cashsales->paid ?? 0); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($cashsales->total ?? 0); ?>)</small>
            </td>
          </tr>
          <tr>
            <td><?php echo lang('ch_sale') ?: 'Ventes chèques'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($chsales->paid ?? 0); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($chsales->total ?? 0); ?>)</small>
            </td>
          </tr>
          <tr>
            <td><?php echo lang('cc_sale') ?: 'Ventes CB'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($ccsales->paid ?? 0); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($ccsales->total ?? 0); ?>)</small>
            </td>
          </tr>
          <tr>
            <td><?php echo lang('gc_sale') ?: 'Ventes carte cadeau'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($gcsales->paid ?? 0); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($gcsales->total ?? 0); ?>)</small>
            </td>
          </tr>
          <tr>
            <td><?php echo lang('other') ?: 'Autre'; ?></td>
            <td class="text-end">
              <?php echo $this->sma->formatMoney($othersales->paid ?? 0); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($othersales->total ?? 0); ?>)</small>
            </td>
          </tr>
          <?php
          $total_paid  = ($cashsales->paid ?? 0) + ($chsales->paid ?? 0) + ($ccsales->paid ?? 0) + ($gcsales->paid ?? 0) + ($othersales->paid ?? 0);
          $total_grand = ($cashsales->total ?? 0) + ($chsales->total ?? 0) + ($ccsales->total ?? 0) + ($gcsales->total ?? 0) + ($othersales->total ?? 0);
          ?>
          <tr class="table-active">
            <td class="fw-bold"><?php echo lang('total') ?: 'Total'; ?></td>
            <td class="text-end fw-bold">
              <?php echo $this->sma->formatMoney($total_paid); ?>
              <small class="text-muted">(<?php echo $this->sma->formatMoney($total_grand); ?>)</small>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
