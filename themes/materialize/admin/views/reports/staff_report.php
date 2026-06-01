<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<div class="row mb-4">
  <div class="col-12">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb breadcrumb-style1 mb-2">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('reports'); ?>"><?php echo lang('reports') ?: 'Rapports'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('staff_report') ?: 'Rapport Personnel'; ?></li>
      </ol>
    </nav>
    <h4 class="mb-1">
      <i class="ri ri-user-star-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
      <?php echo lang('staff_report') ?: 'Rapport Personnel'; ?>
      <?php if (isset($staff)): ?>
        <span class="text-muted fw-normal fs-6"> — <?php echo htmlspecialchars($staff->first_name . ' ' . $staff->last_name); ?></span>
      <?php endif; ?>
    </h4>
  </div>
</div>

<?php if (isset($staff)): ?>
<!-- KPI Cards -->
<div class="row g-4 mb-4">
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-primary rounded mx-auto mb-3">
          <span class="icon-base ri ri-shopping-cart-line icon-22px"></span>
        </div>
        <h5 class="mb-1"><?php echo $this->sma->formatMoney($sales->total_amount ?? 0); ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('sales_amount') ?: 'Montant ventes'; ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-success rounded mx-auto mb-3">
          <span class="icon-base ri ri-money-dollar-circle-line icon-22px"></span>
        </div>
        <h5 class="mb-1"><?php echo $this->sma->formatMoney($sales->paid ?? 0); ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('total_paid') ?: 'Total payé'; ?></p>
      </div>
    </div>
  </div>
  <div class="col-sm-4">
    <div class="card text-center">
      <div class="card-body">
        <div class="avatar avatar-md bg-label-info rounded mx-auto mb-3">
          <span class="icon-base ri ri-file-list-3-line icon-22px"></span>
        </div>
        <h5 class="mb-1"><?php echo $total_sales ?? 0; ?></h5>
        <p class="text-muted small mb-0"><?php echo lang('total_sales') ?: 'Nbre de ventes'; ?></p>
      </div>
    </div>
  </div>
</div>

<!-- Staff profile -->
<div class="card mb-4">
  <div class="card-header"><h5 class="card-title mb-0"><?php echo lang('staff_details') ?: 'Profil'; ?></h5></div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-sm-6">
        <table class="table table-sm table-borderless mb-0">
          <tbody>
            <tr><td class="text-muted small"><?php echo lang('full_name') ?: 'Nom'; ?></td><td><?php echo htmlspecialchars($staff->first_name . ' ' . $staff->last_name); ?></td></tr>
            <tr><td class="text-muted small"><?php echo lang('email') ?: 'Email'; ?></td><td><?php echo htmlspecialchars($staff->email ?? ''); ?></td></tr>
            <tr><td class="text-muted small"><?php echo lang('group') ?: 'Groupe'; ?></td><td><?php echo htmlspecialchars($staff->group_name ?? ''); ?></td></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Sales by this staff member -->
<div class="card">
  <div class="card-header"><h5 class="card-title mb-0"><?php echo lang('sales_by_staff') ?: 'Ventes par ce membre'; ?></h5></div>
  <div class="card-datatable table-responsive">
    <table id="staffReportTable" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th><?php echo lang('date') ?: 'Date'; ?></th>
          <th><?php echo lang('reference_no') ?: 'Référence'; ?></th>
          <th><?php echo lang('customer') ?: 'Client'; ?></th>
          <th class="text-end"><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-center"><?php echo lang('payment_status') ?: 'Statut'; ?></th>
        </tr>
      </thead>
      <tbody></tbody>
      <tfoot>
        <tr>
          <th colspan="3"><?php echo lang('total') ?: 'Total'; ?></th>
          <th class="text-end"></th><th></th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>

<script>
(function () {
  'use strict';
  $('#staffReportTable').DataTable({
    processing: true,
    serverSide: true,
    order: [[0, 'desc']],
    ajax: {
      url: '<?php echo admin_url('reports/getStaffReport/' . (isset($staff) ? $staff->id : '')); ?>',
      type: 'POST',
      data: function(d){ d['<?php echo $this->security->get_csrf_token_name();?>'] = '<?php echo $this->security->get_csrf_hash();?>'; }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    columns: [
      null, null, null,
      { className:'text-end', render:function(d){return parseFloat(d||0).toLocaleString(undefined,{minimumFractionDigits:2});} },
      { className:'text-center', render:function(d){
          var m={'paid':'success','partial':'warning','due':'danger'};
          return '<span class="badge bg-label-'+(m[d]||'secondary')+'">'+(d||'')+'</span>';
        }
      }
    ],
    footerCallback:function(row,data){
      var t3=0;
      data.forEach(function(r){t3+=parseFloat(r[3]||0);});
      row.querySelectorAll('th')[3].innerHTML=t3.toLocaleString(undefined,{minimumFractionDigits:2});
    },
    lengthMenu:[[10,25,50,100,-1],[10,25,50,100,'<?php echo lang('all')?>']],
    dom:'<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });
})();
</script>
