<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-arrow-go-back-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('return_no') ?: 'Retour' ?> <span class="text-primary">#<?= $inv->id ?></span></h4>
    <p class="mb-0 text-muted"><?= lang('date') ?>: <?= $this->sma->hrld($inv->date ?? '') ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('returns') ?>"><?= lang('Retours') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('return_no') ?> #<?= $inv->id ?></li>
      </ol>
    </nav>
  </div>
  <?php if (!$Supplier && !$Customer): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print();">
            <span class="icon-base ri ri-printer-line icon-20px me-1"></span><?= lang('print') ?>
        </button>
        <a href="<?= admin_url('returns/pdf/' . $inv->id) ?>" class="btn btn-outline-secondary btn-sm">
            <span class="icon-base ri ri-file-pdf-line icon-20px me-1"></span><?= lang('pdf') ?>
        </a>
        <?php if ($Owner || ($GP && $GP['returns-edit'])) { ?>
        <a href="<?= admin_url('returns/edit/' . $inv->id) ?>" class="btn btn-outline-warning btn-sm reedit">
            <span class="icon-base ri ri-edit-line icon-20px me-1"></span><?= lang('edit') ?>
        </a>
        <?php } ?>
        <?php if ($Owner || ($GP && $GP['returns-delete'])) { ?>
        <a href="<?= admin_url('returns/delete/' . $inv->id) ?>" class="btn btn-outline-danger btn-sm"
           onclick="return confirm('<?= lang('r_u_sure') ?>')">
            <span class="icon-base ri ri-delete-bin-line icon-20px me-1"></span><?= lang('delete') ?>
        </a>
        <?php } ?>
  </div>
  <?php endif; ?>
</div>

