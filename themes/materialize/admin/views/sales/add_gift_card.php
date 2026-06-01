<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-gift-line me-2 text-primary icon-18px"></span>
        <?php echo lang('add_gift_card') ?: 'Ajouter une carte cadeau'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
    </div>
    <?php echo admin_form_open('sales/add_gift_card'); ?>
    <div class="modal-body">
      <div class="row g-3">
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <div class="input-group">
              <input type="text" class="form-control" id="gc_card_no" name="card_no"
                     placeholder="XXXX-XXXX" required />
              <button class="btn btn-outline-secondary" type="button" id="genNo"
                      title="<?php echo lang('generate') ?: 'Générer'; ?>">
                <span class="icon-base ri ri-refresh-line icon-16px"></span>
              </button>
            </div>
            <label for="gc_card_no" style="position:static;padding:0;margin-bottom:4px;" class="form-label">
              <?php echo lang('card_no') ?: 'N° de carte'; ?> <span class="text-danger">*</span>
            </label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="number" class="form-control" id="gc_value" name="value"
                   placeholder="Valeur" step="0.01" min="0.01" required />
            <label for="gc_value"><?php echo lang('value') ?: 'Valeur'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $c_opts = ['' => lang('select') . ' ' . (lang('customer') ?: 'Client')];
            if (isset($customers)) foreach ($customers as $c) $c_opts[$c->id] = $c->name;
            echo form_dropdown('customer_id', $c_opts, '', 'class="form-select select2" id="gcCustomer"');
            ?>
            <label for="gcCustomer"><?php echo lang('customer') ?: 'Client'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <input type="text" class="form-control flatpickr-datetime" id="gc_expiry" name="expiry"
                   placeholder="Expiration"
                   value="<?php echo $this->sma->hrsd(date('Y-m-d', strtotime('+2 year'))); ?>" />
            <label for="gc_expiry"><?php echo lang('expiry_date') ?: 'Date d\'expiration'; ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="staff_points" id="staff_points" />
            <label class="form-check-label" for="staff_points">
              <?php echo lang('use_staff_award_points') ?: 'Utiliser les points du personnel'; ?>
            </label>
          </div>
        </div>
        <div id="staff-con" class="col-12" style="display:none;">
          <div class="form-floating form-floating-outline">
            <?php
            $u_opts = ['' => lang('select') . ' ' . (lang('user') ?: 'Utilisateur')];
            if (isset($users)) foreach ($users as $u) $u_opts[$u->id] = $u->first_name . ' ' . $u->last_name;
            echo form_dropdown('user', $u_opts, '', 'class="form-select select2" id="gcUser"');
            ?>
            <label for="gcUser"><?php echo lang('user') ?: 'Utilisateur'; ?></label>
          </div>
          <div id="sa-points-con" class="mt-3 bg-light rounded p-3" style="display:none;">
            <p class="small"><?php echo lang('award_points') ?: 'Points disponibles'; ?>: <strong id="staff_award_points"></strong></p>
            <div class="form-floating form-floating-outline">
              <input type="number" class="form-control" id="sa_points" name="sa_points" placeholder="Points" min="0" />
              <label for="sa_points"><?php echo lang('use_points') ?: 'Points à utiliser'; ?></label>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Annuler'; ?></button>
      <?php echo form_submit('add_gift_card', lang('save') ?: 'Enregistrer', 'class="btn btn-primary"'); ?>
    </div>
    <?php echo form_close(); ?>
  </div>
</div>
<script>
(function () {
  'use strict';
  // Toggle staff points section
  document.getElementById('staff_points').addEventListener('change', function () {
    document.getElementById('staff-con').style.display = this.checked ? 'block' : 'none';
  });

  // Generate random card number
  document.getElementById('genNo').addEventListener('click', function (e) {
    e.preventDefault();
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var no = '';
    for (var i = 0; i < 16; i++) {
      if (i > 0 && i % 4 === 0) no += '-';
      no += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('gc_card_no').value = no;
  });

  // Load staff award points via AJAX when user is selected
  document.getElementById('gcUser').addEventListener('change', function () {
    var uid = this.value;
    if (!uid) { document.getElementById('sa-points-con').style.display = 'none'; return; }
    fetch('<?php echo admin_url('sales/get_staff_points'); ?>/' + uid)
      .then(function(r){ return r.json(); })
      .then(function(data) {
        document.getElementById('staff_award_points').textContent = data.points || 0;
        document.getElementById('sa-points-con').style.display = 'block';
      });
  });
})();
</script>
<?php echo $modal_js; ?>
