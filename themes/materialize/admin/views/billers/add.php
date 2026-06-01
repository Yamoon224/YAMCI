<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-building-line icon-20px me-2 text-primary"></i><?= lang('add_biller') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form'];
        echo admin_form_open_multipart('billers/add', $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <!-- Logo row -->
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="biller_logo" class="form-label"><?= lang('logo') ?></label>
                    <?php
                    $biller_logos = ['' => ''];
                    foreach ($logos as $key => $value) {
                        $biller_logos[$value] = $value;
                    }
                    echo form_dropdown('logo', $biller_logos, '', 'class="form-select" id="biller_logo"');
                    ?>
                </div>
                <div class="col-md-6 d-flex align-items-center justify-content-center">
                    <div id="logo-con" class="text-center border rounded p-2" style="min-height:60px; min-width:120px;">
                        <span class="text-muted small"><?= lang('logo_preview') ?? 'Aperçu logo' ?></span>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <!-- Left column -->
                <div class="col-md-6">
                    <div class="mb-3 company">
                        <label for="company" class="form-label"><?= lang('company') ?> <span class="text-danger">*</span></label>
                        <?php echo form_input('company', '', 'class="form-control" id="company" required="required"'); ?>
                    </div>

                    <div class="mb-3 person">
                        <label for="name" class="form-label"><?= lang('name') ?></label>
                        <?php echo form_input('name', '', 'class="form-control" id="name"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="vat_no" class="form-label"><?= lang('vat_no') ?></label>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="gst_no" class="form-label"><?= lang('gst_no') ?></label>
                        <?php echo form_input('gst_no', '', 'class="form-control" id="gst_no"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="email_address" class="form-label"><?= lang('email_address') ?> <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" required="required" id="email_address"/>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label"><?= lang('phone') ?> <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control" required="required" id="phone"/>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label"><?= lang('address') ?> <span class="text-danger">*</span></label>
                        <?php echo form_textarea('address', '', 'class="form-control" id="address" required="required" rows="2"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="city" class="form-label"><?= lang('city') ?> <span class="text-danger">*</span></label>
                        <?php echo form_input('city', '', 'class="form-control" id="city" required="required"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="state" class="form-label"><?= lang('state') ?></label>
                        <?php if ($Settings->indian_gst):
                            $states = $this->gst->getIndianStates();
                            echo form_dropdown('state', $states, '', 'class="form-select" id="state" required="required"');
                        else:
                            echo form_input('state', '', 'class="form-control" id="state"');
                        endif; ?>
                    </div>
                </div>

                <!-- Right column -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="postal_code" class="form-label"><?= lang('postal_code') ?></label>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="country" class="form-label"><?= lang('country') ?></label>
                        <?php echo form_input('country', '', 'class="form-control" id="country"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf1" class="form-label"><?= lang('bcf1') ?></label>
                        <?php echo form_input('cf1', '', 'class="form-control" id="cf1"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf2" class="form-label"><?= lang('bcf2') ?></label>
                        <?php echo form_input('cf2', '', 'class="form-control" id="cf2"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf3" class="form-label"><?= lang('bcf3') ?></label>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf4" class="form-label"><?= lang('bcf4') ?></label>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf5" class="form-label"><?= lang('bcf5') ?></label>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>
                    </div>

                    <div class="mb-3">
                        <label for="cf6" class="form-label"><?= lang('bcf6') ?></label>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div>
                </div>

                <!-- Invoice footer (full width) -->
                <div class="col-12">
                    <div class="mb-3">
                        <label for="invoice_footer" class="form-label"><?= lang('invoice_footer') ?></label>
                        <?php echo form_textarea('invoice_footer', '', 'class="form-control skip" id="invoice_footer" rows="3"'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?php echo form_submit('add_biller', lang('add_biller'), 'class="btn btn-primary"'); ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#biller_logo').change(function () {
        var biller_logo = $(this).val();
        if (biller_logo) {
            $('#logo-con').html('<img src="<?= base_url('assets/uploads/logos') ?>/' + biller_logo + '" alt="" style="max-height:80px; max-width:150px;">');
        } else {
            $('#logo-con').html('<span class="text-muted small"><?= lang('logo_preview') ?? 'Aperçu logo' ?></span>');
        }
    });
});
</script>
<?= $modal_js ?>
