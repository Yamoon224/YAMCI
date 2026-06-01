<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<script type="text/javascript">
$(document).ready(function () {
    $(document).on("click", ".sledit", function (e) {
        if (localStorage.getItem("slitems")) {
            e.preventDefault();
            var href = $(this).attr("href");
            bootbox.confirm("<?php echo lang('you_will_loss_sale_data'); ?>", function (result) {
                if (result) { window.location.href = href; }
            });
        }
    });
});
</script>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?php echo lang('sale_no') ?: 'Vente'; ?> <span class="text-primary">#<?php echo htmlspecialchars($inv->reference_no); ?></span></h4>
    <p class="mb-0 text-muted">
      <?php echo lang('date') ?>: <?= $this->sma->hrld($inv->date) ?>
      <?php if (!empty($inv->customer)): ?>
      <span class="mx-2">·</span>
      <?php echo lang('customer') ?>: <span class="fw-semibold"><?= htmlspecialchars($inv->customer) ?></span>
      <?php endif; ?>
    </p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url('welcome'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('sales'); ?>"><?php echo lang('sales') ?: 'Ventes'; ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo $inv->reference_no; ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <?php if (!$inv->sale_id): ?>
    <a href="<?php echo admin_url('sales/edit/' . $inv->id); ?>" class="btn btn-warning sledit">
      <span class="ri-edit-line me-1" aria-hidden="true"></span>
      <?php echo lang('edit_sale') ?: 'Edit'; ?>
    </a>
    <?php endif; ?>
    <a href="<?php echo admin_url('sales/pdf/' . $inv->id); ?>" class="btn btn-outline-danger">
      <span class="ri-file-pdf-line me-1" aria-hidden="true"></span>
      <?php echo lang('pdf') ?: 'PDF'; ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <span class="ri-more-2-line" aria-hidden="true"></span>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales/add_payment/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="ri-secure-payment-line me-2" aria-hidden="true"></span>
            <?php echo lang('add_payment') ?: 'Add Payment'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales/payments/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="ri-money-dollar-circle-line me-2" aria-hidden="true"></span>
            <?php echo lang('view_payments') ?: 'View Payments'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales/email/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="ri-mail-send-line me-2" aria-hidden="true"></span>
            <?php echo lang('send_email') ?: 'Send Email'; ?>
          </a>
        </li>
        <?php if (!$inv->sale_id): ?>
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales/add_delivery/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal">
            <span class="ri-truck-line me-2" aria-hidden="true"></span>
            <?php echo lang('add_delivery') ?: 'Add Delivery'; ?>
          </a>
        </li>
        <li>
          <a class="dropdown-item" href="<?php echo admin_url('sales/return_sale/' . $inv->id); ?>">
            <span class="ri-arrow-go-back-line me-2" aria-hidden="true"></span>
            <?php echo lang('return_sale') ?: 'Return Sale'; ?>
          </a>
        </li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <a class="dropdown-item text-danger"
             href="#"
             onclick="if(confirm('<?php echo lang('r_u_sure'); ?>')) window.location='<?php echo admin_url('sales/delete/' . $inv->id); ?>'; return false;">
            <span class="ri-delete-bin-line me-2" aria-hidden="true"></span>
            <?php echo lang('delete_sale') ?: 'Delete'; ?>
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
    <a href="<?php echo admin_url('sales'); ?>" class="btn btn-outline-secondary">
      <span class="ri-arrow-left-line me-1" aria-hidden="true"></span>
      <?php echo lang('back') ?: 'Back'; ?>
    </a>
  </div>
</div>

<?php if (!empty($inv->return_sale_ref) && $inv->return_id): ?>
<div class="alert alert-info no-print d-flex align-items-center mb-4" role="alert">
  <span class="ri-information-line me-2 fs-5" aria-hidden="true"></span>
  <div>
    <?php echo lang('sale_is_returned') . ': ' . $inv->return_sale_ref; ?>
    <a class="ms-2" data-bs-target="#myModal2" data-bs-toggle="modal" href="<?php echo admin_url('sales/modal_view/' . $inv->return_id); ?>">
      <span class="ri-external-link-line no-print" aria-hidden="true"></span>
    </a>
  </div>
</div>
<?php endif; ?>

<!-- Sale Meta Card -->
<div class="card mb-4">
  <div class="card-body">
    <div class="row g-4">

      <!-- Customer -->
      <div class="col-md-4 border-end">
        <div class="d-flex align-items-start gap-3">
          <div class="avatar avatar-lg flex-shrink-0">
            <span class="avatar-initial rounded-circle bg-label-primary">
              <span class="ri-user-line fs-4" aria-hidden="true"></span>
            </span>
          </div>
          <div>
            <h6 class="fw-semibold mb-1"><?php echo $customer->company && $customer->company != '-' ? $customer->company : $customer->name; ?></h6>
            <?php if ($customer->company && $customer->company != '-'): ?>
            <div class="text-muted small mb-1">Attn: <?php echo $customer->name; ?></div>
            <?php endif; ?>
            <div class="small text-muted">
              <?php echo nl2br(htmlspecialchars($customer->address . "\n" . $customer->city . ' ' . $customer->postal_code . ' ' . $customer->state . "\n" . $customer->country)); ?>
            </div>
            <?php foreach (['vat_no' => 'vat_no', 'gst_no' => 'gst_no', 'cf1' => 'ccf1', 'cf2' => 'ccf2', 'cf3' => 'ccf3', 'cf4' => 'ccf4', 'cf5' => 'ccf5', 'cf6' => 'ccf6'] as $field => $label): ?>
            <?php if (!empty($customer->$field) && $customer->$field != '-'): ?>
            <div class="small text-muted"><?php echo lang($label) . ': ' . $customer->$field; ?></div>
            <?php endif; ?>
            <?php endforeach; ?>
            <div class="small mt-1">
              <?php echo lang('tel') . ': ' . $customer->phone; ?><br>
              <?php echo lang('email') . ': ' . $customer->email; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Biller -->
      <div class="col-md-4 border-end">
        <div class="d-flex align-items-start gap-3">
          <div class="avatar avatar-lg flex-shrink-0">
            <span class="avatar-initial rounded-circle bg-label-success">
              <span class="ri-building-2-line fs-4" aria-hidden="true"></span>
            </span>
          </div>
          <div>
            <h6 class="fw-semibold mb-1"><?php echo $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?></h6>
            <?php if ($biller->company): ?>
            <div class="text-muted small mb-1">Attn: <?php echo $biller->name; ?></div>
            <?php endif; ?>
            <div class="small text-muted">
              <?php echo nl2br(htmlspecialchars($biller->address . "\n" . $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state . "\n" . $biller->country)); ?>
            </div>
            <?php foreach (['vat_no' => 'vat_no', 'gst_no' => 'gst_no', 'cf1' => 'bcf1', 'cf2' => 'bcf2', 'cf3' => 'bcf3', 'cf4' => 'bcf4', 'cf5' => 'bcf5', 'cf6' => 'bcf6'] as $field => $label): ?>
            <?php if (!empty($biller->$field) && $biller->$field != '-'): ?>
            <div class="small text-muted"><?php echo lang($label) . ': ' . $biller->$field; ?></div>
            <?php endif; ?>
            <?php endforeach; ?>
            <div class="small mt-1">
              <?php echo lang('tel') . ': ' . $biller->phone; ?><br>
              <?php echo lang('email') . ': ' . $biller->email; ?>
            </div>
          </div>
        </div>
      </div>

      <!-- Sale Info + Barcodes -->
      <div class="col-md-4">
        <div class="d-flex align-items-start gap-3">
          <div class="avatar avatar-lg flex-shrink-0">
            <span class="avatar-initial rounded-circle bg-label-info">
              <span class="ri-file-list-3-line fs-4" aria-hidden="true"></span>
            </span>
          </div>
          <div class="flex-grow-1">
            <h6 class="fw-semibold mb-2"><?php echo lang('ref') . ': ' . $inv->reference_no; ?></h6>
            <?php if (!empty($inv->return_sale_ref)): ?>
            <p class="mb-1 small"><?php echo lang('return_ref') . ': ' . $inv->return_sale_ref; ?>
              <?php if ($inv->return_id): ?>
              <a data-bs-target="#myModal2" data-bs-toggle="modal" href="<?php echo admin_url('sales/modal_view/' . $inv->return_id); ?>">
                <span class="ri-external-link-line no-print" aria-hidden="true"></span>
              </a>
              <?php endif; ?>
            </p>
            <?php endif; ?>
            <p class="mb-1">
              <strong><?php echo lang('date'); ?>:</strong> <?php echo $this->sma->hrld($inv->date); ?>
            </p>
            <p class="mb-1">
              <strong><?php echo lang('sale_status'); ?>:</strong>
              <?php
              $statusMap = ['completed' => 'bg-success', 'pending' => 'bg-warning', 'partial' => 'bg-info', 'returned' => 'bg-secondary', 'cancelled' => 'bg-danger'];
              $statusClass = $statusMap[$inv->sale_status] ?? 'bg-secondary';
              ?>
              <span class="badge <?php echo $statusClass; ?>"><?php echo lang($inv->sale_status); ?></span>
            </p>
            <p class="mb-1">
              <strong><?php echo lang('payment_status'); ?>:</strong>
              <?php
              $payMap = ['paid' => 'bg-success', 'partial' => 'bg-info', 'due' => 'bg-danger'];
              $payClass = $payMap[$inv->payment_status] ?? 'bg-warning';
              ?>
              <span class="badge <?php echo $payClass; ?>"><?php echo lang($inv->payment_status); ?></span>
            </p>
            <?php if ($inv->payment_status != 'paid' && $inv->due_date): ?>
            <p class="mb-1 small text-muted"><?php echo lang('due_date') . ': ' . $this->sma->hrsd($inv->due_date); ?></p>
            <?php endif; ?>
          </div>
        </div>
        <!-- Barcodes -->
        <div class="text-end mt-3 order_barcodes">
          <img src="<?php echo admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1'); ?>"
               alt="<?php echo $inv->reference_no; ?>" class="bcimg mb-1" />
          <?php
          if ($Settings->ksa_qrcode) {
              $qrtext = $this->inv_qrcode->base64([
                  'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
                  'vat_no'           => $biller->vat_no ?: $biller->get_no,
                  'date'             => $inv->date,
                  'grand_total'      => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
                  'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
              ]);
              echo $this->sma->qrcode('text', $qrtext, 2);
          } else {
              echo $this->sma->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 2);
          }
          ?>
        </div>
      </div>

    </div>
  </div>
