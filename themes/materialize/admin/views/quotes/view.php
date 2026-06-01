<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('quote_no') ?: 'Devis' ?> <span class="text-primary">#<?= htmlspecialchars($inv->reference_no) ?></span></h4>
    <p class="mb-0 text-muted">
      <?= lang('date') ?>: <?= $this->sma->hrld($inv->date) ?>
      <?php if (!empty($inv->customer)): ?>
      <span class="mx-2">·</span><?= lang('customer') ?>: <span class="fw-semibold"><?= htmlspecialchars($inv->customer) ?></span>
      <?php endif; ?>
    </p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('quotes') ?>"><?= lang('quotes') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $inv->reference_no ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
        <button type="button" class="btn btn-outline-secondary" onclick="window.print();">
            <span class="icon-base ri ri-printer-line icon-20px me-1"></span><?= lang('print') ?>
        </button>
        <?php if (!$Supplier && !$Customer) { ?>
        <a href="<?= admin_url('quotes/edit/' . $inv->id) ?>" class="btn btn-warning">
            <span class="icon-base ri ri-edit-line icon-20px me-1"></span><?= lang('edit_quote') ?>
        </a>
        <a href="<?= admin_url('sales/add/' . $inv->id) ?>" class="btn btn-success">
            <span class="icon-base ri ri-shopping-cart-line icon-20px me-1"></span><?= lang('create_invoice') ?>
        </a>
        <a href="<?= admin_url('quotes/pdf/' . $inv->id) ?>" class="btn btn-outline-danger">
            <span class="icon-base ri ri-file-pdf-line icon-20px me-1"></span><?= lang('pdf') ?>
        </a>
        <div class="dropdown">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <span class="icon-base ri ri-more-2-line icon-20px"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="<?= admin_url('quotes/email/' . $inv->id) ?>"
                       data-bs-toggle="modal" data-bs-target="#myModal">
                        <span class="icon-base ri ri-mail-send-line icon-20px me-2"></span><?= lang('send_email') ?>
                    </a>
                </li>
                <?php if ($inv->attachment) { ?>
                <li>
                    <a class="dropdown-item" href="<?= admin_url('welcome/download/' . $inv->attachment) ?>">
                        <span class="icon-base ri ri-attachment-2 icon-20px me-2"></span><?= lang('attachment') ?>
                    </a>
                </li>
                <?php } ?>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="#"
                       onclick="if(confirm('<?= lang('r_u_sure') ?>')) window.location='<?= admin_url('quotes/delete/' . $inv->id) ?>'; return false;">
                        <span class="icon-base ri ri-delete-bin-line icon-20px me-2"></span><?= lang('delete_quote') ?>
                    </a>
                </li>
            </ul>
        </div>
        <?php } ?>
        <a href="<?= admin_url('quotes') ?>" class="btn btn-outline-secondary">
            <span class="icon-base ri ri-arrow-left-line icon-20px me-1"></span><?= lang('back') ?>
        </a>
    </div>
</div>

