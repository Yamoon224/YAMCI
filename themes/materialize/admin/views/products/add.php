<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
if (!empty($variants)) {
    foreach ($variants as $variant) {
        $vars[] = addslashes($variant->name);
    }
} else {
    $vars = [];
}
?>

<?php
$attrib = ['data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-product-form'];
echo admin_form_open_multipart('products/add', $attrib);
?>

<div class="app-ecommerce">

  <!-- ============================
       HEADER + ACTIONS (style template Pixinvent)
       ============================ -->
  <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
      <h4 class="mb-1"><?php echo lang('add_product') ?: 'Ajouter un produit'; ?></h4>
      <p class="mb-0 text-muted">Saisissez les informations du nouveau produit</p>
      <nav aria-label="breadcrumb" class="mt-2">
        <ol class="breadcrumb breadcrumb-style1 mb-0">
          <li class="breadcrumb-item"><a href="<?php echo admin_url('welcome'); ?>">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="<?php echo admin_url('products'); ?>"><?php echo lang('products') ?: 'Produits'; ?></a></li>
          <li class="breadcrumb-item active" aria-current="page"><?php echo lang('add_product') ?: 'Ajouter'; ?></li>
        </ol>
      </nav>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-3">
      <a href="<?php echo admin_url('products'); ?>" class="btn btn-outline-secondary">
        <i class="ri ri-close-line me-1" style="font-size:16px"></i>
        <?php echo lang('cancel') ?: 'Annuler'; ?>
      </a>
      <button type="submit" name="add_product" value="1" class="btn btn-primary">
        <i class="ri ri-save-line me-1" style="font-size:16px"></i>
        <?php echo lang('save') ?: 'Enregistrer'; ?>
      </button>
    </div>
  </div>

