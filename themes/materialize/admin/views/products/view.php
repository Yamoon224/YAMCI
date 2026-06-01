<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= htmlspecialchars($product->name) ?></h4>
    <p class="mb-0 text-muted">
      <span class="me-2"><?= lang('code') ?>: <span class="text-primary fw-semibold"><?= htmlspecialchars($product->code) ?></span></span>
      <?php if ($product->type): ?>
      <span class="badge bg-label-info text-uppercase ms-1"><?= htmlspecialchars($product->type) ?></span>
      <?php endif; ?>
    </p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>"><?= lang('home') ?: 'Accueil' ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('products') ?>"><?= lang('products') ?></a></li>
        <li class="breadcrumb-item active"><?= htmlspecialchars($product->name) ?></li>
      </ol>
    </nav>
  </div>
  <?php if (!$Supplier || !$Customer): ?>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?= admin_url('products/print_barcodes/' . $product->id) ?>" class="btn btn-outline-secondary">
      <i class="ri ri-printer-line me-1" style="font-size:16px"></i><?= lang('print_barcode_label') ?: 'Code-barres' ?>
    </a>
    <a href="<?= admin_url('products/pdf/' . $product->id) ?>" class="btn btn-outline-secondary">
      <i class="ri ri-file-pdf-line me-1" style="font-size:16px"></i><?= lang('pdf') ?>
    </a>
    <a href="<?= admin_url('products/edit/' . $product->id) ?>" class="btn btn-warning">
      <i class="ri ri-edit-line me-1" style="font-size:16px"></i><?= lang('edit') ?>
    </a>
    <a href="<?= admin_url('products/delete/' . $product->id) ?>" class="btn btn-outline-danger"
       onclick="return confirm('<?= lang('r_u_sure') ?>')">
      <i class="ri ri-delete-bin-line me-1" style="font-size:16px"></i><?= lang('delete') ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<?php if ($Owner || $Admin): ?>
<!-- Nav Tabs -->
<ul class="nav nav-tabs mb-4" id="productTabs" role="tablist">
    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#details" type="button"><i class="icon-base ri ri-file-list-3-line icon-20px me-1"></i><?= lang('product_details') ?></button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-sales" type="button"><i class="icon-base ri ri-shopping-cart-line icon-20px me-1"></i><?= lang('sales') ?></button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-quotes" type="button"><i class="icon-base ri ri-file-text-line icon-20px me-1"></i><?= lang('quotes') ?></button></li>
    <?php if ($product->type == 'standard'): ?>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-purchases" type="button"><i class="icon-base ri ri-shopping-bag-line icon-20px me-1"></i><?= lang('purchases') ?></button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-transfers" type="button"><i class="icon-base ri ri-swap-box-line icon-20px me-1"></i><?= lang('transfers') ?></button></li>
    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-adjustments" type="button"><i class="icon-base ri ri-equalizer-line icon-20px me-1"></i><?= lang('quantity_adjustments') ?></button></li>
    <?php endif; ?>
</ul>
<div class="tab-content" id="productTabsContent">
<div class="tab-pane fade show active" id="details" role="tabpanel">
<?php endif; ?>

