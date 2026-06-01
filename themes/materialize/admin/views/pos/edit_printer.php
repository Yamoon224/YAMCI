<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('edit_printer'); ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?= admin_form_open_multipart('pos/edit_printer/' . $printer->id); ?>
        <div class="modal-body">
            <p class="text-muted small mb-4"><?= lang('update_info'); ?></p>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="title"><?= lang('title'); ?> <span class="text-danger">*</span></label>
                <?= form_input('title', set_value('title', $printer->title), 'class="form-control" id="title" required="required"'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="type"><?= lang('type'); ?> <span class="text-danger">*</span></label>
                <?php $topts = ['network' => lang('network'), 'windows' => lang('windows'), 'linux' => lang('linux')]; ?>
                <?= form_dropdown('type', $topts, set_value('type', $printer->type), 'class="form-select" id="type" required="required"'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="profile"><?= lang('profile'); ?></label>
                <?php $popts = [
                    'default'  => lang('default'),
                    'simple'   => lang('simple'),
                    'SP2000'   => lang('star_branded'),
                    'TEP-200M' => lang('epson_tep'),
                    'P822D'    => lang('P822D'),
                ]; ?>
                <?= form_dropdown('profile', $popts, set_value('profile', $printer->profile), 'class="form-select" id="profile" required="required"'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="char_per_line"><?= lang('char_per_line'); ?> <span class="text-danger">*</span></label>
                <?= form_input('char_per_line', set_value('char_per_line', $printer->char_per_line), 'class="form-control" id="char_per_line" required="required" type="number" min="1"'); ?>
            </div>

            <!-- Network fields -->
            <div class="network-fields">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="ip_address">
                        <?= lang('ip_address'); ?> <span class="text-danger">*</span>
                    </label>
                    <?= form_input('ip_address', set_value('ip_address', $printer->ip_address), 'class="form-control" id="ip_address"'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="port">
                        <?= lang('port'); ?> <span class="text-danger">*</span>
                    </label>
                    <?= form_input('port', set_value('port', $printer->port), 'class="form-control" id="port"'); ?>
                    <div class="form-text"><?= lang('printer_port_tip'); ?></div>
                </div>
            </div>

            <!-- Path fields (Windows/Linux) -->
            <div class="path-fields" style="display:none;">
                <div class="mb-3">
                    <label class="form-label fw-semibold" for="path">
                        <?= lang('path'); ?> <span class="text-danger">*</span>
                    </label>
                    <?= form_input('path', set_value('path', $printer->path), 'class="form-control" id="path"'); ?>
                    <div class="form-text">
                        <strong><?= lang('windows'); ?>:</strong> <?= lang('printer_path_tip'); ?><br>
                        <strong><?= lang('linux'); ?>:</strong> <code>/dev/usb/lp0</code>, <code>/dev/ttyUSB0</code>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="header"><?= lang('header'); ?></label>
                <?= form_textarea('header', set_value('header', $printer->header ?? ''), 'class="form-control" id="header" rows="3"'); ?>
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold" for="footer"><?= lang('footer'); ?></label>
                <?= form_textarea('footer', set_value('footer', $printer->footer ?? ''), 'class="form-control" id="footer" rows="3"'); ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= lang('cancel'); ?></button>
            <?= form_submit('update_printer', lang('update_printer'), 'class="btn btn-primary"'); ?>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<?= $modal_js ?>
<script>
$(document).ready(function () {
    function togglePrinterFields(type) {
        if (type === 'network') {
            $('.network-fields').show();
            $('.path-fields').hide();
        } else {
            $('.network-fields').hide();
            $('.path-fields').show();
        }
    }
    $('#type').on('change', function () {
        togglePrinterFields($(this).val());
    });
    togglePrinterFields($('#type').val());
});
</script>
