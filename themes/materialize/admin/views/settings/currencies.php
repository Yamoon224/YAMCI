<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-money-dollar-circle-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('currencies') ?: 'Devises'); ?></h4>
        <p class="mb-0 text-muted">Gestion des devises et taux de change utilisés dans l'application.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('system_settings') ?>"><?= lang('system_settings') ?: 'Paramètres'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('currencies') ?: 'Devises'; ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <a href="<?= admin_url('system_settings/add_currency') ?>"
           class="btn btn-primary"
           data-bs-toggle="modal" data-bs-target="#ajaxModal">
            <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_currency') ?: 'Ajouter une devise'; ?>
        </a>
    </div>
</div>

<?= admin_form_open('system_settings/currency_actions', 'id="action-form"') ?>

<div class="card">
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
                        <?= lang('delete_currencies') ?: 'Supprimer'; ?>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table id="CurrencyTable" class="table table-hover">
            <thead>
                <tr>
                    <th style="width:40px;" class="text-center">
                        <input class="form-check-input" type="checkbox" id="checkAll" />
                    </th>
                    <th><?= lang('currency_code') ?></th>
                    <th><?= lang('currency_name') ?></th>
                    <th><?= lang('exchange_rate') ?></th>
                    <th><?= lang('symbol') ?></th>
                    <th class="text-center">
                        <span class="badge bg-label-success"><?= lang('default') ?></span>
                    </th>
                    <th style="width:100px;" class="text-center"><?= lang('actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="7" class="text-center"><?= lang('loading_data_from_server') ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="d-none">
    <input type="hidden" name="form_action" value="" id="form_action" />
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>

<script>
$(document).ready(function () {
    var oTable = $('#CurrencyTable').dataTable({
        "aaSorting": [[1, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "<?= admin_url('system_settings/getCurrencies') ?>",
        "fnServerData": function (sSource, aoData, fnCallback) {
            aoData.push({
                "name": "<?= $this->security->get_csrf_token_name() ?>",
                "value": "<?= $this->security->get_csrf_hash() ?>"
            });
            $.ajax({ "dataType": "json", "type": "POST", "url": sSource, "data": aoData, "success": fnCallback });
        },
        "aoColumns": [
            { "bSortable": false, "mRender": checkbox },
            null,
            null,
            null,
            null,
            { "bSortable": false },
            { "bSortable": false }
        ]
    });

    $('#checkAll').on('change', function () {
        $('input.multi-select').prop('checked', $(this).is(':checked'));
    });

    $('#btn-delete').on('click', function (e) {
        e.preventDefault();
        $('#form_action').val($(this).data('action'));
        $('#action-form-submit').trigger('click');
    });

    $('#btn-export-excel').on('click', function (e) {
        e.preventDefault();
        $('#form_action').val($(this).data('action'));
        $('#action-form-submit').trigger('click');
    });
});
</script>
