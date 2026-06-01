<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-building-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('billers') ?: 'Facturiers' ?></h4>
    <p class="mb-0 text-muted">Entités émettrices de factures et leur configuration</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>"><?= lang('home') ?: 'Accueil' ?></a></li>
        <li class="breadcrumb-item active"><?= lang('billers') ?: 'Facturiers' ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('billers/add') ?>" id="add"
       data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_biller') ?: 'Nouveau facturier' ?>
    </a>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])):
    echo admin_form_open('billers/biller_actions', 'id="action-form"');
endif; ?>

<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <h5 class="card-title mb-0"><i class="ri ri-list-check-line me-2" style="font-size:18px;vertical-align:-0.15em"></i>Liste des facturiers</h5>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
            <div class="dropdown">
                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="icon-base ri ri-more-2-line icon-20px"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
                            <i class="icon-base ri ri-file-excel-line icon-20px me-2 text-success"></i><?= lang('export_to_excel') ?>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#"
                           onclick="if(confirm('<?= lang('r_u_sure') ?>')) { document.getElementById('form_action').value='delete'; document.getElementById('action-form-submit').click(); } return false;">
                            <i class="icon-base ri ri-delete-bin-line icon-20px me-2"></i><?= lang('delete_billers') ?>
                        </a>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="card-datatable table-responsive">
        <table id="SupData" cellpadding="0" cellspacing="0" border="0"
               class="table table-bordered table-hover">
            <thead>
            <tr>
                <th style="min-width:30px; width:30px; text-align:center;">
                    <input class="form-check-input checkbox checkth" type="checkbox" name="check"/>
                </th>
                <th><?= lang('company') ?></th>
                <th><?= lang('name') ?></th>
                <th><?= lang('vat_no') ?></th>
                <th><?= lang('phone') ?></th>
                <th><?= lang('email_address') ?></th>
                <th><?= lang('city') ?></th>
                <th><?= lang('country') ?></th>
                <th style="width:85px;"><?= lang('actions') ?></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
            </tr>
            </tbody>
            <tfoot class="dtFilter">
            <tr class="active">
                <th style="min-width:30px; width:30px; text-align:center;">
                    <input class="form-check-input checkbox checkft" type="checkbox" name="check"/>
                </th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th style="width:85px;" class="text-center"><?= lang('actions') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
<div style="display:none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php endif; ?>

<?php if (isset($action) && $action == 'add'): ?>
<script>$(document).ready(function(){ $("#add").trigger("click"); });</script>
<?php endif; ?>

<script>
$(document).ready(function () {
    oTable = $('#SupData').dataTable({
        "aaSorting": [[1, "asc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('billers/getBillers') ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        "aoColumns": [{"bSortable": false, "mRender": checkbox}, null, null, null, null, null, null, null, {"bSortable": false}]
    }).dtFilter([
        {column_number: 1, filter_default_label: "[<?= lang('company') ?>]", filter_type: "text", data: []},
        {column_number: 2, filter_default_label: "[<?= lang('name') ?>]", filter_type: "text", data: []},
        {column_number: 3, filter_default_label: "[<?= lang('vat_no') ?>]", filter_type: "text", data: []},
        {column_number: 4, filter_default_label: "[<?= lang('phone') ?>]", filter_type: "text", data: []},
        {column_number: 5, filter_default_label: "[<?= lang('email_address') ?>]", filter_type: "text", data: []},
        {column_number: 6, filter_default_label: "[<?= lang('city') ?>]", filter_type: "text", data: []},
        {column_number: 7, filter_default_label: "[<?= lang('country') ?>]", filter_type: "text", data: []},
    ], "footer");
});
</script>
