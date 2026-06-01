<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default" data-bs-theme="light"
      data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
      data-template="vertical-menu-template">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?php echo $title ?? (lang('reset_password') ?: 'Reset Password'); ?> &mdash; <?php echo $this->Settings->site_name; ?></title>
  <script type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?php echo admin_url('pos'); ?>'; }</script>

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

        <!-- Reset Password Card -->
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
            <h4 class="mb-1">
              <?php
              if (isset($identity_label)) {
                echo sprintf(lang('reset_password_email') ?: 'Reset Password for %s', $identity_label);
              } else {
                echo lang('reset_password') ?: 'Reset Password 🔑';
              }
              ?>
            </h4>
            <p class="mb-5 text-muted"><?php echo lang('pasword_hint') ?: 'Your new password must be at least 8 characters long and contain uppercase, lowercase letters and a number.'; ?></p>

            <!-- Maintenance Mode Alert -->
            <?php if (!empty($Settings->mmode)): ?>
            <div class="alert alert-warning alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl" aria-hidden="true"></span>
                <div><?php echo lang('site_is_offline') ?: 'The site is currently in maintenance mode.'; ?></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Error Messages -->
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-error-warning-line me-2 ri-xl" aria-hidden="true"></span>
                <div><ul class="list-unstyled mb-0"><?php echo $error; ?></ul></div>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <!-- Success Messages -->
            <?php if (!empty($message)): ?>
            <div class="alert alert-success alert-dismissible mb-4" role="alert">
              <div class="d-flex">
                <span class="ri-checkbox-circle-line me-2 ri-xl" aria-hidden="true"></span>
                <div><ul class="list-unstyled mb-0"><?php echo $message; ?></ul></div>
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

            <!-- Reset Password Form -->
            <?php echo admin_form_open('auth/reset_password/' . $code, ['id' => 'formResetPassword', 'class' => 'mb-5']); ?>

              <!-- Hidden CSRF from original (legacy compatibility) -->
              <?php if (isset($csrf)): ?>
              <?php echo form_hidden($csrf); ?>
              <?php endif; ?>

              <!-- Hidden User ID -->
              <?php if (isset($user_id)): ?>
              <?php echo form_input($user_id); ?>
              <?php endif; ?>

              <!-- New Password -->
              <div class="mb-5">
                <div class="form-password-toggle form-control-validation">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <?php if (isset($new_password) && is_array($new_password)): ?>
                        <input type="password"
                               class="form-control"
                               id="new_password"
                               name="<?php echo $new_password['name'] ?? 'new_password'; ?>"
                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                               autocomplete="new-password"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               aria-describedby="toggleNewPassword"
                               required
                               autofocus />
                      <?php else: ?>
                        <input type="password"
                               class="form-control"
                               id="new_password"
                               name="new_password"
                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                               autocomplete="new-password"
                               pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                               aria-describedby="toggleNewPassword"
                               required
                               autofocus />
                      <?php endif; ?>
                      <label for="new_password"><?php echo lang('new_password') ?: 'New Password'; ?></label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="toggleNewPassword" aria-label="<?php echo lang('toggle_password') ?: 'Toggle password visibility'; ?>">
                      <i class="icon-base ri ri-eye-off-line icon-20px" aria-hidden="true"></i>
                    </span>
                  </div>
                </div>
                <div class="form-text text-muted mt-1">
                  <?php echo lang('pasword_hint') ?: 'Min 8 chars with uppercase, lowercase and a number.'; ?>
                </div>
              </div>

              <!-- Confirm New Password -->
              <div class="mb-5">
                <div class="form-password-toggle form-control-validation">
                  <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                      <?php if (isset($new_password_confirm) && is_array($new_password_confirm)): ?>
                        <input type="password"
                               class="form-control"
                               id="new_password_confirm"
                               name="<?php echo $new_password_confirm['name'] ?? 'new_password_confirm'; ?>"
                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                               autocomplete="new-password"
                               aria-describedby="toggleConfirmPassword"
                               required />
                      <?php else: ?>
                        <input type="password"
                               class="form-control"
                               id="new_password_confirm"
                               name="new_password_confirm"
                               placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                               autocomplete="new-password"
                               aria-describedby="toggleConfirmPassword"
                               required />
                      <?php endif; ?>
                      <label for="new_password_confirm"><?php echo lang('confirm_password') ?: 'Confirm New Password'; ?></label>
                    </div>
                    <span class="input-group-text cursor-pointer" id="toggleConfirmPassword" aria-label="<?php echo lang('toggle_password') ?: 'Toggle password visibility'; ?>">
                      <i class="icon-base ri ri-eye-off-line icon-20px" aria-hidden="true"></i>
                    </span>
                  </div>
                </div>
              </div>

              <!-- Submit Button -->
              <div class="mb-5 d-flex align-items-center justify-content-between gap-3">
                <a href="<?php echo admin_url('auth/login'); ?>" class="btn btn-outline-secondary">
                  <i class="icon-base ri ri-arrow-left-s-line icon-20px me-1" aria-hidden="true"></i>
                  <?php echo lang('back_to_login') ?: 'Back to Login'; ?>
                </a>
                <button class="btn btn-primary flex-grow-1" type="submit" id="submitBtn">
                  <?php echo lang('submit') ?: 'Set New Password'; ?>
                  <i class="icon-base ri ri-send-plane-line icon-20px ms-1" aria-hidden="true"></i>
                </button>
              </div>
            <?php echo form_close(); ?>

          </div>
        </div>
        <!-- /Reset Password Card -->

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
      // Generic password toggle helper
      function bindToggle(toggleId, inputId) {
        var btn = document.getElementById(toggleId);
        if (!btn) return;
        btn.addEventListener('click', function () {
          var input = document.getElementById(inputId);
          var icon = this.querySelector('i');
          if (!input) return;
          if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'icon-base ri ri-eye-line icon-20px';
          } else {
            input.type = 'password';
            icon.className = 'icon-base ri ri-eye-off-line icon-20px';
          }
        });
      }

      bindToggle('toggleNewPassword', 'new_password');
      bindToggle('toggleConfirmPassword', 'new_password_confirm');

      // Client-side confirm password match check
      var form = document.getElementById('formResetPassword');
      var submitBtn = document.getElementById('submitBtn');

      if (form) {
        form.addEventListener('submit', function (e) {
          var pwd = document.getElementById('new_password');
          var confirmPwd = document.getElementById('new_password_confirm');

          if (pwd && confirmPwd && pwd.value !== confirmPwd.value) {
            e.preventDefault();
            // Remove previous error if any
            var existingAlert = form.querySelector('.alert-mismatch');
            if (!existingAlert) {
              var alertDiv = document.createElement('div');
              alertDiv.className = 'alert alert-danger alert-dismissible mb-4 alert-mismatch';
              alertDiv.setAttribute('role', 'alert');
              alertDiv.innerHTML = '<div class="d-flex"><span class="ri-error-warning-line me-2 ri-xl"></span>'
                + '<div><?php echo addslashes(lang("pw_not_same") ?: "Passwords do not match."); ?></div></div>'
                + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
              form.insertBefore(alertDiv, form.firstChild);
            }
            return false;
          }

          if (submitBtn) {
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span><?php echo addslashes(lang("loading") ?: "Saving..."); ?>';
            submitBtn.disabled = true;
          }
        });
      }
    })();
  </script>

</body>
</html>