<!-- Return info: Customer / Biller / Document details -->
<div class="row g-4 mb-4">
    <!-- Customer -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <span class="icon-base ri ri-user-line icon-20px"></span>
                        </span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $customer->company ? $customer->company : $customer->name ?></h6>
                        <?php if ($customer->company) { ?>
                        <p class="mb-1 text-muted small"><?= $customer->name ?></p>
                        <?php } ?>
                        <p class="mb-1 small"><?= $customer->address ?></p>
                        <p class="mb-1 small"><?= $customer->city ?> <?= $customer->postal_code ?> <?= $customer->state ?></p>
                        <p class="mb-1 small"><?= $customer->country ?></p>
                        <?php if ($customer->phone) { ?><p class="mb-1 small"><span class="icon-base ri ri-phone-line icon-20px me-1"></span><?= $customer->phone ?></p><?php } ?>
                        <?php if ($customer->email) { ?><p class="mb-0 small"><span class="icon-base ri ri-mail-line icon-20px me-1"></span><?= $customer->email ?></p><?php } ?>
                        <?php if ($customer->vat_no && $customer->vat_no != '-') { ?><p class="mb-0 small text-muted"><?= lang('vat_no') ?>: <?= $customer->vat_no ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Biller -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <span class="icon-base ri ri-building-line icon-20px"></span>
                        </span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name ?></h6>
                        <?php if ($biller->company && $biller->company != '-') { ?>
                        <p class="mb-1 text-muted small"><?= $biller->name ?></p>
                        <?php } ?>
                        <p class="mb-1 small"><?= $biller->address ?></p>
                        <p class="mb-1 small"><?= $biller->city ?> <?= $biller->postal_code ?> <?= $biller->state ?></p>
                        <p class="mb-1 small"><?= $biller->country ?></p>
                        <?php if ($biller->phone) { ?><p class="mb-1 small"><span class="icon-base ri ri-phone-line icon-20px me-1"></span><?= $biller->phone ?></p><?php } ?>
                        <?php if ($biller->email) { ?><p class="mb-0 small"><span class="icon-base ri ri-mail-line icon-20px me-1"></span><?= $biller->email ?></p><?php } ?>
                        <?php if ($biller->vat_no && $biller->vat_no != '-') { ?><p class="mb-0 small text-muted"><?= lang('vat_no') ?>: <?= $biller->vat_no ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Return info -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <span class="icon-base ri ri-file-text-line icon-20px"></span>
                        </span>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bold mb-2"><?= lang('ref') ?>: <?= $inv->reference_no ?></h6>
                        <p class="mb-1 small"><strong><?= lang('date') ?>:</strong> <?= $this->sma->hrld($inv->date) ?></p>
                        <p class="mb-1 small"><strong><?= lang('type') ?>:</strong> <?= lang('return_sale') ?></p>
                        <?php if (isset($inv->status) && $inv->status) { ?>
                        <p class="mb-1 small">
                            <strong><?= lang('status') ?>:</strong>
                            <?php
                            $statusMap = [
                                'received'  => 'bg-label-success',
                                'pending'   => 'bg-label-warning',
                                'partial'   => 'bg-label-info',
                                'cancelled' => 'bg-label-danger',
                                'completed' => 'bg-label-success',
                                'sent'      => 'bg-label-info',
                            ];
                            $sc = $statusMap[$inv->status] ?? 'bg-label-secondary';
                            ?>
                            <span class="badge <?= $sc ?>"><?= lang($inv->status) ?></span>
                        </p>
                        <?php } ?>
                        <p class="mb-1 small"><strong><?= lang('warehouse') ?>:</strong> <?= isset($warehouse) ? $warehouse->name : '' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Barcode / QR -->
<div class="card mb-4 no-print">
    <div class="card-body d-flex align-items-center gap-4 flex-wrap">
        <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1') ?>"
             alt="<?= $inv->reference_no ?>" class="bcimg" />
        <?php
        $qrtext = $this->inv_qrcode->base64([
            'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
            'vat_no'           => $biller->vat_no ?: $biller->get_no,
            'date'             => $inv->date,
            'grand_total'      => 0 - $inv->grand_total,
            'total_tax_amount' => 0 - $inv->total_tax,
        ]);
        echo $this->sma->qrcode('text', $qrtext, 2);
        ?>
    </div>
</div>

<!-- Returned items table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-bag-line icon-20px me-2"></span><?= lang('order_items') ?>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th><?= lang('description') ?></th>
                    <?php if ($Settings->indian_gst) { ?><th><?= lang('hsn_code') ?></th><?php } ?>
                    <th><?= lang('quantity') ?></th>
                    <th class="text-end"><?= lang('unit_price') ?></th>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?><th class="text-end"><?= lang('tax') ?></th><?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?><th class="text-end"><?= lang('discount') ?></th><?php } ?>
                    <th class="text-end"><?= lang('subtotal') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $r = 1; foreach ($rows as $row) { ?>
                <tr>
                    <td class="text-center align-middle"><?= $r ?></td>
                    <td class="align-middle">
                        <strong><?= $row->product_code ?></strong> — <?= $row->product_name ?><?= $row->variant ? ' <span class="badge bg-label-secondary">' . $row->variant . '</span>' : '' ?>
                        <?= $row->second_name ? '<br><small class="text-muted">' . $row->second_name . '</small>' : '' ?>
                        <?= $row->details ? '<br><small>' . $row->details . '</small>' : '' ?>
                        <?= $row->serial_no ? '<br><small><?= lang("serial_no") ?>: ' . $row->serial_no . '</small>' : '' ?>
                    </td>
                    <?php if ($Settings->indian_gst) { ?><td class="text-center align-middle"><?= $row->hsn_code ?></td><?php } ?>
                    <td class="text-center align-middle"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code ?></td>
                    <td class="text-end align-middle"><?= $this->sma->formatMoney($row->unit_price) ?></td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end align-middle">
                        <?= $row->item_tax != 0 ? '<small class="text-muted">(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_tax) ?>
                    </td>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <td class="text-end align-middle">
                        <?= $row->discount != 0 ? '<small class="text-muted">(' . $row->discount . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_discount) ?>
                    </td>
                    <?php } ?>
                    <td class="text-end align-middle fw-bold"><?= $this->sma->formatMoney($row->subtotal) ?></td>
                </tr>
                <?php $r++; } ?>
                </tbody>
                <tfoot>
                <?php
                $col = $Settings->indian_gst ? 5 : 4;
                if ($Settings->product_discount && $inv->product_discount != 0) $col++;
                if ($Settings->tax1 && $inv->product_tax > 0) $col++;
                $tcol = $col;
                if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) { $tcol = $col - 2; }
                elseif ($Settings->product_discount && $inv->product_discount != 0) { $tcol = $col - 1; }
                elseif ($Settings->tax1 && $inv->product_tax > 0) { $tcol = $col - 1; }
                ?>
                <?php if ($inv->grand_total != $inv->total) { ?>
                <tr class="table-light">
                    <td colspan="<?= $tcol ?>" class="text-end"><?= lang('total') ?> (<?= $default_currency->code ?>)</td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->product_tax) ?></td>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->product_discount) ?></td>
                    <?php } ?>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->total + $inv->product_tax) ?></td>
                </tr>
                <?php } ?>
                <?php if ($inv->surcharge != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('return_surcharge') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->surcharge) ?></td>
                </tr>
                <?php } ?>
                <?php if ($inv->shipping != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('shipping') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->shipping) ?></td>
                </tr>
                <?php } ?>
                <?php if ($inv->order_discount != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_discount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= ($inv->order_discount_id ? '<small class="text-muted">(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($inv->order_discount) ?></td>
                </tr>
                <?php } ?>
                <?php if ($Settings->tax2 && $inv->order_tax != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_tax') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->order_tax) ?></td>
                </tr>
                <?php } ?>
                <tr class="table-primary">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('total_amount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($inv->grand_total) ?></td>
                </tr>
                <tr class="table-success">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('paid') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($inv->paid) ?></td>
                </tr>
                <tr class="table-warning">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('balance') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($inv->paid) ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, null, $inv->product_tax) : '' ?>

<!-- Notes + meta -->
<div class="row g-4 mb-4">
    <div class="col-md-7">
        <?php if ($inv->note && $inv->note != '') { ?>
        <div class="card mb-3">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><span class="icon-base ri ri-sticky-note-line icon-20px me-1"></span><?= lang('note') ?></h6>
                <div class="text-muted"><?= $this->sma->decode_html($inv->note) ?></div>
            </div>
        </div>
        <?php } ?>
        <?php if ($inv->staff_note && $inv->staff_note != '') { ?>
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><span class="icon-base ri ri-file-text-line icon-20px me-1"></span><?= lang('staff_note') ?></h6>
                <div class="text-muted"><?= $this->sma->decode_html($inv->staff_note) ?></div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><span class="icon-base ri ri-user-settings-line icon-20px me-1"></span><?= lang('created_by') ?></h6>
                <dl class="row mb-0 small">
                    <dt class="col-sm-5"><?= lang('created_by') ?></dt>
                    <dd class="col-sm-7"><?= $created_by->first_name . ' ' . $created_by->last_name ?></dd>
                    <dt class="col-sm-5"><?= lang('date') ?></dt>
                    <dd class="col-sm-7"><?= $this->sma->hrld($inv->date) ?></dd>
                    <?php if ($inv->updated_by) { ?>
                    <dt class="col-sm-5"><?= lang('updated_by') ?></dt>
                    <dd class="col-sm-7"><?= $updated_by->first_name . ' ' . $updated_by->last_name ?></dd>
                    <dt class="col-sm-5"><?= lang('update_at') ?></dt>
                    <dd class="col-sm-7"><?= $this->sma->hrld($inv->updated_at) ?></dd>
                    <?php } ?>
                </dl>
            </div>
        </div>
    </div>
</div>

<?php include(dirname(__FILE__) . '/../partials/attachments.php'); ?>
