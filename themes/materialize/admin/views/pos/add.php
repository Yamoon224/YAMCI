<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="fr" dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= lang('pos_module') . ' | ' . $Settings->site_name; ?></title>
  <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?= admin_url('pos'); ?>'; }</script>
  <base href="<?= base_url(); ?>"/>
  <meta http-equiv="cache-control" content="max-age=0"/>
  <meta http-equiv="cache-control" content="no-cache"/>
  <meta http-equiv="expires" content="0"/>
  <meta http-equiv="pragma" content="no-cache"/>
  <link rel="shortcut icon" href="<?= $assets; ?>images/icon.png"/>

  <!-- Materialize theme CSS -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/css/core.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/css/theme-default.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/libs/remixicon/remixicon.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/libs/select2/select2.css'); ?>" />
  <!-- POS specific styles -->
  <link rel="stylesheet" href="<?= $assets; ?>pos/css/posajax.css" type="text/css"/>
  <link rel="stylesheet" href="<?= $assets; ?>pos/css/print.css" type="text/css" media="print"/>

  <style>
    html, body { height: 100%; overflow: hidden; background: #f5f5f9; }
    #pos-wrapper { display: flex; flex-direction: column; height: 100vh; }
    #pos-topbar { flex-shrink: 0; background: #fff; border-bottom: 1px solid #e0e0e0; padding: 0.5rem 1rem; display: flex; align-items: center; justify-content: space-between; gap: 0.5rem; box-shadow: 0 2px 6px rgba(0,0,0,.06); }
    #pos-topbar .brand-name { font-weight: 700; font-size: 1.1rem; color: #7367f0; }
    #pos-body { flex: 1; display: flex; overflow: hidden; }
    /* Left panel */
    #pos-left { width: 340px; flex-shrink: 0; background: #fff; border-right: 1px solid #e0e0e0; display: flex; flex-direction: column; overflow: hidden; }
    #pos-left .panel-header { padding: 0.75rem; border-bottom: 1px solid #e9ecef; }
    #pos-left .panel-body { flex: 1; overflow-y: auto; padding: 0.5rem; }
    /* Category pills */
    .cat-pill { cursor: pointer; border-radius: 20px; padding: 0.3rem 0.75rem; font-size: 0.8rem; border: 1px solid #7367f0; color: #7367f0; background: transparent; transition: all .2s; white-space: nowrap; }
    .cat-pill.active, .cat-pill:hover { background: #7367f0; color: #fff; }
    #category-scroll { display: flex; gap: 0.4rem; overflow-x: auto; padding-bottom: 0.25rem; flex-wrap: nowrap; }
    #category-scroll::-webkit-scrollbar { height: 3px; }
    /* Product grid */
    .product-card { cursor: pointer; border: 1px solid #e9ecef; border-radius: 8px; padding: 0.5rem; text-align: center; transition: all .2s; background: #fff; }
    .product-card:hover { border-color: #7367f0; box-shadow: 0 2px 8px rgba(115,103,240,.2); transform: translateY(-1px); }
    .product-card img { width: 60px; height: 60px; object-fit: cover; border-radius: 6px; }
    .product-card .prod-name { font-size: 0.75rem; font-weight: 600; margin-top: 0.3rem; line-height: 1.2; max-height: 2.4em; overflow: hidden; }
    .product-card .prod-price { font-size: 0.8rem; color: #7367f0; font-weight: 700; }
    /* Center cart */
    #pos-center { flex: 1; display: flex; flex-direction: column; overflow: hidden; background: #f8f9fa; }
    #pos-center .cart-header { padding: 0.75rem 1rem; background: #fff; border-bottom: 1px solid #e9ecef; }
    #pos-center .cart-body { flex: 1; overflow-y: auto; }
    #posTable { margin-bottom: 0; }
    #posTable thead th { position: sticky; top: 0; background: #fff; z-index: 1; font-size: 0.8rem; padding: 0.5rem 0.75rem; }
    #posTable tbody td { padding: 0.5rem 0.75rem; vertical-align: middle; font-size: 0.85rem; }
    /* Right panel */
    #pos-right { width: 300px; flex-shrink: 0; background: #fff; border-left: 1px solid #e0e0e0; display: flex; flex-direction: column; overflow: hidden; }
    #pos-right .panel-header { padding: 0.75rem; border-bottom: 1px solid #e9ecef; font-weight: 600; }
    #pos-right .panel-body { flex: 1; overflow-y: auto; padding: 0.75rem; display: flex; flex-direction: column; gap: 0.75rem; }
    .totals-table td { padding: 0.35rem 0; font-size: 0.9rem; }
    .totals-table .grand-total td { font-size: 1.1rem; font-weight: 700; color: #7367f0; border-top: 2px solid #7367f0; padding-top: 0.5rem; }
    .qty-btn { width: 26px; height: 26px; padding: 0; line-height: 24px; text-align: center; border-radius: 50%; }
    #pos-search { border-radius: 20px; padding-left: 2.5rem; }
    .search-wrap { position: relative; }
    .search-wrap .ri-search-line { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #aaa; }
    @media print {
      #pos-topbar .no-print, .no-print { display: none !important; }
    }
  </style>
</head>
<body>
<noscript>
  <div class="alert alert-danger m-2">JavaScript must be enabled to use the POS.</div>
</noscript>

<div id="pos-wrapper">
  <!-- TOP BAR -->
  <div id="pos-topbar">
    <div class="d-flex align-items-center gap-3">
      <span class="brand-name"><span class="ri-store-2-line me-1"></span><?= $Settings->site_name; ?></span>
      <span class="badge bg-label-info fs-6 no-print">
        <span class="ri-calendar-line me-1"></span><span id="display_time"></span>
      </span>
    </div>
    <div class="d-flex align-items-center gap-2">
      <span class="text-muted small no-print">
        <span class="ri-user-line me-1"></span><?= $this->session->userdata('username'); ?>
      </span>
      <?php if ($Owner): ?>
      <a href="<?= admin_url('pos/settings'); ?>" class="btn btn-sm btn-outline-secondary no-print" title="<?= lang('settings'); ?>">
        <span class="ri-settings-3-line"></span>
      </a>
      <?php endif; ?>
      <a href="<?= admin_url('pos/opened_bills'); ?>" class="btn btn-sm btn-outline-warning no-print" id="opened_bills" data-toggle="ajax" title="<?= lang('suspended_sales'); ?>">
        <span class="ri-layout-grid-line"></span>
      </a>
      <a href="<?= admin_url('pos/close_register'); ?>" class="btn btn-sm btn-outline-danger no-print" id="close_register" data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('close_register'); ?>">
        <span class="ri-door-open-line"></span>
      </a>
      <?php if ($Owner || $Admin): ?>
      <a href="<?= admin_url('pos/registers'); ?>" class="btn btn-sm btn-outline-primary no-print" title="<?= lang('list_open_registers'); ?>">
        <span class="ri-list-check-line"></span>
      </a>
      <?php endif; ?>
      <a href="<?= admin_url('welcome'); ?>" class="btn btn-sm btn-outline-secondary no-print" title="<?= lang('dashboard'); ?>">
        <span class="ri-dashboard-line"></span>
      </a>
    </div>
  </div>

  <!-- MAIN BODY -->
  <div id="pos-body">

    <!-- LEFT: Product Browser -->
    <div id="pos-left">
      <div class="panel-header">
        <!-- Customer select -->
        <div class="mb-2">
          <div class="input-group input-group-sm">
            <?= form_input('customer', ($_POST['customer'] ?? ''), 'id="poscustomer" data-placeholder="' . lang('select') . ' ' . lang('customer') . '" required class="form-control form-control-sm" style="width:100%;"'); ?>
            <?php if ($Owner || $Admin || $GP['customers-add']): ?>
            <a href="<?= admin_url('customers/add'); ?>" id="add-customer" class="input-group-text" data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('add_customer'); ?>">
              <span class="ri-user-add-line"></span>
            </a>
            <?php endif; ?>
          </div>
        </div>

        <!-- Warehouse -->
        <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')): ?>
        <div class="mb-2">
          <?php
          $wh = ['' => ''];
          foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
          echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse), 'id="poswarehouse" class="form-select form-select-sm select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required style="width:100%;"');
          ?>
        </div>
        <?php else: ?>
        <?= form_input(['type' => 'hidden', 'name' => 'warehouse', 'id' => 'poswarehouse', 'value' => $this->session->userdata('warehouse_id')]); ?>
        <?php endif; ?>

        <!-- Search -->
        <div class="search-wrap">
          <span class="ri-search-line"></span>
          <?= form_input('add_item', '', 'class="form-control form-control-sm" id="add_item" id="pos-search" placeholder="' . lang('search_product_by_name_code') . '"'); ?>
        </div>

        <!-- Category pills -->
        <div id="category-scroll" class="mt-2">
          <button type="button" class="cat-pill active" value="" id="cat-all"><?= lang('all'); ?></button>
          <?php foreach ($categories as $cat): ?>
          <button type="button" class="cat-pill category" id="category-<?= $cat->id; ?>" value="<?= $cat->id; ?>"><?= $cat->name; ?></button>
          <?php endforeach; ?>
        </div>
      </div>

      <!-- Product grid -->
      <div class="panel-body" id="item-list">
        <?= $products; ?>
      </div>

      <!-- Pagination -->
      <div class="d-flex justify-content-between p-2 border-top">
        <button type="button" class="btn btn-sm btn-outline-primary" id="previous">
          <span class="ri-arrow-left-s-line"></span>
        </button>
        <?php if ($Owner || $Admin || $GP['sales-add_gift_card']): ?>
        <button type="button" class="btn btn-sm btn-outline-secondary" id="sellGiftCard">
          <span class="ri-bank-card-line me-1"></span><?= lang('sell_gift_card'); ?>
        </button>
        <?php endif; ?>
        <button type="button" class="btn btn-sm btn-outline-primary" id="next">
          <span class="ri-arrow-right-s-line"></span>
        </button>
      </div>
    </div>

    <!-- CENTER: Cart -->
    <div id="pos-center">
      <div class="cart-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0 fw-bold"><span class="ri-shopping-cart-2-line me-2"></span><?= lang('cart'); ?></h6>
        <div class="d-flex gap-2 no-print">
          <button type="button" class="btn btn-sm btn-outline-info" id="print_order">
            <span class="ri-file-list-line me-1"></span><?= lang('order'); ?>
          </button>
          <button type="button" class="btn btn-sm btn-outline-primary" id="print_bill">
            <span class="ri-receipt-line me-1"></span><?= lang('bill'); ?>
          </button>
          <button type="button" class="btn btn-sm btn-outline-warning" id="suspend">
            <span class="ri-pause-circle-line me-1"></span><?= lang('suspend'); ?>
          </button>
          <button type="button" class="btn btn-sm btn-outline-danger" id="reset">
            <span class="ri-close-circle-line me-1"></span><?= lang('cancel'); ?>
          </button>
        </div>
      </div>
      <div class="cart-body">
        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form'];
        echo admin_form_open('pos', $attrib);
        ?>
        <div style="position:absolute; <?= $Settings->user_rtl ? 'right:-9999px;' : 'left:-9999px;'; ?>">
          <?= form_input('test', '', 'id="test" class="kb-pad"'); ?>
        </div>
        <table class="table table-hover table-sm" id="posTable">
          <thead>
            <tr>
              <th style="width:40%"><?= lang('product'); ?></th>
              <th><?= lang('price'); ?></th>
              <th style="width:120px;"><?= lang('qty'); ?></th>
              <th class="text-end"><?= lang('subtotal'); ?></th>
              <th style="width:40px; text-align:center;">
                <span class="ri-delete-bin-line text-danger opacity-50"></span>
              </th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>

        <!-- Hidden payment fields -->
        <div id="payment-con">
          <?php for ($i = 1; $i <= 5; $i++): ?>
          <input type="hidden" name="amount[]"              id="amount_val_<?= $i; ?>"           value="" />
          <input type="hidden" name="balance_amount[]"      id="balance_amount_<?= $i; ?>"       value="" />
          <input type="hidden" name="paid_by[]"             id="paid_by_val_<?= $i; ?>"          value="cash" />
          <input type="hidden" name="cc_no[]"               id="cc_no_val_<?= $i; ?>"            value="" />
          <input type="hidden" name="paying_gift_card_no[]" id="paying_gift_card_no_val_<?= $i; ?>" value="" />
          <input type="hidden" name="cc_holder[]"           id="cc_holder_val_<?= $i; ?>"        value="" />
          <input type="hidden" name="cheque_no[]"           id="cheque_no_val_<?= $i; ?>"        value="" />
          <input type="hidden" name="cc_month[]"            id="cc_month_val_<?= $i; ?>"         value="" />
          <input type="hidden" name="cc_year[]"             id="cc_year_val_<?= $i; ?>"          value="" />
          <input type="hidden" name="cc_type[]"             id="cc_type_val_<?= $i; ?>"          value="" />
          <input type="hidden" name="cc_cvv2[]"             id="cc_cvv2_val_<?= $i; ?>"          value="" />
          <input type="hidden" name="payment_note[]"        id="payment_note_val_<?= $i; ?>"     value="" />
          <?php endfor; ?>
        </div>
        <input name="order_tax" type="hidden" value="<?= $suspend_sale ? $suspend_sale->order_tax_id : ($old_sale ? $old_sale->order_tax_id : $Settings->default_tax_rate2); ?>" id="postax2" />
        <input name="discount"  type="hidden" value="<?= $suspend_sale ? $suspend_sale->order_discount_id : ($old_sale ? $old_sale->order_discount_id : ''); ?>" id="posdiscount" />
        <input name="shipping"  type="hidden" value="<?= $suspend_sale ? $suspend_sale->shipping : ($old_sale ? $old_sale->shipping : '0'); ?>" id="posshipping" />
        <input name="biller"    type="hidden" id="biller" value="<?= ($Owner || $Admin || !$this->session->userdata('biller_id')) ? $pos_settings->default_biller : $this->session->userdata('biller_id'); ?>" />
        <input type="hidden" name="rpaidby"    id="rpaidby"    value="cash" />
        <input type="hidden" name="total_items" id="total_items" value="0" />
        <input type="hidden" name="pos_note"    id="pos_note"    value="" />
        <input type="hidden" name="staff_note"  id="staff_note"  value="" />
        <span id="hidesuspend"></span>
        <input type="submit" id="submit_sale" value="Submit Sale" style="display:none;" />
        <?= form_close(); ?>
      </div>
    </div>

    <!-- RIGHT: Totals & Payment -->
    <div id="pos-right">
      <div class="panel-header">
        <span class="ri-calculator-line me-2"></span><?= lang('totals'); ?>
      </div>
      <div class="panel-body">
        <!-- Totals -->
        <table class="totals-table w-100">
          <tr>
            <td><?= lang('items'); ?></td>
            <td class="text-end fw-semibold"><span id="titems">0</span></td>
          </tr>
          <tr>
            <td><?= lang('total'); ?></td>
            <td class="text-end fw-semibold"><span id="total">0.00</span></td>
          </tr>
          <tr>
            <td>
              <?= lang('order_tax'); ?>
              <a href="#" id="pptax2" class="ms-1"><span class="ri-edit-line text-primary" style="font-size:.8rem;"></span></a>
            </td>
            <td class="text-end"><span id="ttax2">0.00</span></td>
          </tr>
          <tr>
            <td>
              <?= lang('discount'); ?>
              <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')): ?>
              <a href="#" id="ppdiscount" class="ms-1"><span class="ri-edit-line text-primary" style="font-size:.8rem;"></span></a>
              <?php endif; ?>
            </td>
            <td class="text-end"><span id="tds">0.00</span></td>
          </tr>
          <tr>
            <td>
              <?= lang('shipping'); ?>
              <a href="#" id="pshipping" class="ms-1"><span class="ri-add-circle-line text-primary" style="font-size:.8rem;"></span></a>
              <span id="tship" class="text-muted small"></span>
            </td>
            <td class="text-end"><span id="tshipamt">0.00</span></td>
          </tr>
          <tr class="grand-total">
            <td><?= lang('total_payable'); ?></td>
            <td class="text-end"><span id="gtotal">0.00</span></td>
          </tr>
        </table>

        <hr class="my-2">

        <!-- Quick Cash -->
        <div class="text-center mb-2">
          <small class="text-muted text-uppercase fw-semibold"><?= lang('quick_cash'); ?></small>
          <div class="d-flex flex-wrap gap-1 justify-content-center mt-1">
            <button type="button" class="btn btn-sm btn-info quick-cash" id="quick-payable">0.00</button>
            <?php foreach (lang('quick_cash_notes') as $cash_note_amount): ?>
            <button type="button" class="btn btn-sm btn-warning quick-cash"><?= $cash_note_amount; ?></button>
            <?php endforeach; ?>
            <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-cash-notes"><?= lang('clear'); ?></button>
          </div>
        </div>

        <!-- Charge button -->
        <button type="button" class="btn btn-success w-100 btn-lg mt-auto" id="payment" style="font-size:1.1rem; letter-spacing:.02em;">
          <span class="ri-secure-payment-line me-2"></span><?= lang('payment'); ?>
        </button>
      </div>
    </div>

  </div><!-- /#pos-body -->
</div><!-- /#pos-wrapper -->

<!-- PAYMENT MODAL -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="payModalLabel" data-bs-backdrop="static" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="payModalLabel">
          <span class="ri-secure-payment-line me-2"></span><?= lang('finalize_sale'); ?>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
      </div>
      <div class="modal-body" id="payment_content">
        <div class="row g-3">
          <div class="col-md-9">
            <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')): ?>
            <div class="mb-3">
              <label for="posbiller" class="form-label"><?= lang('biller'); ?></label>
              <?php
              foreach ($billers as $biller) {
                $btest = ($biller->company && $biller->company != '-' ? $biller->company : $biller->name);
                $bl[$biller->id] = $btest;
                $posbillers[] = ['logo' => $biller->logo, 'company' => $btest];
                if ($biller->id == $pos_settings->default_biller) { $posbiller = ['logo' => $biller->logo, 'company' => $btest]; }
              }
              echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $pos_settings->default_biller), 'class="form-select" id="posbiller" required');
              ?>
            </div>
            <?php else:
              $biller_input = ['type' => 'hidden', 'name' => 'biller', 'id' => 'posbiller', 'value' => $this->session->userdata('biller_id')];
              echo form_input($biller_input);
              foreach ($billers as $biller) {
                $btest = ($biller->company && $biller->company != '-' ? $biller->company : $biller->name);
                $posbillers[] = ['logo' => $biller->logo, 'company' => $btest];
                if ($biller->id == $this->session->userdata('biller_id')) { $posbiller = ['logo' => $biller->logo, 'company' => $btest]; }
              }
            endif; ?>

            <div class="row g-2 mb-3">
              <div class="col-sm-6">
                <?= form_textarea('sale_note', '', 'id="sale_note" class="form-control" style="height:80px;" placeholder="' . lang('sale_note') . '" maxlength="250"'); ?>
              </div>
              <div class="col-sm-6">
                <?= form_textarea('staffnote', '', 'id="staffnote" class="form-control" style="height:80px;" placeholder="' . lang('staff_note') . '" maxlength="250"'); ?>
              </div>
            </div>

            <div id="payments">
              <div class="card card-body mb-2 well_1">
                <div class="payment">
                  <div class="row g-2">
                    <div class="col-sm-6">
                      <div class="form-floating form-floating-outline">
                        <input name="amount[]" type="text" id="amount_1" class="pa form-control kb-pad1 amount" placeholder=" " />
                        <label for="amount_1"><?= lang('amount'); ?></label>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-floating form-floating-outline">
                        <select name="paid_by[]" id="paid_by_1" class="form-select paid_by">
                          <?= $this->sma->paid_opts(); ?>
                          <?= $pos_settings->paypal_pro ? '<option value="ppp">' . lang('paypal_pro') . '</option>' : ''; ?>
                          <?= $pos_settings->stripe ? '<option value="stripe">' . lang('stripe') . '</option>' : ''; ?>
                          <?= $pos_settings->authorize ? '<option value="authorize">' . lang('authorize') . '</option>' : ''; ?>
                        </select>
                        <label for="paid_by_1"><?= lang('paying_by'); ?></label>
                      </div>
                    </div>
                  </div>
                  <!-- Gift card -->
                  <div class="gc_1 mt-2" style="display:none;">
                    <div class="form-floating form-floating-outline">
                      <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1" class="pa form-control kb-pad gift_card_no" placeholder=" " />
                      <label for="gift_card_no_1"><?= lang('gift_card_no'); ?></label>
                    </div>
                    <div id="gc_details_1" class="mt-1 text-muted small"></div>
                  </div>
                  <!-- CC fields -->
                  <div class="pcc_1 mt-2" style="display:none;">
                    <div class="row g-2">
                      <div class="col-12">
                        <input type="text" id="swipe_1" class="form-control swipe" placeholder="<?= lang('swipe'); ?>" />
                      </div>
                      <div class="col-6">
                        <input name="cc_no[]" type="text" id="pcc_no_1" class="form-control" placeholder="<?= lang('cc_no'); ?>" />
                      </div>
                      <div class="col-6">
                        <input name="cc_holer[]" type="text" id="pcc_holder_1" class="form-control" placeholder="<?= lang('cc_holder'); ?>" />
                      </div>
                      <div class="col-3">
                        <select name="cc_type[]" id="pcc_type_1" class="form-select pcc_type">
                          <option value="Visa"><?= lang('Visa'); ?></option>
                          <option value="MasterCard"><?= lang('MasterCard'); ?></option>
                          <option value="Amex"><?= lang('Amex'); ?></option>
                          <option value="Discover"><?= lang('Discover'); ?></option>
                        </select>
                      </div>
                      <div class="col-3">
                        <input name="cc_month[]" type="text" id="pcc_month_1" class="form-control" placeholder="<?= lang('month'); ?>" />
                      </div>
                      <div class="col-3">
                        <input name="cc_year" type="text" id="pcc_year_1" class="form-control" placeholder="<?= lang('year'); ?>" />
                      </div>
                      <div class="col-3">
                        <input name="cc_cvv2" type="text" id="pcc_cvv2_1" class="form-control" placeholder="<?= lang('cvv2'); ?>" />
                      </div>
                    </div>
                  </div>
                  <!-- Cheque -->
                  <div class="pcheque_1 mt-2" style="display:none;">
                    <div class="form-floating form-floating-outline">
                      <input name="cheque_no[]" type="text" id="cheque_no_1" class="form-control cheque_no" placeholder=" " />
                      <label for="cheque_no_1"><?= lang('cheque_no'); ?></label>
                    </div>
                  </div>
                  <!-- Payment note -->
                  <div class="mt-2">
                    <textarea name="payment_note[]" id="payment_note_1" class="form-control pa payment_note" style="height:60px;" placeholder="<?= lang('payment_note'); ?>"></textarea>
                  </div>
                </div>
              </div>
            </div>
            <div id="multi-payment"></div>
            <button type="button" class="btn btn-outline-primary btn-sm w-100 addButton">
              <span class="ri-add-line me-1"></span><?= lang('add_more_payments'); ?>
            </button>

            <div class="table-responsive mt-3">
              <table class="table table-sm table-bordered">
                <tr>
                  <td><?= lang('total_items'); ?></td>
                  <td class="text-end fw-semibold"><span id="item_count">0</span></td>
                  <td><?= lang('total_payable'); ?></td>
                  <td class="text-end fw-semibold"><span id="twt">0.00</span></td>
                </tr>
                <tr>
                  <td><?= lang('total_paying'); ?></td>
                  <td class="text-end fw-semibold"><span id="total_paying">0.00</span></td>
                  <td><?= lang('balance'); ?></td>
                  <td class="text-end fw-semibold"><span id="balance">0.00</span></td>
                </tr>
              </table>
            </div>
          </div>

          <div class="col-md-3 text-center">
            <span class="fw-bold d-block mb-2"><?= lang('quick_cash'); ?></span>
            <div class="d-flex flex-column gap-1">
              <button type="button" class="btn btn-info quick-cash" id="quick-payable-modal">0.00</button>
              <?php foreach (lang('quick_cash_notes') as $cash_note_amount): ?>
              <button type="button" class="btn btn-warning quick-cash"><?= $cash_note_amount; ?></button>
              <?php endforeach; ?>
              <button type="button" class="btn btn-outline-danger" id="clear-cash-notes"><?= lang('clear'); ?></button>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success btn-lg w-100" id="submit-sale">
          <span class="ri-check-double-line me-2"></span><?= lang('submit'); ?>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- Edit item modal -->
<div class="modal fade" id="prModal" tabindex="-1" aria-labelledby="prModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="prModalLabel"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form class="row g-2" role="form">
          <?php if ($Settings->tax1): ?>
          <div class="col-12">
            <label class="form-label"><?= lang('product_tax'); ?></label>
            <?php $tr = ['' => ''];
            foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
            echo form_dropdown('ptax', $tr, '', 'id="ptax" class="form-select select2" style="width:100%;"'); ?>
          </div>
          <?php endif; ?>
          <?php if ($Settings->product_serial): ?>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control kb-text" id="pserial" placeholder=" " />
              <label><?= lang('serial_no'); ?></label>
            </div>
          </div>
          <?php endif; ?>
          <div class="col-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control kb-pad" id="pquantity" placeholder=" " />
              <label><?= lang('quantity'); ?></label>
            </div>
          </div>
          <div class="col-6">
            <div id="punits-div"></div>
          </div>
          <div class="col-12">
            <div id="poptions-div"></div>
          </div>
          <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))): ?>
          <div class="col-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control kb-pad" id="pdiscount" placeholder=" " />
              <label><?= lang('product_discount'); ?></label>
            </div>
          </div>
          <?php endif; ?>
          <div class="col-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control kb-pad" id="pprice" placeholder=" " <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly'; ?> />
              <label><?= lang('unit_price'); ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="d-flex gap-3">
              <small><?= lang('net_unit_price'); ?>: <strong><span id="net_price"></span></strong></small>
              <small><?= lang('product_tax'); ?>: <strong><span id="pro_tax"></span></strong></small>
            </div>
          </div>
          <input type="hidden" id="punit_price" value=""/>
          <input type="hidden" id="old_tax" value=""/>
          <input type="hidden" id="old_qty" value=""/>
          <input type="hidden" id="old_price" value=""/>
          <input type="hidden" id="row_id" value=""/>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Suspend modal -->
<div class="modal fade" id="susModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('suspend_sale'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating form-floating-outline">
          <?= form_input('reference_note', (!empty($reference_note) ? $reference_note : ''), 'class="form-control kb-text" id="reference_note" placeholder=" "'); ?>
          <label for="reference_note"><?= lang('reference_note'); ?></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="suspend_sale" class="btn btn-primary"><?= lang('submit'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Order tax edit modal -->
<div class="modal fade" id="txModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('edit_order_tax'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <?php $tr = ['' => ''];
        foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
        echo form_dropdown('order_tax_input', $tr, '', 'id="order_tax_input" class="form-select select2" style="width:100%;"'); ?>
      </div>
      <div class="modal-footer">
        <button type="button" id="updateOrderTax" class="btn btn-primary"><?= lang('update'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Order discount edit modal -->
<div class="modal fade" id="dsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('edit_order_discount'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating form-floating-outline">
          <?= form_input('order_discount_input', '', 'class="form-control kb-pad" id="order_discount_input" placeholder=" "'); ?>
          <label for="order_discount_input"><?= lang('order_discount'); ?></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="updateOrderDiscount" class="btn btn-primary"><?= lang('update'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Shipping modal -->
<div class="modal fade" id="sModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('shipping'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="form-floating form-floating-outline">
          <?= form_input('shipping_input', '', 'class="form-control kb-pad" id="shipping_input" placeholder=" "'); ?>
          <label for="shipping_input"><?= lang('shipping'); ?></label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="updateShipping" class="btn btn-primary"><?= lang('update'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Gift card sell modal -->
<div class="modal fade" id="gcModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?= lang('sell_gift_card'); ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="alert alert-danger gcerror-con d-none"><span id="gcerror"></span></div>
        <div class="row g-3">
          <div class="col-12">
            <div class="input-group">
              <?= form_input('gccard_no', '', 'class="form-control" id="gccard_no" placeholder="' . lang('card_no') . '"'); ?>
              <a href="#" class="input-group-text" id="genNo"><span class="ri-settings-3-line"></span></a>
            </div>
            <input type="hidden" name="gcname" value="<?= lang('gift_card'); ?>" id="gcname" />
          </div>
          <div class="col-md-6">
            <?= form_input('gcvalue', '', 'class="form-control" id="gcvalue" placeholder="' . lang('value') . '"'); ?>
          </div>
          <div class="col-md-6">
            <?= form_input('gcprice', '', 'class="form-control" id="gcprice" placeholder="' . lang('price') . '"'); ?>
          </div>
          <div class="col-12">
            <?= form_input('gccustomer', '', 'class="form-control" id="gccustomer" placeholder="' . lang('customer') . '"'); ?>
          </div>
          <div class="col-12">
            <?= form_input('gcexpiry', $this->sma->hrsd(date('Y-m-d', strtotime('+2 year'))), 'class="form-control date" id="gcexpiry" placeholder="' . lang('expiry_date') . '"'); ?>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card'); ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Generic AJAX modal -->
<div class="modal fade" id="myModal"  tabindex="-1" aria-hidden="true"></div>
<div class="modal fade" id="myModal2" tabindex="-1" aria-hidden="true"></div>
<div id="modal-loading" style="display:none;">
  <div class="blackbg"></div>
  <div class="loader"></div>
</div>

<!-- Print areas -->
<div id="order_tbl"><span id="order_span"></span>
  <table id="order-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
</div>
<div id="bill_tbl"><span id="bill_span"></span>
  <table id="bill-table"  width="100%" class="prT table" style="margin-bottom:0;"></table>
  <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
  <span id="bill_footer"></span>
</div>

<!-- JS -->
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code); ?>
<script>
var site = <?= json_encode(['url' => base_url(), 'base_url' => admin_url('/'), 'assets' => $assets, 'settings' => $Settings, 'dateFormats' => $dateFormats]); ?>,
    pos_settings = <?= json_encode($pos_settings); ?>;
var lang = {
  unexpected_value: '<?= lang('unexpected_value'); ?>',
  select_above: '<?= lang('select_above'); ?>',
  r_u_sure: '<?= lang('r_u_sure'); ?>',
  bill: '<?= lang('bill'); ?>',
  order: '<?= lang('order'); ?>',
  total: '<?= lang('total'); ?>',
  items: '<?= lang('items'); ?>',
  discount: '<?= lang('discount'); ?>',
  order_tax: '<?= lang('order_tax'); ?>',
  grand_total: '<?= lang('grand_total'); ?>',
  total_payable: '<?= lang('total_payable'); ?>',
  rounding: '<?= lang('rounding'); ?>',
  merchant_copy: '<?= lang('merchant_copy'); ?>'
};
</script>

<!-- Materialize assets -->
<script src="<?= base_url('themes/materialize/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
<script src="<?= base_url('themes/materialize/assets/vendor/js/bootstrap.js'); ?>"></script>
<script src="<?= base_url('themes/materialize/assets/vendor/libs/select2/select2.js'); ?>"></script>

<!-- POS JS -->
<script>
var pa_no = 1, product_variant = 0, shipping = 0, p_page = 0, per_page = 0,
    tcp = "<?= $tcp; ?>",
    pro_limit = <?= $pos_settings->pro_limit; ?>,
    brand_id = 0, obrand_id = 0,
    cat_id    = "<?= $pos_settings->default_category; ?>",
    ocat_id   = "<?= $pos_settings->default_category; ?>",
    sub_cat_id = 0, osub_cat_id,
    count = 1, an = 1,
    DT = <?= $Settings->default_tax_rate; ?>,
    product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0,
    total_discount = 0, total = 0, total_paid = 0, grand_total = 0,
    KB = <?= $pos_settings->keyboard; ?>,
    tax_rates = <?= json_encode($tax_rates); ?>;
var protect_delete = <?= (!$Owner && !$Admin) ? ($pos_settings->pin_code ? '1' : '0') : '0'; ?>,
    billers = <?= json_encode($posbillers ?? []); ?>,
    biller  = <?= json_encode($posbiller ?? new stdClass()); ?>;
var username = '<?= $this->session->userdata('username'); ?>', order_data = '', bill_data = '';

function widthFunctions() {
  var wh = $(window).height();
  $('#item-list').css('height', wh - 180);
}
$(window).on('resize', widthFunctions);

$(document).ready(function () {
  widthFunctions();

  <?php if ($sid): ?>
  localStorage.setItem('positems', JSON.stringify(<?= $items; ?>));
  <?php endif; ?>
  <?php if ($oid): ?>
  localStorage.setItem('positems', JSON.stringify(<?= $items; ?>));
  <?php endif; ?>

  <?php if ($this->session->userdata('remove_posls')): ?>
  ['positems','posdiscount','postax2','posshipping','poswarehouse','posnote','poscustomer','posbiller','poscurrency','staffnote'].forEach(function(k){ localStorage.removeItem(k); });
  <?php $this->sma->unset_data('remove_posls'); endif; ?>

  <?php if ($suspend_sale): ?>
  localStorage.setItem('postax2',     '<?= $suspend_sale->order_tax_id; ?>');
  localStorage.setItem('posdiscount', '<?= $suspend_sale->order_discount_id; ?>');
  localStorage.setItem('poswarehouse','<?= $suspend_sale->warehouse_id; ?>');
  localStorage.setItem('poscustomer', '<?= $suspend_sale->customer_id; ?>');
  localStorage.setItem('posbiller',   '<?= $suspend_sale->biller_id; ?>');
  localStorage.setItem('posshipping', '<?= $suspend_sale->shipping; ?>');
  <?php endif; ?>
  <?php if ($old_sale): ?>
  localStorage.setItem('postax2',     '<?= $old_sale->order_tax_id; ?>');
  localStorage.setItem('posdiscount', '<?= $old_sale->order_discount_id; ?>');
  localStorage.setItem('poswarehouse','<?= $old_sale->warehouse_id; ?>');
  localStorage.setItem('poscustomer', '<?= $old_sale->customer_id; ?>');
  localStorage.setItem('posbiller',   '<?= $old_sale->biller_id; ?>');
  localStorage.setItem('posshipping', '<?= $old_sale->shipping; ?>');
  <?php endif; ?>

  <?php if ($this->input->get('customer')): ?>
  if (!localStorage.getItem('positems')) { localStorage.setItem('poscustomer', <?= $this->input->get('customer'); ?>); }
  else if (!localStorage.getItem('poscustomer')) { localStorage.setItem('poscustomer', <?= $customer->id; ?>); }
  <?php else: ?>
  if (!localStorage.getItem('poscustomer')) { localStorage.setItem('poscustomer', <?= $customer->id; ?>); }
  <?php endif; ?>

  if (!localStorage.getItem('postax2')) { localStorage.setItem('postax2', <?= $Settings->default_tax_rate2; ?>); }

  // Customer select2
  $('#poscustomer').val(localStorage.getItem('poscustomer')).select2({
    minimumInputLength: 1,
    data: [],
    initSelection: function (element, callback) {
      $.ajax({ type: "get", async: false, url: "<?= admin_url('customers/getCustomer'); ?>/" + $(element).val(), dataType: "json",
        success: function (data) { callback(data[0]); }
      });
    },
    ajax: {
      url: site.base_url + "customers/suggestions", dataType: 'json', quietMillis: 15,
      data: function (term) { return { term: term, limit: 10 }; },
      results: function (data) { return data.results ? { results: data.results } : { results: [{ id: '', text: 'No Match Found' }] }; }
    }
  });

  // Biller change
  $(document).on('change', '#posbiller', function () {
    var sb = $(this).val();
    $.each(billers, function () { if (this.id == sb) { biller = this; } });
    $('#biller').val(sb);
  });

  // Payment button
  $('#payment').click(function () {
    <?php if ($sid): ?>
    suspend = $('<span></span>');
    suspend.html('<input type="hidden" name="delete_id" value="<?= $sid; ?>" />');
    suspend.appendTo("#hidesuspend");
    <?php endif; ?>
    var twt = formatDecimal((total + invoice_tax) - order_discount + shipping);
    if (count == 1) {
      if (typeof Swal !== 'undefined') { Swal.fire({ icon: 'warning', title: '<?= lang('x_total'); ?>', timer: 2500, showConfirmButton: false }); }
      return false;
    }
    gtotal = formatDecimal(twt);
    <?php if ($pos_settings->rounding): ?>
    round_total = roundNumber(gtotal, <?= $pos_settings->rounding; ?>);
    var rounding = formatDecimal(0 - (gtotal - round_total));
    $('#twt').text(formatMoney(round_total) + ' (' + formatMoney(rounding) + ')');
    $('#quick-payable,#quick-payable-modal').text(round_total);
    <?php else: ?>
    $('#twt').text(formatMoney(gtotal));
    $('#quick-payable,#quick-payable-modal').text(gtotal);
    <?php endif; ?>
    $('#item_count').text(count - 1);
    $('#paymentModal').modal('show');
    setTimeout(function () { $('#amount_1').focus().val(grand_total); }, 400);
  });

  $('#paymentModal').on('shown.bs.modal', function () {
    $('#amount_1').focus().val(0);
    $('#quick-payable-modal').click();
  });

  // Quick cash
  $(document).on('click', '.quick-cash', function (e) {
    var cl_id = e.target.id;
    if (cl_id !== 'quick-payable' && cl_id !== 'quick-payable-modal') {
      var amt = parseFloat($(this).text()) || 0;
      var cur = parseFloat($('#amount_1').val()) || 0;
      $('#amount_1').val(formatDecimal(amt + cur)).focus();
    } else {
      $('.quick-cash').find('.badge').remove();
      $('#amount_1').val(grand_total).focus();
    }
    calculateTotals && calculateTotals();
  });

  $(document).on('click', '#clear-cash-notes', function () {
    $('.quick-cash').find('.badge').remove();
    $('#amount_1').val('0').focus();
    calculateTotals && calculateTotals();
  });

  // Category pills
  $(document).on('click', '.cat-pill', function () {
    $('.cat-pill').removeClass('active');
    $(this).addClass('active');
    cat_id = $(this).val();
    ocat_id = cat_id;
    p_page = 0;
    if (typeof loadProducts === 'function') { loadProducts(); }
  });

  // Payment field sync
  <?php for ($i = 1; $i <= 5; $i++): ?>
  $('#paymentModal').on('change blur', '#amount_<?= $i; ?>',      function () { $('#amount_val_<?= $i; ?>').val($(this).val()); });
  $('#paymentModal').on('change',      '#paid_by_<?= $i; ?>',     function () { $('#paid_by_val_<?= $i; ?>').val($(this).val()); });
  $('#paymentModal').on('change',      '#pcc_no_<?= $i; ?>',      function () { $('#cc_no_val_<?= $i; ?>').val($(this).val()); });
  $('#paymentModal').on('change',      '#pcc_holder_<?= $i; ?>',  function () { $('#cc_holder_val_<?= $i; ?>').val($(this).val()); });
  $('#paymentModal').on('change',      '#gift_card_no_<?= $i; ?>', function () { $('#paying_gift_card_no_val_<?= $i; ?>').val($(this).val()); });
  $('#paymentModal').on('change',      '#payment_note_<?= $i; ?>', function () { $('#payment_note_val_<?= $i; ?>').val($(this).val()); });
  <?php endfor; ?>

  // Display time
  <?php if ($pos_settings->display_time): ?>
  function updateClock() { var now = new Date(); $('#display_time').text(now.toLocaleTimeString()); }
  updateClock();
  setInterval(updateClock, 1000);
  <?php endif; ?>
});
</script>

<!-- Main POS JS from assets -->
<script type="text/javascript" src="<?= $assets; ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= $assets; ?>pos/js/posajax.js"></script>
<script type="text/javascript" src="<?= $assets; ?>pos/js/parse-track-data.js"></script>
<script type="text/javascript" src="<?= $assets; ?>js/custom.js"></script>

<?php include 'remote_printing.php'; ?>
</body>
</html>
