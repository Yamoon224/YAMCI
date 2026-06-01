<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- ============================
     HEADER PAGE + ACTIONS (style template Pixinvent)
     ============================ -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <?php echo lang('sales') ?: 'Ventes'; ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?php echo $warehouse_id ? $warehouse->name : lang('all_warehouses'); ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Consultez et gérez l'ensemble des ventes du magasin</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url('welcome'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo lang('sales') ?: 'Ventes'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('sales/add'); ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i>
      <?php echo lang('add_sale') ?: 'Nouvelle vente'; ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
            <i class="ri ri-file-excel-2-line me-2" style="font-size:14px"></i><?php echo lang('export_to_excel') ?: 'Excel'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="#" id="combine" data-action="combine">
            <i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i><?php echo lang('combine_to_pdf') ?: 'PDF groupé'; ?>
          </a>
        </li>
        <?php if (defined('SHOP') && SHOP): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?php echo lang('filter_by') ?: 'Filtrer par'; ?></h6></li>
        <li>
          <a class="dropdown-item<?php echo $this->input->get('shop') == 'yes' ? ' active' : ''; ?>" href="<?php echo admin_url('sales?shop=yes'); ?>">
            <i class="ri ri-shopping-cart-line me-2" style="font-size:14px"></i><?php echo lang('shop_sales') ?: 'Ventes boutique'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item<?php echo $this->input->get('shop') == 'no' ? ' active' : ''; ?>" href="<?php echo admin_url('sales?shop=no'); ?>">
            <i class="ri ri-heart-line me-2" style="font-size:14px"></i><?php echo lang('staff_sales') ?: 'Ventes staff'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item<?php echo !$this->input->get('shop') ? ' active' : ''; ?>" href="<?php echo admin_url('sales'); ?>">
            <i class="ri ri-list-check-line me-2" style="font-size:14px"></i><?php echo lang('all_sales') ?: 'Toutes'; ?>
          </a>
        </li>
        <?php endif; ?>
        <?php if (!empty($warehouses)): ?>
        <li><hr class="dropdown-divider"></li>
        <li><h6 class="dropdown-header"><?php echo lang('warehouses') ?: 'Entrepôts'; ?></h6></li>
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales'); ?>">
            <i class="ri ri-building-line me-2" style="font-size:14px"></i><?php echo lang('all_warehouses') ?: 'Tous'; ?>
          </a>
        </li>
        <?php foreach ($warehouses as $w): ?>
        <li>
          <a class="dropdown-item<?php echo ($warehouse_id == $w->id ? ' active' : ''); ?>" href="<?php echo admin_url('sales/' . $w->id); ?>">
            <i class="ri ri-building-4-line me-2" style="font-size:14px"></i><?php echo $w->name; ?>
          </a>
        </li>
        <?php endforeach; ?>
        <?php endif; ?>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger bpo" href="#"
             title="<b><?php echo lang('delete_sales'); ?></b>"
             data-content="<p><?php echo lang('r_u_sure'); ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?php echo lang('i_m_sure'); ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?php echo lang('no'); ?></button>"
             data-html="true" data-placement="left">
            <i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?php echo lang('delete_sales') ?: 'Supprimer'; ?>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- ============================
     STATS WIDGETS (style Pixinvent : 4 KPIs)
     ============================ -->
<div class="card mb-6">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('total_sales') ?: 'Total ventes'; ?></p>
              <h4 class="mb-1"><?php echo number_format($stats->total_sales); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary"><?php echo lang('orders') ?: 'commandes'; ?></span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-primary">
                <i class="ri ri-shopping-cart-2-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('total_amount') ?: 'CA total'; ?></p>
              <h4 class="mb-1"><?php echo $this->sma->formatMoney($stats->total_amount); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success"><?php echo lang('all_sales') ?: 'toutes ventes'; ?></span></p>
            </div>
            <div class="avatar me-lg-6">
              <span class="avatar-initial rounded-3 bg-label-success">
                <i class="ri ri-money-dollar-circle-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('pending') ?: 'En attente'; ?></p>
              <h4 class="mb-1 <?php echo $stats->pending > 0 ? 'text-warning' : ''; ?>"><?php echo number_format($stats->pending); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-warning"><?php echo lang('payment_pending') ?: 'paiement en attente'; ?></span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-warning">
                <i class="ri ri-time-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('credit') ?: 'Crédit'; ?></p>
              <h4 class="mb-1 <?php echo $stats->credit > 0 ? 'text-danger' : ''; ?>"><?php echo $this->sma->formatMoney($stats->credit); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-danger"><?php echo lang('due_balance') ?: 'restant dû'; ?></span></p>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded-3 bg-label-danger">
                <i class="ri ri-bank-card-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])):
    echo admin_form_open('sales/sale_actions', 'id="action-form"');
endif; ?>

