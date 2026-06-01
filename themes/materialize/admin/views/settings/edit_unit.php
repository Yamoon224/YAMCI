<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-ruler-line icon-20px me-2 text-warning"></i><?= lang('edit_unit') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'editUnitForm'];
        echo admin_form_open('system_settings/edit_unit/' . $unit->id, $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', set_value('code', $unit->code), 'class="form-control" id="code" placeholder="' . lang('unit_code') . '" required="required"') ?>
                        <label for="code"><?= lang('unit_code') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', set_value('name', $unit->name), 'class="form-control" id="name" placeholder="' . lang('unit_name') . '" required="required"') ?>
                        <label for="name"><?= lang('unit_name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="base_unit" class="form-label"><?= lang('base_unit') ?></label>
                    <?php
                    $opts[0] = lang('select') . ' ' . lang('unit');
                    foreach ($base_units as $bu) {
                        $opts[$bu->id] = $bu->name . ' (' . $bu->code . ')';
                    }
                    echo form_dropdown('base_unit', $opts, set_value('base_unit', $unit->base_unit), 'class="form-select select2" id="base_unit" data-placeholder="' . lang('select') . ' ' . lang('unit') . '"');
                    ?>
                </div>

                <div id="measuring" class="col-12" style="display:none;">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="operator" class="form-label"><?= lang('operator') ?></label>
                            <?php
                            $oopts = ['*' => lang('*'), '/' => lang('/'), '+' => lang('+'), '-' => lang('-')];
                            echo form_dropdown('operator', $oopts, set_value('operator', $unit->operator), 'class="form-select" id="operator"');
                            ?>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline">
                                <?= form_input('operation_value', set_value('operation_value', $unit->operation_value), 'class="form-control" id="operation_value" placeholder="' . lang('operation_value') . '"') ?>
                                <label for="operation_value"><?= lang('operation_value') ?></label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_unit', lang('edit_unit'), 'class="btn btn-warning"') ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?= $modal_js ?>
<script>
$(document).ready(function () {
    $('#base_unit').on('change', function () {
        var bu = $(this).val();
        if (bu > 0) {
            $('#measuring').slideDown();
        } else {
            $('#measuring').slideUp();
        }
    });

    var obu = <?= !empty($unit->base_unit) ? (int)$unit->base_unit : 0; ?>;
    if (obu > 0) {
        $('#measuring').slideDown();
    } else {
        $('#measuring').slideUp();
    }
});
</script>