<!-- Quote document card -->
<div class="card mb-4">
    <div class="card-body">

        <!-- Print logo -->
        <div class="print-only mb-4">
            <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo ?>"
                 alt="<?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name ?>"
                 style="max-height:80px;" />
        </div>

        <!-- Biller / Customer / Warehouse row -->
        <div class="row mb-4">
            <div class="col-md-4 border-end">
                <div class="d-flex align-items-start gap-3">
                    <span class="icon-base ri ri-user-line icon-40px text-muted"></span>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $customer->company && $customer->company != '-' ? $customer->company : $customer->name ?></h6>
                        <?php if ($customer->company && $customer->company != '-') { echo '<small>Attn: ' . $customer->name . '</small><br>'; } ?>
                        <small><?= $customer->address ?><br><?= $customer->city . ' ' . $customer->postal_code . ' ' . $customer->state ?><br><?= $customer->country ?></small>
                        <?php if ($customer->vat_no && $customer->vat_no != '-') { echo '<br><small>' . lang('vat_no') . ': ' . $customer->vat_no . '</small>'; } ?>
                        <br><small><?= lang('tel') ?>: <?= $customer->phone ?> | <?= lang('email') ?>: <?= $customer->email ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 border-end">
                <div class="d-flex align-items-start gap-3">
                    <span class="icon-base ri ri-building-line icon-40px text-muted"></span>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name ?></h6>
                        <?php if ($biller->company) { echo '<small>Attn: ' . $biller->name . '</small><br>'; } ?>
                        <small><?= $biller->address ?><br><?= $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state ?><br><?= $biller->country ?></small>
                        <?php if ($biller->vat_no && $biller->vat_no != '-') { echo '<br><small>' . lang('vat_no') . ': ' . $biller->vat_no . '</small>'; } ?>
                        <br><small><?= lang('tel') ?>: <?= $biller->phone ?> | <?= lang('email') ?>: <?= $biller->email ?></small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="icon-base ri ri-store-line icon-40px text-muted"></span>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $Settings->site_name ?></h6>
                        <small><?= $warehouse->name ?></small><br>
                        <small><?= $warehouse->address ?></small><br>
                        <?php if ($warehouse->phone) { echo '<small>' . lang('tel') . ': ' . $warehouse->phone . '</small><br>'; } ?>
                        <?php if ($warehouse->email) { echo '<small>' . lang('email') . ': ' . $warehouse->email . '</small>'; } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reference / date / barcode row -->
        <div class="row mb-4 align-items-center">
            <div class="col-md-4">
                <div class="d-flex align-items-start gap-3">
                    <span class="icon-base ri ri-file-text-line icon-40px text-muted"></span>
                    <div>
                        <h5 class="fw-bold mb-1"><?= lang('ref') ?>: <?= $inv->reference_no ?></h5>
                        <p class="mb-1"><strong><?= lang('date') ?>:</strong> <?= $this->sma->hrld($inv->date) ?></p>
                        <p class="mb-0">
                            <strong><?= lang('status') ?>:</strong>
                            <span class="badge bg-label-<?= ($inv->status == 'completed') ? 'success' : (($inv->status == 'sent') ? 'info' : 'warning') ?>">
                                <?= lang($inv->status) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 text-end order_barcodes">
                <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1') ?>"
                     alt="<?= $inv->reference_no ?>" class="bcimg me-3" />
                <?= $this->sma->qrcode('link', urlencode(admin_url('quotes/view/' . $inv->id)), 2) ?>
            </div>
        </div>

        <!-- Items table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered table-hover table-striped print-table order-table">
                <thead class="table-light">
                <tr>
                    <th style="width:40px;"><?= lang('no.') ?></th>
                    <th><?= lang('description') ?></th>
                    <?php if ($Settings->indian_gst) { ?><th><?= lang('hsn_sac_code') ?></th><?php } ?>
                    <th><?= lang('quantity') ?></th>
                    <th class="text-end"><?= lang('unit_price') ?></th>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <th class="text-end"><?= lang('tax') ?></th>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <th class="text-end"><?= lang('discount') ?></th>
                    <?php } ?>
                    <th class="text-end"><?= lang('subtotal') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $r = 1; foreach ($rows as $row): ?>
                <tr>
                    <td class="text-center"><?= $r ?></td>
                    <td>
                        <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '') ?>
                        <?= $row->second_name ? '<br><small class="text-muted">' . $row->second_name . '</small>' : '' ?>
                        <?= $row->details ? '<br><small>' . $row->details . '</small>' : '' ?>
                    </td>
                    <?php if ($Settings->indian_gst) { ?><td class="text-center"><?= $row->hsn_code ?: '' ?></td><?php } ?>
                    <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($row->unit_price) ?></td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end">
                        <?= $row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_tax) ?>
                    </td>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <td class="text-end">
                        <?= $row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_discount) ?>
                    </td>
                    <?php } ?>
                    <td class="text-end"><?= $this->sma->formatMoney($row->subtotal) ?></td>
                </tr>
                <?php $r++; endforeach; ?>
                </tbody>
                <tfoot>
                <?php
                $col = $Settings->indian_gst ? 5 : 4;
                if ($Settings->product_discount && $inv->product_discount != 0) { $col++; }
                if ($Settings->tax1 && $inv->product_tax > 0) { $col++; }
                ?>
                <tr>
                    <td colspan="<?= ($Settings->tax1 && $inv->product_tax > 0 && $Settings->product_discount && $inv->product_discount != 0) ? $col - 2 : (($Settings->tax1 && $inv->product_tax > 0) || ($Settings->product_discount && $inv->product_discount != 0) ? $col - 1 : $col) ?>"
                        class="text-end fw-semibold"><?= lang('total') ?> (<?= $default_currency->code ?>)</td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->product_tax) ?></td>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->product_discount) ?></td>
                    <?php } ?>
                    <td class="text-end fw-semibold"><?= $this->sma->formatMoney($inv->total + $inv->product_tax) ?></td>
                </tr>
                <?php if ($inv->order_discount != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_discount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end text-danger">
                        <?= $inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($inv->order_discount) ?>
                    </td>
                </tr>
                <?php } ?>
                <?php if ($Settings->tax2 && $inv->order_tax != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_tax') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->order_tax) ?></td>
                </tr>
                <?php } ?>
                <?php if ($inv->shipping != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('shipping') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->shipping) ?></td>
                </tr>
                <?php } ?>
                <tr class="table-primary">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('total_amount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold fs-6"><?= $this->sma->formatMoney($inv->grand_total) ?></td>
                </tr>
                </tfoot>
            </table>
        </div>

        <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, null, $inv->product_tax) : '' ?>

        <!-- Note and audit info -->
        <div class="row">
            <div class="col-md-7">
                <?php if ($inv->note && $inv->note != '') { ?>
                <div class="card bg-light border-0">
                    <div class="card-body">
                        <p class="fw-bold mb-1"><?= lang('note') ?>:</p>
                        <div><?= $this->sma->decode_html($inv->note) ?></div>
                    </div>
                </div>
                <?php } ?>
            </div>
            <div class="col-md-4 offset-md-1">
                <div class="card bg-light border-0">
                    <div class="card-body small">
                        <p class="mb-1"><strong><?= lang('created_by') ?>:</strong> <?= $created_by->first_name . ' ' . $created_by->last_name ?></p>
                        <p class="mb-1"><strong><?= lang('date') ?>:</strong> <?= $this->sma->hrld($inv->date) ?></p>
                        <?php if ($inv->updated_by) { ?>
                        <p class="mb-1"><strong><?= lang('updated_by') ?>:</strong> <?= $updated_by->first_name . ' ' . $updated_by->last_name ?></p>
                        <p class="mb-0"><strong><?= lang('update_at') ?>:</strong> <?= $this->sma->hrld($inv->updated_at) ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
