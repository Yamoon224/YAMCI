<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!doctype html>
<html
  lang="en"
  class="layout-navbar-fixed layout-menu-fixed layout-compact customizer-hide"
  dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>"
  data-skin="default"
  data-bs-theme="light"
  data-assets-path="<?= base_url('themes/materialize/admin/assets/'); ?>"
  data-template="vertical-menu-template-semi-dark">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title><?= $page_title; ?> - <?= $Settings->site_name; ?></title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="<?= base_url('assets/images/logo.png'); ?>" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

  <!-- Icons -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/fonts/iconify-icons.css'); ?>" />

  <!-- Node Waves -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/node-waves/node-waves.css'); ?>" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/css/core.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/css/demo.css'); ?>" />

  <!-- Vendor Libraries -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/select2/select2.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/flatpickr/flatpickr.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/libs/sweetalert2/sweetalert2.css'); ?>" />

  <!-- RTL overrides -->
  <?php if ($Settings->user_rtl): ?>
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/vendor/css/rtl/core.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/css/demo.css'); ?>" />
  <?php endif; ?>

  <!-- SMA Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('themes/materialize/admin/assets/css/sma-custom.css'); ?>?v=20260529c" />
  <link rel="stylesheet" href="<?= base_url('assets/custom/custom.css'); ?>" />

  <!-- Page-specific CSS dynamique -->
  <?php if (isset($meta['css'])) { echo $meta['css']; } ?>

  <!-- Helpers JS (must be in <head>) -->
  <script src="<?= base_url('themes/materialize/admin/assets/vendor/js/helpers.js'); ?>"></script>
  <!--! Template config (template-customizer.js NOT loaded — displayCustomizer disabled, Pickr not needed) -->
  <script src="<?= base_url('themes/materialize/admin/assets/js/config.js'); ?>"></script>
  <!-- jQuery en <head> pour que les scripts inline des vues ($(document).ready) fonctionnent -->
  <script src="<?= base_url('themes/materialize/admin/assets/vendor/libs/jquery/jquery.js'); ?>"></script>
</head>

