<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <span class="icon-base ri ri-truck-line me-1 icon-16px"></span><?= lang('add_delivery'); ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('sales/add_delivery/' . $inv->id, $attrib); ?>
        <div class="modal-body">
            <p class="text-muted small mb-4"><?= lang('enter_info'); ?></p>
            <div class="row g-3">
                <!-- Left column -->
                <div class="col-md-6">
                    <?php if ($Owner || $Admin): ?>
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="date"><?= lang('date'); ?> <span class="text-danger">*</span></label>
                        <?= form_input('date', isset($_POST['date']) ? $_POST['date'] : '', 'class="form-control datetime" id="date" required="required"'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="do_reference_no"><?= lang('do_reference_no'); ?></label>
                        <?= form_input('do_reference_no', isset($_POST['do_reference_no']) ? $_POST['do_reference_no'] : $do_reference_no, 'class="form-control" id="do_reference_no"'); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="sale_reference_no"><?= lang('sale_reference_no'); ?> <span class="text-danger">*</span></label>
                        <?= form_input('sale_reference_no', isset($_POST['sale_reference_no']) ? $_POST['sale_reference_no'] : $inv->reference_no, 'class="form-control" id="sale_reference_no" required="required"'); ?>
                        <input type="hidden" name="sale_id" value="<?= $inv->id; ?>" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="customer"><?= lang('customer'); ?> <span class="text-danger">*</span></label>
                        <?= form_input('customer', isset($_POST['customer']) ? $_POST['customer'] : $customer->name, 'class="form-control" id="customer" required="required"'); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="address"><?= lang('address'); ?> <span class="text-danger">*</span></label>
                        <?php
                        $av = isset($_POST['address']) ? $_POST['address']
                            : (empty($address)
                                ? ($customer->address . ' ' . $customer->city . ' ' . $customer->state . ' ' . $customer->postal_code . ' ' . $customer->country . "\n" . lang('tel') . ': ' . $customer->phone . ' Email: ' . $customer->email)
                                : ($address->line1 . "\n" . $address->line2 . "\n" . $address->city . ' ' . $address->postal_code . ' ' . $address->country . "\n" . lang('tel') . ': ' . $address->phone));
                        echo form_textarea('address', $av, 'class="form-control" id="address" required="required" rows="4"');
                        ?>
                    </div>
                </div>

                <!-- Right column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="status"><?= lang('status'); ?> <span class="text-danger">*</span></label>
                        <?php $opts = ['packing' => lang('packing'), 'delivering' => lang('delivering'), 'delivered' => lang('delivered')]; ?>
                        <?= form_dropdown('status', $opts, '', 'class="form-select" id="status" required="required"'); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="delivered_by"><?= lang('delivered_by'); ?></label>
                        <?= form_input('delivered_by', isset($_POST['delivered_by']) ? $_POST['delivered_by'] : '', 'class="form-control" id="delivered_by"'); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="received_by"><?= lang('received_by'); ?></label>
                        <?= form_input('received_by', isset($_POST['received_by']) ? $_POST['received_by'] : '', 'class="form-control" id="received_by"'); ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="attachment"><?= lang('attachment'); ?></label>
                        <input id="attachment" type="file" name="document"
                               class="form-control"
                               data-browse-label="<?= lang('browse'); ?>"
                               data-show-upload="false" data-show-preview="false" />
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold" for="note"><?= lang('note'); ?></label>
                        <?= form_textarea('note', isset($_POST['note']) ? $_POST['note'] : '', 'class="form-control" id="note" rows="3"'); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= lang('cancel'); ?></button>
            <?= form_submit('add_delivery', lang('add_delivery'), 'class="btn btn-primary"'); ?>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
    $.fn.datetimepicker.dates['sma'] = <?= $dp_lang ?>;
</script>
<?= $modal_js ?>
<script type="text/javascript" charset="UTF-8">
$(document).ready(function () {
    $.fn.datetimepicker.dates['sma'] = <?= $dp_lang ?>;
    $("#date").datetimepicker({
        format: site.dateFormats.js_ldate,
        fontAwesome: true,
        language: 'sma',
        weekStart: 1,
        todayBtn: 1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        forceParse: 0
    }).datetimepicker('update', new Date());
});
</script>
