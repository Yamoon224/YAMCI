<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-promo-form'];
echo admin_form_open('promos/add', $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-add-circle-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('add_promo') ?: 'Nouvelle promotion'; ?></h4>
    <p class="mb-0 text-muted">Créez un code promo ou une offre spéciale</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('promos'); ?>"><?php echo lang('promos') ?: 'Promotions'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('add_promo') ?: 'Nouvelle'; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('promos'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#add-promo-form').submit();">
      <i class="ri ri-save-line me-1" style="font-size:16px"></i><?php echo lang('save') ?: 'Enregistrer'; ?>
    </button>
  </div>
</div>

<div class="row g-4">

  <!-- Main form card -->
  <div class="col-lg-8">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-information-line me-2 text-primary icon-18px"></span>
          <?php echo lang('enter_info') ?: 'Informations de la promotion'; ?>
        </h5>
      </div>
      <div class="card-body">

        <div class="mb-4">
          <label class="form-label" for="name"><?php echo lang('name') ?: 'Nom'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('name', '', 'class="form-control" id="name" required data-bv-notempty="true" placeholder="' . (lang('name') ?: 'Nom de la promotion') . '"'); ?>
        </div>

        <div class="row g-4">
          <div class="col-sm-6">
            <label class="form-label" for="promo_type"><?php echo lang('type') ?: 'Type de remise'; ?> <span class="text-danger">*</span></label>
            <?php
            $types = [
                'percent' => lang('percent') ?: 'Pourcentage (%)',
                'fixed'   => lang('fixed')   ?: 'Montant fixe',
            ];
            echo form_dropdown('promo_type', $types, 'percent', 'class="form-select select2" id="promo_type" required');
            ?>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="discount"><?php echo lang('discount') ?: 'Valeur de la remise'; ?> <span class="text-danger">*</span></label>
            <div class="input-group">
              <?php echo form_input('discount', '', 'class="form-control" id="discount" type="number" min="0" step="0.01" required placeholder="0.00"'); ?>
              <span class="input-group-text" id="discount_suffix">%</span>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <label class="form-label" for="suggest_product"><?php echo lang('product2buy') ?: 'Produit(s) éligible(s)'; ?></label>
          <?php echo form_input('sproduct', isset($_POST['sproduct']) ? $_POST['sproduct'] : '', 'class="form-control" id="suggest_product" data-bv-notempty="true" placeholder="' . (lang('search_product') ?: 'Rechercher un produit...') . '"'); ?>
          <input type="hidden" name="product2buy" value="<?php echo isset($_POST['product2buy']) ? $_POST['product2buy'] : ''; ?>" id="report_product_id" />
          <small class="text-muted"><?php echo lang('type_to_search') ?: 'Commencez à taper pour rechercher un produit'; ?></small>
        </div>

        <div class="mt-4">
          <label class="form-label" for="suggest_product2"><?php echo lang('product2get') ?: 'Produit offert'; ?></label>
          <?php echo form_input('sgproduct', isset($_POST['sgproduct']) ? $_POST['sgproduct'] : '', 'class="form-control" id="suggest_product2" placeholder="' . (lang('search_product') ?: 'Produit offert (optionnel)') . '"'); ?>
          <input type="hidden" name="product2get" value="<?php echo isset($_POST['product2get']) ? $_POST['product2get'] : ''; ?>" id="report_product_id2" />
        </div>

        <div class="mt-4">
          <label class="form-label" for="description"><?php echo lang('description') ?: 'Description'; ?></label>
          <?php echo form_textarea('description', '', 'class="form-control" id="description" rows="4" placeholder="' . (lang('description') ?: 'Description de la promotion') . '"'); ?>
        </div>

      </div>
    </div>
  </div>

  <!-- Sidebar card -->
  <div class="col-lg-4">
    <div class="card">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="icon-base ri ri-calendar-line me-2 text-primary icon-18px"></span>
          <?php echo lang('validity') ?: 'Validité &amp; Statut'; ?>
        </h5>
      </div>
      <div class="card-body">

        <div class="mb-4">
          <label class="form-label" for="start_date"><?php echo lang('start_date') ?: 'Date de début'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('start_date', '', 'class="form-control flatpickr-date" id="start_date" required placeholder="yyyy-mm-dd"'); ?>
        </div>

        <div class="mb-4">
          <label class="form-label" for="end_date"><?php echo lang('end_date') ?: 'Date de fin'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('end_date', '', 'class="form-control flatpickr-date" id="end_date" required placeholder="yyyy-mm-dd"'); ?>
        </div>

        <div class="mb-4">
          <label class="form-label" for="status"><?php echo lang('status') ?: 'Statut'; ?></label>
          <?php
          $statuses = [
              '1' => lang('active')   ?: 'Actif',
              '0' => lang('inactive') ?: 'Inactif',
          ];
          echo form_dropdown('status', $statuses, '1', 'class="form-select" id="status"');
          ?>
        </div>

        <div class="d-grid gap-2">
          <?php echo form_submit('add_promo', lang('add_promo') ?: 'Enregistrer la promotion', 'class="btn btn-primary"'); ?>
          <a href="<?php echo admin_url('promos'); ?>" class="btn btn-outline-secondary">
            <?php echo lang('cancel') ?: 'Annuler'; ?>
          </a>
        </div>

      </div>
    </div>
  </div>

</div>

<?php echo form_close(); ?>

<script>
(function () {
  'use strict';

  // Update discount suffix based on type
  document.getElementById('promo_type').addEventListener('change', function () {
    var suffix = document.getElementById('discount_suffix');
    suffix.textContent = this.value === 'percent' ? '%' : '<?php echo $Settings->currency_symbol ?: "F"; ?>';
  });
})();
</script>
