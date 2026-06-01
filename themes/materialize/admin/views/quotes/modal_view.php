<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
        <div class="modal-body p-4">
            <div class="d-flex justify-content-between align-items-start mb-3">
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
                        <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
                    </button>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <?php if ($logo): ?>
            <div class="text-center mb-4">
                <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                     alt="<?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?>"
                     style="max-height:80px;" />
            </div>
            <?php endif; ?>

            <!-- Header info -->
            <div class="card bg-light border-0 mb-4">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-1"><span class="fw-semibold"><?= lang('ref'); ?>:</span> <code><?= $inv->reference_no; ?></code></p>
                            <p class="mb-1"><span class="fw-semibold"><?= lang('date'); ?>:</span> <?= $this->sma->hrld($inv->date); ?></p>
                            <p class="mb-0">
                                <span class="fw-semibold"><?= lang('status'); ?>:</span>
                                <?php
                                $st = $inv->status;
                                $sbadge = ($st == 'approved') ? 'bg-label-success' : (($st == 'pending') ? 'bg-label-warning' : 'bg-label-info');
                                echo '<span class="badge ' . $sbadge . '">' . $st . '</span>';
                                ?>
                            </p>
                        </div>
                        <div class="col-md-6 text-end order_barcodes">
                            <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/60/0/1'); ?>"
                                 alt="<?= $inv->reference_no; ?>" class="bcimg" />
                            <?= $this->sma->qrcode('link', urlencode(site_url('view/quote/' . $inv->hash)), 2); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer / Biller -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted small mb-1"><?= $this->lang->line('to'); ?></p>
                    <h6 class="fw-bold mb-1"><?= $customer->company && $customer->company != '-' ? $customer->company : $customer->name; ?></h6>
                    <small class="text-muted">
                        <?= $customer->address ?>, <?= $customer->city ?> <?= $customer->postal_code ?><br>
                        <?= $customer->state ?> <?= $customer->country ?><br>
                        <?php if ($customer->vat_no && $customer->vat_no != '-') echo lang('vat_no') . ': ' . $customer->vat_no . '<br>'; ?>
                        <?= lang('tel') ?>: <?= $customer->phone ?> &bull; <?= lang('email') ?>: <?= $customer->email ?>
                    </small>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1"><?= $this->lang->line('from'); ?></p>
                    <h6 class="fw-bold mb-1"><?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?></h6>
                    <small class="text-muted">
                        <?= $biller->address ?>, <?= $biller->city ?> <?= $biller->postal_code ?><br>
                        <?= $biller->state ?> <?= $biller->country ?><br>
                        <?php if ($biller->vat_no && $biller->vat_no != '-') echo lang('vat_no') . ': ' . $biller->vat_no . '<br>'; ?>
                        <?= lang('tel') ?>: <?= $biller->phone ?> &bull; <?= lang('email') ?>: <?= $biller->email ?>
                    </small>
                </div>
            </div>

            <!-- Items table -->
            <?php
            $col = $Settings->indian_gst ? 5 : 4;
            if ($Settings->product_discount && $inv->product_discount != 0) $col++;
            if ($Settings->tax1 && $inv->product_tax > 0) $col++;
            if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                $tcol = $col - 2;
            } elseif ($Settings->product_discount && $inv->product_discount != 0) {
                $tcol = $col - 1;
            } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                $tcol = $col - 1;
            } else {
                $tcol = $col;
            }
            ?>
            <div class="table-responsive mb-3">
                <table class="table table-sm table-bordered table-hover print-table order-table">
                    <thead class="table-light">
                        <tr>
                            <th><?= lang('no.'); ?></th>
                            <th><?= lang('description'); ?></th>
                            <?php if ($Settings->indian_gst) echo '<th>' . lang('hsn_sac_code') . '</th>'; ?>
                            <th class="text-center"><?= lang('quantity'); ?></th>
                            <th class="text-end"><?= lang('unit_price'); ?></th>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<th class="text-end">' . lang('tax') . '</th>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<th class="text-end">' . lang('discount') . '</th>';
                            ?>
                            <th class="text-end"><?= lang('subtotal'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $r = 1;
                        foreach ($rows as $row): ?>
                        <tr>
                            <td class="text-center"><?= $r; ?></td>
                            <td>
                                <?= $row->product_code . ' &mdash; ' . $row->product_name . ($row->variant ? ' <span class="badge bg-label-info">' . $row->variant . '</span>' : ''); ?>
                                <?= $row->second_name ? '<br><small class="text-muted">' . $row->second_name . '</small>' : ''; ?>
                                <?= $row->details ? '<br><small>' . $row->details . '</small>' : ''; ?>
                            </td>
                            <?php if ($Settings->indian_gst) echo '<td class="text-center">' . ($row->hsn_code ?: '') . '</td>'; ?>
                            <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code; ?></td>
                            <td class="text-end"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . ($row->item_tax != 0 ? '<small class="text-muted">(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . ($row->discount != 0 ? '<small class="text-muted">(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                            ?>
                            <td class="text-end fw-semibold"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                        <?php $r++; endforeach; ?>
                    </tbody>
                    <tfoot>
                        <?php if ($inv->grand_total != $inv->total): ?>
                        <tr>
                            <td colspan="<?= $tcol; ?>" class="text-end"><?= lang('total'); ?> (<?= $default_currency->code; ?>)</td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . $this->sma->formatMoney($inv->product_tax) . '</td>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . $this->sma->formatMoney($inv->product_discount) . '</td>';
                            ?>
                            <td class="text-end"><?= $this->sma->formatMoney($inv->total + $inv->product_tax); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php
                        if ($inv->order_discount != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->order_discount) . '</td></tr>';
                        if ($Settings->tax2 && $inv->order_tax != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->order_tax) . '</td></tr>';
                        if ($inv->shipping != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('shipping') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                        ?>
                        <tr class="table-light fw-bold">
                            <td colspan="<?= $col; ?>" class="text-end"><?= lang('total_amount'); ?> (<?= $default_currency->code; ?>)</td>
                            <td class="text-end"><?= $this->sma->formatMoney($inv->grand_total); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, null, $inv->product_tax) : ''; ?>

            <?php if ($inv->note): ?>
            <div class="alert alert-light border mb-2">
                <strong><?= lang('note'); ?>:</strong> <?= $this->sma->decode_html($inv->note); ?>
            </div>
            <?php endif; ?>

            <div class="row mt-3">
                <div class="col-md-6 ms-auto">
                    <div class="card bg-light border-0">
                        <div class="card-body py-2">
                            <p class="mb-1 small">
                                <span class="fw-semibold"><?= lang('created_by'); ?>:</span>
                                <?= $created_by->first_name . ' ' . $created_by->last_name; ?>
                                &bull; <?= $this->sma->hrld($inv->date); ?>
                            </p>
                            <?php if ($inv->updated_by): ?>
                            <p class="mb-0 small">
                                <span class="fw-semibold"><?= lang('updated_by'); ?>:</span>
                                <?= $updated_by->first_name . ' ' . $updated_by->last_name; ?>
                                &bull; <?= $this->sma->hrld($inv->updated_at); ?>
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!$Supplier || !$Customer): ?>
        <div class="modal-footer justify-content-start gap-2 flex-wrap">
            <a href="<?= admin_url('sales/add/' . $inv->id) ?>" class="btn btn-sm btn-primary">
                <span class="icon-base ri ri-heart-line me-1 icon-16px"></span><?= lang('create_sale') ?>
            </a>
            <a href="<?= admin_url('purchases/add/' . $inv->id) ?>" class="btn btn-sm btn-primary">
                <span class="icon-base ri ri-star-line me-1 icon-16px"></span><?= lang('create_purchase') ?>
            </a>
            <a href="<?= admin_url('quotes/email/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-sm btn-primary">
                <span class="icon-base ri ri-mail-line me-1 icon-16px"></span><?= lang('email') ?>
            </a>
            <a href="<?= admin_url('quotes/pdf/' . $inv->id) ?>" class="btn btn-sm btn-outline-secondary">
                <span class="icon-base ri ri-download-line me-1 icon-16px"></span><?= lang('pdf') ?>
            </a>
            <a href="<?= admin_url('quotes/edit/' . $inv->id) ?>" class="btn btn-sm btn-warning sledit">
                <span class="icon-base ri ri-pencil-line me-1 icon-16px"></span><?= lang('edit') ?>
            </a>
            <a href="<?= admin_url('quotes/delete/' . $inv->id) ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('<?= lang('r_u_sure') ?>')">
                <span class="icon-base ri ri-delete-bin-line me-1 icon-16px"></span><?= lang('delete') ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