</div>

<?php if ($Settings->invoice_view == 1): ?>
<div class="text-center mb-4">
  <h4 class="fw-bold"><?php echo lang('tax_invoice'); ?></h4>
</div>
<?php endif; ?>

<!-- Products Table -->
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="ri-list-check-line me-2" aria-hidden="true"></span>
      <?php echo lang('products') ?: 'Products'; ?>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 order-table print-table">
        <thead class="table-light">
          <tr>
            <th style="width:40px; text-align:center;"><?php echo lang('no.') ?: '#'; ?></th>
            <th><?php echo lang('description') . ' (' . lang('code') . ')'; ?></th>
            <?php if ($Settings->indian_gst): ?>
            <th><?php echo lang('hsn_sac_code'); ?></th>
            <?php endif; ?>
            <th class="text-center"><?php echo lang('quantity'); ?></th>
            <?php if ($Settings->product_serial): ?>
            <th class="text-center"><?php echo lang('serial_no'); ?></th>
            <?php endif; ?>
            <th class="text-end"><?php echo lang('unit_price'); ?></th>
            <?php if ($Settings->tax1 && $inv->product_tax > 0): ?>
            <th class="text-end"><?php echo lang('tax'); ?></th>
            <?php endif; ?>
            <?php if ($Settings->product_discount && $inv->product_discount != 0): ?>
            <th class="text-end"><?php echo lang('discount'); ?></th>
            <?php endif; ?>
            <th class="text-end"><?php echo lang('subtotal'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $r = 1; foreach ($rows as $row): ?>
          <tr>
            <td class="text-center align-middle"><?php echo $r; ?></td>
            <td class="align-middle">
              <span class="fw-semibold"><?php echo $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?></span>
              <?php if ($row->second_name): ?><br><small class="text-muted"><?php echo $row->second_name; ?></small><?php endif; ?>
              <?php if ($row->details): ?><br><small><?php echo $row->details; ?></small><?php endif; ?>
            </td>
            <?php if ($Settings->indian_gst): ?>
            <td class="text-center align-middle"><?php echo $row->hsn_code ?: ''; ?></td>
            <?php endif; ?>
            <td class="text-center align-middle">
              <?php echo $this->sma->formatQuantity($row->unit_quantity) . ' ' . ($inv->sale_status == 'returned' ? $row->base_unit_code : $row->product_unit_code); ?>
            </td>
            <?php if ($Settings->product_serial): ?>
            <td class="align-middle"><?php echo $row->serial_no; ?></td>
            <?php endif; ?>
            <td class="text-end align-middle">
              <?php if ($row->unit_price != $row->real_unit_price && $row->item_discount > 0): ?>
              <del class="text-muted small"><?php echo $this->sma->formatMoney($row->real_unit_price); ?></del><br>
              <?php endif; ?>
              <?php echo $this->sma->formatMoney($row->unit_price); ?>
            </td>
            <?php if ($Settings->tax1 && $inv->product_tax > 0): ?>
            <td class="text-end align-middle">
              <?php if ($row->item_tax != 0): ?>
              <small class="text-muted">(<?php echo $Settings->indian_gst ? $row->tax : $row->tax_code; ?>)</small><br>
              <?php endif; ?>
              <?php echo $this->sma->formatMoney($row->item_tax); ?>
            </td>
            <?php endif; ?>
            <?php if ($Settings->product_discount && $inv->product_discount != 0): ?>
            <td class="text-end align-middle">
              <?php if ($row->discount != 0): ?>
              <small class="text-muted">(<?php echo $row->discount; ?>)</small>
              <?php endif; ?>
              <?php echo $this->sma->formatMoney($row->item_discount); ?>
            </td>
            <?php endif; ?>
            <td class="text-end align-middle fw-semibold"><?php echo $this->sma->formatMoney($row->subtotal); ?></td>
          </tr>
          <?php $r++; endforeach; ?>

          <?php if ($return_rows): ?>
          <tr class="table-warning">
            <td colspan="100%" class="fw-semibold py-2">
              <span class="ri-arrow-go-back-line me-1" aria-hidden="true"></span>
              <?php echo lang('returned_items'); ?>
            </td>
          </tr>
          <?php foreach ($return_rows as $row): ?>
          <tr class="table-warning">
            <td class="text-center align-middle"><?php echo $r; ?></td>
            <td class="align-middle">
              <?php echo $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
              <?php if ($row->second_name): ?><br><small class="text-muted"><?php echo $row->second_name; ?></small><?php endif; ?>
              <?php if ($row->details): ?><br><small><?php echo $row->details; ?></small><?php endif; ?>
            </td>
            <?php if ($Settings->indian_gst): ?>
            <td class="text-center align-middle"><?php echo $row->hsn_code ?: ''; ?></td>
            <?php endif; ?>
            <td class="text-center align-middle"><?php echo $this->sma->formatQuantity($row->quantity) . ' ' . $row->base_unit_code; ?></td>
            <?php if ($Settings->product_serial): ?>
            <td class="align-middle"><?php echo $row->serial_no; ?></td>
            <?php endif; ?>
            <td class="text-end align-middle"><?php echo $this->sma->formatMoney($row->unit_price); ?></td>
            <?php if ($Settings->tax1 && $inv->product_tax > 0): ?>
            <td class="text-end align-middle">
              <?php if ($row->item_tax != 0): ?>
              <small class="text-muted">(<?php echo $Settings->indian_gst ? $row->tax : $row->tax_code; ?>)</small>
              <?php endif; ?>
              <?php echo $this->sma->formatMoney($row->item_tax); ?>
            </td>
            <?php endif; ?>
            <?php if ($Settings->product_discount && $inv->product_discount != 0): ?>
            <td class="text-end align-middle">
              <?php if ($row->discount != 0): ?>
              <small class="text-muted">(<?php echo $row->discount; ?>)</small>
              <?php endif; ?>
              <?php echo $this->sma->formatMoney($row->item_discount); ?>
            </td>
            <?php endif; ?>
            <td class="text-end align-middle fw-semibold"><?php echo $this->sma->formatMoney($row->subtotal); ?></td>
          </tr>
          <?php $r++; endforeach; ?>
          <?php endif; ?>
        </tbody>

        <!-- Totals footer -->
        <tfoot class="table-light">
          <?php
          $col = $Settings->indian_gst ? 5 : 4;
          if ($Settings->product_serial) $col++;
          if ($Settings->product_discount && $inv->product_discount != 0) $col++;
          if ($Settings->tax1 && $inv->product_tax > 0) $col++;
          if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) $tcol = $col - 2;
          elseif ($Settings->product_discount && $inv->product_discount != 0) $tcol = $col - 1;
          elseif ($Settings->tax1 && $inv->product_tax > 0) $tcol = $col - 1;
          else $tcol = $col;
          ?>

          <?php if ($inv->grand_total != $inv->total): ?>
          <tr>
            <td colspan="<?php echo $tcol; ?>" class="text-end"><?php echo lang('total') . ' (' . $default_currency->code . ')'; ?></td>
            <?php if ($Settings->tax1 && $inv->product_tax > 0): ?>
            <td class="text-end"><?php echo $this->sma->formatMoney($return_sale ? ($inv->product_tax + $return_sale->product_tax) : $inv->product_tax); ?></td>
            <?php endif; ?>
            <?php if ($Settings->product_discount && $inv->product_discount != 0): ?>
            <td class="text-end"><?php echo $this->sma->formatMoney($return_sale ? ($inv->product_discount + $return_sale->product_discount) : $inv->product_discount); ?></td>
            <?php endif; ?>
            <td class="text-end"><?php echo $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
          </tr>
          <?php endif; ?>

          <?php if ($return_sale): ?>
          <tr>
            <td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('return_total') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end"><?php echo $this->sma->formatMoney($return_sale->grand_total); ?></td>
          </tr>
          <?php endif; ?>

          <?php if ($inv->surcharge != 0): ?>
          <tr>
            <td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('return_surcharge') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end"><?php echo $this->sma->formatMoney($inv->surcharge); ?></td>
          </tr>
          <?php endif; ?>

          <?php if ($Settings->indian_gst): ?>
          <?php if ($inv->cgst > 0): ?>
          <tr><td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('cgst') . ' (' . $default_currency->code . ')'; ?></td><td class="text-end"><?php $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst; echo $Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst; ?></td></tr>
          <?php endif; ?>
          <?php if ($inv->sgst > 0): ?>
          <tr><td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('sgst') . ' (' . $default_currency->code . ')'; ?></td><td class="text-end"><?php $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst; echo $Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst; ?></td></tr>
          <?php endif; ?>
          <?php if ($inv->igst > 0): ?>
          <tr><td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('igst') . ' (' . $default_currency->code . ')'; ?></td><td class="text-end"><?php $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst; echo $Settings->format_gst ? $this->sma->formatMoney($igst) : $igst; ?></td></tr>
          <?php endif; ?>
          <?php endif; ?>

          <?php if ($inv->order_discount != 0): ?>
          <tr>
            <td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('order_discount') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end"><?php echo ($inv->order_discount_id ? '<small class="text-muted">(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount); ?></td>
          </tr>
          <?php endif; ?>

          <?php if ($Settings->tax2 && $inv->order_tax != 0): ?>
          <tr>
            <td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('order_tax') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end"><?php echo $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax); ?></td>
          </tr>
          <?php endif; ?>

          <?php if ($inv->shipping != 0): ?>
          <tr>
            <td colspan="<?php echo $col; ?>" class="text-end"><?php echo lang('shipping') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end"><?php echo $this->sma->formatMoney($inv->shipping - ($return_sale && $return_sale->shipping ? $return_sale->shipping : 0)); ?></td>
          </tr>
          <?php endif; ?>

          <tr class="table-primary">
            <td colspan="<?php echo $col; ?>" class="text-end fw-bold"><?php echo lang('total_amount') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end fw-bold"><?php echo $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></td>
          </tr>
          <tr class="table-success">
            <td colspan="<?php echo $col; ?>" class="text-end fw-bold"><?php echo lang('paid') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end fw-bold"><?php echo $this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></td>
          </tr>
          <tr class="<?php echo (($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total) > ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)) ? 'table-danger' : 'table-light'; ?>">
            <td colspan="<?php echo $col; ?>" class="text-end fw-bold"><?php echo lang('Reste à payer') . ' (' . $default_currency->code . ')'; ?></td>
            <td class="text-end fw-bold">
              <?php echo $this->sma->formatMoney(($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?>
            </td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>

<!-- Notes + Meta -->
<div class="row mb-4">
  <div class="col-md-6">
    <?php if ($inv->note && $inv->note != ''): ?>
    <div class="card mb-3">
      <div class="card-body">
        <p class="fw-semibold mb-1"><span class="ri-sticky-note-line me-1" aria-hidden="true"></span><?php echo lang('note'); ?></p>
        <div><?php echo $this->sma->decode_html($inv->note); ?></div>
      </div>
    </div>
    <?php endif; ?>
    <?php if ($inv->staff_note && $inv->staff_note != ''): ?>
    <div class="card mb-3 staff_note">
      <div class="card-body">
        <p class="fw-semibold mb-1"><span class="ri-message-2-line me-1" aria-hidden="true"></span><?php echo lang('staff_note'); ?></p>
        <div><?php echo $this->sma->decode_html($inv->staff_note); ?></div>
      </div>
    </div>
    <?php endif; ?>
    <?php if ($customer->award_points != 0 && $Settings->each_spent > 0): ?>
    <div class="card mb-3">
      <div class="card-body small">
        <p class="mb-1"><?php echo lang('this_sale') . ': ' . floor(($inv->grand_total / $Settings->each_spent) * $Settings->ca_point); ?></p>
        <p class="mb-0"><?php echo lang('total') . ' ' . lang('award_points') . ': ' . $customer->award_points; ?></p>
      </div>
    </div>
    <?php endif; ?>
  </div>
  <div class="col-md-6">
    <?php echo $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax + $return_sale->product_tax : $inv->product_tax)) : ''; ?>
    <div class="card mb-3">
      <div class="card-body small">
        <p class="mb-1"><strong><?php echo lang('created_by'); ?>:</strong> <?php echo $inv->created_by ? $created_by->first_name . ' ' . $created_by->last_name : $customer->name; ?></p>
        <p class="mb-1"><strong><?php echo lang('date'); ?>:</strong> <?php echo $this->sma->hrld($inv->date); ?></p>
        <?php if ($inv->updated_by): ?>
        <p class="mb-1"><strong><?php echo lang('updated_by'); ?>:</strong> <?php echo $updated_by->first_name . ' ' . $updated_by->last_name; ?></p>
        <p class="mb-0"><strong><?php echo lang('update_at'); ?>:</strong> <?php echo $this->sma->hrld($inv->updated_at); ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include(dirname(__FILE__) . '/../partials/attachments.php'); ?>

