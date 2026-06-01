<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('sale') . ' ' . $inv->reference_no; ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body { background: #f4f5f7; font-family: 'Segoe UI', Arial, sans-serif; color: #333; }
        .invoice-wrap { max-width: 820px; margin: 30px auto; background: #fff; border-radius: 8px; box-shadow: 0 2px 12px rgba(0,0,0,.1); padding: 40px; }
        .invoice-header { border-bottom: 2px solid #696cff; padding-bottom: 20px; margin-bottom: 24px; }
        .company-logo img { max-height: 70px; }
        .invoice-title { font-size: 2rem; font-weight: 700; color: #696cff; }
        .info-label { font-size: 0.75rem; text-transform: uppercase; color: #888; letter-spacing: .05em; }
        .info-value { font-weight: 600; }
        .table thead th { background: #696cff; color: #fff; border: none; }
        .table tfoot td, .table tfoot th { font-weight: 600; }
        .total-row td { font-size: 1.05rem; }
        .grand-total td { font-size: 1.2rem; font-weight: 700; color: #696cff; border-top: 2px solid #696cff !important; }
        .status-paid { color: #71dd37; }
        .status-partial { color: #ffd950; }
        .status-due { color: #ff3e1d; }
        .note-box { background: #f8f9fa; border-left: 4px solid #696cff; padding: 12px 16px; border-radius: 4px; }
        @media print {
            body { background: #fff; }
            .invoice-wrap { box-shadow: none; padding: 0; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="invoice-wrap">
    <!-- Header -->
    <div class="invoice-header d-flex justify-content-between align-items-start flex-wrap gap-3">
        <div>
            <?php if ($logo):
                $path   = base_url() . 'assets/uploads/logos/' . $biller->logo;
                $type   = pathinfo($path, PATHINFO_EXTENSION);
                $data   = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); ?>
                <div class="company-logo mb-2">
                    <img src="<?= $base64; ?>" alt="<?= htmlspecialchars($biller->company && $biller->company != '-' ? $biller->company : $biller->name); ?>">
                </div>
            <?php endif; ?>
        </div>
        <div class="text-end">
            <?php if ($Settings->invoice_view == 1): ?>
                <div class="invoice-title mb-1"><?= lang('tax_invoice'); ?></div>
            <?php else: ?>
                <div class="invoice-title mb-1"><?= lang('invoice'); ?></div>
            <?php endif; ?>
            <div class="text-muted"><?= htmlspecialchars($Settings->site_name); ?></div>
        </div>
    </div>

    <!-- Parties -->
    <div class="row mb-4">
        <div class="col-sm-5">
            <div class="info-label mb-1"><?= $this->lang->line('to'); ?></div>
            <h5 class="mb-1"><?= htmlspecialchars($customer->company && $customer->company != '-' ? $customer->company : $customer->name); ?></h5>
            <?= $customer->company && $customer->company != '-' ? '' : '<div class="text-muted">Attn: ' . htmlspecialchars($customer->name) . '</div>'; ?>
            <div class="text-muted">
                <?= htmlspecialchars($customer->address) ?><br>
                <?= htmlspecialchars($customer->city . ' ' . $customer->postal_code . ' ' . $customer->state) ?><br>
                <?= htmlspecialchars($customer->country) ?>
            </div>
            <?php if ($customer->vat_no != '-' && $customer->vat_no != '') echo '<div>' . lang('vat_no') . ': ' . htmlspecialchars($customer->vat_no) . '</div>'; ?>
            <?php if ($customer->gst_no != '-' && $customer->gst_no != '') echo '<div>' . lang('gst_no') . ': ' . htmlspecialchars($customer->gst_no) . '</div>'; ?>
            <?php foreach (['cf1'=>'ccf1','cf2'=>'ccf2','cf3'=>'ccf3','cf4'=>'ccf4','cf5'=>'ccf5','cf6'=>'ccf6'] as $cf => $lk):
                if ($customer->$cf != '-' && $customer->$cf != '') echo '<div>' . lang($lk) . ': ' . htmlspecialchars($customer->$cf) . '</div>';
            endforeach; ?>
            <div class="mt-1">
                <?= lang('tel') ?>: <?= htmlspecialchars($customer->phone) ?><br>
                <?= lang('email') ?>: <?= htmlspecialchars($customer->email) ?>
            </div>
        </div>
        <div class="col-sm-4 offset-sm-1">
            <div class="info-label mb-1"><?= $this->lang->line('from'); ?></div>
            <h5 class="mb-1"><?= htmlspecialchars($biller->company && $biller->company != '-' ? $biller->company : $biller->name); ?></h5>
            <div class="text-muted">
                <?= htmlspecialchars($biller->address) ?><br>
                <?= htmlspecialchars($biller->city . ' ' . $biller->postal_code . ' ' . $biller->state) ?><br>
                <?= htmlspecialchars($biller->country) ?>
            </div>
            <?php if ($biller->vat_no != '-' && $biller->vat_no != '') echo '<div>' . lang('vat_no') . ': ' . htmlspecialchars($biller->vat_no) . '</div>'; ?>
            <?php if ($biller->gst_no != '-' && $biller->gst_no != '') echo '<div>' . lang('gst_no') . ': ' . htmlspecialchars($biller->gst_no) . '</div>'; ?>
            <div class="mt-1">
                <?= lang('tel') ?>: <?= htmlspecialchars($biller->phone) ?><br>
                <?= lang('email') ?>: <?= htmlspecialchars($biller->email) ?>
            </div>
        </div>
    </div>

    <!-- Invoice Meta -->
    <div class="row mb-4">
        <div class="col-sm-5">
            <div class="info-label"><?= lang('warehouse'); ?></div>
            <div class="info-value"><?= htmlspecialchars($warehouse->name); ?></div>
            <div class="text-muted small"><?= htmlspecialchars($warehouse->address); ?></div>
        </div>
        <div class="col-sm-4 offset-sm-1">
            <table class="table table-sm table-borderless mb-0">
                <tr>
                    <td class="info-label pe-3"><?= lang('date'); ?></td>
                    <td class="info-value"><?= $this->sma->hrld($inv->date); ?></td>
                </tr>
                <tr>
                    <td class="info-label pe-3"><?= lang('ref'); ?></td>
                    <td class="info-value"><?= htmlspecialchars($inv->reference_no); ?></td>
                </tr>
                <tr>
                    <td class="info-label pe-3"><?= lang('payment_status'); ?></td>
                    <td class="info-value <?= 'status-' . ($inv->payment_status == 'paid' ? 'paid' : ($inv->payment_status == 'partial' ? 'partial' : 'due')); ?>">
                        <?= lang($inv->payment_status); ?>
                    </td>
                </tr>
                <?php if ($inv->payment_method): ?>
                <tr>
                    <td class="info-label pe-3"><?= lang('payment_method'); ?></td>
                    <td class="info-value"><?= lang($inv->payment_method); ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($inv->payment_status != 'paid' && $inv->due_date): ?>
                <tr>
                    <td class="info-label pe-3"><?= lang('due_date'); ?></td>
                    <td class="info-value"><?= $this->sma->hrsd($inv->due_date); ?></td>
                </tr>
                <?php endif; ?>
            </table>
            <?php if (!empty($inv->return_sale_ref)) echo '<div class="text-muted small">' . lang('return_ref') . ': ' . htmlspecialchars($inv->return_sale_ref) . '</div>'; ?>
            <div class="mt-2">
                <?php
                if ($Settings->ksa_qrcode) {
                    $qrtext = $this->inv_qrcode->base64([
                        'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
                        'vat_no'           => $biller->vat_no ?: $biller->get_no,
                        'date'             => $inv->date,
                        'grand_total'      => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
                        'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
                    ]);
                    echo $this->sma->qrcode('text', $qrtext, 2);
                } else {
                    echo $this->sma->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 2);
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Items Table -->
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
    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center" style="width:40px;"><?= lang('no'); ?></th>
                    <th><?= lang('description'); ?></th>
                    <?php if ($Settings->indian_gst): ?><th><?= lang('hsn_sac_code'); ?></th><?php endif; ?>
                    <th class="text-center"><?= lang('quantity'); ?></th>
                    <th class="text-end"><?= lang('unit_price'); ?></th>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) echo '<th class="text-end">' . lang('tax') . '</th>'; ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) echo '<th class="text-end">' . lang('discount') . '</th>'; ?>
                    <th class="text-end"><?= lang('subtotal'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php $r = 1;
                foreach ($rows as $row): ?>
                <tr>
                    <td class="text-center"><?= $r; ?></td>
                    <td>
                        <?= htmlspecialchars($row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?>
                        <?= $row->second_name ? '<br><small class="text-muted">' . htmlspecialchars($row->second_name) . '</small>' : ''; ?>
                        <?= $row->details ? '<br><small>' . htmlspecialchars($row->details) . '</small>' : ''; ?>
                        <?= $row->serial_no ? '<br><small class="text-muted">' . htmlspecialchars($row->serial_no) . '</small>' : ''; ?>
                    </td>
                    <?php if ($Settings->indian_gst): ?><td class="text-center"><?= htmlspecialchars($row->hsn_code ?: ''); ?></td><?php endif; ?>
                    <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . ($inv->sale_status == 'returned' ? $row->base_unit_code : $row->product_unit_code); ?></td>
                    <td class="text-end">
                        <?= $row->unit_price != $row->real_unit_price && $row->item_discount > 0 ? '<del class="text-muted">' . $this->sma->formatMoney($row->real_unit_price) . '</del> ' : ''; ?>
                        <?= $this->sma->formatMoney($row->unit_price); ?>
                    </td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>'; ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>'; ?>
                    <td class="text-end"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                </tr>
                <?php $r++; endforeach;

                if ($return_rows) {
                    echo '<tr class="table-warning"><td colspan="' . ($col + 1) . '"><strong>' . lang('returned_items') . '</strong></td></tr>';
                    foreach ($return_rows as $row): ?>
                    <tr class="table-warning">
                        <td class="text-center"><?= $r; ?></td>
                        <td>
                            <?= htmlspecialchars($row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?>
                            <?= $row->second_name ? '<br><small>' . htmlspecialchars($row->second_name) . '</small>' : ''; ?>
                        </td>
                        <?php if ($Settings->indian_gst) echo '<td class="text-center">' . htmlspecialchars($row->hsn_code ?: '') . '</td>'; ?>
                        <td class="text-center"><?= $this->sma->formatQuantity($row->quantity) . ' ' . $row->base_unit_code; ?></td>
                        <td class="text-end"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                        <?php if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>'; ?>
                        <?php if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>'; ?>
                        <td class="text-end"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                    </tr>
                    <?php $r++; endforeach;
                } ?>
            </tbody>
            <tfoot>
                <?php if ($inv->grand_total != $inv->total): ?>
                <tr>
                    <td colspan="<?= $tcol; ?>" class="text-end"><?= lang('total'); ?> (<?= $default_currency->code; ?>)</td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) echo '<td class="text-end">' . $this->sma->formatMoney($return_sale ? ($inv->product_tax + $return_sale->product_tax) : $inv->product_tax) . '</td>'; ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) echo '<td class="text-end">' . $this->sma->formatMoney($return_sale ? ($inv->product_discount + $return_sale->product_discount) : $inv->product_discount) . '</td>'; ?>
                    <td class="text-end"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                </tr>
                <?php endif; ?>
                <?php if ($return_sale) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('return_total') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($return_sale->grand_total) . '</td></tr>'; ?>
                <?php if ($inv->surcharge != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('return_surcharge') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>'; ?>
                <?php if ($Settings->indian_gst):
                    if ($inv->cgst > 0) { $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst; echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('cgst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst) . '</td></tr>'; }
                    if ($inv->sgst > 0) { $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst; echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('sgst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst) . '</td></tr>'; }
                    if ($inv->igst > 0) { $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst; echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('igst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($igst) : $igst) . '</td></tr>'; }
                endif; ?>
                <?php if ($inv->order_discount != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</td></tr>'; ?>
                <?php if ($Settings->tax2 && $inv->order_tax != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</td></tr>'; ?>
                <?php if ($inv->shipping != 0) echo '<tr><td colspan="' . $col . '" class="text-end">' . lang('shipping') . ' (' . $default_currency->code . ')</td><td class="text-end">' . $this->sma->formatMoney($inv->shipping - ($return_sale && $return_sale->shipping ? $return_sale->shipping : 0)) . '</td></tr>'; ?>
                <tr class="grand-total">
                    <td colspan="<?= $col; ?>" class="text-end"><?= lang('total_amount'); ?> (<?= $default_currency->code; ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="<?= $col; ?>" class="text-end"><?= lang('paid'); ?> (<?= $default_currency->code; ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></td>
                </tr>
                <tr class="total-row">
                    <td colspan="<?= $col; ?>" class="text-end"><?= lang('balance'); ?> (<?= $default_currency->code; ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney(($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax + $return_sale->product_tax : $inv->product_tax)) : ''; ?>

    <!-- Note -->
    <?php if ($inv->note && $inv->note != ''): ?>
    <div class="note-box mt-3">
        <strong><?= lang('note'); ?>:</strong>
        <div class="mt-1"><?= $this->sma->decode_html($inv->note); ?></div>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
