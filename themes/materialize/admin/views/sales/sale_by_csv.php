<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
  <!-- HEADER style template Pixinvent -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1"><i class="ri ri-upload-cloud-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Importer les ventes par CSV</h4>
      <p class="mb-0 text-muted">Téléversez un fichier CSV pour créer plusieurs ventes en masse</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
          <li class="breadcrumb-item"><a href="<?php echo admin_url('sales'); ?>"><?php echo lang('sales') ?: 'Ventes'; ?></a></li>
          <li class="breadcrumb-item active"><?php echo lang('import_csv') ?: 'Import CSV'; ?></li>
        </ol>
      </nav>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-2">
      <a href="<?php echo admin_url('sales'); ?>" class="btn btn-outline-secondary">
        <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?php echo lang('back') ?: 'Retour'; ?>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h5 class="card-title mb-0">
        <span class="icon-base ri ri-upload-cloud-line me-2 text-primary"></span>
        <?php echo lang('add_sale') ?: 'Import ventes CSV'; ?>
      </h5>
    </div>
    <div class="card-body">
      <?php echo admin_form_open_multipart('sales/sale_by_csv'); ?>
      <div class="row g-3">

        <?php if ($Owner || $Admin): ?>
        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('date', isset($_POST['date']) ? $_POST['date'] : '', 'id="sldate_csv" class="form-control flatpickr-input" placeholder="' . lang('date') . '" required="required"'); ?>
            <label for="sldate_csv"><?php echo lang('date') ?: 'Date'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('reference_no', isset($_POST['reference_no']) ? $_POST['reference_no'] : $slnumber, 'id="slref_csv" class="form-control" placeholder="' . lang('reference_no') . '"'); ?>
            <label for="slref_csv"><?php echo lang('reference_no') ?: 'Réf'; ?></label>
          </div>
        </div>

        <?php if (!$Settings->restrict_user || $Owner || $Admin): ?>
        <div class="col-md-4">
          <?php
          $bl = ['' => ''];
          foreach ($billers as $biller) {
            $bl[$biller->id] = ($biller->company && $biller->company != '-') ? $biller->company : $biller->name;
          }
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('biller', $bl, isset($_POST['biller']) ? $_POST['biller'] : $Settings->default_biller, 'id="slbiller_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('biller') . '" required="required" style="width:100%;"'); ?>
            <label for="slbiller_csv"><?php echo lang('biller') ?: 'Caissier'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="biller" id="slbiller_csv" value="<?php echo $this->session->userdata('biller_id'); ?>" />
        <?php endif; ?>

        <?php if (!$Settings->restrict_user || $Owner || $Admin): ?>
        <div class="col-md-4">
          <?php
          $wh = ['' => ''];
          foreach ($warehouses as $warehouse) {
            $wh[$warehouse->id] = $warehouse->name;
          }
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('warehouse', $wh, isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse, 'id="slwarehouse_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '" required="required" style="width:100%;"'); ?>
            <label for="slwarehouse_csv"><?php echo lang('warehouse') ?: 'Entrepôt'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>
        <?php else: ?>
        <input type="hidden" name="warehouse" id="slwarehouse_csv" value="<?php echo $this->session->userdata('warehouse_id'); ?>" />
        <?php endif; ?>

        <div class="col-md-4">
          <label class="form-label" for="slcustomer_csv"><?php echo lang('customer') ?: 'Client'; ?> <span class="text-danger">*</span></label>
          <input type="text" name="customer" value="<?php echo isset($_POST['customer']) ? htmlspecialchars($_POST['customer']) : ''; ?>"
                 id="slcustomer_csv"
                 class="form-control select2-customers"
                 placeholder="<?php echo lang('select') . ' ' . lang('customer'); ?>"
                 required="required"
                 style="width:100%;" />
        </div>

        <div class="col-md-4">
          <?php
          $sst = [
            'completed' => lang('completed'),
            'pending'   => lang('pending'),
          ];
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('sale_status', $sst, isset($_POST['sale_status']) ? $_POST['sale_status'] : '', 'id="slsale_status_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('sale_status') . '" required="required" style="width:100%;"'); ?>
            <label for="slsale_status_csv"><?php echo lang('sale_status') ?: 'Statut vente'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <div class="col-md-4">
          <?php
          $pst = [
            'pending' => lang('pending'),
            'due'     => lang('due'),
            'paid'    => lang('paid'),
          ];
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('payment_status', $pst, isset($_POST['payment_status']) ? $_POST['payment_status'] : '', 'id="slpayment_status_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('payment_status') . '" required="required" style="width:100%;"'); ?>
            <label for="slpayment_status_csv"><?php echo lang('payment_status') ?: 'Statut paiement'; ?> <span class="text-danger">*</span></label>
          </div>
        </div>

        <?php if ($Settings->tax2): ?>
        <div class="col-md-4">
          <?php
          $tr = ['' => ''];
          foreach ($tax_rates as $tax) {
            $tr[$tax->id] = $tax->name;
          }
          ?>
          <div class="form-floating form-floating-outline">
            <?php echo form_dropdown('order_tax', $tr, isset($_POST['order_tax']) ? $_POST['order_tax'] : $Settings->default_tax_rate2, 'id="sltax2_csv" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('order_tax') . '" style="width:100%;"'); ?>
            <label for="sltax2_csv"><?php echo lang('order_tax') ?: 'Taxe commande'; ?></label>
          </div>
        </div>
        <?php endif; ?>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('order_discount', '', 'id="sldiscount_csv" class="form-control" placeholder="' . lang('order_discount') . '"'); ?>
            <label for="sldiscount_csv"><?php echo lang('order_discount') ?: 'Remise commande'; ?></label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('shipping', '', 'id="slshipping_csv" class="form-control" placeholder="' . lang('shipping') . '"'); ?>
            <label for="slshipping_csv"><?php echo lang('shipping') ?: 'Livraison'; ?></label>
          </div>
        </div>

        <div class="col-md-4">
          <div class="form-floating form-floating-outline">
            <?php echo form_input('payment_term', '', 'id="slpayment_term_csv" class="form-control" placeholder="' . lang('payment_term') . '" title="' . lang('payment_term_tip') . '"'); ?>
            <label for="slpayment_term_csv"><?php echo lang('payment_term') ?: 'Délai paiement'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <div class="alert alert-info d-flex align-items-start">
            <span class="icon-base ri ri-information-line me-2 mt-1 flex-shrink-0"></span>
            <div>
              <?php echo lang('csv1') ?: ''; ?><br>
              <?php echo lang('csv2') ?: 'Colonnes'; ?>:
              <strong>(<?php echo lang('product_code') . ', ' . lang('net_unit_price') . ', ' . lang('quantity') . ', ' . lang('product_variant') . ', ' . lang('tax_rate_name') . ', ' . lang('discount') . ', ' . lang('serial_no'); ?>)</strong>
              <?php echo lang('csv3') ?: ''; ?><br>
              <strong><?php echo sprintf(lang('x_col_required'), 3); ?></strong>
            </div>
          </div>
          <a href="<?php echo base_url(); ?>assets/csv/sample_sale_products.csv" class="btn btn-outline-primary btn-sm mb-3">
            <span class="icon-base ri ri-download-line me-1"></span><?php echo lang('download_sample_file') ?: 'Télécharger exemple'; ?>
          </a>
          <div class="mb-3">
            <label class="form-label" for="csv_file_sl"><?php echo lang('csv_file') ?: 'Fichier CSV'; ?> <span class="text-danger">*</span></label>
            <input type="file" class="form-control" id="csv_file_sl" name="userfile" accept=".csv" required />
          </div>
          <div>
            <label class="form-label" for="document_sl"><?php echo lang('document') ?: 'Document'; ?></label>
            <input type="file" class="form-control" id="document_sl" name="attachments[]" multiple />
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('note', isset($_POST['note']) ? $_POST['note'] : '', 'id="slnote_csv" class="form-control" placeholder="' . lang('sale_note') . '" style="height:100px;"'); ?>
            <label for="slnote_csv"><?php echo lang('sale_note') ?: 'Note vente'; ?></label>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-floating form-floating-outline">
            <?php echo form_textarea('staff_note', isset($_POST['staff_note']) ? $_POST['staff_note'] : '', 'id="slinnote_csv" class="form-control" placeholder="' . lang('staff_note') . '" style="height:100px;"'); ?>
            <label for="slinnote_csv"><?php echo lang('staff_note') ?: 'Note interne'; ?></label>
          </div>
        </div>

        <div class="col-12">
          <?php echo form_submit('add_sale', lang('submit') ?: 'Importer', 'class="btn btn-primary"'); ?>
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
    flatpickr('#sldate_csv', { dateFormat: 'd-m-Y', defaultDate: 'today', allowInput: true });
  }

  // Customer select2 with AJAX suggestions
  if (typeof $.fn.select2 !== 'undefined' && $('#slcustomer_csv').length) {
    $('#slcustomer_csv').select2({
      minimumInputLength: 1,
      placeholder: '<?php echo lang('select') . ' ' . lang('customer'); ?>',
      ajax: {
        url: '<?php echo base_url(); ?>customers/suggestions',
        dataType: 'json',
        delay: 150,
        data: function(params) { return { term: params.term, limit: 10 }; },
        processResults: function(data) {
          return { results: data.results || [{ id: '', text: 'No Match Found' }] };
        }
      }
    });
  }
});
</script>