<body>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
  <div class="layout-container">

    <!-- ===== MENU SIDEBAR ===== -->
    <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">

      <!-- Logo / Brand -->
      <div class="app-brand demo">
        <a href="<?= admin_url('welcome'); ?>" class="app-brand-link">
          <img src="<?= base_url('assets/images/logo.png'); ?>"
               alt="<?= htmlspecialchars($Settings->site_name); ?>"
               style="max-height:38px; max-width:150px; width:auto; object-fit:contain;" />
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M8.47365 11.7183C8.11707 12.0749 8.11707 12.6531 8.47365 13.0097L12.071 16.607C12.4615 16.9975 12.4615 17.6305 12.071 18.021C11.6805 18.4115 11.0475 18.4115 10.657 18.021L5.83009 13.1941C5.37164 12.7356 5.37164 11.9924 5.83009 11.5339L10.657 6.707C11.0475 6.31653 11.6805 6.31653 12.071 6.707C12.4615 7.09747 12.4615 7.73053 12.071 8.121L8.47365 11.7183Z" fill-opacity="0.9"/>
            <path d="M14.3584 11.8336C14.0654 12.1266 14.0654 12.6014 14.3584 12.8944L18.071 16.607C18.4615 16.9975 18.4615 17.6305 18.071 18.021C17.6805 18.4115 17.0475 18.4115 16.657 18.021L11.6819 13.0459C11.3053 12.6693 11.3053 12.0587 11.6819 11.6821L16.657 6.707C17.0475 6.31653 17.6805 6.31653 18.071 6.707C18.4615 7.09747 18.4615 7.73053 18.071 8.121L14.3584 11.8336Z" fill-opacity="0.4"/>
          </svg>
        </a>
      </div>

      <div class="menu-inner-shadow"></div>

      <!-- Navigation items -->
      <ul class="menu-inner py-1">

        <!-- Dashboard -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'welcome' || $this->uri->segment(2) == '') ? 'active' : ''; ?>">
          <a href="<?= admin_url('welcome'); ?>" class="menu-link">
            <i class="menu-icon icon-base ri ri-home-smile-line"></i>
            <div data-i18n="Dashboard"><?= lang('dashboard'); ?></div>
          </a>
        </li>

        <!-- ==================== SECTION : OPERATIONS ==================== -->
        <li class="menu-header small text-uppercase">
          <span class="menu-header-text"><?= lang('operations'); ?></span>
        </li>

        <?php if ($Owner || $Admin || $GP['products-index'] || $GP['products-add'] || $GP['products-barcode'] || $GP['products-adjustments'] || $GP['products-stock_count']): ?>
        <!-- Products -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'products') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-archive-line"></i>
            <div data-i18n="Products"><?= lang('products'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'products' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products'); ?>" class="menu-link">
                <div><?= lang('list_products'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['products-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(2) == 'products' && $this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/add'); ?>" class="menu-link">
                <div><?= lang('add_product'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'import_csv') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/import_csv'); ?>" class="menu-link">
                <div><?= lang('import_products'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['products-barcode']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'print_barcodes') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/print_barcodes'); ?>" class="menu-link">
                <div><?= lang('print_barcode_label'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['products-adjustments']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'quantity_adjustments') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/quantity_adjustments'); ?>" class="menu-link">
                <div><?= lang('quantity_adjustments'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add_adjustment') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/add_adjustment'); ?>" class="menu-link">
                <div><?= lang('add_adjustment'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['products-stock_count']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'stock_counts') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/stock_counts'); ?>" class="menu-link">
                <div><?= lang('stock_counts'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'count_stock') ? 'active' : ''; ?>">
              <a href="<?= admin_url('products/count_stock'); ?>" class="menu-link">
                <div><?= lang('count_stock'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if ($Owner || $Admin || $GP['sales-index'] || $GP['sales-add'] || $GP['sales-deliveries'] || $GP['sales-gift_cards']): ?>
        <!-- Sales -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'sales' || $this->uri->segment(2) == 'pos') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-shopping-cart-line"></i>
            <div data-i18n="Sales"><?= lang('sales'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'sales' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('sales'); ?>" class="menu-link">
                <div><?= lang('list_sales'); ?></div>
              </a>
            </li>
            <?php if (POS && ($Owner || $Admin || $GP['pos-index'])): ?>
            <li class="menu-item <?= ($this->uri->segment(2) == 'pos' && $this->uri->segment(3) == 'sales') ? 'active' : ''; ?>">
              <a href="<?= admin_url('pos/sales'); ?>" class="menu-link">
                <div><?= lang('pos_sales'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['sales-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(2) == 'sales' && $this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('sales/add'); ?>" class="menu-link">
                <div><?= lang('add_sale'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'sale_by_csv') ? 'active' : ''; ?>">
              <a href="<?= admin_url('sales/sale_by_csv'); ?>" class="menu-link">
                <div><?= lang('add_sale_by_csv'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['sales-deliveries']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'deliveries') ? 'active' : ''; ?>">
              <a href="<?= admin_url('sales/deliveries'); ?>" class="menu-link">
                <div><?= lang('deliveries'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['sales-gift_cards']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'gift_cards') ? 'active' : ''; ?>">
              <a href="<?= admin_url('sales/gift_cards'); ?>" class="menu-link">
                <div><?= lang('gift_cards'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if ($Owner || $Admin || $GP['quotes-index'] || $GP['quotes-add']): ?>
        <!-- Quotes -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'quotes') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-file-list-3-line"></i>
            <div data-i18n="Quotes"><?= lang('quotes'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'quotes' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('quotes'); ?>" class="menu-link">
                <div><?= lang('list_quotes'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['quotes-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('quotes/add'); ?>" class="menu-link">
                <div><?= lang('add_quote'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if ($Owner || $Admin || $GP['purchases-index'] || $GP['purchases-add'] || $GP['purchases-expenses']): ?>
        <!-- Purchases -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'purchases') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-shopping-bag-line"></i>
            <div data-i18n="Purchases"><?= lang('purchases'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'purchases' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('purchases'); ?>" class="menu-link">
                <div><?= lang('list_purchases'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['purchases-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('purchases/add'); ?>" class="menu-link">
                <div><?= lang('add_purchase'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'purchase_by_csv') ? 'active' : ''; ?>">
              <a href="<?= admin_url('purchases/purchase_by_csv'); ?>" class="menu-link">
                <div><?= lang('add_purchase_by_csv'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['purchases-expenses']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'expenses') ? 'active' : ''; ?>">
              <a href="<?= admin_url('purchases/expenses'); ?>" class="menu-link">
                <div><?= lang('list_expenses'); ?></div>
              </a>
            </li>
            <li class="menu-item">
              <a href="<?= admin_url('purchases/add_expense'); ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal">
                <div><?= lang('add_expense'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if ($Owner || $Admin || $GP['transfers-index'] || $GP['transfers-add']): ?>
        <!-- Transfers -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'transfers') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-exchange-line"></i>
            <div data-i18n="Transfers"><?= lang('transfers'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'transfers' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('transfers'); ?>" class="menu-link">
                <div><?= lang('list_transfers'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['transfers-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('transfers/add'); ?>" class="menu-link">
                <div><?= lang('add_transfer'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'transfer_by_csv') ? 'active' : ''; ?>">
              <a href="<?= admin_url('transfers/transfer_by_csv'); ?>" class="menu-link">
                <div><?= lang('add_transfer_by_csv'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <?php if ($Owner || $Admin || $GP['returns-index'] || $GP['returns-add']): ?>
        <!-- Returns -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'returns') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-arrow-go-back-line"></i>
            <div data-i18n="Returns"><?= lang('returns'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'returns' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('returns'); ?>" class="menu-link">
                <div><?= lang('list_returns'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['returns-add']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add') ? 'active' : ''; ?>">
              <a href="<?= admin_url('returns/add'); ?>" class="menu-link">
                <div><?= lang('add_return'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <!-- POS (direct link, visible only if module is active) -->
        <?php if (POS && ($Owner || $Admin || $GP['pos-index'])): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'pos' && $this->uri->segment(3) != 'sales') ? 'active' : ''; ?>">
          <a href="<?= admin_url('pos'); ?>" class="menu-link">
            <i class="menu-icon icon-base ri ri-layout-grid-line"></i>
            <div data-i18n="POS"><?= lang('pos'); ?></div>
          </a>
        </li>
        <?php endif; ?>

        <!-- ==================== SECTION : PEOPLE ==================== -->
        <?php if ($Owner || $Admin || $GP['customers-index'] || $GP['customers-add'] || $GP['suppliers-index'] || $GP['suppliers-add']): ?>
        <li class="menu-header small text-uppercase">
          <span class="menu-header-text"><?= lang('people'); ?></span>
        </li>

        <!-- Users (Owner only) -->
        <?php if ($Owner): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'users') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-user-settings-line"></i>
            <div data-i18n="Users"><?= lang('users'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'users' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('users'); ?>" class="menu-link">
                <div><?= lang('list_users'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'create_user') ? 'active' : ''; ?>">
              <a href="<?= admin_url('users/create_user'); ?>" class="menu-link">
                <div><?= lang('new_user'); ?></div>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Customers -->
        <?php if ($Owner || $Admin || $GP['customers-index'] || $GP['customers-add']): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'customers') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-group-line"></i>
            <div data-i18n="Customers"><?= lang('customers'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'customers' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('customers'); ?>" class="menu-link">
                <div><?= lang('list_customers'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['customers-add']): ?>
            <li class="menu-item">
              <a href="<?= admin_url('customers/add'); ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal">
                <div><?= lang('add_customer'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Suppliers -->
        <?php if ($Owner || $Admin || $GP['suppliers-index'] || $GP['suppliers-add']): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'suppliers') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-truck-line"></i>
            <div data-i18n="Suppliers"><?= lang('suppliers'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'suppliers' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('suppliers'); ?>" class="menu-link">
                <div><?= lang('list_suppliers'); ?></div>
              </a>
            </li>
            <?php if ($Owner || $Admin || $GP['suppliers-add']): ?>
            <li class="menu-item">
              <a href="<?= admin_url('suppliers/add'); ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal">
                <div><?= lang('add_supplier'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Billers (Owner only) -->
        <?php if ($Owner): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'billers') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-building-line"></i>
            <div data-i18n="Billers"><?= lang('billers'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'billers' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('billers'); ?>" class="menu-link">
                <div><?= lang('list_billers'); ?></div>
              </a>
            </li>
            <li class="menu-item">
              <a href="<?= admin_url('billers/add'); ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal">
                <div><?= lang('add_biller'); ?></div>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <?php endif; // end people section ?>

        <!-- ==================== SECTION : ANALYTICS ==================== -->
        <?php if ($Owner || $Admin || $GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts'] || $GP['reports-products'] || $GP['reports-monthly_sales'] || $GP['reports-sales'] || $GP['reports-payments'] || $GP['reports-purchases'] || $GP['reports-customers'] || $GP['reports-suppliers'] || $GP['reports-staff'] || $GP['reports-expenses']): ?>
        <li class="menu-header small text-uppercase">
          <span class="menu-header-text"><?= lang('analytics'); ?></span>
        </li>

        <!-- Reports -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'reports') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-bar-chart-line"></i>
            <div data-i18n="Reports"><?= lang('reports'); ?></div>
          </a>
          <ul class="menu-sub">
            <?php if ($Owner || $Admin || $GP['reports-products']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'best_sellers') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/best_sellers'); ?>" class="menu-link">
                <div><?= lang('best_sellers'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-quantity_alerts']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'quantity_alerts') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/quantity_alerts'); ?>" class="menu-link">
                <div><?= lang('product_quantity_alerts'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if (($Owner || $Admin || $GP['reports-expiry_alerts']) && $Settings->product_expiry): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'expiry_alerts') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/expiry_alerts'); ?>" class="menu-link">
                <div><?= lang('product_expiry_alerts'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-products']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'products') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/products'); ?>" class="menu-link">
                <div><?= lang('products_report'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'adjustments') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/adjustments'); ?>" class="menu-link">
                <div><?= lang('adjustments_report'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'categories') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/categories'); ?>" class="menu-link">
                <div><?= lang('categories_report'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'brands') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/brands'); ?>" class="menu-link">
                <div><?= lang('brands_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-daily_sales']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'daily_sales') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/daily_sales'); ?>" class="menu-link">
                <div><?= lang('daily_sales'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-monthly_sales']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'monthly_sales') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/monthly_sales'); ?>" class="menu-link">
                <div><?= lang('monthly_sales'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-sales']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'sales') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/sales'); ?>" class="menu-link">
                <div><?= lang('sales_report'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'returns') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/returns'); ?>" class="menu-link">
                <div><?= lang('returns_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-payments']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'payments') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/payments'); ?>" class="menu-link">
                <div><?= lang('payments_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-tax']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'tax') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/tax'); ?>" class="menu-link">
                <div><?= lang('tax_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'profit_loss') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/profit_loss'); ?>" class="menu-link">
                <div><?= lang('profit_and_loss'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-daily_purchases']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'daily_purchases') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/daily_purchases'); ?>" class="menu-link">
                <div><?= lang('daily_purchases'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-monthly_purchases']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'monthly_purchases') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/monthly_purchases'); ?>" class="menu-link">
                <div><?= lang('monthly_purchases'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-purchases']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'purchases') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/purchases'); ?>" class="menu-link">
                <div><?= lang('purchases_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-expenses']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'expenses') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/expenses'); ?>" class="menu-link">
                <div><?= lang('expenses_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-customers']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'customers') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/customers'); ?>" class="menu-link">
                <div><?= lang('customers_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-suppliers']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'suppliers') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/suppliers'); ?>" class="menu-link">
                <div><?= lang('suppliers_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <?php if ($Owner || $Admin || $GP['reports-staff']): ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'users') ? 'active' : ''; ?>">
              <a href="<?= admin_url('reports/users'); ?>" class="menu-link">
                <div><?= lang('staff_report'); ?></div>
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </li>
        <?php endif; // end analytics section ?>

        <!-- Calendar (accessible to all) -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'calendar') ? 'active' : ''; ?>">
          <a href="<?= admin_url('calendar'); ?>" class="menu-link">
            <i class="menu-icon icon-base ri ri-calendar-line"></i>
            <div data-i18n="Calendar"><?= lang('calendar'); ?></div>
          </a>
        </li>

        <!-- Notifications (accessible to all) -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'notifications') ? 'active' : ''; ?>">
          <a href="<?= admin_url('notifications'); ?>" class="menu-link">
            <i class="menu-icon icon-base ri ri-notification-3-line"></i>
            <div data-i18n="Notifications"><?= lang('notifications'); ?></div>
            <?php if ($info && count($info) > 0): ?>
            <div class="badge badge-center text-bg-danger rounded-pill ms-auto"><?= count($info); ?></div>
            <?php endif; ?>
          </a>
        </li>

        <!-- ==================== SECTION : ADMINISTRATION (Owner only) ==================== -->
        <?php if ($Owner): ?>
        <li class="menu-header small text-uppercase">
          <span class="menu-header-text"><?= lang('settings'); ?></span>
        </li>

        <!-- System Settings -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'system_settings') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-settings-3-line"></i>
            <div data-i18n="System Settings"><?= lang('system_settings'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'system_settings' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings'); ?>" class="menu-link">
                <div><?= lang('general_settings'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'change_logo') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/change_logo'); ?>" class="menu-link" data-bs-toggle="modal" data-bs-target="#myModal">
                <div><?= lang('change_logo'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'currencies') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/currencies'); ?>" class="menu-link">
                <div><?= lang('currencies'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'customer_groups') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/customer_groups'); ?>" class="menu-link">
                <div><?= lang('customer_groups'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'price_groups') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/price_groups'); ?>" class="menu-link">
                <div><?= lang('price_groups'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'categories') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/categories'); ?>" class="menu-link">
                <div><?= lang('categories'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'expense_categories') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/expense_categories'); ?>" class="menu-link">
                <div><?= lang('expense_categories'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'units') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/units'); ?>" class="menu-link">
                <div><?= lang('units'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'brands') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/brands'); ?>" class="menu-link">
                <div><?= lang('brands'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'variants') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/variants'); ?>" class="menu-link">
                <div><?= lang('variants'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'tax_rates') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/tax_rates'); ?>" class="menu-link">
                <div><?= lang('tax_rates'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'warehouses') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/warehouses'); ?>" class="menu-link">
                <div><?= lang('warehouses'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'email_templates') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/email_templates'); ?>" class="menu-link">
                <div><?= lang('email_templates'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'user_groups') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/user_groups'); ?>" class="menu-link">
                <div><?= lang('group_permissions'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'backups') ? 'active' : ''; ?>">
              <a href="<?= admin_url('system_settings/backups'); ?>" class="menu-link">
                <div><?= lang('backups'); ?></div>
              </a>
            </li>
          </ul>
        </li>

        <?php if (POS): ?>
        <!-- POS Settings -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'pos' && in_array($this->uri->segment(3), ['settings', 'printers', 'add_printer', 'registers'])) ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-layout-grid-line"></i>
            <div data-i18n="POS Settings"><?= lang('pos_settings'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(3) == 'settings') ? 'active' : ''; ?>">
              <a href="<?= admin_url('pos/settings'); ?>" class="menu-link">
                <div><?= lang('pos_settings'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(2) == 'promos') ? 'active' : ''; ?>">
              <a href="<?= admin_url('promos'); ?>" class="menu-link">
                <div><?= lang('promos'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'printers') ? 'active' : ''; ?>">
              <a href="<?= admin_url('pos/printers'); ?>" class="menu-link">
                <div><?= lang('list_printers'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add_printer') ? 'active' : ''; ?>">
              <a href="<?= admin_url('pos/add_printer'); ?>" class="menu-link">
                <div><?= lang('add_printer'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'registers') ? 'active' : ''; ?>">
              <a href="<?= admin_url('pos/registers'); ?>" class="menu-link">
                <div><?= lang('list_open_registers'); ?></div>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Shop / API Settings (if shop module is present) -->
        <?php if (SHOP && file_exists(APPPATH . 'controllers' . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'Shop.php')): ?>
        <li class="menu-item <?= ($this->uri->segment(2) == 'shop_settings' || $this->uri->segment(2) == 'api_settings') ? 'open active' : ''; ?>">
          <a href="javascript:void(0);" class="menu-link menu-toggle">
            <i class="menu-icon icon-base ri ri-shopping-cart-2-line"></i>
            <div data-i18n="Front End"><?= lang('front_end'); ?></div>
          </a>
          <ul class="menu-sub">
            <li class="menu-item <?= ($this->uri->segment(2) == 'shop_settings' && $this->uri->segment(3) == '') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings'); ?>" class="menu-link">
                <div><?= lang('shop_settings'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'slider') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/slider'); ?>" class="menu-link">
                <div><?= lang('slider_settings'); ?></div>
              </a>
            </li>
            <?php if ($Settings->apis): ?>
            <li class="menu-item <?= ($this->uri->segment(2) == 'api_settings') ? 'active' : ''; ?>">
              <a href="<?= admin_url('api_settings'); ?>" class="menu-link">
                <div><?= lang('api_keys'); ?></div>
              </a>
            </li>
            <?php endif; ?>
            <li class="menu-item <?= ($this->uri->segment(3) == 'pages') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/pages'); ?>" class="menu-link">
                <div><?= lang('list_pages'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'add_page') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/add_page'); ?>" class="menu-link">
                <div><?= lang('add_page'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'sms_settings') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/sms_settings'); ?>" class="menu-link">
                <div><?= lang('sms_settings'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'send_sms') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/send_sms'); ?>" class="menu-link">
                <div><?= lang('send_sms'); ?></div>
              </a>
            </li>
            <li class="menu-item <?= ($this->uri->segment(3) == 'sms_log') ? 'active' : ''; ?>">
              <a href="<?= admin_url('shop_settings/sms_log'); ?>" class="menu-link">
                <div><?= lang('sms_log'); ?></div>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>

        <!-- Activity Log -->
        <li class="menu-item <?= ($this->uri->segment(2) == 'site_logs') ? 'active' : ''; ?>">
          <a href="<?= admin_url('site_logs'); ?>" class="menu-link">
            <i class="menu-icon icon-base ri ri-file-text-line"></i>
            <div data-i18n="Activity Log"><?= lang('site_logs'); ?></div>
          </a>
        </li>
        <?php endif; // end Owner administration section ?>

      </ul>
    </aside>
    <!-- /Menu Sidebar -->

    <!-- Layout page -->
    <div class="layout-page">

      <!-- ===== NAVBAR ===== -->
      <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">

        <!-- Mobile menu toggle -->
        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
          <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="ri-menu-line ri-xl"></i>
          </a>
        </div>

        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

          <!-- Left side: empty (breadcrumb is in page content) -->
          <div class="me-auto"></div>

          <!-- Right side: actions -->
          <ul class="navbar-nav flex-row align-items-center ms-auto">

            <!-- Shop link -->
            <?php if (SHOP): ?>
            <li class="nav-item me-2 me-xl-0 d-none d-xl-block">
              <a class="nav-link" href="<?= base_url(); ?>" title="<?= lang('shop'); ?>">
                <i class="ri-shopping-cart-line ri-xl"></i>
              </a>
            </li>
            <?php endif; ?>

            <!-- Today's profit (Owner only) -->
            <?php if ($Owner): ?>
            <li class="nav-item me-2 me-xl-0">
              <a class="nav-link" href="<?= admin_url('reports/profit'); ?>" id="today_profit"
                 title="<?= lang('today_profit'); ?>" data-bs-toggle="modal" data-bs-target="#myModal">
                <i class="ri-funds-line ri-xl"></i>
              </a>
            </li>
            <?php endif; ?>

            <!-- Alerts -->
            <?php if (($Owner || $Admin || $GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts']) && ($qty_alert_num > 0 || $exp_alert_num > 0 || $shop_sale_alerts || $shop_payment_alerts)): ?>
            <li class="nav-item dropdown me-2 me-xl-0">
              <a class="nav-link dropdown-toggle hide-arrow position-relative" href="javascript:void(0);"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <i class="ri-alert-line ri-xl text-warning"></i>
                <span class="badge bg-danger badge-notifications">
                  <?= $qty_alert_num + (($Settings->product_expiry) ? $exp_alert_num : 0) + $shop_sale_alerts + $shop_payment_alerts; ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end py-0">
                <li class="dropdown-menu-header border-bottom">
                  <div class="dropdown-header d-flex align-items-center py-3">
                    <h5 class="text-body mb-0 me-auto fw-semibold"><?= lang('alerts'); ?></h5>
                  </div>
                </li>
                <?php if ($qty_alert_num > 0): ?>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('reports/quantity_alerts'); ?>">
                    <span class="badge bg-danger float-end ms-2"><?= $qty_alert_num; ?></span>
                    <?= lang('quantity_alerts'); ?>
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($Settings->product_expiry && $exp_alert_num > 0): ?>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('reports/expiry_alerts'); ?>">
                    <span class="badge bg-danger float-end ms-2"><?= $exp_alert_num; ?></span>
                    <?= lang('expiry_alerts'); ?>
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($shop_sale_alerts): ?>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('sales?shop=yes&delivery=no'); ?>">
                    <span class="badge bg-danger float-end ms-2"><?= $shop_sale_alerts; ?></span>
                    <?= lang('sales_x_delivered'); ?>
                  </a>
                </li>
                <?php endif; ?>
                <?php if ($shop_payment_alerts): ?>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('sales?shop=yes&attachment=yes'); ?>">
                    <span class="badge bg-danger float-end ms-2"><?= $shop_payment_alerts; ?></span>
                    <?= lang('manual_payments'); ?>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </li>
            <?php endif; ?>

            <!-- Upcoming Events -->
            <?php if ($events): ?>
            <li class="nav-item dropdown me-2 me-xl-0 d-none d-xl-block">
              <a class="nav-link dropdown-toggle hide-arrow position-relative" href="javascript:void(0);"
                 data-bs-toggle="dropdown" aria-expanded="false" title="<?= lang('calendar'); ?>">
                <i class="ri-calendar-event-line ri-xl"></i>
                <span class="badge bg-warning badge-notifications"><?= count($events); ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end py-0" style="min-width:300px;">
                <li class="dropdown-menu-header border-bottom">
                  <div class="dropdown-header d-flex align-items-center py-3">
                    <h5 class="text-body mb-0 me-auto fw-semibold"><?= lang('upcoming_events'); ?></h5>
                  </div>
                </li>
                <li>
                  <div class="list-group list-group-flush">
                    <?php foreach ($events as $event): ?>
                    <div class="list-group-item list-group-item-action py-2">
                      <small class="text-muted"><?= date($dateFormats['php_ldate'], strtotime($event->start)); ?></small>
                      <div class="fw-semibold small"><?= $event->title; ?></div>
                      <?php if ($event->description): ?>
                      <small class="text-muted"><?= $event->description; ?></small>
                      <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                  </div>
                </li>
                <li class="border-top">
                  <div class="d-grid gap-2 p-2">
                    <a class="btn btn-primary btn-sm" href="<?= admin_url('calendar'); ?>">
                      <?= lang('calendar'); ?>
                    </a>
                  </div>
                </li>
              </ul>
            </li>
            <?php else: ?>
            <li class="nav-item d-none d-xl-block me-2 me-xl-0">
              <a class="nav-link" href="<?= admin_url('calendar'); ?>" title="<?= lang('calendar'); ?>">
                <i class="ri-calendar-line ri-xl"></i>
              </a>
            </li>
            <?php endif; ?>

            <!-- Language selector -->
            <li class="nav-item dropdown-language dropdown me-2 me-xl-0 d-none d-xl-block">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                 data-bs-toggle="dropdown" aria-expanded="false" title="<?= lang('language'); ?>">
                <img src="<?= base_url('assets/images/' . $Settings->user_language . '.png'); ?>"
                     alt="<?= $Settings->user_language; ?>" width="20" class="rounded-circle" />
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <?php
                $scanned_lang_dir = array_map(function ($path) { return basename($path); },
                  glob(APPPATH . 'language/*', GLOB_ONLYDIR));
                foreach ($scanned_lang_dir as $entry): ?>
                <li>
                  <a class="dropdown-item <?= ($Settings->user_language == $entry) ? 'active' : ''; ?>"
                     href="<?= admin_url('welcome/language/' . $entry); ?>">
                    <img src="<?= base_url('assets/images/' . $entry . '.png'); ?>"
                         alt="<?= $entry; ?>" width="16" class="me-2 rounded-circle" />
                    <?= ucwords($entry); ?>
                  </a>
                </li>
                <?php endforeach; ?>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('welcome/toggle_rtl'); ?>">
                    <i class="ri-align-<?= $Settings->user_rtl ? 'right' : 'left'; ?>-line me-2"></i>
                    <?= lang('toggle_alignment'); ?>
                  </a>
                </li>
              </ul>
            </li>

            <!-- User Menu -->
            <li class="nav-item navbar-dropdown dropdown-user dropdown">
              <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-online">
                  <?php if ($this->session->userdata('avatar')): ?>
                    <img src="<?= base_url('assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar')); ?>"
                         alt="<?= $this->session->userdata('username'); ?>"
                         class="w-px-40 h-auto rounded-circle" />
                  <?php else: ?>
                    <img src="<?= base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>"
                         alt="<?= $this->session->userdata('username'); ?>"
                         class="w-px-40 h-auto rounded-circle" />
                  <?php endif; ?>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <!-- User info header -->
                <li>
                  <a class="dropdown-item" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <?php if ($this->session->userdata('avatar')): ?>
                            <img src="<?= base_url('assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar')); ?>"
                                 alt="" class="w-px-40 h-auto rounded-circle" />
                          <?php else: ?>
                            <img src="<?= base_url('assets/images/' . $this->session->userdata('gender') . '.png'); ?>"
                                 alt="" class="w-px-40 h-auto rounded-circle" />
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <span class="fw-semibold d-block"><?= $this->session->userdata('username'); ?></span>
                        <small class="text-muted">
                          <?php if ($Owner): ?><?= lang('owner'); ?>
                          <?php elseif ($Admin): ?><?= lang('admin'); ?>
                          <?php else: ?><?= lang('user'); ?>
                          <?php endif; ?>
                        </small>
                      </div>
                    </div>
                  </a>
                </li>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                    <i class="ri-user-line me-2 ri-22px"></i><?= lang('profile'); ?>
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>">
                    <i class="ri-lock-line me-2 ri-22px"></i><?= lang('change_password'); ?>
                  </a>
                </li>
                <?php if ($Owner): ?>
                <li>
                  <a class="dropdown-item" href="<?= admin_url('system_settings'); ?>">
                    <i class="ri-settings-3-line me-2 ri-22px"></i><?= lang('settings'); ?>
                  </a>
                </li>
                <?php endif; ?>
                <li><hr class="dropdown-divider" /></li>
                <li>
                  <a class="dropdown-item text-danger" href="<?= admin_url('logout'); ?>">
                    <i class="ri-logout-box-r-line me-2 ri-22px"></i><?= lang('logout'); ?>
                  </a>
                </li>
              </ul>
            </li>
            <!-- /User menu -->

          </ul>
        </div>
      </nav>
      <!-- /Navbar -->

      <!-- Content wrapper -->
      <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">

          <!-- Flash messages / Alerts -->
          <?php if ($message): ?>
          <div class="alert alert-success alert-dismissible mb-4" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?= $message; ?>
          </div>
          <?php endif; ?>

          <?php if ($error): ?>
          <div class="alert alert-danger alert-dismissible mb-4" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?= $error; ?>
          </div>
          <?php endif; ?>

          <?php if ($warning): ?>
          <div class="alert alert-warning alert-dismissible mb-4" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <?= $warning; ?>
          </div>
          <?php endif; ?>

          <?php
          if ($info) {
            foreach ($info as $n) {
              if (!$this->session->userdata('hidden' . $n->id)) {
          ?>
          <div class="alert alert-info alert-dismissible mb-2" role="alert">
            <a href="#" id="<?= $n->id; ?>" class="btn-close hideComment external"
               data-bs-dismiss="alert" aria-label="Close"></a>
            <?= $n->comment; ?>
          </div>
          <?php
              }
            }
          }
          ?>

          <div class="alerts-con"></div>
