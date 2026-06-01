<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'countStockForm'];
echo admin_form_open_multipart('products/count_stock', $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-bar-chart-box-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('count_stock') ?: 'Nouvel inventaire'; ?></h4>
    <p class="mb-0 text-muted">Comptez et ajustez le stock physique réel</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products/stock_counts'); ?>"><?php echo lang('stock_counts') ?: 'Inventaires'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('new_count') ?: 'Nouveau'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('products/stock_counts'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#countStockForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?php echo lang('save') ?: 'Enregistrer'; ?>
    </button>
  </div>
</div>

<!-- Header fields -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
      <?php echo lang('count_details') ?: 'Détails de l\'inventaire'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-4">

      <?php if ($Owner || $Admin || !$this->session->userdata('warehouse_id')): ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $wh_opts = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
          if (!empty($warehouses)) {
              foreach ($warehouses as $wh) {
                  $wh_opts[$wh->id] = $wh->name;
              }
          }
          echo form_dropdown('warehouse', $wh_opts,
            ($_POST['warehouse'] ?? $Settings->default_warehouse),
            'class="form-select select2" id="sc_warehouse" data-placeholder="' . (lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')) . '" required="required"');
          ?>
          <label for="sc_warehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?> <span class="text-danger">*</span></label>
        </div>
      </div>
      <?php else: ?>
        <?php
        echo form_input([
          'type'  => 'hidden',
          'name'  => 'warehouse',
          'id'    => 'sc_warehouse',
          'value' => $this->session->userdata('warehouse_id'),
        ]);
        ?>
      <?php endif; ?>

      <?php if ($Owner || $Admin): ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('date',
            ($_POST['date'] ?? $this->sma->hrld(date('Y-m-d H:i:s'))),
            'class="form-control" id="sc_date" placeholder="Date" required="required"'); ?>
          <label for="sc_date"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
        </div>
      </div>
      <?php endif; ?>

      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <?php echo form_input('reference_no', ($_POST['reference_no'] ?? ''),
            'class="form-control" id="sc_ref" placeholder="INV-000"'); ?>
          <label for="sc_ref"><?php echo lang('reference_no') ?: 'Référence'; ?></label>
        </div>
      </div>

      <div class="col-12">
        <div class="form-floating form-floating-outline">
          <?php echo form_textarea('note', ($_POST['note'] ?? ''),
            'class="form-control" id="sc_note" placeholder="Note" style="height:80px;"'); ?>
          <label for="sc_note"><?php echo lang('note') ?: 'Note'; ?></label>
        </div>
      </div>

    </div>
  </div>
</div>

<!-- Product search -->
<div class="card mb-4">
  <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-3">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-search-line me-2 text-primary icon-18px"></span>
      <?php echo lang('search_product') ?: 'Rechercher des produits'; ?>
    </h5>
  </div>
  <div class="card-body border-bottom">
    <div class="row g-3 align-items-center">
      <div class="col-md-8">
        <div class="input-group">
          <span class="input-group-text">
            <span class="icon-base ri ri-search-line icon-18px"></span>
          </span>
          <input type="text"
                 class="form-control"
                 id="sc_add_item"
                 placeholder="<?php echo lang('search_product_hint') ?: 'Rechercher par nom ou code-barres...'; ?>" />
        </div>
      </div>
    </div>
  </div>

  <!-- Items table -->
  <div class="table-responsive">
    <table class="table mb-0" id="scItemsTable">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th style="width:150px;" class="text-end"><?php echo lang('expected_qty') ?: 'Qté attendue'; ?></th>
          <th style="width:150px;" class="text-end"><?php echo lang('counted_qty') ?: 'Qté comptée'; ?></th>
          <th style="width:150px;" class="text-end"><?php echo lang('difference') ?: 'Différence'; ?></th>
          <th style="width:50px;"></th>
        </tr>
      </thead>
      <tbody id="scItems">
        <tr id="sc-no-item-row">
          <td colspan="5" class="text-center py-5 text-muted">
            <span class="icon-base ri ri-inbox-line d-block mb-2 icon-24px"></span>
            <?php echo lang('no_products') ?: 'Aucun produit ajouté — utilisez la recherche ci-dessus.'; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Submit -->
<div class="card mb-4">
  <div class="card-body d-flex justify-content-end gap-3">
    <a href="<?php echo admin_url('products/stock_counts'); ?>" class="btn btn-outline-secondary">
      <?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="submit" class="btn btn-primary" id="scSubmitBtn">
      <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
      <?php echo lang('submit_count') ?: 'Soumettre l\'inventaire'; ?>
    </button>
  </div>
</div>

<?php echo form_close(); ?>

<script>
var scCount = 1;

(function () {
  'use strict';

  // Date picker
  <?php if ($Owner || $Admin): ?>
  if (typeof flatpickr !== 'undefined') {
    flatpickr('#sc_date', {
      enableTime: true,
      dateFormat: '<?php echo addslashes($dateFormats['js_ldate'] ?? 'd/m/Y H:i'); ?>',
      defaultDate: new Date()
    });
  }
  <?php endif; ?>

  // Warehouse: restore from session
  <?php if ($this->session->userdata('warehouse_id')): ?>
  $('#sc_warehouse').val('<?php echo $this->session->userdata('warehouse_id'); ?>');
  <?php endif; ?>

  // Product autocomplete
  $('#sc_add_item').autocomplete({
    source: '<?php echo admin_url('products/suggestions'); ?>',
    minLength: 1,
    autoFocus: false,
    delay: 250,
    select: function (event, ui) {
      if (ui.item && ui.item.id) {
        addStockCountItem(ui.item);
        $(this).val('');
      }
      return false;
    }
  });

  function addStockCountItem(item) {
    // Remove empty placeholder row
    $('#sc-no-item-row').remove();

    var rowId = 'sc_row_' + scCount;
    var html =
      '<tr id="' + rowId + '">' +
        '<td>' +
          '<span class="fw-semibold">' + item.label + '</span>' +
          '<input type="hidden" name="product_id[]" value="' + item.id + '">' +
        '</td>' +
        '<td class="text-end">' +
          '<input type="number" name="expected_qty[]" class="form-control form-control-sm text-end" value="' + (item.quantity || 0) + '" readonly tabindex="-1">' +
        '</td>' +
        '<td class="text-end">' +
          '<input type="number" name="counted_qty[]" class="form-control form-control-sm text-end sc-counted" ' +
            'min="0" step="0.01" value="0" data-row="' + rowId + '" data-expected="' + (item.quantity || 0) + '">' +
        '</td>' +
        '<td class="text-end sc-diff-cell" id="diff_' + rowId + '">' +
          '<span class="badge bg-label-secondary">0</span>' +
        '</td>' +
        '<td class="text-center">' +
          '<button type="button" class="btn btn-sm btn-icon btn-outline-danger sc-remove-btn" data-row="' + rowId + '">' +
            '<span class="icon-base ri ri-delete-bin-line icon-14px"></span>' +
          '</button>' +
        '</td>' +
      '</tr>';

    $('#scItems').append(html);
    scCount++;
    bindRowEvents(rowId);
  }

  function bindRowEvents(rowId) {
    // Diff calculation
    $('#scItems').on('input', '#' + rowId + ' .sc-counted', function () {
      var counted  = parseFloat($(this).val()) || 0;
      var expected = parseFloat($(this).data('expected')) || 0;
      var diff = counted - expected;
      var badge = diff > 0
        ? '<span class="badge bg-label-success">+' + diff.toFixed(2) + '</span>'
        : diff < 0
          ? '<span class="badge bg-label-danger">' + diff.toFixed(2) + '</span>'
          : '<span class="badge bg-label-secondary">0</span>';
      $('#diff_' + rowId).html(badge);
    });

    // Remove row
    $('#scItems').on('click', '#' + rowId + ' .sc-remove-btn', function () {
      $('#' + rowId).remove();
      if ($('#scItems tr').length === 0) {
        $('#scItems').append(
          '<tr id="sc-no-item-row"><td colspan="5" class="text-center py-5 text-muted">' +
          '<span class="icon-base ri ri-inbox-line d-block mb-2 icon-24px"></span>' +
          '<?php echo addslashes(lang('no_products') ?: 'Aucun produit ajouté.'); ?>' +
          '</td></tr>'
        );
      }
    });
  }

  // Submit loading state
  $('#countStockForm').on('submit', function () {
    $('#scSubmitBtn')
      .html('<span class="spinner-border spinner-border-sm me-2"></span><?php echo addslashes(lang('saving') ?: 'Enregistrement...'); ?>')
      .prop('disabled', true);
  });

  // Select2 init
  if (typeof $.fn.select2 !== 'undefined') {
    $('select.select2').select2({
      minimumResultsForSearch: 7
    });
  }
})();
</script>