<div class="row">

  <!-- Left Column: Main Info (8/12) -->
  <div class="col-12 col-lg-8">
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-information-line me-2" aria-hidden="true"></span>
          <?php echo lang('general_information') ?: 'General Information'; ?>
        </h5>
      </div>
      <div class="card-body">

        <div class="mb-3">
          <label for="type" class="form-label"><?php echo lang('product_type') ?: 'Product Type'; ?> <span class="text-danger">*</span></label>
          <?php
          $opts = ['standard' => lang('standard'), 'combo' => lang('combo'), 'digital' => lang('digital'), 'service' => lang('service')];
          echo form_dropdown('type', $opts, ($_POST['type'] ?? ''), 'class="form-select" id="type" required="required"');
          ?>
        </div>

        <div class="mb-3 all">
          <label for="name" class="form-label"><?php echo lang('product_name') ?: 'Product Name'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('name', ($_POST['name'] ?? ''), 'class="form-control' . ($Settings->use_code_for_slug ? '' : ' gen_slug') . '" id="name" required="required"'); ?>
        </div>

        <div class="mb-3 all">
          <label for="code" class="form-label"><?php echo lang('product_code') ?: 'Product Code'; ?> <span class="text-danger">*</span></label>
          <div class="input-group">
            <?php echo form_input('code', ($_POST['code'] ?? ''), 'class="form-control' . ($Settings->use_code_for_slug ? ' gen_slug' : '') . '" id="code" required="required"'); ?>
            <button class="btn btn-outline-secondary" type="button" id="random_num" title="<?php echo lang('generate') ?: 'Generate'; ?>">
              <span class="ri-shuffle-line" aria-hidden="true"></span>
            </button>
          </div>
          <div class="form-text"><?php echo lang('you_scan_your_barcode_too') ?: 'You can also scan a barcode here.'; ?></div>
        </div>

        <div class="mb-3 all">
          <label for="slug" class="form-label"><?php echo lang('lien') ?: 'Slug'; ?></label>
          <?php echo form_input('slug', set_value('slug'), 'class="form-control" id="slug" required="required"'); ?>
        </div>

        <div class="mb-3 all">
          <label for="second_name" class="form-label"><?php echo lang('Autre nom') ?: 'Second Name'; ?></label>
          <?php echo form_input('second_name', set_value('second_name'), 'class="form-control" id="second_name"'); ?>
        </div>

        <div class="mb-3 standard_combo">
          <label for="weight" class="form-label"><?php echo lang('Poids') ?: 'Weight'; ?></label>
          <?php echo form_input('weight', set_value('weight'), 'class="form-control" id="weight"'); ?>
        </div>

        <div class="mb-3 all">
          <label for="barcode_symbology" class="form-label"><?php echo lang('Code barre') ?: 'Barcode Symbology'; ?></label>
          <?php
          $bs = ['code25' => 'Code25', 'code39' => 'Code39', 'code128' => 'Code128', 'ean8' => 'EAN8', 'ean13' => 'EAN13', 'upca' => 'UPC-A', 'upce' => 'UPC-E'];
          echo form_dropdown('barcode_symbology', $bs, ($_POST['barcode_symbology'] ?? 'code128'), 'class="form-select" id="barcode_symbology" required="required"');
          ?>
        </div>

        <div class="mb-3 all">
          <label for="brand" class="form-label"><?php echo lang('brand') ?: 'Brand'; ?></label>
          <?php
          $br[''] = '';
          foreach ($brands as $brand) { $br[$brand->id] = $brand->name; }
          echo form_dropdown('brand', $br, ($_POST['brand'] ?? ''), 'class="form-select select2" id="brand" style="width:100%"');
          ?>
        </div>

        <div class="mb-3 all">
          <label for="category" class="form-label"><?php echo lang('category') ?: 'Category'; ?> <span class="text-danger">*</span></label>
          <?php
          $cat[''] = '';
          foreach ($categories as $category) { $cat[$category->id] = $category->name; }
          echo form_dropdown('category', $cat, ($_POST['category'] ?? ''), 'class="form-select select2" id="category" required="required" style="width:100%"');
          ?>
        </div>

        <div class="mb-3 all">
          <label for="subcategory" class="form-label"><?php echo lang('subcategory') ?: 'Subcategory'; ?></label>
          <div id="subcat_data">
            <?php echo form_input('subcategory', '', 'class="form-control" id="subcategory" placeholder="' . lang('select_category_to_load') . '"'); ?>
          </div>
        </div>

      </div>
    </div>

    <!-- Pricing & Tax -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-money-dollar-circle-line me-2" aria-hidden="true"></span>
          <?php echo lang('pricing') ?: 'Pricing & Tax'; ?>
        </h5>
      </div>
      <div class="card-body">

        <div class="mb-3 standard">
          <label for="unit" class="form-label"><?php echo lang('product_unit') ?: 'Unit'; ?> <span class="text-danger">*</span></label>
          <?php
          $pu[''] = lang('select') . ' ' . lang('unit');
          foreach ($base_units as $bu) { $pu[$bu->id] = $bu->name . ' (' . $bu->code . ')'; }
          echo form_dropdown('unit', $pu, set_value('unit'), 'class="form-select select2" id="unit" required="required" style="width:100%;"');
          ?>
        </div>

        <div class="mb-3 standard">
          <label for="default_sale_unit" class="form-label"><?php echo lang('default_sale_unit') ?: 'Default Sale Unit'; ?></label>
          <?php $uopts[''] = lang('select_unit_first'); ?>
          <?php echo form_dropdown('default_sale_unit', $uopts, '', 'class="form-select" id="default_sale_unit" style="width:100%;"'); ?>
        </div>

        <div class="mb-3 standard">
          <label for="default_purchase_unit" class="form-label"><?php echo lang('default_purchase_unit') ?: 'Default Purchase Unit'; ?></label>
          <?php echo form_dropdown('default_purchase_unit', $uopts, '', 'class="form-select" id="default_purchase_unit" style="width:100%;"'); ?>
        </div>

        <div class="mb-3 standard">
          <label for="cost" class="form-label"><?php echo lang('product_cost') ?: 'Cost'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('cost', ($_POST['cost'] ?? ''), 'class="form-control" id="cost" required="required"'); ?>
        </div>

        <div class="mb-3 all">
          <label for="price" class="form-label"><?php echo lang('Prix de vente') ?: 'Sale Price'; ?> <span class="text-danger">*</span></label>
          <?php echo form_input('price', ($_POST['price'] ?? ''), 'class="form-control" id="price" required="required"'); ?>
        </div>

        <div class="mb-3">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" value="1" name="promotion" id="promotion" <?php echo $this->input->post('promotion') ? 'checked' : ''; ?>>
            <label for="promotion" class="form-check-label"><?php echo lang('promotion') ?: 'Promotion'; ?></label>
          </div>
        </div>

        <div id="promo" style="display:none;">
          <div class="card bg-label-warning border-0 mb-3">
            <div class="card-body">
              <div class="mb-3">
                <label for="promo_price" class="form-label"><?php echo lang('promo_price') ?: 'Promo Price'; ?></label>
                <?php echo form_input('promo_price', set_value('promo_price'), 'class="form-control" id="promo_price"'); ?>
              </div>
              <div class="row">
                <div class="col-6">
                  <label for="start_date" class="form-label"><?php echo lang('start_date') ?: 'Start Date'; ?></label>
                  <?php echo form_input('start_date', set_value('start_date'), 'class="form-control date" id="start_date"'); ?>
                </div>
                <div class="col-6">
                  <label for="end_date" class="form-label"><?php echo lang('end_date') ?: 'End Date'; ?></label>
                  <?php echo form_input('end_date', set_value('end_date'), 'class="form-control date" id="end_date"'); ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php if ($Settings->invoice_view == 2): ?>
        <div class="mb-3">
          <label for="hsn_code" class="form-label"><?php echo lang('hsn_code') ?: 'HSN Code'; ?></label>
          <?php echo form_input('hsn_code', set_value('hsn_code'), 'class="form-control" id="hsn_code"'); ?>
        </div>
        <?php endif; ?>

        <?php if ($Settings->tax1): ?>
        <div class="mb-3 all">
          <label for="tax_rate" class="form-label"><?php echo lang('product_tax') ?: 'Tax Rate'; ?></label>
          <?php
          $tr[''] = '';
          foreach ($tax_rates as $tax) { $tr[$tax->id] = $tax->name; }
          echo form_dropdown('tax_rate', $tr, ($_POST['tax_rate'] ?? $Settings->default_tax_rate), 'class="form-select select2" id="tax_rate" style="width:100%"');
          ?>
        </div>
        <div class="mb-3 all">
          <label for="tax_method" class="form-label"><?php echo lang('tax_method') ?: 'Tax Method'; ?></label>
          <?php
          $tm = ['1' => lang('exclusive'), '0' => lang('inclusive')];
          echo form_dropdown('tax_method', $tm, ($_POST['tax_method'] ?? ''), 'class="form-select" id="tax_method"');
          ?>
        </div>
        <?php endif; ?>

        <div class="mb-3 standard">
          <label for="alert_quantity" class="form-label"><?php echo lang('alert_quantity') ?: 'Alert Quantity'; ?></label>
          <div class="input-group">
            <?php echo form_input('alert_quantity', ($_POST['alert_quantity'] ?? ''), 'class="form-control" id="alert_quantity"'); ?>
            <span class="input-group-text">
              <div class="form-check mb-0">
                <input type="checkbox" class="form-check-input" name="track_quantity" id="track_quantity" value="1" checked="checked">
                <label for="track_quantity" class="form-check-label small"><?php echo lang('track') ?: 'Track'; ?></label>
              </div>
            </span>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- Right Column (4/12) -->
  <div class="col-12 col-lg-4">

    <!-- Supplier -->
    <div class="card mb-4 standard">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-truck-line me-2" aria-hidden="true"></span>
          <?php echo lang('supplier') ?: 'Supplier'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div id="supplier-con">
          <div class="mb-3">
            <?php echo form_input('supplier', ($_POST['supplier'] ?? ''), 'class="form-control suppliers" id="supplier" placeholder="' . lang('select') . ' ' . lang('supplier') . '" style="width:100%;"'); ?>
          </div>
          <div class="row">
            <div class="col-6 mb-3">
              <?php echo form_input('supplier_part_no', ($_POST['supplier_part_no'] ?? ''), 'class="form-control" id="supplier_part_no" placeholder="' . lang('supplier_part_no') . '"'); ?>
            </div>
            <div class="col-6 mb-3">
              <?php echo form_input('supplier_price', ($_POST['supplier_price'] ?? ''), 'class="form-control" id="supplier_price" placeholder="' . lang('supplier_price') . '"'); ?>
            </div>
          </div>
        </div>
        <div id="ex-suppliers"></div>
        <button type="button" class="btn btn-sm btn-outline-primary" id="addSupplier">
          <span class="ri-add-line me-1" aria-hidden="true"></span>
          <?php echo lang('add_supplier') ?: 'Add Supplier'; ?>
        </button>
      </div>
    </div>

    <!-- Attributes (standard products) -->
    <div class="card mb-4 standard">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-list-settings-line me-2" aria-hidden="true"></span>
          <?php echo lang('attributes') ?: 'Attributes / Variants'; ?>
        </h5>
      </div>
      <div class="card-body" id="attrs">
        <div class="mb-3">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="attributes" id="attributes" <?php echo ($this->input->post('attributes') || $product_options) ? 'checked' : ''; ?>>
            <label for="attributes" class="form-check-label"><?php echo lang('product_has_attributes') ?: 'Product has attributes'; ?></label>
            <small class="text-muted ms-2"><?php echo lang('eg_sizes_colors') ?: '(e.g. sizes, colors)'; ?></small>
          </div>
        </div>
        <div id="attr-con" style="<?php echo ($this->input->post('attributes') || $product_options) ? '' : 'display:none;'; ?>">
          <div class="mb-3" id="ui">
            <div class="input-group">
              <?php echo form_input('attributesInput', '', 'class="form-control select-tags" id="attributesInput" placeholder="' . $this->lang->line('enter_attributes') . '"'); ?>
              <button class="btn btn-outline-primary" type="button" id="addAttributes">
                <span class="ri-add-line" aria-hidden="true"></span>
              </button>
            </div>
          </div>
          <div class="table-responsive">
            <table id="attrTable" class="table table-sm table-bordered" style="<?php echo ($this->input->post('attributes') || $product_options) ? '' : 'display:none;'; ?>margin-bottom:0;">
              <thead class="table-light">
                <tr>
                  <th><?php echo lang('name'); ?></th>
                  <th><?php echo lang('warehouse'); ?></th>
                  <th><?php echo lang('price_addition'); ?></th>
                  <th class="text-center"><span class="ri-delete-bin-line attr-remove-all" style="cursor:pointer;" aria-hidden="true"></span></th>
                </tr>
              </thead>
              <tbody>
                <?php
                if ($this->input->post('attributes')) {
                    $a = sizeof($_POST['attr_name']);
                    for ($r = 0; $r <= $a; $r++) {
                        if (isset($_POST['attr_name'][$r]) && (isset($_POST['attr_warehouse'][$r]) || isset($_POST['attr_quantity'][$r]))) {
                            echo '<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' . $_POST['attr_name'][$r] . '"><span>' . $_POST['attr_name'][$r] . '</span></td><td class="text-center"><input type="hidden" name="attr_warehouse[]" value="' . $_POST['attr_warehouse'][$r] . '"><input type="hidden" name="attr_wh_name[]" value="' . $_POST['attr_wh_name'][$r] . '"><span>' . $_POST['attr_wh_name'][$r] . '</span></td><td class="text-end"><input type="hidden" name="attr_price[]" value="' . $_POST['attr_price'][$r] . '"><span>' . $_POST['attr_price'][$r] . '</span></td><td class="text-center"><span class="ri-close-line delAttr" style="cursor:pointer;"></span></td></tr>';
                        }
                    }
                } elseif ($product_options) {
                    foreach ($product_options as $option) {
                        echo '<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' . $option->name . '"><span>' . $option->name . '</span></td><td class="text-center"><input type="hidden" name="attr_warehouse[]" value="' . $option->warehouse_id . '"><input type="hidden" name="attr_wh_name[]" value="' . $option->wh_name . '"><span>' . $option->wh_name . '</span></td><td class="text-end"><input type="hidden" name="attr_price[]" value="' . $this->sma->formatMoney($option->price) . '"><span>' . $this->sma->formatMoney($option->price) . '</span></td><td class="text-center"><span class="ri-close-line delAttr" style="cursor:pointer;"></span></td></tr>';
                    }
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Combo products -->
    <div class="card mb-4 combo" style="display:none;">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-stack-line me-2" aria-hidden="true"></span>
          <?php echo lang('combo_products') ?: 'Combo Products'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="add_item" class="form-label"><?php echo lang('add_product') . ' (' . lang('not_with_variants') . ')'; ?></label>
          <?php echo form_input('add_item', '', 'class="form-control ttip" id="add_item" placeholder="' . $this->lang->line('add_item') . '"'); ?>
        </div>
        <div class="table-responsive">
          <table id="prTable" class="table table-sm table-bordered items">
            <thead class="table-light">
              <tr>
                <th><?php echo lang('product') . ' (' . lang('code') . ' - ' . lang('name') . ')'; ?></th>
                <th><?php echo lang('quantity'); ?></th>
                <th><?php echo lang('unit_price'); ?></th>
                <th class="text-center"><span class="ri-delete-bin-line" style="opacity:0.5;" aria-hidden="true"></span></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Digital products -->
    <div class="card mb-4 digital" style="display:none;">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-file-download-line me-2" aria-hidden="true"></span>
          <?php echo lang('digital_file') ?: 'Digital File'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label for="digital_file" class="form-label"><?php echo lang('digital_file') ?: 'Upload File'; ?></label>
          <input id="digital_file" type="file" name="digital_file" class="form-control" accept="*/*">
        </div>
        <div class="mb-3">
          <label for="file_link" class="form-label"><?php echo lang('file_link') ?: 'File Link'; ?></label>
          <?php echo form_input('file_link', set_value('file_link'), 'class="form-control" id="file_link"'); ?>
        </div>
      </div>
    </div>

    <!-- Images -->
    <div class="card mb-4">
      <div class="card-header">
        <h5 class="card-title mb-0">
          <span class="ri-image-line me-2" aria-hidden="true"></span>
          <?php echo lang('images') ?: 'Images'; ?>
        </h5>
      </div>
      <div class="card-body">
        <div class="mb-3 all">
          <label for="product_image" class="form-label"><?php echo lang('product_image') ?: 'Main Image'; ?></label>
          <input id="product_image" type="file" name="product_image" class="form-control" accept="image/*">
        </div>
        <div class="mb-3 all">
          <label for="images" class="form-label"><?php echo lang('product_gallery_images') ?: 'Gallery Images'; ?></label>
          <input id="images" type="file" name="userfile[]" multiple class="form-control" accept="image/*">
        </div>
        <div id="img-details"></div>
      </div>
    </div>

  </div>

</div>

<!-- Custom Fields & Additional Info -->
<div class="card mb-4">
  <div class="card-header">
    <div class="d-flex align-items-center gap-3">
      <h5 class="card-title mb-0">
        <span class="ri-settings-3-line me-2" aria-hidden="true"></span>
        <?php echo lang('additional_info') ?: 'Additional Info'; ?>
      </h5>
      <div class="form-check ms-2 mb-0">
        <input name="cf" type="checkbox" class="form-check-input" id="extras" value="" <?php echo isset($_POST['cf']) ? 'checked' : ''; ?>>
        <label for="extras" class="form-check-label"><?php echo lang('custom_fields') ?: 'Custom Fields'; ?></label>
      </div>
    </div>
  </div>
  <div class="card-body">

    <div class="row mb-3">
      <div class="col-auto">
        <div class="form-check form-check-inline">
          <input name="featured" type="checkbox" class="form-check-input" id="featured" value="1" <?php echo isset($_POST['featured']) ? 'checked' : ''; ?>>
          <label for="featured" class="form-check-label"><?php echo lang('Sponorisé') ?: 'Featured'; ?></label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check form-check-inline">
          <input name="hide_pos" type="checkbox" class="form-check-input" id="hide_pos" value="1" <?php echo isset($_POST['hide_pos']) ? 'checked' : ''; ?>>
          <label for="hide_pos" class="form-check-label"><?php echo lang('Masquer en POS') ?: 'Hide in POS'; ?></label>
        </div>
      </div>
      <div class="col-auto">
        <div class="form-check form-check-inline">
          <input name="hide" type="checkbox" class="form-check-input" id="hide" value="1" <?php echo isset($_POST['hide']) ? 'checked' : ''; ?>>
          <label for="hide" class="form-check-label"><?php echo lang('Masquer dans shop') ?: 'Hide in Shop'; ?></label>
        </div>
      </div>
    </div>

    <div id="extras-con" style="display:none;">
      <div class="row">
        <?php for ($cf = 1; $cf <= 6; $cf++): ?>
        <div class="col-md-4 mb-3">
          <label for="cf<?php echo $cf; ?>" class="form-label"><?php echo lang('pcf' . $cf) ?: 'Custom Field ' . $cf; ?></label>
          <?php echo form_input('cf' . $cf, ($_POST['cf' . $cf] ?? ''), 'class="form-control" id="cf' . $cf . '"'); ?>
        </div>
        <?php endfor; ?>
      </div>
    </div>

    <div class="mb-3 all">
      <label for="product_details" class="form-label"><?php echo lang('product_details') ?: 'Product Details'; ?></label>
      <?php echo form_textarea('product_details', ($_POST['product_details'] ?? ''), 'class="form-control" id="product_details" rows="3"'); ?>
    </div>

    <div class="mb-3 all">
      <label for="details" class="form-label"><?php echo lang('product_details_for_invoice') ?: 'Details (on Invoice)'; ?></label>
      <?php echo form_textarea('details', ($_POST['details'] ?? ''), 'class="form-control" id="details" rows="3"'); ?>
    </div>

  </div>
  <div class="card-footer d-flex justify-content-end gap-2">
    <a href="<?php echo admin_url('products'); ?>" class="btn btn-outline-secondary">
      <i class="ri ri-close-line me-1" style="font-size:16px"></i>
      <?php echo lang('cancel') ?: 'Annuler'; ?>
    </a>
    <?php echo form_submit('add_product', lang('add_product') ?: 'Enregistrer', 'class="btn btn-primary"'); ?>
  </div>
</div>

</div><!-- /.app-ecommerce -->

<?php echo form_close(); ?>

<!-- Attribute warehouse modal -->
<div class="modal fade" id="aModal" tabindex="-1" role="dialog" aria-labelledby="aModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="aModalLabel"><?php echo lang('add_product_manually') ?: 'Edit Attribute'; ?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="awarehouse" class="form-label"><?php echo lang('warehouse') ?: 'Warehouse'; ?></label>
          <?php
          $wh[''] = '';
          foreach ($warehouses as $warehouse) { $wh[$warehouse->id] = $warehouse->name; }
          echo form_dropdown('warehouse', $wh, '', 'id="awarehouse" class="form-select"');
          ?>
        </div>
        <input type="hidden" id="aquantity" value="0">
        <div class="mb-3">
          <label for="aprice" class="form-label"><?php echo lang('price_addition') ?: 'Price Addition'; ?></label>
          <input type="text" class="form-control" id="aprice">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('cancel') ?: 'Cancel'; ?></button>
        <button type="button" class="btn btn-primary" id="updateAttr"><?php echo lang('submit') ?: 'Save'; ?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    $('.gen_slug').on('change', function () {
        getSlug($(this).val(), 'products');
    });

    $('#subcategory').select2('destroy').empty().attr('placeholder', '<?php echo lang('select_category_to_load'); ?>').select2({
        placeholder: '<?php echo lang('select_category_to_load'); ?>',
        minimumResultsForSearch: 7,
        data: [{ id: '', text: '<?php echo lang('select_category_to_load'); ?>' }]
    });

    $('#category').on('change', function () {
        var v = $(this).val();
        if (v) {
            $.ajax({
                type: 'get', async: false,
                url: '<?php echo admin_url('products/getSubCategories'); ?>/' + v,
                dataType: 'json',
                success: function (scdata) {
                    if (scdata !== null) {
                        scdata.push({ id: '', text: '<?php echo lang('select_subcategory'); ?>' });
                        $('#subcategory').select2('destroy').empty().select2({ minimumResultsForSearch: 7, data: scdata });
                    } else {
                        $('#subcategory').select2('destroy').empty().select2({ minimumResultsForSearch: 7, data: [{ id: '', text: '<?php echo lang('no_subcategory'); ?>' }] });
                    }
                },
                error: function () { bootbox.alert('<?php echo lang('ajax_error'); ?>'); }
            });
        } else {
            $('#subcategory').select2('destroy').empty().select2({ minimumResultsForSearch: 7, data: [{ id: '', text: '<?php echo lang('select_category_to_load'); ?>' }] });
        }
    });

    $('#code').on('keypress', function (e) { if (e.keyCode == 13) { e.preventDefault(); return false; } });

    // Product type toggles
    function setProductType(t) {
        if (t !== 'standard') {
            $('.standard').slideUp(); $('#unit').prop('disabled', true); $('#cost').prop('disabled', true);
        } else {
            $('.standard').slideDown(); $('#unit').prop('disabled', false); $('#cost').prop('disabled', false);
        }
        t !== 'digital' ? $('.digital').slideUp() : $('.digital').slideDown();
        t !== 'combo' ? $('.combo').slideUp() : $('.combo').slideDown();
        (t === 'standard' || t === 'combo') ? $('.standard_combo').slideDown() : $('.standard_combo').slideUp();
    }

    var t0 = $('#type').val();
    setProductType(t0);
    $('#type').on('change', function () { setProductType($(this).val()); });

    // Promotion toggle
    $('#promotion').on('change', function () { $(this).is(':checked') ? $('#promo').slideDown() : $('#promo').slideUp(); });
    <?php echo $this->input->post('promotion') ? '$("#promo").show();' : ''; ?>

    // Custom fields toggle
    $('#extras').on('change', function () { $(this).is(':checked') ? $('#extras-con').slideDown() : $('#extras-con').slideUp(); });
    <?php echo isset($_POST['cf']) ? '$("#extras-con").show();' : ''; ?>

    // Attributes toggle
    $('#attributes').on('change', function () {
        if ($(this).is(':checked')) { $('#attr-con').slideDown(); }
        else { $('.select-tags').select2('val', ''); $('.attr-remove-all').trigger('click'); $('#attr-con').slideUp(); }
    });

    $('#addAttributes').on('click', function (e) {
        e.preventDefault();
        var attrs = $('#attributesInput').val().split(',');
        for (var i in attrs) {
            if (attrs[i] !== '') {
                <?php
                if (!empty($warehouses)) {
                    foreach ($warehouses as $warehouse) {
                        echo '$(\'#attrTable\').show().append(\'<tr class="attr"><td><input type="hidden" name="attr_name[]" value="\' + attrs[i] + \'"><span>\' + attrs[i] + \'</span></td><td class="text-center"><input type="hidden" name="attr_warehouse[]" value="' . $warehouse->id . '"><span>' . $warehouse->name . '</span></td><td class="text-end"><input type="hidden" name="attr_price[]" value="0"><span>0</span></td><td class="text-center"><span class="ri-close-line delAttr" style="cursor:pointer;"></span></td></tr>\');';
                    }
                } else {
                    ?>
                $('#attrTable').show().append('<tr class="attr"><td><input type="hidden" name="attr_name[]" value="' + attrs[i] + '"><span>' + attrs[i] + '</span></td><td class="text-center"><input type="hidden" name="attr_warehouse[]" value=""><span></span></td><td class="text-end"><input type="hidden" name="attr_price[]" value="0"><span>0</span></td><td class="text-center"><span class="ri-close-line delAttr" style="cursor:pointer;"></span></td></tr>');
                    <?php
                }
                ?>
            }
        }
    });

    $(document).on('click', '.delAttr', function () { $(this).closest('tr').remove(); });
    $(document).on('click', '.attr-remove-all', function () { $('#attrTable tbody').empty(); $('#attrTable').hide(); });

    var row, warehouses = <?php echo json_encode($warehouses); ?>;
    $(document).on('click', '.attr td:not(:last-child)', function () {
        row = $(this).closest('tr');
        $('#aModalLabel').text(row.children().eq(0).find('span').text());
        $('#awarehouse').select2('val', row.children().eq(1).find('input').val());
        $('#aprice').val(row.children().eq(2).find('span').text());
        $('#aModal').appendTo('body').modal('show');
    });

    $('#updateAttr').on('click', function () {
        var wh = $('#awarehouse').val(), wh_name = '';
        $.each(warehouses, function () { if (this.id == wh) { wh_name = this.name; } });
        row.children().eq(1).html('<input type="hidden" name="attr_warehouse[]" value="' + wh + '"><input type="hidden" name="attr_wh_name[]" value="' + wh_name + '"><span>' + wh_name + '</span>');
        row.children().eq(2).html('<input type="hidden" name="attr_price[]" value="' + $('#aprice').val() + '"><span>' + currencyFormat($('#aprice').val()) + '</span>');
        $('#aModal').modal('hide');
    });

    var variants = <?php echo json_encode($vars); ?>;
    $('.select-tags').select2({ tags: variants, tokenSeparators: [','], multiple: true });

    // Unit change
    $('#unit').on('change', function () {
        var v = $(this).val();
        if (v) {
            $.ajax({
                type: 'get', async: false,
                url: '<?php echo admin_url('products/getSubUnits'); ?>/' + v,
                dataType: 'json',
                success: function (data) {
                    $('#default_sale_unit, #default_purchase_unit').select2('destroy').empty().select2({ minimumResultsForSearch: 7 });
                    $.each(data, function () {
                        $('<option />', { value: this.id, text: this.name + ' (' + this.code + ')' }).appendTo($('#default_sale_unit, #default_purchase_unit'));
                    });
                    $('#default_sale_unit').select2('val', v);
                    $('#default_purchase_unit').select2('val', v);
                },
                error: function () { bootbox.alert('<?php echo lang('ajax_error'); ?>'); }
            });
        } else {
            $('#default_sale_unit, #default_purchase_unit').select2('destroy').empty();
            $('<option />', { value: '', text: '<?php echo lang('select_unit_first'); ?>' }).appendTo($('#default_sale_unit, #default_purchase_unit'));
            $('#default_sale_unit, #default_purchase_unit').select2({ minimumResultsForSearch: 7 }).select2('val', '');
        }
    });

    // Combo product item
    var items = {};
    var audio_success = new Audio('<?php echo $assets; ?>sounds/sound2.mp3');
    var audio_error   = new Audio('<?php echo $assets; ?>sounds/sound3.mp3');

    <?php
    if ($combo_items) {
        foreach ($combo_items as $item) {
            if ($item->code) { echo 'add_product_item(' . json_encode($item) . ');'; }
        }
    }
    if ($this->input->post('type') == 'combo') {
        $c = isset($_POST['combo_item_code']) ? sizeof($_POST['combo_item_code']) : 0;
        for ($r = 0; $r <= $c; $r++) {
            if (isset($_POST['combo_item_code'][$r]) && isset($_POST['combo_item_quantity'][$r]) && isset($_POST['combo_item_price'][$r])) {
                $citems[] = ['id' => $_POST['combo_item_id'][$r], 'name' => $_POST['combo_item_name'][$r], 'code' => $_POST['combo_item_code'][$r], 'qty' => $_POST['combo_item_quantity'][$r], 'price' => $_POST['combo_item_price'][$r]];
            }
        }
        echo 'var ci = ' . (isset($citems) ? json_encode($citems) : "[]") . '; $.each(ci, function() { add_product_item(this); });';
    }
    ?>

    function add_product_item(item) {
        if (!item) return false;
        var item_id = item.id;
        if (items[item_id]) { items[item_id].qty = (parseFloat(items[item_id].qty) + 1).toFixed(2); }
        else { items[item_id] = item; }
        var pp = 0;
        $('#prTable tbody').empty();
        $.each(items, function () {
            var row_no = this.id;
            var tr = '<tr id="row_' + row_no + '" class="item_' + this.id + '" data-item-id="' + row_no + '">';
            tr += '<td><input name="combo_item_id[]" type="hidden" value="' + this.id + '"><input name="combo_item_name[]" type="hidden" value="' + this.name + '"><input name="combo_item_code[]" type="hidden" value="' + this.code + '"><span>' + this.code + ' - ' + this.name + '</span></td>';
            tr += '<td><input class="form-control form-control-sm text-center rquantity" name="combo_item_quantity[]" type="text" value="' + formatDecimal(this.qty) + '" data-id="' + row_no + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
            tr += '<td><input class="form-control form-control-sm text-center rprice" name="combo_item_price[]" type="text" value="' + formatDecimal(this.price) + '" data-id="' + row_no + '" id="combo_item_price_' + row_no + '" onClick="this.select();"></td>';
            tr += '<td class="text-center"><span class="ri-close-line del" id="' + row_no + '" style="cursor:pointer;"></span></td>';
            tr += '</tr>';
            $('#prTable tbody').prepend(tr);
            pp += formatDecimal(parseFloat(this.price) * parseFloat(this.qty));
        });
        $('.item_' + item_id).addClass('table-warning');
        $('#price').val(pp);
        return true;
    }

    function calculate_price() {
        var pp = 0;
        $('#prTable tbody tr').each(function () {
            pp += formatDecimal(parseFloat($(this).find('.rprice').val()) * parseFloat($(this).find('.rquantity').val()));
        });
        $('#price').val(pp);
    }

    $(document).on('change', '.rquantity, .rprice', calculate_price);
    $(document).on('click', '.del', function () {
        var id = $(this).attr('id');
        delete items[id];
        $('#row_' + id).remove();
        calculate_price();
    });

    $('#add_item').autocomplete({
        source: '<?php echo admin_url('products/suggestions'); ?>',
        minLength: 1, autoFocus: false, delay: 250,
        response: function (event, ui) {
            if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                bootbox.alert('<?php echo lang('no_product_found'); ?>', function () { $('#add_item').focus(); });
                $(this).val('');
            } else if (ui.content.length == 1 && ui.content[0].id != 0) {
                ui.item = ui.content[0];
                $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                $(this).autocomplete('close').removeClass('ui-autocomplete-loading');
            } else if (ui.content.length == 1 && ui.content[0].id == 0) {
                bootbox.alert('<?php echo lang('no_product_found'); ?>', function () { $('#add_item').focus(); });
                $(this).val('');
            }
        },
        select: function (event, ui) {
            event.preventDefault();
            if (ui.item.id !== 0) {
                var row = add_product_item(ui.item);
                if (row) { $(this).val(''); }
            } else { bootbox.alert('<?php echo lang('no_product_found'); ?>'); }
        }
    });

    // Supplier add
    var su = 2;
    $('#addSupplier').on('click', function () {
        if (su <= 5) {
            $('#supplier_1').select2('destroy');
            var html = '<div class="mt-3"><div class="row"><div class="col-12 mb-2"><input type="hidden" name="supplier_' + su + '" class="form-control" id="supplier_' + su + '" placeholder="<?php echo lang('select') . ' ' . lang('supplier'); ?>" style="width:100%;display:block !important;" /></div><div class="col-6"><input type="text" name="supplier_' + su + '_part_no" class="form-control mb-2" id="supplier_' + su + '_part_no" placeholder="<?php echo lang('supplier_part_no'); ?>" /></div><div class="col-6"><input type="text" name="supplier_' + su + '_price" class="form-control mb-2" id="supplier_' + su + '_price" placeholder="<?php echo lang('supplier_price'); ?>" /></div></div></div>';
            $('#ex-suppliers').append(html);
            suppliers($('#supplier_' + su));
            su++;
        } else { bootbox.alert('<?php echo lang('max_reached'); ?>'); }
    });
});
</script>
