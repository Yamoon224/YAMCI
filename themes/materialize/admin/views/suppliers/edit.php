<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal wrapper (loaded via AJAX into #myModal) -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="ri-edit-line me-2"></span><?= lang('edit_supplier') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
        </div>

        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('suppliers/edit/' . $supplier->id, $attrib);
        ?>

        <div class="modal-body">
            <div class="row g-3">
                <!-- Left column -->
                <div class="col-md-6">
                    <div class="mb-3 company">
                        <label class="form-label" for="company"><?= lang('company') ?></label>
                        <?= form_input('company', set_value('company', $supplier->company), 'class="form-control" id="company" required') ?>
                    </div>
                    <div class="mb-3 person">
                        <label class="form-label" for="name"><?= lang('name') ?></label>
                        <?= form_input('name', set_value('name', $supplier->name), 'class="form-control" id="name" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="vat_no"><?= lang('vat_no') ?></label>
                        <?= form_input('vat_no', set_value('vat_no', $supplier->vat_no), 'class="form-control" id="vat_no"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="gst_no"><?= lang('gst_no') ?></label>
                        <?= form_input('gst_no', set_value('gst_no', $supplier->gst_no), 'class="form-control" id="gst_no"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="email_address"><?= lang('email_address') ?> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required id="email_address"
                               value="<?= set_value('email', $supplier->email) ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="phone"><?= lang('phone') ?> <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" required id="phone"
                               value="<?= set_value('phone', $supplier->phone) ?>" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address"><?= lang('address') ?> <span class="text-danger">*</span></label>
                        <?= form_input('address', set_value('address', $supplier->address), 'class="form-control" id="address" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="city"><?= lang('city') ?> <span class="text-danger">*</span></label>
                        <?= form_input('city', set_value('city', $supplier->city), 'class="form-control" id="city" required') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="state"><?= lang('state') ?></label>
                        <?php if ($Settings->indian_gst) {
                            $states = $this->gst->getIndianStates(true);
                            echo form_dropdown('state', $states, $supplier->state, 'class="form-select" id="state" required');
                        } else {
                            echo form_input('state', set_value('state', $supplier->state), 'class="form-control" id="state"');
                        } ?>
                    </div>
                </div>

                <!-- Right column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label" for="postal_code"><?= lang('postal_code') ?></label>
                        <?= form_input('postal_code', set_value('postal_code', $supplier->postal_code), 'class="form-control" id="postal_code"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="country"><?= lang('country') ?></label>
                        <?= form_input('country', set_value('country', $supplier->country), 'class="form-control" id="country"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf1"><?= lang('scf1') ?></label>
                        <?= form_input('cf1', set_value('cf1', $supplier->cf1), 'class="form-control" id="cf1"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf2"><?= lang('scf2') ?></label>
                        <?= form_input('cf2', set_value('cf2', $supplier->cf2), 'class="form-control" id="cf2"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf3"><?= lang('scf3') ?></label>
                        <?= form_input('cf3', set_value('cf3', $supplier->cf3), 'class="form-control" id="cf3"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf4"><?= lang('scf4') ?></label>
                        <?= form_input('cf4', set_value('cf4', $supplier->cf4), 'class="form-control" id="cf4"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf5"><?= lang('scf5') ?></label>
                        <?= form_input('cf5', set_value('cf5', $supplier->cf5), 'class="form-control" id="cf5"') ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="cf6"><?= lang('scf6') ?></label>
                        <?= form_input('cf6', set_value('cf6', $supplier->cf6), 'class="form-control" id="cf6"') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('cancel') ?></button>
            <?= form_submit('edit_supplier', lang('edit_supplier'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>

<?= $modal_js ?>
