<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1, po_edit = true, product_variant = 0,
        DT = <?= $Settings->default_tax_rate ?>,
        DC = '<?= $default_currency->code ?>',
        shipping = 0, product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0,
        tax_rates = <?= json_encode($tax_rates) ?>, poitems = {},
        audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3'),
        audio_error   = new Audio('<?= $assets ?>sounds/sound3.mp3');

    $(window).bind("load", function () {
        <?= ($purchase->status == 'received' || $purchase->status == 'partial') ? '$(".rec_con").show();' : '$(".rec_con").hide();'; ?>
    });

    $(document).ready(function () {
        <?= ($purchase->status == 'received' || $purchase->status == 'partial') ? '$(".rec_con").show();' : '$(".rec_con").hide();'; ?>
        $('#postatus').change(function () {
            var st = $(this).val();
            if (st == 'received' || st == 'partial') {
                $(".rec_con").show();
            } else {
                $(".rec_con").hide();
            }
        });

        <?php if ($purchase) { ?>
        localStorage.setItem('podate',        '<?= date($dateFormats['php_ldate'], strtotime($purchase->date)) ?>');
        localStorage.setItem('posupplier',    '<?= $purchase->supplier_id ?>');
        localStorage.setItem('poref',         '<?= $purchase->reference_no ?>');
        localStorage.setItem('powarehouse',   '<?= $purchase->warehouse_id ?>');
        localStorage.setItem('postatus',      '<?= $purchase->status ?>');
        localStorage.setItem('ponote',        '<?= addslashes(str_replace(["\r", "\n"], '', $this->sma->decode_html($purchase->note))); ?>');
        localStorage.setItem('podiscount',    '<?= $purchase->order_discount_id ?>');
        localStorage.setItem('potax2',        '<?= $purchase->order_tax_id ?>');
        localStorage.setItem('poshipping',    '<?= $purchase->shipping ?>');
        localStorage.setItem('popayment_term','<?= $purchase->payment_term ?>');
        if (parseFloat(localStorage.getItem('potax2')) >= 1 || localStorage.getItem('podiscount').length >= 1 || parseFloat(localStorage.getItem('poshipping')) >= 1) {
            localStorage.setItem('poextras', '1');
        }
        localStorage.setItem('poitems', JSON.stringify(<?= $purchase_items ?>));
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        $(document).on('change', '#podate', function () {
            localStorage.setItem('podate', $(this).val());
        });
        if (podate = localStorage.getItem('podate')) { $('#podate').val(podate); }
        <?php } ?>

        ItemnTotals();

        $("#add_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get', url: '<?= admin_url('purchases/suggestions') ?>',
                    dataType: "json",
                    data: { term: request.term, supplier_id: $("#posupplier").val() },
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
                    var row = add_purchase_item(ui.item);
                    if (row) $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });

        $(document).on('click', '#addItemManually', function () {
            var msgs = {
                mcode: '<?= lang('product_code_is_required') ?>',
                mname: '<?= lang('product_name_is_required') ?>',
                mcategory: '<?= lang('product_category_is_required') ?>',
                munit: '<?= lang('product_unit_is_required') ?>',
                mcost: '<?= lang('product_cost_is_required') ?>',
                mprice: '<?= lang('product_price_is_required') ?>'
            };
            for (var f in msgs) {
                if (!$('#' + f).val()) {
                    $('#mError').text(msgs[f]); $('#mError-con').show(); return false;
                }
            }
            var msg, row = null, product = {
                type: 'standard', code: $('#mcode').val(), name: $('#mname').val(),
                tax_rate: $('#mtax').val(), tax_method: $('#mtax_method').val(),
                category_id: $('#mcategory').val(), unit: $('#munit').val(),
                cost: $('#mcost').val(), price: $('#mprice').val()
            };
            $.ajax({
                type: "get", async: false,
                url: site.base_url + "products/addByAjax",
                data: { token: "<?= $csrf ?>", product: product },
                dataType: "json",
                success: function (data) {
                    if (data.msg == 'success') { row = add_purchase_item(data.result); }
                    else { msg = data.msg; }
                }
            });
            if (row) { $('#mModal').modal('hide'); }
            else { $('#mError').text(msg); $('#mError-con').show(); }
            return false;
        });

        $(window).bind('beforeunload', function () {
            $.get('<?= admin_url('welcome/set_data/remove_pols/1') ?>');
            if (count > 1) { return "You will lose data!"; }
        });
        $('#reset').click(function () { $(window).unbind('beforeunload'); });
        $('#edit_pruchase').click(function () {
            $(window).unbind('beforeunload');
            $('form.edit-po-form').submit();
        });
    });
