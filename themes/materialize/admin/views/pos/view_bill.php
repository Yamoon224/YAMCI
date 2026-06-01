<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('view_bill') . ' | ' . $Settings->site_name; ?></title>
    <base href="<?= base_url(); ?>"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
    <style>
        * { font-family: 'Segoe UI', Arial, sans-serif; font-size: 13px; box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #f4f5f7; color: #333; }
        a { outline: none; text-decoration: none; }

        /* Layout */
        .wrap { display: flex; height: 100vh; overflow: hidden; }
        .bill { width: 400px; min-width: 320px; background: #fff; display: flex; flex-direction: column; border-right: 1px solid #ddd; }
        .main { flex: 1; overflow: auto; }
        .content { display: none; }

        /* Bill sections */
        #product-list { flex: 1; overflow: auto; padding: 10px; border-bottom: 1px solid #ddd; }
        #totals { padding: 8px; background: #fff; }

        /* Tables */
        #billTable { width: 100%; border-collapse: collapse; font-size: 12px; }
        #billTable thead th { background: #696cff; color: #fff; padding: 6px 8px; text-align: center; }
        #billTable tbody td { padding: 5px 8px; border-bottom: 1px solid #f0f0f0; vertical-align: middle; }
        #billTable tbody tr:hover { background: #f8f8ff; }

        #totalTable { width: 100%; border-collapse: collapse; font-size: 13px; }
        #totalTable td { padding: 5px 10px; }
        #totalTable .gtotal-row td { background: #333; color: #fff; font-weight: bold; font-size: 1.2em; padding: 8px 10px; }

        /* Promo / customer frame */
        .preview_frame { width: 100%; height: calc(100vh - 40px); border: none; }

        /* Responsive */
        @media (max-width: 700px) {
            .main { display: none; }
            .bill { width: 100%; border-right: none; }
        }
    </style>
</head>
<body>
<noscript>
    <div style="padding:20px;background:#fff3cd;color:#856404;">
        <strong>JavaScript seems to be disabled in your browser.</strong><br>
        You must have JavaScript enabled to utilize the POS bill view.
    </div>
</noscript>

<div class="wrap">
    <!-- Bill panel -->
    <div class="bill" id="bill">
        <div id="product-list">
            <table id="billTable">
                <thead>
                    <tr>
                        <th style="width:50%;"><?= lang('product'); ?></th>
                        <th style="width:15%;"><?= lang('price'); ?></th>
                        <th style="width:15%;"><?= lang('qty'); ?></th>
                        <th style="width:20%;"><?= lang('subtotal'); ?></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

        <div id="totals">
            <table id="totalTable">
                <tbody>
                    <tr>
                        <td style="text-align:left;"><?= lang('items'); ?></td>
                        <td style="text-align:right; font-weight:bold;"><span id="titems">0</span></td>
                        <td style="text-align:left; padding-left:15px;"><?= lang('total'); ?></td>
                        <td style="text-align:right; font-weight:bold;"><span id="total">0.00</span></td>
                    </tr>
                    <tr>
                        <td style="text-align:left;"><?= lang('order_tax'); ?></td>
                        <td style="text-align:right; font-weight:bold;"><span id="ttax2">0.00</span></td>
                        <td style="text-align:left; padding-left:15px;"><?= lang('discount'); ?></td>
                        <td style="text-align:right; font-weight:bold;"><span id="tds">0.00</span></td>
                    </tr>
                    <tr class="gtotal-row">
                        <td colspan="3" style="text-align:left;">
                            <?= lang('total_payable'); ?>
                            <?= $Settings->display_symbol ? $Settings->symbol : ''; ?>
                            <small id="tship"></small>
                        </td>
                        <td style="text-align:right;"><span id="gtotal">0.00</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Promotions / customer info panel -->
    <div class="main content" id="rightside-content">
        <iframe class="preview_frame"
                src="<?= admin_url('welcome/promotions'); ?>"
                name="preview-frame"
                frameborder="0"></iframe>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true"></div>

<?php
unset(
    $Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass,
    $Settings->smtp_port, $Settings->update, $Settings->reg_ver,
    $Settings->allow_reg, $Settings->default_email, $Settings->mmode,
    $Settings->timezone, $Settings->restrict_calendar,
    $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification
);
?>
<script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>pos/js/plugins.min.js"></script>
<script type="text/javascript">
    var site = <?= json_encode(['base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats]); ?>,
        pos_settings = <?= json_encode($pos_settings); ?>;
</script>
<script type="text/javascript">
    var product_tax = 0, invoice_tax = 0, total_discount = 0, product_discount = 0,
        order_discount = 0, total = 0,
        tax_rates = <?= json_encode($tax_rates); ?>,
        pos_customer = localStorage.getItem('poscustomer'),
        shipping = 0;

    function widthFunctions() {
        var wh  = $(window).height();
        var tT  = $('#totalTable').outerHeight(true);
        $('#bill').css('height', wh);
        $('#product-list').css('height', wh - tT);
        $('.preview_frame').css('height', wh - 35);
    }
    $(window).on('resize load', widthFunctions);

    $(document).ready(function () {
        if (localStorage.getItem('poscustomer')) {
            getCustomer(localStorage.getItem('poscustomer'));
        }
        loadItems();
        window.setInterval(function () {
            if (localStorage.getItem('poscustomer') && pos_customer != localStorage.getItem('poscustomer')) {
                getCustomer(localStorage.getItem('poscustomer'));
                pos_customer = localStorage.getItem('poscustomer');
            }
            loadItems();
        }, 1000);
    });

    function formatDecimal(x) {
        return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
    }
    function formatQuantity2(x) {
        return (x != null) ? parseFloat(parseFloat(x).toFixed(site.settings.qty_decimals)) : '';
    }
    function formatMoney(x, symbol) {
        if (!symbol) symbol = '';
        return accounting.formatMoney(x, symbol, site.settings.decimals,
            site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep,
            site.settings.decimals_sep, '%s%v');
    }

    function getCustomer(id) {
        $.getJSON('customers/get_customer_details/' + id, function (data) {
            $('#rightside-content').show().html(
                '<div style="padding:15px;"><h3><?= lang('customer'); ?>: ' +
                (data.company && data.company != '-' ? data.company + ' (' + data.name + ')' : data.name) +
                '</h3><table style="width:100%; border-collapse:collapse; font-size:12px;">' +
                '<tr><td style="padding:4px 8px; border:1px solid #eee;"><?= lang('company'); ?></td><td style="padding:4px 8px; border:1px solid #eee;"><strong>' + data.company + '</strong></td></tr>' +
                '<tr><td style="padding:4px 8px; border:1px solid #eee;"><?= lang('contact_person'); ?></td><td style="padding:4px 8px; border:1px solid #eee;"><strong>' + data.name + '</strong></td></tr>' +
                '<tr><td style="padding:4px 8px; border:1px solid #eee;"><?= lang('phone'); ?></td><td style="padding:4px 8px; border:1px solid #eee;"><strong>' + data.phone + '</strong></td></tr>' +
                '<tr><td style="padding:4px 8px; border:1px solid #eee;"><?= lang('email_address'); ?></td><td style="padding:4px 8px; border:1px solid #eee;"><strong>' + data.email + '</strong></td></tr>' +
                '<tr><td style="padding:4px 8px; border:1px solid #eee;"><?= lang('award_points'); ?></td><td style="padding:4px 8px; border:1px solid #eee;"><strong>' + data.award_points + '</strong></td></tr>' +
                '</table></div>'
            );
        });
    }

    function loadItems() {
        if (!localStorage.getItem('positems')) {
            $('#billTable tbody').empty();
            $('#total').text('0.00'); $('#titems').text('0'); $('#tds').text('(0.00) 0.00');
            if (site.settings.tax2 != 0) $('#ttax2').text('0.00');
            $('#gtotal').text('0.00');
            return;
        }
        total = 0; var count = 1, an = 1;
        product_tax = 0; invoice_tax = 0; product_discount = 0;
        order_discount = 0; total_discount = 0;
        shipping = parseFloat(localStorage.getItem('posshipping') || 0);
        $('#billTable tbody').empty();
        var positems = JSON.parse(localStorage.getItem('positems'));
        var sortedItems = pos_settings.item_order == 1
            ? _.sortBy(positems, function (o) { return [parseInt(o.category), parseInt(o.order)]; })
            : (site.settings.item_addition == 1 ? _.sortBy(positems, function (o) { return [parseInt(o.order)]; }) : positems);
        var category = 0;

        $.each(sortedItems, function () {
            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            var item_price = item.row.price, item_qty = item.row.qty,
                item_tax_method = item.row.tax_method, item_ds = item.row.discount,
                item_discount = 0, item_code = item.row.code,
                item_name = item.row.name.replace(/"/g, '&#034;').replace(/'/g, '&#039;');
            var unit_price = item.row.real_unit_price;

            var ds = item_ds ? item_ds : '0';
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) item_discount = formatDecimal((parseFloat(unit_price) * parseFloat(pds[0])) / 100);
            } else { item_discount = formatDecimal(ds); }
            product_discount += formatDecimal(item_discount * item_qty);
            unit_price = formatDecimal(unit_price - item_discount);

            var pr_tax = item.tax_rate, pr_tax_val = 0;
            if (site.settings.tax1 == 1 && pr_tax !== false) {
                if (pr_tax.type == 1) {
                    pr_tax_val = item_tax_method == '0'
                        ? formatDecimal((unit_price * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)))
                        : formatDecimal((unit_price * parseFloat(pr_tax.rate)) / 100);
                } else if (pr_tax.type == 2) { pr_tax_val = formatDecimal(pr_tax.rate); }
                product_tax += pr_tax_val * item_qty;
            }
            item_price = item_tax_method == 0 ? formatDecimal(unit_price - pr_tax_val) : formatDecimal(unit_price);

            var newTr = $('<tr></tr>');
            var tr_html = '<td><span>' + item_code + ' - ' + item_name + '</span></td>';
            tr_html += '<td style="text-align:right;">' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + '</td>';
            tr_html += '<td style="text-align:center;">' + formatQuantity2(item_qty) + '</td>';
            tr_html += '<td style="text-align:right;">' + formatMoney((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)) + '</td>';
            newTr.html(tr_html);
            if (pos_settings.item_order == 1) newTr.appendTo('#billTable'); else newTr.prependTo('#billTable');

            total += formatDecimal((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty));
            count += parseFloat(item_qty);
            an++;
        });

        if (posdiscount = localStorage.getItem('posdiscount')) {
            var ds = posdiscount;
            if (ds.indexOf('%') !== -1) {
                var pds = ds.split('%');
                if (!isNaN(pds[0])) order_discount = formatDecimal((parseFloat(total) * parseFloat(pds[0])) / 100);
            } else { order_discount = parseFloat(ds); }
        }
        if (site.settings.tax2 != 0 && (postax2 = localStorage.getItem('postax2'))) {
            $.each(tax_rates, function () {
                if (this.id == postax2) {
                    if (this.type == 2) invoice_tax = formatDecimal(this.rate);
                    if (this.type == 1) invoice_tax = formatDecimal(((total - order_discount) * this.rate) / 100);
                }
            });
        }
        total = formatDecimal(total);
        product_tax = formatDecimal(product_tax);
        total_discount = formatDecimal(order_discount + product_discount);
        var gtotal = parseFloat(((total + invoice_tax) - order_discount)) + shipping;

        $('#total').text(formatMoney(total));
        $('#titems').text((an - 1) + ' (' + formatQuantity2(parseFloat(count) - 1) + ')');
        $('#tds').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
        if (site.settings.tax2 != 0) $('#ttax2').text(formatMoney(invoice_tax));
        $('#tship').text(shipping > 0 ? ' + <?= lang('shipping'); ?>' : '');
        $('#gtotal').text(formatMoney(gtotal));
    }
</script>
</body>
</html>
