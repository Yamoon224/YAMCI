<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('purchase_no') ?: 'Achat' ?> <span class="text-primary">#<?= htmlspecialchars($inv->reference_no ?? $inv->id) ?></span></h4>
    <p class="mb-0 text-muted">
      <?= lang('date') ?>: <?= $this->sma->hrld($inv->date ?? '') ?>
      <?php if (!empty($inv->supplier)): ?>
      <span class="mx-2">·</span>
      <?= lang('supplier') ?>: <span class="fw-semibold"><?= htmlspecialchars($inv->supplier) ?></span>
      <?php endif; ?>
    </p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('purchases') ?>"><?= lang('purchases') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($inv->reference_no ?? $inv->id) ?></li>
      </ol>
    </nav>
  </div>
  <?php if (!$Supplier && !$Customer): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
    <a href="<?= admin_url('purchases/edit/' . $inv->id) ?>" class="btn btn-warning">
      <i class="ri ri-edit-line me-1" style="font-size:16px"></i><?= lang('edit') ?>
    </a>
    <a href="<?= admin_url('purchases/pdf/' . $inv->id) ?>" class="btn btn-outline-danger">
      <i class="ri ri-file-pdf-line me-1" style="font-size:16px"></i><?= lang('pdf') ?>
    </a>
    <div class="dropdown">
      <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="ri ri-more-2-line" style="font-size:16px"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end">
        <li><a class="dropdown-item" href="<?= admin_url('purchases/add_payment/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-secure-payment-line me-2" style="font-size:14px"></i><?= lang('add_payment') ?></a></li>
        <li><a class="dropdown-item" href="<?= admin_url('purchases/payments/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-money-dollar-circle-line me-2" style="font-size:14px"></i><?= lang('view_payments') ?></a></li>
        <li><a class="dropdown-item" href="<?= admin_url('purchases/email/' . $inv->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal"><i class="ri ri-mail-send-line me-2" style="font-size:14px"></i><?= lang('email') ?></a></li>
        <li><a class="dropdown-item" href="<?= admin_url('purchases/return_purchase/' . $inv->id) ?>"><i class="ri ri-arrow-go-back-line me-2" style="font-size:14px"></i>Retour</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="#" onclick="if(confirm('<?= lang('r_u_sure') ?>')) window.location='<?= admin_url('purchases/delete/' . $inv->id) ?>'; return false;"><i class="ri ri-delete-bin-line me-2" style="font-size:14px"></i><?= lang('delete') ?></a></li>
      </ul>
    </div>
    <a href="<?= admin_url('purchases') ?>" class="btn btn-outline-secondary">
      <i class="ri ri-arrow-left-line me-1" style="font-size:16px"></i><?= lang('back') ?: 'Retour' ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<?php if (!empty($inv->return_purchase_ref) && $inv->return_id) { ?>
<div class="alert alert-info d-flex align-items-center mb-4 no-print">
    <span class="ri-information-line me-2 fs-5"></span>
    <div>
        <?= lang('purchase_is_returned') ?>: <strong><?= $inv->return_purchase_ref ?></strong>
        <a data-bs-target="#myModal2" data-bs-toggle="modal" href="<?= admin_url('purchases/modal_view/' . $inv->return_id) ?>" class="ms-2">
            <span class="ri-external-link-line"></span>
        </a>
    </div>
</div>
<?php } ?>

