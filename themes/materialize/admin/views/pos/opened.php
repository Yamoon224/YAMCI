<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-pause-circle-line me-2 text-primary icon-18px"></span>
        <?php echo lang('suspended_sales') ?: 'Ventes suspendues'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <div class="modal-body">
      <?php if ($r): ?>
        <p class="text-muted small mb-3"><?php echo lang('click_to_add') ?: 'Cliquez sur une vente pour la reprendre.'; ?></p>
      <?php endif; ?>
      <div class="html_con">
        <?php echo $html; ?>
      </div>
    </div>
    <?php if ($page): ?>
    <div class="modal-footer border-top-0 justify-content-center">
      <div class="page_con"><?php echo $page; ?></div>
    </div>
    <?php endif; ?>
  </div>
</div>
<script>
(function () {
  'use strict';
  document.querySelectorAll('.sus_sale').forEach(function (el) {
    el.addEventListener('click', function (e) {
      e.preventDefault();
      var sid = this.id;
      if (typeof count !== 'undefined' && count > 1) {
        Swal.fire({
          title: '<?php echo addslashes(lang('leave_alert') ?: 'Quitter cette vente ?'); ?>',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: '<?php echo addslashes(lang('yes') ?: 'Oui'); ?>',
          cancelButtonText: '<?php echo addslashes(lang('no') ?: 'Non'); ?>'
        }).then(function (r) {
          if (r.isConfirmed) {
            window.location.href = '<?php echo admin_url('pos/index'); ?>/' + sid;
          }
        });
      } else {
        window.location.href = '<?php echo admin_url('pos/index'); ?>/' + sid;
      }
    });
  });
})();
</script>
