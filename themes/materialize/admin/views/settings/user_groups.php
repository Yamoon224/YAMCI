<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-team-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('groups') ?: "Groupes d'utilisateurs"); ?></h4>
        <p class="mb-0 text-muted">Rôles et permissions accordés aux utilisateurs de l'application.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('system_settings') ?>"><?= lang('system_settings') ?: 'Paramètres'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('groups') ?: "Groupes d'utilisateurs"; ?></li>
            </ol>
        </nav>
    </div>
    <?php if (isset($Owner) && $Owner): ?>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <a href="<?= admin_url('system_settings/create_group') ?>"
           class="btn btn-primary"
           data-bs-toggle="modal" data-bs-target="#ajaxModal">
            <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_group') ?: 'Ajouter un groupe'; ?>
        </a>
    </div>
    <?php endif; ?>
</div>

<?php if (isset($Owner) && $Owner): ?>
<?= admin_form_open('system_settings/group_actions', 'id="action-form"') ?>
<?php endif; ?>

<div class="card">
    <?php if (isset($Owner) && $Owner): ?>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0"><?= lang('list_results') ?: 'Liste'; ?></h5>
        <div class="dropdown">
            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <span class="icon-base ri ri-settings-3-line me-1 icon-16px"></span>
                <?= lang('actions') ?: 'Actions'; ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#" id="btn-export-excel" data-action="export_excel">
                        <span class="icon-base ri ri-file-excel-line me-2 text-success icon-16px"></span>
                        <?= lang('export_to_excel') ?: 'Excel'; ?>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger" href="#" id="btn-delete" data-action="delete">
                        <span class="icon-base ri ri-delete-bin-line me-2 icon-16px"></span>
                        <?= lang('delete_groups') ?: 'Supprimer'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <?php endif; ?>
    <div class="card-datatable table-responsive">
        <table id="UserGroupTable" class="table table-hover">
            <thead>
                <tr>
                    <?php if (isset($Owner) && $Owner): ?>
                    <th style="width:40px;" class="text-center">
                        <input class="form-check-input" type="checkbox" id="checkAll" />
                    </th>
                    <?php endif; ?>
                    <th style="width:60px;"><?= lang('group_id') ?></th>
                    <th><?= lang('group_name') ?></th>
                    <th><?= lang('group_description') ?></th>
                    <th style="width:120px;" class="text-center"><?= lang('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($groups as $group): ?>
                <tr>
                    <?php if (isset($Owner) && $Owner): ?>
                    <td class="text-center">
                        <input class="form-check-input multi-select" type="checkbox" name="val[]" value="<?= $group->id ?>" />
                    </td>
                    <?php endif; ?>
                    <td><span class="badge bg-label-secondary"><?= $group->id ?></span></td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <span class="avatar avatar-xs bg-label-primary rounded-circle">
                                <i class="icon-base ri ri-group-line icon-20px"></i>
                            </span>
                            <span class="fw-medium"><?= htmlspecialchars($group->name) ?></span>
                        </div>
                    </td>
                    <td class="text-muted"><?= htmlspecialchars($group->description) ?></td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="<?= admin_url('system_settings/permissions/' . $group->id) ?>"
                               class="btn btn-sm btn-icon btn-label-warning"
                               title="<?= lang('change_permissions') ?>">
                                <i class="icon-base ri ri-shield-keyhole-line icon-20px"></i>
                            </a>
                            <?php if (isset($Owner) && $Owner): ?>
                            <a href="<?= admin_url('system_settings/edit_group/' . $group->id) ?>"
                               class="btn btn-sm btn-icon btn-label-info"
                               data-bs-toggle="modal" data-bs-target="#ajaxModal"
                               title="<?= lang('edit_group') ?>">
                                <i class="icon-base ri ri-pencil-line icon-20px"></i>
                            </a>
                            <a href="<?= admin_url('system_settings/delete_group/' . $group->id) ?>"
                               class="btn btn-sm btn-icon btn-label-danger confirm-delete"
                               title="<?= lang('delete_group') ?>"
                               data-confirm="<?= lang('r_u_sure') ?>">
                                <i class="icon-base ri ri-delete-bin-line icon-20px"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php if (isset($Owner) && $Owner): ?>
<div class="d-none">
    <input type="hidden" name="form_action" value="" id="form_action" />
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php endif; ?>

<script>
$(document).ready(function () {
    var colCount = <?= (isset($Owner) && $Owner) ? 5 : 4 ?>;

    $('#UserGroupTable').dataTable({
        "aaSorting": [[<?= (isset($Owner) && $Owner) ? 1 : 0 ?>, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        "aoColumns": [
            <?php if (isset($Owner) && $Owner): ?>
            { "bSortable": false },
            <?php endif; ?>
            null,
            null,
            null,
            { "bSortable": false }
        ]
    });

    <?php if (isset($Owner) && $Owner): ?>
    $('#checkAll').on('change', function () {
        $('input.multi-select').prop('checked', $(this).is(':checked'));
    });

    $('#btn-delete').on('click', function (e) {
        e.preventDefault();
        if (!$('input.multi-select:checked').length) {
            return;
        }
        $('#form_action').val($(this).data('action'));
        $('#action-form-submit').trigger('click');
    });

    $('#btn-export-excel').on('click', function (e) {
        e.preventDefault();
        $('#form_action').val($(this).data('action'));
        $('#action-form-submit').trigger('click');
    });

    // Confirm delete for single row
    $(document).on('click', '.confirm-delete', function (e) {
        e.preventDefault();
        var url = $(this).attr('href');
        var msg = $(this).data('confirm') || '<?= lang('r_u_sure') ?>';
        if (confirm(msg)) {
            window.location.href = url;
        }
    });
    <?php endif; ?>
});
</script>