</script>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-po-form', 'id' => 'purchasesEditForm'];
echo admin_form_open_multipart('purchases/edit/' . $purchase->id, $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('edit_purchase') ?: 'Modifier l\'achat' ?></h4>
    <p class="mb-0 text-muted">
      <?= lang('reference_no') ?>: <span class="text-primary fw-semibold"><?= htmlspecialchars($purchase->reference_no ?? '') ?></span>
    </p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('purchases') ?>"><?= lang('purchases') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($purchase->reference_no ?? '') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('purchases/view/' . $purchase->id) ?>" class="btn btn-outline-info">
      <i class="ri ri-eye-line me-1" style="font-size:16px"></i><?= lang('view') ?>
    </a>
    <a href="<?= admin_url('purchases') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?= lang('cancel') ?: 'Annuler' ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#purchasesEditForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?= lang('save') ?: 'Enregistrer' ?>
    </button>
  </div>
</div>

<!-- Card 1: Purchase details -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-file-list-line icon-20px me-2"></span><?= lang('purchase_details') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php if ($Owner || $Admin) { ?>
            <div class="col-md-4">
                <label for="podate" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?= form_input('date', ($_POST['date'] ?? $this->sma->hrld($purchase->date)), 'class="form-control datetime" id="podate" required') ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="poref" class="form-label"><?= lang('reference_no') ?> <span class="text-danger">*</span></label>
                <?= form_input('reference_no', ($_POST['reference_no'] ?? $purchase->reference_no), 'class="form-control" id="poref" required') ?>
            </div>

            <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
            <div class="col-md-4">
                <label for="powarehouse" class="form-label"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                <?php
                $wh[''] = '';
                foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
                echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $purchase->warehouse_id),
                    'id="powarehouse" class="form-select" required');
                ?>
            </div>
            <?php } else {
                echo form_input(['type'=>'hidden','name'=>'warehouse','id'=>'powarehouse','value'=>$this->session->userdata('warehouse_id')]);
            } ?>

            <div class="col-md-4">
                <label for="postatus" class="form-label"><?= lang('status') ?> <span class="text-danger">*</span></label>
                <?php
                $post = ['received' => lang('received'), 'partial' => lang('partial'), 'pending' => lang('pending'), 'ordered' => lang('ordered')];
                echo form_dropdown('status', $post, ($_POST['status'] ?? $purchase->status), 'id="postatus" class="form-select" required');
                ?>
            </div>

            <div class="col-md-4">
                <label for="document" class="form-label"><?= lang('attachments') ?></label>
                <input id="document" type="file" name="attachments[]" multiple
                       class="form-control" data-show-upload="false" data-show-preview="false" />
            </div>
        </div>
    </div>
</div>

<!-- Card 2: Supplier (must select before adding product) -->
<div class="card mb-4 border-warning">
    <div class="card-header bg-warning bg-opacity-10">
        <h6 class="card-title mb-0 text-warning">
            <span class="icon-base ri ri-alert-line icon-20px me-1"></span><?= lang('please_select_these_before_adding_product') ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="posupplier" class="form-label"><?= lang('supplier') ?></label>
                <div class="input-group">
                    <input type="hidden" name="supplier" value="" id="posupplier" class="form-control"
                           placeholder="<?= lang('select') . ' ' . lang('supplier') ?>" />
                    <input type="hidden" name="supplier_id" value="" id="supplier_id" />
                    <a href="#" id="removeReadonly" class="btn btn-outline-secondary" title="<?= lang('unlock') ?>">
                        <span class="icon-base ri ri-lock-unlock-line icon-20px" id="unLock"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Card 3: Product search bar -->
