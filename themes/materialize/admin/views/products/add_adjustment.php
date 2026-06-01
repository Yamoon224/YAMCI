<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo admin_form_open_multipart('products/add_adjustment', ['id' => 'adjustmentForm']); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-arrow-up-down-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('add_adjustment') ?: 'Nouvel ajustement de stock'; ?></h4>
    <p class="mb-0 text-muted">Ajustez manuellement les quantités en stock</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products/quantity_adjustments'); ?>"><?php echo lang('quantity_adjustments') ?: 'Ajustements'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('add_adjustment') ?: 'Nouveau'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('products/quantity_adjustments'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#adjustmentForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?php echo lang('save') ?: 'Enregistrer'; ?>
    </button>
  </div>
</div>

<!-- Header info -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
      <?php echo lang('adjustment_details') ?: 'Détails de l\'ajustement'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-4">
      <?php if ($Owner || $Admin): ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control flatpickr-datetime" id="qadate" name="date"
                 placeholder="Date" />
          <label for="qadate"><?php echo lang('date') ?: 'Date'; ?></label>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="qaref" name="reference_no"
                 placeholder="REF-000" />
          <label for="qaref"><?php echo lang('reference_no') ?: 'N° de référence'; ?></label>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <?php
          $wh_opts = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
          if (isset($warehouses)) {
              foreach ($warehouses as $wh) {
                  $wh_opts[$wh->id] = $wh->name;
              }
          }
          echo form_dropdown('warehouse_id', $wh_opts, isset($warehouse_id) ? $warehouse_id : '',
            'class="form-select select2" id="qawarehouse" data-placeholder="' . lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt') . '"');
          ?>
          <label for="qawarehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?> <span class="text-danger">*</span></label>
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
      <?php echo lang('add_products') ?: 'Ajouter des produits'; ?>
    </h5>
  </div>
  <div class="card-body border-bottom">
    <div class="row g-3 align-items-center">
      <div class="col-md-8">
        <div class="input-group">
          <span class="input-group-text">
            <span class="icon-base ri ri-search-line icon-18px"></span>
          </span>
          <input type="text" class="form-control" id="add_item"
                 placeholder="<?php echo lang('search_product') ?: 'Rechercher un produit par nom ou code...'; ?>" />
        </div>
      </div>
    </div>
  </div>

  <!-- Products table -->
  <div class="table-responsive">
    <table class="table" id="qaTable">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th style="width:150px;"><?php echo lang('quantity') ?: 'Quantité'; ?></th>
          <th style="width:160px;"><?php echo lang('type') ?: 'Type'; ?></th>
          <?php if (!empty($Settings->product_serial)): ?>
          <th style="width:180px;"><?php echo lang('serial_no') ?: 'N° série'; ?></th>
          <?php endif; ?>
          <th style="width:50px;"></th>
        </tr>
      </thead>
      <tbody id="qaItems">
        <tr id="no-item-row">
          <td colspan="<?php echo !empty($Settings->product_serial) ? 5 : 4; ?>" class="text-center py-4 text-muted">
            <span class="icon-base ri ri-inbox-line me-2 icon-20px"></span>
            <?php echo lang('no_products') ?: 'Aucun produit ajouté'; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Note -->
<div class="card mb-4">
  <div class="card-body">
    <div class="form-floating form-floating-outline">
      <textarea class="form-control" id="qanote" name="note" placeholder="Note" style="height:100px;"></textarea>
      <label for="qanote"><?php echo lang('note') ?: 'Note'; ?></label>
    </div>
  </div>
</div>

<!-- Attachment + submit -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-4 align-items-end">
      <div class="col-md-6">
        <label class="form-label"><?php echo lang('attach_document') ?: 'Pièce jointe'; ?></label>
        <input type="file" class="form-control" name="attachment" id="attachment" />
      </div>
      <div class="col-md-6 d-flex gap-3 justify-content-end">
        <a href="<?php echo admin_url('products/quantity_adjustments'); ?>" class="btn btn-outline-secondary">
          <?php echo lang('cancel') ?: 'Annuler'; ?>
        </a>
        <button type="submit" class="btn btn-primary" id="saveAdjBtn">
          <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
          <?php echo lang('save_adjustment') ?: 'Enregistrer l\'ajustement'; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php echo form_close(); ?>

<!-- Edit item modal -->
<div class="modal fade" id="qaModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo lang('edit_item') ?: 'Modifier l\'article'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="qaModalBody"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
        <button type="button" class="btn btn-primary" id="saveQaItem"><?php echo lang('update') ?: 'Mettre à jour'; ?></button>
      </div>
    </div>
  </div>
</div>

<script>
var count = 1, an = 1;
var type_opt = {'addition': '<?php echo addslashes(lang('addition') ?: 'Ajout'); ?>', 'subtraction': '<?php echo addslashes(lang('subtraction') ?: 'Soustraction'); ?>'};

(function () {
  'use strict';

  // localStorage cleanup
  if (localStorage.getItem('remove_qals')) {
    ['qaitems','qaref','qawarehouse','qanote','qadate'].forEach(function(k){ localStorage.removeItem(k); });
    localStorage.removeItem('remove_qals');
  }

  <?php if (isset($adjustment_items) && $adjustment_items): ?>
  localStorage.setItem('qaitems', JSON.stringify(<?php echo $adjustment_items; ?>));
  <?php endif; ?>

  <?php if (isset($warehouse_id) && $warehouse_id): ?>
  localStorage.setItem('qawarehouse', '<?php echo $warehouse_id; ?>');
  $('#qawarehouse').prop('disabled', true);
  <?php endif; ?>

  // Restore from localStorage
  if (localStorage.getItem('qaref'))       $('#qaref').val(localStorage.getItem('qaref'));
  if (localStorage.getItem('qanote'))      $('#qanote').val(localStorage.getItem('qanote'));
  if (localStorage.getItem('qawarehouse') && !$('#qawarehouse').prop('disabled')) {
    $('#qawarehouse').val(localStorage.getItem('qawarehouse')).trigger('change');
  }

  // Save to localStorage on change
  $('#qaref').on('input',   function() { localStorage.setItem('qaref', this.value); });
  $('#qanote').on('input',  function() { localStorage.setItem('qanote', this.value); });
  $('#qawarehouse').on('change', function() { localStorage.setItem('qawarehouse', this.value); });
  <?php if ($Owner || $Admin): ?>
  if (localStorage.getItem('qadate')) {
    $('#qadate').val(localStorage.getItem('qadate'));
  }
  $('#qadate').on('change', function() { localStorage.setItem('qadate', this.value); });
  <?php endif; ?>

  // Product autocomplete
  if (window.$) {
    $("#add_item").autocomplete({
      source: '<?php echo admin_url('products/qa_suggestions'); ?>',
      minLength: 1,
      autoFocus: false,
      delay: 250,
      select: function (event, ui) {
        if (ui.item && ui.item.id !== 0) {
          add_adjustment_item(ui.item.id);
          $(this).val('');
        }
        return false;
      }
    });
  }

  // Form submit with loading state
  $('#adjustmentForm').on('submit', function() {
    $('#saveAdjBtn').html('<span class="spinner-border spinner-border-sm me-2"></span><?php echo addslashes(lang('saving') ?: 'Enregistrement...'); ?>');
    $('#saveAdjBtn').prop('disabled', true);
    localStorage.setItem('remove_qals', 1);
  });
})();
</script>
