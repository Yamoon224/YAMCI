<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('transfer') ?: 'Transfert' ?> <span class="text-primary">#<?= htmlspecialchars($transfer->transfer_no) ?></span></h4>
    <p class="mb-0 text-muted"><?= lang('date') ?>: <?= $this->sma->hrld($transfer->date) ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= site_url('admin/welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('transfers') ?>"><?= lang('transfers') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= $transfer->transfer_no ?></li>
      </ol>
    </nav>
  </div>
  <?php if (!$Supplier && !$Customer): ?>
  <div class="d-flex gap-2 align-content-center flex-wrap">
        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="window.print();">
            <span class="icon-base ri ri-printer-line icon-20px me-1"></span><?= lang('print') ?>
        </button>
        <a href="<?= admin_url('transfers/email/' . $transfer->id) ?>" data-bs-toggle="modal" data-bs-target="#myModal2"
           class="btn btn-outline-info btn-sm">
            <span class="icon-base ri ri-mail-send-line icon-20px me-1"></span><?= lang('email') ?>
        </a>
        <a href="<?= admin_url('transfers/pdf/' . $transfer->id) ?>" class="btn btn-outline-secondary btn-sm">
            <span class="icon-base ri ri-file-pdf-line icon-20px me-1"></span><?= lang('pdf') ?>
        </a>
        <?php if ($Owner || ($GP && $GP['transfers-edit'])) { ?>
        <a href="<?= admin_url('transfers/edit/' . $transfer->id) ?>" class="btn btn-outline-warning btn-sm sledit">
            <span class="icon-base ri ri-edit-line icon-20px me-1"></span><?= lang('edit') ?>
        </a>
        <?php } ?>
        <?php if ($Owner || ($GP && $GP['transfers-delete'])) { ?>
        <a href="#" class="btn btn-outline-danger btn-sm bpo"
           title="<b><?= lang('delete') ?></b>"
           data-content="<div style='width:160px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger btn-sm' href='<?= admin_url('transfers/delete/' . $transfer->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn btn-secondary btn-sm bpo-close'><?= lang('no') ?></button></div>"
           data-html="true" data-placement="top">
            <span class="icon-base ri ri-delete-bin-line icon-20px me-1"></span><?= lang('delete') ?>
        </a>
        <?php } ?>
  </div>
  <?php endif; ?>
</div>

<!-- Transfer info: From / To / Document details -->
<div class="row g-4 mb-4">
    <!-- From warehouse -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <span class="icon-base ri ri-building-line icon-20px"></span>
                        </span>
                    </div>
                    <div>
                        <p class="mb-1 small text-muted text-uppercase fw-bold"><?= lang('from') ?></p>
                        <h6 class="fw-bold mb-1"><?= $from_warehouse->name . ' (' . $from_warehouse->code . ')' ?></h6>
                        <?php if ($from_warehouse->address) { ?><p class="mb-1 small"><?= $from_warehouse->address ?></p><?php } ?>
                        <?php if ($from_warehouse->phone) { ?><p class="mb-1 small"><span class="icon-base ri ri-phone-line icon-20px me-1"></span><?= $from_warehouse->phone ?></p><?php } ?>
                        <?php if ($from_warehouse->email) { ?><p class="mb-0 small"><span class="icon-base ri ri-mail-line icon-20px me-1"></span><?= $from_warehouse->email ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- To warehouse -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <span class="icon-base ri ri-building-2-line icon-20px"></span>
                        </span>
                    </div>
                    <div>
                        <p class="mb-1 small text-muted text-uppercase fw-bold"><?= lang('to') ?></p>
                        <h6 class="fw-bold mb-1"><?= $to_warehouse->name . ' (' . $to_warehouse->code . ')' ?></h6>
                        <?php if ($to_warehouse->address) { ?><p class="mb-1 small"><?= $to_warehouse->address ?></p><?php } ?>
                        <?php if ($to_warehouse->phone) { ?><p class="mb-1 small"><span class="icon-base ri ri-phone-line icon-20px me-1"></span><?= $to_warehouse->phone ?></p><?php } ?>
                        <?php if ($to_warehouse->email) { ?><p class="mb-0 small"><span class="icon-base ri ri-mail-line icon-20px me-1"></span><?= $to_warehouse->email ?></p><?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transfer info -->
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <span class="icon-base ri ri-file-text-line icon-20px"></span>
                        </span>
                    </div>
                    <div class="w-100">
                        <h6 class="fw-bold mb-2"><?= lang('ref') ?>: <?= $transfer->transfer_no ?></h6>
                        <p class="mb-1 small"><strong><?= lang('date') ?>:</strong> <?= $this->sma->hrld($transfer->date) ?></p>
                        <p class="mb-1 small">
                            <strong><?= lang('status') ?>:</strong>
                            <?php
                            $statusMap = [
                                'completed' => 'bg-label-success',
                                'pending'   => 'bg-label-warning',
                                'sent'      => 'bg-label-info',
                                'cancelled' => 'bg-label-danger',
                            ];
                            $sc = $statusMap[$transfer->status] ?? 'bg-label-secondary';
                            ?>
                            <span class="badge <?= $sc ?>"><?= lang($transfer->status) ?></span>
                        </p>
                        <?php if ($transfer->shipping > 0) { ?>
                        <p class="mb-1 small"><strong><?= lang('shipping') ?>:</strong> <?= $this->sma->formatMoney($transfer->shipping) ?></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Barcode / QR -->
<div class="card mb-4 no-print">
    <div class="card-body d-flex align-items-center gap-4 flex-wrap">
        <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($transfer->transfer_no) . '/code128/74/0/1') ?>"
             alt="<?= $transfer->transfer_no ?>" class="bcimg" />
        <?= $this->sma->qrcode('link', urlencode(admin_url('transfers/view/' . $transfer->id)), 2) ?>
    </div>
</div>

<!-- Transferred items table -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-shopping-bag-line icon-20px me-2"></span><?= lang('order_items') ?>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                <tr>
                    <th style="width:40px; text-align:center;">#</th>
                    <th><?= lang('description') ?></th>
                    <?php if ($Settings->indian_gst) { ?><th><?= lang('hsn_code') ?></th><?php } ?>
                    <th class="text-center"><?= lang('quantity') ?></th>
                    <th class="text-end"><?= lang('unit_cost') ?></th>
                    <?php if ($Settings->tax1) { ?><th class="text-end"><?= lang('tax') ?></th><?php } ?>
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
                    </td>
                    <?php if ($Settings->indian_gst) { ?><td class="text-center align-middle"><?= $row->hsn_code ?></td><?php } ?>
                    <td class="text-center align-middle"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code ?></td>
                    <td class="text-end align-middle"><?= $this->sma->formatMoney($row->net_unit_cost) ?></td>
                    <?php if ($Settings->tax1) { ?>
                    <td class="text-end align-middle">
                        <?= $Settings->indian_gst ? '<small class="text-muted">(' . $row->tax . ')</small> ' : '' ?>
                        <?= $this->sma->formatMoney($row->item_tax) ?>
                    </td>
                    <?php } ?>
                    <td class="text-end align-middle fw-bold"><?= $this->sma->formatMoney($row->subtotal) ?></td>
                </tr>
                <?php $r++; } ?>
                </tbody>
                <tfoot>
                <?php
                $col = $Settings->indian_gst ? 4 : 3;
                if ($Settings->tax1) $col++;
                ?>
                <tr class="table-light">
                    <td colspan="<?= $col ?>" class="text-end"><?= lang('total') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end"><?= $this->sma->formatMoney($transfer->total_tax) ?></td>
                    <td class="text-end"><?= $this->sma->formatMoney($transfer->total + $transfer->total_tax) ?></td>
                </tr>
                <?php if ($Settings->indian_gst) {
                    if ($transfer->cgst > 0) {
                        echo '<tr><td colspan="' . ($col + 1) . '" class="text-end">' . lang('cgst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($transfer->cgst) : $transfer->cgst) . '</td></tr>';
                    }
                    if ($transfer->sgst > 0) {
                        echo '<tr><td colspan="' . ($col + 1) . '" class="text-end">' . lang('sgst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($transfer->sgst) : $transfer->sgst) . '</td></tr>';
                    }
                    if ($transfer->igst > 0) {
                        echo '<tr><td colspan="' . ($col + 1) . '" class="text-end">' . lang('igst') . ' (' . $default_currency->code . ')</td><td class="text-end">' . ($Settings->format_gst ? $this->sma->formatMoney($transfer->igst) : $transfer->igst) . '</td></tr>';
                    }
                } ?>
                <tr class="table-primary">
                    <td colspan="<?= $col + 1 ?>" class="text-end fw-bold"><?= lang('total_amount') ?> (<?= $default_currency->code ?>)</td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($transfer->grand_total) ?></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Notes + signatures -->
<div class="row g-4 mb-4">
    <div class="col-md-7">
        <?php if ($transfer->note && $transfer->note != '') { ?>
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-2"><span class="icon-base ri ri-sticky-note-line icon-20px me-1"></span><?= lang('note') ?></h6>
                <div class="text-muted"><?= $this->sma->decode_html($transfer->note) ?></div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-body">
                <h6 class="fw-bold mb-3"><span class="icon-base ri ri-user-settings-line icon-20px me-1"></span><?= lang('created_by') ?></h6>
                <dl class="row mb-3 small">
                    <dt class="col-sm-5"><?= lang('created_by') ?></dt>
                    <dd class="col-sm-7"><?= $created_by->first_name . ' ' . $created_by->last_name ?></dd>
                    <?php if (isset($updated_by)) { ?>
                    <dt class="col-sm-5"><?= lang('updated_by') ?></dt>
                    <dd class="col-sm-7"><?= $updated_by->first_name . ' ' . $updated_by->last_name ?></dd>
                    <?php } ?>
                </dl>
                <div class="row g-2 small">
                    <div class="col-6 border-top pt-3">
                        <p class="text-muted mb-4"><?= lang('stamp_sign') ?></p>
                        <p class="fw-bold"><?= lang('created_by') ?></p>
                    </div>
                    <div class="col-6 border-top pt-3">
                        <p class="text-muted mb-4"><?= lang('stamp_sign') ?></p>
                        <p class="fw-bold"><?= lang('received_by') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include(dirname(__FILE__) . '/../partials/attachments.php'); ?>

<script type="text/javascript">
    $(document).ready(function () { $('.tip').tooltip(); });
</script>
