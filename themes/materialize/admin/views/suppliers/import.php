<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mb-1">
                <li class="breadcrumb-item">
                    <a href="<?= admin_url('suppliers') ?>">
                        <span class="icon-base ri ri-team-line me-1 icon-16px"></span><?= lang('suppliers'); ?>
                    </a>
                </li>
                <li class="breadcrumb-item active"><?= lang('import'); ?></li>
            </ol>
        </nav>
        <h4 class="fw-bold mb-0">
            <span class="icon-base ri ri-upload-cloud-line me-1 icon-16px"></span><?= lang('import_by_csv'); ?>
        </h4>
    </div>
</div>

<!-- Alerts -->
<?php if (!empty($errors)): ?>
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
    <strong><span class="icon-base ri ri-close-circle-line me-1 icon-16px"></span><?= lang('errors'); ?></strong>
    <ul class="mb-0 mt-2">
        <?php foreach ($errors as $error): ?>
        <li><?= $error ?></li>
        <?php endforeach; ?>
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (!empty($success)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
    <span class="icon-base ri ri-checkbox-circle-line me-1 icon-16px"></span><?= $success ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <span class="icon-base ri ri-file-excel-line me-1 icon-16px"></span><?= lang('import_by_csv'); ?>
                </h5>
            </div>
            <div class="card-body">
                <!-- CSV format info -->
                <div class="alert alert-info mb-4">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="fw-semibold mb-1">
                                <span class="icon-base ri ri-information-line me-1 icon-16px"></span><?= lang('csv1'); ?>
                            </p>
                            <p class="mb-1"><?= lang('csv2'); ?>
                                <span class="text-primary">
                                    (<?= lang('company') . ', ' . lang('name') . ', ' . lang('email') . ', ' . lang('phone') . ', ' . lang('address') . ', ' . lang('city') . ', ' . lang('state') . ', ' . lang('postal_code') . ', ' . lang('country') . ', ' . lang('vat_no') . ', ' . lang('gst_no') . ', ' . lang('scf1') . ', ' . lang('scf2') . ', ' . lang('scf3') . ', ' . lang('scf4') . ', ' . lang('scf5') . ', ' . lang('scf6'); ?>)
                                </span>
                                <?= lang('csv3'); ?>
                            </p>
                            <p class="text-success mb-1 small"><?= lang('first_6_required'); ?></p>
                            <p class="text-primary mb-0 small"><?= lang('csv_update_tip'); ?></p>
                        </div>
                        <a href="<?= base_url() ?>assets/csv/sample.csv" class="btn btn-sm btn-outline-primary ms-3 flex-shrink-0">
                            <span class="icon-base ri ri-download-line me-1 icon-16px"></span><?= lang('download_sample_file') ?: 'Download Sample'; ?>
                        </a>
                    </div>
                </div>

                <!-- Upload form -->
                <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
                echo admin_form_open_multipart('suppliers/import_csv', $attrib); ?>

                <div class="mb-4">
                    <label class="form-label fw-semibold" for="csv_file">
                        <?= lang('upload_file'); ?> <span class="text-danger">*</span>
                    </label>
                    <input id="csv_file" type="file" name="csv_file"
                           class="form-control"
                           accept=".csv,.txt"
                           data-browse-label="<?= lang('browse'); ?>"
                           data-show-upload="false"
                           data-show-preview="false"
                           data-bv-notempty="true"
                           required="required" />
                    <div class="form-text"><?= lang('csv_file_hint') ?: 'Fichier CSV (séparateur : virgule)'; ?></div>
                </div>

                <div class="d-flex gap-2">
                    <a href="<?= admin_url('suppliers') ?>" class="btn btn-outline-secondary">
                        <span class="icon-base ri ri-arrow-left-line me-1 icon-16px"></span><?= lang('back'); ?>
                    </a>
                    <?= form_submit('import', lang('import'), 'class="btn btn-primary"'); ?>
                </div>

                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>
