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
                <img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
                     alt="<?= $Settings->site_name; ?>" style="max-height:80px;" />
            </div>
            <?php endif; ?>

            <!-- Header info -->
            <div class="card bg-light border-0 mb-4">
                <div class="card-body py-3">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-1"><span class="fw-semibold"><?= lang('date'); ?>:</span> <?= $this->sma->hrld($inv->date); ?></p>
                            <p class="mb-1"><span class="fw-semibold"><?= lang('ref'); ?>:</span> <code><?= $inv->reference_no; ?></code></p>
                            <?php if (!empty($inv->return_purchase_ref)): ?>
                            <p class="mb-1">
                                <span class="fw-semibold"><?= lang('return_ref'); ?>:</span> <?= $inv->return_purchase_ref; ?>
                                <?php if ($inv->return_id): ?>
                                <a data-bs-target="#myModal2" data-bs-toggle="modal"
                                   href="<?= admin_url('purchases/modal_view/' . $inv->return_id) ?>">
                                    <span class="icon-base ri ri-external-link-line icon-16px"></span>
                                </a>
                                <?php endif; ?>
                            </p>
                            <?php endif; ?>
                            <p class="mb-1">
                                <span class="fw-semibold"><?= lang('status'); ?>:</span>
                                <?php
                                $st = $inv->status;
                                $sbadge = ($st == 'received') ? 'bg-label-success' : (($st == 'partial') ? 'bg-label-warning' : 'bg-label-info');
                                echo '<span class="badge ' . $sbadge . '">' . lang($st) . '</span>';
                                ?>
                            </p>
                            <p class="mb-1">
                                <span class="fw-semibold"><?= lang('payment_status'); ?>:</span>
                                <?php
                                $ps = $inv->payment_status;
                                $pbadge = ($ps == 'paid') ? 'bg-label-success' : (($ps == 'partial') ? 'bg-label-warning' : 'bg-label-danger');
                                echo '<span class="badge ' . $pbadge . '">' . lang($ps) . '</span>';
                                ?>
                            </p>
                            <?php if ($inv->payment_status != 'paid' && $inv->due_date): ?>
                            <p class="mb-0"><span class="fw-semibold"><?= lang('due_date'); ?>:</span> <?= $this->sma->hrsd($inv->due_date); ?></p>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 text-end order_barcodes">
                            <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/60/0/1'); ?>"
                                 alt="<?= $inv->reference_no; ?>" class="bcimg" />
                            <?= $this->sma->qrcode('link', urlencode(admin_url('purchases/view/' . $inv->id)), 2); ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Supplier / Warehouse -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <p class="text-muted small mb-1"><?= $this->lang->line('to'); ?></p>
                    <h6 class="fw-bold mb-1"><?= $supplier->company && $supplier->company != '-' ? $supplier->company : $supplier->name; ?></h6>
                    <small class="text-muted">
                        <?= $supplier->address ?>, <?= $supplier->city ?> <?= $supplier->postal_code ?><br>
                        <?= $supplier->state ?> <?= $supplier->country ?><br>
                        <?php if ($supplier->vat_no && $supplier->vat_no != '-') echo lang('vat_no') . ': ' . $supplier->vat_no . '<br>'; ?>
                        <?= lang('tel') ?>: <?= $supplier->phone ?> &bull; <?= lang('email') ?>: <?= $supplier->email ?>
                    </small>
                </div>
                <div class="col-md-6">
                    <p class="text-muted small mb-1"><?= $this->lang->line('from'); ?></p>
                    <h6 class="fw-bold mb-1"><?= $Settings->site_name; ?></h6>
                    <small class="text-muted">
                        <?= $warehouse->name ?><br>
                        <?= $warehouse->address ?><br>
                        <?= $warehouse->phone ? lang('tel') . ': ' . $warehouse->phone . '<br>' : '' ?>
                        <?= $warehouse->email ? lang('email') . ': ' . $warehouse->email : '' ?>
                    </small>
                </div>
            </div>

            <!-- Items table -->
            <?php
            $col = $Settings->indian_gst ? 5 : 4;
            if ($inv->status == 'partial') $col++;
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
                            <?php if ($inv->status == 'partial') echo '<th class="text-center">' . lang('received') . '</th>'; ?>
                            <th class="text-end"><?= lang('unit_cost'); ?></th>
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
                                <?= $row->supplier_part_no ? '<br><small>' . lang('supplier_part_no') . ': ' . $row->supplier_part_no . '</small>' : ''; ?>
                                <?= $row->details ? '<br><small>' . $row->details . '</small>' : ''; ?>
                                <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br><small class="text-muted">' . lang('expiry') . ': ' . $this->sma->hrsd($row->expiry) . '</small>' : ''; ?>
                            </td>
                            <?php if ($Settings->indian_gst) echo '<td class="text-center">' . ($row->hsn_code ?: '') . '</td>'; ?>
                            <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code; ?></td>
                            <?php if ($inv->status == 'partial') echo '<td class="text-center">' . $this->sma->formatQuantity($row->quantity_received) . ' ' . $row->product_unit_code . '</td>'; ?>
                            <td class="text-end">
                                <?= $row->unit_cost != $row->real_unit_cost && $row->item_discount > 0 ? '<del class="text-muted small">' . $this->sma->formatMoney($row->real_unit_cost) . '</del> ' : ''; ?>
                                <?= $this->sma->formatMoney($row->unit_cost); ?>
                            </td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . ($row->item_tax != 0 ? '<small class="text-muted">(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . ($row->discount != 0 ? '<small class="text-muted">(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                            ?>
                            <td class="text-end fw-semibold"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                        <?php $r++; endforeach;
                        if ($return_rows):
                            echo '<tr class="table-warning"><td colspan="100%" class="fw-bold">' . lang('returned_items') . '</td></tr>';
                            foreach ($return_rows as $row): ?>
                        <tr class="table-warning">
                            <td class="text-center"><?= $r; ?></td>
                            <td>
                                <?= $row->product_code . ' &mdash; ' . $row->product_name . ($row->variant ? ' <span class="badge bg-label-warning">' . $row->variant . '</span>' : ''); ?>
                                <?= $row->second_name ? '<br><small>' . $row->second_name . '</small>' : ''; ?>
                            </td>
                            <?php if ($Settings->indian_gst) echo '<td class="text-center">' . ($row->hsn_code ?: '') . '</td>'; ?>
                            <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code; ?></td>
                            <?php if ($inv->status == 'partial') echo '<td class="text-center">' . $this->sma->formatQuantity($row->quantity_received) . ' ' . $row->product_unit_code . '</td>'; ?>
                            <td class="text-end"><?= $this->sma->formatMoney($row->unit_cost); ?></td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . $this->sma->formatMoney($row->item_tax) . '</td>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . $this->sma->formatMoney($row->item_discount) . '</td>';
                            ?>
                            <td class="text-end fw-semibold"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                            <?php $r++; endforeach;
                        endif; ?>
                    </tbody>
                    <tfoot>
                        <?php if ($inv->grand_total != $inv->total): ?>
                        <tr>
                            <td colspan="<?= $tcol; ?>" class="text-end"><?= lang('total'); ?> (<?= $default_currency->code; ?>)</td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . $this->sma->formatMoney($return_purchase ? ($inv->product_tax + $return_purchase->product_tax) : $inv->product_tax) . '</td>';
                            if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . $this->sma->formatMoney($return_purchase ? ($inv->product_discount + $return_purchase->product_discount) : $inv->product_discount) . '</td>';
                            ?>
                            <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? (($inv->total + $inv->product_tax) + ($return_purchase->total + $return_purchase->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php
                        if ($return_purchase) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('return_total') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($return_purchase->grand_total) . '</td></tr>';
                        if ($inv->surcharge != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('return_surcharge') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
                        if ($inv->order_discount != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($return_purchase ? ($inv->order_discount + $return_purchase->order_discount) : $inv->order_discount) . '</td></tr>';
                        if ($Settings->tax2 && $inv->order_tax != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($return_purchase ? ($inv->order_tax + $return_purchase->order_tax) : $inv->order_tax) . '</td></tr>';
                        if ($inv->shipping != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('shipping') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                        ?>
                        <tr class="table-light fw-bold">
                            <td colspan="<?= $col; ?>" class="text-end"><?= lang('total_amount'); ?> (<?= $default_currency->code; ?>)</td>
                            <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? ($inv->grand_total + $return_purchase->grand_total) : $inv->grand_total); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>" class="text-end fw-semibold"><?= lang('paid'); ?> (<?= $default_currency->code; ?>)</td>
                            <td class="text-end fw-semibold"><?= $this->sma->formatMoney($return_purchase ? ($inv->paid + $return_purchase->paid) : $inv->paid); ?></td>
                        </tr>
                        <tr class="table-danger">
                            <td colspan="<?= $col; ?>" class="text-end fw-bold"><?= lang('Reste à payer'); ?> (<?= $default_currency->code; ?>)</td>
                            <td class="text-end fw-bold"><?= $this->sma->formatMoney(($return_purchase ? ($inv->grand_total + $return_purchase->grand_total) : $inv->grand_total) - ($return_purchase ? ($inv->paid + $return_purchase->paid) : $inv->paid)); ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_purchase ? $inv->product_tax + $return_purchase->product_tax : $inv->product_tax), true) : ''; ?>

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

            <?php include(dirname(__FILE__) . '/../partials/attachments.php'); ?>
        </div>

        <?php if (!$Supplier || !$Customer): ?>
        <div class="modal-footer justify-content-start gap-2 flex-wrap">
            <a href="<?= admin_url('purchases/add_payment/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-sm btn-primary">
                <span class="icon-base ri ri-money-dollar-circle-line me-1 icon-16px"></span><?= lang('add_payment') ?>
            </a>
            <a href="<?= admin_url('purchases/email/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal2" class="btn btn-sm btn-primary">
                <span class="icon-base ri ri-mail-line me-1 icon-16px"></span><?= lang('email') ?>
            </a>
            <a href="<?= admin_url('purchases/pdf/' . $inv->id) ?>" class="btn btn-sm btn-outline-secondary">
                <span class="icon-base ri ri-download-line me-1 icon-16px"></span><?= lang('pdf') ?>
            </a>
            <a href="<?= admin_url('purchases/edit/' . $inv->id) ?>" class="btn btn-sm btn-warning sledit">
                <span class="icon-base ri ri-pencil-line me-1 icon-16px"></span><?= lang('edit') ?>
            </a>
            <a href="<?= admin_url('purchases/delete/' . $inv->id) ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('<?= lang('r_u_sure') ?>')">
                <span class="icon-base ri ri-delete-bin-line me-1 icon-16px"></span><?= lang('delete') ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
