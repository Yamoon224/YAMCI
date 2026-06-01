<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default" data-bs-theme="light"
      data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
      data-template="vertical-menu-template">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo lang('register') ?: 'Inscription'; ?> &mdash; <?php echo $this->Settings->site_name; ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/uploads/logos/' . ($this->Settings->logo ?? 'logo.png')); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/fonts/iconify-icons.css'); ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/core.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/pages/page-auth.css'); ?>" />
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/css/sma-custom.css'); ?>" />

  <!-- Helpers -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/helpers.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/template-customizer.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/config.js'); ?>"></script>
</head>

<body>
  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">

        <div class="card p-md-7 p-1">

          <!-- Logo -->
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
            <h4 class="mb-1"><?php echo lang('register_subheading') ?: 'Créer un compte'; ?></h4>
            <p class="mb-5 text-muted"><?php echo lang('register_line') ?: 'Remplissez le formulaire pour vous inscrire.'; ?></p>

            <?php if (!empty($this->mmode)): ?>
            <div class="alert alert-warning alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl"></span>
                <div><?php echo lang('site_is_offline') ?: 'Le site est actuellement hors ligne.'; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl"></span>
                <div><?php echo $error; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-checkbox-circle-line me-2 ri-xl"></span>
                <div><?php echo $message; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php endif; ?>

            <?php echo admin_form_open('auth/register', ['id' => 'registerForm', 'class' => 'mb-5']); ?>

              <div class="row g-4 mb-4">
                <div class="col-md-6">
                  <div class="form-floating form-floating-outline">
                    <?php
                    $fn = $first_name;
                    $fn['class'] = 'form-control';
                    $fn['placeholder'] = 'Prénom';
                    echo form_input($fn);
                    ?>
                    <label for="first_name"><?php echo lang('create_user_fname_label') ?: 'Prénom'; ?> <span class="text-danger">*</span></label>
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
                    <label for="last_name"><?php echo lang('create_user_lname_label') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
                  </div>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating form-floating-outline">
                  <?php
                  $co = $company;
                  $co['class'] = 'form-control';
                  $co['placeholder'] = 'Société';
                  echo form_input($co);
                  ?>
                  <label for="company"><?php echo lang('create_user_company_label') ?: 'Société'; ?></label>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating form-floating-outline">
                  <?php
                  $ph = $phone;
                  $ph['class'] = 'form-control';
                  $ph['placeholder'] = '+225 ...';
                  echo form_input($ph);
                  ?>
                  <label for="phone"><?php echo lang('create_user_phone_label') ?: 'Téléphone'; ?></label>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating form-floating-outline">
                  <?php
                  $em = $email;
                  $em['class'] = 'form-control';
                  $em['placeholder'] = 'email@exemple.com';
                  echo form_input($em);
                  ?>
                  <label for="email"><?php echo lang('create_user_email_label') ?: 'Email'; ?> <span class="text-danger">*</span></label>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating form-floating-outline">
                  <?php
                  $pw = $password;
                  $pw['class'] = 'form-control';
                  $pw['placeholder'] = '············';
                  echo form_input($pw);
                  ?>
                  <label for="password"><?php echo lang('create_user_password_label') ?: 'Mot de passe'; ?> <span class="text-danger">*</span></label>
                </div>
              </div>

              <div class="mb-4">
                <div class="form-floating form-floating-outline">
                  <?php
                  $pwc = $password_confirm;
                  $pwc['class'] = 'form-control';
                  $pwc['placeholder'] = '············';
                  echo form_input($pwc);
                  ?>
                  <label for="password_confirm"><?php echo lang('create_user_password_confirm_label') ?: 'Confirmer le mot de passe'; ?> <span class="text-danger">*</span></label>
                </div>
              </div>

              <?php if (!empty($image)): ?>
              <div class="mb-4">
                <div class="row g-3 align-items-center">
                  <div class="col-sm-6">
                    <span class="captcha-image"><?php echo $image; ?></span>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <a href="<?php echo admin_url('auth/reload_captcha'); ?>" class="input-group-text reload-captcha" title="<?php echo lang('reload') ?: 'Recharger'; ?>">
                        <i class="icon-base ri ri-refresh-line icon-20px"></i>
                      </a>
                      <?php echo form_input($captcha, '', 'class="form-control" placeholder="' . (lang('type_captcha') ?: 'Saisir le code') . '"'); ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>

              <div class="mb-5">
                <button class="btn btn-primary d-grid w-100" type="submit">
                  <?php echo lang('register') ?: 'S\'inscrire'; ?>
                </button>
              </div>

            <?php echo form_close(); ?>

            <p class="text-center mb-5">
              <span><?php echo lang('already_have_account') ?: 'Vous avez déjà un compte ?'; ?></span>
              <a href="<?php echo site_url('admin/auth/login'); ?>">
                <span><?php echo lang('sign_in') ?: 'Se connecter'; ?></span>
              </a>
            </p>
          </div>
        </div>

        <img alt="mask"
             src="<?php echo base_url('themes/materialize/admin/assets/img/illustrations/auth-basic-login-mask-light.png'); ?>"
             class="authentication-image d-none d-lg-block" />
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/bootstrap.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/main.js'); ?>"></script>

  <script>
    (function () {
      var reloadLinks = document.querySelectorAll('.reload-captcha');
      reloadLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          fetch('<?php echo admin_url('auth/reload_captcha'); ?>')
            .then(function (r) { return r.text(); })
            .then(function (html) {
              var el = document.querySelector('.captcha-image');
              if (el) el.innerHTML = html;
            });
        });
      });
    })();
  </script>
</body>
</html>
