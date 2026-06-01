<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$wm = ['0' => lang('no'), '1' => lang('yes')];
$ps = ['0' => lang('disable'), '1' => lang('enable')];
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-settings-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('system_settings') ?: 'Paramètres système'); ?></h4>
        <p class="mb-0 text-muted">Configuration générale de l'application, formats, e-mails et options métier.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('system_settings') ?: 'Paramètres système'; ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <button type="submit" form="settingsForm" name="update_settings" value="1" class="btn btn-primary">
            <i class="ri ri-save-line me-1" style="font-size:16px"></i><?= lang('update_settings') ?: 'Enregistrer'; ?>
        </button>
    </div>
</div>

<?php echo admin_form_open('system_settings', ['id' => 'settingsForm', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']); ?>

<div class="row">
    <!-- Vertical Nav Pills -->
    <div class="col-md-3 col-lg-2 mb-4">
        <div class="nav flex-column nav-pills me-3" id="settingsNav" role="tablist" aria-orientation="vertical">
            <button class="nav-link active text-start mb-1" id="tab-general-tab" data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab">
                <i class="icon-base ri ri-settings-3-line icon-20px me-2"></i><?= lang('site_config') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-products-tab" data-bs-toggle="pill" data-bs-target="#tab-products" type="button" role="tab">
                <i class="icon-base ri ri-shopping-bag-line icon-20px me-2"></i><?= lang('products') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-sales-tab" data-bs-toggle="pill" data-bs-target="#tab-sales" type="button" role="tab">
                <i class="icon-base ri ri-file-list-3-line icon-20px me-2"></i><?= lang('sales') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-prefix-tab" data-bs-toggle="pill" data-bs-target="#tab-prefix" type="button" role="tab">
                <i class="icon-base ri ri-price-tag-3-line icon-20px me-2"></i><?= lang('prefix') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-format-tab" data-bs-toggle="pill" data-bs-target="#tab-format" type="button" role="tab">
                <i class="icon-base ri ri-money-dollar-circle-line icon-20px me-2"></i><?= lang('money_number_format') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-email-tab" data-bs-toggle="pill" data-bs-target="#tab-email" type="button" role="tab">
                <i class="icon-base ri ri-mail-send-line icon-20px me-2"></i><?= lang('email') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-points-tab" data-bs-toggle="pill" data-bs-target="#tab-points" type="button" role="tab">
                <i class="icon-base ri ri-award-line icon-20px me-2"></i><?= lang('award_points') ?>
            </button>
            <button class="nav-link text-start mb-1" id="tab-barcode-tab" data-bs-toggle="pill" data-bs-target="#tab-barcode" type="button" role="tab">
                <i class="icon-base ri ri-barcode-line icon-20px me-2"></i><?= lang('weighing_scale_barcode') ?>
            </button>
        </div>
    </div>
    <!-- / Vertical Nav Pills -->

    <!-- Tab Content -->
    <div class="col-md-9 col-lg-10">
        <div class="tab-content" id="settingsNavContent">

            <!-- General / Site Config -->
            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-settings-3-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('site_config') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="site_name"><?= lang('site_name') ?></label>
                                <?= form_input('site_name', $Settings->site_name, 'class="form-control" id="site_name" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="language"><?= lang('language') ?></label>
                                <?php
                                $lang_opts = [
                                    'arabic'               => 'Arabic',
                                    'english'              => 'English',
                                    'french'               => 'French',
                                    'german'               => 'German',
                                    'indonesian'           => 'Indonesian',
                                    'portuguese-brazilian' => 'Portuguese (Brazil)',
                                    'simplified-chinese'   => 'Simplified Chinese',
                                    'spanish'              => 'Spanish',
                                    'thai'                 => 'Thai',
                                    'traditional-chinese'  => 'Traditional Chinese',
                                    'turkish'              => 'Turkish',
                                    'vietnamese'           => 'Vietnamese',
                                ];
                                echo form_dropdown('language', $lang_opts, $Settings->language, 'class="form-select" id="language" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="currency"><?= lang('default_currency') ?></label>
                                <?php
                                $cu = [];
                                foreach ($currencies as $currency) {
                                    $cu[$currency->code] = $currency->name;
                                }
                                echo form_dropdown('currency', $cu, $Settings->default_currency, 'class="form-select" id="currency" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="accounting_method"><?= lang('accounting_method') ?></label>
                                <?php
                                $am = [0 => 'FIFO (First In First Out)', 1 => 'LIFO (Last In First Out)', 2 => 'AVCO (Average Cost Method)'];
                                echo form_dropdown('accounting_method', $am, $Settings->accounting_method, 'class="form-select" id="accounting_method" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="email"><?= lang('default_email') ?></label>
                                <?= form_input('email', $Settings->default_email, 'class="form-control" id="email" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="customer_group"><?= lang('default_customer_group') ?></label>
                                <?php
                                $pgs = [];
                                foreach ($customer_groups as $cg) {
                                    $pgs[$cg->id] = $cg->name;
                                }
                                echo form_dropdown('customer_group', $pgs, $Settings->customer_group, 'class="form-select" id="customer_group" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="price_group"><?= lang('default_price_group') ?></label>
                                <?php
                                $cgs = [];
                                foreach ($price_groups as $pg) {
                                    $cgs[$pg->id] = $pg->name;
                                }
                                echo form_dropdown('price_group', $cgs, $Settings->price_group, 'class="form-select" id="price_group" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="warehouse"><?= lang('default_warehouse') ?></label>
                                <?php
                                $wh = [];
                                foreach ($warehouses as $warehouse) {
                                    $wh[$warehouse->id] = $warehouse->name . ' (' . $warehouse->code . ')';
                                }
                                echo form_dropdown('warehouse', $wh, $Settings->default_warehouse, 'class="form-select" id="warehouse" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="biller"><?= lang('default_biller') ?></label>
                                <?php
                                $bl = ['' => ''];
                                foreach ($billers as $biller) {
                                    $bl[$biller->id] = ($biller->company && $biller->company != '-') ? $biller->company : $biller->name;
                                }
                                echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller), 'class="form-select" id="biller"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="mmode"><?= lang('maintenance_mode') ?></label>
                                <?= form_dropdown('mmode', $wm, ($_POST['mmode'] ?? $Settings->mmode), 'class="form-select" id="mmode" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="theme"><?= lang('theme') ?></label>
                                <?php
                                $themes = ['default' => 'Default', 'materialize' => 'Materialize'];
                                echo form_dropdown('theme', $themes, $Settings->theme, 'class="form-select" id="theme" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="rtl"><?= lang('rtl_support') ?></label>
                                <?= form_dropdown('rtl', $ps, $Settings->rtl, 'class="form-select" id="rtl" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="captcha"><?= lang('login_captcha') ?></label>
                                <?= form_dropdown('captcha', $ps, $Settings->captcha, 'class="form-select" id="captcha" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="disable_editing"><?= lang('disable_editing') ?></label>
                                <?= form_input('disable_editing', $Settings->disable_editing, 'class="form-control" id="disable_editing" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="rows_per_page"><?= lang('rows_per_page') ?></label>
                                <?php
                                $rppopts = ['10' => '10', '25' => '25', '50' => '50', '100' => '100', '-1' => lang('all') . ' (' . lang('not_recommended') . ')'];
                                echo form_dropdown('rows_per_page', $rppopts, $Settings->rows_per_page, 'class="form-select" id="rows_per_page" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="dateformat"><?= lang('dateformat') ?></label>
                                <?php
                                $dt = [];
                                foreach ($date_formats as $df) {
                                    $dt[$df->id] = $df->js;
                                }
                                echo form_dropdown('dateformat', $dt, $Settings->dateformat, 'class="form-select" id="dateformat" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="timezone"><?= lang('timezone') ?></label>
                                <?php
                                $tz = [];
                                foreach (DateTimeZone::listIdentifiers(DateTimeZone::ALL) as $tzi) {
                                    $tz[$tzi] = $tzi;
                                }
                                echo form_dropdown('timezone', $tz, TIMEZONE, 'class="form-select" id="timezone" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="restrict_calendar"><?= lang('calendar') ?></label>
                                <?php
                                $opt_cal = [1 => lang('private'), 0 => lang('shared')];
                                echo form_dropdown('restrict_calendar', $opt_cal, $Settings->restrict_calendar, 'class="form-select" id="restrict_calendar" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="pdf_lib"><?= lang('pdf_lib') ?></label>
                                <?php $pdflibs = ['mpdf' => 'mPDF', 'dompdf' => 'Dompdf']; ?>
                                <?= form_dropdown('pdf_lib', $pdflibs, $Settings->pdf_lib, 'class="form-select" id="pdf_lib" required="required"') ?>
                            </div>
                            <?php if (defined('SHOP') && SHOP): ?>
                            <div class="col-md-4">
                                <label class="form-label" for="apis"><?= lang('apis_feature') ?></label>
                                <?= form_dropdown('apis', $ps, $Settings->apis, 'class="form-select" id="apis" required="required"') ?>
                            </div>
                            <?php endif; ?>
                            <div class="col-md-4">
                                <label class="form-label" for="code_slig"><?= lang('use_code_for_slug') ?></label>
                                <?= form_dropdown('use_code_for_slug', $ps, $Settings->use_code_for_slug, 'class="form-select" id="code_slig" required="required"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / General -->

            <!-- Products -->
            <div class="tab-pane fade" id="tab-products" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-shopping-bag-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('products') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="tax_rate"><?= lang('product_tax') ?></label>
                                <?= form_dropdown('tax_rate', $ps, $Settings->default_tax_rate, 'class="form-select" id="tax_rate" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="racks"><?= lang('racks') ?></label>
                                <?= form_dropdown('racks', $ps, $Settings->racks, 'class="form-select" id="racks" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="attributes"><?= lang('attributes') ?></label>
                                <?= form_dropdown('attributes', $ps, $Settings->attributes, 'class="form-select" id="attributes" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product_expiry"><?= lang('product_expiry') ?></label>
                                <?= form_dropdown('product_expiry', $ps, $Settings->product_expiry, 'class="form-select" id="product_expiry" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="remove_expired"><?= lang('remove_expired') ?></label>
                                <?php
                                $re_opts = [0 => lang('no') . ', ' . lang('i_ll_remove'), 1 => lang('yes') . ', ' . lang('remove_automatically')];
                                echo form_dropdown('remove_expired', $re_opts, $Settings->remove_expired, 'class="form-select" id="remove_expired" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><?= lang('image_size') ?> (Width : Height)</label>
                                <div class="input-group">
                                    <?= form_input('iwidth', $Settings->iwidth, 'class="form-control" id="iwidth" placeholder="Width" required="required"') ?>
                                    <span class="input-group-text">:</span>
                                    <?= form_input('iheight', $Settings->iheight, 'class="form-control" id="iheight" placeholder="Height" required="required"') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label"><?= lang('thumbnail_size') ?> (Width : Height)</label>
                                <div class="input-group">
                                    <?= form_input('twidth', $Settings->twidth, 'class="form-control" id="twidth" placeholder="Width" required="required"') ?>
                                    <span class="input-group-text">:</span>
                                    <?= form_input('theight', $Settings->theight, 'class="form-control" id="theight" placeholder="Height" required="required"') ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="watermark"><?= lang('watermark') ?></label>
                                <?= form_dropdown('watermark', $wm, ($_POST['watermark'] ?? $Settings->watermark), 'class="form-select" id="watermark" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="display_all_products"><?= lang('display_all_products') ?></label>
                                <?php
                                $dopts = [0 => lang('hide_with_0_qty'), 1 => lang('show_with_0_qty')];
                                echo form_dropdown('display_all_products', $dopts, ($_POST['display_all_products'] ?? $Settings->display_all_products), 'class="form-select" id="display_all_products" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="barcode_separator"><?= lang('barcode_separator') ?></label>
                                <?php
                                $bcopts = ['-' => lang('dash'), '.' => lang('dot'), '~' => lang('tilde'), '_' => lang('underscore')];
                                echo form_dropdown('barcode_separator', $bcopts, ($_POST['barcode_separator'] ?? $Settings->barcode_separator), 'class="form-select" id="barcode_separator" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="barcode_renderer"><?= lang('barcode_renderer') ?></label>
                                <?php
                                $bcropts = [1 => lang('image'), 0 => lang('svg')];
                                echo form_dropdown('barcode_renderer', $bcropts, ($_POST['barcode_renderer'] ?? $Settings->barcode_img), 'class="form-select" id="barcode_renderer" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="update_cost"><?= lang('update_cost_with_purchase') ?></label>
                                <?= form_dropdown('update_cost', $wm, $Settings->update_cost, 'class="form-select" id="update_cost" required="required"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Products -->

            <!-- Sales -->
            <div class="tab-pane fade" id="tab-sales" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-file-list-3-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('sales') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="overselling"><?= lang('over_selling') ?></label>
                                <?php
                                $opt = [1 => lang('yes'), 0 => lang('no')];
                                echo form_dropdown('restrict_sale', $opt, $Settings->overselling, 'class="form-select" id="overselling" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="reference_format"><?= lang('reference_format') ?></label>
                                <?php
                                $ref = [1 => lang('prefix_year_no'), 2 => lang('prefix_month_year_no'), 3 => lang('sequence_number'), 4 => lang('random_number')];
                                echo form_dropdown('reference_format', $ref, $Settings->reference_format, 'class="form-select" id="reference_format" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="tax_rate2"><?= lang('invoice_tax') ?></label>
                                <?php
                                $tr = ['0' => lang('disable')];
                                foreach ($tax_rates as $rate) {
                                    $tr[$rate->id] = $rate->name;
                                }
                                echo form_dropdown('tax_rate2', $tr, $Settings->default_tax_rate2, 'class="form-select" id="tax_rate2" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product_discount"><?= lang('product_level_discount') ?></label>
                                <?= form_dropdown('product_discount', $ps, $Settings->product_discount, 'class="form-select" id="product_discount" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="product_serial"><?= lang('product_serial') ?></label>
                                <?= form_dropdown('product_serial', $ps, $Settings->product_serial, 'class="form-select" id="product_serial" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="detect_barcode"><?= lang('auto_detect_barcode') ?></label>
                                <?= form_dropdown('detect_barcode', $ps, $Settings->auto_detect_barcode, 'class="form-select" id="detect_barcode" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="bc_fix"><?= lang('bc_fix') ?></label>
                                <?= form_input('bc_fix', $Settings->bc_fix, 'class="form-control" id="bc_fix" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="item_addition"><?= lang('item_addition') ?></label>
                                <?php
                                $ia = [0 => lang('add_new_item'), 1 => lang('increase_quantity_if_item_exist')];
                                echo form_dropdown('item_addition', $ia, $Settings->item_addition, 'class="form-select" id="item_addition" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="set_focus"><?= lang('set_focus') ?></label>
                                <?php
                                $sfopts = [0 => lang('add_item_input'), 1 => lang('last_order_item')];
                                echo form_dropdown('set_focus', $sfopts, ($_POST['set_focus'] ?? $Settings->set_focus), 'class="form-select" id="set_focus" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="ksa_qrcode"><?= lang('ksa_qrcode') ?></label>
                                <?= form_dropdown('ksa_qrcode', $ps, $Settings->ksa_qrcode, 'class="form-select" id="ksa_qrcode" required="required"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="invoice_view"><?= lang('invoice_view') ?></label>
                                <?php
                                $opt_inv = [1 => lang('tax_invoice'), 0 => lang('standard'), 2 => lang('indian_gst')];
                                echo form_dropdown('invoice_view', $opt_inv, $Settings->invoice_view, 'class="form-select" id="invoice_view" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4" id="states" style="display:none;">
                                <label class="form-label" for="state"><?= lang('biz_state') ?></label>
                                <?php
                                if (method_exists($this, 'gst')) {
                                    $states = $this->gst->getIndianStates();
                                    echo form_dropdown('state', $states, $Settings->state, 'class="form-select" id="state" required="required"');
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Sales -->

            <!-- Prefix -->
            <div class="tab-pane fade" id="tab-prefix" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-price-tag-3-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('prefix') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="sales_prefix"><?= lang('sales_prefix') ?></label>
                                <?= form_input('sales_prefix', $Settings->sales_prefix, 'class="form-control" id="sales_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="return_prefix"><?= lang('return_prefix') ?></label>
                                <?= form_input('return_prefix', $Settings->return_prefix, 'class="form-control" id="return_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="payment_prefix"><?= lang('payment_prefix') ?></label>
                                <?= form_input('payment_prefix', $Settings->payment_prefix, 'class="form-control" id="payment_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="ppayment_prefix"><?= lang('ppayment_prefix') ?></label>
                                <?= form_input('ppayment_prefix', $Settings->ppayment_prefix, 'class="form-control" id="ppayment_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="delivery_prefix"><?= lang('delivery_prefix') ?></label>
                                <?= form_input('delivery_prefix', $Settings->delivery_prefix, 'class="form-control" id="delivery_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="quote_prefix"><?= lang('quote_prefix') ?></label>
                                <?= form_input('quote_prefix', $Settings->quote_prefix, 'class="form-control" id="quote_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="purchase_prefix"><?= lang('purchase_prefix') ?></label>
                                <?= form_input('purchase_prefix', $Settings->purchase_prefix, 'class="form-control" id="purchase_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="returnp_prefix"><?= lang('returnp_prefix') ?></label>
                                <?= form_input('returnp_prefix', $Settings->returnp_prefix, 'class="form-control" id="returnp_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="transfer_prefix"><?= lang('transfer_prefix') ?></label>
                                <?= form_input('transfer_prefix', $Settings->transfer_prefix, 'class="form-control" id="transfer_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="expense_prefix"><?= lang('expense_prefix') ?></label>
                                <?= form_input('expense_prefix', $Settings->expense_prefix, 'class="form-control" id="expense_prefix"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="qa_prefix"><?= lang('qa_prefix') ?></label>
                                <?= form_input('qa_prefix', $Settings->qa_prefix, 'class="form-control" id="qa_prefix"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Prefix -->

            <!-- Money / Number Format -->
            <div class="tab-pane fade" id="tab-format" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-money-dollar-circle-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('money_number_format') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="decimals"><?= lang('decimals') ?></label>
                                <?php
                                $decimals_opts = [0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                echo form_dropdown('decimals', $decimals_opts, $Settings->decimals, 'class="form-select" id="decimals" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="qty_decimals"><?= lang('qty_decimals') ?></label>
                                <?php
                                $qty_dec = [0 => lang('disable'), 1 => '1', 2 => '2', 3 => '3', 4 => '4'];
                                echo form_dropdown('qty_decimals', $qty_dec, $Settings->qty_decimals, 'class="form-select" id="qty_decimals" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="sac"><?= lang('sac') ?></label>
                                <?= form_dropdown('sac', $ps, set_value('sac', $Settings->sac), 'class="form-select" id="sac" required="required"') ?>
                            </div>
                            <div class="col-12 nsac" id="nsac-fields">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="decimals_sep"><?= lang('decimals_sep') ?></label>
                                        <?php
                                        $dec_point = ['.' => lang('dot'), ',' => lang('comma')];
                                        echo form_dropdown('decimals_sep', $dec_point, $Settings->decimals_sep, 'class="form-select" id="decimals_sep" required="required"');
                                        ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="thousands_sep"><?= lang('thousands_sep') ?></label>
                                        <?php
                                        $thousands_sep = ['.' => lang('dot'), ',' => lang('comma'), '0' => lang('space')];
                                        echo form_dropdown('thousands_sep', $thousands_sep, $Settings->thousands_sep, 'class="form-select" id="thousands_sep" required="required"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="display_symbol"><?= lang('display_currency_symbol') ?></label>
                                <?php
                                $sym_opts = [0 => lang('disable'), 1 => lang('before'), 2 => lang('after')];
                                echo form_dropdown('display_symbol', $sym_opts, $Settings->display_symbol, 'class="form-select" id="display_symbol" required="required"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="symbol"><?= lang('currency_symbol') ?></label>
                                <?= form_input('symbol', $Settings->symbol, 'class="form-control" id="symbol"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Money Format -->

            <!-- Email -->
            <div class="tab-pane fade" id="tab-email" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-mail-send-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('email') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="protocol"><?= lang('email_protocol') ?></label>
                                <?php
                                $popt = ['mail' => 'PHP Mail Function', 'sendmail' => 'Send Mail', 'smtp' => 'SMTP'];
                                echo form_dropdown('protocol', $popt, $Settings->protocol, 'class="form-select" id="protocol" required="required"');
                                ?>
                            </div>
                            <!-- Sendmail config -->
                            <div class="col-12" id="sendmail_config" style="display:none;">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="mailpath"><?= lang('mailpath') ?></label>
                                        <?= form_input('mailpath', $Settings->mailpath, 'class="form-control" id="mailpath"') ?>
                                    </div>
                                </div>
                            </div>
                            <!-- SMTP config -->
                            <div class="col-12" id="smtp_config" style="display:none;">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="smtp_host"><?= lang('smtp_host') ?></label>
                                        <?= form_input('smtp_host', $Settings->smtp_host, 'class="form-control" id="smtp_host"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="smtp_user"><?= lang('smtp_user') ?></label>
                                        <?= form_input('smtp_user', $Settings->smtp_user, 'class="form-control" id="smtp_user"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="smtp_pass"><?= lang('smtp_pass') ?></label>
                                        <?= form_password('smtp_pass', $Settings->smtp_pass, 'class="form-control" id="smtp_pass"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="smtp_port"><?= lang('smtp_port') ?></label>
                                        <?= form_input('smtp_port', $Settings->smtp_port, 'class="form-control" id="smtp_port"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="smtp_crypto"><?= lang('smtp_crypto') ?></label>
                                        <?php
                                        $crypto_opt = ['' => lang('none'), 'tls' => 'TLS', 'ssl' => 'SSL'];
                                        echo form_dropdown('smtp_crypto', $crypto_opt, $Settings->smtp_crypto, 'class="form-select" id="smtp_crypto"');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Email -->

            <!-- Award Points -->
            <div class="tab-pane fade" id="tab-points" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-award-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('award_points') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <h6 class="mb-3"><?= lang('customer_award_points') ?></h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-fill">
                                        <label class="form-label"><?= lang('each_spent') ?></label>
                                        <?= form_input('each_spent', $this->sma->formatDecimal($Settings->each_spent), 'class="form-control"') ?>
                                    </div>
                                    <div class="pt-4">
                                        <i class="icon-base ri ri-arrow-right-line icon-20px text-muted"></i>
                                    </div>
                                    <div class="flex-fill">
                                        <label class="form-label"><?= lang('award_points') ?></label>
                                        <?= form_input('ca_point', $Settings->ca_point, 'class="form-control"') ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3"><?= lang('staff_award_points') ?></h6>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="flex-fill">
                                        <label class="form-label"><?= lang('each_in_sale') ?></label>
                                        <?= form_input('each_sale', $this->sma->formatDecimal($Settings->each_sale), 'class="form-control"') ?>
                                    </div>
                                    <div class="pt-4">
                                        <i class="icon-base ri ri-arrow-right-line icon-20px text-muted"></i>
                                    </div>
                                    <div class="flex-fill">
                                        <label class="form-label"><?= lang('award_points') ?></label>
                                        <?= form_input('sa_point', $Settings->sa_point, 'class="form-control"') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Award Points -->

            <!-- Weighing Scale Barcode -->
            <div class="tab-pane fade" id="tab-barcode" role="tabpanel">
                <div class="card mb-4">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-barcode-line icon-20px me-2"></i>
                        <h5 class="card-title mb-0"><?= lang('weighing_scale_barcode') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label" for="ws_barcode_type"><?= lang('ws_barcode_type') ?></label>
                                <?php
                                $ws_bt = ['weight' => lang('weight_qty'), 'price' => lang('price')];
                                echo form_dropdown('ws_barcode_type', $ws_bt, $Settings->ws_barcode_type, 'class="form-select" id="ws_barcode_type"');
                                ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="ws_barcode_chars"><?= lang('ws_barcode_chars') ?></label>
                                <?= form_input('ws_barcode_chars', $Settings->ws_barcode_chars, 'class="form-control" id="ws_barcode_chars"') ?>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label" for="flag_chars"><?= lang('flag_chars') ?></label>
                                <?= form_input('flag_chars', $Settings->flag_chars, 'class="form-control" id="flag_chars"') ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="item_code_start"><?= lang('item_code_start') ?></label>
                                <?= form_input('item_code_start', $Settings->item_code_start, 'class="form-control" id="item_code_start"') ?>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="item_code_chars"><?= lang('item_code_chars') ?></label>
                                <?= form_input('item_code_chars', $Settings->item_code_chars, 'class="form-control" id="item_code_chars"') ?>
                            </div>
                            <!-- Price fields -->
                            <div class="col-12" id="ws_price">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="price_start"><?= lang('price_start') ?></label>
                                        <?= form_input('price_start', $Settings->price_start, 'class="form-control" id="price_start"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="price_chars"><?= lang('price_chars') ?></label>
                                        <?= form_input('price_chars', $Settings->price_chars, 'class="form-control" id="price_chars"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="price_divide_by"><?= lang('price_divide_by') ?></label>
                                        <?= form_input('price_divide_by', $Settings->price_divide_by, 'class="form-control" id="price_divide_by"') ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Weight fields -->
                            <div class="col-12" id="ws_weight">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label" for="weight_start"><?= lang('weight_start') ?></label>
                                        <?= form_input('weight_start', $Settings->weight_start, 'class="form-control" id="weight_start"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="weight_chars"><?= lang('weight_chars') ?></label>
                                        <?= form_input('weight_chars', $Settings->weight_chars, 'class="form-control" id="weight_chars"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="weight_divide_by"><?= lang('weight_divide_by') ?></label>
                                        <?= form_input('weight_divide_by', $Settings->weight_divide_by, 'class="form-control" id="weight_divide_by"') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / Weighing Scale Barcode -->

        </div><!-- /.tab-content -->

        <!-- Save Button -->
        <div class="d-flex justify-content-end mb-4">
            <?= form_submit('update_settings', lang('update_settings'), 'class="btn btn-primary"') ?>
        </div>

    </div><!-- /.col -->
</div><!-- /.row -->

<?= form_close() ?>

<?php if (!defined('DEMO') || !DEMO): ?>
<div class="alert alert-info d-flex align-items-start gap-3" role="alert">
    <i class="icon-base ri ri-information-line icon-20px mt-1 flex-shrink-0"></i>
    <div>
        <strong>Cron Job</strong> (run at 1:00 AM daily):<br>
        <code>0 1 * * * wget -qO- <?= admin_url('cron/run') ?> &gt;/dev/null 2&gt;&amp;1</code>
        <a class="btn btn-sm btn-label-primary ms-3" target="_blank" href="<?= admin_url('cron/run') ?>">Run now</a>
    </div>
</div>
<?php endif; ?>

<script>
$(document).ready(function () {
    // Timezone autocomplete
    var timezones = <?= json_encode(DateTimeZone::listIdentifiers(DateTimeZone::ALL)) ?>;

    // Protocol toggle
    function toggleProtocol(val) {
        if (val === 'smtp') {
            $('#sendmail_config').hide();
            $('#smtp_config').slideDown();
        } else if (val === 'sendmail') {
            $('#smtp_config').hide();
            $('#sendmail_config').slideDown();
        } else {
            $('#smtp_config').slideUp();
            $('#sendmail_config').slideUp();
        }
    }
    toggleProtocol($('#protocol').val());
    $('#protocol').change(function () { toggleProtocol($(this).val()); });

    // SAC toggle
    function toggleSac(val) {
        if (val == 1) {
            $('#nsac-fields').slideUp();
        } else {
            $('#nsac-fields').slideDown();
        }
    }
    toggleSac($('#sac').val());
    $('#sac').change(function () { toggleSac($(this).val()); });

    // Invoice view states
    function toggleStates(val) {
        if (val == 2) { $('#states').show(); } else { $('#states').hide(); }
    }
    toggleStates($('#invoice_view').val());
    $('#invoice_view').change(function () { toggleStates($(this).val()); });

    // Barcode type toggle
    function toggleBarcodeType(val) {
        if (val === 'price') {
            $('#ws_price').show();
            $('#ws_weight').hide();
        } else {
            $('#ws_weight').show();
            $('#ws_price').hide();
        }
    }
    toggleBarcodeType($('#ws_barcode_type').val());
    $('#ws_barcode_type').change(function () { toggleBarcodeType($(this).val()); });

    // Overselling / accounting method alert
    $('#overselling').change(function () {
        if ($(this).val() == 1 && $('#accounting_method').val() != 2) {
            alert('<?= lang('overselling_will_only_work_with_AVCO_accounting_method_only') ?>');
            $('#accounting_method').val('2');
        }
    });
    $('#accounting_method').change(function () {
        var oam = <?= $Settings->accounting_method ?>, nam = parseInt($(this).val());
        if (oam != nam) {
            alert('<?= lang('accounting_method_change_alert') ?>');
        }
        if (nam != 2 && $('#overselling').val() == 1) {
            alert('<?= lang('overselling_will_only_work_with_AVCO_accounting_method_only') ?>');
            $('#overselling').val(0);
        }
    });
    $('#item_addition').change(function () {
        if ($(this).val() == 1) {
            alert('<?= lang('product_variants_feature_x') ?>');
        }
    });
});
</script>
