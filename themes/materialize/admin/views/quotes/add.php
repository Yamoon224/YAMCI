<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0, DT = <?= $Settings->default_tax_rate ?>,
        allow_discount = <?= ($Owner || $Admin || $this->session->userdata('allow_discount')) ? 1 : 0; ?>,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0, shipping = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>;
    var audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3');
    var audio_error   = new Audio('<?= $assets ?>sounds/sound3.mp3');

    $(document).ready(function () {
        <?php if ($this->input->get('customer')) { ?>
        if (!localStorage.getItem('quitems')) {
            localStorage.setItem('qucustomer', <?= $this->input->get('customer') ?>);
        }
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('qudate')) {
            $("#qudate").datetimepicker({
                format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma',
                weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0
            }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#qudate', function () { localStorage.setItem('qudate', $(this).val()); });
        if (qudate = localStorage.getItem('qudate')) { $('#qudate').val(qudate); }
        <?php } ?>

        $(document).on('change', '#qubiller', function () { localStorage.setItem('qubiller', $(this).val()); });
        if (qubiller = localStorage.getItem('qubiller')) { $('#qubiller').val(qubiller); }

        if (!localStorage.getItem('qutax2')) {
            localStorage.setItem('qutax2', <?= $Settings->default_tax_rate2 ?>);
        }
        ItemnTotals();

        $('.bootbox').on('hidden.bs.modal', function () { $('#add_item').focus(); });

        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#qucustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?= lang('select_above') ?>');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get', url: '<?= admin_url('quotes/suggestions') ?>',
                    dataType: "json",
                    data: { term: request.term, warehouse_id: $("#quwarehouse").val(), customer_id: $("#qucustomer").val() },
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

        $(window).on('beforeunload', function () {
            localStorage.setItem('remove_quls', true);
            if (count > 1) { return "You will lose data!"; }
        });
        $('#reset').on('click', function () { $(window).off('beforeunload'); });
        $('#add_quote').on('click', function () {
            $(window).off('beforeunload');
            $('form#quoteAddForm').submit();
        });
    });
</script>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'quoteAddForm'];
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('add_quote') ?: 'Nouveau devis' ?></h4>
    <p class="mb-0 text-muted">Créez un devis pour un client</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('quotes') ?>"><?= lang('quotes') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('add_quote') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('quotes') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?= lang('cancel') ?: 'Annuler' ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#quoteAddForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?= lang('save') ?: 'Enregistrer' ?>
    </button>
  </div>
</div>

<?php
// keep $attrib in scope
echo admin_form_open_multipart('quotes/add', $attrib);
?>

<!-- Card 1: Quote Details -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-file-list-3-line icon-20px me-2"></span><?= lang('quote_details') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">

            <?php if ($Owner || $Admin) { ?>
            <div class="col-md-4">
                <label for="qudate" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?php echo form_input('date', ($_POST['date'] ?? ''), 'class="form-control datetime" id="qudate" required="required"'); ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="quref" class="form-label"><?= lang('reference_no') ?></label>
                <?php echo form_input('reference_no', ($_POST['reference_no'] ?? $qunumber), 'class="form-control" id="quref"'); ?>
            </div>

            <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
            <div class="col-md-4">
                <label for="qubiller" class="form-label"><?= lang('biller') ?> <span class="text-danger">*</span></label>
                <?php
                $bl[''] = '';
                foreach ($billers as $biller) {
                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                }
                echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $Settings->default_biller),
                    'id="qubiller" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" required="required" class="form-select select2"');
                ?>
            </div>
            <?php } else {
                echo form_input(['type' => 'hidden', 'name' => 'biller', 'id' => 'qubiller', 'value' => $this->session->userdata('biller_id')]);
            } ?>

            <div class="col-md-4">
                <label for="qustatus" class="form-label"><?= lang('status') ?></label>
                <?php
                $st = ['pending' => lang('pending'), 'sent' => lang('sent')];
                echo form_dropdown('status', $st, ($_POST['status'] ?? ''), 'class="form-select" id="qustatus"');
                ?>
            </div>

            <?php if ($Settings->tax2) { ?>
            <div class="col-md-4">
                <label for="qutax2" class="form-label"><?= lang('order_tax') ?></label>
                <?php
                $tr[''] = '';
                foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                echo form_dropdown('order_tax', $tr, ($_POST['order_tax'] ?? $Settings->default_tax_rate2),
                    'id="qutax2" data-placeholder="' . lang('select') . ' ' . lang('order_tax') . '" class="form-select select2"');
                ?>
            </div>
            <?php } ?>

            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
            <div class="col-md-4">
                <label for="qudiscount" class="form-label"><?= lang('discount') ?></label>
                <?php echo form_input('discount', ($_POST['discount'] ?? ''), 'class="form-control" id="qudiscount"'); ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="qushipping" class="form-label"><?= lang('shipping') ?></label>
                <?php echo form_input('shipping', ($_POST['shipping'] ?? ''), 'class="form-control" id="qushipping"'); ?>
            </div>

            <div class="col-md-4">
                <label for="document" class="form-label"><?= lang('document') ?></label>
                <input id="document" type="file" name="document" class="form-control"
                       data-show-upload="false" data-show-preview="false" />
            </div>

            <div class="col-md-4">
                <label for="qusupplier" class="form-label"><?= lang('supplier') ?></label>
                <input type="hidden" name="supplier" value="" id="qusupplier" class="form-control"
                       placeholder="<?= lang('select') . ' ' . lang('supplier') ?>" />
                <input type="hidden" name="supplier_id" value="" id="supplier_id" />
            </div>

        </div>
    </div>
