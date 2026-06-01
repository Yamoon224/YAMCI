<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
        <i class="ri ri-money-dollar-circle-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
        <?php echo lang('profit_loss') ?: 'Rapport Profits & Pertes'; ?>
      </h4>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><span class="icon-base ri ri-home-line icon-20px"></span></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('profit_loss') ?: 'Profits & Pertes'; ?></li>
      </ol>
    </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <button class="btn btn-outline-secondary btn-sm" id="toggleFilterBtn" type="button">
        <span class="icon-base ri ri-filter-3-line me-1 icon-16px"></span>
        <?php echo lang('show_form') ?: 'Filtres'; ?>
      </button>
    </div>
</div>

<!-- Filter Card -->
<div class="card mb-4" id="filterCard">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-filter-3-line me-2 text-primary icon-18px"></span>
      <?php echo lang('customize_report') ?: 'Personnaliser le rapport'; ?>
    </h5>
    <button type="button" class="btn-close" id="closeFilterBtn" aria-label="Close"></button>
  </div>
  <div class="card-body">
    <?php echo admin_form_open('reports/profit_loss', ['id' => 'reportForm', 'autocomplete' => 'off']); ?>
    <div class="row g-4">
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('start_date', ($start ? $this->sma->hrsd($start) : ''), 'class="form-control flatpickr-date" id="start_date" placeholder="Date début"'); ?>
          <label for="start_date"><?php echo lang('start_date') ?: 'Date début'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('end_date', ($end ? $this->sma->hrsd($end) : ''), 'class="form-control flatpickr-date" id="end_date" placeholder="Date fin"'); ?>
          <label for="end_date"><?php echo lang('end_date') ?: 'Date fin'; ?></label>
        </div>
      </div>
      <div class="col-sm-6 col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $wh = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
          foreach ($warehouses as $whr) {
              $wh[$whr->id] = $whr->name;
          }
          echo form_dropdown('warehouse', $wh, $this->input->post('warehouse') ?: '',
            'class="form-select select2" id="warehouse" data-placeholder="' . lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt') . '"');
          ?>
          <label for="warehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
        </div>
      </div>
    </div>
    <div class="mt-4 d-flex gap-3">
      <?php echo form_submit('submit_report', lang('submit') ?: 'Appliquer', 'class="btn btn-primary"'); ?>
      <a href="<?php echo admin_url('reports/profit_loss'); ?>" class="btn btn-outline-secondary"><?php echo lang('reset') ?: 'Réinitialiser'; ?></a>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Summary KPI Cards -->
<div class="row g-4 mb-4">

  <!-- Achats -->
  <div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-warning">
              <span class="icon-base ri ri-shopping-bag-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('purchases') ?: 'Achats'; ?></h6>
            <small class="text-muted"><?php echo $total_purchases->total . ' ' . (lang('purchases') ?: 'achats'); ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1"><?php echo $this->sma->formatMoney($total_purchases->total_amount); ?></h4>
        <small class="text-muted"><?php echo lang('paid') ?: 'Payé'; ?> : <?php echo $this->sma->formatMoney($total_purchases->paid); ?></small>
      </div>
    </div>
  </div>

  <!-- Ventes -->
  <div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-success">
              <span class="icon-base ri ri-shopping-cart-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Total Ventes réalisées') ?: 'Ventes'; ?></h6>
            <small class="text-muted"><?php echo $total_sales->total . ' ' . (lang('Ventes réalisées') ?: 'ventes'); ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1"><?php echo $this->sma->formatMoney($total_sales->total_amount); ?></h4>
        <small class="text-muted"><?php echo lang('F CFA') ?: 'F CFA'; ?></small>
      </div>
    </div>
  </div>

  <!-- Retours -->
  <div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-danger">
              <span class="icon-base ri ri-arrow-go-back-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Retournés ou Annulés') ?: 'Retours / Annulés'; ?></h6>
            <small class="text-muted"><?php echo $total_return_sales->total . ' ' . (lang('Retournés avec 50% remboursés') ?: 'retours (50%)'); ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1 text-danger"><?php echo $this->sma->formatMoney($total_return_sales->total_amount / 2); ?></h4>
        <small class="text-muted"><?php echo lang('F CFA') ?: 'F CFA'; ?></small>
      </div>
    </div>
  </div>

  <!-- Paiements reçus -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-success">
              <span class="icon-base ri ri-hand-coin-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Paiement reçu') ?: 'Paiements reçus'; ?></h6>
            <small class="text-muted"><?php echo $total_received->total . ' ' . (lang('Reçus') ?: 'reçus'); ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1 text-success"><?php echo $this->sma->formatMoney($total_received->total_amount); ?></h4>
      </div>
    </div>
  </div>

  <!-- Crédits -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-warning">
              <span class="icon-base ri ri-calculator-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Total des Credits') ?: 'Crédits restants'; ?></h6>
            <small class="text-muted"><?php echo lang('Crédit Restant à payer') ?: 'À payer'; ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1 text-warning"><?php echo $this->sma->formatMoney($total_sales->total_amount - $total_received->total_amount); ?></h4>
      </div>
    </div>
  </div>

  <!-- Dépenses -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-info">
              <span class="icon-base ri ri-bank-card-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Dépenses effectuées') ?: 'Dépenses'; ?></h6>
            <small class="text-muted"><?php echo $total_expenses->total . ' ' . (lang('expenses') ?: 'dépenses'); ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1 text-info"><?php echo $this->sma->formatMoney($total_expenses->total_amount); ?></h4>
      </div>
    </div>
  </div>

  <!-- TVA -->
  <div class="col-xl-3 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-secondary">
              <span class="icon-base ri ri-government-line icon-20px"></span>
            </span>
          </div>
          <div>
            <h6 class="card-title mb-0"><?php echo lang('Total TVA collectée') ?: 'TVA collectée'; ?></h6>
            <small class="text-muted"><?php echo lang('TVA collectée sur ventes') ?: 'TVA sur ventes'; ?></small>
          </div>
        </div>
        <h4 class="fw-bold mb-1"><?php echo $this->sma->formatMoney($total_sales->tax); ?></h4>
      </div>
    </div>
  </div>

</div>

<!-- Profit / Perte rows -->
<div class="row g-4 mb-4">

  <!-- Bénéfice HT -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-danger">
              <span class="icon-base ri ri-flashlight-line icon-20px"></span>
            </span>
          </div>
          <h6 class="card-title mb-0"><?php echo lang('Bénéfice/Perte HT (Ventes - Achats)') ?: 'Bénéfice / Perte HT'; ?></h6>
        </div>
        <h3 class="fw-bold mb-1"><?php echo $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount); ?></h3>
        <small class="text-muted">
          <?php echo $this->sma->formatMoney($total_sales->total_amount); ?> <?php echo lang('sales') ?: 'Ventes'; ?>
          &minus; <?php echo $this->sma->formatMoney($total_purchases->total_amount); ?> <?php echo lang('purchases') ?: 'Achats'; ?>
        </small>
      </div>
    </div>
  </div>

  <!-- Bénéfice TTC -->
  <div class="col-md-6">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="avatar flex-shrink-0">
            <span class="avatar-initial rounded bg-label-primary">
              <span class="icon-base ri ri-bar-chart-grouped-line icon-20px"></span>
            </span>
          </div>
          <h6 class="card-title mb-0"><?php echo lang('Bénéfice/Perte TTC (Ventes - Achats)') ?: 'Bénéfice / Perte TTC'; ?></h6>
        </div>
        <h3 class="fw-bold mb-1"><?php echo $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount - $total_sales->tax); ?></h3>
        <small class="text-muted">
          <?php echo $this->sma->formatMoney($total_sales->total_amount); ?> <?php echo lang('sales') ?: 'Ventes'; ?>
          &minus; <?php echo $this->sma->formatMoney($total_sales->tax); ?> <?php echo lang('TVA') ?: 'TVA'; ?>
          &minus; <?php echo $this->sma->formatMoney($total_purchases->total_amount); ?> <?php echo lang('purchases') ?: 'Achats'; ?>
        </small>
      </div>
    </div>
  </div>

