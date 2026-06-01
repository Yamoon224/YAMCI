<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0,
        total_discount = 0, total = 0,
        allow_discount = <?= ($Owner || $Admin || $this->session->userdata('allow_discount')) ? 1 : 0; ?>,
        tax_rates = <?php echo json_encode($tax_rates); ?>;

    $(document).ready(function () {
        /* ── Purge stale localStorage keys ── */
        if (localStorage.getItem('remove_slls')) {
            ['slitems','sldiscount','sltax2','slref','slshipping','slwarehouse','slnote',
             'slinnote','slcustomer','slbiller','slcurrency','sldate','slsale_status',
             'slpayment_status','paid_by','amount_1','paid_by_1','pcc_holder_1','pcc_type_1',
             'pcc_month_1','pcc_year_1','pcc_no_1','cheque_no_1','payment_note_1','slpayment_term'
            ].forEach(function(k){ if (localStorage.getItem(k)) localStorage.removeItem(k); });
            localStorage.removeItem('remove_slls');
        }

        <?php if ($quote_id) { ?>
        localStorage.setItem('slcustomer', '<?= $quote->customer_id ?>');
        localStorage.setItem('slbiller',   '<?= $quote->biller_id ?>');
        localStorage.setItem('slwarehouse','<?= $quote->warehouse_id ?>');
        localStorage.setItem('slnote',     '<?= str_replace(["\r", "\n"], '', $this->sma->decode_html($quote->note)); ?>');
        localStorage.setItem('sldiscount', '<?= $quote->order_discount_id ?>');
        localStorage.setItem('sltax2',     '<?= $quote->order_tax_id ?>');
        localStorage.setItem('slshipping', '<?= $quote->shipping ?>');
        localStorage.setItem('slitems',    JSON.stringify(<?= $quote_items; ?>));
        <?php } ?>

        <?php if ($this->input->get('customer')) { ?>
        if (!localStorage.getItem('slitems')) {
            localStorage.setItem('slcustomer', <?= $this->input->get('customer'); ?>);
        }
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('sldate')) {
            $("#sldate").datetimepicker({
                format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma',
                weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0
            }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#sldate', function () {
            localStorage.setItem('sldate', $(this).val());
        });
        if (sldate = localStorage.getItem('sldate')) { $('#sldate').val(sldate); }
        <?php } ?>

        $(document).on('change', '#slbiller', function () {
            localStorage.setItem('slbiller', $(this).val());
        });
        if (slbiller = localStorage.getItem('slbiller')) { $('#slbiller').val(slbiller); }

        if (!localStorage.getItem('slref')) {
            localStorage.setItem('slref', '<?= $slnumber ?>');
        }
        if (!localStorage.getItem('sltax2')) {
            localStorage.setItem('sltax2', <?= $Settings->default_tax_rate2; ?>);
        }

        ItemnTotals();

        $('.bootbox').on('hidden.bs.modal', function () { $('#add_item').focus(); });

        /* ── Product autocomplete ── */
        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#slcustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?= lang('select_above'); ?>');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get', url: '<?= admin_url('sales/suggestions'); ?>',
                    dataType: "json",
                    data: { term: request.term, warehouse_id: $("#slwarehouse").val(), customer_id: $("#slcustomer").val() },
                    success: function (data) { $(this).removeClass('ui-autocomplete-loading'); response(data); }
                });
            },
            minLength: 1, autoFocus: false, delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () { $('#add_item').focus(); });
                    $(this).removeClass('ui-autocomplete-loading').val('');
                } else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close').removeClass('ui-autocomplete-loading');
                } else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () { $('#add_item').focus(); });
                    $(this).removeClass('ui-autocomplete-loading').val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_invoice_item(ui.item);
                    if (row) $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });

        /* ── Gift card validation ── */
        $(document).on('change', '#gift_card_no', function () {
            var cn = $(this).val();
            if (cn) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "sales/validate_gift_card/" + cn,
                    dataType: "json",
                    success: function (data) {
                        if (data === false) {
                            $('#gift_card_no').closest('.mb-3').addClass('has-error');
                            bootbox.alert('<?= lang('incorrect_gift_card') ?>');
                        } else if (data.customer_id !== null && data.customer_id !== $('#slcustomer').val()) {
                            $('#gift_card_no').closest('.mb-3').addClass('has-error');
                            bootbox.alert('<?= lang('gift_card_not_for_customer') ?>');
                        } else {
                            $('#gc_details').html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + data.balance + '</small>');
                            $('#gift_card_no').closest('.mb-3').removeClass('has-error');
                        }
                    }
                });
            }
        });

        /* ── Payment status toggle ── */
        $(document).on('change', '#slpayment_status', function () {
            if ($(this).val() === 'paid' || $(this).val() === 'partial') {
                $('#payments').slideDown();
            } else {
                $('#payments').slideUp();
            }
        });

        $(window).on('beforeunload', function () {
            localStorage.setItem('remove_slls', true);
            if (count > 1) { return "You will lose data!"; }
        });

        $('#reset').on('click', function () {
            $(window).off('beforeunload');
        });
        $('#add_sale').on('click', function () {
            $(window).off('beforeunload');
            $('form#salesAddForm').submit();
        });
    });
