<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-database-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('database_backups') ?: 'Sauvegardes'); ?></h4>
        <p class="mb-0 text-muted">Sauvegardes de la base de données — créer, télécharger ou restaurer une copie.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('system_settings') ?>"><?= lang('system_settings') ?: 'Paramètres'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('database_backups') ?: 'Sauvegardes'; ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <a href="<?= admin_url('system_settings/backup_database') ?>" class="btn btn-primary" id="btn-backup-db">
            <i class="ri ri-database-2-line me-1" style="font-size:16px"></i><?= lang('backup_database') ?: 'Nouvelle sauvegarde'; ?>
        </a>
    </div>
</div>

<div class="alert alert-warning d-flex align-items-start gap-2 mb-4" role="alert">
    <i class="icon-base ri ri-alert-line icon-20px flex-shrink-0 mt-1"></i>
    <div>
        <strong><?= lang('database_backups') ?></strong> &mdash;
        <?= lang('restore_heading') ?>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="icon-base ri ri-database-2-line icon-20px"></i>
        <h5 class="card-title mb-0"><?= lang('database_backups') ?></h5>
        <span class="badge bg-label-secondary ms-auto"><?= count($dbs) ?> <?= lang('backups') ?></span>
    </div>

    <?php if (!empty($dbs)): ?>
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th><?= lang('backup_file') ?></th>
                    <th><?= lang('date') ?></th>
                    <th class="text-center" style="width:180px;"><?= lang('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dbs as $file):
                    $file      = basename($file);
                    $date_string = substr($file, 13, 10);
                    $time_string = substr($file, 24, 8);
                    $date        = $date_string . ' ' . str_replace('-', ':', $time_string);
                    $bkdate      = $this->sma->hrld($date);
                    $file_base   = substr($file, 0, -4);
                ?>
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="avatar avatar-xs bg-label-primary rounded-circle flex-shrink-0">
                                <i class="icon-base ri ri-database-2-line icon-20px"></i>
                            </span>
                            <span class="fw-medium text-truncate" style="max-width:300px;" title="<?= htmlspecialchars($file) ?>">
                                <?= htmlspecialchars($file) ?>
                            </span>
                        </div>
                    </td>
                    <td>
                        <span class="text-muted">
                            <i class="icon-base ri ri-time-line icon-20px me-1"></i><?= $bkdate ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="<?= admin_url('system_settings/download_database/' . $file_base) ?>"
                               class="btn btn-sm btn-icon btn-label-primary"
                               title="<?= lang('download') ?>">
                                <i class="icon-base ri ri-download-line icon-20px"></i>
                            </a>
                            <a href="<?= admin_url('system_settings/restore_database/' . $file_base) ?>"
                               class="btn btn-sm btn-icon btn-label-warning restore-db"
                               title="<?= lang('restore') ?>"
                               data-confirm="<?= lang('restore_confirm') ?>">
                                <i class="icon-base ri ri-refresh-line icon-20px"></i>
                            </a>
                            <a href="<?= admin_url('system_settings/delete_database/' . $file_base) ?>"
                               class="btn btn-sm btn-icon btn-label-danger delete-backup"
                               title="<?= lang('delete') ?>"
                               data-confirm="<?= lang('delete_confirm') ?>">
                                <i class="icon-base ri ri-delete-bin-line icon-20px"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
    <div class="card-body">
        <div class="text-center py-5">
            <i class="icon-base ri ri-database-2-line icon-20px text-muted mb-3 d-block" style="font-size:3rem;"></i>
            <p class="text-muted mb-3"><?= lang('no_backups_found') ?></p>
            <a href="<?= admin_url('system_settings/backup_database') ?>" class="btn btn-primary" id="btn-backup-db-empty">
                <i class="icon-base ri ri-database-2-line icon-20px me-1"></i><?= lang('backup_database') ?>
            </a>
        </div>
    </div>
    <?php endif; ?>
</div>

<!-- Wait modal (Bootstrap 5) -->
<div class="modal fade" id="wModal" tabindex="-1" aria-labelledby="wModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="wModalLabel"><?= lang('please_wait') ?></h5>
            </div>
            <div class="modal-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="spinner-border text-primary flex-shrink-0" role="status">
                        <span class="visually-hidden"><?= lang('please_wait') ?></span>
                    </div>
                    <span><?= lang('backup_modal_msg') ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    // Create backup — show wait modal then redirect
    $('#btn-backup-db, #btn-backup-db-empty').on('click', function (e) {
        e.preventDefault();
        var href = '<?= admin_url('system_settings/backup_database') ?>';
        $('#wModalLabel').text('<?= lang('backup_modal_heading') ?>');
        var modal = new bootstrap.Modal(document.getElementById('wModal'));
        modal.show();
        window.location.href = href;
    });

    // Restore database
    $(document).on('click', '.restore-db', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var msg  = $(this).data('confirm') || '<?= lang('restore_confirm') ?>';
        if (confirm(msg)) {
            window.location.href = href;
        }
    });

    // Delete backup
    $(document).on('click', '.delete-backup', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        var msg  = $(this).data('confirm') || '<?= lang('delete_confirm') ?>';
        if (confirm(msg)) {
            window.location.href = href;
        }
    });

});
</script>
