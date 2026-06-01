<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1"><i class="ri ri-upload-cloud-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Importer les achats par CSV</h4>
      <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer plusieurs achats en masse</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo admin_url('purchases'); ?>"><?php echo lang('purchases') ?: 'Achats'; ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('import_csv') ?: 'Import CSV'; ?></li>
        </ol>
      </nav>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <a href="<?php echo admin_url('purchases'); ?>" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?php echo lang('back') ?: 'Retour'; ?>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-upload-cloud-line me-2 text-primary"></span>
        <?php echo lang('add_purchase_by_csv') ?: 'Import achats CSV'; ?>
      </h5>
    </div>
    <div class="card-body">
      <?php echo admin_form_open_multipart('purchases/purchase_by_csv'); ?>
      <div class="row g-3">

        <?php if ($Owner || $Admin): ?>
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', isset($_POST['date']) ? $_POST['date'] : '', 'id="podate_csv" class="form-control flatpickr-input" placeholder="' . lang('date') . '" required="required"'); ?>
            <label for="podate_csv"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : $ponumber, 'id="poref_csv" class="form-control" placeholder="' . lang('reference_no') . '"'); ?>
            <label for="poref_csv"><?php echo lang('reference_no') ?: 'Réf'; ?></label>
          </div>
        </div>

        <div class="col-md-4">
          <?php
          $wh = ['' => ''];
          foreach ($warehouses as $warehouse) {
            $wh[$warehouse->id] = $warehouse->name;
          }
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('warehouse', $wh, isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse, 'id="powarehouse_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" style="width:100%;"'); ?>
            <label for="powarehouse_csv"><?php echo lang('warehouse') ?: 'Entrepôt'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <?php
          $post_status = [
            'received' => lang('received'),
            'pending'  => lang('pending'),
            'ordered'  => lang('ordered'),
          ];
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('status', $post_status, isset($_POST['status']) ? $_POST['status'] : '', 'id="postatus_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('status') . '" required="required" style="width:100%;"'); ?>
            <label for="postatus_csv"><?php echo lang('status') ?: 'Statut'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <label class="form-label" for="posupplier_csv"><?php echo lang('supplier') ?: 'Fournisseur'; ?> <span class="text-danger">*</span></label>
          <input type="text" name="supplier" value="" id="posupplier_csv" required="required"
                 class="form-control suppliers select2"
                 placeholder="<?php echo lang('select') . ' ' . lang('supplier'); ?>"
                 style="width:100%;" />
          <input type="hidden" name="supplier_id" value="" id="supplier_id_csv" class="form-control" />
        </div>

        <div class="col-12">
          <div class="alert alert-info d-flex align-items-start">
            <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
            <div>
              <?php echo lang('csv1') ?: ''; ?><br>
              <?php echo lang('csv2') ?: 'Colonnes'; ?>:
              <strong>(<?php echo lang('product_code') . ', ' . lang('net_unit_cost') . ', ' . lang('quantity') . ', ' . lang('product_variant') . ', ' . lang('tax_rate_name') . ', ' . lang('discount') . ', ' . lang('expiry'); ?>)</strong>
              <?php echo lang('csv3') ?: ''; ?><br>
              <strong><?php echo sprintf(lang('x_col_required'), 3); ?></strong>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>assets/csv/sample_purchase_products.csv" class="btn btn-outline-primary btn-sm mb-3">
            <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Télécharger exemple'; ?>
          </a>
          <div class="mb-3">
            <label class="form-label" for="csv_file_po"><?php echo lang('csv_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="csv_file_po" name="userfile" accept=".csv" required />
          </div>
          <div>
            <label class="form-label" for="document_po"><?php echo lang('attachments') ?: 'Pièces jointes'; ?></label>
            <input type="file" class="form-control" id="document_po" name="attachments[]" multiple />
          </div>
        </div>

        <div class="col-12">
          <div class="form-check mb-2">
            <input type="checkbox" class="form-check-input" id="extras_po" value="" />
            <label class="form-check-label" for="extras_po"><?php echo lang('more_options') ?: 'Plus d\'options'; ?></label>
          </div>
          <div id="extras_po_con" style="display:none;">
            <div class="row g-3">
              <?php if ($Settings->tax1): ?>
              <div class="col-md-4">
                <?php
                $tr = ['' => ''];
                foreach ($tax_rates as $tax) {
                  $tr[$tax->id] = $tax->name;
                }
                ?>
                <div class="form-floating form-floating-outline">
                  <?php echo form_dropdown('order_tax', $tr, '', 'id="potax2_csv" class="form-select select2" style="width:100%;"'); ?>
                  <label for="potax2_csv"><?php echo lang('order_tax') ?: 'Taxe commande'; ?></label>
                </div>
              </div>
              <?php endif; ?>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <?php echo form_input('discount', '', 'id="podiscount_csv" class="form-control" placeholder="' . lang('discount_label') . '"'); ?>
                  <label for="podiscount_csv"><?php echo lang('discount_label') ?: 'Remise'; ?></label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-floating form-floating-outline">
                  <?php echo form_input('shipping', '', 'id="poshipping_csv" class="form-control" placeholder="' . lang('shipping') . '"'); ?>
                  <label for="poshipping_csv"><?php echo lang('shipping') ?: 'Livraison'; ?></label>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', isset($_POST['note']) ? $_POST['note'] : '', 'id="ponote_csv" class="form-control" placeholder="' . lang('note') . '" style="height:100px;"'); ?>
            <label for="ponote_csv"><?php echo lang('note') ?: 'Note'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <?php echo form_submit('add_pruchase', lang('submit') ?: 'Importer', 'class="btn btn-primary"'); ?>
          <button type="reset" class="btn btn-outline-secondary ms-2"><?php echo lang('reset') ?: 'Réinitialiser'; ?></button>
        </div>
      </div>
      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
  if (typeof flatpickr !== 'undefined') {
    flatpickr('#podate_csv', { dateFormat: 'd-m-Y', defaultDate: 'today', allowInput: true });
  }
  document.getElementById('extras_po').addEventListener('change', function() {
    var con = document.getElementById('extras_po_con');
    con.style.display = this.checked ? '' : 'none';
  });
});
</script>
