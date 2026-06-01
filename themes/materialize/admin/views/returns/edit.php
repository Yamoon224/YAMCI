<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1, product_variant = 0,
        DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0,
        total_discount = 0, total = 0,
        allow_discount = <?= ($Owner || $Admin || $this->session->userdata('allow_discount')) ? 1 : 0 ?>,
        tax_rates = <?= json_encode($tax_rates) ?>;

    $(document).ready(function () {
        <?php if ($return) { ?>
        localStorage.setItem('redate',    '<?= $this->sma->hrld($return->date) ?>');
        localStorage.setItem('recustomer','<?= $return->customer_id ?>');
        localStorage.setItem('rebiller',  '<?= $return->biller_id ?>');
        localStorage.setItem('reref',     '<?= $return->reference_no ?>');
        localStorage.setItem('rewarehouse','<?= $return->warehouse_id ?>');
        localStorage.setItem('renote',    '<?= str_replace(["\r", "\n"], '', $this->sma->decode_html($return->note)) ?>');
        localStorage.setItem('reinnote',  '<?= str_replace(["\r", "\n"], '', $this->sma->decode_html($return->staff_note)) ?>');
        localStorage.setItem('rediscount','<?= $return->order_discount_id ?>');
        localStorage.setItem('reshipping','<?= $this->sma->formatDecimal($return->shipping) ?>');
        localStorage.setItem('retax2',    '<?= $return->order_tax_id ?>');
        localStorage.setItem('reitems',   JSON.stringify(<?= $return_items ?>));
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        $(document).on('change', '#redate', function () { localStorage.setItem('redate', $(this).val()); });
        if (var_redate = localStorage.getItem('redate')) { $('#redate').val(var_redate); }
        <?php } ?>

        ItemnTotals();

        $('.bootbox').on('hidden.bs.modal', function () { $('#add_item').focus(); });

        $("#add_item").autocomplete({
            source: function (request, response) {
                $.ajax({
                    type: 'get', url: '<?= admin_url('returns/suggestions') ?>',
                    dataType: "json",
                    data: { term: request.term },
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
                    var row = add_return_item(ui.item);
                    if (row) $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
    });
</script>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'returnEditForm'];
echo admin_form_open_multipart('returns/edit/' . $return->id, $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-edit-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('edit_return') ?: 'Modifier le retour' ?></h4>
    <?php if (!empty($return->reference_no)): ?>
    <p class="mb-0 text-muted"><?= lang('reference_no') ?>: <span class="text-primary fw-semibold"><?= htmlspecialchars($return->reference_no) ?></span></p>
    <?php endif; ?>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('returns') ?>">Retours</a></li>
        <li class="breadcrumb-item active">Modifier</li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('returns/view/' . $return->id) ?>" class="btn btn-outline-info">
      <i class="ri ri-eye-line me-1" style="font-size:16px"></i><?= lang('view') ?>
    </a>
    <a href="<?= admin_url('returns') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?= lang('cancel') ?: 'Annuler' ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#returnEditForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?= lang('save') ?: 'Enregistrer' ?>
    </button>
  </div>
</div>

<!-- Card 1: Return details -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-file-list-line icon-20px me-2"></span><?= lang('return_details') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php if ($Owner || $Admin) { ?>
            <div class="col-md-4">
                <label for="redate" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : $this->sma->hrld($return->date)), 'class="form-control datetime" id="redate" required') ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="reref" class="form-label"><?= lang('reference_no') ?></label>
                <?= form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $return->reference_no), 'class="form-control" id="reref"') ?>
            </div>

            <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
            <div class="col-md-4">
                <label for="rebiller" class="form-label"><?= lang('biller') ?> <span class="text-danger">*</span></label>
                <?php
                $bl[''] = '';
                foreach ($billers as $biller) {
                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                }
                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $return->biller_id),
                    'id="rebiller" class="form-select" required');
                ?>
            </div>
            <?php } else {
                echo form_input(['type'=>'hidden','name'=>'biller','id'=>'rebiller','value'=>$this->session->userdata('biller_id')]);
            } ?>

            <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
            <div class="col-md-4">
                <label for="rewarehouse" class="form-label"><?= lang('warehouse') ?> <span class="text-danger">*</span></label>
                <?php
                $wh[''] = '';
                foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $return->warehouse_id),
                    'id="rewarehouse" class="form-select" required');
                ?>
            </div>
            <?php } else {
                echo form_input(['type'=>'hidden','name'=>'warehouse','id'=>'rewarehouse','value'=>$this->session->userdata('warehouse_id')]);
            } ?>

            <div class="col-md-4">
                <label for="recustomer" class="form-label"><?= lang('customer') ?> <span class="text-danger">*</span></label>
                <?= form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ''),
                    'id="recustomer" class="form-control ssr-customer" placeholder="' . lang('select') . ' ' . lang('customer') . '" required') ?>
            </div>

            <?php if ($Settings->tax2) { ?>
            <div class="col-md-4">
                <label for="retax2" class="form-label"><?= lang('order_tax') ?></label>
                <?php
                $tr[''] = '';
                foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
                echo form_dropdown('order_tax', $tr, (isset($_POST['order_tax']) ? $_POST['order_tax'] : $return->order_tax_id),
                    'id="retax2" class="form-select"');
                ?>
            </div>
            <?php } ?>

            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) { ?>
            <div class="col-md-4">
                <label for="rediscount" class="form-label"><?= lang('order_discount') ?></label>
                <?= form_input('order_discount', '', 'class="form-control" id="rediscount"') ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="reshipping" class="form-label"><?= lang('shipping') ?></label>
                <?= form_input('shipping', '', 'class="form-control" id="reshipping"') ?>
            </div>

            <div class="col-md-4">
                <label for="document" class="form-label"><?= lang('document') ?></label>
                <input id="document" type="file" name="document" class="form-control"
                       data-show-upload="false" data-show-preview="false" />
            </div>
        </div>
    </div>
</div>

<!-- Card 2: Product search bar -->
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

<!-- Card 3: Order items table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-bag-line icon-20px me-2"></span><?= lang('order_items') ?> <span class="text-danger">*</span>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="reTable" class="table items table-striped table-bordered table-hover mb-0 sortable_table">
                <thead class="table-light">
                <tr>
                    <th class="col-md-4"><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')' ?></th>
                    <?php if ($Settings->product_serial) { ?><th class="col-md-2"><?= lang('serial_no') ?></th><?php } ?>
                    <th class="col-md-1"><?= lang('net_unit_price') ?></th>
                    <th class="col-md-1"><?= lang('quantity') ?></th>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) { ?>
                    <th class="col-md-1"><?= lang('discount') ?></th>
                    <?php } ?>
                    <?php if ($Settings->tax1) { ?><th class="col-md-1"><?= lang('product_tax') ?></th><?php } ?>
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