<!-- Online Payment Buttons -->
<?php if ($inv->payment_status != 'paid'): ?>
<div id="payment_buttons" class="row justify-content-center mb-4 no-print">
  <?php if ($paypal->active == '1' && $inv->grand_total != '0.00'):
      if (trim(strtolower($customer->country)) == $biller->country) {
          $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_my / 100);
      } else {
          $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_other / 100);
      } ?>
  <div class="col-md-4 mb-3">
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
      <input type="hidden" name="cmd" value="_xclick">
      <input type="hidden" name="business" value="<?php echo $paypal->account_email; ?>">
      <input type="hidden" name="item_name" value="<?php echo $inv->reference_no; ?>">
      <input type="hidden" name="item_number" value="<?php echo $inv->id; ?>">
      <input type="hidden" name="image_url" value="<?php echo base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>">
      <input type="hidden" name="amount" value="<?php echo ($inv->grand_total - $inv->paid) + $paypal_fee; ?>">
      <input type="hidden" name="no_shipping" value="1">
      <input type="hidden" name="no_note" value="1">
      <input type="hidden" name="currency_code" value="<?php echo $default_currency->code; ?>">
      <input type="hidden" name="bn" value="FC-BuyNow">
      <input type="hidden" name="rm" value="2">
      <input type="hidden" name="return" value="<?php echo admin_url('sales/view/' . $inv->id); ?>">
      <input type="hidden" name="cancel_return" value="<?php echo admin_url('sales/view/' . $inv->id); ?>">
      <input type="hidden" name="notify_url" value="<?php echo admin_url('payments/paypalipn'); ?>">
      <input type="hidden" name="custom" value="<?php echo $inv->reference_no . '__' . ($inv->grand_total - $inv->paid) . '__' . $paypal_fee; ?>">
      <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
        <span class="ri-paypal-line me-2" aria-hidden="true"></span>
        <?php echo lang('pay_by_paypal'); ?>
      </button>
    </form>
  </div>
  <?php endif; ?>

  <?php if ($skrill->active == '1' && $inv->grand_total != '0.00'):
      if (trim(strtolower($customer->country)) == $biller->country) {
          $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_my / 100);
      } else {
          $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_other / 100);
      } ?>
  <div class="col-md-4 mb-3">
    <form action="https://www.moneybookers.com/app/payment.pl" method="post">
      <input type="hidden" name="pay_to_email" value="<?php echo $skrill->account_email; ?>">
      <input type="hidden" name="status_url" value="<?php echo admin_url('payments/skrillipn'); ?>">
      <input type="hidden" name="cancel_url" value="<?php echo admin_url('sales/view/' . $inv->id); ?>">
      <input type="hidden" name="return_url" value="<?php echo admin_url('sales/view/' . $inv->id); ?>">
      <input type="hidden" name="language" value="EN">
      <input type="hidden" name="item_name" value="<?php echo $inv->reference_no; ?>">
      <input type="hidden" name="item_number" value="<?php echo $inv->id; ?>">
      <input type="hidden" name="amount" value="<?php echo ($inv->grand_total - $inv->paid) + $skrill_fee; ?>">
      <input type="hidden" name="currency" value="<?php echo $default_currency->code; ?>">
      <button type="submit" name="submit" class="btn btn-primary btn-lg w-100">
        <span class="ri-bank-card-line me-2" aria-hidden="true"></span>
        <?php echo lang('pay_by_skrill'); ?>
      </button>
    </form>
  </div>
  <?php endif; ?>
