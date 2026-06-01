<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-upload-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('import_by_csv') ?: 'Importer des clients par CSV'; ?></h4>
    <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer plusieurs clients en masse</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers'); ?>"><?php echo lang('customers') ?: 'Clients'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('import') ?: 'Importer'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('customers'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?php echo lang('back') ?: 'Retour'; ?>
    </a>
  </div>
</div>

<?php if (!empty($success)): ?>
<div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
  <span class="icon-base ri ri-checkbox-circle-line me-2"></span>
  <?php echo $success; ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo lang('close') ?: 'Fermer'; ?>"></button>
</div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
<div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
  <span class="icon-base ri ri-error-warning-line me-2"></span>
  <strong><?php echo lang('errors') ?: 'Des erreurs ont été détectées'; ?></strong>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="<?php echo lang('close') ?: 'Fermer'; ?>"></button>
  <ul class="mt-2 mb-0">
    <?php foreach ((array)$errors as $err): ?>
      <li><?php echo htmlspecialchars($err); ?></li>
    <?php endforeach; ?>
  </ul>
</div>
<?php endif; ?>

<div class="row justify-content-center">
  <div class="col-lg-8">

    <!-- Info card -->
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
          <?php echo lang('csv2') ?: 'Colonnes requises :'; ?>
          <span class="text-info">
            (<?php echo implode(', ', [
              lang('company'), lang('name'), lang('email'), lang('phone'),
              lang('address'), lang('city'), lang('state'), lang('postal_code'),
              lang('country'), lang('vat_no'), lang('gst_no'),
            ]); ?>)
          </span>
        </p>
        <p class="text-success mb-2">
          <span class="icon-base ri ri-checkbox-circle-line me-1 icon-16px"></span>
          <?php echo lang('first_6_required') ?: 'Les 6 premières colonnes sont obligatoires.'; ?>
        </p>
        <p class="text-primary mb-0">
          <span class="icon-base ri ri-lightbulb-line me-1 icon-16px"></span>
          <?php echo lang('csv_update_tip') ?: 'Pour mettre à jour un client existant, incluez son email.'; ?>
        </p>
      </div>
      <div class="card-footer d-flex justify-content-end">
        <a href="<?php echo base_url(); ?>assets/csv/sample.csv" class="btn btn-outline-secondary">
          <span class="icon-base ri ri-download-line me-1 icon-16px"></span>
          <?php echo lang('download_sample_file') ?: 'Télécharger le fichier d\'exemple'; ?>
        </a>
      </div>
    </div>

    <!-- Upload card -->
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-file-upload-line me-2 text-primary icon-18px"></span>
          <?php echo lang('upload_file') ?: 'Téléverser le fichier'; ?>
        </h5>
      </div>

      <?php
      $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'importForm'];
      echo admin_form_open_multipart('customers/import_csv', $attrib);
      ?>

      <div class="card-body">
        <div class="mb-3">
          <label class="form-label" for="csv_file">
            <?php echo lang('upload_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span>
          </label>
          <input type="file"
                 class="form-control"
                 id="csv_file"
                 name="csv_file"
                 accept=".csv,text/csv"
                 required="required" />
          <div class="form-text text-muted">
            <?php echo lang('csv_file_hint') ?: 'Format accepté : .csv — encodage UTF-8 recommandé.'; ?>
          </div>
        </div>
      </div>

      <div class="card-footer d-flex justify-content-end gap-2">
        <a href="<?php echo admin_url('customers'); ?>" class="btn btn-outline-secondary">
          <?php echo lang('cancel') ?: 'Annuler'; ?>
        </a>
        <?php echo form_submit('import', lang('import') ?: 'Importer', 'class="btn btn-primary"'); ?>
      </div>

      <?php echo form_close(); ?>
    </div>

  </div>
</div>
