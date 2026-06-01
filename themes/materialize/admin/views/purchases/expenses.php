<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-money-dollar-box-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('expenses') ?: 'Dépenses' ?></h4>
    <p class="mb-0 text-muted">Suivez les dépenses de votre activité par catégorie</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('purchases') ?>"><?= lang('purchases') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('expenses') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('purchases/add_expense') ?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('add_expense') ?: 'Nouvelle dépense' ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel"><i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?></a></li>
        <?php if ($Owner): ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger bpo" href="#"
             title="<b><?= lang('delete_expenses') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
          <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_expenses') ?>
        </a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<?php if ($Owner) {
    echo admin_form_open('purchases/expense_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE DÉPENSES -->
<div class="card">

  <!-- toolbar : custom search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir la dépense
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="EXPData" class="datatables-expenses table table-hover" aria-label="<?= lang('expenses') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('reference') ?></th>
          <th><?= lang('category') ?></th>
          <th><?= lang('warehouse') ?></th>
          <th class="text-end"><?= lang('amount') ?></th>
          <th><?= lang('note') ?></th>
          <th><?= lang('created_by') ?></th>
          <th style="width:30px; text-align:center;"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="10" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th><th></th><th></th><th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-exp-total">0</th>
          <th></th><th></th><th></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner) { ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<?php } ?>

<script>
(function () {
  'use strict';
  var oTable;

  function renderRef(d) { return d ? '<span class="fw-semibold text-primary">' + d + '</span>' : ''; }

  function renderCategory(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    return '<span class="badge rounded-pill bg-label-' + colors[idx] + '">' + data + '</span>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('purchases/edit_expense') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('purchases/expense_note') ?>/' + id + '"><i class="ri ri-printer-line me-2" style="font-size:14px"></i><?= lang('print') ?: 'Imprimer' ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#EXPData').dataTable({
      "aaSorting": [[1, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      "bProcessing": true, "bServerSide": true,
      "sAjaxSource": "<?= admin_url('purchases/getExpenses') ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "aoColumns": [
        { "bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; } },
        { "mRender": typeof fld === 'function' ? fld : null },
        { "mRender": renderRef },
        { "mRender": renderCategory },
        null,
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        null, null,
        { "bSortable": false, "mRender": typeof attachment === 'function' ? attachment : null },
        { "bSortable": false, "mRender": renderActions }
      ],
      "fnRowCallback": function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "expense_link";
        return nRow;
      },
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var total = 0;
        for (var i = 0; i < aaData.length; i++) total += parseFloat(aaData[aiDisplay[i]][5]) || 0;
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-exp-total').html(fmt(total));
      }
    });

    $('#customDtSearch').on('keyup input', function () { $('#EXPData').dataTable().fnFilter($(this).val()); });
  });
})();
</script>
