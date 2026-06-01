<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- HEADER style template Pixinvent -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
      <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-barcode-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('print_barcode_label'); ?></h4>
        <p class="mb-0 text-muted">Sélectionnez les produits et imprimez leurs codes-barres / étiquettes</p>
        <nav aria-label="breadcrumb" class="mt-2">
          <ol class="breadcrumb breadcrumb-style1 mb-0">
            <li class="breadcrumb-item"><a href="<?= admin_url(); ?>">Accueil</a></li>
            <li class="breadcrumb-item"><a href="<?= admin_url('products'); ?>"><?= lang('products'); ?></a></li>
            <li class="breadcrumb-item active"><?= lang('print_barcode_label'); ?></li>
          </ol>
        </nav>
      </div>
      <div class="d-flex align-content-center flex-wrap gap-2">
        <button onclick="window.print(); return false;" class="btn btn-primary">
          <i class="ri ri-printer-line me-1" style="font-size:16px"></i><?= lang('print'); ?>
        </button>
        <a href="<?= admin_url('products'); ?>" class="btn btn-outline-secondary">
          <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?= lang('back') ?: 'Retour'; ?>
        </a>
      </div>
    </div>

    <div class="card no-print mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0"><i class="ri ri-list-settings-line me-2" style="font-size:18px;vertical-align:-0.15em"></i><?= lang('settings') ?: 'Configuration' ?></h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4"><?php echo sprintf(
                lang('print_barcode_heading'),
                anchor('admin/system_settings/categories', lang('categories') . ' & ' . lang('subcategories')),
                '',
                anchor('admin/purchases', lang('purchases')),
                anchor('admin/transfers', lang('transfers'))
            ); ?></p>

            <!-- Add product input -->
            <div class="mb-3">
                <label class="form-label" for="add_item"><?= lang('add_product'); ?></label>
                <div class="form-floating form-floating-outline">
                    <?= form_input('add_item', '', 'class="form-control" id="add_item" placeholder="' . $this->lang->line('add_item') . '"'); ?>
                    <label for="add_item"><?= lang('add_item'); ?></label>
                </div>
            </div>

            <?= admin_form_open('products/print_barcodes', 'id="barcode-print-form"'); ?>

            <!-- Items table -->
            <div class="table-responsive mb-3">
                <table id="bcTable" class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th><?= lang('product_name') . ' (' . $this->lang->line('product_code') . ')'; ?></th>
                            <th style="width:100px;"><?= lang('quantity'); ?></th>
                            <th><?= lang('variants'); ?></th>
                            <th style="width:36px;" class="text-center"><i class="ri-delete-bin-line text-muted"></i></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <!-- Style select -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <?php $opts = [
                            ''  => lang('select') . ' ' . lang('style'),
                            40  => lang('40_per_sheet'),
                            30  => lang('30_per_sheet'),
                            24  => lang('24_per_sheet'),
                            20  => lang('20_per_sheet'),
                            18  => lang('18_per_sheet'),
                            14  => lang('14_per_sheet'),
                            12  => lang('12_per_sheet'),
                            10  => lang('10_per_sheet'),
                            50  => lang('continuous_feed'),
                        ]; ?>
                        <?= form_dropdown('style', $opts, set_value('style', 24), 'class="form-select" id="style" required="required"'); ?>
                        <label for="style"><?= lang('style'); ?></label>
                    </div>
                </div>
            </div>

            <!-- Continuous feed dimensions (hidden by default) -->
            <div class="row g-3 mb-3 cf-con" style="display:none;">
                <div class="col-md-3">
                    <div class="input-group">
                        <?= form_input('cf_width', '', 'class="form-control" id="cf_width" placeholder="' . lang('width') . '"'); ?>
                        <span class="input-group-text"><?= lang('inches'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <?= form_input('cf_height', '', 'class="form-control" id="cf_height" placeholder="' . lang('height') . '"'); ?>
                        <span class="input-group-text"><?= lang('inches'); ?></span>
                    </div>
                </div>
                <div class="col-md-3">
                    <?php $oopts = [0 => lang('portrait'), 1 => lang('landscape')]; ?>
                    <?= form_dropdown('cf_orientation', $oopts, '', 'class="form-select" id="cf_orientation"'); ?>
                </div>
            </div>
            <div class="form-text mb-3"><?= lang('barcode_tip'); ?></div>

            <!-- Print options checkboxes -->
            <div class="mb-3">
                <label class="form-label fw-semibold"><?= lang('print'); ?>:</label>
                <div class="d-flex flex-wrap gap-3">
                    <?php
                    $checkboxes = [
                        'site_name'     => lang('site_name'),
                        'product_name'  => lang('product_name'),
                        'price'         => lang('price'),
                        'currencies'    => lang('currencies'),
                        'unit'          => lang('unit'),
                        'category'      => lang('category'),
                        'variants'      => lang('variants'),
                        'product_image' => lang('product_image'),
                        'check_promo'   => lang('check_promo'),
                    ];
                    $checked_defaults = ['site_name', 'product_name', 'price', 'check_promo'];
                    foreach ($checkboxes as $name => $label): ?>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="<?= $name; ?>" id="<?= $name; ?>"
                               value="1" <?= in_array($name, $checked_defaults) ? 'checked' : ''; ?>>
                        <label class="form-check-label" for="<?= $name; ?>"><?= $label; ?></label>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="d-flex gap-2">
                <?= form_submit('print', lang('update'), 'class="btn btn-primary"'); ?>
                <button type="button" id="reset" class="btn btn-outline-danger"><?= lang('reset'); ?></button>
            </div>

            <?= form_close(); ?>
        </div>
    </div>

    <!-- Barcode output -->
    <div id="barcode-con">
        <?php
        if ($this->input->post('print')) {
            if (!empty($barcodes)) {
                echo '<button type="button" onclick="window.print();return false;" class="btn btn-primary mb-3 no-print"><i class="ri-printer-line me-1"></i> ' . lang('print') . '</button>';
                $c = 1;
                if ($style == 12 || $style == 18 || $style == 24 || $style == 40) {
                    echo '<div class="barcodea4">';
                } elseif ($style != 50) {
                    echo '<div class="barcode">';
                }
                foreach ($barcodes as $item) {
                    for ($r = 1; $r <= $item['quantity']; $r++) {
                        echo '<div class="item style' . $style . '"' .
                            ($style == 50 && $this->input->post('cf_width') && $this->input->post('cf_height') ?
                                ' style="width:' . $this->input->post('cf_width') . 'in;height:' . $this->input->post('cf_height') . 'in;border:0;"' : '') . '>';
                        if ($style == 50) {
                            if ($this->input->post('cf_orientation')) {
                                $ty = (($this->input->post('cf_height') / $this->input->post('cf_width')) * 100) . '%';
                                $landscape = '-webkit-transform-origin:0 0;transform-origin:0 0;-webkit-transform:translateY(' . $ty . ') rotate(-90deg);transform:translateY(' . $ty . ') rotate(-90deg);';
                                echo '<div class="div50" style="width:' . $this->input->post('cf_height') . 'in;height:' . $this->input->post('cf_width') . 'in;border:1px dotted #CCC;' . $landscape . '">';
                            } else {
                                echo '<div class="div50" style="width:' . $this->input->post('cf_width') . 'in;height:' . $this->input->post('cf_height') . 'in;border:1px dotted #CCC;padding-top:0.025in;">';
                            }
                        }
                        if ($item['image']) echo '<span class="product_image"><img src="' . base_url('assets/uploads/thumbs/' . $item['image']) . '" alt="" /></span>';
                        if ($item['site'])  echo '<span class="barcode_site">' . $item['site'] . '</span>';
                        if ($item['name'])  echo '<span class="barcode_name">' . $item['name'] . '</span>';
                        if ($item['price']) {
                            echo '<span class="barcode_price">' . lang('price') . ' ';
                            if ($item['currencies']) {
                                $rates = [];
                                foreach ($currencies as $currency) {
                                    $rates[] = $currency->code . ': ' . $this->sma->formatMoney($item['rprice'] * $currency->rate, 'none');
                                }
                                echo implode(', ', $rates);
                            } else { echo $item['price']; }
                            echo '</span>';
                        }
                        if ($item['unit'])     echo '<span class="barcode_unit">' . lang('unit') . ': ' . $item['unit'] . '</span>, ';
                        if ($item['category']) echo '<span class="barcode_category">' . lang('category') . ': ' . $item['category'] . '</span> ';
                        if ($item['variants']) {
                            echo '<span class="variants">' . lang('variants') . ': ';
                            foreach ($item['variants'] as $variant) echo $variant->name . ', ';
                            echo '</span>';
                        }
                        echo '<span class="barcode_image"><img src="' . admin_url('products/barcode/' . $item['barcode'] . '/' . $item['bcs'] . '/' . $item['bcis']) . '" alt="' . $item['barcode'] . '" class="bcimg" /></span>';
                        if ($style == 50) echo '</div>';
                        echo '</div>';
                        // Page breaks
                        foreach ([40, 30, 24, 20, 18, 14, 12, 10] as $brk) {
                            if ($style == $brk && $c % $brk == 0) {
                                $cls = in_array($brk, [12, 18, 24, 40]) ? 'barcodea4' : 'barcode';
                                echo '</div><div class="clearfix"></div><div class="' . $cls . '">';
                            }
                        }
                        $c++;
                    }
                }
                if ($style != 50) echo '</div>';
                echo '<button type="button" onclick="window.print();return false;" class="btn btn-primary mt-3 no-print"><i class="ri-printer-line me-1"></i> ' . lang('print') . '</button>';
            } else {
                echo '<div class="alert alert-warning"><strong>' . lang('no_product_selected') . '</strong></div>';
            }
        }
        ?>
    </div>
</div>

<script>
var ac = false, bcitems = {};
if (localStorage.getItem('bcitems')) {
    bcitems = JSON.parse(localStorage.getItem('bcitems'));
}
<?php if ($items): ?>
localStorage.setItem('bcitems', JSON.stringify(<?= $items; ?>));
<?php endif; ?>

function formatDecimal(x) {
    return parseFloat(parseFloat(x).toFixed(2));
}

$(document).ready(function () {
    <?php if ($this->input->post('print')): ?>
    $(window).on('load', function () {
        $('html, body').animate({ scrollTop: ($('#barcode-con').offset().top) - 15 }, 1000);
    });
    <?php endif; ?>

    if (localStorage.getItem('bcitems')) loadItems();

    // Autocomplete
    $('#add_item').autocomplete({
        source: '<?= admin_url('products/get_suggestions'); ?>',
        minLength: 1,
        autoFocus: false,
        delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0] && ui.content[0].id == 0) {
                bootbox.alert('<?= lang('no_product_found'); ?>', function () { $('#add_item').focus(); });
                $(this).val('');
            } else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close');
                $(this).removeClass('ui-autocomplete-loading');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            if (ui.item.id !== 0) {
                if (add_product_item(ui.item)) $(this).val('');
            } else {
                bootbox.alert('<?= lang('no_product_found'); ?>');
            }
        }
    });

    // Style change
    $('#style').on('change', function () {
        localStorage.setItem('bcstyle', $(this).val());
        $(this).val() == 50 ? $('.cf-con').slideDown() : $('.cf-con').slideUp();
    });
    if (var_style = localStorage.getItem('bcstyle')) {
        $('#style').val(var_style);
        if (typeof $.fn.select2 !== 'undefined') $('#style').select2('val', var_style);
        if (var_style == 50) $('.cf-con').slideDown(); else $('.cf-con').slideUp();
    }

    // CF dimensions persist
    $('#cf_width').on('change', function () { localStorage.setItem('cf_width', $(this).val()); });
    if (cf_width = localStorage.getItem('cf_width')) $('#cf_width').val(cf_width);
    $('#cf_height').on('change', function () { localStorage.setItem('cf_height', $(this).val()); });
    if (cf_height = localStorage.getItem('cf_height')) $('#cf_height').val(cf_height);
    $('#cf_orientation').on('change', function () { localStorage.setItem('cf_orientation', $(this).val()); });
    if (cf_orientation = localStorage.getItem('cf_orientation')) $('#cf_orientation').val(cf_orientation);

    // Checkbox persistence
    var boolChecks = ['site_name','product_name','price','currencies','unit','category','check_promo','product_image','variants'];
    boolChecks.forEach(function (n) {
        $('#' + n).on('change', function () {
            localStorage.setItem('bc' + n, this.checked ? 1 : 0);
        });
        var v = localStorage.getItem('bc' + n);
        if (v !== null) { $('#' + n).prop('checked', v == 1); }
    });

    // Row variants checkboxes
    $(document).on('change', '.checkbox', function () {
        var item_id = $(this).attr('data-item-id');
        var vt_id   = $(this).attr('id');
        bcitems[item_id]['selected_variants'][vt_id] = this.checked ? 1 : 0;
        localStorage.setItem('bcitems', JSON.stringify(bcitems));
    });

    // Delete row
    $(document).on('click', '.del', function () {
        var id = $(this).attr('id');
        delete bcitems[id];
        localStorage.setItem('bcitems', JSON.stringify(bcitems));
        $(this).closest('#row_' + id).remove();
    });

    // Reset
    $('#reset').on('click', function () {
        bootbox.confirm(lang.r_u_sure, function (result) {
            if (result) {
                ['bcitems','bcstyle','bcsite_name','bcproduct_name','bcprice','bccurrencies','bcunit','bccategory','bccheck_promo','bcproduct_image','bcvariants'].forEach(function (k) {
                    localStorage.removeItem(k);
                });
                window.location.replace('<?= admin_url('products/print_barcodes'); ?>');
            }
        });
    });

    // Qty change
    var old_row_qty;
    $(document).on('focus', '.quantity', function () { old_row_qty = $(this).val(); });
    $(document).on('change', '.quantity', function () {
        var row     = $(this).closest('tr');
        var new_qty = parseFloat($(this).val());
        if (isNaN(new_qty)) { $(this).val(old_row_qty); bootbox.alert(lang.unexpected_value); return; }
        var item_id = row.attr('data-item-id');
        bcitems[item_id].qty = new_qty;
        localStorage.setItem('bcitems', JSON.stringify(bcitems));
    });
});

