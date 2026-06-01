<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-4">
                <?php echo $page_title; ?>
            </h4>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-warning alert-dismissible mb-4" role="alert">
        <div><?php echo $message; ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="row g-4">
        <!-- Product Reports -->
        <div class="col-sm-6 col-md-4 col-xl-3">
            <a href="<?php echo admin_url('reports/products'); ?>" class="card card-hover-shadow h-100 text-decoration-none">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <div class="avatar-initial rounded-circle bg-label-primary">
                            <i class="ri-box-3-line ri-2x"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1"><?php echo $this->lang->line('product_reports'); ?></h5>
                    <p class="text-muted mb-0 small"><?php echo $this->lang->line('view_product_reports'); ?></p>
                </div>
            </a>
        </div>

        <?php $group1 = ['owner', 'admin', 'viewer', 'purchaser'];
        if ($this->ion_auth->in_group($group1)): ?>
        <!-- Purchase Reports -->
        <div class="col-sm-6 col-md-4 col-xl-3">
            <a href="<?php echo admin_url('reports/purchases'); ?>" class="card card-hover-shadow h-100 text-decoration-none">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <div class="avatar-initial rounded-circle bg-label-success">
                            <i class="ri-shopping-cart-line ri-2x"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1"><?php echo $this->lang->line('purchase_reports'); ?></h5>
                    <p class="text-muted mb-0 small"><?php echo $this->lang->line('view_purchase_reports'); ?></p>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <?php $group2 = ['owner', 'admin', 'viewer', 'salesman'];
        if ($this->ion_auth->in_group($group2)): ?>
        <!-- Sale Reports -->
        <div class="col-sm-6 col-md-4 col-xl-3">
            <a href="<?php echo admin_url('reports/sales'); ?>" class="card card-hover-shadow h-100 text-decoration-none">
                <div class="card-body text-center py-5">
                    <div class="avatar avatar-xl mx-auto mb-3">
                        <div class="avatar-initial rounded-circle bg-label-info">
                            <i class="ri-line-chart-line ri-2x"></i>
                        </div>
                    </div>
                    <h5 class="card-title mb-1"><?php echo $this->lang->line('sale_reports'); ?></h5>
                    <p class="text-muted mb-0 small"><?php echo $this->lang->line('view_sale_reports'); ?></p>
                </div>
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
