<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-mail-settings-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Modèles d'email</h4>
    <p class="mb-0 text-muted">Personnalisez les emails transactionnels</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('email_templates') ?: 'Modèles e-mail'; ?></li>
      </ol>
    </nav>
  </div>
</div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-mail-settings-line me-2 text-primary"></span>
        <?php echo lang('email_templates') ?: 'Modèles d\'e-mail'; ?>
      </h5>
    </div>
    <div class="card-body">
      <?php if (!empty($templates)): ?>
      <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th><?php echo lang('name') ?: 'Nom'; ?></th>
              <th><?php echo lang('subject') ?: 'Objet'; ?></th>
              <th style="width:100px;"><?php echo lang('actions') ?: 'Actions'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($templates as $i => $tpl): ?>
            <tr>
              <td><?php echo $i + 1; ?></td>
              <td><?php echo htmlspecialchars($tpl->name ?? ''); ?></td>
              <td><?php echo htmlspecialchars($tpl->subject ?? ''); ?></td>
              <td>
                <a href="<?php echo admin_url('email_templates/edit/' . $tpl->id); ?>" class="btn btn-sm btn-icon btn-outline-primary" title="<?php echo lang('edit') ?: 'Modifier'; ?>">
                  <span class="icon-base ri ri-edit-line"></span>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div class="text-center py-5 text-muted">
        <span class="icon-base ri ri-mail-line" style="font-size:3rem;"></span>
        <p class="mt-2"><?php echo lang('no_records') ?: 'Aucun modèle trouvé'; ?></p>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
