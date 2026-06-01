<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-group-line icon-20px me-2"></i><?= lang('add_customer_group') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-bs-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open('system_settings/add_customer_group', $attrib); ?>
        <div class="modal-body">
            <p class="text-muted mb-4"><?= lang('enter_info') ?></p>

            <div class="mb-3">
                <label class="form-label" for="name"><?= lang('group_name') ?></label>
                <?= form_input('name', '', 'class="form-control" id="name" required="required"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="percent"><?= lang('group_percentage') ?></label>
                <div class="input-group">
                    <?= form_input('percent', '', 'class="form-control" id="percent" required="required" placeholder="0.00"') ?>
                    <span class="input-group-text">%</span>
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <?= form_checkbox('discount', '1', false, 'class="form-check-input" id="discount"') ?>
                    <label class="form-check-label" for="discount"><?= lang('apply_as_discount') ?></label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                <?= lang('cancel') ?>
            </button>
            <?= form_submit('add_customer_group', lang('add_customer_group'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $modal_js ?>
