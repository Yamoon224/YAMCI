<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-price-tag-3-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('promos') ?: 'Promotions'; ?></h4>
    <p class="mb-0 text-muted">Gérez les codes promos et offres spéciales</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('promos') ?: 'Promotions'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?php echo admin_url('promos/add'); ?>" class="btn btn-primary" id="add">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_promo') ?: 'Nouvelle promotion'; ?>
    </a>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])):
    echo admin_form_open('promos/promo_actions', 'id="action-form"');
endif; ?>

<!-- Data Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table id="SupData" class="table datatables-ajax border-top">
      <thead>
        <tr>
          <th style="min-width:30px; width:30px; text-align:center;">
            <input class="form-check-input checkbox checkth" type="checkbox" name="check" />
          </th>
          <th><?php echo lang('name') ?: 'Nom'; ?></th>
          <th><?php echo lang('type') ?: 'Type'; ?></th>
          <th><?php echo lang('discount') ?: 'Remise'; ?></th>
          <th><?php echo lang('product2buy') ?: 'Produit(s)'; ?></th>
          <th><?php echo lang('status') ?: 'Statut'; ?></th>
          <th><?php echo lang('start_date') ?: 'Date début'; ?></th>
          <th><?php echo lang('end_date') ?: 'Date fin'; ?></th>
          <th style="min-width:85px; width:85px; text-align:center;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="9" class="dataTables_empty"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td></tr>
      </tbody>
      <tfoot class="dtFilter">
        <tr>
          <th style="min-width:30px; width:30px; text-align:center;">
            <input class="form-check-input checkbox checkft" type="checkbox" name="check" />
          </th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th style="min-width:85px; width:85px; text-align:center;"><?php echo lang('actions') ?: 'Actions'; ?></th>
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

<?php if ($action && $action == 'add'): ?>
<script>$(document).ready(function(){ $('#add').trigger('click'); });</script>
<?php endif; ?>

<script>
(function () {
  'use strict';

  function promoStatus(active) {
    if (active == 1 || active === 'active' || active === true) {
      return '<span class="badge bg-label-success"><?php echo lang('active') ?: 'Actif'; ?></span>';
    }
    return '<span class="badge bg-label-secondary"><?php echo lang('inactive') ?: 'Inactif'; ?></span>';
  }

  function promoType(t) {
    if (t === 'percent' || t === 'percentage') {
      return '<span class="badge bg-label-info"><?php echo lang('percent') ?: 'Pourcentage'; ?></span>';
    }
    return '<span class="badge bg-label-warning"><?php echo lang('fixed') ?: 'Fixe'; ?></span>';
  }

  $('#SupData').dataTable({
    aaSorting: [[1, 'asc']],
    aLengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    iDisplayLength: <?php echo (int)$Settings->rows_per_page; ?>,
    bProcessing: true,
    bServerSide: true,
    sAjaxSource: '<?php echo admin_url('promos/getPromos'); ?>',
    fnServerData: function (sSource, aoData, fnCallback) {
      aoData.push({
        name: '<?php echo $this->security->get_csrf_token_name(); ?>',
        value: '<?php echo $this->security->get_csrf_hash(); ?>'
      });
      $.ajax({ dataType: 'json', type: 'POST', url: sSource, data: aoData, success: fnCallback });
    },
    aoColumns: [
      { bVisible: false, bSortable: false, mRender: checkbox },
      null,
      { mRender: promoType },
      { mRender: function (d) { return d !== null && d !== '' ? '<strong>' + d + '</strong>' : '—'; } },
      null,
      { mRender: promoStatus },
      { mRender: fsd },
      { mRender: fsd },
      { bSortable: false }
    ]
  }).dtFilter([
    { column_number: 1, filter_default_label: '[<?php echo lang('name'); ?>]',        filter_type: 'text', data: [] },
    { column_number: 4, filter_default_label: '[<?php echo lang('product2buy'); ?>]', filter_type: 'text', data: [] },
    { column_number: 6, filter_default_label: '[<?php echo lang('start_date'); ?>]',  filter_type: 'text', data: [] },
    { column_number: 7, filter_default_label: '[<?php echo lang('end_date'); ?>]',    filter_type: 'text', data: [] }
  ], 'footer');
})();
</script>
