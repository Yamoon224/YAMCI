<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-money-dollar-circle-line icon-20px me-2"></i><?= lang('add_currency') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-bs-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open('system_settings/add_currency', $attrib); ?>
        <div class="modal-body">
            <p class="text-muted mb-4"><?= lang('enter_info') ?></p>

            <div class="mb-3">
                <label class="form-label" for="code"><?= lang('currency_code') ?></label>
                <?= form_input('code', set_value('code'), 'class="form-control" id="code" required="required" placeholder="USD"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="name"><?= lang('currency_name') ?></label>
                <?= form_input('name', set_value('name'), 'class="form-control" id="name" required="required" placeholder="US Dollar"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="symbol"><?= lang('symbol') ?></label>
                <?= form_input('symbol', set_value('symbol'), 'class="form-control" id="symbol" required="required" placeholder="$"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="rate"><?= lang('exchange_rate') ?></label>
                <?= form_input('rate', set_value('rate'), 'class="form-control" id="rate" required="required" placeholder="1.00"') ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                <?= lang('cancel') ?>
            </button>
            <?= form_submit('add_currency', lang('add_currency'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $modal_js ?>
