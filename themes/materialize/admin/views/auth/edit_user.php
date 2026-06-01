<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo admin_form_open(uri_string(), ['id' => 'editUserForm']); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-user-settings-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('edit_user_heading') ?: 'Modifier l\'utilisateur'; ?></h4>
    <p class="mb-0 text-muted"><?php echo lang('edit_user_subheading') ?: 'Modifier les informations et les groupes de l\'utilisateur.'; ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>">Accueil</a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('auth'); ?>">Utilisateurs</a></li>
        <li class="breadcrumb-item active">Modifier</li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('auth'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i>Annuler
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#editUserForm').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i>Enregistrer
    </button>
  </div>
</div>

<div class="row">
  <!-- Informations personnelles -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-user-line me-2 text-primary icon-18px"></span>
          <?php echo lang('personal_info') ?: 'Informations personnelles'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?php
              $fn = $first_name;
              $fn['class'] = 'form-control';
              $fn['placeholder'] = 'Prénom';
              echo form_input($fn);
              ?>
              <label for="first_name"><?php echo lang('edit_user_fname_label') ?: 'Prénom'; ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?php
              $ln = $last_name;
              $ln['class'] = 'form-control';
              $ln['placeholder'] = 'Nom';
              echo form_input($ln);
              ?>
              <label for="last_name"><?php echo lang('edit_user_lname_label') ?: 'Nom'; ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <?php
              $co = $company;
              $co['class'] = 'form-control';
              $co['placeholder'] = 'Société';
              echo form_input($co);
              ?>
              <label for="company"><?php echo lang('edit_user_company_label') ?: 'Société'; ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <?php
              $ph = $phone;
              $ph['class'] = 'form-control';
              $ph['placeholder'] = '+225 0700000000';
              echo form_input($ph);
              ?>
              <label for="phone"><?php echo lang('edit_user_phone_label') ?: 'Téléphone'; ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Mot de passe + Groupes -->
  <div class="col-md-6">
    <!-- Nouveau mot de passe -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-lock-password-line me-2 text-primary icon-18px"></span>
          <?php echo lang('password') ?: 'Mot de passe'; ?>
        </h5>
      </div>
      <div class="card-body">
        <p class="text-muted small mb-3"><?php echo lang('leave_blank_to_keep') ?: 'Laisser vide pour conserver le mot de passe actuel.'; ?></p>
        <div class="row g-4">
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <?php
              $pw = $password;
              $pw['class'] = 'form-control';
              $pw['placeholder'] = '············';
              echo form_input($pw);
              ?>
              <label for="password"><?php echo lang('edit_user_password_label') ?: 'Nouveau mot de passe'; ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <?php
              $pwc = $password_confirm;
              $pwc['class'] = 'form-control';
              $pwc['placeholder'] = '············';
              echo form_input($pwc);
              ?>
              <label for="password_confirm"><?php echo lang('edit_user_password_confirm_label') ?: 'Confirmer le mot de passe'; ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Groupes -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-group-line me-2 text-primary icon-18px"></span>
          <?php echo lang('edit_user_groups_heading') ?: 'Groupes'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="row g-2">
          <?php foreach ($groups as $group): ?>
            <?php
            $gID    = $group['id'];
            $checked = '';
            foreach ($currentGroups as $grp) {
                if ($gID == $grp->id) {
                    $checked = 'checked';
                    break;
                }
            }
            ?>
            <div class="col-md-6">
              <div class="form-check">
                <input type="checkbox" class="form-check-input"
                       name="groups[]"
                       value="<?php echo $group['id']; ?>"
                       id="group_<?php echo $group['id']; ?>"
                       <?php echo $checked; ?> />
                <label class="form-check-label" for="group_<?php echo $group['id']; ?>">
                  <?php echo htmlspecialchars($group['name']); ?>
                </label>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php echo form_hidden('id', $user->id); ?>
<?php echo form_hidden($csrf); ?>

<div class="row mb-4">
  <div class="col-12">
    <div class="d-flex gap-3">
      <button type="submit" name="submit" class="btn btn-primary">
        <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
        <?php echo lang('edit_user_submit_btn') ?: 'Enregistrer'; ?>
      </button>
      <a href="<?php echo admin_url('auth'); ?>" class="btn btn-outline-secondary">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </a>
    </div>
  </div>
</div>

<?php echo form_close(); ?>
