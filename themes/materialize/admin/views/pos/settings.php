<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-settings-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('pos_settings') ?: 'Paramètres POS' ?></h4>
    <p class="mb-0 text-muted">Configuration de la caisse, taxes, paiements et imprimantes</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>">Accueil</a></li>
        <li class="breadcrumb-item">POS</li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('settings') ?></li>
      </ol>
    </nav>
  </div>
</div>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos_setting'];
echo admin_form_open('pos/settings', $attrib);
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs mb-4" id="posSettingsTabs" role="tablist">
  <li class="nav-item" role="presentation">
    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-panel" type="button" role="tab">
      <span class="icon-base ri ri-settings-2-line me-1 icon-16px"></span><?= lang('pos_config'); ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="printing-tab" data-bs-toggle="tab" data-bs-target="#printing-panel" type="button" role="tab">
      <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('pos_printing'); ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="shortcuts-tab" data-bs-toggle="tab" data-bs-target="#shortcuts-panel" type="button" role="tab">
      <span class="icon-base ri ri-keyboard-line me-1 icon-16px"></span><?= lang('shortcuts'); ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom-panel" type="button" role="tab">
      <span class="icon-base ri ri-layout-4-line me-1 icon-16px"></span><?= lang('custom_fileds'); ?>
    </button>
  </li>
  <li class="nav-item" role="presentation">
    <button class="nav-link" id="gateways-tab" data-bs-toggle="tab" data-bs-target="#gateways-panel" type="button" role="tab">
      <span class="icon-base ri ri-bank-card-line me-1 icon-16px"></span><?= lang('payment_gateways'); ?>
    </button>
  </li>
</ul>

