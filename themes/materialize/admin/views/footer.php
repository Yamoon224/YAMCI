<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
        </div><!-- /container-xxl -->
      </div><!-- /content-wrapper -->

      <!-- Footer -->
      <footer class="content-footer footer bg-footer-theme">
        <div class="container-xxl">
          <div class="footer-container d-flex align-items-center justify-content-between py-3 flex-md-row flex-column">
            <div class="mb-2 mb-md-0">
              &copy; <?php echo date('Y'); ?> <strong><?php echo $Settings->site_name; ?></strong>
              <?php if ($_SERVER['REMOTE_ADDR'] === '127.0.0.1'): ?>
                &mdash; rendu en <strong>{elapsed_time}</strong>s, m&eacute;moire : {memory_usage}
              <?php endif; ?>
            </div>
            <div>
              <a href="<?php echo site_url('admin/welcome'); ?>" class="footer-link me-4">Dashboard</a>
              <a href="<?php echo site_url('admin/auth/profile'); ?>" class="footer-link">Profile</a>
            </div>
          </div>
        </div>
      </footer>
      <!-- /Footer -->

      <div class="content-backdrop fade"></div>
    </div><!-- /content-wrapper -->
  </div><!-- /layout-page -->
</div><!-- /layout-container -->

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle" aria-hidden="true"></div>

<!-- Drag Target (slide-in menu on small screens) -->
<div class="drag-target"></div>

</div><!-- /layout-wrapper -->

<!-- ===================================================
     MODALS PARTAGÉES
     =================================================== -->

<!-- Modal générique #1 -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModalLabel"><?php echo lang('details') ?: 'Details'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close') ?: 'Close'; ?>"></button>
      </div>
      <div class="modal-body" id="myModalContent">
        <!-- Dynamic content loaded via AJAX -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Close'; ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Modal générique #2 -->
<div class="modal fade" id="myModal2" tabindex="-1" aria-labelledby="myModal2Label" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="myModal2Label"><?php echo lang('details') ?: 'Details'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close') ?: 'Close'; ?>"></button>
      </div>
      <div class="modal-body" id="myModal2Content">
        <!-- Dynamic content loaded via AJAX -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Close'; ?></button>
      </div>
    </div>
  </div>
</div>

<!-- Spinner AJAX global (rétrocompatibilité avec les vues SMA) -->
<div id="modal-loading" style="display:none;">
  <div class="blackbg"></div>
  <div class="loader"></div>
</div>
<div id="ajaxCall" style="display:none;"><span class="spinner-border spinner-border-sm" role="status"></span></div>

<!-- ===================================================
     CORE JS — Materialize
     =================================================== -->
<!-- jQuery chargé dans header.php pour la compatibilité avec les scripts inline des vues -->
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/popper/popper.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/bootstrap.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/js/menu.js'); ?>"></script>
<!-- Menu & layout init (replaces template's main.js for SMA) -->
<script src="<?php echo base_url('themes/materialize/admin/assets/js/menu-init.js'); ?>"></script>

<!-- ===================================================
     VENDOR LIBS JS
     =================================================== -->
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/select2/select2.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/flatpickr/flatpickr.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/sweetalert2/sweetalert2.js'); ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/vendor/libs/apex-charts/apexcharts.js'); ?>"></script>

<!-- ===================================================
     SMA JS
     =================================================== -->
<!-- Shim DataTables 1.9→1.10+: doit être chargé AVANT custom.js -->
<?php $smav = '?v=20260528j'; ?>
<script src="<?php echo base_url('themes/materialize/admin/assets/sma-js/dt-compat.js') . $smav; ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/sma-js/core.js') . $smav; ?>"></script>
<script src="<?php echo base_url('themes/materialize/admin/assets/sma-js/custom.js'); ?>"></script>
<!-- Post-compat: override les defaults BS3 fixés par custom.js -->
<script src="<?php echo base_url('themes/materialize/admin/assets/sma-js/dt-postcompat.js') . $smav; ?>"></script>

