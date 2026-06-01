<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-edit-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Modifier l'ajustement</h4>
    <p class="mb-0 text-muted">Modifiez les détails de l'ajustement de stock</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products/quantity_adjustments'); ?>"><?php echo lang('quantity_adjustments') ?: 'Ajustements'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('edit_adjustment') ?: 'Modifier l\'ajustement'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<?php echo admin_form_open_multipart('products/edit_adjustment/' . $inv->id, ['id' => 'adjustmentForm']); ?>

<!-- Header info -->
<div class="card mb-4">
  <div class="card-header border-bottom">
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
                 value="<?php echo isset($_POST['date']) ? set_value('date') : $this->sma->hrld($inv->date); ?>"
                 placeholder="Date" required />
          <label for="qadate"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
        </div>
      </div>
      <?php endif; ?>

      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="qaref" name="reference_no"
                 value="<?php echo isset($_POST['reference_no']) ? set_value('reference_no') : htmlspecialchars($inv->reference_no); ?>"
                 placeholder="REF-000" />
          <label for="qaref"><?php echo lang('reference_no') ?: 'N° de référence'; ?></label>
        </div>
      </div>

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
          $wh_val = isset($_POST['warehouse']) ? $_POST['warehouse'] : $inv->warehouse_id;
          echo form_dropdown('warehouse', $wh_opts, $wh_val,
            'class="form-select select2" id="qawarehouse" data-placeholder="' . lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt') . '" required');
          ?>
          <label for="qawarehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?> <span class="text-danger">*</span></label>
        </div>
      </div>
      <?php else: ?>
      <input type="hidden" name="warehouse" id="qawarehouse"
             value="<?php echo $this->session->userdata('warehouse_id'); ?>" />
      <?php endif; ?>

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
            <span class="icon-base ri ri-barcode-line icon-18px"></span>
          </span>
          <input type="text" class="form-control" id="add_item"
                 placeholder="<?php echo lang('add_product_to_order') ?: 'Rechercher un produit par nom ou code...'; ?>" />
        </div>
      </div>
    </div>
  </div>

  <!-- Products table -->
  <div class="table-responsive">
    <table class="table" id="qaTable">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('product_name') . ' (' . lang('product_code') . ')'; ?></th>
          <th style="width:150px;"><?php echo lang('variant') ?: 'Variante'; ?></th>
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
          <td colspan="<?php echo !empty($Settings->product_serial) ? 6 : 5; ?>" class="text-center py-4 text-muted">
            <span class="icon-base ri ri-inbox-line me-2 icon-20px"></span>
            <?php echo lang('no_products') ?: 'Aucun produit ajouté'; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<!-- Note + Attachment -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-4">
      <div class="col-md-8">
        <div class="form-floating form-floating-outline">
          <textarea class="form-control" id="qanote" name="note" placeholder="Note" style="height:100px;"><?php echo isset($_POST['note']) ? set_value('note') : htmlspecialchars($inv->note ?? ''); ?></textarea>
          <label for="qanote"><?php echo lang('note') ?: 'Note'; ?></label>
        </div>
      </div>
      <div class="col-md-4">
        <label class="form-label"><?php echo lang('document') ?: 'Document'; ?></label>
        <input type="file" class="form-control" name="document" id="document" />
        <?php if (!empty($inv->document)): ?>
        <div class="mt-2 small text-muted">
          <span class="icon-base ri ri-attachment-line me-1 icon-14px"></span>
          <?php echo htmlspecialchars($inv->document); ?>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<!-- Submit -->
<div class="card mb-4">
  <div class="card-body d-flex gap-3 justify-content-end">
    <a href="<?php echo admin_url('products/quantity_adjustments'); ?>" class="btn btn-outline-secondary">
      <?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="button" class="btn btn-outline-danger" id="reset">
      <span class="icon-base ri ri-refresh-line me-1 icon-16px"></span>
      <?php echo lang('reset') ?: 'Réinitialiser'; ?>
    </button>
    <button type="submit" class="btn btn-primary" id="saveAdjBtn">
      <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
      <?php echo lang('update') ?: 'Mettre à jour'; ?>
    </button>
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
var type_opt = {
  'addition':    '<?php echo addslashes(lang('addition') ?: 'Ajout'); ?>',
  'subtraction': '<?php echo addslashes(lang('subtraction') ?: 'Soustraction'); ?>'
};

(function () {
  'use strict';

  // localStorage cleanup from previous session
  if (localStorage.getItem('remove_qals')) {
    ['qaitems','qaref','qawarehouse','qanote','qadate'].forEach(function (k) {
      localStorage.removeItem(k);
    });
    localStorage.removeItem('remove_qals');
  }

  // Pre-fill localStorage from server data
  localStorage.setItem('qadate',      '<?php echo $this->sma->hrld($inv->date); ?>');
  localStorage.setItem('qaref',       '<?php echo addslashes($inv->reference_no); ?>');
  localStorage.setItem('qawarehouse', '<?php echo $inv->warehouse_id; ?>');
  localStorage.setItem('qanote',      '<?php echo str_replace(["\r", "\n"], '', addslashes($this->sma->decode_html($inv->note ?? ''))); ?>');
  localStorage.setItem('qaitems',     JSON.stringify(<?php echo $rows; ?>));
  localStorage.setItem('remove_qals', '1');

  // Product autocomplete
  if (window.$) {
    $("#add_item").autocomplete({
      source:    '<?php echo admin_url('products/qa_suggestions'); ?>',
      minLength: 1,
      autoFocus: false,
      delay:     250,
      select: function (event, ui) {
        if (ui.item && ui.item.id !== 0) {
          add_adjustment_item(ui.item.id);
          $(this).val('');
        }
        return false;
      }
    });

    // Reset button
    $('#reset').on('click', function () {
      Swal.fire({
        title: '<?php echo lang('confirm') ?: 'Confirmer'; ?>',
        text:  '<?php echo lang('reset_form_confirm') ?: 'Réinitialiser le formulaire ?'; ?>',
        icon:  'question',
        showCancelButton: true,
        confirmButtonText: '<?php echo lang('yes') ?: 'Oui'; ?>',
        cancelButtonText:  '<?php echo lang('no') ?: 'Non'; ?>'
      }).then(function (result) {
        if (result.isConfirmed) {
          ['qaitems','qaref','qawarehouse','qanote','qadate'].forEach(function (k) {
            localStorage.removeItem(k);
          });
          location.reload();
        }
      });
    });

    // Form submit
    $('#adjustmentForm').on('submit', function () {
      $('#saveAdjBtn').html('<span class="spinner-border spinner-border-sm me-2"></span><?php echo addslashes(lang('saving') ?: 'Enregistrement...'); ?>');
      $('#saveAdjBtn').prop('disabled', true);
      localStorage.setItem('remove_qals', 1);
    });
  }

})();
</script>
