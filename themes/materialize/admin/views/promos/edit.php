<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'edit-promo-form'];
echo admin_form_open('promos/edit/' . $promo->id, $attrib);
?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-edit-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('edit_promo') ?: 'Modifier la promotion'; ?></h4>
    <p class="mb-0 text-muted"><?php echo htmlspecialchars($promo->name); ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('promos'); ?>"><?php echo lang('promos') ?: 'Promotions'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo htmlspecialchars($promo->name); ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('promos'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i><?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <button type="button" class="btn btn-primary" onclick="$('#edit-promo-form').submit();">
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
          <?php echo form_input('name', set_value('name', $promo->name), 'class="form-control" id="name" required data-bv-notempty="true" placeholder="' . (lang('name') ?: 'Nom de la promotion') . '"'); ?>
        </div>

        <div class="row g-4">
          <div class="col-sm-6">
            <label class="form-label" for="promo_type"><?php echo lang('type') ?: 'Type de remise'; ?> <span class="text-danger">*</span></label>
            <?php
            $types = [
                'percent' => lang('percent') ?: 'Pourcentage (%)',
                'fixed'   => lang('fixed')   ?: 'Montant fixe',
            ];
            $currentType = set_value('promo_type', isset($promo->promo_type) ? $promo->promo_type : 'percent');
            echo form_dropdown('promo_type', $types, $currentType, 'class="form-select select2" id="promo_type" required');
            ?>
          </div>
          <div class="col-sm-6">
            <label class="form-label" for="discount"><?php echo lang('discount') ?: 'Valeur de la remise'; ?> <span class="text-danger">*</span></label>
            <div class="input-group">
              <?php
              $discountVal = set_value('discount', isset($promo->discount) ? $promo->discount : '');
              echo form_input('discount', $discountVal, 'class="form-control" id="discount" type="number" min="0" step="0.01" required placeholder="0.00"');
              ?>
              <span class="input-group-text" id="discount_suffix">
                <?php echo ($currentType === 'fixed') ? ($Settings->currency_symbol ?: 'F') : '%'; ?>
              </span>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <label class="form-label" for="suggest_product"><?php echo lang('product2buy') ?: 'Produit(s) éligible(s)'; ?></label>
          <?php echo form_input('sproduct', isset($_POST['sproduct']) ? $_POST['sproduct'] : (isset($promo->p2b) ? $promo->p2b : ''), 'class="form-control" id="suggest_product" data-bv-notempty="true" placeholder="' . (lang('search_product') ?: 'Rechercher un produit...') . '"'); ?>
          <input type="hidden" name="product2buy" value="<?php echo isset($_POST['product2buy']) ? $_POST['product2buy'] : (isset($promo->product2buy) ? $promo->product2buy : ''); ?>" id="report_product_id" />
          <small class="text-muted"><?php echo lang('type_to_search') ?: 'Commencez à taper pour rechercher un produit'; ?></small>
        </div>

        <div class="mt-4">
          <label class="form-label" for="suggest_product2"><?php echo lang('product2get') ?: 'Produit offert'; ?></label>
          <?php echo form_input('sgproduct', isset($_POST['sgproduct']) ? $_POST['sgproduct'] : (isset($promo->p2g) ? $promo->p2g : ''), 'class="form-control" id="suggest_product2" placeholder="' . (lang('search_product') ?: 'Produit offert (optionnel)') . '"'); ?>
          <input type="hidden" name="product2get" value="<?php echo isset($_POST['product2get']) ? $_POST['product2get'] : (isset($promo->product2get) ? $promo->product2get : ''); ?>" id="report_product_id2" />
        </div>

        <div class="mt-4">
          <label class="form-label" for="description"><?php echo lang('description') ?: 'Description'; ?></label>
          <?php echo form_textarea('description', set_value('description', $promo->description), 'class="form-control" id="description" rows="4" placeholder="' . (lang('description') ?: 'Description de la promotion') . '"'); ?>
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
          <?php echo form_input('start_date', set_value('start_date', $promo->start_date ? $this->sma->hrsd($promo->start_date) : ''), 'class="form-control flatpickr-date" id="start_date" required placeholder="yyyy-mm-dd"'); ?>
        </div>

        <div class="mb-4">
          <label class="form-label" for="end_date"><?php echo lang('end_date') ?: 'Date de fin'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('end_date', set_value('end_date', $promo->end_date ? $this->sma->hrsd($promo->end_date) : ''), 'class="form-control flatpickr-date" id="end_date" required placeholder="yyyy-mm-dd"'); ?>
        </div>

        <div class="mb-4">
          <label class="form-label" for="status"><?php echo lang('status') ?: 'Statut'; ?></label>
          <?php
          $statuses = [
              '1' => lang('active')   ?: 'Actif',
              '0' => lang('inactive') ?: 'Inactif',
          ];
          $currentStatus = set_value('status', isset($promo->status) ? $promo->status : '1');
          echo form_dropdown('status', $statuses, $currentStatus, 'class="form-select" id="status"');
          ?>
        </div>

        <!-- Status Badge Preview -->
        <div class="mb-4">
          <?php if (isset($promo->status) && $promo->status == 1): ?>
            <span class="badge bg-label-success"><span class="icon-base ri ri-checkbox-circle-line me-1 icon-16px"></span><?php echo lang('active') ?: 'Actif'; ?></span>
          <?php else: ?>
            <span class="badge bg-label-secondary"><span class="icon-base ri ri-close-circle-line me-1 icon-16px"></span><?php echo lang('inactive') ?: 'Inactif'; ?></span>
          <?php endif; ?>
        </div>

        <div class="d-grid gap-2">
          <?php echo form_submit('edit_promo', lang('edit_promo') ?: 'Mettre à jour', 'class="btn btn-primary"'); ?>
          <a href="<?php echo admin_url('promos'); ?>" class="btn btn-outline-secondary">
            <?php echo lang('cancel') ?: 'Annuler'; ?>
          </a>
        </div>

      </div>
    </div>

    <!-- Promo meta info -->
    <div class="card mt-4">
      <div class="card-body">
        <h6 class="card-title mb-3">
          <span class="icon-base ri ri-shield-check-line me-1 text-muted icon-16px"></span>
          <?php echo lang('promo_info') ?: 'Informations'; ?>
        </h6>
        <dl class="row mb-0 small">
          <dt class="col-5 text-muted"><?php echo lang('id') ?: 'ID'; ?></dt>
          <dd class="col-7">#<?php echo (int)$promo->id; ?></dd>
          <?php if (isset($promo->created_at) && $promo->created_at): ?>
          <dt class="col-5 text-muted"><?php echo lang('created_at') ?: 'Créé le'; ?></dt>
          <dd class="col-7"><?php echo $this->sma->hrsd($promo->created_at); ?></dd>
          <?php endif; ?>
        </dl>
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
    suffix.textContent = this.value === 'percent' ? '%' : '<?php echo addslashes($Settings->currency_symbol ?: 'F'); ?>';
  });
})();
</script>
