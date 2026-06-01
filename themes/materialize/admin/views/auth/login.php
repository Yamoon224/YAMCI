<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!doctype html>
<html lang="en" class="layout-wide customizer-hide" dir="ltr" data-skin="default" data-bs-theme="light"
    data-assets-path="<?php echo base_url('themes/materialize/admin/assets/'); ?>"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title><?php echo $title ?? (lang('login') ?: 'Login'); ?> &mdash; <?php echo $this->Settings->site_name; ?></title>
    <script
        type="text/javascript">if (parent.frames.length !== 0) { top.location = '<?php echo admin_url(); ?>'; }</script>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="<?php echo base_url('assets/uploads/logos/' . ($this->Settings->logo ?? 'logo.png')); ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet"
        href="<?php echo base_url('themes/materialize/admin/assets/vendor/fonts/iconify-icons.css'); ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet"
        href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/core.css'); ?>" />
    <link rel="stylesheet"
        href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
    <link rel="stylesheet"
        href="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/form-validation.css'); ?>" />

    <!-- Page Auth CSS -->
    <link rel="stylesheet"
        href="<?php echo base_url('themes/materialize/admin/assets/vendor/css/pages/page-auth.css'); ?>" />

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

                <!-- Login Card -->
                <div class="card p-md-7 p-1">

                    <!-- Logo -->
                    <div class="app-brand justify-content-center mt-5">
                        <a href="<?php echo site_url(); ?>" class="app-brand-link gap-2">
                            <?php if (!empty($this->Settings->logo2)): ?>
                                <img src="<?php echo base_url('assets/uploads/logos/' . $this->Settings->logo2); ?>"
                                    alt="<?php echo htmlspecialchars($this->Settings->site_name); ?>" height="110"
                                    style="max-width:110px;object-fit:contain;" />
                            <?php elseif (!empty($this->Settings->logo)): ?>
                                <img src="<?php echo base_url('assets/uploads/logos/' . $this->Settings->logo); ?>"
                                    alt="<?php echo htmlspecialchars($this->Settings->site_name); ?>" height="110"
                                    style="max-width:110px;object-fit:contain;" />
                            <?php else: ?>
                                <span
                                    class="app-brand-text demo text-heading fw-semibold"><?php echo htmlspecialchars($this->Settings->site_name); ?></span>
                            <?php endif; ?>
                        </a>
                    </div>
                    <!-- /Logo -->

                    <div class="card-body mt-1">
                        <h4 class="mb-1">Bienvenue sur <?= htmlspecialchars($Settings->site_name ?? 'YAMCI SARL'); ?> 👋
                        </h4>
                        <p class="mb-5 text-muted">Connectez-vous à votre compte pour continuer.</p>

                        <!-- Maintenance Mode Alert -->
                        <?php if (!empty($Settings->mmode)): ?>
                            <div class="alert alert-warning alert-dismissible mb-4" role="alert">
                                <div class="d-flex">
                                    <span class="ri-error-warning-line me-2 ri-xl" aria-hidden="true"></span>
                                    <div><?php echo lang('site_offline') ?: 'The site is currently in maintenance mode.'; ?>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Error Messages -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible mb-4" role="alert">
                                <div class="d-flex">
                                    <span class="ri-error-warning-line me-2 ri-xl" aria-hidden="true"></span>
                                    <div>
                                        <ul class="list-unstyled mb-0"><?php echo $error; ?></ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Success / Info Messages -->
                        <?php if (!empty($message)): ?>
                            <div class="alert alert-success alert-dismissible mb-4" role="alert">
                                <div class="d-flex">
                                    <span class="ri-checkbox-circle-line me-2 ri-xl" aria-hidden="true"></span>
                                    <div>
                                        <ul class="list-unstyled mb-0"><?php echo $message; ?></ul>
                                    </div>
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

                        <!-- Login Form -->
                        <?php echo admin_form_open('auth/login', ['id' => 'formAuthentication', 'class' => 'mb-5', 'autocomplete' => 'on']); ?>

                        <!-- Identity (username or email) -->
                        <div class="form-floating form-floating-outline mb-5 form-control-validation">
                            <input type="<?php echo (!empty($Settings->email_login)) ? 'email' : 'text'; ?>"
                                class="form-control" id="identity" name="identity"
                                placeholder="<?php echo (!empty($Settings->email_login)) ? 'john@example.com' : 'johndoe'; ?>"
                                value="<?php echo DEMO ? 'owner@tecdiary.com' : set_value('identity'); ?>"
                                autocomplete="username" required autofocus />
                            <label for="identity">
                                <?php echo (!empty($Settings->email_login)) ? (lang('email') ?: 'Email') : (lang('username') ?: 'Username'); ?>
                            </label>
                        </div>

                        <!-- Password -->
                        <div class="mb-5">
                            <div class="form-password-toggle form-control-validation">
                                <div class="input-group input-group-merge">
                                    <div class="form-floating form-floating-outline">
                                        <input type="password" id="password" class="form-control" name="password"
                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                            value="<?php echo DEMO ? '12345678' : ''; ?>"
                                            autocomplete="current-password" aria-describedby="togglePassword"
                                            required />
                                        <label
                                            for="password"><?php echo lang('pw') ?: lang('password') ?: 'Password'; ?></label>
                                    </div>
                                    <span class="input-group-text cursor-pointer" id="togglePassword"
                                        aria-label="<?php echo lang('toggle_password') ?: 'Toggle password visibility'; ?>">
                                        <i class="icon-base ri ri-eye-off-line icon-20px" aria-hidden="true"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Remember me + Forgot Password -->
                        <div class="mb-5 d-flex justify-content-between mt-5">
                            <div class="form-check mt-2">
                                <?php echo form_checkbox('remember', '1', false, 'class="form-check-input" id="remember"'); ?>
                                <label class="form-check-label" for="remember">
                                    <?php echo lang('remember_me') ?: 'Remember Me'; ?>
                                </label>
                            </div>
                            <a href="<?php echo site_url('admin/auth/forgot_password'); ?>" class="float-end mb-1 mt-2">
                                <span><?php echo lang('forgot_your_password') ?: 'Forgot Password?'; ?></span>
                            </a>
                        </div>

                        <!-- Captcha (if enabled) -->
                        <?php if (!empty($Settings->captcha)): ?>
                            <div class="mb-4">
                                <div class="row g-3 align-items-center">
                                    <div class="col-sm-6">
                                        <span class="captcha-image"><?php echo $image; ?></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group input-group-merge">
                                            <a href="<?php echo admin_url('auth/reload_captcha'); ?>"
                                                class="input-group-text reload-captcha"
                                                title="<?php echo lang('reload') ?: 'Reload'; ?>">
                                                <i class="icon-base ri ri-refresh-line icon-20px" aria-hidden="true"></i>
                                            </a>
                                            <?php echo form_input($captcha, '', 'class="form-control"'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- Submit Button -->
                        <div class="mb-5">
                            <button class="btn btn-primary d-grid w-100" type="submit" id="loginBtn">
                                <?php echo lang('login') ?: 'Sign in'; ?>
                            </button>
                        </div>
                        <?php echo form_close(); ?>

                        <!-- Register Link -->
                        <?php if (!empty($Settings->allow_reg)): ?>
                            <p class="text-center mb-5">
                                <span><?php echo lang('dont_have_account') ?: "Don't have an account?"; ?></span>
                                <a href="<?php echo site_url('admin/auth/register'); ?>">
                                    <span><?php echo lang('click_here') ?: 'Create an account'; ?></span>
                                </a>
                            </p>
                        <?php endif; ?>

                    </div>
                </div>
                <!-- /Login Card -->

                <img alt="mask"
                    src="<?php echo base_url('themes/materialize/admin/assets/img/illustrations/auth-basic-login-mask-light.png'); ?>"
                    class="authentication-image d-none d-lg-block"
                    data-app-light-img="img/illustrations/auth-basic-login-mask-light.png"
                    data-app-dark-img="img/illustrations/auth-basic-login-mask-dark.png" />

            </div>
        </div>
    </div>
    <!-- /Content -->

    <!-- Core JS -->
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/popper/popper.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/bootstrap.js'); ?>"></script>
    <script
        src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
    <script
        src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/hammer/hammer.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/i18n/i18n.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/menu.js'); ?>"></script>

    <!-- Vendors JS -->
    <script
        src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/popular.js'); ?>"></script>
    <script
        src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/bootstrap5.js'); ?>"></script>
    <script
        src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/@form-validation/auto-focus.js'); ?>"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url('themes/materialize/admin/assets/js/main.js'); ?>"></script>
    <script src="<?php echo base_url('themes/materialize/admin/assets/js/pages-auth.js'); ?>"></script>

    <script>
        (function () {
            // Clear localStorage on login page load
            localStorage.clear();

            // Loading state on submit
            var form = document.getElementById('formAuthentication');
            var loginBtn = document.getElementById('loginBtn');
            if (form && loginBtn) {
                form.addEventListener('submit', function () {
                    loginBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span><?php echo addslashes(lang("loading") ?: "Loading..."); ?>';
                    loginBtn.disabled = true;
                });
            }

            // Captcha reload
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