</script>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'salesAddForm'];
echo admin_form_open_multipart('sales/add', $attrib);
if ($quote_id) { echo form_hidden('quote_id', $quote_id); }
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('add_sale') ?: 'Nouvelle vente' ?></h4>
    <p class="mb-0 text-muted">Créez une nouvelle vente et ses lignes de produits</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('sales') ?>"><?= lang('sales') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('add_sale') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('sales') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i>
      <?= lang('cancel') ?: 'Annuler' ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#salesAddForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i>
      <?= lang('save') ?: 'Enregistrer la vente' ?>
    </button>
  </div>
</div>

<!-- ── Card 1: Sale Details ── -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-file-list-3-line icon-20px me-2"></span><?= lang('sale_details') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <?php if ($Owner || $Admin) { ?>
            <div class="col-md-4">
                <label for="sldate" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?php echo form_input('date', ($_POST['date'] ?? ''), 'class="form-control datetime" id="sldate" required="required"'); ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="slref" class="form-label"><?= lang('reference_no') ?></label>
                <?php echo form_input('reference_no', ($_POST['reference_no'] ?? $slnumber), 'class="form-control" id="slref"'); ?>
            </div>

            <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
            <div class="col-md-4">
                <label for="slbiller" class="form-label"><?= lang('biller') ?> <span class="text-danger">*</span></label>
                <?php
                $bl[''] = '';
                foreach ($billers as $biller) {
                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                }
                echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller),
                    'id="slbiller" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" required="required" class="form-select select2"');
                ?>
            </div>
            <?php } else {
                echo form_input(['type' => 'hidden', 'name' => 'biller', 'id' => 'slbiller', 'value' => $this->session->userdata('biller_id')]);
            } ?>

            <div class="col-md-4">
                <label for="slsale_status" class="form-label"><?= lang('sale_status') ?> <span class="text-danger">*</span></label>
                <?php
                $sst = ['completed' => lang('completed'), 'pending' => lang('pending')];
                echo form_dropdown('sale_status', $sst, ($_POST['sale_status'] ?? ''), 'class="form-select" required="required" id="slsale_status"');
                ?>
            </div>

            <div class="col-md-4">
                <label for="slpayment_term" class="form-label"><?= lang('payment_term') ?></label>
                <?php echo form_input('payment_term', ($_POST['payment_term'] ?? ''), 'class="form-control" id="slpayment_term" title="' . lang('payment_term_tip') . '"'); ?>
            </div>

            <?php if ($Owner || $Admin || $GP['sales-payments']) { ?>
            <div class="col-md-4">
                <label for="slpayment_status" class="form-label"><?= lang('payment_status') ?> <span class="text-danger">*</span></label>
                <?php
                $pst = ['pending' => lang('pending'), 'due' => lang('due'), 'partial' => lang('partial'), 'paid' => lang('paid')];
                echo form_dropdown('payment_status', $pst, ($_POST['payment_status'] ?? ''), 'class="form-select" required="required" id="slpayment_status"');
                ?>
            </div>
            <?php } else {
                echo form_hidden('payment_status', 'pending');
            } ?>

            <div class="col-md-4">
                <label for="document" class="form-label"><?= lang('Pièce jointe') ?></label>
                <input id="document" type="file" name="attachments[]" multiple
                       class="form-control" data-show-upload="false" data-show-preview="false" />
            </div>

        </div>
    </div>
