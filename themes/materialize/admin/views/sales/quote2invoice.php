<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
$reference_no = [
    'name'  => 'reference_no',
    'id'    => 'reference_no',
    'value' => $rnumber,
    'class' => 'form-control',
];
$date_field = [
    'name'  => 'date',
    'id'    => 'date',
    'value' => date(PHP_DATE, strtotime($inv->date)),
    'class' => 'form-control',
];
$pr_value = sizeof($inv_products);
$cno      = $pr_value + 1;
?>

<div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <i class="ri-file-transfer-line me-2"></i>
                <?= lang('quote_to_invoice'); ?> — <?= htmlspecialchars($inv->reference_no); ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <?php if ($message): ?>
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                <div><?= $message; ?></div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?= admin_form_open('sales/quote2invoice/' . $inv->id, ['class' => '', 'id' => 'q2iForm']); ?>

            <div class="row g-3 mb-3">
                <!-- Date -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="date" id="date" class="form-control"
                               value="<?= date(PHP_DATE, strtotime($inv->date)); ?>"
                               placeholder="<?= lang('date'); ?>" required />
                        <label for="date"><?= lang('date'); ?></label>
                    </div>
                </div>
                <!-- Reference No -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="reference_no" id="reference_no" class="form-control"
                               value="<?= htmlspecialchars($rnumber); ?>"
                               placeholder="<?= lang('reference_no'); ?>" />
                        <label for="reference_no"><?= lang('reference_no'); ?></label>
                    </div>
                </div>
                <!-- Warehouse -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <?php
                        $wh = ['' => ''];
                        foreach ($warehouses as $warehouse) {
                            $wh[$warehouse->id] = $warehouse->name;
                        }
                        echo form_dropdown('warehouse', $wh, $inv->warehouse_id,
                            'id="warehouse_s" class="form-select" required="required"');
                        ?>
                        <label for="warehouse_s"><?= lang('warehouse'); ?></label>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <!-- Biller -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <?php
                        $bl = ['' => ''];
                        foreach ($billers as $biller) {
                            $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                        }
                        echo form_dropdown('biller', $bl, $inv->biller_id,
                            'id="biller_s" class="form-select" required="required"');
                        ?>
                        <label for="biller_s"><?= lang('biller'); ?></label>
                    </div>
                </div>
                <!-- Customer -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <?php
                        $cu = ['' => ''];
                        foreach ($customers as $customer) {
                            $cu[$customer->id] = ($customer->company == '-' || !$customer->company)
                                ? $customer->name . ' (P)'
                                : $customer->company . ' (C)';
                        }
                        echo form_dropdown('customer', $cu, $inv->customer_id,
                            'id="customer_s" class="form-select" required="required"');
                        ?>
                        <label for="customer_s"><?= lang('customer'); ?></label>
                    </div>
                </div>
                <!-- Shipping -->
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" name="shipping" id="shipping" class="form-control"
                               value="<?= $inv->shipping; ?>"
                               placeholder="<?= lang('shipping'); ?>" />
                        <label for="shipping"><?= lang('shipping'); ?></label>
                    </div>
                </div>
            </div>

            <?php if (TAX2): ?>
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline">
                        <?php
                        $tr = ['' => ''];
                        foreach ($tax_rates as $tax) {
                            $tr[$tax->id] = $tax->name;
                        }
                        echo form_dropdown('tax2', $tr, $inv->tax_rate2_id,
                            'id="tax2_s" class="form-select"');
                        ?>
                        <label for="tax2_s"><?= lang('tax2'); ?></label>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Items Table -->
            <div class="table-responsive mb-3">
                <table id="dyTable" class="table table-bordered table-sm">
                    <thead class="table-primary">
                        <tr>
                            <th><?= lang('product_name') . ' (' . lang('product_code') . ')'; ?></th>
                            <?php if (PRODUCT_SERIAL) echo '<th>' . lang('serial_no') . '</th>'; ?>
                            <?php if (DISCOUNT_OPTION == 2) echo '<th>' . lang('discount') . '</th>'; ?>
                            <?php if (TAX1) echo '<th>' . lang('tax_rate') . '</th>'; ?>
                            <th style="width:100px;"><?= lang('quantity'); ?></th>
                            <th style="width:120px;"><?= lang('unit_price'); ?></th>
                            <th style="width:36px;"><i class="ri-delete-bin-line text-muted"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $r = 1;
                        foreach ($inv_products as $prod):
                            echo '<tr id="row_' . $r . '">';
                            echo '<td><input name="product' . $r . '" type="hidden" value="' . htmlspecialchars($prod->product_code) . '"><input class="form-control form-control-sm tran" name="item' . $r . '" type="text" value="' . htmlspecialchars($prod->product_name . ' (' . $prod->product_code . ')') . '"></td>';
                            if (PRODUCT_SERIAL) echo '<td><input class="form-control form-control-sm" name="serial' . $r . '" type="text" value=""></td>';
                            if (DISCOUNT_OPTION == 2) {
                                echo '<td><select class="form-select form-select-sm" name="discount' . $r . '">';
                                foreach ($discounts as $discount) {
                                    echo '<option value="' . $discount->id . '"' . ($discount->id == $prod->discount_id ? ' selected' : '') . '>' . htmlspecialchars($discount->name) . '</option>';
                                }
                                echo '</select></td>';
                            }
                            if (TAX1) {
                                echo '<td><select class="form-select form-select-sm" name="tax_rate' . $r . '">';
                                foreach ($tax_rates as $tax) {
                                    echo '<option value="' . $tax->id . '"' . ($tax->id == $prod->tax_rate_id ? ' selected' : '') . '>' . htmlspecialchars($tax->name) . '</option>';
                                }
                                echo '</select></td>';
                            }
                            echo '<td><input class="form-control form-control-sm text-center" name="quantity' . $r . '" type="text" value="' . $prod->quantity . '"></td>';
                            echo '<td><input class="form-control form-control-sm text-end" name="unit_price' . $r . '" type="text" value="' . $prod->unit_price . '"></td>';
                            echo '<td class="text-center"><i class="ri-close-line text-danger del cursor-pointer" id="' . $r . '" style="cursor:pointer;"></i></td>';
                            echo '</tr>';
                            $r++;
                        endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Notes -->
            <div class="mb-3">
                <label class="form-label" for="internal_note"><?= lang('internal_note'); ?></label>
                <?= form_textarea('internal_note', isset($_POST['internal_note']) ? $_POST['internal_note'] : html_entity_decode($inv->internal_note), 'class="form-control" id="internal_note" rows="3"'); ?>
            </div>
            <div class="mb-3">
                <label class="form-label" for="note"><?= lang('on_invoice_note'); ?></label>
                <?= form_textarea('note', isset($_POST['note']) ? $_POST['note'] : html_entity_decode($inv->note), 'class="form-control" id="note" rows="3"'); ?>
            </div>

            <?= form_close(); ?>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <?= lang('cancel'); ?>
            </button>
            <button type="submit" form="q2iForm" class="btn btn-primary">
                <i class="ri-file-transfer-line me-1"></i><?= lang('convert_to_invoice'); ?>
            </button>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    // Date picker
    if ($.fn.datepicker) {
        $('#date').datepicker({ format: '<?= JS_DATE; ?>', autoclose: true });
    }

    // Select2
    $('#warehouse_s, #biller_s, #customer_s, #tax2_s').select2({
        dropdownParent: $('#myModal'),
        width: '100%'
    });

    var count = <?= $cno; ?>;
    var an    = <?= $cno; ?>;

    // Remove row
    $('#dyTable').on('click', '.del', function () {
        var delID = $(this).attr('id');
        $('#row_' + delID).remove();
        an--;
    });
});
</script>
<?php echo $modal_js; ?>