<!-- Product Hero Card -->
<div class="card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <i class="icon-base ri ri-box-3-line icon-20px text-primary"></i>
            <h5 class="card-title mb-0">
                <?= lang('product_details') ?: 'Détails du produit' ?>
                <?php if (SHOP && $product->hide != 1): ?>
                    <small class="text-muted ms-2"><?= lang('shop_views') ?>: <?= $product->views ?></small>
                <?php endif; ?>
            </h5>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- Product image gallery -->
            <div class="col-md-4 mb-3">
                <img src="<?= base_url() ?>assets/uploads/<?= $product->image ?>"
                     alt="<?= $product->name ?>"
                     class="img-fluid rounded border mb-2"
                     id="mainProductImg"
                     style="width:100%; max-height:280px; object-fit:contain;">

                <?php if (!empty($images)): ?>
                <div class="d-flex flex-wrap gap-2 mt-2" id="multiimages">
                    <a href="<?= base_url() ?>assets/uploads/<?= $product->image ?>"
                       data-bs-toggle="lightbox" data-gallery="product-gallery"
                       class="border rounded overflow-hidden" style="width:60px; height:60px;">
                        <img src="<?= base_url() ?>assets/uploads/thumbs/<?= $product->image ?>"
                             class="img-fluid" style="width:60px; height:60px; object-fit:cover;">
                    </a>
                    <?php foreach ($images as $ph): ?>
                    <div class="position-relative">
                        <a href="<?= base_url() ?>assets/uploads/<?= $ph->photo ?>"
                           data-bs-toggle="lightbox" data-gallery="product-gallery"
                           class="border rounded overflow-hidden d-block" style="width:60px; height:60px;">
                            <img src="<?= base_url() ?>assets/uploads/thumbs/<?= $ph->photo ?>"
                                 class="img-fluid" style="width:60px; height:60px; object-fit:cover;">
                        </a>
                        <?php if ($Owner || $Admin || $GP['products-edit']): ?>
                        <a href="#" class="delimg position-absolute top-0 end-0 bg-danger text-white rounded-circle d-flex align-items-center justify-content-center"
                           data-item-id="<?= $ph->id ?>" style="width:18px;height:18px;font-size:10px;">
                            <i class="ri ri-close-line"></i>
                        </a>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Product details table -->
            <div class="col-md-8">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td class="text-muted fw-semibold" style="width:35%;"><?= lang('type') ?></td>
                            <td><span class="badge bg-label-info"><?= lang($product->type) ?></span></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('code') ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= admin_url('misc/barcode/' . $product->code . '/' . $product->barcode_symbology . '/74/0') ?>"
                                         alt="<?= $product->code ?>" style="max-height:40px;">
                                    <span><?= $product->code ?></span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('category') ?></td>
                            <td><?= $category->name ?></td>
                        </tr>
                        <?php if ($product->subcategory_id): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('subcategory') ?></td>
                            <td><?= $subcategory->name ?></td>
                        </tr>
                        <?php endif; ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('brand') ?></td>
                            <td><?= $brand ? $brand->name : '<span class="text-muted">—</span>' ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('unit') ?></td>
                            <td><?= $unit ? $unit->name . ' (' . $unit->code . ')' : '' ?></td>
                        </tr>
                        <?php if ($Owner || $Admin): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('cost') ?></td>
                            <td class="fw-bold text-success"><?= $this->sma->formatMoney($product->cost) ?></td>
                        </tr>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('price') ?></td>
                            <td class="fw-bold text-primary"><?= $this->sma->formatMoney($product->price) ?></td>
                        </tr>
                        <?php if ($product->promotion): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('promotion') ?></td>
                            <td>
                                <span class="badge bg-label-danger"><?= $this->sma->formatMoney($product->promo_price) ?></span>
                                <small class="text-muted ms-1"><?= $this->sma->hrsd($product->start_date) . ' - ' . $this->sma->hrsd($product->end_date) ?></small>
                            </td>
                        </tr>
                        <?php endif; ?>
                        <?php else: ?>
                            <?php if ($this->session->userdata('show_cost')): ?>
                            <tr>
                                <td class="text-muted fw-semibold"><?= lang('cost') ?></td>
                                <td class="fw-bold text-success"><?= $this->sma->formatMoney($product->cost) ?></td>
                            </tr>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('show_price')): ?>
                            <tr>
                                <td class="text-muted fw-semibold"><?= lang('price') ?></td>
                                <td class="fw-bold text-primary"><?= $this->sma->formatMoney($product->price) ?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($product->tax_rate): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('tax_rate') ?></td>
                            <td><?= $tax_rate->name ?> — <?= $product->tax_method == 0 ? lang('inclusive') : lang('exclusive') ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($product->alert_quantity != 0): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('alert_quantity') ?></td>
                            <td><span class="badge bg-label-warning"><?= $this->sma->formatQuantity($product->alert_quantity) ?></span></td>
                        </tr>
                        <?php endif; ?>
                        <?php if ($variants): ?>
                        <tr>
                            <td class="text-muted fw-semibold"><?= lang('product_variants') ?></td>
                            <td>
                                <?php foreach ($variants as $variant): ?>
                                <span class="badge bg-label-primary me-1"><?= $variant->name ?></span>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stock & Details Row -->