</div>
<?php endif; ?>

<!-- Payments Table -->
<?php if ($payments): ?>
<div class="card mb-4">
  <div class="card-header">
    <h5 class="card-title mb-0">
      <span class="ri-secure-payment-line me-2" aria-hidden="true"></span>
      <?php echo lang('payments') ?: 'Payments'; ?>
    </h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover mb-0 print-table">
        <thead class="table-light">
          <tr>
            <th><?php echo lang('date'); ?></th>
            <th><?php echo lang('payment_reference'); ?></th>
            <th><?php echo lang('paid_by'); ?></th>
            <th class="text-end"><?php echo lang('amount'); ?></th>
            <th><?php echo lang('created_by'); ?></th>
            <th><?php echo lang('type'); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($payments as $payment): ?>
          <tr <?php echo $payment->type == 'returned' ? 'class="table-warning"' : ''; ?>>
            <td><?php echo $this->sma->hrld($payment->date); ?></td>
            <td><code><?php echo $payment->reference_no; ?></code></td>
            <td>
              <?php echo lang($payment->paid_by); ?>
              <?php if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC'): ?>
              <small class="text-muted">(<?php echo $payment->cc_no; ?>)</small>
              <?php elseif ($payment->paid_by == 'Cheque'): ?>
              <small class="text-muted">(<?php echo $payment->cheque_no; ?>)</small>
              <?php endif; ?>
            </td>
            <td class="text-end fw-semibold"><?php echo $this->sma->formatMoney($payment->amount); ?></td>
            <td><?php echo $payment->first_name . ' ' . $payment->last_name; ?></td>
            <td>
              <?php $typeMap = ['sale' => 'bg-label-primary', 'returned' => 'bg-label-warning', 'deposit' => 'bg-label-success']; ?>
              <span class="badge <?php echo $typeMap[$payment->type] ?? 'bg-label-secondary'; ?>"><?php echo lang($payment->type); ?></span>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<?php endif; ?>

