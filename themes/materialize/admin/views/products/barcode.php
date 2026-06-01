<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-barcode-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Codes-barres</h4>
    <p class="mb-0 text-muted">Génération de codes-barres produits</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('barcode_generator') ?: 'Générateur de codes-barres'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<!-- Filter form -->
<div class="card mb-4 d-print-none">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-filter-line me-2 text-primary icon-18px"></span>
      <?php echo lang('filter') ?: 'Filtres'; ?>
    </h5>
  </div>
  <div class="card-body">
    <?php echo admin_form_open('products/barcode', ['id' => 'barcodeForm', 'method' => 'get']); ?>
    <div class="row g-4">

      <div class="col-md-5">
        <div class="form-floating form-floating-outline">
          <select name="product_id[]" id="product_id" class="form-select select2"
                  multiple data-placeholder="<?php echo lang('select_products') ?: 'Sélectionner des produits...'; ?>">
            <?php if (!empty($products)): ?>
              <?php foreach ($products as $product): ?>
              <option value="<?php echo $product->id; ?>"
                <?php echo (!empty($_GET['product_id']) && in_array($product->id, (array)$_GET['product_id'])) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($product->name); ?>
              </option>
              <?php endforeach; ?>
            <?php endif; ?>
          </select>
          <label for="product_id"><?php echo lang('products') ?: 'Produits'; ?></label>
        </div>
      </div>

      <div class="col-md-3">
        <div class="form-floating form-floating-outline">
          <?php
          $wh_opts = ['' => lang('all_warehouses') ?: 'Tous les entrepôts'];
          if (!empty($warehouses)) {
              foreach ($warehouses as $wh) {
                  $wh_opts[$wh->id] = $wh->name;
              }
          }
          echo form_dropdown('warehouse_id', $wh_opts, isset($_GET['warehouse_id']) ? $_GET['warehouse_id'] : '',
            'class="form-select select2" id="warehouse_id" data-placeholder="' . (lang('all_warehouses') ?: 'Tous les entrepôts') . '"');
          ?>
          <label for="warehouse_id"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
        </div>
      </div>

      <div class="col-md-2">
        <div class="form-floating form-floating-outline">
          <?php
          $sizes = ['small' => lang('small') ?: 'Petit', 'medium' => lang('medium') ?: 'Moyen', 'large' => lang('large') ?: 'Grand'];
          echo form_dropdown('barcode_size', $sizes, isset($_GET['barcode_size']) ? $_GET['barcode_size'] : 'medium',
            'class="form-select" id="barcode_size"');
          ?>
          <label for="barcode_size"><?php echo lang('barcode_size') ?: 'Taille'; ?></label>
        </div>
      </div>

      <div class="col-md-2 d-flex align-items-center">
        <button type="submit" class="btn btn-primary w-100">
          <span class="icon-base ri ri-search-line me-1 icon-16px"></span>
          <?php echo lang('generate') ?: 'Générer'; ?>
        </button>
      </div>

    </div>
    <?php echo form_close(); ?>
  </div>
</div>

<!-- Barcodes output -->
<?php if (!empty($barcodes)): ?>
<div class="card" id="barcodeOutput">
  <div class="card-header border-bottom d-print-none d-flex align-items-center justify-content-between">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-qr-code-line me-2 text-primary icon-18px"></span>
      <?php echo lang('barcodes') ?: 'Codes-barres'; ?>
      <span class="badge bg-label-primary ms-2"><?php echo count($barcodes); ?></span>
    </h5>
    <button type="button" class="btn btn-sm btn-primary d-print-none" onclick="window.print()">
      <span class="icon-base ri ri-printer-line me-1 icon-16px"></span>
      <?php echo lang('print') ?: 'Imprimer'; ?>
    </button>
  </div>
  <div class="card-body">
    <div class="row g-3" id="barcodeGrid">
      <?php foreach ($barcodes as $bc): ?>
      <div class="col-auto barcode-item text-center p-3 border rounded"
           style="min-width:180px; page-break-inside:avoid;">
        <div class="fw-semibold small mb-1 text-truncate" style="max-width:160px;" title="<?php echo htmlspecialchars($bc->name); ?>">
          <?php echo htmlspecialchars($bc->name); ?>
        </div>
        <?php if (!empty($bc->barcode_image)): ?>
          <img src="<?php echo $bc->barcode_image; ?>" alt="<?php echo htmlspecialchars($bc->barcode); ?>" class="img-fluid d-block mx-auto" />
        <?php endif; ?>
        <div class="text-muted small mt-1"><?php echo htmlspecialchars($bc->barcode); ?></div>
        <?php if (!empty($bc->price)): ?>
          <div class="fw-semibold text-primary mt-1"><?php echo htmlspecialchars($bc->price); ?></div>
        <?php endif; ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<?php elseif (isset($_GET['product_id'])): ?>
<div class="alert alert-info d-flex align-items-center gap-2" role="alert">
  <span class="icon-base ri ri-information-line icon-20px"></span>
  <?php echo lang('no_barcodes') ?: 'Aucun code-barre trouvé pour les critères sélectionnés.'; ?>
</div>
<?php endif; ?>

<style>
@media print {
  .d-print-none { display: none !important; }
  .barcode-item { page-break-inside: avoid; border: 1px solid #ccc !important; }
  body { background: #fff; }
  .card { border: none; box-shadow: none; }
}
</style>