<div class="tab-content">

  <!-- GENERAL CONFIG -->
  <div class="tab-pane fade show active" id="general-panel" role="tabpanel">
    <div class="card">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('pro_limit', $pos->pro_limit, 'class="form-control" id="limit" required placeholder=" "'); ?>
              <label for="limit"><?= lang('pro_limit'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_password('pin_code', $pos->pin_code, 'class="form-control" pattern="[0-9]{4,8}" id="pin_code" placeholder=" "'); ?>
              <label for="pin_code"><?= lang('delete_code'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php
              $ct = ['' => lang('select') . ' ' . lang('default_category')];
              foreach ($categories as $category) { $ct[$category->id] = $category->name; }
              echo form_dropdown('category', $ct, $pos->default_category, 'class="form-select select2" id="default_category" required data-placeholder="' . lang('select_category') . '"');
              ?>
              <label for="default_category"><?= lang('default_category'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php
              $bl = [0 => ''];
              foreach ($billers as $biller) { $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name; }
              echo form_dropdown('biller', $bl, $pos->default_biller, 'class="form-select select2" id="default_biller" required data-placeholder="' . lang('select') . '"');
              ?>
              <label for="default_biller"><?= lang('default_biller'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : $pos->default_customer), 'id="customer1" data-placeholder="' . lang('select') . ' ' . lang('customer') . '" required class="form-control" style="width:100%;" placeholder=" "'); ?>
              <label for="customer1"><?= lang('default_customer'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $yn = ['1' => lang('yes'), '0' => lang('no')];
              echo form_dropdown('display_time', $yn, $pos->display_time, 'class="form-select" id="display_time" required'); ?>
              <label for="display_time"><?= lang('display_time'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_dropdown('keyboard', $yn, $pos->keyboard, 'class="form-select" id="keyboard" required'); ?>
              <label for="keyboard"><?= lang('onscreen_keyboard'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $col = ['default' => lang('default'), 'primary' => lang('primary'), 'info' => lang('info'), 'warning' => lang('warning'), 'danger' => lang('danger')];
              echo form_dropdown('product_button_color', $col, $pos->product_button_color, 'class="form-select" id="product_button_color" required'); ?>
              <label for="product_button_color"><?= lang('product_button_color'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_dropdown('tooltips', $yn, $pos->tooltips, 'class="form-select" id="tooltips" required'); ?>
              <label for="tooltips"><?= lang('tooltips'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $rnd = ['0' => lang('disable'), '1' => lang('to_nearest_005'), '2' => lang('to_nearest_050'), '3' => lang('to_nearest_number'), '4' => lang('to_next_number')];
              echo form_dropdown('rounding', $rnd, $pos->rounding, 'class="form-select" id="rounding" required'); ?>
              <label for="rounding"><?= lang('rounding'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $oopts = [0 => lang('default'), 1 => lang('category')];
              echo form_dropdown('item_order', $oopts, $pos->item_order, 'class="form-select" id="item_order" required'); ?>
              <label for="item_order"><?= lang('item_order'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $popts = [0 => lang('receipt'), 1 => lang('pos')];
              echo form_dropdown('after_sale_page', $popts, $pos->after_sale_page, 'class="form-select" id="after_sale_page" required'); ?>
              <label for="after_sale_page"><?= lang('after_sale_page'); ?></label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?php $cdo = [0 => lang('no'), 1 => lang('yes')];
              echo form_dropdown('customer_details', $cdo, $pos->customer_details, 'class="form-select" id="customer_details" required'); ?>
              <label for="customer_details"><?= lang('display_customer_details'); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PRINTING -->
  <div class="tab-pane fade" id="printing-panel" role="tabpanel">
    <div class="card">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <?php $opts = [0 => lang('local_install'), 1 => lang('web_browser_print'), 3 => lang('php_pos_print_app')];
              echo form_dropdown('remote_printing', $opts, $pos->remote_printing, 'class="form-select select2" id="remote_printing" style="width:100%;" required'); ?>
              <label for="remote_printing"><?= lang('printing'); ?></label>
            </div>
            <small class="text-muted d-block mt-1"><?= lang('print_recommandations'); ?></small>
          </div>

          <div class="printers">
            <div class="col-md-6">
              <div class="form-floating form-floating-outline">
                <?= form_dropdown('auto_print', $yn, $pos->auto_print, 'class="form-select select2" id="auto_print" style="width:100%;"'); ?>
                <label for="auto_print"><?= lang('auto_print'); ?></label>
              </div>
            </div>
            <div class="ppp mt-3">
              <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                  <?= form_dropdown('local_printers', $yn, set_value('local_printers', $pos->local_printers), 'class="form-select" id="local_printers" required'); ?>
                  <label for="local_printers"><?= lang('use_local_printers'); ?></label>
                </div>
              </div>
            </div>
            <div class="lp mt-3">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <?php $printer_opts = [];
                    if (!empty($printers)) { foreach ($printers as $printer) { $printer_opts[$printer->id] = $printer->title; } }
                    echo form_dropdown('receipt_printer', $printer_opts, $pos->printer, 'class="form-select select2" id="receipt_printer" style="width:100%;"'); ?>
                    <label for="receipt_printer"><?= lang('receipt_printer'); ?></label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <?= form_dropdown('order_printers[]', $printer_opts, '', 'multiple class="form-select select2" id="order_printers" style="width:100%;"'); ?>
                    <label for="order_printers"><?= lang('order_printers'); ?></label>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <?= form_input('cash_drawer_codes', $pos->cash_drawer_codes, 'class="form-control" id="cash_drawer_codes" placeholder="\x1C"'); ?>
                    <label for="cash_drawer_codes"><?= lang('cash_drawer_codes'); ?></label>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SHORTCUTS -->
  <div class="tab-pane fade" id="shortcuts-panel" role="tabpanel">
    <div class="card">
      <div class="card-body">
        <p class="text-muted mb-3"><?= lang('shortcut_heading'); ?></p>
        <div class="row g-3">
          <?php
          $shortcuts = [
            'focus_add_item' => lang('focus_add_item'),
            'add_manual_product' => lang('add_manual_product'),
            'customer_selection' => lang('customer_selection'),
            'add_customer' => lang('add_customer'),
            'toggle_category_slider' => lang('toggle_category_slider'),
            'toggle_subcategory_slider' => lang('toggle_subcategory_slider'),
            'toggle_brands_slider' => lang('toggle_brands_slider'),
            'cancel_sale' => lang('cancel_sale'),
            'suspend_sale' => lang('suspend_sale'),
            'print_items_list' => lang('print_items_list'),
            'finalize_sale' => lang('finalize_sale'),
            'today_sale' => lang('today_sale'),
            'open_hold_bills' => lang('open_hold_bills'),
            'close_register' => lang('close_register'),
          ];
          foreach ($shortcuts as $field => $label): ?>
          <div class="col-md-4 col-sm-6">
            <div class="form-floating form-floating-outline">
              <?= form_input($field, $pos->$field, 'class="form-control" id="' . $field . '" placeholder=" "'); ?>
              <label for="<?= $field; ?>"><?= $label; ?></label>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- CUSTOM FIELDS -->
  <div class="tab-pane fade" id="custom-panel" role="tabpanel">
    <div class="card">
      <div class="card-body">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('cf_title1', $pos->cf_title1, 'class="form-control" id="tcf1" placeholder=" "'); ?>
              <label for="tcf1"><?= lang('cf_title1'); ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('cf_value1', $pos->cf_value1, 'class="form-control" id="vcf1" placeholder=" "'); ?>
              <label for="vcf1"><?= lang('cf_value1'); ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('cf_title2', $pos->cf_title2, 'class="form-control" id="tcf2" placeholder=" "'); ?>
              <label for="tcf2"><?= lang('cf_title2'); ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('cf_value2', $pos->cf_value2, 'class="form-control" id="vcf2" placeholder=" "'); ?>
              <label for="vcf2"><?= lang('cf_value2'); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PAYMENT GATEWAYS -->
  <div class="tab-pane fade" id="gateways-panel" role="tabpanel">
    <div class="card">
      <div class="card-body">
        <?php if ($paypal_balance): ?>
          <?php if (!isset($paypal_balance['error'])): ?>
          <div class="alert alert-success alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <strong><?= lang('paypal_balance'); ?></strong>
            <?php foreach ($paypal_balance['amount'] as $bl): ?>
            <br><?= lang('balance'); ?>: <?= $bl['L_AMT']; ?> (<?= $bl['L_CURRENCYCODE']; ?>)
            <?php endforeach; ?>
          </div>
          <?php else: ?>
          <div class="alert alert-danger alert-dismissible fade show">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php foreach ($paypal_balance['message'] as $msg): ?>
            <?= $msg['L_SHORTMESSAGE']; ?> (<?= $msg['L_ERRORCODE']; ?>): <?= $msg['L_LONGMESSAGE']; ?><br>
            <?php endforeach; ?>
          </div>
          <?php endif; ?>
        <?php endif; ?>

        <div class="row g-3">
          <!-- PayPal Pro -->
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_dropdown('paypal_pro', $yn, $pos->paypal_pro, 'class="form-select" id="paypal_pro" required'); ?>
              <label for="paypal_pro"><?= lang('paypal_pro'); ?></label>
            </div>
          </div>
        </div>
        <div id="paypal_pro_con" class="row g-3 mt-1">
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_input('APIUsername', $APIUsername, 'class="form-control" id="APIUsername" placeholder=" "'); ?>
              <label for="APIUsername"><?= lang('APIUsername'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_input('APIPassword', $APIPassword, 'class="form-control" id="APIPassword" placeholder=" "'); ?>
              <label for="APIPassword"><?= lang('APIPassword'); ?></label>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_input('APISignature', $APISignature, 'class="form-control" id="APISignature" placeholder=" "'); ?>
              <label for="APISignature"><?= lang('APISignature'); ?></label>
            </div>
          </div>
        </div>

        <?php if ($stripe_balance): ?>
        <div class="alert alert-success alert-dismissible fade show mt-3">
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          <strong><?= lang('stripe_balance'); ?></strong>
          <?= lang('pending_amount'); ?>: <?= $stripe_balance['pending_amount']; ?> (<?= $stripe_balance['pending_currency']; ?>),
          <?= lang('available_amount'); ?>: <?= $stripe_balance['available_amount']; ?> (<?= $stripe_balance['available_currency']; ?>)
        </div>
        <?php endif; ?>

        <div class="row g-3 mt-1">
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_dropdown('stripe', $yn, $pos->stripe, 'class="form-select" id="stripe" required'); ?>
              <label for="stripe"><?= lang('stripe'); ?></label>
            </div>
          </div>
        </div>
        <div id="stripe_con" class="row g-3 mt-1">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('stripe_secret_key', $stripe_secret_key, 'class="form-control" id="stripe_secret_key" placeholder=" "'); ?>
              <label for="stripe_secret_key"><?= lang('stripe_secret_key'); ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('stripe_publishable_key', $stripe_publishable_key, 'class="form-control" id="stripe_publishable_key" placeholder=" "'); ?>
              <label for="stripe_publishable_key"><?= lang('stripe_publishable_key'); ?></label>
            </div>
          </div>
        </div>

        <div class="row g-3 mt-1">
          <div class="col-md-4">
            <div class="form-floating form-floating-outline">
              <?= form_dropdown('authorize', $yn, $pos->authorize, 'class="form-select" id="authorize" required'); ?>
              <label for="authorize"><?= lang('authorize'); ?></label>
            </div>
          </div>
        </div>
        <div id="authorize_con" class="row g-3 mt-1">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('api_login_id', $api_login_id, 'class="form-control" id="api_login_id" placeholder=" "'); ?>
              <label for="api_login_id"><?= lang('api_login_id'); ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?= form_input('api_transaction_key', $api_transaction_key, 'class="form-control" id="api_transaction_key" placeholder=" "'); ?>
              <label for="api_transaction_key"><?= lang('api_transaction_key'); ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</div><!-- /.tab-content -->

<div class="mt-3">
  <?= form_submit('update_settings', lang('update_settings'), 'class="btn btn-primary"'); ?>
</div>
<?= form_close(); ?>

<script>
$(document).ready(function () {
  $('#customer1').val('<?= $pos->default_customer; ?>').select2({
    minimumInputLength: 1,
    data: [],
    initSelection: function (element, callback) {
      $.ajax({ type: "get", async: false, url: site.base_url + "customers/getCustomer/" + $(element).val(), dataType: "json",
        success: function (data) { callback(data[0]); }
      });
    },
    ajax: {
      url: site.base_url + "customers/suggestions", dataType: 'json', quietMillis: 15,
      data: function (term) { return { term: term, limit: 10 }; },
      results: function (data) { return data.results ? { results: data.results } : { results: [{ id: '', text: 'No Match Found' }] }; }
    }
  });

  $("#order_printers").select2().select2('val', <?= $pos->order_printers; ?>);

  function togglePrinting() {
    var v = $('#remote_printing').val();
    if (v == 1) { $('.printers').slideUp(); }
    else if (v == 0) { $('.printers').slideDown(); $('.ppp').slideUp(); $('.lp').slideDown(); }
    else { $('.printers').slideDown(); $('.ppp').slideDown(); toggleLocalPrinters(); }
  }
  function toggleLocalPrinters() {
    if ($('#local_printers').val() == 1) { $('.lp').slideUp(); } else { $('.lp').slideDown(); }
  }
  togglePrinting();
  $('#remote_printing').change(togglePrinting);
  $('#local_printers').change(toggleLocalPrinters);

  function toggleGateway(id, containerId) {
    $('#' + id).change(function () {
      if ($(this).val() == 1) { $('#' + containerId).slideDown(); } else { $('#' + containerId).slideUp(); }
    });
    if ($('#' + id).val() == 1) { $('#' + containerId).slideDown(); } else { $('#' + containerId).slideUp(); }
  }
  toggleGateway('paypal_pro', 'paypal_pro_con');
  toggleGateway('stripe',     'stripe_con');
  toggleGateway('authorize',  'authorize_con');
});
</script>
