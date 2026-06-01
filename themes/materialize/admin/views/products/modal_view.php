<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <span class="icon-base ri ri-box-3-line me-1 icon-16px"></span>
                <?= $product->name . (SHOP && $product->hide != 1 ? ' <small class="text-muted">(' . lang('shop_views') . ': ' . $product->views . ')</small>' : ''); ?>
            </h5>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
                    <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
        <div class="modal-body">
            <div class="row g-4">
                <!-- Left: Image -->
                <div class="col-md-5">
                    <img id="pr-image"
                         src="<?= base_url() ?>assets/uploads/<?= $product->image ?>"
                         alt="<?= $product->name ?>"
                         class="img-fluid rounded border w-100" style="max-height:280px; object-fit:contain;" />

                    <?php if (!empty($images)): ?>
                    <div id="multiimages" class="d-flex flex-wrap gap-2 mt-3">
                        <a class="change_img border rounded p-1" href="<?= base_url() ?>assets/uploads/<?= $product->image ?>">
                            <img class="img-fluid" src="<?= base_url() ?>assets/uploads/thumbs/<?= $product->image ?>"
                                 style="width:<?= $Settings->twidth ?>px; height:<?= $Settings->theight ?>px; object-fit:cover;" />
                        </a>
                        <?php foreach ($images as $ph): ?>
                        <div class="position-relative gallery-image">
                            <a class="change_img border rounded p-1" href="<?= base_url() ?>assets/uploads/<?= $ph->photo ?>">
                                <img class="img-fluid" src="<?= base_url() ?>assets/uploads/thumbs/<?= $ph->photo ?>"
                                     style="width:<?= $Settings->twidth ?>px; height:<?= $Settings->theight ?>px; object-fit:cover;" />
                            </a>
                            <?php if ($Owner || $Admin || $GP['products-edit']): ?>
                            <a href="#" class="delimg position-absolute top-0 end-0 text-danger" data-item-id="<?= $ph->id ?>">
                                <span class="icon-base ri ri-close-line icon-16px"></span>
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Right: Details -->
                <div class="col-md-7">
                    <div class="table-responsive">
                        <table class="table table-sm table-borderless">
                            <tbody>
                                <tr>
                                    <td class="fw-semibold text-muted" style="width:35%;"><?= lang('barcode_qrcode'); ?></td>
                                    <td>
                                        <img src="<?= admin_url('misc/barcode/' . $product->code . '/' . $product->barcode_symbology . '/60/0'); ?>" alt="<?= $product->code; ?>" class="bcimg" />
                                        <?= $this->sma->qrcode('link', urlencode(admin_url('products/view/' . $product->id)), 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('type'); ?></td>
                                    <td><?= lang($product->type); ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('name'); ?></td>
                                    <td><?= $product->name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('code'); ?></td>
                                    <td><code><?= $product->code; ?></code></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('category'); ?></td>
                                    <td><?= $category->name; ?></td>
                                </tr>
                                <?php if ($product->subcategory_id): ?>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('subcategory'); ?></td>
                                    <td><?= $subcategory->name; ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('brand'); ?></td>
                                    <td><?= $brand ? $brand->name : '&mdash;'; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('unit'); ?></td>
                                    <td><?= $unit ? $unit->name . ' (' . $unit->code . ')' : '&mdash;'; ?></td>
                                </tr>
                                <?php
                                if ($Owner || $Admin) {
                                    echo '<tr><td class="fw-semibold text-muted">' . lang('cost') . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                                    echo '<tr><td class="fw-semibold text-muted">' . lang('price') . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                                    if ($product->promotion) {
                                        echo '<tr><td class="fw-semibold text-muted">' . lang('promotion') . '</td><td>' . $this->sma->formatMoney($product->promo_price) . ' <small class="text-muted">(' . $this->sma->hrsd($product->start_date) . ' &mdash; ' . $this->sma->hrsd($product->end_date) . ')</small></td></tr>';
                                    }
                                } else {
                                    if ($this->session->userdata('show_cost')) {
                                        echo '<tr><td class="fw-semibold text-muted">' . lang('cost') . '</td><td>' . $this->sma->formatMoney($product->cost) . '</td></tr>';
                                    }
                                    if ($this->session->userdata('show_price')) {
                                        echo '<tr><td class="fw-semibold text-muted">' . lang('price') . '</td><td>' . $this->sma->formatMoney($product->price) . '</td></tr>';
                                        if ($product->promotion) {
                                            echo '<tr><td class="fw-semibold text-muted">' . lang('promotion') . '</td><td>' . $this->sma->formatMoney($product->promo_price) . ' <small class="text-muted">(' . $this->sma->hrsd($product->start_date) . ' &mdash; ' . $this->sma->hrsd($product->end_date) . ')</small></td></tr>';
                                        }
                                    }
                                }
                                ?>
                                <?php if ($product->tax_rate): ?>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('tax_rate'); ?></td>
                                    <td><?= $tax_rate->name; ?></td>
                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('tax_method'); ?></td>
                                    <td><?= $product->tax_method == 0 ? lang('inclusive') : lang('exclusive'); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($product->alert_quantity != 0): ?>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('alert_quantity'); ?></td>
                                    <td><?= $this->sma->formatQuantity($product->alert_quantity); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php if ($variants): ?>
                                <tr>
                                    <td class="fw-semibold text-muted"><?= lang('product_variants'); ?></td>
                                    <td>
                                        <?php foreach ($variants as $variant): ?>
                                        <span class="badge bg-label-info me-1"><?= $variant->name ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Custom fields -->
            <?php if ($product->cf1 || $product->cf2 || $product->cf3 || $product->cf4 || $product->cf5 || $product->cf6): ?>
            <div class="mt-4">
                <h6 class="fw-bold mb-2"><?= lang('custom_fields') ?></h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th><?= lang('custom_field') ?></th>
                                <th><?= lang('value') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $cfs = ['cf1'=>'pcf1','cf2'=>'pcf2','cf3'=>'pcf3','cf4'=>'pcf4','cf5'=>'pcf5','cf6'=>'pcf6'];
                            foreach ($cfs as $cf => $lk):
                                if ($product->$cf): ?>
                            <tr><td><?= lang($lk) ?></td><td><?= $product->$cf ?></td></tr>
                                <?php endif;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Warehouse stock -->
            <?php if ((!$Supplier || !$Customer) && !empty($warehouses) && $product->type == 'standard'): ?>
            <div class="mt-4">
                <h6 class="fw-bold mb-2"><?= lang('warehouse_quantity') ?></h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th><?= lang('warehouse_name') ?></th>
                                <th><?= lang('quantity') . ' (' . lang('rack') . ')'; ?></th>
                                <?php if ($Owner || $Admin || $this->session->userdata('show_cost')): ?>
                                <th><?= lang('avg_cost') ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($warehouses as $warehouse):
                                if ($warehouse->quantity != 0): ?>
                            <tr>
                                <td><?= $warehouse->name . ' (' . $warehouse->code . ')' ?></td>
                                <td><strong><?= $this->sma->formatQuantity($warehouse->quantity) ?></strong><?= $warehouse->rack ? ' <small class="text-muted">(' . $warehouse->rack . ')</small>' : '' ?></td>
                                <?php if ($Owner || $Admin || $this->session->userdata('show_cost')): ?>
                                <td><?= $warehouse->avg_cost ?></td>
                                <?php endif; ?>
                            </tr>
                                <?php endif;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Combo items -->
            <?php if ($product->type == 'combo'): ?>
            <div class="mt-4">
                <h6 class="fw-bold mb-2"><?= lang('combo_items') ?></h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th><?= lang('product_name') ?></th>
                                <th><?= lang('quantity') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($combo_items as $ci):
                                echo '<tr><td>' . $ci->name . ' (' . $ci->code . ')</td><td>' . $this->sma->formatQuantity($ci->qty) . '</td></tr>';
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Variant quantities -->
            <?php if (!empty($options)): ?>
            <div class="mt-4">
                <h6 class="fw-bold mb-2"><?= lang('product_variants_quantity') ?></h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th><?= lang('warehouse_name') ?></th>
                                <th><?= lang('product_variant') ?></th>
                                <th><?= lang('quantity') . ' (' . lang('rack') . ')'; ?></th>
                                <?php if ($Owner || $Admin): ?>
                                <th><?= lang('price_addition') ?></th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($options as $option):
                                if ($option->wh_qty != 0): ?>
                            <tr>
                                <td><?= $option->wh_name ?></td>
                                <td><?= $option->name ?></td>
                                <td class="text-center"><?= $this->sma->formatQuantity($option->wh_qty) ?></td>
                                <?php if ($Owner || $Admin): ?>
                                <td class="text-end"><?= $this->sma->formatMoney($option->price) ?></td>
                                <?php endif; ?>
                            </tr>
                                <?php endif;
                            endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>

            <!-- Product details panels -->
            <?php if ($product->details): ?>
            <div class="card border-success mt-4">
                <div class="card-header bg-label-success">
                    <span class="icon-base ri ri-file-text-line me-1 icon-16px"></span><?= lang('product_details_for_invoice') ?>
                </div>
                <div class="card-body"><?= $product->details ?></div>
            </div>
            <?php endif; ?>
            <?php if ($product->product_details): ?>
            <div class="card border-primary mt-3">
                <div class="card-header bg-label-info">
                    <span class="icon-base ri ri-information-line me-1 icon-16px"></span><?= lang('product_details') ?>
                </div>
                <div class="card-body"><?= $product->product_details ?></div>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!$Supplier || !$Customer): ?>
        <div class="modal-footer justify-content-start gap-2 flex-wrap">
            <a href="<?= admin_url('products/print_barcodes/' . $product->id) ?>" class="btn btn-sm btn-outline-secondary">
                <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print_barcode_label') ?>
            </a>
            <a href="<?= admin_url('products/pdf/' . $product->id) ?>" class="btn btn-sm btn-outline-secondary">
                <span class="icon-base ri ri-download-line me-1 icon-16px"></span><?= lang('pdf') ?>
            </a>
            <a href="<?= admin_url('products/edit/' . $product->id) ?>" class="btn btn-sm btn-warning">
                <span class="icon-base ri ri-pencil-line me-1 icon-16px"></span><?= lang('edit') ?>
            </a>
            <a href="<?= admin_url('products/delete/' . $product->id) ?>" class="btn btn-sm btn-danger"
               onclick="return confirm('<?= lang('r_u_sure') ?>')">
                <span class="icon-base ri ri-delete-bin-line me-1 icon-16px"></span><?= lang('delete') ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<script>
$(document).ready(function() {
    $('.change_img').on('click', function(e) {
        e.preventDefault();
        $('#pr-image').attr('src', $(this).attr('href'));
    });
});
</script>