<!-- Action Buttons (bottom) -->
<?php if (!$Supplier || !$Customer): ?>
<div class="d-flex flex-wrap gap-2 no-print mb-4">
  <a href="<?php echo admin_url('sales/payments/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-outline-primary">
    <span class="ri-money-dollar-circle-line me-1" aria-hidden="true"></span>
    <?php echo lang('view_payments'); ?>
  </a>
  <a href="<?php echo admin_url('sales/add_payment/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-primary">
    <span class="ri-secure-payment-line me-1" aria-hidden="true"></span>
    <?php echo lang('add_payment'); ?>
  </a>
  <a href="<?php echo admin_url('sales/email/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-outline-secondary">
    <span class="ri-mail-send-line me-1" aria-hidden="true"></span>
    <?php echo lang('email'); ?>
  </a>
  <a href="<?php echo admin_url('sales/pdf/' . $inv->id); ?>" class="btn btn-outline-danger">
    <span class="ri-file-pdf-line me-1" aria-hidden="true"></span>
    <?php echo lang('pdf'); ?>
  </a>
  <?php if (!$inv->sale_id): ?>
  <a href="<?php echo admin_url('sales/add_delivery/' . $inv->id); ?>" data-bs-toggle="modal" data-bs-target="#myModal" class="btn btn-outline-info">
    <span class="ri-truck-line me-1" aria-hidden="true"></span>
    <?php echo lang('add_delivery'); ?>
  </a>
  <a href="<?php echo admin_url('sales/edit/' . $inv->id); ?>" class="btn btn-warning sledit">
    <span class="ri-edit-line me-1" aria-hidden="true"></span>
    <?php echo lang('edit'); ?>
  </a>
  <?php endif; ?>
</div>
<?php endif; ?>