<!-- ===================================================
     VARIABLES JS GLOBALES SMA
     =================================================== -->
<?php
/*
 * Nettoyage des données sensibles avant exposition côté client
 * (reproduit le comportement du footer AdminLTE original)
 */
if (isset($Settings)) {
    unset(
        $Settings->setting_id,
        $Settings->smtp_user,
        $Settings->smtp_pass,
        $Settings->smtp_port,
        $Settings->update,
        $Settings->reg_ver,
        $Settings->allow_reg,
        $Settings->default_email,
        $Settings->mmode,
        $Settings->timezone,
        $Settings->restrict_calendar,
        $Settings->restrict_user,
        $Settings->auto_reg,
        $Settings->reg_notification,
        $Settings->protocol,
        $Settings->mailpath,
        $Settings->smtp_crypto,
        $Settings->corn,
        $Settings->customer_group,
        $Settings->envato_username,
        $Settings->purchase_code
    );
}
?>
<script>
  /* URLs de base */
  var site  = <?php echo json_encode([
      'url'        => base_url(),
      'base_url'   => admin_url(),
      'assets'     => isset($assets) ? $assets : base_url('themes/materialize/admin/assets/'),
      'settings'   => isset($Settings) ? $Settings : (object)[],
      'dateFormats' => isset($dateFormats) ? $dateFormats : [],
  ]); ?>;

  /* Raccourcis globaux (rétrocompatibilité) */
  var admin = <?php echo json_encode(rtrim(site_url('admin'), '/') . '/'); ?>;

  /* Jeton CSRF */
  var csrf_token_name  = "<?php echo $this->security->get_csrf_token_name(); ?>";
  var csrf_token_value = "<?php echo $this->security->get_csrf_hash(); ?>";

  /* Paramètres monétaires */
  <?php if (!empty($Settings->currency_symbol)): ?>
  var currency = "<?php echo addslashes($Settings->currency_symbol); ?>";
  <?php endif; ?>
  <?php if (!empty($Settings->number_format)): ?>
  var number_format      = "<?php echo addslashes($Settings->number_format); ?>";
  var decimal_separator  = "<?php echo addslashes($Settings->decimal_separator  ?? '.'); ?>";
  var thousand_separator = "<?php echo addslashes($Settings->thousand_separator ?? ','); ?>";
  <?php endif; ?>

  /* Langue DataTables / DateTimePicker */
  var dt_lang = <?php echo isset($dt_lang) ? $dt_lang : '{}'; ?>;
  var dp_lang = <?php echo isset($dp_lang) ? $dp_lang : '{}'; ?>;

  /* Traductions utilisées par les scripts SMA */
  var lang = {
    paid:             "<?php echo addslashes(lang('paid'));             ?>",
    pending:          "<?php echo addslashes(lang('pending'));          ?>",
    completed:        "<?php echo addslashes(lang('completed'));        ?>",
    ordered:          "<?php echo addslashes(lang('ordered'));          ?>",
    received:         "<?php echo addslashes(lang('received'));         ?>",
    partial:          "<?php echo addslashes(lang('partial'));          ?>",
    sent:             "<?php echo addslashes(lang('sent'));             ?>",
    r_u_sure:         "<?php echo addslashes(lang('r_u_sure'));         ?>",
    due:              "<?php echo addslashes(lang('due'));              ?>",
    returned:         "<?php echo addslashes(lang('returned'));         ?>",
    transferring:     "<?php echo addslashes(lang('transferring'));     ?>",
    active:           "<?php echo addslashes(lang('active'));           ?>",
    inactive:         "<?php echo addslashes(lang('inactive'));         ?>",
    unexpected_value: "<?php echo addslashes(lang('unexpected_value')); ?>",
    select_above:     "<?php echo addslashes(lang('select_above'));     ?>",
    download:         "<?php echo addslashes(lang('download'));         ?>",
    required_invalid: "<?php echo addslashes(lang('required_invalid')); ?>"
  };

  /* Alias de rétrocompatibilité */
  var r_u_sure = lang.r_u_sure;
  var oTable   = '';

  /* DataTables : langue par défaut */
  $(function () {
    if (typeof $.fn.dataTable !== 'undefined') {
      $.extend(true, $.fn.dataTable.defaults, { oLanguage: dt_lang });
    }

    /* Mise en surbrillance du menu actif */
    <?php if (isset($m)): ?>
    $('.mm_<?php echo $m; ?>').addClass('active');
    $('#<?php echo $m; ?>_<?php echo isset($v) ? $v : ''; ?>').addClass('active');
    <?php endif; ?>
  });