<div class="card mb-4" id="sticker">
    <div class="card-body">
        <div class="input-group input-group-lg">
            <span class="input-group-text"><span class="icon-base ri ri-barcode-line icon-20px"></span></span>
            <?= form_input('add_item', '', 'class="form-control" id="add_item" placeholder="' . lang('add_product_to_order') . '"') ?>
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
            <span class="icon-base ri ri-shopping-bag-line icon-20px me-2"></span><?= lang('order_items') ?> <span class="text-danger">*</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="poTable" class="table items table-striped table-bordered table-hover mb-0 sortable_table">
                <thead class="table-light">
                <tr>
                    <th class="col-md-4"><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')' ?></th>
                    <?php if ($Settings->product_expiry) { ?>
                    <th class="col-md-2"><?= lang('expiry_date') ?></th>
                    <?php } ?>
                    <th class="col-md-1"><?= lang('net_unit_cost') ?></th>
                    <th class="col-md-1"><?= lang('quantity') ?></th>
                    <th class="col-md-1 rec_con"><?= lang('received') ?></th>
                    <?php if ($Settings->product_discount) { ?><th class="col-md-1"><?= lang('discount') ?></th><?php } ?>
                    <?php if ($Settings->tax1) { ?><th class="col-md-1"><?= lang('product_tax') ?></th><?php } ?>
                    <th><?= lang('subtotal') ?> (<span class="currency"><?= $default_currency->code ?></span>)</th>
                    <th style="width:40px; text-align:center;"><span class="icon-base ri ri-delete-bin-line icon-20px text-danger"></span></th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot></tfoot>
            </table>
        </div>
    </div>
</div>

<input type="hidden" name="total_items" value="" id="total_items" required />

<!-- Card 5: More options -->
<div class="card mb-4">
    <div class="card-body">
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="extras" value="" />
            <label class="form-check-label" for="extras"><?= lang('more_options') ?></label>
        </div>
        <div id="extras-con" style="display:none;">
            <div class="row g-3 mb-3">
                <?php if ($Settings->tax2) { ?>
                <div class="col-md-4">
                    <label for="potax2" class="form-label"><?= lang('order_tax') ?></label>
                    <?php
                    $tr[''] = '';
                    foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                    echo form_dropdown('order_tax', $tr, '', 'id="potax2" class="form-select"');
                    ?>
                </div>
                <?php } ?>
                <div class="col-md-4">
                    <label for="podiscount" class="form-label"><?= lang('discount_label') ?></label>
                    <?= form_input('discount', '', 'class="form-control" id="podiscount"') ?>
                </div>
                <div class="col-md-4">
                    <label for="poshipping" class="form-label"><?= lang('shipping') ?></label>
                    <?= form_input('shipping', '', 'class="form-control" id="poshipping"') ?>
                </div>
                <div class="col-md-4">
                    <label for="popayment_term" class="form-label"><?= lang('payment_term') ?></label>
                    <?= form_input('payment_term', '', 'class="form-control" id="popayment_term" title="' . lang('payment_term_tip') . '"') ?>
                </div>
            </div>
        </div>
        <div class="mb-0">
            <label for="ponote" class="form-label"><?= lang('note') ?></label>
            <?= form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="ponote" style="height:100px;"') ?>
        </div>
    </div>
</div>

