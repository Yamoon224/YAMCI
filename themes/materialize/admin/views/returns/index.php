<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-arrow-go-back-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('Retours') ?: 'Retours' ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?= $warehouse_id ? $warehouse->name : lang('all_warehouses') ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Retours de ventes effectués par les clients</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('Retours') ?: 'Retours' ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="#" id="excel" data-action="export_excel">
          <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?= lang('export_to_excel') ?: 'Excel' ?>
        </a></li>
        <?php if (!empty($warehouses)): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?= lang('warehouses') ?></h6></li>
        <li><a class="dropdown-item" href="<?= admin_url('returns') ?>"><i class="ri ri-building-line me-2" style="font-size:14px"></i><?= lang('all_warehouses') ?></a></li>
        <?php foreach ($warehouses as $w): ?>
        <li><a class="dropdown-item<?= ($warehouse_id == $w->id ? ' active' : '') ?>" href="<?= admin_url('returns/' . $w->id) ?>"><i class="ri ri-building-4-line me-2" style="font-size:14px"></i><?= $w->name ?></a></li>
        <?php endforeach; ?>
        <?php endif; ?>
        <?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger bpo" href="#"
             title="<b><?= lang('delete_returns') ?></b>"
             data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?= lang('i_m_sure') ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button>"
             data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete_returns') ?: 'Supprimer' ?>
        </a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</div>

<!-- STATS WIDGETS -->
<div class="card mb-6">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Total retours</p>
              <h4 class="mb-1"><?= number_format($stats->total ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary">tous</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-primary"><i class="ri ri-arrow-go-back-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Montant total</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->total_amount ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-danger">remboursé</span></p>
            </div>
            <div class="avatar me-lg-6"><span class="avatar-initial rounded-3 bg-label-danger"><i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i></span></div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted">Ce mois</p>
              <h4 class="mb-1"><?= number_format($stats->month_count ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-info">retours</span></p>
            </div>
            <div class="avatar me-sm-6"><span class="avatar-initial rounded-3 bg-label-info"><i class="ri ri-calendar-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted">Montant ce mois</p>
              <h4 class="mb-1"><?= $this->sma->formatMoney($stats->month_amount ?? 0) ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning">en cours</span></p>
            </div>
            <div class="avatar"><span class="avatar-initial rounded-3 bg-label-warning"><i class="ri ri-pie-chart-2-line" style="font-size:28px"></i></span></div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) {
    echo admin_form_open('returns/return_actions', 'id="action-form"');
} ?>

<!-- CARTE LISTE RETOURS -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?= lang('filter') ?: 'Filtre' ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-6">
        <select id="filterCustomer" class="form-select">
          <option value="">Tous clients</option>
          <?php if (!empty($customers_list)) foreach ($customers_list as $c): ?>
            <option value="<?= htmlspecialchars($c->company ?: ($c->name ?? ''), ENT_QUOTES) ?>"><?= htmlspecialchars($c->company ?: ($c->name ?? '')) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-6">
        <select id="filterPaymentStatus" class="form-select">
          <option value="">Tout statut paiement</option>
          <?php foreach ($statuses_payment as $key => $label): ?>
            <option value="<?= htmlspecialchars($label, ENT_QUOTES) ?>"><?= htmlspecialchars($label) ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar : custom search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?= lang('search') ?: 'Rechercher' ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      Cliquez sur une ligne pour ouvrir le retour
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="REData" class="datatables-returns table table-hover" aria-label="<?= lang('Retours') ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkft" type="checkbox" name="check" />
          </th>
          <th><?= lang('date') ?></th>
          <th><?= lang('reference_no') ?></th>
          <th><?= lang('biller') ?></th>
          <th><?= lang('customer') ?></th>
          <th class="text-end"><?= lang('grand_total') ?></th>
          <th style="width:30px; text-align:center;"><i class="ri ri-attachment-2" style="font-size:18px"></i></th>
          <th style="width:90px; text-align:center;"><?= lang('actions') ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="8" class="dataTables_empty text-center py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div><?= lang('loading_data_from_server') ?: 'Chargement…' ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th><th></th><th></th><th></th>
          <th class="text-end">Total :</th>
          <th class="text-end" id="ft-re-total">0</th>
          <th></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])) { ?>
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

  function renderName(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var initial = data.toString().substring(0, 2).toUpperCase();
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    return '<div class="d-flex align-items-center"><div class="avatar-wrapper me-2"><div class="avatar avatar-sm rounded-circle bg-label-' + colors[idx] + '"><span class="avatar-initial rounded-circle">' + initial + '</span></div></div><span class="text-truncate">' + data + '</span></div>';
  }

  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?= admin_url('returns/edit') ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill reedit" title="<?= lang('edit') ?>"><i class="ri ri-edit-box-line" style="font-size:20px"></i></a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="ri ri-more-2-line" style="font-size:20px"></i></button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?= admin_url('returns/view') ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?= lang('view') ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#REData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
      "iDisplayLength": <?= $Settings->rows_per_page ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      'bProcessing': true, 'bServerSide': true,
      'sAjaxSource': '<?= admin_url('returns/getReturns' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>',
      'fnServerData': function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
        $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
      },
      'fnRowCallback': function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "oreturn_link";
        return nRow;
      },
      "aoColumns": [
        {"bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input" value="'+d+'">'; }},
        {"mRender": typeof fld === 'function' ? fld : null},
        {"mRender": renderRef},
        null,                                  /* biller */
        {"mRender": renderName},                /* customer */
        {"mRender": typeof currencyFormat === 'function' ? currencyFormat : null},
        {"bSortable": false, "mRender": typeof attachment === 'function' ? attachment : null},
        {"bSortable": false, "mRender": renderActions}
      ],
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var gtotal = 0;
        for (var i = 0; i < aaData.length; i++) gtotal += parseFloat(aaData[aiDisplay[i]][5]) || 0;
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-re-total').html(fmt(gtotal));
      }
    }).fnSetFilteringDelay();

    $('#filterCustomer').on('change', function () { $('#REData').dataTable().fnFilter($(this).val(), 4, false, false, true); });
    $('#customDtSearch').on('keyup input', function () { $('#REData').dataTable().fnFilter($(this).val()); });

    /* Clear stale localStorage */
    if (localStorage.getItem('remove_rels')) {
      ['reitems','rediscount','retax2','reref','rewarehouse','renote','reinnote','recustomer','rebiller','redate'].forEach(function(k){ localStorage.removeItem(k); });
      localStorage.removeItem('remove_rels');
    }
    <?php if ($this->session->userdata('remove_rels')) { ?>
    ['reitems','rediscount','retax2','reref','rewarehouse','renote','reinnote','recustomer','rebiller','redate'].forEach(function(k){ localStorage.removeItem(k); });
    <?php $this->sma->unset_data('remove_rels'); } ?>

    $(document).on('click', '.reedit', function (e) {
      if (localStorage.getItem('reitems')) {
        e.preventDefault();
        var href = $(this).attr('href');
        bootbox.confirm("<?= lang('you_will_loss_return_data') ?>", function (result) {
          if (result) { window.location.href = href; }
        });
      }
    });
  });
})();
</script>