</script>

<?php
/* =====================================================
 * Select2 : fichier de langue dynamique
 * (reproduit la logique du footer AdminLTE original)
 * ===================================================== */
$s2_lang_file = @read_file('./assets/config_dumps/s2_lang.js');
if ($s2_lang_file) {
    $s2_data = [];
    foreach (lang('select2_lang') as $s2_key => $s2_line) {
        $s2_data[$s2_key] = str_replace(['{', '}'], ['"+', '+"'], $s2_line);
    }
    $s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
    echo '<script>' . $s2_file_date . '</script>' . "\n";
}
?>

<!-- ===================================================
     SCRIPTS CONDITIONNELS PAR MODULE
     =================================================== -->
<?php
/*
 * L'original utilise les variables $m (module) et $v (vue).
 * On conserve ce mécanisme ET on ajoute un fallback sur le segment URI
 * pour les cas où $m/$v ne sont pas encore injectés.
 */
$_m = isset($m) ? $m : $this->uri->segment(2);
$_v = isset($v) ? $v : $this->uri->segment(3);
$_sma_js = base_url('themes/materialize/admin/assets/sma-js/');
?>

<?php if ($_m === 'purchases' && in_array($_v, ['add', 'edit', 'purchase_by_csv'])): ?>
<script src="<?php echo $_sma_js; ?>purchases.js"></script>
<?php endif; ?>

<?php if ($_m === 'transfers' && in_array($_v, ['add', 'edit'])): ?>
<script src="<?php echo $_sma_js; ?>transfers.js"></script>
<?php endif; ?>

<?php if ($_m === 'sales' && in_array($_v, ['add', 'edit'])): ?>
<script src="<?php echo $_sma_js; ?>sales.js"></script>
<?php endif; ?>

<?php if ($_m === 'returns' && in_array($_v, ['add', 'edit'])): ?>
<script src="<?php echo $_sma_js; ?>returns.js"></script>
<?php endif; ?>

<?php if ($_m === 'quotes' && in_array($_v, ['add', 'edit'])): ?>
<script src="<?php echo $_sma_js; ?>quotes.js"></script>
<?php endif; ?>

<?php if ($_m === 'products' && in_array($_v, ['add_adjustment', 'edit_adjustment'])): ?>
<script src="<?php echo $_sma_js; ?>adjustments.js"></script>
<?php endif; ?>

<?php if ($_m === 'products' && $_v === 'barcodes'): ?>
<script src="<?php echo $_sma_js; ?>barcode.js"></script>
<?php endif; ?>

<?php if ($_m === 'pos'): ?>
<script src="<?php echo $_sma_js; ?>pos.js"></script>
<?php endif; ?>

<?php if (defined('DEMO') && DEMO): ?>
<script src="<?php echo isset($assets) ? $assets : base_url('themes/materialize/admin/assets/'); ?>js/ppp_ad.min.js"></script>
<?php endif; ?>

<!-- Surcharges custom globales (équivalent assets/custom/custom.js de l'original) -->
<script src="<?php echo base_url('assets/custom/custom.js'); ?>"></script>

<!-- Script JS injecté depuis les vues (via $meta['js']) -->
<?php if (!empty($meta['js'])): ?>
<?php echo $meta['js']; ?>
<?php endif; ?>

</body>
</html>
