<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-survey-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Finaliser l'inventaire</h4>
    <p class="mb-0 text-muted">Validez l'inventaire et appliquez les ajustements</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products/stock_counts'); ?>"><?php echo lang('stock_counts') ?: 'Inventaires'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('finalize_count') ?: 'Finaliser l\'inventaire'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<?php echo admin_form_open_multipart('products/finalize_count/' . $stock_count->id, ['id' => 'finalizeForm']); ?>
<?php echo form_hidden('count_id', $stock_count->id); ?>

<!-- Count info -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
      <?php echo lang('stock_count') ?: 'Détails de l\'inventaire'; ?>
    </h5>
  </div>
  <div class="card-body">
    <div class="row g-3">
      <div class="col-sm-6">
        <table class="table table-bordered mb-0">
          <tbody>
            <tr>
              <td class="fw-semibold" style="width:40%;"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></td>
              <td><?php echo htmlspecialchars($warehouse->name . ' (' . $warehouse->code . ')'); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('date') ?: 'Date'; ?></td>
              <td><?php echo $this->sma->hrld($stock_count->date); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('reference') ?: 'Référence'; ?></td>
              <td><?php echo htmlspecialchars($stock_count->reference_no); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('type') ?: 'Type'; ?></td>
              <td><?php echo lang($stock_count->type) ?: $stock_count->type; ?></td>
            </tr>
            <?php if ($stock_count->type == 'partial'): ?>
            <tr>
              <td class="fw-semibold"><?php echo lang('categories') ?: 'Catégories'; ?></td>
              <td><?php echo htmlspecialchars($stock_count->category_names ?? ''); ?></td>
            </tr>
            <tr>
              <td class="fw-semibold"><?php echo lang('brands') ?: 'Marques'; ?></td>
              <td><?php echo htmlspecialchars($stock_count->brand_names ?? ''); ?></td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Products -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-list-check me-2 text-primary icon-18px"></span>
      <?php echo lang('products') ?: 'Produits'; ?>
    </h5>
  </div>
  <div class="table-responsive">
    <table class="table table-bordered mb-0" id="countTable">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th style="width:120px;" class="text-center"><?php echo lang('expected') ?: 'Attendu'; ?></th>
          <th style="width:150px;" class="text-center"><?php echo lang('counted') ?: 'Compté'; ?></th>
          <th style="width:100px;" class="text-center"><?php echo lang('difference') ?: 'Écart'; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row): ?>
        <?php $diff = ($row->counted_qty ?? 0) - ($row->expected_qty ?? 0); ?>
        <tr>
          <td class="align-middle">
            <?php echo htmlspecialchars($row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?>
            <input type="hidden" name="product_id[]" value="<?php echo $row->product_id; ?>" />
          </td>
          <td class="text-center align-middle">
            <?php echo $this->sma->formatQuantity($row->expected_qty ?? 0); ?>
            <input type="hidden" name="expected_qty[]" value="<?php echo (float)($row->expected_qty ?? 0); ?>" />
          </td>
          <td class="text-center align-middle">
            <input type="number" class="form-control form-control-sm text-center counted-qty" step="0.001" min="0"
                   name="counted_qty[]" value="<?php echo (float)($row->counted_qty ?? 0); ?>"
                   data-expected="<?php echo (float)($row->expected_qty ?? 0); ?>" />
          </td>
          <td class="text-center align-middle">
            <span class="badge diff-badge <?php echo $diff == 0 ? 'bg-label-success' : ($diff < 0 ? 'bg-label-danger' : 'bg-label-warning'); ?>">
              <?php echo ($diff > 0 ? '+' : '') . $this->sma->formatQuantity($diff); ?>
            </span>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Note -->
<div class="card mb-4">
  <div class="card-body">
    <div class="form-floating form-floating-outline">
      <textarea class="form-control" id="countnote" name="note" placeholder="Note" style="height:80px;"><?php echo set_value('note', $stock_count->note ?? ''); ?></textarea>
      <label for="countnote"><?php echo lang('note') ?: 'Note'; ?></label>
    </div>
  </div>
</div>

<!-- Submit -->
<div class="card mb-4">
  <div class="card-body d-flex gap-3 justify-content-end">
    <a href="<?php echo admin_url('products/stock_counts'); ?>" class="btn btn-outline-secondary">
      <?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="submit" class="btn btn-primary" id="finalizeSaveBtn">
      <span class="icon-base ri ri-check-double-line me-1 icon-16px"></span>
      <?php echo lang('finalize_count') ?: 'Finaliser'; ?>
    </button>
  </div>
</div>

<?php echo form_close(); ?>

<script>
(function () {
  'use strict';
  // Live diff update
  document.querySelectorAll('.counted-qty').forEach(function (input) {
    input.addEventListener('input', function () {
      var expected = parseFloat(this.dataset.expected) || 0;
      var counted  = parseFloat(this.value) || 0;
      var diff     = counted - expected;
      var badge    = this.closest('tr').querySelector('.diff-badge');
      badge.textContent = (diff > 0 ? '+' : '') + diff.toFixed(2);
      badge.className = 'badge diff-badge ' + (diff === 0 ? 'bg-label-success' : (diff < 0 ? 'bg-label-danger' : 'bg-label-warning'));
    });
  });

  document.getElementById('finalizeSaveBtn').addEventListener('click', function () {
    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span><?php echo addslashes(lang('saving') ?: 'Enregistrement...'); ?>';
  });
})();
</script>