</div>

<!-- Card 2: Warehouse & Customer (must select before adding product) -->
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
                <label for="quwarehouse" class="form-label"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                <?php
                $wh[''] = '';
                foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
                echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $Settings->default_warehouse),
                    'id="quwarehouse" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required"');
                ?>
            </div>
            <?php } else {
                echo form_input(['type' => 'hidden', 'name' => 'warehouse', 'id' => 'quwarehouse', 'value' => $this->session->userdata('warehouse_id')]);
            } ?>

            <div class="col-md-4">
                <label for="qucustomer" class="form-label"><?= lang('customer') ?> <span class="text-danger">*</span></label>
                <div class="input-group">
                    <?php echo form_input('customer', ($_POST['customer'] ?? ''), 'id="qucustomer" data-placeholder="' . lang('select') . ' ' . lang('customer') . '" required="required" class="form-control"'); ?>
                    <a href="#" id="toogle-customer-read-attr" class="btn btn-outline-secondary no-print" title="<?= lang('edit') ?>">
                        <span class="icon-base ri ri-pencil-line icon-20px"></span>
                    </a>
                    <a href="#" id="view-customer" class="btn btn-outline-secondary no-print external"
                       data-bs-toggle="modal" data-bs-target="#myModal" title="<?= lang('view') ?>">
                        <span class="icon-base ri ri-eye-line icon-20px"></span>
                    </a>
                    <?php if ($Owner || $Admin || $GP['customers-add']) { ?>
                    <a href="<?= admin_url('customers/add') ?>" id="add-customer"
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

<!-- Card 3: Product search -->
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
        </div>
    </div>
</div>

<!-- Card 4: Order items table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-cart-line icon-20px me-2"></span><?= lang('order_items') ?> <span class="text-danger">*</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="quTable" class="table items table-striped table-bordered table-hover mb-0 sortable_table">
                <thead class="table-light">
                <tr>
                    <th class="col-md-4"><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')' ?></th>
                    <th class="col-md-1"><?= lang('net_unit_price') ?></th>
                    <th class="col-md-1"><?= lang('quantity') ?></th>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {
                        echo '<th class="col-md-1">' . lang('discount') . '</th>';
                    } ?>
                    <?php if ($Settings->tax1) {
                        echo '<th class="col-md-1">' . lang('product_tax') . '</th>';
                    } ?>
                    <th><?= lang('subtotal') ?> (<span class="currency"><?= $default_currency->code ?></span>)</th>
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

<!-- Card 5: Note -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="qunote" class="form-label"><?= lang('note') ?></label>
                <?php echo form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="qunote" style="height:100px;"'); ?>
            </div>
        </div>
    </div>
</div>

<!-- Totals summary -->
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

<!-- Submit buttons -->
<div class="d-flex gap-2 justify-content-end mb-5">
    <button type="button" class="btn btn-secondary" id="reset">
        <span class="icon-base ri ri-refresh-line icon-20px me-1"></span><?= lang('reset') ?>
    </button>
    <?php echo form_submit('add_quote', lang('submit'), 'id="add_quote" class="btn btn-primary"'); ?>
</div>

<?php echo form_close(); ?>


<!-- Modal: Edit item -->
<div class="modal fade" id="prModal" tabindex="-1" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="prModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
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
                        <input type="text" class="form-control" id="pprice" <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly' ?> />
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-between p-2 bg-light rounded">
                            <div><small class="text-muted"><?= lang('net_unit_price') ?></small><br><strong id="net_price"></strong></div>
                            <div><small class="text-muted"><?= lang('product_tax') ?></small><br><strong id="pro_tax"></strong></div>
                        </div>
                    </div>
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

<!-- Modal: Add product manually -->
<div class="modal fade" id="mModal" tabindex="-1" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
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
