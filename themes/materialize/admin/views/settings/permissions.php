<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- Breadcrumb -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><?= lang('group_permissions') ?></h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url('dashboard') ?>"><?= lang('home') ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('system_settings') ?>"><?= lang('system_settings') ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('system_settings/user_groups') ?>"><?= lang('groups') ?></a></li>
                <li class="breadcrumb-item active"><?= lang('permissions') ?></li>
            </ol>
        </nav>
    </div>
</div>
<!-- / Breadcrumb -->

<?php if (!empty($p)): ?>
    <?php if ($p->group_id != 1): ?>

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center gap-2">
                <i class="icon-base ri ri-shield-keyhole-line icon-20px"></i>
                <h5 class="card-title mb-0">
                    <?= htmlspecialchars($group->description) ?> &mdash; <?= htmlspecialchars($group->name) ?>
                </h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-4"><?= lang('set_permissions') ?></p>

                <?= admin_form_open('system_settings/permissions/' . $id) ?>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th rowspan="2" class="align-middle" style="min-width:140px;"><?= lang('module_name') ?></th>
                                <th colspan="5" class="text-center"><?= lang('permissions') ?></th>
                            </tr>
                            <tr>
                                <th class="text-center" style="width:80px;"><?= lang('view') ?></th>
                                <th class="text-center" style="width:80px;"><?= lang('add') ?></th>
                                <th class="text-center" style="width:80px;"><?= lang('edit') ?></th>
                                <th class="text-center" style="width:80px;"><?= lang('delete') ?></th>
                                <th><?= lang('misc') ?></th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Products -->
                            <tr>
                                <td class="fw-medium"><?= lang('products') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="products-index" <?= $p->{'products-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="products-add" <?= $p->{'products-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="products-edit" <?= $p->{'products-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="products-delete" <?= $p->{'products-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="products-cost" name="products-cost" <?= $p->{'products-cost'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="products-cost"><?= lang('product_cost') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="products-price" name="products-price" <?= $p->{'products-price'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="products-price"><?= lang('product_price') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="products-adjustments" name="products-adjustments" <?= $p->{'products-adjustments'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="products-adjustments"><?= lang('adjustments') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="products-barcode" name="products-barcode" <?= $p->{'products-barcode'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="products-barcode"><?= lang('print_barcodes') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="products-stock_count" name="products-stock_count" <?= $p->{'products-stock_count'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="products-stock_count"><?= lang('stock_counts') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Sales -->
                            <tr>
                                <td class="fw-medium"><?= lang('sales') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="sales-index" <?= $p->{'sales-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="sales-add" <?= $p->{'sales-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="sales-edit" <?= $p->{'sales-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="sales-delete" <?= $p->{'sales-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="sales-email" name="sales-email" <?= $p->{'sales-email'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sales-email"><?= lang('email') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="sales-pdf" name="sales-pdf" <?= $p->{'sales-pdf'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sales-pdf"><?= lang('pdf') ?></label>
                                        </div>
                                        <?php if (POS): ?>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="pos-index" name="pos-index" <?= $p->{'pos-index'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="pos-index"><?= lang('pos') ?></label>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="sales-payments" name="sales-payments" <?= $p->{'sales-payments'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sales-payments"><?= lang('payments') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="sales-return_sales" name="sales-return_sales" <?= $p->{'sales-return_sales'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="sales-return_sales"><?= lang('return_sales') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Purchases -->
                            <tr>
                                <td class="fw-medium"><?= lang('purchases') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="purchases-index" <?= $p->{'purchases-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="purchases-add" <?= $p->{'purchases-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="purchases-edit" <?= $p->{'purchases-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="purchases-delete" <?= $p->{'purchases-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="purchases-email" name="purchases-email" <?= $p->{'purchases-email'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="purchases-email"><?= lang('email') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="purchases-pdf" name="purchases-pdf" <?= $p->{'purchases-pdf'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="purchases-pdf"><?= lang('pdf') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="purchases-payments" name="purchases-payments" <?= $p->{'purchases-payments'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="purchases-payments"><?= lang('payments') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="purchases-expenses" name="purchases-expenses" <?= $p->{'purchases-expenses'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="purchases-expenses"><?= lang('expenses') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="purchases-return_purchases" name="purchases-return_purchases" <?= $p->{'purchases-return_purchases'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="purchases-return_purchases"><?= lang('return_purchases') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Transfers -->
                            <tr>
                                <td class="fw-medium"><?= lang('transfers') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="transfers-index" <?= $p->{'transfers-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="transfers-add" <?= $p->{'transfers-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="transfers-edit" <?= $p->{'transfers-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="transfers-delete" <?= $p->{'transfers-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="transfers-email" name="transfers-email" <?= $p->{'transfers-email'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="transfers-email"><?= lang('email') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="transfers-pdf" name="transfers-pdf" <?= $p->{'transfers-pdf'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="transfers-pdf"><?= lang('pdf') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Returns -->
                            <tr>
                                <td class="fw-medium"><?= lang('returns') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="returns-index" <?= $p->{'returns-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="returns-add" <?= $p->{'returns-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="returns-edit" <?= $p->{'returns-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="returns-delete" <?= $p->{'returns-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="returns-email" name="returns-email" <?= $p->{'returns-email'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="returns-email"><?= lang('email') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="returns-pdf" name="returns-pdf" <?= $p->{'returns-pdf'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="returns-pdf"><?= lang('pdf') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Customers -->
                            <tr>
                                <td class="fw-medium"><?= lang('customers') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="customers-index" <?= $p->{'customers-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="customers-add" <?= $p->{'customers-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="customers-edit" <?= $p->{'customers-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="customers-delete" <?= $p->{'customers-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="customers-deposits" name="customers-deposits" <?= $p->{'customers-deposits'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="customers-deposits"><?= lang('deposits') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="customers-delete_deposit" name="customers-delete_deposit" <?= $p->{'customers-delete_deposit'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="customers-delete_deposit"><?= lang('delete_deposit') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Suppliers -->
                            <tr>
                                <td class="fw-medium"><?= lang('suppliers') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="suppliers-index" <?= $p->{'suppliers-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="suppliers-add" <?= $p->{'suppliers-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="suppliers-edit" <?= $p->{'suppliers-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="suppliers-delete" <?= $p->{'suppliers-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td></td>
                            </tr>

                            <!-- Reports -->
                            <tr>
                                <td class="fw-medium"><?= lang('reports') ?></td>
                                <td colspan="5">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-quantity_alerts" name="reports-quantity_alerts" <?= $p->{'reports-quantity_alerts'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-quantity_alerts"><?= lang('product_quantity_alerts') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-expiry_alerts" name="reports-expiry_alerts" <?= $p->{'reports-expiry_alerts'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-expiry_alerts"><?= lang('product_expiry_alerts') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-products" name="reports-products" <?= $p->{'reports-products'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-products"><?= lang('products') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-daily_sales" name="reports-daily_sales" <?= $p->{'reports-daily_sales'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-daily_sales"><?= lang('daily_sales') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-monthly_sales" name="reports-monthly_sales" <?= $p->{'reports-monthly_sales'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-monthly_sales"><?= lang('monthly_sales') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-sales" name="reports-sales" <?= $p->{'reports-sales'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-sales"><?= lang('sales') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-payments" name="reports-payments" <?= $p->{'reports-payments'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-payments"><?= lang('payments') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-tax" name="reports-tax" <?= $p->{'reports-tax'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-tax"><?= lang('tax_report') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-expenses" name="reports-expenses" <?= $p->{'reports-expenses'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-expenses"><?= lang('expenses') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-daily_purchases" name="reports-daily_purchases" <?= $p->{'reports-daily_purchases'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-daily_purchases"><?= lang('daily_purchases') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-monthly_purchases" name="reports-monthly_purchases" <?= $p->{'reports-monthly_purchases'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-monthly_purchases"><?= lang('monthly_purchases') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-purchases" name="reports-purchases" <?= $p->{'reports-purchases'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-purchases"><?= lang('purchases') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-customers" name="reports-customers" <?= $p->{'reports-customers'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-customers"><?= lang('customers') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-suppliers" name="reports-suppliers" <?= $p->{'reports-suppliers'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-suppliers"><?= lang('suppliers') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="reports-staff" name="reports-staff" <?= $p->{'reports-staff'} ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="reports-staff"><?= lang('staff') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <!-- Calendar -->
                            <tr>
                                <td class="fw-medium"><?= lang('calendar') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="calendar-index" <?= $p->{'calendar-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="calendar-add" <?= $p->{'calendar-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="calendar-edit" <?= $p->{'calendar-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="calendar-delete" <?= $p->{'calendar-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td></td>
                            </tr>

                            <!-- Settings -->
                            <tr>
                                <td class="fw-medium"><?= lang('system_settings') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="system_settings-index" <?= $p->{'system_settings-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="system_settings-add" <?= $p->{'system_settings-add'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="system_settings-edit" <?= $p->{'system_settings-edit'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="system_settings-delete" <?= $p->{'system_settings-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td></td>
                            </tr>

                            <!-- Notifications -->
                            <tr>
                                <td class="fw-medium"><?= lang('notifications') ?></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="notifications-index" <?= $p->{'notifications-index'} ? 'checked' : '' ?>>
                                </td>
                                <td class="text-center"></td>
                                <td class="text-center"></td>
                                <td class="text-center">
                                    <input type="checkbox" value="1" class="form-check-input" name="notifications-delete" <?= $p->{'notifications-delete'} ? 'checked' : '' ?>>
                                </td>
                                <td></td>
                            </tr>

                            <!-- Misc -->
                            <tr>
                                <td class="fw-medium"><?= lang('misc') ?></td>
                                <td colspan="5">
                                    <div class="d-flex flex-wrap gap-3">
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="bulk_actions" name="bulk_actions" <?= $p->bulk_actions ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="bulk_actions"><?= lang('bulk_actions') ?></label>
                                        </div>
                                        <div class="form-check form-check-inline mb-0">
                                            <input type="checkbox" value="1" class="form-check-input" id="edit_price" name="edit_price" <?= $p->edit_price ? 'checked' : '' ?>>
                                            <label class="form-check-label" for="edit_price"><?= lang('edit_price_on_sale') ?></label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="<?= admin_url('system_settings/user_groups') ?>" class="btn btn-label-secondary me-2">
                        <?= lang('cancel') ?>
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="icon-base ri ri-save-line icon-20px me-1"></i><?= lang('update') ?>
                    </button>
                </div>

                <?= form_close() ?>
            </div>
        </div>

    <?php else: ?>

        <div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
            <i class="icon-base ri ri-shield-keyhole-line icon-20px flex-shrink-0"></i>
            <div><?= lang('group_x_allowed') ?></div>
        </div>

    <?php endif; ?>
<?php else: ?>

    <div class="alert alert-warning d-flex align-items-center gap-2" role="alert">
        <i class="icon-base ri ri-shield-keyhole-line icon-20px flex-shrink-0"></i>
        <div><?= lang('group_x_allowed') ?></div>
    </div>

<?php endif; ?>