function add_product_item(item) {
    ac = true;
    if (!item) return false;
    var item_id = item.id;
    if (bcitems[item_id]) {
        bcitems[item_id].qty = parseFloat(bcitems[item_id].qty) + 1;
    } else {
        bcitems[item_id] = item;
        bcitems[item_id]['selected_variants'] = {};
        if (item.variants) {
            $.each(item.variants, function () {
                bcitems[item_id]['selected_variants'][this.id] = 1;
            });
        }
    }
    localStorage.setItem('bcitems', JSON.stringify(bcitems));
    loadItems();
    return true;
}

function loadItems() {
    if (!localStorage.getItem('bcitems')) return;
    $('#bcTable tbody').empty();
    bcitems = JSON.parse(localStorage.getItem('bcitems'));
    $.each(bcitems, function () {
        var item   = this;
        var row_no = item.id;
        var vd     = '';
        var newTr  = $('<tr id="row_' + row_no + '" class="row_' + item.id + '" data-item-id="' + item.id + '"></tr>');
        var tr_html = '<td><input name="product[]" type="hidden" value="' + item.id + '">'
                    + '<span id="name_' + row_no + '">' + item.name + ' (' + item.code + ')</span></td>';
        tr_html += '<td><input class="form-control form-control-sm quantity text-center" name="quantity[]" type="text" value="' + formatDecimal(item.qty) + '" data-id="' + row_no + '" data-item="' + item.id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
        if (item.variants) {
            $.each(item.variants, function () {
                vd += '<div class="form-check form-check-inline"><input type="checkbox" class="form-check-input checkbox" id="' + this.id + '" data-item-id="' + item.id + '" value="' + this.id + '"'
                    + (item.selected_variants[this.id] == 1 ? ' checked' : '') + '>'
                    + '<label class="form-check-label" for="' + this.id + '">' + this.name + '</label></div>';
            });
        }
        tr_html += '<td>' + vd + '</td>';
        tr_html += '<td class="text-center"><i class="ri-close-line text-danger del" id="' + row_no + '" style="cursor:pointer;" title="<?= lang('remove'); ?>"></i></td>';
        newTr.html(tr_html);
        newTr.appendTo('#bcTable');
    });
}
</script>