</div>

<!-- Bénéfice Net -->
<div class="card mb-4 border-0 shadow-sm">
  <div class="card-body p-4">
    <div class="d-flex align-items-center gap-3 mb-3">
      <div class="avatar avatar-lg flex-shrink-0">
        <span class="avatar-initial rounded bg-label-success">
          <span class="icon-base ri ri-emotion-happy-line icon-20px"></span>
        </span>
      </div>
      <div>
        <h5 class="card-title mb-0"><?php echo lang('Bénéfice Net') ?: 'Bénéfice Net'; ?></h5>
        <small class="text-muted"><?php echo lang('net_profit_desc') ?: 'Paiements reçus − Achats − Dépenses − TVA − Retours'; ?></small>
      </div>
    </div>
    <?php
    $net = $total_received->total_amount
         - $total_paid->total_amount
         - $total_expenses->total_amount
         - $total_sales->tax
         - ($total_return_sales->total_amount / 2);
    ?>
    <h2 class="fw-bold mb-2 <?php echo $net >= 0 ? 'text-success' : 'text-danger'; ?>">
      <?php echo $this->sma->formatMoney($net); ?>
    </h2>
    <p class="text-muted small mb-0">
      <?php echo $this->sma->formatMoney($total_received->total_amount); ?> <?php echo lang('Paiement reçu') ?: 'Paiements reçus'; ?>
      &minus; <?php echo $this->sma->formatMoney($total_paid->total_amount); ?> <?php echo lang('Achats effectués') ?: 'Achats'; ?>
      &minus; <?php echo $this->sma->formatMoney($total_expenses->total_amount); ?> <?php echo lang('Dépenses') ?: 'Dépenses'; ?>
      &minus; <?php echo $this->sma->formatMoney($total_sales->tax); ?> <?php echo lang('Taxe sur ventes') ?: 'TVA'; ?>
      &minus; <?php echo $this->sma->formatMoney($total_return_sales->total_amount / 2); ?> <?php echo lang('Retourné ou Annulé') ?: 'Retours'; ?>
    </p>
  </div>