<!-- Header info: Supplier / Warehouse / Invoice details -->
<div class="row g-4 mb-4">
    <!-- Supplier -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-secondary">
                            <span class="ri-building-2-line ri-lg"></span>
                        </span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $supplier->company && $supplier->company != '-' ? $supplier->company : $supplier->name ?></h6>
                        <?php if ($supplier->company && $supplier->company != '-') { ?>
                            <p class="mb-1 text-muted small"><?= $supplier->name ?></p>
                        <?php } ?>
                        <p class="mb-1 small"><?= $supplier->address ?></p>
                        <p class="mb-1 small"><?= $supplier->city ?> <?= $supplier->postal_code ?> <?= $supplier->state ?></p>
                        <p class="mb-1 small"><?= $supplier->country ?></p>
                        <?php if ($supplier->phone) { ?><p class="mb-1 small"><span class="ri-phone-line me-1"></span><?= $supplier->phone ?></p><?php } ?>
                        <?php if ($supplier->email) { ?><p class="mb-0 small"><span class="ri-mail-line me-1"></span><?= $supplier->email ?></p><?php } ?>
                        <?php if ($supplier->vat_no && $supplier->vat_no != '-') { ?><p class="mb-0 small text-muted"><?= lang('vat_no') ?>: <?= $supplier->vat_no ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Warehouse (Ship To) -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <span class="ri-truck-line ri-lg"></span>
                        </span>
                    </div>
                    <div>
                        <h6 class="fw-bold mb-1"><?= $Settings->site_name ?></h6>
                        <p class="mb-1 small text-muted"><?= $warehouse->name ?></p>
                        <?php if ($warehouse->address) { ?><p class="mb-1 small"><?= $warehouse->address ?></p><?php } ?>
                        <?php if ($warehouse->phone) { ?><p class="mb-1 small"><span class="ri-phone-line me-1"></span><?= $warehouse->phone ?></p><?php } ?>
                        <?php if ($warehouse->email) { ?><p class="mb-0 small"><span class="ri-mail-line me-1"></span><?= $warehouse->email ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Invoice info -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <span class="ri-file-text-line ri-lg"></span>
                        </span>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bold mb-2"><?= lang('ref') ?>: <?= $inv->reference_no ?></h6>
                        <?php if (!empty($inv->return_purchase_ref)) { ?>
                        <p class="mb-1 small"><?= lang('return_ref') ?>: <?= $inv->return_purchase_ref ?>
                            <?php if ($inv->return_id) { ?>
                            <a data-bs-target="#myModal2" data-bs-toggle="modal" href="<?= admin_url('purchases/modal_view/' . $inv->return_id) ?>" class="ms-1"><span class="ri-external-link-line"></span></a>
                            <?php } ?>
                        </p>
                        <?php } ?>
                        <p class="mb-1 small"><strong><?= lang('date') ?>:</strong> <?= $this->sma->hrld($inv->date) ?></p>
                        <p class="mb-1 small">
                            <strong><?= lang('status') ?>:</strong>
                            <?php
                            $statusMap = [
                                'received' => 'bg-success', 'pending' => 'bg-warning text-dark',
                                'partial'  => 'bg-info',    'ordered' => 'bg-secondary',
                                'cancelled'=> 'bg-danger',
                            ];
                            $sc = $statusMap[$inv->status] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $sc ?>"><?= lang($inv->status) ?></span>
                        </p>
                        <p class="mb-1 small">
                            <strong><?= lang('payment_status') ?>:</strong>
                            <?php
                            $psMap = ['paid'=>'bg-success','partial'=>'bg-info','pending'=>'bg-warning text-dark','due'=>'bg-warning text-dark'];
                            $pc = $psMap[$inv->payment_status] ?? 'bg-secondary';
                            ?>
                            <span class="badge <?= $pc ?>"><?= lang($inv->payment_status) ?></span>
                        </p>
                        <?php if ($inv->payment_status != 'paid' && $inv->due_date) { ?>
                        <p class="mb-0 small"><strong><?= lang('due_date') ?>:</strong> <?= $this->sma->hrsd($inv->due_date) ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Products table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0"><span class="ri-shopping-bag-line me-2"></span><?= lang('order_items') ?></h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th style="width:40px;">#</th>
                    <th><?= lang('description') ?></th>
                    <?php if ($Settings->indian_gst) { ?><th><?= lang('hsn_sac_code') ?></th><?php } ?>
                    <th><?= lang('quantity') ?></th>
                    <?php if ($inv->status == 'partial') { ?><th><?= lang('received') ?></th><?php } ?>
                    <th class="text-end"><?= lang('unit_cost') ?></th>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?><th class="text-end"><?= lang('tax') ?></th><?php } ?>
                    <?php if ($Settings->product_discount != 0 && $inv->product_discount != 0) { ?><th class="text-end"><?= lang('discount') ?></th><?php } ?>
                    <th class="text-end"><?= lang('subtotal') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php $r = 1; foreach ($rows as $row) { ?>
                <tr>
                    <td class="text-center align-middle"><?= $r ?></td>
                    <td class="align-middle">
                        <strong><?= $row->product_code ?></strong> — <?= $row->product_name ?><?= $row->variant ? ' <span class="badge bg-label-secondary">' . $row->variant . '</span>' : '' ?>
                        <?= $row->second_name ? '<br><small class="text-muted">' . $row->second_name . '</small>' : '' ?>
                        <?= $row->supplier_part_no ? '<br><small>' . lang('supplier_part_no') . ': ' . $row->supplier_part_no . '</small>' : '' ?>
                        <?= $row->details ? '<br><small>' . $row->details . '</small>' : '' ?>
                        <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br><small class="text-danger"><span class="ri-time-line me-1"></span>' . lang('expiry') . ': ' . $this->sma->hrsd($row->expiry) . '</small>' : '' ?>
                    </td>
                    <?php if ($Settings->indian_gst) { ?><td class="text-center align-middle"><?= $row->hsn_code ?: '' ?></td><?php } ?>
                    <td class="text-center align-middle"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code ?></td>
                    <?php if ($inv->status == 'partial') { ?><td class="text-center align-middle"><?= $this->sma->formatQuantity($row->quantity_received) . ' ' . $row->product_unit_code ?></td><?php } ?>
                    <td class="text-end align-middle">
                        <?= $row->unit_cost != $row->real_unit_cost && $row->item_discount > 0 ? '<del class="text-muted">' . $this->sma->formatMoney($row->real_unit_cost) . '</del><br>' : '' ?>
                        <?= $this->sma->formatMoney($row->unit_cost) ?>
                    </td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end align-middle">
                        <?= $row->item_tax != 0 ? '<small class="text-muted">(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_tax) ?>
                    </td>
                    <?php } ?>
                    <?php if ($Settings->product_discount != 0 && $inv->product_discount != 0) { ?>
                    <td class="text-end align-middle">
                        <?= $row->discount != 0 ? '<small class="text-muted">(' . $row->discount . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_discount) ?>
                    </td>
                    <?php } ?>
                    <td class="text-end align-middle fw-bold"><?= $this->sma->formatMoney($row->subtotal) ?></td>
                </tr>
                <?php $r++; } ?>

                <?php if ($return_rows) {
                    echo '<tr class="table-warning"><td colspan="100%" class="fw-bold">' . lang('returned_items') . '</td></tr>';
                    foreach ($return_rows as $row) { ?>
                <tr class="table-warning">
                    <td class="text-center align-middle"><?= $r ?></td>
                    <td class="align-middle">
                        <strong><?= $row->product_code ?></strong> — <?= $row->product_name ?><?= $row->variant ? ' <span class="badge bg-label-secondary">' . $row->variant . '</span>' : '' ?>
                        <?= $row->second_name ? '<br><small class="text-muted">' . $row->second_name . '</small>' : '' ?>
                        <?= $row->details ? '<br><small>' . $row->details . '</small>' : '' ?>
                    </td>
                    <?php if ($Settings->indian_gst) { ?><td class="text-center"><?= $row->hsn_code ?: '' ?></td><?php } ?>
                    <td class="text-center"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code ?></td>
                    <?php if ($inv->status == 'partial') { ?><td class="text-center"><?= $this->sma->formatQuantity($row->quantity_received) . ' ' . $row->product_unit_code ?></td><?php } ?>
                    <td class="text-end"><?= $this->sma->formatMoney($row->unit_cost) ?></td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($row->item_tax) ?></td>
                    <?php } ?>
                    <?php if ($Settings->product_discount != 0 && $inv->product_discount != 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($row->item_discount) ?></td>
                    <?php } ?>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($row->subtotal) ?></td>
                </tr>
                    <?php $r++; } ?>
                <?php } ?>
                </tbody>
                <tfoot>
                <?php
                $col = $Settings->indian_gst ? 5 : 4;
                if ($inv->status == 'partial') $col++;
                if ($Settings->product_discount && $inv->product_discount != 0) $col++;
                if ($Settings->tax1 && $inv->product_tax > 0) $col++;
                ?>
                <?php if ($inv->grand_total != $inv->total) { ?>
                <tr class="table-light">
                    <td colspan="<?= ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) ? $col - 2 : (($Settings->product_discount && $inv->product_discount != 0) || ($Settings->tax1 && $inv->product_tax > 0) ? $col - 1 : $col) ?>" class="text-end">
                        <?= lang('total') ?> (<?= $default_currency->code ?>)
                    </td>
                    <?php if ($Settings->tax1 && $inv->product_tax > 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? $inv->product_tax + $return_purchase->product_tax : $inv->product_tax) ?></td>
                    <?php } ?>
                    <?php if ($Settings->product_discount && $inv->product_discount != 0) { ?>
                    <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? $inv->product_discount + $return_purchase->product_discount : $inv->product_discount) ?></td>
                    <?php } ?>
                    <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? ($inv->total + $inv->product_tax) + ($return_purchase->total + $return_purchase->product_tax) : $inv->total + $inv->product_tax) ?></td>
                </tr>
                <?php } ?>

                <?php if ($return_purchase) { ?>
                <tr class="table-warning">
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('return_total') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($return_purchase->grand_total) ?></td>
                </tr>
                <?php } ?>

                <?php if ($inv->order_discount != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_discount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= ($inv->order_discount_id ? '<small class="text-muted">(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($return_purchase ? $inv->order_discount + $return_purchase->order_discount : $inv->order_discount) ?></td>
                </tr>
                <?php } ?>

                <?php if ($Settings->tax2 && $inv->order_tax != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('order_tax') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($return_purchase ? $inv->order_tax + $return_purchase->order_tax : $inv->order_tax) ?></td>
                </tr>
                <?php } ?>

                <?php if ($inv->shipping != 0) { ?>
                <tr>
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('shipping') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($inv->shipping) ?></td>
                </tr>
                <?php } ?>

                <tr class="table-primary">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('total_amount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($return_purchase ? $inv->grand_total + $return_purchase->grand_total : $inv->grand_total) ?></td>
                </tr>
                <tr class="table-success">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('paid') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($return_purchase ? $inv->paid + $return_purchase->paid : $inv->paid) ?></td>
                </tr>
                <tr class="table-warning">
                    <td colspan="<?= $col ?>" class="text-end fw-bold"><?= lang('balance') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold">
                        <?= $this->sma->formatMoney(($return_purchase ? $inv->grand_total + $return_purchase->grand_total : $inv->grand_total) - ($return_purchase ? $inv->paid + $return_purchase->paid : $inv->paid)) ?>
                    </td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Note + meta -->
<div class="row g-4 mb-4">
    <div class="col-md-7">
        <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_purchase ? $inv->product_tax + $return_purchase->product_tax : $inv->product_tax), true) : '' ?>
        <?php if ($inv->note && $inv->note != '') { ?>
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><span class="ri-sticky-note-line me-1"></span><?= lang('note') ?></h6>
                <div class="text-muted"><?= $this->sma->decode_html($inv->note) ?></div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><span class="ri-user-settings-line me-1"></span><?= lang('created_by') ?></h6>
                <dl class="row mb-0 small">
                    <dt class="col-sm-5"><?= lang('created_by') ?></dt>
                    <dd class="col-sm-7"><?= $created_by->first_name . ' ' . $created_by->last_name ?></dd>
                    <dt class="col-sm-5"><?= lang('date') ?></dt>
                    <dd class="col-sm-7"><?= $this->sma->hrld($inv->date) ?></dd>
                    <?php if ($inv->updated_by) { ?>
                    <dt class="col-sm-5"><?= lang('updated_by') ?></dt>
                    <dd class="col-sm-7"><?= $updated_by->first_name . ' ' . $updated_by->last_name ?></dd>
                    <dt class="col-sm-5"><?= lang('update_at') ?></dt>
                    <dd class="col-sm-7"><?= $this->sma->hrld($inv->updated_at) ?></dd>
                    <?php } ?>
                </dl>
            </div>
        </div>
    </div>
</div>

<!-- Payments table -->
<?php if (!empty($payments)) { ?>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0"><span class="ri-bank-card-line me-2"></span><?= lang('payments') ?></h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('payment_reference') ?></th>
                    <th><?= lang('paid_by') ?></th>
                    <th class="text-end"><?= lang('amount') ?></th>
                    <th><?= lang('created_by') ?></th>
                    <th><?= lang('type') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($payments as $payment) { ?>
                <tr>
                    <td><?= $this->sma->hrld($payment->date) ?></td>
                    <td><?= $payment->reference_no ?></td>
                    <td><?= $payment->paid_by ?></td>
                    <td class="text-end fw-bold"><?= $payment->amount ?></td>
                    <td><?= $payment->first_name . ' ' . $payment->last_name ?></td>
                    <td><span class="badge bg-label-primary"><?= $payment->type ?></span></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php } ?>

<?php include(dirname(__FILE__) . '/../partials/attachments.php'); ?>