<div class="row mb-4">
    <!-- Warehouse Stock -->
    <?php if ((!$Supplier || !$Customer) && !empty($warehouses) && $product->type == 'standard'): ?>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="icon-base ri ri-store-2-line icon-20px text-success"></i>
                <h6 class="card-title mb-0"><?= lang('warehouse_quantity') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th><?= lang('warehouse_name') ?></th>
                                <th><?= lang('quantity') ?></th>
                                <?php if ($Owner || $Admin || $this->session->userdata('show_cost')): ?>
                                <th><?= lang('avg_cost') ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($warehouses as $warehouse): ?>
                            <?php if ($warehouse->quantity != 0): ?>
                            <tr>
                                <td><?= $warehouse->name ?> <small class="text-muted">(<?= $warehouse->code ?>)</small></td>
                                <td>
                                    <strong><?= $this->sma->formatQuantity($warehouse->quantity) ?></strong>
                                    <?= $warehouse->rack ? ' <small class="text-muted">(' . $warehouse->rack . ')</small>' : '' ?>
                                </td>
                                <?php if ($Owner || $Admin || $this->session->userdata('show_cost')): ?>
                                <td><?= $warehouse->avg_cost ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Product details / Custom fields -->
    <div class="col-md-6 mb-3">
        <?php if ($product->cf1 || $product->cf2 || $product->cf3 || $product->cf4 || $product->cf5 || $product->cf6): ?>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="icon-base ri ri-list-check-line icon-20px text-info"></i>
                <h6 class="card-title mb-0"><?= lang('custom_fields') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <tbody>
                        <?php
                        if ($product->cf1) echo '<tr><td class="text-muted">' . lang('pcf1') . '</td><td>' . $product->cf1 . '</td></tr>';
                        if ($product->cf2) echo '<tr><td class="text-muted">' . lang('pcf2') . '</td><td>' . $product->cf2 . '</td></tr>';
                        if ($product->cf3) echo '<tr><td class="text-muted">' . lang('pcf3') . '</td><td>' . $product->cf3 . '</td></tr>';
                        if ($product->cf4) echo '<tr><td class="text-muted">' . lang('pcf4') . '</td><td>' . $product->cf4 . '</td></tr>';
                        if ($product->cf5) echo '<tr><td class="text-muted">' . lang('pcf5') . '</td><td>' . $product->cf5 . '</td></tr>';
                        if ($product->cf6) echo '<tr><td class="text-muted">' . lang('pcf6') . '</td><td>' . $product->cf6 . '</td></tr>';
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($product->type == 'combo' && !empty($combo_items)): ?>
        <div class="card mb-3">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="icon-base ri ri-apps-2-line icon-20px text-warning"></i>
                <h6 class="card-title mb-0"><?= lang('combo_items') ?></h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th><?= lang('product_name') ?></th><th><?= lang('quantity') ?></th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($combo_items as $combo_item): ?>
                        <tr>
                            <td><?= $combo_item->name ?> <small class="text-muted">(<?= $combo_item->code ?>)</small></td>
                            <td><?= $this->sma->formatQuantity($combo_item->qty) ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Variants quantity -->
<?php if (!empty($options)): ?>
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="icon-base ri ri-pantone-line icon-20px text-primary"></i>
        <h6 class="card-title mb-0"><?= lang('product_variants_quantity') ?></h6>
    </div>
    <div class="card-datatable table-responsive">
        <table class="table table-sm table-hover">
            <thead class="table-light">
                <tr>
                    <th><?= lang('warehouse_name') ?></th>
                    <th><?= lang('product_variant') ?></th>
                    <th><?= lang('quantity') ?></th>
                    <?php if ($Owner || $Admin): ?>
                    <th><?= lang('cost') ?></th>
                    <th><?= lang('price') ?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($options as $option): ?>
                <?php if ($option->wh_qty != 0): ?>
                <tr>
                    <td><?= $option->wh_name ?></td>
                    <td><?= $option->name ?></td>
                    <td><?= $this->sma->formatQuantity($option->wh_qty) ?></td>
                    <?php if ($Owner || $Admin): ?>
                    <td><?= $this->sma->formatMoney($option->cost) ?></td>
                    <td><?= $this->sma->formatMoney($option->price) ?></td>
                    <?php endif; ?>
                </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<!-- Product description / details -->
