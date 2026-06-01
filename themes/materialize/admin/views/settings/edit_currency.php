<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-pencil-line icon-20px me-2"></i><?= lang('edit_currency') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-bs-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open('system_settings/edit_currency/' . $id, $attrib); ?>
        <div class="modal-body">
            <p class="text-muted mb-4"><?= lang('enter_info') ?></p>

            <div class="mb-3">
                <label class="form-label" for="code"><?= lang('currency_code') ?></label>
                <?= form_input('code', set_value('code', $currency->code), 'class="form-control" id="code" required="required"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="name"><?= lang('currency_name') ?></label>
                <?= form_input('name', set_value('name', $currency->name), 'class="form-control" id="name" required="required"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="symbol"><?= lang('symbol') ?></label>
                <?= form_input('symbol', $currency->symbol, 'class="form-control" id="symbol" required="required"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="rate"><?= lang('exchange_rate') ?></label>
                <?= form_input('rate', set_value('rate', $currency->rate), 'class="form-control" id="rate" required="required"') ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                <?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_currency', lang('edit_currency'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $modal_js ?>
