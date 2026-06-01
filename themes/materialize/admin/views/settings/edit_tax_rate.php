<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-percent-line icon-20px me-2 text-warning"></i><?= lang('edit_tax_rate') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'editTaxRateForm'];
        echo admin_form_open('system_settings/edit_tax_rate/' . $id, $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <div class="row g-3">
                <div class="col-md-8">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', $tax_rate->name, 'class="form-control" id="name" placeholder="' . lang('name') . '" required="required"') ?>
                        <label for="name"><?= lang('name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', $tax_rate->code, 'class="form-control" id="code" placeholder="' . lang('code') . '"') ?>
                        <label for="code"><?= lang('code') ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('rate', $tax_rate->rate, 'class="form-control" id="rate" placeholder="' . lang('tax_rate') . '" required="required"') ?>
                        <label for="rate"><?= lang('tax_rate') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="type" class="form-label"><?= lang('type') ?> <span class="text-danger">*</span></label>
                    <?php
                    $type = ['1' => lang('percentage'), '2' => lang('fixed')];
                    echo form_dropdown('type', $type, $tax_rate->type, 'class="form-select select2" id="type" required="required" data-placeholder="' . lang('type') . '"');
                    ?>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_tax_rate', lang('edit_tax_rate'), 'class="btn btn-warning"') ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?= $modal_js ?>
