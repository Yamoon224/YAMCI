<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="<?php echo $this->config->item('language') ?: 'en'; ?>" class="layout-wide customizer-hide" dir="ltr"
      data-skin="default" data-bs-theme="light"
      data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
      data-template="vertical-menu-template">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo lang('login') ?: 'Login'; ?> &mdash; <?php echo htmlspecialchars($this->Settings->site_name ?? ''); ?></title>
  <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?php echo admin_url(); ?>'; }</script>
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
    <div class="authentication-wrapper authentication-cover">
      <div class="authentication-inner row m-0">

        <!-- Left illustration panel -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg d-flex align-items-end justify-content-center"
               style="background: linear-gradient(135deg, #312d4b 0%, #666cff 100%); height: 100vh; width: 100%;">
            <div class="text-center text-white pb-5 px-4">
              <h2 class="text-white fw-bold mb-2"><?php echo htmlspecialchars($this->Settings->site_name ?? 'SMA'); ?></h2>
              <p class="text-white-50 mb-0"><?php echo lang('system_slogan') ?: 'Gestion de stock intelligente'; ?></p>
            </div>
          </div>
        </div>

        <!-- Right login panel -->
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">

            <div class="app-brand mb-6">
              <a href="<?php echo site_url(); ?>" class="app-brand-link gap-2">
                <img src="<?php echo base_url('assets/images/logo.png'); ?>"
                     alt="<?php echo htmlspecialchars($this->Settings->site_name ?? ''); ?>"
                     style="max-height:40px; max-width:160px; width:auto; object-fit:contain;" />
              </a>
            </div>

            <h3 class="mb-1"><?php echo lang('welcome_back') ?: 'Bon retour ! 👋'; ?></h3>
            <p class="mb-5 text-muted"><?php echo lang('login_desc') ?: 'Connectez-vous à votre compte.'; ?></p>

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

            <?php echo admin_form_open('auth/login', ['id' => 'formAuthentication2', 'class' => 'mb-5']); ?>

              <div class="form-floating form-floating-outline mb-5">
                <input type="<?php echo (!empty($Settings->email_login)) ? 'email' : 'text'; ?>"
                       class="form-control" id="s2_identity" name="identity"
                       placeholder="<?php echo (!empty($Settings->email_login)) ? 'email@example.com' : 'username'; ?>"
                       value="<?php echo DEMO ? 'owner@tecdiary.com' : set_value('identity'); ?>"
                       required autofocus />
                <label for="s2_identity">
                  <?php echo (!empty($Settings->email_login)) ? (lang('email') ?: 'Email') : (lang('username') ?: 'Identifiant'); ?>
                </label>
              </div>

              <div class="mb-5">
                <div class="form-password-toggle">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <input type="password" id="s2_password" class="form-control" name="password"
                             placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                             value="<?php echo DEMO ? '12345678' : ''; ?>" required />
                      <label for="s2_password"><?php echo lang('password') ?: 'Mot de passe'; ?></label>
                    </div>
                    <span class="input-group-text cursor-pointer">
                      <span class="icon-base ri ri-eye-off-line"></span>
                    </span>
                  </div>
                </div>
              </div>

              <div class="d-flex justify-content-between flex-wrap mb-5">
                <div class="form-check mb-0">
                  <input class="form-check-input" type="checkbox" id="s2_remember" name="remember" />
                  <label class="form-check-label" for="s2_remember"><?php echo lang('remember_me') ?: 'Se souvenir de moi'; ?></label>
                </div>
                <a href="<?php echo site_url('auth/forgot_password'); ?>" class="float-end mb-1 mt-0">
                  <span><?php echo lang('forgot_password') ?: 'Mot de passe oublié ?'; ?></span>
                </a>
              </div>

              <button class="btn btn-primary d-grid w-100" type="submit">
                <span><?php echo lang('login') ?: 'Se connecter'; ?></span>
              </button>

            <?php echo form_close(); ?>
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
