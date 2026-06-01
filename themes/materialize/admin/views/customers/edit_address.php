<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-map-pin-2-line me-2"></span>
        <?php echo lang('edit_address') ?: 'Modifier l\'adresse'; ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php echo lang('close') ?: 'Fermer'; ?>"></button>
    </div>

    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'editAddressForm'];
    echo admin_form_open('customers/edit_address/' . $address->id, $attrib);
    ?>

    <div class="modal-body">
      <div class="row g-3">

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php
            $type_opts = [
              ''         => lang('select') . ' ' . (lang('type') ?: 'Type'),
              'billing'  => lang('billing')  ?: 'Facturation',
              'shipping' => lang('shipping') ?: 'Livraison',
            ];
            echo form_dropdown('type', $type_opts, set_value('type', $address->type ?? ''),
              'class="form-select select2" id="addr_type" data-placeholder="' . (lang('select') . ' ' . (lang('type') ?: 'Type')) . '" required="required"');
            ?>
            <label for="addr_type"><?php echo lang('type') ?: 'Type'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('line1', set_value('line1', $address->line1 ?? ''),
              'class="form-control" id="addr_line1" placeholder="Adresse ligne 1" required="required"'); ?>
            <label for="addr_line1"><?php echo lang('line1') ?: 'Adresse ligne 1'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('line2', set_value('line2', $address->line2 ?? ''),
              'class="form-control" id="addr_line2" placeholder="Adresse ligne 2"'); ?>
            <label for="addr_line2"><?php echo lang('line2') ?: 'Adresse ligne 2'; ?></label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('city', set_value('city', $address->city ?? ''),
              'class="form-control" id="addr_city" placeholder="Ville" required="required"'); ?>
            <label for="addr_city"><?php echo lang('city') ?: 'Ville'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('state', set_value('state', $address->state ?? ''),
              'class="form-control" id="addr_state" placeholder="État / Région"'); ?>
            <label for="addr_state"><?php echo lang('state') ?: 'État / Région'; ?></label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('postal_code', set_value('postal_code', $address->postal_code ?? ''),
              'class="form-control" id="addr_zip" placeholder="Code postal"'); ?>
            <label for="addr_zip"><?php echo lang('postal_code') ?: 'Code postal'; ?></label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('country', set_value('country', $address->country ?? ''),
              'class="form-control" id="addr_country" placeholder="Pays"'); ?>
            <label for="addr_country"><?php echo lang('country') ?: 'Pays'; ?></label>
          </div>
        </div>

      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </button>
      <?php echo form_submit('edit_address', lang('edit_address') ?: 'Enregistrer', 'class="btn btn-primary"'); ?>
    </div>

    <?php echo form_close(); ?>
  </div>
</div>

<?php echo $modal_js; ?>

<script>
$(document).ready(function () {
  $('select.select2').select2({ minimumResultsForSearch: 7, dropdownParent: $('#myModal') });
});
</script>
