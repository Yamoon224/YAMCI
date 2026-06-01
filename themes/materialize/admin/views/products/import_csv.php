<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?php echo lang('import_products_by_csv') ?: 'Importer des produits par CSV'; ?></h4>
    <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer ou mettre à jour vos produits en masse</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('import') ?: 'Importer'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-3">
    <a href="<?php echo admin_url('products/import_csv_template'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-download-line me-1" style="font-size:16px"></i>
      <?php echo lang('download_sample_file') ?: 'Modèle CSV'; ?>
    </a>
    <a href="<?php echo admin_url('products'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i>
      <?php echo lang('back') ?: 'Retour'; ?>
    </a>
  </div>
</div>

<?php if (!empty($errors)): ?>
<div class="card mb-4 border-danger">
  <div class="card-header bg-label-danger">
    <h5 class="card-title mb-0 text-danger">
      <span class="icon-base ri ri-error-warning-line me-2 icon-18px"></span>
      <?php echo lang('import_errors') ?: 'Erreurs d\'importation'; ?>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-sm mb-0">
        <thead class="table-danger">
          <tr>
            <th><?php echo lang('row') ?: 'Ligne'; ?></th>
            <th><?php echo lang('error') ?: 'Erreur'; ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ((array)$errors as $row => $err): ?>
          <tr>
            <td><span class="badge bg-label-danger"><?php echo htmlspecialchars($row); ?></span></td>
            <td><?php echo htmlspecialchars($err); ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-lg-9">

    <!-- Format info card -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
          <?php echo lang('csv_format') ?: 'Format du fichier CSV'; ?>
        </h5>
      </div>
      <div class="card-body">
        <p class="text-warning mb-2">
          <span class="icon-base ri ri-alert-line me-1 icon-16px"></span>
          <?php echo lang('csv1') ?: 'La première ligne doit contenir les en-têtes.'; ?>
        </p>
        <p class="mb-2">
          <?php echo lang('csv2') ?: 'Colonnes :'; ?>
          <span class="text-info small">
            (<?php echo implode(', ', [
              lang('name'), lang('code'), lang('barcode_symbology'), lang('brand'),
              lang('category_code'), lang('unit_code'),
              lang('sale') . ' ' . lang('unit_code'),
              lang('purchase') . ' ' . lang('unit_code'),
              lang('cost'), lang('price'), lang('alert_quantity'),
              lang('tax'), lang('tax_method'), lang('image'),
            ]); ?>)
          </span>
        </p>
        <p class="text-muted small mb-2">
          <?php echo lang('images_location_tip') ?: 'Les images doivent être placées dans le dossier uploads/products/.'; ?>
        </p>
        <p class="text-primary mb-0">
          <span class="icon-base ri ri-lightbulb-line me-1 icon-16px"></span>
          <?php echo lang('csv_update_tip') ?: 'Pour mettre à jour un produit existant, incluez son code.'; ?>
        </p>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <a href="<?php echo admin_url('products/import_csv_template'); ?>" class="btn btn-outline-secondary">
          <span class="icon-base ri ri-download-line me-1 icon-16px"></span>
          <?php echo lang('download_sample_file') ?: 'Télécharger le fichier d\'exemple'; ?>
        </a>
      </div>
    </div>

    <!-- Upload form card -->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-file-upload-line me-2 text-primary icon-18px"></span>
          <?php echo lang('upload_file') ?: 'Téléverser le fichier'; ?>
        </h5>
      </div>

      <?php
      $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'importCsvForm'];
      echo admin_form_open_multipart('products/import_csv', $attrib);
      ?>

      <div class="card-body">
        <div class="row g-4">

          <div class="col-md-6">
            <label class="form-label" for="csv_file">
              <?php echo lang('upload_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span>
            </label>
            <input type="file"
                   class="form-control"
                   id="csv_file"
                   name="userfile"
                   accept=".csv,text/csv"
                   required="required" />
            <div class="form-text text-muted">
              <?php echo lang('csv_file_hint') ?: 'Format .csv — encodage UTF-8 recommandé.'; ?>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?php
              $wh_opts = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
              if (!empty($warehouses)) {
                  foreach ($warehouses as $wh) {
                      $wh_opts[$wh->id] = $wh->name;
                  }
              }
              echo form_dropdown('warehouse_id', $wh_opts, isset($warehouse_id) ? $warehouse_id : '',
                'class="form-select select2" id="import_warehouse" data-placeholder="' . (lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')) . '"');
              ?>
              <label for="import_warehouse">
                <?php echo lang('warehouse') ?: 'Entrepôt'; ?>
                <small class="text-muted">(<?php echo lang('optional') ?: 'optionnel'; ?>)</small>
              </label>
            </div>
            <div class="form-text text-muted">
              <?php echo lang('warehouse_import_tip') ?: 'Sélectionnez un entrepôt pour importer le stock initial.'; ?>
            </div>
          </div>

        </div>
      </div>

      <div class="card-footer d-flex justify-content-end gap-2">
        <a href="<?php echo admin_url('products'); ?>" class="btn btn-outline-secondary">
          <?php echo lang('cancel') ?: 'Annuler'; ?>
        </a>
        <?php echo form_submit('import', lang('import') ?: 'Importer', 'class="btn btn-primary"'); ?>
      </div>

      <?php echo form_close(); ?>
    </div>

  </div>
</div>

<script>
$(document).ready(function () {
  $('select.select2').select2({
    minimumResultsForSearch: 7,
    placeholder: '<?php echo addslashes(lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')); ?>'
  });
});
</script>
