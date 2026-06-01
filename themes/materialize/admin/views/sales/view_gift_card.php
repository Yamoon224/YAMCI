<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-gift-2-line me-2 text-primary icon-18px"></span>
        <?php echo lang('gift_card') ?: 'Carte cadeau'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <div class="text-center mb-4">
        <?php if (!empty($Settings->logo)): ?>
          <img src="<?php echo base_url('assets/uploads/logos/' . $Settings->logo); ?>" alt="" style="max-height:50px;" />
        <?php endif; ?>
      </div>
      <table class="table table-bordered mb-0">
        <tbody>
          <tr>
            <td class="fw-semibold" style="width:40%;"><?php echo lang('card_no') ?: 'N° carte'; ?></td>
            <td><strong><?php echo htmlspecialchars($card->card_no ?? ''); ?></strong></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('customer') ?: 'Client'; ?></td>
            <td><?php echo htmlspecialchars($card->customer ?? ''); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('balance') ?: 'Solde'; ?></td>
            <td><strong class="text-success"><?php echo $this->sma->formatMoney($card->balance ?? 0); ?></strong></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('value') ?: 'Valeur initiale'; ?></td>
            <td><?php echo $this->sma->formatMoney($card->value ?? 0); ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('expiry_date') ?: 'Expiration'; ?></td>
            <td><?php echo !empty($card->expiry) ? $this->sma->hrsd($card->expiry) : '—'; ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('issue_date') ?: 'Date d\'émission'; ?></td>
            <td><?php echo !empty($card->date) ? $this->sma->hrsd($card->date) : '—'; ?></td>
          </tr>
          <tr>
            <td class="fw-semibold"><?php echo lang('status') ?: 'Statut'; ?></td>
            <td>
              <?php
              $expired = !empty($card->expiry) && strtotime($card->expiry) < time();
              $empty   = ($card->balance ?? 0) <= 0;
              if ($expired): ?>
                <span class="badge bg-label-danger"><?php echo lang('expired') ?: 'Expirée'; ?></span>
              <?php elseif ($empty): ?>
                <span class="badge bg-label-warning"><?php echo lang('empty') ?: 'Vide'; ?></span>
              <?php else: ?>
                <span class="badge bg-label-success"><?php echo lang('active') ?: 'Active'; ?></span>
              <?php endif; ?>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
      <?php if ($Owner || $Admin): ?>
        <a href="<?php echo admin_url('sales/topup_gift_card/' . $card->id); ?>" class="btn btn-primary sa-modal">
          <span class="icon-base ri ri-add-circle-line me-1 icon-14px"></span>
          <?php echo lang('topup') ?: 'Recharger'; ?>
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php echo $modal_js; ?>