</div>

<!-- Per-warehouse breakdown -->
<?php if (!empty($warehouses_report)): ?>
<div class="row g-4 mb-4">
  <div class="col-12">
    <h6 class="text-muted text-uppercase mb-3" style="letter-spacing:.05rem; font-size:.75rem;">
      <span class="icon-base ri ri-building-line icon-20px me-1"></span>
      <?php echo lang('warehouses') ?: 'Détail par filiale'; ?>
    </h6>
  </div>
  <?php foreach ($warehouses_report as $wr): ?>
  <?php
    $wnet = ($wr['total_sales']->paid)
          - ($wr['total_expenses']->total_amount)
          - ($wr['total_sales']->tax)
          - ($wr['total_returns']->total_amount / 2);
    $reliquat = $wr['total_sales']->total_amount - $wr['total_sales']->paid;
  ?>
  <div class="col-xl-4 col-md-6">
    <div class="card h-100 border-0 shadow-sm">
      <div class="card-header d-flex align-items-center gap-2 pb-2">
        <span class="avatar-initial rounded bg-label-primary" style="width:32px;height:32px;display:inline-flex;align-items:center;justify-content:center;">
          <span class="icon-base ri ri-building-4-line icon-16px"></span>
        </span>
        <div>
          <h6 class="mb-0 fw-semibold"><?php echo htmlspecialchars($wr['warehouse']->name); ?></h6>
          <small class="text-muted"><?php echo htmlspecialchars($wr['warehouse']->code); ?></small>
        </div>
      </div>
      <div class="card-body">
        <table class="table table-sm table-borderless mb-0">
          <tbody>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('Ventes réalisées') ?: 'Ventes'; ?></td>
              <td class="text-end fw-medium"><?php echo $this->sma->formatMoney($wr['total_sales']->total_amount); ?></td>
            </tr>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('Paiement(s) Perçu(s)') ?: 'Perçus'; ?></td>
              <td class="text-end text-success fw-medium"><?php echo $this->sma->formatMoney($wr['total_sales']->paid); ?></td>
            </tr>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('Crédit à payer') ?: 'Crédit restant'; ?></td>
              <td class="text-end text-warning fw-medium"><?php echo $this->sma->formatMoney($reliquat); ?></td>
            </tr>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('Total Dépenses effectuées') ?: 'Dépenses'; ?></td>
              <td class="text-end text-info fw-medium"><?php echo $this->sma->formatMoney($wr['total_expenses']->total_amount); ?></td>
            </tr>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('Retourné ou Annulé') ?: 'Retours (50%)'; ?></td>
              <td class="text-end text-danger fw-medium"><?php echo $this->sma->formatMoney($wr['total_returns']->total_amount / 2); ?></td>
            </tr>
            <tr>
              <td class="text-muted ps-0"><?php echo lang('TVA collectée sur ventes') ?: 'TVA'; ?></td>
              <td class="text-end fw-medium"><?php echo $this->sma->formatMoney($wr['total_sales']->tax); ?></td>
            </tr>
            <tr class="border-top">
              <td class="ps-0 fw-bold"><?php echo lang('Résultat Net Filiale') ?: 'Résultat Net'; ?></td>
              <td class="text-end fw-bold <?php echo $wnet >= 0 ? 'text-success' : 'text-danger'; ?>">
                <?php echo $this->sma->formatMoney($wnet); ?>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var filterCard = document.getElementById('filterCard');
  document.getElementById('toggleFilterBtn').addEventListener('click', function () {
    filterCard.style.display = filterCard.style.display === 'none' ? '' : 'none';
  });
  document.getElementById('closeFilterBtn').addEventListener('click', function () {
    filterCard.style.display = 'none';
  });
  <?php if (!$start && !$this->input->post('submit_report')): ?>
  filterCard.style.display = 'none';
  <?php endif; ?>
})();
</script>