<?php if ($product->details): ?>
<div class="card mb-3 border-success">
    <div class="card-header bg-label-success d-flex align-items-center gap-2">
        <i class="icon-base ri ri-file-text-line icon-20px"></i>
        <h6 class="card-title mb-0"><?= lang('product_details_for_invoice') ?></h6>
    </div>
    <div class="card-body"><?= $product->details ?></div>
</div>
<?php endif; ?>
<?php if ($product->product_details): ?>
<div class="card mb-3 border-primary">
    <div class="card-header bg-label-primary d-flex align-items-center gap-2">
        <i class="icon-base ri ri-information-line icon-20px"></i>
        <h6 class="card-title mb-0"><?= lang('product_details') ?></h6>
    </div>
    <div class="card-body"><?= $product->product_details ?></div>
</div>
<?php endif; ?>

<?php if ($Owner || $Admin): ?>
</div><!-- #details tab-pane -->

<!-- Sales Tab -->
<div class="tab-pane fade" id="tab-sales" role="tabpanel">
    <div class="card">
        <div class="card-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="icon-base ri ri-shopping-cart-line icon-20px text-primary"></i>
                <h5 class="card-title mb-0"><?= $product->name . ' — ' . lang('sales') ?></h5>
            </div>
            <div>
                <a href="<?= admin_url('reports/getSalesReport/0/xls/?v=1&product=' . $product->id) ?>" class="btn btn-sm btn-outline-success">
                    <i class="icon-base ri ri-file-excel-line icon-20px me-1"></i>XLS
                </a>
            </div>
        </div>
        <div class="card-datatable table-responsive">
            <table id="SlRData" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('reference_no') ?></th>
                        <th><?= lang('biller') ?></th>
                        <th><?= lang('customer') ?></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('paid') ?></th>
                        <th><?= lang('balance') ?></th>
                        <th><?= lang('payment_status') ?></th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td></tr></tbody>
                <tfoot class="dtFilter">
                    <tr class="active">
                        <th></th><th></th><th></th><th></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('paid') ?></th>
                        <th><?= lang('balance') ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Quotes Tab -->
<div class="tab-pane fade" id="tab-quotes" role="tabpanel">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="icon-base ri ri-file-text-line icon-20px text-info"></i>
            <h5 class="card-title mb-0"><?= $product->name . ' — ' . lang('quotes') ?></h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="QuRData" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('reference_no') ?></th>
                        <th><?= lang('biller') ?></th>
                        <th><?= lang('customer') ?></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('status') ?></th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td></tr></tbody>
                <tfoot class="dtFilter">
                    <tr><th></th><th></th><th></th><th></th><th><?= lang('product_qty') ?></th><th></th><th></th></tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php if ($product->type == 'standard'): ?>
<!-- Purchases Tab -->
<div class="tab-pane fade" id="tab-purchases" role="tabpanel">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="icon-base ri ri-shopping-bag-line icon-20px text-warning"></i>
            <h5 class="card-title mb-0"><?= $product->name . ' — ' . lang('purchases') ?></h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="PoRData" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('reference_no') ?></th>
                        <th><?= lang('warehouse') ?></th>
                        <th><?= lang('supplier') ?></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('paid') ?></th>
                        <th><?= lang('balance') ?></th>
                        <th><?= lang('status') ?></th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td></tr></tbody>
                <tfoot class="dtFilter">
                    <tr><th></th><th></th><th></th><th></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('paid') ?></th>
                        <th><?= lang('balance') ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Transfers Tab -->
<div class="tab-pane fade" id="tab-transfers" role="tabpanel">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="icon-base ri ri-swap-box-line icon-20px text-secondary"></i>
            <h5 class="card-title mb-0"><?= $product->name . ' — ' . lang('transfers') ?></h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="TrRData" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('reference_no') ?></th>
                        <th><?= lang('product_qty') ?></th>
                        <th><?= lang('warehouse') . ' (' . lang('from') . ')' ?></th>
                        <th><?= lang('warehouse') . ' (' . lang('to') . ')' ?></th>
                        <th><?= lang('grand_total') ?></th>
                        <th><?= lang('status') ?></th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td></tr></tbody>
                <tfoot class="dtFilter">
                    <tr><th></th><th></th><th><?= lang('product_qty') ?></th><th></th><th></th><th></th><th></th></tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Adjustments Tab -->
