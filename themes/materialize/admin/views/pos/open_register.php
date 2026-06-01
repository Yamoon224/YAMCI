<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-store-2-line me-2 icon-20px"></span><?= lang('open_register'); ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
    </div>
    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
    echo admin_form_open('pos/open_register/' . $register->id, $attrib);
    ?>
    <div class="modal-body">
      <div id="alerts"></div>
      <p class="text-muted mb-3">
        <span class="icon-base ri ri-information-line me-1 icon-16px"></span>
        <?= lang('register_total_tip'); ?>
      </p>

      <div class="row g-3">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?= form_input('opening_balance', (isset($_POST['opening_balance']) ? $_POST['opening_balance'] : '0'), 'class="form-control" id="opening_balance" type="number" step="0.01" min="0" required placeholder=" "'); ?>
            <label for="opening_balance">
              <span class="icon-base ri ri-money-dollar-circle-line me-1 icon-16px"></span>
              <?= lang('cash_in_hand'); ?>
            </label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control" id="note" style="height:90px;" placeholder=" "'); ?>
            <label for="note">
              <span class="icon-base ri ri-file-text-line me-1 icon-16px"></span>
              <?= lang('note'); ?>
            </label>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <span class="icon-base ri ri-close-line me-1 icon-16px"></span><?= lang('cancel'); ?>
      </button>
      <?= form_submit('open_register', lang('open_register'), 'class="btn btn-primary" id="open_register"'); ?>
    </div>
    <?= form_close(); ?>
  </div>
</div>
<?= $modal_js ?>
<script>
$(document).ready(function () {
  $('#opening_balance').on('change blur', function () {
    var v = $(this).val();
    if (v !== '' && isNaN(parseFloat(v))) {
      $(this).val('0');
      if (typeof Swal !== 'undefined') {
        Swal.fire({ icon: 'warning', title: '<?= lang('unexpected_value'); ?>', timer: 2000, showConfirmButton: false });
      }
    }
  });
});
</script>
