<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?= admin_form_open('pos/add_printer', ['id' => 'printerForm']); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-printer-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('add_printer') ?: 'Ajouter une imprimante'); ?></h4>
        <p class="mb-0 text-muted">Configurer une imprimante ticket (réseau, Windows ou Linux) pour le point de vente.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('pos') ?>"><?= lang('pos') ?: 'POS'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('pos/printers') ?>"><?= lang('printers') ?: 'Imprimantes'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('add_printer') ?: 'Ajouter une imprimante'; ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <a href="<?= admin_url('pos/printers') ?>" class="btn btn-outline-secondary">
            <i class="ri ri-close-line me-1" style="font-size:16px"></i><?= lang('cancel') ?: 'Annuler'; ?>
        </a>
        <?= form_submit('add_printer', lang('add_printer') ?: 'Enregistrer', 'class="btn btn-primary" id="btnSavePrinter"'); ?>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="ri ri-printer-line" style="font-size:18px"></i>
        <h5 class="card-title mb-0"><?= lang('printer') ?: 'Imprimante'; ?></h5>
    </div>
    <div class="card-body">
        <p class="text-muted small mb-4"><?= lang('enter_info') ?: 'Remplissez les informations ci-dessous.'; ?></p>

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold" for="title"><?= lang('title') ?: 'Titre'; ?> <span class="text-danger">*</span></label>
                <?= form_input('title', set_value('title'), 'class="form-control" id="title" required="required"'); ?>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" for="type"><?= lang('type') ?: 'Type'; ?> <span class="text-danger">*</span></label>
                <?php $topts = ['network' => lang('network') ?: 'Réseau', 'windows' => lang('windows') ?: 'Windows', 'linux' => lang('linux') ?: 'Linux']; ?>
                <?= form_dropdown('type', $topts, set_value('type', 'network'), 'class="form-select" id="type" required="required"'); ?>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" for="profile"><?= lang('profile') ?: 'Profil'; ?></label>
                <?php $popts = [
                    'default'  => lang('default') ?: 'Default',
                    'simple'   => lang('simple') ?: 'Simple',
                    'SP2000'   => lang('star_branded') ?: 'Star',
                    'TEP-200M' => lang('epson_tep') ?: 'Epson TEP',
                    'P822D'    => lang('P822D') ?: 'P822D',
                ]; ?>
                <?= form_dropdown('profile', $popts, set_value('profile', 'default'), 'class="form-select" id="profile" required="required"'); ?>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold" for="char_per_line"><?= lang('char_per_line') ?: 'Caractères / ligne'; ?> <span class="text-danger">*</span></label>
                <?= form_input('char_per_line', set_value('char_per_line', '42'), 'class="form-control" id="char_per_line" required="required" type="number" min="1"'); ?>
            </div>

            <!-- Network fields -->
            <div class="col-12 network-fields">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="ip_address">
                            <?= lang('ip_address') ?: 'Adresse IP'; ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input('ip_address', set_value('ip_address'), 'class="form-control" id="ip_address"'); ?>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold" for="port">
                            <?= lang('port') ?: 'Port'; ?> <span class="text-danger">*</span>
                        </label>
                        <?= form_input('port', set_value('port', '9100'), 'class="form-control" id="port"'); ?>
                        <div class="form-text"><?= lang('printer_port_tip') ?: 'Port TCP de l\'imprimante réseau (par défaut 9100).'; ?></div>
                    </div>
                </div>
            </div>

            <!-- Path fields (USB/Windows/Linux) -->
            <div class="col-12 path-fields" style="display:none;">
                <label class="form-label fw-semibold" for="path">
                    <?= lang('path') ?: 'Chemin'; ?> <span class="text-danger">*</span>
                </label>
                <?= form_input('path', set_value('path'), 'class="form-control" id="path"'); ?>
                <div class="form-text"><?= lang('printer_path_tip') ?: 'Chemin local vers l\'imprimante (ex. /dev/usb/lp0 ou \\\\PC\\PRINTER).'; ?></div>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="header"><?= lang('header') ?: 'En-tête'; ?></label>
                <?= form_textarea('header', set_value('header'), 'class="form-control" id="header" rows="3"'); ?>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold" for="footer"><?= lang('footer') ?: 'Pied de page'; ?></label>
                <?= form_textarea('footer', set_value('footer'), 'class="form-control" id="footer" rows="3"'); ?>
            </div>
        </div>
    </div>
</div>

<?= form_close(); ?>

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
