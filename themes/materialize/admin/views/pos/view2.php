<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($modal): ?>
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-body p-0">
            <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="z-index:10;"></button>
<?php else: ?>
<!doctype html>
<html dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="utf-8">
    <title><?= $page_title . ' ' . lang('no') . ' ' . $inv->id; ?></title>
    <base href="<?= base_url(); ?>"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <style>
        * { font-family: 'Courier New', Courier, monospace; font-size: 13px; box-sizing: border-box; }
        body { background: #f7f9fa; display: flex; justify-content: center; padding: 20px; color: #000; }
        #wrapper { width: 380px; background: #fff; padding: 20px; box-shadow: 0 2px 10px rgba(0,0,0,.12); border-radius: 4px; }
        h3 { font-size: 15px; text-transform: uppercase; text-align: center; margin: 5px 0; }
        .text-center { text-align: center; }
        .pull-right { float: right; }
        .no-border { border: none !important; }
        .border-bottom { border-bottom: 1px solid #ddd !important; }
        table { width: 100%; border-collapse: collapse; }
        table td, table th { padding: 3px 5px; vertical-align: top; }
        table tfoot th { border-top: 1px solid #999; }
        .order_barcodes { text-align: center; margin-top: 10px; }
        .order_barcodes img { max-width: 180px; display: inline-block; }
        .btn { display: inline-block; padding: 8px 16px; border: 1px solid #ccc; border-radius: 3px; cursor: pointer; font-family: sans-serif; }
        .btn-primary { background: #696cff; color: #fff; border-color: #696cff; }
        .btn-success { background: #71dd37; color: #fff; border-color: #71dd37; }
        .btn-default { background: #f5f5f5; color: #333; }
        .btn-warning { background: #ffd950; color: #333; border-color: #ffd950; }
        .btn-block { display: block; width: 100%; margin-bottom: 5px; text-align: center; }
        .alert { padding: 10px; border-radius: 4px; margin-bottom: 10px; }
        .alert-success { background: #d4edda; color: #155724; }
        .clearfix::after { content: ''; display: table; clear: both; }
        @media print {
            body { background: none; padding: 0; }
            #wrapper { box-shadow: none; padding: 0; width: 100%; max-width: 380px; }
            .no-print { display: none !important; }
            .no-border { border: none !important; }
            .border-bottom { border-bottom: 1px solid #ddd !important; }
            table tfoot { display: table-row-group; }
        }
    </style>
</head>
<body>
<?php endif; ?>

<div id="wrapper">
    <div id="receiptData">
        <div class="no-print">
            <?php if ($message): ?>
            <div class="alert alert-success">
                <?= is_array($message) ? print_r($message, true) : $message; ?>
            </div>
            <?php endif; ?>
        </div>

        <div id="receipt-data">
            <div class="text-center">
                <?= !empty($biller->logo) ? '<img src="' . base_url('assets/uploads/logos/' . $biller->logo) . '" alt="" style="max-width:180px;display:block;margin:0 auto 8px;">' : ''; ?>
                <h3><?= htmlspecialchars($biller->company && $biller->company != '-' ? $biller->company : $biller->name); ?></h3>
                <p>
                    <?= htmlspecialchars($biller->address . ' ' . $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state . ' ' . $biller->country); ?>
                    <br><?= lang('tel') ?>: <?= htmlspecialchars($biller->phone); ?>
                    <?php
                    if (!empty($biller->cf1) && $biller->cf1 != '-') echo '<br>' . lang('bcf1') . ': ' . htmlspecialchars($biller->cf1);
                    if (!empty($biller->cf2) && $biller->cf2 != '-') echo '<br>' . lang('bcf2') . ': ' . htmlspecialchars($biller->cf2);
                    if (!empty($biller->cf3) && $biller->cf3 != '-') echo '<br>' . lang('bcf3') . ': ' . htmlspecialchars($biller->cf3);
                    if (!empty($biller->cf4) && $biller->cf4 != '-') echo '<br>' . lang('bcf4') . ': ' . htmlspecialchars($biller->cf4);
                    if (!empty($biller->cf5) && $biller->cf5 != '-') echo '<br>' . lang('bcf5') . ': ' . htmlspecialchars($biller->cf5);
                    if (!empty($biller->cf6) && $biller->cf6 != '-') echo '<br>' . lang('bcf6') . ': ' . htmlspecialchars($biller->cf6);
                    if ($pos_settings->cf_title1 && $pos_settings->cf_value1) echo '<br>' . htmlspecialchars($pos_settings->cf_title1) . ': ' . htmlspecialchars($pos_settings->cf_value1);
                    if ($pos_settings->cf_title2 && $pos_settings->cf_value2) echo '<br>' . htmlspecialchars($pos_settings->cf_title2) . ': ' . htmlspecialchars($pos_settings->cf_value2);
                    ?>
                </p>
            </div>

            <?php if ($Settings->invoice_view == 1 || $Settings->indian_gst): ?>
            <div class="text-center"><strong><?= lang('tax_invoice'); ?></strong></div>
            <?php endif; ?>

            <p>
                <?= lang('date') ?>: <?= $this->sma->hrld($inv->date); ?><br>
                <?= lang('sale_no_ref') ?>: <?= htmlspecialchars($inv->reference_no); ?><br>
                <?php if (!empty($inv->return_sale_ref)) echo lang('return_ref') . ': ' . htmlspecialchars($inv->return_sale_ref) . '<br>'; ?>
                <?= lang('sales_person') ?>: <?= htmlspecialchars($created_by->first_name . ' ' . $created_by->last_name); ?>
            </p>
            <p>
                <?= lang('customer') ?>: <?= htmlspecialchars($customer->company && $customer->company != '-' ? $customer->company : $customer->name); ?><br>
                <?php if ($pos_settings->customer_details):
                    if ($customer->vat_no != '-' && $customer->vat_no != '') echo lang('vat_no') . ': ' . htmlspecialchars($customer->vat_no) . '<br>';
                    if ($customer->gst_no != '-' && $customer->gst_no != '') echo lang('gst_no') . ': ' . htmlspecialchars($customer->gst_no) . '<br>';
                    echo lang('tel') . ': ' . htmlspecialchars($customer->phone) . '<br>';
                    echo lang('address') . ': ' . htmlspecialchars($customer->address) . '<br>';
                    echo htmlspecialchars($customer->city . ' ' . $customer->state . ' ' . $customer->country) . '<br>';
                endif; ?>
            </p>

            <div style="clear:both;"></div>
            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="text-center"><?= lang('desc'); ?></th>
                        <th class="text-center"><?= lang('qty_x_price'); ?></th>
                        <th class="text-center"><?= lang('subtotal'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $r        = 1;
                    $category = 0;
                    foreach ($rows as $row) {
                        if ($pos_settings->item_order == 1 && $category != $row->category_id) {
                            $category = $row->category_id;
                            echo '<tr><td colspan="100%" class="no-border"><strong>' . htmlspecialchars($row->category_name) . '</strong></td></tr>';
                        }
                        echo '<tr>';
                        echo '<td colspan="2" class="no-border">#' . $r . ': &nbsp;' . htmlspecialchars($row->product_code) . '</td>';
                        echo '<td class="no-border text-center" style="width:120px;">' . $this->sma->formatQuantity($row->quantity) . $row->base_unit_code . ' x ' . $this->sma->formatMoney($row->unit_price) . '</td>';
                        echo '<td class="no-border" style="width:80px; text-align:right;">' . $this->sma->formatMoney($row->subtotal) . '</td>';
                        echo '</tr>';
                        echo '<tr><td colspan="4" class="no-border" style="padding-top:0;padding-bottom:0;">' . htmlspecialchars(product_name($row->product_name, ($printer ? $printer->char_per_line : null))) . ($row->variant ? ' (' . htmlspecialchars($row->variant) . ')' : '') . '</td></tr>';
                        if (!empty($row->second_name)) {
                            echo '<tr><td colspan="4" class="no-border" style="padding-top:0;padding-bottom:0;">' . htmlspecialchars($row->second_name) . '</td></tr>';
                        }
                        echo '<tr><td colspan="4" class="no-border border-bottom">' . ($row->item_tax != 0 ? lang('tax') . ' <small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' . $this->sma->formatMoney($row->item_tax) : '') . '</td></tr>';
                        $r++;
                    }
                    if ($return_rows) {
                        echo '<tr><td colspan="100%" class="no-border"><strong>' . lang('returned_items') . '</strong></td></tr>';
                        foreach ($return_rows as $row) {
                            echo '<tr>';
                            echo '<td colspan="2" class="no-border">#' . $r . ': &nbsp;' . htmlspecialchars($row->product_code) . '</td>';
                            echo '<td class="no-border text-center">' . $this->sma->formatQuantity($row->quantity) . $row->base_unit_code . ' x ' . $this->sma->formatMoney($row->unit_price) . '</td>';
                            echo '<td class="no-border" style="text-align:right;">' . $this->sma->formatMoney($row->subtotal) . '</td>';
                            echo '</tr>';
                            echo '<tr><td colspan="4" class="no-border" style="padding-top:0;padding-bottom:0;">' . htmlspecialchars(product_name($row->product_name, ($printer ? $printer->char_per_line : null))) . ($row->variant ? ' (' . htmlspecialchars($row->variant) . ')' : '') . '</td></tr>';
                            $r++;
                        }
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3"><?= lang('total'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></th>
                    </tr>
                    <?php
                    if ($inv->order_tax != 0) echo '<tr><th colspan="3">' . lang('tax') . '</th><th style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
                    if ($inv->order_discount != 0) echo '<tr><th colspan="3">' . lang('order_discount') . '</th><th style="text-align:right;">' . $this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                    if ($inv->shipping != 0) echo '<tr><th colspan="3">' . lang('shipping') . '</th><th style="text-align:right;">' . $this->sma->formatMoney($inv->shipping) . '</th></tr>';
                    if ($Settings->indian_gst) {
                        if ($inv->cgst > 0) { $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst; echo '<tr><td colspan="3">' . lang('cgst') . '</td><td style="text-align:right;">' . ($Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst) . '</td></tr>'; }
                        if ($inv->sgst > 0) { $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst; echo '<tr><td colspan="3">' . lang('sgst') . '</td><td style="text-align:right;">' . ($Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst) . '</td></tr>'; }
                        if ($inv->igst > 0) { $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst; echo '<tr><td colspan="3">' . lang('igst') . '</td><td style="text-align:right;">' . ($Settings->format_gst ? $this->sma->formatMoney($igst) : $igst) . '</td></tr>'; }
                    }
                    if ($pos_settings->rounding || $inv->rounding != 0): ?>
                    <tr>
                        <th colspan="3"><?= lang('rounding'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney($inv->rounding); ?></th>
                    </tr>
                    <tr>
                        <th colspan="3"><?= lang('grand_total'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)); ?></th>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <th colspan="3"><?= lang('grand_total'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></th>
                    </tr>
                    <?php endif;
                    if ($inv->paid < ($inv->grand_total + $inv->rounding)): ?>
                    <tr>
                        <th colspan="3"><?= lang('paid_amount'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></th>
                    </tr>
                    <tr>
                        <th colspan="3"><?= lang('due_amount'); ?></th>
                        <th style="text-align:right;"><?= $this->sma->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></th>
                    </tr>
                    <?php endif; ?>
                </tfoot>
            </table>

            <?php
            if ($payments) {
                echo '<table><tbody>';
                foreach ($payments as $payment) {
                    echo '<tr>';
                    if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                        echo '<td>' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
                        echo '<td>' . lang('change') . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                    } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                        echo '<td>' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid) . '</td>';
                        echo '<td>xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                    } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                        echo '<td>' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid) . '</td>';
                        echo '<td>' . lang('cheque_no') . ': ' . $payment->cheque_no . '</td>';
                    } elseif ($payment->paid_by == 'other' && $payment->amount) {
                        echo '<td colspan="2">' . lang('paid_by') . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</tbody></table>';
            }
            ?>

            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax + $return_sale->product_tax : $inv->product_tax)) : ''; ?>
            <?= $customer->award_points != 0 && $Settings->each_spent > 0 ? '<p class="text-center">' . lang('this_sale') . ': ' . floor(($inv->grand_total / $Settings->each_spent) * $Settings->ca_point) . '<br>' . lang('total') . ' ' . lang('award_points') . ': ' . $customer->award_points . '</p>' : ''; ?>
            <?= $inv->note ? '<p class="text-center">' . $this->sma->decode_html($inv->note) . '</p>' : ''; ?>
            <?= $biller->invoice_footer ? '<p class="text-center">' . $this->sma->decode_html($biller->invoice_footer) . '</p>' : ''; ?>
        </div>

        <div class="order_barcodes text-center">
            <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1'); ?>" alt="<?= htmlspecialchars($inv->reference_no); ?>" class="bcimg" />
            <br>
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
        <div style="clear:both;"></div>
    </div>

    <div id="buttons" style="padding-top:10px;" class="no-print">
        <hr>
        <?php if ($message): ?>
        <div class="alert alert-success"><?= is_array($message) ? print_r($message, true) : $message; ?></div>
        <?php endif; ?>

        <?php if ($modal): ?>
        <div style="display:flex; gap:8px;">
            <button onclick="<?= $pos->remote_printing == 1 ? 'window.print()' : 'return printReceipt()'; ?>;" class="btn btn-primary" style="flex:1;"><?= lang('print'); ?></button>
            <a class="btn btn-success" href="#" id="email" style="flex:1;"><?= lang('email'); ?></a>
            <button type="button" class="btn btn-default" data-bs-dismiss="modal" style="flex:1;"><?= lang('close'); ?></button>
        </div>
        <?php else: ?>
        <button onclick="<?= $pos->remote_printing == 1 ? 'window.print()' : 'return printReceipt()'; ?>;" class="btn btn-primary btn-block"><?= lang('print'); ?></button>
        <?php if (!$pos->remote_printing): ?>
        <button onclick="return openCashDrawer()" class="btn btn-default btn-block"><?= lang('open_cash_drawer'); ?></button>
        <?php endif; ?>
        <a class="btn btn-success btn-block" href="#" id="email"><?= lang('email'); ?></a>
        <a class="btn btn-warning btn-block" href="<?= admin_url('pos'); ?>"><?= lang('back_to_pos'); ?></a>
        <?php endif; ?>
    </div>
</div>

<?php if (!$modal): ?>
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?php endif; ?>

<script>
$(document).ready(function () {
    $('#email').on('click', function () {
        var email = prompt('<?= lang('email_address'); ?>', '<?= $customer->email; ?>');
        if (email) {
            $.ajax({
                type: 'post',
                url: '<?= admin_url('pos/email_receipt'); ?>',
                data: {<?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>', email: email, id: <?= $inv->id; ?>},
                dataType: 'json',
                success: function (data) { alert(data.msg); },
                error: function () { alert('<?= lang('ajax_request_failed'); ?>'); }
            });
        }
        return false;
    });
    <?php if ($pos_settings->remote_printing == 1): ?>
    $(window).on('load', function () { window.print(); return false; });
    <?php endif; ?>
});
</script>
<?php include 'remote_printing2.php'; ?>
<?php if ($modal): ?>
        </div>
    </div>
</div>
<?php else: ?>
</body>
</html>
<?php endif; ?>
