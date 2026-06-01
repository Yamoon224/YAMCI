<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-upload-cloud-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('updates') ?: 'Mises à jour'; ?></h4>
    <p class="mb-0 text-muted">Vérifiez et installez les mises à jour disponibles</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('system_settings'); ?>"><?php echo lang('settings') ?: 'Paramètres'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('updates') ?: 'Mises à jour'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<div class="card">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-shield-check-line me-2 text-primary icon-18px"></span>
      <?php echo lang('envato_license') ?: 'Licence Envato'; ?>
    </h5>
  </div>
  <div class="card-body">
    <p class="text-muted mb-4"><?php echo lang('update_heading') ?: 'Veuillez entrer vos informations de licence Envato pour recevoir les mises à jour.'; ?></p>

    <?php if (!$Settings->purchase_code || !$Settings->envato_username): ?>

      <?php echo admin_form_open('system_settings/updates', ['id' => 'updatesForm']); ?>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="purchase_code" name="purchase_code"
                   value="<?php echo set_value('purchase_code'); ?>"
                   placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx" required />
            <label for="purchase_code"><?php echo lang('purchase_code') ?: 'Code d\'achat'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control" id="envato_username" name="envato_username"
                   value="<?php echo set_value('envato_username'); ?>"
                   placeholder="votre_pseudo_envato" required />
            <label for="envato_username"><?php echo lang('envato_username') ?: 'Nom d\'utilisateur Envato'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">
            <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
            <?php echo lang('save') ?: 'Enregistrer'; ?>
          </button>
        </div>
      </div>
      <?php echo form_close(); ?>

    <?php else: ?>

      <!-- License info -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <div class="d-flex align-items-center p-3 rounded border bg-label-info">
            <span class="icon-base ri ri-key-line me-3 icon-24px text-info"></span>
            <div>
              <div class="text-muted small"><?php echo lang('purchase_code') ?: 'Code d\'achat'; ?></div>
              <div class="fw-semibold"><?php echo htmlspecialchars($Settings->purchase_code); ?></div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="d-flex align-items-center p-3 rounded border bg-label-info">
            <span class="icon-base ri ri-user-line me-3 icon-24px text-info"></span>
            <div>
              <div class="text-muted small"><?php echo lang('envato_username') ?: 'Utilisateur Envato'; ?></div>
              <div class="fw-semibold"><?php echo htmlspecialchars($Settings->envato_username); ?></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Current version -->
      <div class="d-flex align-items-center gap-2 mb-4">
        <span class="badge bg-label-success px-3 py-2 fs-6">
          <span class="icon-base ri ri-git-branch-line me-1 icon-16px"></span>
          <?php echo lang('current_version') ?: 'Version actuelle'; ?> : <?php echo htmlspecialchars($Settings->version); ?>
        </span>
      </div>

      <!-- Updates list -->
      <?php if (!empty($updates->data->updates)): ?>
        <h6 class="fw-semibold mb-3"><?php echo lang('available_updates') ?: 'Mises à jour disponibles'; ?></h6>
        <div class="table-responsive">
          <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
              <tr>
                <th><?php echo lang('version') ?: 'Version'; ?></th>
                <th><?php echo lang('changelog') ?: 'Journal des modifications'; ?></th>
                <th style="width:160px;"><?php echo lang('action') ?: 'Action'; ?></th>
              </tr>
            </thead>
            <tbody>
              <?php $c = 1; foreach ($updates->data->updates as $update): ?>
              <tr>
                <td>
                  <span class="badge bg-label-primary fs-6">
                    <?php echo lang('version') ?: 'v'; ?> <?php echo htmlspecialchars($update->version); ?>
                  </span>
                  <?php if ($c === 1): ?>
                  <span class="badge bg-label-success ms-1"><?php echo lang('latest') ?: 'Dernière'; ?></span>
                  <?php endif; ?>
                </td>
                <td>
                  <pre class="mb-0 small text-muted" style="white-space:pre-wrap;"><?php echo htmlspecialchars($update->changelog); ?></pre>
                </td>
                <td>
                  <?php if ($c === 1 && !empty($update->filename)): ?>
                    <a href="<?php echo admin_url('system_settings/install_update/' . substr($update->filename, 0, -4) . '/' . (!empty($update->mversion) ? $update->mversion : 0) . '/' . $update->version); ?>"
                       class="btn btn-primary btn-sm"
                       onclick="return confirm('<?php echo lang('confirm_install') ?: 'Confirmer l\'installation ?'; ?>')">
                      <span class="icon-base ri ri-download-line me-1 icon-16px"></span>
                      <?php echo lang('install') ?: 'Installer'; ?>
                    </a>
                  <?php else: ?>
                    <span class="badge bg-label-secondary"><?php echo lang('installed') ?: 'Installée'; ?></span>
                  <?php endif; ?>
                </td>
              </tr>
              <?php $c++; endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
          <span class="icon-base ri ri-checkbox-circle-line icon-20px"></span>
          <strong><?php echo lang('using_latest_update') ?: 'Vous utilisez déjà la dernière version disponible.'; ?></strong>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>
</div>