<div class="tab-pane fade" id="tab-adjustments" role="tabpanel">
    <div class="card">
        <div class="card-header d-flex align-items-center gap-2">
            <i class="icon-base ri ri-equalizer-line icon-20px text-danger"></i>
            <h5 class="card-title mb-0"><?= lang('adjustments_report') ?></h5>
        </div>
        <div class="card-datatable table-responsive">
            <table id="dmpData" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th><?= lang('date') ?></th>
                        <th><?= lang('reference_no') ?></th>
                        <th><?= lang('warehouse') ?></th>
                        <th><?= lang('created_by') ?></th>
                        <th><?= lang('note') ?></th>
                        <th><?= lang('products') ?></th>
                    </tr>
                </thead>
                <tbody><tr><td colspan="6" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td></tr></tbody>
                <tfoot class="dtFilter">
                    <tr><th></th><th></th><th></th><th></th><th></th><th><?= lang('products') ?></th></tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>

</div><!-- /.tab-content -->

<!-- DataTable Scripts -->
<script>
$(document).ready(function () {
    // Sales
    $('#SlRData').dataTable({
        "aaSorting": [[0, "desc"]],
        "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
        "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getSalesReport/?v=1&product=' . $product->id) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        'fnRowCallback': function (nRow, aData) { nRow.id = aData[9]; nRow.className = (aData[5] > 0) ? "invoice_link2" : "invoice_link2 warning"; return nRow; },
        "aoColumns": [{"mRender": fld}, null, null, null, {"bSearchable": false, "mRender": pqFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}]
    }).fnSetFilteringDelay();

    // Quotes
    $('#QuRData').dataTable({
        "aaSorting": [[0, "desc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getQuotesReport/?v=1&product=' . $product->id) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        'fnRowCallback': function (nRow, aData) { nRow.id = aData[7]; nRow.className = "quote_link2"; return nRow; },
        "aoColumns": [{"mRender": fld}, null, null, null, {"bSearchable": false, "mRender": pqFormat}, {"mRender": currencyFormat}, {"mRender": row_status}]
    }).fnSetFilteringDelay();

    <?php if ($product->type == 'standard'): ?>
    // Purchases
    $('#PoRData').dataTable({
        "aaSorting": [[0, "desc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getPurchasesReport/?v=1&product=' . $product->id) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        'fnRowCallback': function (nRow, aData) { nRow.id = aData[9]; nRow.className = (aData[5] > 0) ? "purchase_link2" : "purchase_link2 warning"; return nRow; },
        "aoColumns": [{"mRender": fld}, null, null, null, {"bSearchable": false, "mRender": pqFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}]
    }).fnSetFilteringDelay();

    // Transfers
    $('#TrRData').dataTable({
        "aaSorting": [[0, "desc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getTransfersReport/?v=1&product=' . $product->id) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        'fnRowCallback': function (nRow, aData) { nRow.id = aData[7]; nRow.className = "transfer_link2"; return nRow; },
        "aoColumns": [{"mRender": fld}, null, {"bSearchable": false, "mRender": pqFormat}, null, null, {"mRender": currencyFormat}, {"mRender": row_status}]
    }).fnSetFilteringDelay();

    // Adjustments
    $('#dmpData').dataTable({
        "aaSorting": [[0, "desc"]], "iDisplayLength": <?= $Settings->rows_per_page ?>,
        'bProcessing': true, 'bServerSide': true,
        'sAjaxSource': '<?= admin_url('reports/getAdjustmentReport/?v=1&product=' . $product->id) ?>',
        'fnServerData': function (sSource, aoData, fnCallback) {
            aoData.push({"name": "<?= $this->security->get_csrf_token_name() ?>", "value": "<?= $this->security->get_csrf_hash() ?>"});
            $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
        },
        "aoColumns": [{"mRender": fld}, null, null, null, {"mRender": decode_html}, {"bSortable": false, "mRender": pqFormat}],
        'fnRowCallback': function (nRow, aData) { nRow.id = aData[6]; nRow.className = "adjustment_link2"; return nRow; }
    }).fnSetFilteringDelay();
    <?php endif; ?>
});
</script>
<?php endif; ?>
