<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1"><i class="ri ri-price-tag-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? lang('group_product_prices'); ?></h4>
      <p class="mb-0 text-muted">Grille tarifaire du groupe : <span class="text-primary fw-semibold"><?php echo htmlspecialchars($price_group->name ?? ''); ?></span></p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo admin_url('system_settings'); ?>"><?php echo lang('settings') ?: 'Paramètres'; ?></a></li>
          <li class="breadcrumb-item active"><?php echo htmlspecialchars($price_group->name ?? ''); ?></li>
        </ol>
      </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
      <a href="<?php echo admin_url('system_settings'); ?>" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?php echo lang('back') ?: 'Retour'; ?>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex align-items-center justify-content-between">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-price-tag-2-line me-2 text-primary"></span>
        <?php echo lang('product_prices') ?: 'Prix produits'; ?>
      </h5>
      <button class="btn btn-sm btn-outline-danger" id="delete-prices-btn">
        <span class="icon-base ri ri-delete-bin-line me-1"></span><?php echo lang('delete_product_group_prices') ?: 'Supprimer sélection'; ?>
      </button>
    </div>
    <div class="card-datatable table-responsive">
      <?php echo admin_form_open('system_settings/product_group_price_actions/' . ($price_group->id ?? ''), 'id="price-action-form"'); ?>
      <table id="CGData" class="table table-hover datatables-ajax">
        <thead>
          <tr>
            <th style="width:40px;"><input type="checkbox" class="form-check-input" id="checkAll" /></th>
            <th><?php echo lang('product_code') ?: 'Code'; ?></th>
            <th><?php echo lang('product_name') ?: 'Produit'; ?></th>
            <th><?php echo lang('price') ?: 'Prix'; ?></th>
            <th style="width:80px;"><?php echo lang('update') ?: 'Sauv.'; ?></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
      <input type="hidden" name="form_action" value="" id="form_action" />
      <?php echo form_close(); ?>
    </div>
  </div>
</div>

<script>
var tabIndex = 0;
function priceInput(x) {
  tabIndex++;
  var v = x.split('__');
  var val = v[1] !== '' ? parseFloat(v[1]).toFixed(<?php echo (int)($Settings->decimal_places ?? 2); ?>) : '';
  return '<input type="text" name="price' + v[0] + '" value="' + val + '" class="form-control form-control-sm text-end price-input" tabindex="' + tabIndex + '" style="width:120px;">';
}
function saveBtn(x) {
  return '<button type="button" class="btn btn-sm btn-primary form-submit"><span class="icon-base ri ri-save-line"></span></button>';
}
function checkboxFn(x) {
  return '<input type="checkbox" class="form-check-input row-check" name="product_ids[]" value="' + x + '" />';
}

$(document).ready(function() {
  $('#CGData').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: '<?php echo admin_url('system_settings/getProductPrices/' . ($price_group->id ?? '')); ?>',
      type: 'POST',
      data: function(d) {
        d['<?php echo $this->security->get_csrf_token_name(); ?>'] = '<?php echo $this->security->get_csrf_hash(); ?>';
      }
    },
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    order: [[1, 'asc']],
    rowCallback: function(row, data) {
      row.id = data[0];
      return row;
    },
    columns: [
      { data: 0, orderable: false, render: checkboxFn },
      { data: 1 },
      { data: 2 },
      { data: 3, orderable: false, render: priceInput },
      { data: 4, orderable: false, render: saveBtn }
    ]
  });

  // Save individual row price
  $(document).on('click', '.form-submit', function() {
    var btn = $(this);
    var row = btn.closest('tr');
    var product_id = row.attr('id');
    var price = row.find('.price-input').val();
    btn.html('<span class="icon-base ri ri-loader-4-line"></span>').prop('disabled', true);
    $.ajax({
      type: 'POST',
      url: '<?php echo admin_url('system_settings/update_product_group_price/' . ($price_group->id ?? '')); ?>',
      dataType: 'json',
      data: {
        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
        product_id: product_id,
        price: price
      },
      success: function(data) {
        if (data.status == 1) {
          btn.removeClass('btn-primary').addClass('btn-success').html('<span class="icon-base ri ri-check-line"></span>');
        } else {
          btn.removeClass('btn-primary').addClass('btn-danger').html('<span class="icon-base ri ri-close-line"></span>');
        }
        btn.prop('disabled', false);
      },
      error: function() {
        btn.removeClass('btn-primary').addClass('btn-danger').html('<span class="icon-base ri ri-close-line"></span>');
        btn.prop('disabled', false);
      }
    });
  });

  // Check all
  $('#checkAll').on('change', function() {
    $('.row-check').prop('checked', this.checked);
  });

  // Delete selected
  $('#delete-prices-btn').on('click', function() {
    if (!$('.row-check:checked').length) return;
    Swal.fire({
      title: '<?php echo lang('are_you_sure') ?: 'Confirmer ?'; ?>',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: '<?php echo lang('yes_delete') ?: 'Oui, supprimer'; ?>'
    }).then(function(result) {
      if (result.isConfirmed) {
        $('#form_action').val('delete');
        $('#price-action-form')[0].submit();
      }
    });
  });
});
</script>
