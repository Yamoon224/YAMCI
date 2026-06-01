<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php echo admin_form_open('auth/create_user', ['id' => 'createUserForm']); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-user-add-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('create_user') ?: 'Créer un utilisateur'; ?></h4>
    <p class="mb-0 text-muted">Ajoutez un nouveau compte utilisateur au système</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>">Accueil</a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('auth'); ?>">Utilisateurs</a></li>
        <li class="breadcrumb-item active">Créer</li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('auth'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i>Annuler
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#createUserForm').submit();">
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
              <input type="text" class="form-control" id="first_name" name="first_name"
                     placeholder="Prénom" value="<?php echo set_value('first_name'); ?>" required />
              <label for="first_name"><?php echo lang('first_name') ?: 'Prénom'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="last_name" name="last_name"
                     placeholder="Nom" value="<?php echo set_value('last_name'); ?>" required />
              <label for="last_name"><?php echo lang('last_name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <select class="form-select select2" id="gender" name="gender"
                      data-placeholder="<?php echo lang('select') . ' ' . (lang('gender') ?: 'Genre'); ?>">
                <option value=""></option>
                <option value="male" <?php echo set_select('gender', 'male'); ?>><?php echo lang('male') ?: 'Homme'; ?></option>
                <option value="female" <?php echo set_select('gender', 'female'); ?>><?php echo lang('female') ?: 'Femme'; ?></option>
              </select>
              <label for="gender"><?php echo lang('gender') ?: 'Genre'; ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="company" name="company"
                     placeholder="Société" value="<?php echo set_value('company'); ?>" />
              <label for="company"><?php echo lang('company') ?: 'Société'; ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="phone" name="phone"
                     placeholder="+225 0700000000" value="<?php echo set_value('phone'); ?>" />
              <label for="phone"><?php echo lang('phone') ?: 'Téléphone'; ?></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input type="email" class="form-control" id="email" name="email"
                     placeholder="email@exemple.com" value="<?php echo set_value('email'); ?>" required />
              <label for="email"><?php echo lang('email') ?: 'Email'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
          <div class="col-12">
            <div class="form-floating form-floating-outline">
              <input type="text" class="form-control" id="username" name="username"
                     placeholder="johndoe" value="<?php echo set_value('username'); ?>" required />
              <label for="username"><?php echo lang('username') ?: 'Nom d\'utilisateur'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="password" class="form-control" id="password" name="password"
                     placeholder="············" required
                     pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
              <label for="password"><?php echo lang('password') ?: 'Mot de passe'; ?> <span class="text-danger">*</span></label>
            </div>
            <small class="text-muted"><?php echo lang('pasword_hint') ?: 'Min 8 caractères, 1 maj, 1 chiffre'; ?></small>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                     placeholder="············" required />
              <label for="confirm_password"><?php echo lang('confirm_password') ?: 'Confirmer le mot de passe'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Droits et accès -->
  <div class="col-md-6">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-shield-user-line me-2 text-primary icon-18px"></span>
          <?php echo lang('access_rights') ?: 'Droits d\'accès'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?php
              $opt = [1 => lang('active') ?: 'Actif', 0 => lang('inactive') ?: 'Inactif'];
              echo form_dropdown('status', $opt, set_value('status', 1),
                'id="status" class="form-select select2" data-placeholder="' . (lang('select') ?: 'Sélectionner') . '"');
              ?>
              <label for="status"><?php echo lang('status') ?: 'Statut'; ?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-floating form-floating-outline">
              <?php
              $gp = [];
              foreach ($groups as $group) {
                  if ($group['name'] != 'customer' && $group['name'] != 'supplier') {
                      $gp[$group['id']] = $group['name'];
                  }
              }
              echo form_dropdown('group', $gp, set_value('group'),
                'id="group" class="form-select select2" data-placeholder="' . (lang('select') . ' ' . (lang('group') ?: 'Groupe')) . '"');
              ?>
              <label for="group"><?php echo lang('group') ?: 'Groupe'; ?> <span class="text-danger">*</span></label>
            </div>
          </div>

          <!-- Extra fields shown for non-owner/admin groups -->
          <div id="extraUserFields" style="display:none;" class="col-12">
            <div class="row g-4">
              <div class="col-12">
                <div class="form-floating form-floating-outline">
                  <?php
                  $bl = ['' => lang('select') . ' ' . (lang('biller') ?: 'Factureur')];
                  foreach ($billers as $biller) {
                      $bl[$biller->id] = ($biller->company && $biller->company != '-') ? $biller->company : $biller->name;
                  }
                  echo form_dropdown('biller', $bl, set_value('biller'),
                    'id="biller" class="form-select select2" data-placeholder="' . (lang('select') . ' ' . (lang('biller') ?: 'Factureur')) . '"');
                  ?>
                  <label for="biller"><?php echo lang('biller') ?: 'Factureur'; ?></label>
                </div>
              </div>
              <div class="col-12">
                <div class="form-floating form-floating-outline">
                  <?php
                  $wh = ['' => lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')];
                  foreach ($warehouses as $warehouse) {
                      $wh[$warehouse->id] = $warehouse->name;
                  }
                  echo form_dropdown('warehouse', $wh, set_value('warehouse'),
                    'id="warehouse" class="form-select select2" data-placeholder="' . (lang('select') . ' ' . (lang('warehouse') ?: 'Entrepôt')) . '"');
                  ?>
                  <label for="warehouse"><?php echo lang('warehouse') ?: 'Entrepôt'; ?></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                  <?php
                  $vropts = [1 => lang('all_records') ?: 'Tous', 0 => lang('own_records') ?: 'Propres'];
                  echo form_dropdown('view_right', $vropts, set_value('view_right', 1),
                    'id="view_right" class="form-select select2"');
                  ?>
                  <label for="view_right"><?php echo lang('view_right') ?: 'Droit de vue'; ?></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                  <?php
                  $opts = [1 => lang('yes') ?: 'Oui', 0 => lang('no') ?: 'Non'];
                  echo form_dropdown('edit_right', $opts, set_value('edit_right', 0),
                    'id="edit_right" class="form-select select2"');
                  ?>
                  <label for="edit_right"><?php echo lang('edit_right') ?: 'Droit de modification'; ?></label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating form-floating-outline">
                  <?php
                  echo form_dropdown('allow_discount', $opts, set_value('allow_discount', 0),
                    'id="allow_discount" class="form-select select2"');
                  ?>
                  <label for="allow_discount"><?php echo lang('allow_discount') ?: 'Autoriser remise'; ?></label>
                </div>
              </div>
            </div>
          </div>

          <div class="col-12">
            <div class="form-check">
              <input type="checkbox" class="form-check-input" name="notify" value="1" id="notify" checked />
              <label class="form-check-label" for="notify">
                <?php echo lang('notify_user_by_email') ?: 'Notifier l\'utilisateur par email'; ?>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-4">
  <div class="col-12">
    <div class="d-flex gap-3">
      <button type="submit" name="add_user" class="btn btn-primary">
        <span class="icon-base ri ri-user-add-line me-1 icon-16px"></span>
        <?php echo lang('add_user') ?: 'Créer l\'utilisateur'; ?>
      </button>
      <a href="<?php echo admin_url('auth'); ?>" class="btn btn-outline-secondary">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </a>
    </div>
  </div>
</div>

<?php echo form_close(); ?>

<script>
(function () {
  var groupSelect = document.getElementById('group');
  var extraFields = document.getElementById('extraUserFields');

  function checkGroup() {
    var val = groupSelect ? groupSelect.value : '';
    // groups 1 and 2 are typically owner/admin — hide extra fields
    if (val == 1 || val == 2 || val === '') {
      extraFields.style.display = 'none';
    } else {
      extraFields.style.display = '';
    }
  }

  if (groupSelect) {
    groupSelect.addEventListener('change', checkGroup);
    // Also listen for Select2
    if (window.$) {
      $(groupSelect).on('change', checkGroup);
    }
    checkGroup();
  }
})();
</script>
