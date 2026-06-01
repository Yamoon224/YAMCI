<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default" data-bs-theme="light"
      data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
      data-template="vertical-menu-template">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo lang('forgot_password') ?: 'Forgot Password'; ?> &mdash; <?php echo $this->Settings->site_name; ?></title>

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
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/form-validation.css'); ?>" />

  <!-- Page Auth CSS -->
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/pages/page-auth.css'); ?>" />

  <!-- Custom SMA CSS -->
  <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/css/sma-custom.css'); ?>" />

  <!-- Helpers -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/helpers.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/template-customizer.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/config.js'); ?>"></script>
</head>

<body>

  <!-- Content -->
  <div class="position-relative">
    <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
      <div class="authentication-inner py-6">

        <!-- Forgot Password Card -->
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
          <!-- /Logo -->

          <div class="card-body mt-1">
            <h4 class="mb-1">Mot de passe oublié ? 🔒</h4>
            <p class="mb-5 text-muted">Saisissez votre adresse e-mail et nous vous enverrons des instructions pour réinitialiser votre mot de passe.</p>

            <!-- Error / Success Messages -->
            <?php if (!empty($message)): ?>
            <div class="alert alert-<?php echo strpos(strtolower($message), 'error') !== false ? 'danger' : 'success'; ?> alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-<?php echo strpos(strtolower($message), 'error') !== false ? 'error-warning' : 'checkbox-circle'; ?>-line me-2 ri-xl" aria-hidden="true"></span>
                <div><?php echo $message; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl" aria-hidden="true"></span>
                <div><?php echo $error; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Flash message from session -->
            <?php if ($this->session->flashdata('message')): ?>
            <div class="alert alert-info alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-information-line me-2 ri-xl" aria-hidden="true"></span>
                <div><?php echo $this->session->flashdata('message'); ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Forgot Password Form -->
            <?php echo admin_form_open('auth/forgot_password', ['id' => 'formAuthentication', 'class' => 'mb-5']); ?>

              <!-- Email / Identity Field -->
              <div class="form-floating form-floating-outline mb-5 form-control-validation">
                <?php if (isset($email) && is_array($email)): ?>
                  <?php echo form_input(array_merge($email, ['class' => 'form-control', 'placeholder' => $email['placeholder'] ?? lang('email_address') ?: 'Enter your email'])); ?>
                  <label for="<?php echo $email['id'] ?? 'forgot_email'; ?>"><?php echo lang('email_address') ?: 'Email'; ?></label>
                <?php else: ?>
                  <input type="email"
                         class="form-control"
                         id="forgot_email"
                         name="forgot_email"
                         placeholder="<?php echo lang('email_address') ?: 'john@example.com'; ?>"
                         value="<?php echo set_value('forgot_email'); ?>"
                         autofocus
                         required />
                  <label for="forgot_email"><?php echo lang('email_address') ?: 'Email'; ?></label>
                <?php endif; ?>
              </div>

              <!-- Captcha -->
              <?php if (!empty($image) && !empty($captcha)): ?>
              <div class="mb-4">
                <div class="row g-3 align-items-center">
                  <div class="col-sm-6">
                    <span class="captcha-image"><?php echo $image; ?></span>
                  </div>
                  <div class="col-sm-6">
                    <div class="input-group input-group-merge">
                      <a href="<?php echo admin_url('auth/reload_captcha'); ?>"
                         class="input-group-text reload-captcha"
                         title="<?php echo lang('reload') ?: 'Reload captcha'; ?>">
                        <i class="icon-base ri ri-refresh-line icon-20px" aria-hidden="true"></i>
                      </a>
                      <?php echo form_input($captcha, '', 'class="form-control"'); ?>
                    </div>
                  </div>
                </div>
              </div>
              <?php endif; ?>

              <!-- Submit Button -->
              <button class="btn btn-primary d-grid w-100 mb-5" type="submit" id="submitBtn">
                <?php echo lang('submit') ?: 'Send Reset Link'; ?>
              </button>
            <?php echo form_close(); ?>

            <!-- Back to Login -->
            <div class="text-center">
              <a href="<?php echo site_url('admin/auth/login'); ?>" class="d-flex align-items-center justify-content-center">
                <i class="icon-base ri ri-arrow-left-s-line scaleX-n1-rtl icon-20px me-1_5" aria-hidden="true"></i>
                <?php echo lang('back_to_login') ?: 'Back to login'; ?>
              </a>
            </div>

          </div>
        </div>
        <!-- /Forgot Password Card -->

        <img alt="mask"
             src="<?php echo base_url('themes/materialize/admin/assets/img/illustrations/auth-basic-forgot-password-mask-light.png'); ?>"
             class="authentication-image d-none d-lg-block"
             data-app-light-img="img/illustrations/auth-basic-forgot-password-mask-light.png"
             data-app-dark-img="img/illustrations/auth-basic-forgot-password-mask-dark.png" />

      </div>
    </div>
  </div>
  <!-- /Content -->

  <!-- Core JS -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/popper/popper.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/bootstrap.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/hammer/hammer.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/i18n/i18n.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/menu.js'); ?>"></script>

  <!-- Vendors JS -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/popular.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/bootstrap5.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/auto-focus.js'); ?>"></script>

  <!-- Main JS -->
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/main.js'); ?>"></script>
  <script src="<?php echo base_url('themes/materialize/admin/assets/js/pages-auth.js'); ?>"></script>

  <script>
    (function () {
      // Submit loading state
      var form = document.getElementById('formAuthentication');
      var submitBtn = document.getElementById('submitBtn');
      if (form && submitBtn) {
        form.addEventListener('submit', function () {
          submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span><?php echo addslashes(lang("loading") ?: "Sending..."); ?>';
          submitBtn.disabled = true;
        });
      }

      // Captcha reload (jQuery fallback or fetch)
      var reloadLinks = document.querySelectorAll('.reload-captcha');
      reloadLinks.forEach(function (link) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          fetch('<?php echo admin_url("auth/reload_captcha"); ?>')
            .then(function (r) { return r.text(); })
            .then(function (html) {
              var captchaEl = document.querySelector('.captcha-image');
              if (captchaEl) captchaEl.innerHTML = html;
            });
        });
      });
    })();
  </script>

</body>
</html>