<input type="hidden" name="total_items" value="" id="total_items" required />

<!-- Card 4: Notes -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="renote" class="form-label"><?= lang('return_note') ?></label>
                <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control" id="renote" style="height:100px;"') ?>
            </div>
            <div class="col-md-6">
                <label for="reinnote" class="form-label"><?= lang('staff_note') ?></label>
                <?= form_textarea('staff_note', (isset($_POST['staff_note']) ? $_POST['staff_note'] : ''), 'class="form-control" id="reinnote" style="height:100px;"') ?>
            </div>
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
    <?= form_submit('add_return', lang('submit'), 'id="add_return" class="btn btn-primary"') ?>
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
                        <input type="text" class="form-control" id="pprice" <?= ($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly' ?> />
                    </div>
                    <div class="col-12">
                        <div class="d-flex gap-3 justify-content-between p-2 bg-light rounded">
                            <div><small class="text-muted"><?= lang('net_unit_price') ?></small><br><strong id="net_price"></strong></div>
                            <div><small class="text-muted"><?= lang('product_tax') ?></small><br><strong id="pro_tax"></strong></div>
                        </div>
                    </div>
                    <input type="hidden" id="punit_price" />
                    <input type="hidden" id="old_tax" /><input type="hidden" id="old_qty" />
                    <input type="hidden" id="old_price" /><input type="hidden" id="row_id" />
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
    <div class="modal-dialog modal-dialog-centered">
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
                        <label for="mtax" class="form-label"><?= lang('product_tax') ?></label>
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
