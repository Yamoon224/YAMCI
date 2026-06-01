<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script type="text/javascript">
    <?php if ($this->session->userdata('remove_tols')) { ?>
    ['toitems','toshipping','toref','to_warehouse','tonote','from_warehouse','todate','tostatus']
        .forEach(function(k){ if(localStorage.getItem(k)) localStorage.removeItem(k); });
    <?php $this->sma->unset_data('remove_tols'); } ?>

    var count = 1, an = 1, product_variant = 0, shipping = 0,
        product_tax = 0, total = 0,
        tax_rates = <?= json_encode($tax_rates) ?>, toitems = {},
        audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3'),
        audio_error   = new Audio('<?= $assets ?>sounds/sound3.mp3');

    $(document).ready(function () {
        <?php if ($transfer) { ?>
        localStorage.setItem('todate',        '<?= date($dateFormats['php_ldate'], strtotime($transfer->date)) ?>');
        localStorage.setItem('from_warehouse','<?= $transfer->from_warehouse_id ?>');
        localStorage.setItem('toref',         '<?= $transfer->transfer_no ?>');
        localStorage.setItem('to_warehouse',  '<?= $transfer->to_warehouse_id ?>');
        localStorage.setItem('tostatus',      '<?= $transfer->status ?>');
        localStorage.setItem('tonote',        '<?= $this->sma->decode_html($transfer->note) ?>');
        localStorage.setItem('toshipping',    '<?= $transfer->shipping ?>');
        localStorage.setItem('toitems',       JSON.stringify(<?= $transfer_items ?>));
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        $(document).on('change', '#todate', function () { localStorage.setItem('todate', $(this).val()); });
        if (todate = localStorage.getItem('todate')) { $('#todate').val(todate); }
        <?php } ?>

        ItemnTotals();

        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#from_warehouse').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?= lang('select_above') ?>');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get', url: '<?= admin_url('transfers/suggestions') ?>',
                    dataType: "json",
                    data: { term: request.term, warehouse_id: $("#from_warehouse").val() },
                    success: function (data) { $(this).removeClass('ui-autocomplete-loading'); response(data); }
                });
            },
            minLength: 1, autoFocus: false, delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    if ($('#from_warehouse').val()) {
                        bootbox.alert('<?= lang('no_match_found') ?>', function () { $('#add_item').focus(); });
                    } else {
                        bootbox.alert('<?= lang('please_select_warehouse') ?>', function () { $('#add_item').focus(); });
                    }
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
                    var row = add_transfer_item(ui.item);
                    if (row) $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });

        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) { e.preventDefault(); $(this).autocomplete("search"); }
        });

        $(window).bind('beforeunload', function () {
            $.get('<?= admin_url('welcome/set_data/remove_tols/1') ?>');
            if (count > 1) { return "You will lose data!"; }
        });
        $('#reset').click(function () { $(window).unbind('beforeunload'); });
        $('#edit_transfer').click(function () {
            $(window).unbind('beforeunload');
            $('form.edit-to-form').submit();
        });

        var to_warehouse_prev;
        $('#to_warehouse').on("select2-focus", function () {
            to_warehouse_prev = $(this).val();
        }).on("select2-close", function () {
            if ($(this).val() !== '' && $(this).val() === $('#from_warehouse').val()) {
                $(this).select2('val', to_warehouse_prev);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });

        var from_warehouse_prev;
        $('#from_warehouse').on("select2-focus", function () {
            from_warehouse_prev = $(this).val();
        }).on("select2-close", function () {
            if ($(this).val() !== '' && $(this).val() === $('#to_warehouse').val()) {
                $(this).select2('val', from_warehouse_prev);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
    });
</script>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-to-form', 'id' => 'transferEditForm'];
echo admin_form_open_multipart('transfers/edit/' . $transfer->id, $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('edit_transfer') ?: 'Modifier le transfert' ?></h4>
    <p class="mb-0 text-muted"><?= lang('reference_no') ?>: <span class="text-primary fw-semibold"><?= htmlspecialchars($transfer->transfer_no ?? $transfer->id) ?></span></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('transfers') ?>"><?= lang('transfers') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page">Modifier</li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('transfers/view/' . $transfer->id) ?>" class="btn btn-outline-info">
      <i class="ri ri-eye-line me-1" style="font-size:16px"></i><?= lang('view') ?>
    </a>
    <a href="<?= admin_url('transfers') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?= lang('cancel') ?: 'Annuler' ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#transferEditForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?= lang('save') ?: 'Enregistrer' ?>
    </button>
  </div>
</div>

<!-- Card 1: Transfer details -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-file-list-line icon-20px me-2"></span><?= lang('transfer_details') ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <?php if ($Owner || $Admin) { ?>
            <div class="col-md-4">
                <label for="todate" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?= form_input('date', ($_POST['date'] ?? ''), 'class="form-control datetime" id="todate" required') ?>
            </div>
            <?php } ?>

            <div class="col-md-4">
                <label for="ref" class="form-label"><?= lang('reference_no') ?> <span class="text-danger">*</span></label>
                <?= form_input('reference_no', ($_POST['reference_no'] ?? $transfer->transfer_no), 'class="form-control" id="ref" required') ?>
            </div>

            <div class="col-md-4">
                <label for="to_warehouse" class="form-label"><?= lang('Vers ce local') ?> <span class="text-danger">*</span></label>
                <?php
                $wh[''] = '';
                foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
                echo form_dropdown('to_warehouse', $wh, ($_POST['to_warehouse'] ?? $transfer->to_warehouse_id),
                    'id="to_warehouse" class="form-select" required');
                ?>
            </div>

            <div class="col-md-4">
                <label for="tostatus" class="form-label"><?= lang('status') ?> <span class="text-danger">*</span></label>
                <?php
                $post = ['pending' => lang('pending'), 'sent' => lang('sent'), 'completed' => lang('completed')];
                echo form_dropdown('status', $post, ($_POST['status'] ?? $transfer->status), 'id="tostatus" class="form-select" required');
                ?>
            </div>

            <div class="col-md-4">
                <label for="toshipping" class="form-label"><?= lang('shipping') ?></label>
                <?= form_input('shipping', '', 'class="form-control" id="toshipping"') ?>
            </div>

            <div class="col-md-4">
                <label for="document" class="form-label"><?= lang('attachments') ?></label>
                <input id="document" type="file" name="attachments[]" multiple
                       class="form-control" data-show-upload="false" data-show-preview="false" />
            </div>
        </div>
    </div>
</div>

<!-- Card 2: Source warehouse (must select before products) -->
<?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
<div class="card mb-4 border-warning">
    <div class="card-header bg-warning bg-opacity-10">
        <h6 class="card-title mb-0 text-warning">
            <span class="icon-base ri ri-alert-line icon-20px me-1"></span><?= lang('please_select_these_before_adding_product') ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="from_warehouse" class="form-label"><?= lang('De ce local') ?> <span class="text-danger">*</span></label>
                <?= form_dropdown('from_warehouse', $wh, ($_POST['from_warehouse'] ?? $transfer->from_warehouse_id),
                    'id="from_warehouse" class="form-select" required') ?>
            </div>
        </div>
    </div>
</div>
<?php } else {
    echo form_input(['type'=>'hidden','name'=>'from_warehouse','id'=>'from_warehouse','value'=>$this->session->userdata('warehouse_id')]);
} ?>

<!-- Card 3: Product search bar -->
<div class="card mb-4" id="sticker">
    <div class="card-body">
        <div class="input-group input-group-lg">
            <span class="input-group-text"><span class="icon-base ri ri-barcode-line icon-20px"></span></span>
            <?= form_input('add_item', '', 'class="form-control" id="add_item" placeholder="' . lang('add_product_to_order') . '"') ?>
        </div>
    </div>
</div>

<!-- Card 4: Order items table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-bag-line icon-20px me-2"></span><?= lang('order_items') ?>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="toTable" class="table items table-striped table-bordered table-hover mb-0 sortable_table">
                <thead class="table-light">
                <tr>
                    <th class="col-md-4"><?= lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')' ?></th>
                    <?php if ($Settings->product_expiry) { ?><th class="col-md-2"><?= lang('expiry_date') ?></th><?php } ?>
                    <th class="col-md-1"><?= lang('net_unit_cost') ?></th>
                    <th class="col-md-1"><?= lang('quantity') ?></th>
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

<!-- Card 5: Notes -->
<div class="card mb-4">
    <div class="card-body">
        <label for="tonote" class="form-label"><?= lang('note') ?></label>
        <?= form_textarea('note', ($_POST['note'] ?? ''), 'id="tonote" class="form-control" style="height:100px;"') ?>
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
            <?php if ($Settings->tax1) { ?>
            <div class="col">
                <div class="fw-bold text-muted small"><?= lang('product_tax') ?></div>
                <div class="fs-6 fw-bold" id="ttax1">0.00</div>
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
    <?= form_submit('edit_transfer', lang('submit'), 'id="edit_transfer" class="btn btn-primary"') ?>
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
                    <div class="col-12">
                        <label for="pprice" class="form-label"><?= lang('cost') ?></label>
                        <input type="text" class="form-control" id="pprice" />
                    </div>
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

<?php if (!$Owner || !$Admin || $this->session->userdata('warehouse_id')) { ?>
<script>
    $(document).ready(function () {
        $("#to_warehouse option[value='<?= $this->session->userdata('warehouse_id') ?>']").attr('disabled', 'disabled');
    });
</script>
<?php } ?>
