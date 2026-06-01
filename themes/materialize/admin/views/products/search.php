<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-search-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Recherche produits</h4>
    <p class="mb-0 text-muted">Résultats de votre recherche</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('search_results') ?: 'Résultats'; ?></li>
      </ol>
    </nav>
  </div>
</div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-search-line me-2 text-primary"></span>
        <?php echo lang('list_results') ?: 'Résultats'; ?>
        <?php if (!empty($sr_name)): ?>
          <span class="text-muted fw-normal ms-2 fs-6">"<?php echo htmlspecialchars($sr_name); ?>"</span>
        <?php endif; ?>
      </h5>
    </div>
    <div class="card-datatable table-responsive">
      <table id="fileData" class="table table-hover datatables-ajax">
        <thead>
          <tr>
            <th><?php echo lang('product_code') ?: 'Code'; ?></th>
            <th><?php echo lang('product_name') ?: 'Produit'; ?></th>
            <th><?php echo lang('product_unit') ?: 'Unité'; ?></th>
            <th><?php echo lang('product_cost') ?: 'Coût'; ?></th>
            <th><?php echo lang('product_price') ?: 'Prix'; ?></th>
            <th><?php echo lang('quantity') ?: 'Qté'; ?></th>
            <th><?php echo lang('alert_quantity') ?: 'Alerte'; ?></th>
            <th style="width:120px;"><?php echo lang('actions') ?: 'Actions'; ?></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="8" class="text-center"><?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $('#fileData').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '<?php echo admin_url('products/getSearchResults/' . urlencode($sr_name ?? '')); ?>',
      type: 'POST',
      data: function(d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)($Settings->rows_per_page ?? 25); ?>,
    order: [[1, 'asc']],
    columns: [
      { data: 0 }, { data: 1 }, { data: 2 }, { data: 3 },
      { data: 4 }, { data: 5 }, { data: 6 },
      { data: 7, orderable: false }
    ]
  });
});
</script>