</div>

<!-- ── Card 2: Warehouse & Customer (must select before adding product) ── -->
<div class="card mb-4 border-warning">
    <div class="card-header bg-label-warning">
        <h6 class="card-title mb-0 text-warning">
            <span class="icon-base ri ri-alert-line icon-20px me-1"></span><?= lang('please_select_these_before_adding_product') ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
            <div class="col-md-4">
                <label for="slwarehouse" class="form-label"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                <?php
                $wh[''] = '';
                foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
                echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse),
                    'id="slwarehouse" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required"');
                ?>
            </div>
            <?php } else {
                echo form_input(['type' => 'hidden', 'name' => 'warehouse', 'id' => 'slwarehouse', 'value' => $this->session->userdata('warehouse_id')]);
            } ?>

            <div class="col-md-4">
                <label for="slcustomer" class="form-label"><?= lang('customer') ?> <span class="text-danger">*</span></label>
                <div class="input-group">
                    <?php echo form_input('customer', ($_POST['customer'] ?? ''), 'id="slcustomer" data-placeholder="' . lang('select') . ' ' . lang('customer') . '" required="required" class="form-control" style="width:100%;"'); ?>
                    <a href="#" id="toogle-customer-read-attr" class="btn btn-outline-secondary no-print" title="<?= lang('edit') ?>">
                        <span class="icon-base ri ri-pencil-line icon-20px"></span>
                    </a>
                    <a href="#" id="view-customer" class="btn btn-outline-secondary no-print external"
                       data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('view') ?>">
                        <span class="icon-base ri ri-eye-line icon-20px"></span>
                    </a>
                    <?php if ($Owner || $Admin || $GP['customers-add']) { ?>
                    <a href="<?= admin_url('customers/add'); ?>" id="add-customer"
                       class="btn btn-outline-primary no-print external"
                       data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('add_customer') ?>">
                        <span class="icon-base ri ri-user-add-line icon-20px"></span>
                    </a>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- ── Card 3: Product search bar ── -->
<div class="card mb-4" id="sticker">
    <div class="card-body">
        <div class="input-group input-group-lg">
            <span class="input-group-text">
                <span class="icon-base ri ri-barcode-line icon-20px"></span>
            </span>
            <?php echo form_input('add_item', '', 'class="form-control" id="add_item" placeholder="' . lang('add_product_to_order') . '"'); ?>
            <?php if ($Owner || $Admin || $GP['products-add']) { ?>
            <a href="#" id="addManually" class="btn btn-outline-secondary" title="<?= lang('add_product_manually') ?>">
                <span class="icon-base ri ri-add-circle-line icon-20px"></span>
            </a>
            <?php } ?>
            <?php if ($Owner || $Admin || $GP['sales-add_gift_card']) { ?>
            <a href="#" id="sellGiftCard" class="btn btn-outline-secondary" title="<?= lang('sell_gift_card') ?>">
                <span class="icon-base ri ri-gift-line icon-20px"></span>
            </a>
            <?php } ?>
        </div>
    </div>
</div>

<!-- ── Card 4: Order items table ── -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-cart-line icon-20px me-2"></span><?= lang('order_items') ?> <span class="text-danger">*</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="slTable" class="table items table-striped table-bordered table-hover mb-0 sortable_table">
                <thead class="table-light">
                <tr>
                    <th class="col-md-4"><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')'; ?></th>
                    <?php if ($Settings->product_serial) { echo '<th class="col-md-2">' . lang('serial_no') . '</th>'; } ?>
                    <th class="col-md-1"><?= lang('net_unit_price'); ?></th>
                    <th class="col-md-1"><?= lang('quantity'); ?></th>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {
                        echo '<th class="col-md-1">' . lang('discount') . '</th>';
                    } ?>
                    <?php if ($Settings->tax1) { echo '<th class="col-md-1">' . lang('product_tax') . '</th>'; } ?>
                    <th><?= lang('subtotal'); ?> (<span class="currency"><?= $default_currency->code ?></span>)</th>
                    <th style="width:40px; text-align:center;">
                        <span class="icon-base ri ri-delete-bin-line icon-20px text-danger"></span>
                    </th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>

<input type="hidden" name="total_items" value="" id="total_items" required="required" />

<!-- ── Card 5: Order options (tax, discount, shipping) ── -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">

            <?php if ($Settings->tax2) { ?>
            <div class="col-md-4">
                <label for="sltax2" class="form-label"><?= lang('order_tax') ?></label>
                <?php
                $tr[''] = '';
                foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                echo form_dropdown('order_tax', $tr, ($_POST['order_tax'] ?? $Settings->default_tax_rate2),
                    'id="sltax2" data-placeholder="' . lang('select') . ' ' . lang('order_tax') . '" class="form-select select2"');
                ?>
            </div>
            <?php } ?>

            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
            <div class="col-md-4">
                <label for="sldiscount" class="form-label"><?= lang('order_discount') ?></label>
                <?php echo form_input('order_discount', ($_POST['order_discount'] ?? ''), 'class="form-control" id="sldiscount"'); ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="slshipping" class="form-label"><?= lang('shipping') ?></label>
                <?php echo form_input('shipping', ($_POST['shipping'] ?? ''), 'class="form-control" id="slshipping"'); ?>
            </div>

        </div>
    </div>
</div>

<!-- ── Card 6: Payment section (shown when payment_status = paid/partial) ── -->
<div id="payments" style="display:none;">
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <span class="icon-base ri ri-bank-card-line icon-20px me-2"></span><?= lang('payment_details') ?>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <label for="payment_reference_no" class="form-label"><?= lang('payment_reference_no') ?></label>
                    <?= form_input('payment_reference_no', ($_POST['payment_reference_no'] ?? $payment_ref), 'class="form-control" id="payment_reference_no"'); ?>
                </div>

                <div class="col-md-4">
                    <div class="ngc">
                        <label for="amount_1" class="form-label"><?= lang('amount') ?></label>
                        <input name="amount-paid" type="text" id="amount_1" class="pa form-control kb-pad amount" />
                    </div>
                    <div class="gc" style="display:none;">
                        <label for="gift_card_no" class="form-label"><?= lang('gift_card_no') ?></label>
                        <input name="gift_card_no" type="text" id="gift_card_no" class="pa form-control kb-pad" />
                        <div id="gc_details" class="mt-1 text-muted small"></div>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="paid_by_1" class="form-label"><?= lang('paying_by') ?></label>
                    <select name="paid_by" id="paid_by_1" class="form-select paid_by">
                        <?= $this->sma->paid_opts(); ?>
                    </select>
                </div>

            </div>

            <!-- Credit card fields -->
            <div class="pcc_1 mt-3" style="display:none;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <input name="pcc_no" type="text" id="pcc_no_1" class="form-control" placeholder="<?= lang('cc_no') ?>" />
                    </div>
                    <div class="col-md-4">
                        <input name="pcc_holder" type="text" id="pcc_holder_1" class="form-control" placeholder="<?= lang('cc_holder') ?>" />
                    </div>
                    <div class="col-md-4">
                        <select name="pcc_type" id="pcc_type_1" class="form-select pcc_type">
                            <option value="Visa"><?= lang('Visa'); ?></option>
                            <option value="MasterCard"><?= lang('MasterCard'); ?></option>
                            <option value="Amex"><?= lang('Amex'); ?></option>
                            <option value="Discover"><?= lang('Discover'); ?></option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input name="pcc_month" type="text" id="pcc_month_1" class="form-control" placeholder="<?= lang('month') ?>" />
                    </div>
                    <div class="col-md-4">
                        <input name="pcc_year" type="text" id="pcc_year_1" class="form-control" placeholder="<?= lang('year') ?>" />
                    </div>
                    <div class="col-md-4">
                        <input name="pcc_ccv" type="text" id="pcc_cvv2_1" class="form-control" placeholder="<?= lang('cvv2') ?>" />
                    </div>
                </div>
            </div>

            <!-- Cheque field -->
            <div class="pcheque_1 mt-3" style="display:none;">
                <label for="cheque_no_1" class="form-label"><?= lang('cheque_no') ?></label>
                <input name="cheque_no" type="text" id="cheque_no_1" class="form-control cheque_no" />
            </div>

            <div class="mt-3">
                <label for="payment_note_1" class="form-label"><?= lang('payment_note') ?></label>
                <textarea name="payment_note" id="payment_note_1" class="pa form-control kb-text payment_note" rows="2"></textarea>
            </div>

        </div>
    </div>
</div>

<!-- ── Card 7: Notes ── -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="slnote" class="form-label"><?= lang('sale_note') ?></label>
                <?php echo form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="slnote" style="height:100px;"'); ?>
            </div>
            <div class="col-md-6">
                <label for="slinnote" class="form-label"><?= lang('staff_note') ?></label>
                <?php echo form_textarea('staff_note', ($_POST['staff_note'] ?? ''), 'class="form-control" id="slinnote" style="height:100px;"'); ?>
            </div>
        </div>
    </div>
</div>

<!-- ── Totals summary ── -->
<div class="card mb-4 bg-label-primary border-0">
    <div class="card-body py-3">
        <div class="row text-center g-2">
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('items') ?></div>
                <div class="fs-6 fw-bold" id="titems">0</div>
            </div>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('total') ?></div>
                <div class="fs-6 fw-bold" id="total">0.00</div>
            </div>
            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('order_discount') ?></div>
                <div class="fs-6 fw-bold text-danger" id="tds">0.00</div>
            </div>
            <?php } ?>
            <?php if ($Settings->tax2) { ?>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('order_tax') ?></div>
                <div class="fs-6 fw-bold" id="ttax2">0.00</div>
            </div>
            <?php } ?>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('shipping') ?></div>
                <div class="fs-6 fw-bold" id="tship">0.00</div>
            </div>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('grand_total') ?></div>
                <div class="fs-4 fw-bold text-primary" id="gtotal">0.00</div>
            </div>
        </div>
    </div>
