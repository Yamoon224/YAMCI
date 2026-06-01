<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<div class="row mb-4">
  <div class="col-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-2">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('supplier_report') ?: 'Rapport Fournisseur'; ?></li>
      </ol>
    </nav>
    <h4 class="mb-1">
      <i class="ri ri-store-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
      <?php echo lang('supplier_report') ?: 'Rapport Fournisseur'; ?>
      <?php if (isset($supplier)): ?>
        <span class="text-muted fw-normal fs-6"> — <?php echo htmlspecialchars($supplier->company ?: $supplier->name); ?></span>
      <?php endif; ?>
    </h4>
  </div>
</div>

<?php if (isset($supplier)): ?>
<!-- KPI Cards -->
<div class="row g-4 mb-4">
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-primary rounded mx-auto mb-3">
          <span class="icon-base ri ri-shopping-bag-line icon-22px"></span>
        </div>
        <h5 class="mb-1"><?php echo $this->sma->formatMoney($purchases->total_amount ?? 0); ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('purchases_amount') ?: 'Montant achats'; ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-success rounded mx-auto mb-3">
          <span class="icon-base ri ri-check-line icon-22px"></span>
        </div>
        <h5 class="mb-1"><?php echo $this->sma->formatMoney($purchases->paid ?? 0); ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('total_paid') ?: 'Total payé'; ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-warning rounded mx-auto mb-3">
          <span class="icon-base ri ri-time-line icon-22px"></span>
        </div>
        <h5 class="mb-1 text-danger"><?php echo $this->sma->formatMoney(($purchases->total_amount ?? 0) - ($purchases->paid ?? 0)); ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('due_amount') ?: 'Solde dû'; ?></p>
      </div>
    </div>
  </div>
</div>

<!-- Supplier info -->
<div class="card mb-4">
  <div class="card-header"><h5 class="card-title mb-0"><?php echo lang('supplier_details') ?: 'Profil fournisseur'; ?></h5></div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-sm-6">
        <table class="table table-sm table-borderless mb-0">
          <tbody>
            <tr><td class="text-muted small"><?php echo lang('company') ?: 'Société'; ?></td><td><?php echo htmlspecialchars($supplier->company ?? ''); ?></td></tr>
            <tr><td class="text-muted small"><?php echo lang('email') ?: 'Email'; ?></td><td><?php echo htmlspecialchars($supplier->email ?? ''); ?></td></tr>
            <tr><td class="text-muted small"><?php echo lang('phone') ?: 'Tél.'; ?></td><td><?php echo htmlspecialchars($supplier->phone ?? ''); ?></td></tr>
          </tbody>
        </table>
      </div>
      <div class="col-sm-6">
        <table class="table table-sm table-borderless mb-0">
          <tbody>
            <tr><td class="text-muted small"><?php echo lang('address') ?: 'Adresse'; ?></td><td><?php echo htmlspecialchars($supplier->address ?? ''); ?></td></tr>
            <tr><td class="text-muted small"><?php echo lang('city') ?: 'Ville'; ?></td><td><?php echo htmlspecialchars(($supplier->city ?? '') . ', ' . ($supplier->country ?? '')); ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Purchases DataTable -->
<div class="card">
  <div class="card-header"><h5 class="card-title mb-0"><?php echo lang('purchases_history') ?: 'Historique des achats'; ?></h5></div>
  <div class="card-datatable table-responsive">
    <table id="suppReportTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th class="text-end"><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-end"><?php echo lang('paid') ?: 'Payé'; ?></th>
          <th class="text-end"><?php echo lang('balance') ?: 'Solde'; ?></th>
          <th class="text-center"><?php echo lang('payment_status') ?: 'Statut'; ?></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th colspan="2"><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-end"></th><th class="text-end"></th><th class="text-end"></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  $('#suppReportTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getSupplierReport/' . (isset($supplier) ? $supplier->id : '')); ?>',
      type: 'POST',
      data: function(d){ d['<?php echo $this->security->get_csrf_token_name();?>'] = '<?php echo $this->security->get_csrf_hash();?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null, null,
      { className:'text-end', render:function(d){return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2});} },
      { className:'text-end', render:function(d){return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2});} },
      { className:'text-end', render:function(d){
          var v=parseFloat(d||0);
          return '<span class="'+(v>0?'text-danger':'text-success')+'">'+v.toLocaleString(undefined,{minimumFractionDigits:2})+'</span>';
        }
      },
      { className:'text-center', render:function(d){
          var m={'paid':'success','partial':'warning','due':'danger'};
          return '<span class="badge bg-label-'+(m[d]||'secondary')+'">'+(d||'')+'</span>';
        }
      }
    ],
    footerCallback:function(row,data){
      var t2=0,t3=0,t4=0;
      data.forEach(function(r){t2+=parseFloat(r[2]||0);t3+=parseFloat(r[3]||0);t4+=parseFloat(r[4]||0);});
      var cells=row.querySelectorAll('th');
      cells[2].innerHTML=t2.toLocaleString(undefined,{minimumFractionDigits:2});
      cells[3].innerHTML=t3.toLocaleString(undefined,{minimumFractionDigits:2});
      cells[4].innerHTML='<span class="'+(t4>0?'text-danger':'text-success')+'">'+t4.toLocaleString(undefined,{minimumFractionDigits:2})+'</span>';
    },
    lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'<?php echo lang('all')?>']],
    dom:'<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
