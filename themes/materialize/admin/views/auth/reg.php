<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?php echo $this->config->item('language') ?: 'en'; ?>" class="layout-wide customizer-hide" dir="ltr"
      data-skin="default" data-bs-theme="light"
      data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
      data-template="vertical-menu-template">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo lang('register') ?: 'Register'; ?> &mdash; <?php echo htmlspecialchars($this->Settings->site_name ?? ''); ?></title>
  <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo.png'); ?>" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/fonts/iconify-icons.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/core.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/pages/page-auth.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/css/sma-custom.css'); ?>" />
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/helpers.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/template-customizer.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/config.js'); ?>"></script>
</head>
<body>
  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">
        <div class="card p-md-7 p-1">

          <div class="app-brand justify-content-center mt-5">
            <a href="<?php echo site_url(); ?>" class="app-brand-link gap-2">
              <?php if (!empty($this->Settings->logo2)): ?>
                <img src="<?php echo base_url('assets/uploads/logos/' . $this->Settings->logo2); ?>"
                     alt="<?php echo htmlspecialchars($this->Settings->site_name); ?>"
                     height="110" style="max-width:110px;object-fit:contain;" />
              <?php elseif (!empty($this->Settings->logo)): ?>
                <img src="<?php echo base_url('assets/uploads/logos/' . $this->Settings->logo); ?>"
                     alt="<?php echo htmlspecialchars($this->Settings->site_name); ?>"
                     height="110" style="max-width:110px;object-fit:contain;" />
              <?php else: ?>
                <span class="app-brand-text demo text-heading fw-semibold"><?php echo htmlspecialchars($this->Settings->site_name); ?></span>
              <?php endif; ?>
            </a>
          </div>

          <div class="card-body mt-1">
            <h4 class="mb-1">Créer un compte 🚀</h4>
            <p class="mb-5 text-muted">Remplissez les informations ci-dessous pour créer votre compte.</p>

            <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible mb-4">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl"></span>
                <div><ul class="list-unstyled mb-0"><?php echo $error; ?></ul></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible mb-4">
              <div class="d-flex">
                <span class="ri-checkbox-circle-line me-2 ri-xl"></span>
                <div><ul class="list-unstyled mb-0"><?php echo $message; ?></ul></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php echo admin_form_open('auth/create_user', ['id' => 'formRegister', 'class' => 'mb-5']); ?>

              <div class="row">
                <div class="col-md-6 mb-5">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="first_name" name="first_name"
                           placeholder="<?php echo lang('first_name') ?: 'Prénom'; ?>"
                           value="<?php echo set_value('first_name'); ?>" required />
                    <label for="first_name"><?php echo lang('first_name') ?: 'Prénom'; ?> <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="col-md-6 mb-5">
                  <div class="form-floating form-floating-outline">
                    <input type="text" class="form-control" id="last_name" name="last_name"
                           placeholder="<?php echo lang('last_name') ?: 'Nom'; ?>"
                           value="<?php echo set_value('last_name'); ?>" required />
                    <label for="last_name"><?php echo lang('last_name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
                  </div>
                </div>
              </div>

              <div class="form-floating form-floating-outline mb-5">
                <input type="text" class="form-control" id="reg_username" name="username"
                       placeholder="<?php echo lang('username') ?: 'Identifiant'; ?>"
                       value="<?php echo set_value('username'); ?>" required />
                <label for="reg_username"><?php echo lang('username') ?: 'Identifiant'; ?> <span class="text-danger">*</span></label>
              </div>

              <div class="form-floating form-floating-outline mb-5">
                <input type="email" class="form-control" id="reg_email" name="email"
                       placeholder="email@example.com"
                       value="<?php echo set_value('email'); ?>" required />
                <label for="reg_email"><?php echo lang('email') ?: 'E-mail'; ?> <span class="text-danger">*</span></label>
              </div>

              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="reg_password" class="form-control" name="password"
                             placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                      <label for="reg_password"><?php echo lang('password') ?: 'Mot de passe'; ?> <span class="text-danger">*</span></label>
                    </div>
                    <span class="input-group-text cursor-pointer">
                      <span class="icon-base ri ri-eye-off-line"></span>
                    </span>
                  </div>
                </div>
              </div>

              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="reg_confirm_password" class="form-control" name="confirm_password"
                             placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                      <label for="reg_confirm_password"><?php echo lang('confirm_password') ?: 'Confirmer mot de passe'; ?> <span class="text-danger">*</span></label>
                    </div>
                    <span class="input-group-text cursor-pointer">
                      <span class="icon-base ri ri-eye-off-line"></span>
                    </span>
                  </div>
                </div>
              </div>

              <?php if (function_exists('recaptcha_get_html') && !empty($this->Settings->recaptcha_site_key)): ?>
              <div class="mb-4"><?php echo recaptcha_get_html($this->Settings->recaptcha_site_key); ?></div>
              <?php endif; ?>

              <button type="submit" class="btn btn-primary d-grid w-100">
                <?php echo lang('register') ?: 'Créer le compte'; ?>
              </button>

            <?php echo form_close(); ?>

            <p class="text-center">
              <span><?php echo lang('already_member') ?: 'Déjà inscrit ?'; ?></span>
              <a href="<?php echo site_url('auth/login'); ?>">
                <span><?php echo lang('login') ?: 'Se connecter'; ?></span>
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/popper/popper.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/bootstrap.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/menu.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/main.js'); ?>"></script>

  <script>
  // Toggle password visibility
  document.querySelectorAll('.form-password-toggle .input-group-text').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var input = this.closest('.input-group').querySelector('input');
      var icon = this.querySelector('.icon-base');
      if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'icon-base ri ri-eye-line';
      } else {
        input.type = 'password';
        icon.className = 'icon-base ri ri-eye-off-line';
      }
    });
  });
  </script>
</body>
</html>