</div>

<!-- ── Submit buttons ── -->
<div class="d-flex gap-2 justify-content-end mb-5">
    <button type="button" class="btn btn-secondary" id="reset">
        <span class="icon-base ri ri-refresh-line icon-20px me-1"></span><?= lang('reset') ?>
    </button>
    <?php echo form_submit('add_sale', lang('submit'), 'id="add_sale" class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>


<!-- ── Modal: Edit item ── -->
<div class="modal fade" id="prModal" tabindex="-1" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="row g-3">
                    <?php if ($Settings->tax1) { ?>
                    <div class="col-12">
                        <label class="form-label"><?= lang('product_tax') ?></label>
                        <?php
                        $tr[''] = '';
                        foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                        echo form_dropdown('ptax', $tr, '', 'id="ptax" class="form-select"');
                        ?>
                    </div>
                    <?php } ?>
                    <?php if ($Settings->product_serial) { ?>
                    <div class="col-12">
                        <label for="pserial" class="form-label"><?= lang('serial_no') ?></label>
                        <input type="text" class="form-control" id="pserial" />
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label for="pquantity" class="form-label"><?= lang('quantity') ?></label>
                        <input type="text" class="form-control" id="pquantity" />
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?= lang('product_unit') ?></label>
                        <div id="punits-div"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?= lang('product_option') ?></label>
                        <div id="poptions-div"></div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                    <div class="col-12">
                        <label for="pdiscount" class="form-label"><?= lang('product_discount') ?></label>
                        <input type="text" class="form-control" id="pdiscount" />
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label for="pprice" class="form-label"><?= lang('unit_price') ?></label>
                        <input type="text" class="form-control" id="pprice" <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly'; ?> />
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-between p-2 bg-light rounded">
                            <div><small class="text-muted"><?= lang('net_unit_price') ?></small><br><strong id="net_price"></strong></div>
                            <div><small class="text-muted"><?= lang('product_tax') ?></small><br><strong id="pro_tax"></strong></div>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                    <div class="col-12">
                        <label for="psubt" class="form-label"><?= lang('subtotal') ?></label>
                        <input type="text" class="form-control" id="psubt" disabled="disabled" />
                    </div>
                    <div class="col-12">
                        <label for="padiscount" class="form-label"><?= lang('Montant après remise') ?></label>
                        <input type="text" class="form-control" id="padiscount" placeholder="<?= lang('Montant') ?>" />
                    </div>
                    <?php } ?>
                    <input type="hidden" id="punit_price" value="" />
                    <input type="hidden" id="old_tax" value="" />
                    <input type="hidden" id="old_qty" value="" />
                    <input type="hidden" id="old_price" value="" />
                    <input type="hidden" id="row_id" value="" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ── Modal: Add product manually ── -->
<div class="modal fade" id="mModal" tabindex="-1" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-12">
                        <label for="mcode" class="form-label"><?= lang('product_code') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mcode" />
                    </div>
                    <div class="col-12">
                        <label for="mname" class="form-label"><?= lang('product_name') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mname" />
                    </div>
                    <?php if ($Settings->tax1) { ?>
                    <div class="col-12">
                        <label for="mtax" class="form-label"><?= lang('product_tax') ?> <span class="text-danger">*</span></label>
                        <?php
                        $tr[''] = '';
                        foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                        echo form_dropdown('mtax', $tr, '', 'id="mtax" class="form-select"');
                        ?>
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label for="mquantity" class="form-label"><?= lang('quantity') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mquantity" />
                    </div>
                    <div class="col-12">
                        <label for="munit" class="form-label"><?= lang('unit') ?> <span class="text-danger">*</span></label>
                        <?php
                        $uts[''] = '';
                        foreach ($units as $unit) { $uts[$unit->id] = $unit->name; }
                        echo form_dropdown('munit', $uts, '', 'id="munit" class="form-select"');
                        ?>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                    <div class="col-12">
                        <label for="mdiscount" class="form-label"><?= lang('product_discount') ?></label>
                        <input type="text" class="form-control" id="mdiscount" />
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label for="mprice" class="form-label"><?= lang('unit_price') ?> <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="mprice" />
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-between p-2 bg-light rounded">
                            <div><small class="text-muted"><?= lang('net_unit_price') ?></small><br><strong id="mnet_price"></strong></div>
                            <div><small class="text-muted"><?= lang('product_tax') ?></small><br><strong id="mpro_tax"></strong></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- ── Modal: Sell gift card ── -->
<div class="modal fade" id="gcModal" tabindex="-1" aria-labelledby="gcModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gcModalLabel"><?= lang('sell_gift_card'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
            </div>
            <div class="modal-body">
                <p class="text-muted"><?= lang('enter_info'); ?></p>
                <div class="alert alert-danger gcerror-con" style="display:none;">
                    <button data-bs-dismiss="alert" class="btn-close float-end" type="button"></button>
                    <span id="gcerror"></span>
                </div>
                <div class="row g-3">
                    <div class="col-12">
                        <label for="gccard_no" class="form-label"><?= lang('card_no') ?> <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                            <a href="#" id="genNo" class="btn btn-outline-secondary">
                                <span class="icon-base ri ri-settings-3-line icon-20px"></span>
                            </a>
                        </div>
                        <input type="hidden" name="gcname" value="<?= lang('gift_card') ?>" id="gcname" />
                    </div>
                    <div class="col-12">
                        <label for="gcvalue" class="form-label"><?= lang('value') ?> <span class="text-danger">*</span></label>
                        <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                    </div>
                    <div class="col-12">
                        <label for="gcprice" class="form-label"><?= lang('price') ?> <span class="text-danger">*</span></label>
                        <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                    </div>
                    <div class="col-12">
                        <label for="gccustomer" class="form-label"><?= lang('customer') ?></label>
                        <?php echo form_input('gccustomer', '', 'class="form-control select2" id="gccustomer" data-placeholder="' . lang('select') . ' ' . lang('customer') . '"'); ?>
                    </div>
                    <div class="col-12">
                        <label for="gcexpiry" class="form-label"><?= lang('expiry_date') ?></label>
                        <?php echo form_input('gcexpiry', $this->sma->hrsd(date('Y-m-d', strtotime('+2 year'))), 'class="form-control date" id="gcexpiry"'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('#gccustomer').select2({
        minimumInputLength: 1,
        ajax: {
            url: site.base_url + "customers/suggestions",
            dataType: 'json', quietMillis: 15,
            data: function (term, page) { return { term: term, limit: 10 }; },
            results: function (data, page) {
                return data.results ? { results: data.results } : { results: [{ id: '', text: 'No Match Found' }] };
            }
        }
    });
    $('#genNo').on('click', function () {
        var no = generateCardNo();
        $(this).closest('.input-group').find('input').val(no);
        return false;
    });
});
</script>
