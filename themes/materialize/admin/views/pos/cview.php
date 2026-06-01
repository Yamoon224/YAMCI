<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
  <title><?php echo $page_title ?? ($Settings->site_name . ' — Reçu'); ?> #<?php echo $inv->id ?? ''; ?></title>
  <style>
    * { font-family: "Courier New", Courier, monospace; font-size: 13px; line-height: 1.5; margin: 0; padding: 0; box-sizing: border-box; }
    body { background: #f7f9fa; display: flex; justify-content: center; padding: 20px; }
    #wrapper { width: 350px; background: #fff; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,.1); }
    #wrapper img { max-width: 200px; width: auto; display: block; margin: 0 auto 10px; }
    h3 { font-size: 15px; text-transform: uppercase; text-align: center; margin: 5px 0; }
    .center { text-align: center; }
    .left  { width: 60%; float: left; text-align: left; margin-bottom: 3px; }
    .right { width: 40%; float: right; text-align: right; margin-bottom: 3px; }
    .clearfix::after { content: ''; display: table; clear: both; }
    .line { border-top: 1px dashed #ccc; margin: 8px 0; }
    .bold { font-weight: bold; }
    table.items { width: 100%; border-collapse: collapse; margin: 8px 0; }
    table.items td { padding: 2px 4px; vertical-align: top; }
    table.items .qty  { width: 40px; text-align: center; }
    table.items .price, table.items .total { width: 70px; text-align: right; }
    .totals td { padding: 2px 4px; }
    .totals .label { text-align: right; }
    .totals .amount { width: 90px; text-align: right; font-weight: bold; }
    .footer { text-align: center; margin-top: 10px; font-size: 11px; color: #666; }
    @media print { body { background: none; padding: 0; } #wrapper { box-shadow: none; padding: 0; } .no-print { display: none !important; } }
  </style>
</head>
<body>
<div id="wrapper">
  <!-- Logo -->
  <?php if (!empty($biller->logo) && !empty($logo)): ?>
  <img src="<?php echo base_url('assets/uploads/logos/' . $biller->logo); ?>"
       alt="<?php echo htmlspecialchars($biller->company ?: $biller->name ?? ''); ?>" />
  <?php endif; ?>

  <h3><?php echo htmlspecialchars($biller->company ?: $biller->name ?? $Settings->site_name); ?></h3>
  <div class="center">
    <?php echo htmlspecialchars($biller->address ?? ''); ?>
    <?php if (!empty($biller->phone)): ?><br>Tél: <?php echo htmlspecialchars($biller->phone); ?><?php endif; ?>
    <?php if (!empty($biller->email)): ?><br><?php echo htmlspecialchars($biller->email); ?><?php endif; ?>
  </div>

  <div class="line"></div>

  <!-- Sale info -->
  <div class="clearfix">
    <div class="left"><?php echo lang('date') ?: 'Date'; ?>:</div>
    <div class="right"><?php echo $this->sma->hrld($inv->date ?? ''); ?></div>
  </div>
  <div class="clearfix">
    <div class="left"><?php echo lang('reference_no') ?: 'Réf'; ?>:</div>
    <div class="right"><?php echo htmlspecialchars($inv->reference_no ?? ''); ?></div>
  </div>
  <?php if (!empty($inv->customer)): ?>
  <div class="clearfix">
    <div class="left"><?php echo lang('customer') ?: 'Client'; ?>:</div>
    <div class="right"><?php echo htmlspecialchars($inv->customer); ?></div>
  </div>
  <?php endif; ?>

  <div class="line"></div>

  <!-- Items -->
  <table class="items">
    <thead>
      <tr>
        <td><?php echo lang('product') ?: 'Produit'; ?></td>
        <td class="qty"><?php echo lang('qty') ?: 'Qté'; ?></td>
        <td class="price"><?php echo lang('price') ?: 'PU'; ?></td>
        <td class="total"><?php echo lang('total') ?: 'Total'; ?></td>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): foreach ($rows as $row): ?>
      <tr>
        <td><?php echo htmlspecialchars($row->product_name . ($row->variant ? ' ' . $row->variant : '')); ?></td>
        <td class="qty"><?php echo $this->sma->formatQuantity($row->quantity); ?></td>
        <td class="price"><?php echo $this->sma->mf($row->unit_price ?? 0); ?></td>
        <td class="total"><?php echo $this->sma->mf(($row->unit_price ?? 0) * ($row->quantity ?? 0)); ?></td>
      </tr>
      <?php endforeach; endif; ?>
    </tbody>
  </table>

  <div class="line"></div>

  <!-- Totals -->
  <table class="totals" width="100%">
    <?php if (!empty($inv->order_discount)): ?>
    <tr>
      <td class="label"><?php echo lang('discount') ?: 'Remise'; ?>:</td>
      <td class="amount"><?php echo $this->sma->mf($inv->order_discount ?? 0); ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($inv->order_tax)): ?>
    <tr>
      <td class="label"><?php echo lang('tax') ?: 'Taxe'; ?>:</td>
      <td class="amount"><?php echo $this->sma->mf($inv->order_tax ?? 0); ?></td>
    </tr>
    <?php endif; ?>
    <?php if (!empty($inv->shipping)): ?>
    <tr>
      <td class="label"><?php echo lang('shipping') ?: 'Livraison'; ?>:</td>
      <td class="amount"><?php echo $this->sma->mf($inv->shipping ?? 0); ?></td>
    </tr>
    <?php endif; ?>
    <tr>
      <td class="label bold"><?php echo lang('grand_total') ?: 'TOTAL'; ?>:</td>
      <td class="amount bold"><?php echo $this->sma->mf($inv->grand_total ?? 0); ?></td>
    </tr>
    <?php if (!empty($inv->paid_amount)): ?>
    <tr>
      <td class="label"><?php echo lang('paid') ?: 'Payé'; ?>:</td>
      <td class="amount"><?php echo $this->sma->mf($inv->paid_amount ?? 0); ?></td>
    </tr>
    <tr>
      <td class="label"><?php echo lang('change') ?: 'Rendu'; ?>:</td>
      <td class="amount"><?php echo $this->sma->mf(($inv->paid_amount ?? 0) - ($inv->grand_total ?? 0)); ?></td>
    </tr>
    <?php endif; ?>
  </table>

  <div class="line"></div>

  <!-- QR/barcode -->
  <div class="center">
    <img src="<?php echo admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no ?? '') . '/code128/74/0/1'); ?>"
         alt="<?php echo htmlspecialchars($inv->reference_no ?? ''); ?>" style="max-width:180px;" />
  </div>

  <?php if (!empty($pos_settings->receipt_footer)): ?>
  <div class="line"></div>
  <div class="footer"><?php echo $this->sma->decode_html($pos_settings->receipt_footer); ?></div>
  <?php endif; ?>

  <div class="footer no-print" style="margin-top:15px;">
    <button onclick="window.print();" style="font-family:sans-serif; padding:8px 16px; cursor:pointer;">
      🖨 <?php echo lang('print') ?: 'Imprimer'; ?>
    </button>
  </div>
</div>
</body>
</html>
