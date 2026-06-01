<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal wrapper (loaded via AJAX into #myModal) -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="ri-user-settings-line me-2"></span><?= lang('edit_customer') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
        </div>

        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('customers/edit/' . $customer->id, $attrib);
        ?>

        <div class="modal-body">
            <!-- Groups -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label" for="customer_group"><?= lang('customer_group') ?> <span class="text-danger">*</span></label>
                    <?php
                    foreach ($customer_groups as $cg) { $cgs[$cg->id] = $cg->name; }
                    echo form_dropdown('customer_group', $cgs, $customer->customer_group_id,
                        'class="form-select" id="customer_group" required');
                    ?>
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="price_group"><?= lang('price_group') ?></label>
                    <?php
                    $pgs[''] = lang('select') . ' ' . lang('price_group');
                    foreach ($price_groups as $pg) { $pgs[$pg->id] = $pg->name; }
                    echo form_dropdown('price_group', $pgs, $customer->price_group_id, 'class="form-select" id="price_group"');
                    ?>
                </div>
            </div>

            <div class="row g-3">
                <!-- Left column -->
                <div class="col-md-6">
                    <div class="mb-3 company">
                        <label class="form-label" for="company"><?= lang('company') ?></label>
                        <?= form_input('company', set_value('company', $customer->company), 'class="form-control" id="company" required') ?>
                    </div>
                    <div class="mb-3 person">
                        <label class="form-label" for="name"><?= lang('name') ?></label>
                        <?= form_input('name', set_value('name', $customer->name), 'class="form-control" id="name" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="vat_no"><?= lang('vat_no') ?></label>
                        <?= form_input('vat_no', set_value('vat_no', $customer->vat_no), 'class="form-control" id="vat_no"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gst_no"><?= lang('gst_no') ?></label>
                        <?= form_input('gst_no', set_value('gst_no', $customer->gst_no), 'class="form-control" id="gst_no"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email_address"><?= lang('email_address') ?> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required id="email_address"
                               value="<?= set_value('email', $customer->email) ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone"><?= lang('phone') ?> <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" required id="phone"
                               value="<?= set_value('phone', $customer->phone) ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address"><?= lang('address') ?> <span class="text-danger">*</span></label>
                        <?= form_input('address', set_value('address', $customer->address), 'class="form-control" id="address" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="city"><?= lang('city') ?> <span class="text-danger">*</span></label>
                        <?= form_input('city', set_value('city', $customer->city), 'class="form-control" id="city" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="state"><?= lang('state') ?></label>
                        <?php if ($Settings->indian_gst) {
                            $states = $this->gst->getIndianStates(true);
                            echo form_dropdown('state', $states, $customer->state, 'class="form-select" id="state" required');
                        } else {
                            echo form_input('state', set_value('state', $customer->state), 'class="form-control" id="state"');
                        } ?>
                    </div>
                </div>

                <!-- Right column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="postal_code"><?= lang('postal_code') ?></label>
                        <?= form_input('postal_code', set_value('postal_code', $customer->postal_code), 'class="form-control" id="postal_code"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="country"><?= lang('country') ?></label>
                        <?= form_input('country', set_value('country', $customer->country), 'class="form-control" id="country"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf1"><?= lang('ccf1') ?></label>
                        <?= form_input('cf1', set_value('cf1', $customer->cf1), 'class="form-control" id="cf1"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf2"><?= lang('ccf2') ?></label>
                        <?= form_input('cf2', set_value('cf2', $customer->cf2), 'class="form-control" id="cf2"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf3"><?= lang('ccf3') ?></label>
                        <?= form_input('cf3', set_value('cf3', $customer->cf3), 'class="form-control" id="cf3"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf4"><?= lang('ccf4') ?></label>
                        <?= form_input('cf4', set_value('cf4', $customer->cf4), 'class="form-control" id="cf4"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf5"><?= lang('ccf5') ?></label>
                        <?= form_input('cf5', set_value('cf5', $customer->cf5), 'class="form-control" id="cf5"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf6"><?= lang('ccf6') ?></label>
                        <?= form_input('cf6', set_value('cf6', $customer->cf6), 'class="form-control" id="cf6"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="award_points"><?= lang('award_points') ?> <span class="text-danger">*</span></label>
                        <?= form_input('award_points', set_value('award_points', $customer->award_points), 'class="form-control" id="award_points" required') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('cancel') ?></button>
            <?= form_submit('edit_customer', lang('edit_customer'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= $modal_js ?>
