<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-arrow-go-back-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>
      <?php echo lang('return_purchase') ?: 'Retour d\'achat'; ?>
    </h4>
    <?php if (isset($inv)): ?>
    <p class="mb-0 text-muted">
      <?php echo lang('reference_no') ?>: <span class="text-primary fw-semibold"><?php echo htmlspecialchars($inv->reference_no); ?></span>
    </p>
    <?php else: ?>
    <p class="mb-0 text-muted">Saisissez les détails du retour fournisseur</p>
    <?php endif; ?>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('purchases'); ?>"><?php echo lang('purchases') ?: 'Achats'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('return_purchase') ?: 'Retour'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('purchases'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
  </div>
</div>

<script>
var count=1, an=1, DT=<?php echo (int)($Settings->default_tax_rate ?? 0); ?>, po_edit=1,
    product_tax=0, invoice_tax=0, total_discount=0, total=0, shipping=0, surcharge=0,
    tax_rates=<?php echo json_encode($tax_rates ?? []); ?>;
</script>

<?php echo admin_form_open('purchases/return_purchase/' . ($inv->id ?? ''), ['id' => 'returnForm', 'autocomplete' => 'off']); ?>
<?php echo form_hidden('return_type', 'purchase'); ?>

<!-- Header info -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
      <?php echo lang('return_details') ?: 'Détails du retour'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-4">
      <?php if ($Owner || $Admin): ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control flatpickr-datetime" id="redate" name="date" placeholder="Date" />
          <label for="redate"><?php echo lang('date') ?: 'Date'; ?></label>
        </div>
      </div>
      <?php endif; ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" id="reref" name="reference_no"
                 placeholder="REF"
                 value="<?php echo htmlspecialchars($reference ?? ''); ?>" />
          <label for="reref"><?php echo lang('reference_no') ?: 'Référence'; ?></label>
        </div>
      </div>
      <?php if (isset($inv)): ?>
      <div class="col-md-4">
        <div class="form-floating form-floating-outline">
          <input type="text" class="form-control" readonly
                 value="<?php echo htmlspecialchars($inv->supplier_name ?? $inv->supplier ?? ''); ?>" />
          <label><?php echo lang('supplier') ?: 'Fournisseur'; ?></label>
        </div>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<!-- Items -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-list-check me-2 text-primary icon-18px"></span>
      <?php echo lang('purchase_items') ?: 'Articles de l\'achat'; ?>
    </h5>
  </div>
  <div class="table-responsive">
    <table class="table mb-0" id="returnTable">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th style="width:120px;" class="text-center"><?php echo lang('purchased_qty') ?: 'Qté achetée'; ?></th>
          <th style="width:150px;" class="text-center"><?php echo lang('return_qty') ?: 'Qté à retourner'; ?></th>
          <th style="width:120px;" class="text-end"><?php echo lang('unit_price') ?: 'Prix unit.'; ?></th>
          <th style="width:120px;" class="text-end"><?php echo lang('subtotal') ?: 'Sous-total'; ?></th>
        </tr>
      </thead>
      <tbody id="returnItems">
        <?php if (!empty($inv_products)): foreach ($inv_products as $item): ?>
        <tr>
          <td class="align-middle">
            <?php echo htmlspecialchars($item->product_code . ' - ' . $item->product_name . ($item->variant ? ' (' . $item->variant . ')' : '')); ?>
            <?php echo form_hidden('item_id[]', $item->product_id); ?>
          </td>
          <td class="text-center align-middle"><?php echo $this->sma->formatQuantity($item->quantity); ?></td>
          <td class="text-center align-middle">
            <input type="number" name="return_qty[]" class="form-control form-control-sm text-center return-qty"
                   min="0" max="<?php echo (float)$item->quantity; ?>" step="0.001"
                   value="<?php echo (float)$item->quantity; ?>"
                   data-price="<?php echo (float)($item->net_unit_cost ?? $item->unit_price ?? 0); ?>" />
          </td>
          <td class="text-end align-middle">
            <?php echo $this->sma->mf($item->net_unit_cost ?? $item->unit_price ?? 0); ?>
            <?php echo form_hidden('item_price[]', $item->net_unit_cost ?? $item->unit_price ?? 0); ?>
          </td>
          <td class="text-end align-middle item-subtotal">
            <?php echo $this->sma->mf(($item->net_unit_cost ?? $item->unit_price ?? 0) * ($item->quantity ?? 0)); ?>
          </td>
        </tr>
        <?php endforeach; endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Note + submit -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-4">
      <div class="col-md-8">
        <div class="form-floating form-floating-outline">
          <textarea class="form-control" id="renote" name="note" placeholder="Note" style="height:80px;"></textarea>
          <label for="renote"><?php echo lang('note') ?: 'Note'; ?></label>
        </div>
      </div>
      <div class="col-md-4 d-flex gap-3 justify-content-end align-items-end">
        <a href="<?php echo admin_url('purchases'); ?>" class="btn btn-outline-secondary">
          <?php echo lang('cancel') ?: 'Annuler'; ?>
        </a>
        <button type="submit" class="btn btn-primary">
          <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
          <?php echo lang('save') ?: 'Enregistrer le retour'; ?>
        </button>
      </div>
    </div>
  </div>
</div>

<?php echo form_close(); ?>

<script>
(function () {
  'use strict';
  // Pre-fill from localStorage
  if (localStorage.getItem('reref'))  document.getElementById('reref').value  = localStorage.getItem('reref');
  if (localStorage.getItem('renote')) document.getElementById('renote').value = localStorage.getItem('renote');

  document.getElementById('reref').addEventListener('input',  function(){ localStorage.setItem('reref',  this.value); });
  document.getElementById('renote').addEventListener('input', function(){ localStorage.setItem('renote', this.value); });

  // Update subtotal on qty change
  document.querySelectorAll('.return-qty').forEach(function (inp) {
    inp.addEventListener('input', function () {
      var price = parseFloat(this.dataset.price) || 0;
      var qty   = parseFloat(this.value) || 0;
      this.closest('tr').querySelector('.item-subtotal').textContent = (price * qty).toFixed(2);
    });
  });
})();
</script>