<!-- ============================
     CARTE LISTE VENTES
     ============================ -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?php echo lang('filter') ?: 'Filtre'; ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterSaleStatus" class="form-select">
          <option value=""><?php echo lang('all_sale_status') ?: 'Tout statut'; ?></option>
          <?php foreach ($statuses_sale as $key => $label): ?>
            <option value="<?php echo htmlspecialchars($label, ENT_QUOTES); ?>"><?php echo htmlspecialchars($label); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterPaymentStatus" class="form-select">
          <option value=""><?php echo lang('all_payment_status') ?: 'Tout paiement'; ?></option>
          <?php foreach ($statuses_payment as $key => $label): ?>
            <option value="<?php echo htmlspecialchars($label, ENT_QUOTES); ?>"><?php echo htmlspecialchars($label); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterBiller" class="form-select">
          <option value=""><?php echo lang('all_billers') ?: 'Tous facturiers'; ?></option>
          <?php if (!empty($billers)) foreach ($billers as $b): ?>
            <option value="<?php echo htmlspecialchars($b->company ?: ($b->name ?? ''), ENT_QUOTES); ?>"><?php echo htmlspecialchars($b->company ?: ($b->name ?? '')); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar : search -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?php echo lang('search') ?: 'Rechercher'; ?>" />
    </div>
    <div class="text-muted small">
      <i class="ri ri-information-line me-1" style="font-size:14px;vertical-align:-0.15em"></i>
      <?php echo lang('click_row_for_invoice') ?: 'Cliquez sur une ligne pour ouvrir la facture'; ?>
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="SLData" class="datatables-order table table-hover" aria-label="<?php echo lang('sales'); ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkbox checkft" type="checkbox" name="check" />
          </th>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('biller') ?: 'Facturier'; ?></th>
          <th><?php echo lang('customer') ?: 'Client'; ?></th>
          <th><?php echo lang('status') ?: 'Statut'; ?></th>
          <th class="text-end"><?php echo lang('grand_total') ?: 'Total'; ?></th>
          <th class="text-end"><?php echo lang('paid') ?: 'Payé'; ?></th>
          <th class="text-end"><?php echo lang('balance') ?: 'Solde'; ?></th>
          <th><?php echo lang('payment') ?: 'Paiement'; ?></th>
          <th style="width:30px; text-align:center;">
            <i class="ri ri-attachment-2" style="font-size:18px"></i>
          </th>
          <th style="display:none;"></th>
          <th style="width:90px; text-align:center;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="12" class="text-center dataTables_empty py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
            <?php echo lang('loading_data') ?: 'Chargement...'; ?>
          </td>
        </tr>
      </tbody>
      <tfoot>
        <tr class="fw-semibold">
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th class="text-end"><?php echo lang('total') ?: 'Total'; ?> :</th>
          <th class="text-end" id="ft-total">0</th>
          <th class="text-end" id="ft-paid">0</th>
          <th class="text-end" id="ft-balance">0</th>
          <th></th>
          <th></th>
          <th style="display:none;"></th>
          <th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?php echo form_submit('performAction', 'performAction', 'id="action-form-submit"'); ?>