<!-- Totals summary -->
<div class="card mb-4 bg-light border-0">
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
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('order_discount') ?></div>
                <div class="fs-6 fw-bold text-danger" id="tds">0.00</div>
            </div>
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
<div class="d-flex gap-2 justify-content-end mb-4">
    <button type="button" class="btn btn-secondary" id="reset">
        <span class="icon-base ri ri-refresh-line icon-20px me-1"></span><?= lang('reset') ?>
    </button>
    <?= form_submit('edit_pruchase', lang('submit'), 'id="edit_pruchase" class="btn btn-primary"') ?>
</div>

<?= form_close() ?>

<!-- Edit item modal -->
<div class="modal fade" id="prModal" tabindex="-1" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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
                    <?php if ($Settings->product_expiry) { ?>
                    <div class="col-12">
                        <label for="pexpiry" class="form-label"><?= lang('product_expiry') ?></label>
                        <input type="text" class="form-control date" id="pexpiry" />
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label class="form-label"><?= lang('product_unit') ?></label>
                        <div id="punits-div"></div>
                    </div>
                    <div class="col-12">
                        <label class="form-label"><?= lang('product_option') ?></label>
                        <div id="poptions-div"></div>
                    </div>
                    <?php if ($Settings->product_discount) { ?>
                    <div class="col-12">
                        <label for="pdiscount" class="form-label"><?= lang('product_discount') ?></label>
                        <input type="text" class="form-control" id="pdiscount" />
                    </div>
                    <?php } ?>
                    <div class="col-12">
                        <label for="pcost" class="form-label"><?= lang('unit_cost') ?></label>
                        <input type="text" class="form-control" id="pcost" />
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-between p-2 bg-light rounded">
                            <div><small class="text-muted"><?= lang('net_unit_cost') ?></small><br><strong id="net_cost"></strong></div>
                            <div><small class="text-muted"><?= lang('product_tax') ?></small><br><strong id="pro_tax"></strong></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-header p-2 small fw-bold"><?= lang('calculate_unit_cost') ?></div>
                            <div class="card-body p-2">
                                <label for="psubtotal" class="form-label small"><?= lang('subtotal') ?></label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control" id="psubtotal" />
                                    <a href="#" id="calculate_unit_price" class="btn btn-outline-secondary" title="<?= lang('calculate_unit_cost') ?>">
                                        <span class="icon-base ri ri-calculator-line icon-20px"></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="punit_cost" /><input type="hidden" id="old_tax" />
                    <input type="hidden" id="old_qty" /><input type="hidden" id="old_cost" />
                    <input type="hidden" id="row_id" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Add product manually modal -->
<div class="modal fade" id="mModal" tabindex="-1" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mModalLabel"><?= lang('add_standard_product') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger" id="mError-con" style="display:none;">
                    <span id="mError"></span>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mcode" class="form-label"><?= lang('product_code') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mcode" />
                        </div>
                        <div class="mb-3">
                            <label for="mname" class="form-label"><?= lang('product_name') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mname" />
                        </div>
                        <div class="mb-3">
                            <label for="mcategory" class="form-label"><?= lang('category') ?> <span class="text-danger">*</span></label>
                            <?php
                            $cat[''] = '';
                            foreach ($categories as $category) { $cat[$category->id] = $category->name; }
                            echo form_dropdown('category', $cat, '', 'class="form-select" id="mcategory"');
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="munit" class="form-label"><?= lang('unit') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="munit" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="mcost" class="form-label"><?= lang('cost') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mcost" />
                        </div>
                        <div class="mb-3">
                            <label for="mprice" class="form-label"><?= lang('price') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="mprice" />
                        </div>
                        <?php if ($Settings->tax1) { ?>
                        <div class="mb-3">
                            <label for="mtax" class="form-label"><?= lang('product_tax') ?></label>
                            <?php
                            $tr[''] = '';
                            foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                            echo form_dropdown('mtax', $tr, '', 'id="mtax" class="form-select"');
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="mtax_method" class="form-label"><?= lang('tax_method') ?></label>
                            <?= form_dropdown('tax_method', ['0' => lang('inclusive'), '1' => lang('exclusive')], '', 'class="form-select" id="mtax_method"') ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
                <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>