</div>
<?php echo form_close(); ?>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var oTable;

  /* ─── Mapping statut → couleur badge ─── */
  function statusBadge(status) {
    if (!status) return '<span class="text-muted">—</span>';
    var s = String(status).toLowerCase();
    var color = 'secondary';
    if (s.indexOf('compl') === 0 || s === 'paid' || s === 'payé' || s === 'paye' || s === 'sent') color = 'success';
    else if (s === 'pending' || s.indexOf('attent') === 0) color = 'warning';
    else if (s === 'partial' || s.indexOf('partiel') === 0) color = 'info';
    else if (s === 'due' || s === 'returned' || s.indexOf('retour') === 0) color = 'danger';
    return '<span class="badge rounded-pill bg-label-' + color + '">' + status + '</span>';
  }

  /* ─── Renderer "Référence" : code + lien icône ─── */
  function renderReference(data) {
    if (!data) return '';
    return '<span class="fw-semibold text-primary">' + data + '</span>';
  }

  /* ─── Renderer "Client" : avatar initiale + nom ─── */
  function renderCustomer(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var initial = data.toString().substring(0, 2).toUpperCase();
    var colors = ['primary','success','warning','info','danger','secondary','dark'];
    var idx = 0;
    for (var i = 0; i < data.length; i++) idx = (idx + data.charCodeAt(i)) % colors.length;
    var color = colors[idx];
    return '<div class="d-flex justify-content-start align-items-center">' +
             '<div class="avatar-wrapper me-3">' +
               '<div class="avatar rounded-2 bg-label-' + color + '">' +
                 '<span class="avatar-initial rounded-2">' + initial + '</span>' +
               '</div>' +
             '</div>' +
             '<span class="text-truncate">' + data + '</span>' +
           '</div>';
  }

  /* ─── Renderer "Actions" : edit icon + dropdown ─── */
  function renderActions(data, type, row) {
    var id = row[0];
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?php echo admin_url('sales/edit'); ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill sledit" title="<?php echo lang('edit'); ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">' +
                 '<i class="ri ri-more-2-line" style="font-size:20px"></i>' +
               '</button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('sales/view'); ?>/' + id + '"><i class="ri ri-eye-line me-2" style="font-size:14px"></i><?php echo lang('view'); ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('sales/pdf'); ?>/' + id + '"><i class="ri ri-file-pdf-line me-2" style="font-size:14px"></i><?php echo lang('pdf') ?: 'PDF'; ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('sales/email'); ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-mail-line me-2" style="font-size:14px"></i><?php echo lang('email') ?: 'E-mail'; ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('sales/payments'); ?>/' + id + '" data-bs-toggle="modal" data-bs-target="#myModal2"><i class="ri ri-money-dollar-circle-line me-2" style="font-size:14px"></i><?php echo lang('payments'); ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('sales/return_sale'); ?>/' + id + '"><i class="ri ri-arrow-go-back-line me-2" style="font-size:14px"></i><?php echo lang('return_sale') ?: 'Retour'; ?></a></li>' +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?php echo lang('delete'); ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#SLData').dataTable({
      "aaSorting": [[1, "desc"], [2, "desc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?php echo lang('all'); ?>"]],
      "iDisplayLength": <?php echo $Settings->rows_per_page; ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      "bProcessing": true, "bServerSide": true,
      "sAjaxSource": "<?php echo admin_url('sales/getSales' . ($warehouse_id ? '/' . $warehouse_id : '') . '?v=1' . ($this->input->get('shop') ? '&shop=' . $this->input->get('shop') : '') . ($this->input->get('attachment') ? '&attachment=' . $this->input->get('attachment') : '') . ($this->input->get('delivery') ? '&delivery=' . $this->input->get('delivery') : '')); ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>"});
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "fnRowCallback": function (nRow, aData) {
        nRow.id = aData[0];
        nRow.setAttribute("data-return-id", aData[11]);
        nRow.className = "invoice_link re" + aData[11];
        return nRow;
      },
      "aoColumns": [
        { "bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input checkbox" value="'+d+'">'; } },
        { "mRender": typeof fld === 'function' ? fld : null },     /* Date */
        { "mRender": renderReference },                            /* Référence */
        null,                                                       /* Biller */
        { "mRender": renderCustomer },                              /* Customer */
        { "mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; } },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": typeof currencyFormat === 'function' ? currencyFormat : null },
        { "mRender": function(d, t){ return t === 'display' ? statusBadge(d) : d; } },
        { "bSortable": false, "mRender": typeof attachment === 'function' ? attachment : null },
        { "bVisible": false },
        { "bSortable": false, "mRender": renderActions }
      ],
      "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
        var gtotal = 0, paid = 0, balance = 0;
        for (var i = 0; i < aaData.length; i++) {
          gtotal  += parseFloat(aaData[aiDisplay[i]][6])  || 0;
          paid    += parseFloat(aaData[aiDisplay[i]][7])  || 0;
          balance += parseFloat((aaData[aiDisplay[i]][8] || '').toString().replace(/,/g, '')) || 0;
        }
        var fmt = typeof currencyFormat === 'function' ? currencyFormat : function(v){ return v.toFixed(2); };
        $('#ft-total').html(fmt(gtotal));
        $('#ft-paid').html(fmt(paid));
        $('#ft-balance').html(fmt(balance));
      }
    }).fnSetFilteringDelay();

    /* ─── Filtres custom (header dropdowns) ─── */
    $('#filterSaleStatus').on('change', function () {
      $('#SLData').dataTable().fnFilter($(this).val(), 5, false, false, true);
    });
    $('#filterPaymentStatus').on('change', function () {
      $('#SLData').dataTable().fnFilter($(this).val(), 9, false, false, true);
    });
    $('#filterBiller').on('change', function () {
      $('#SLData').dataTable().fnFilter($(this).val(), 3, false, false, true);
    });
    $('#customDtSearch').on('keyup input', function () {
      $('#SLData').dataTable().fnFilter($(this).val());
    });

    /* Clear localStorage on return */
    var lsKeys = ['slitems','sldiscount','sltax2','slref','slshipping','slwarehouse','slnote','slinnote','slcustomer','slbiller','slcurrency','sldate','slsale_status','slpayment_status','paid_by','amount_1','paid_by_1','pcc_holder_1','pcc_type_1','pcc_month_1','pcc_year_1','pcc_no_1','cheque_no_1','slpayment_term'];
    if (localStorage.getItem("remove_slls")) {
      $.each(lsKeys, function (i, k) { localStorage.removeItem(k); });
      localStorage.removeItem("remove_slls");
    }
    <?php if ($this->session->userdata('remove_slls')):
          $this->sma->unset_data('remove_slls'); ?>
    $.each(lsKeys, function (i, k) { localStorage.removeItem(k); });
    <?php endif; ?>

    $(document).on("click", ".sledit, .slduplicate", function (e) {
      if (localStorage.getItem("slitems")) {
        e.preventDefault();
        var href = $(this).attr("href");
        bootbox.confirm("<?php echo lang('you_will_loss_sale_data'); ?>", function (result) {
          if (result) { window.location.href = href; }
        });
      }
    });
  });
})();
</script>
