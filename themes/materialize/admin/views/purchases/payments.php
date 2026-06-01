<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4 no-print">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-bank-card-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('view_payments') ?></h4>
    <p class="mb-0 text-muted">Historique et gestion des paiements de l'achat</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url('welcome') ?>"><?= lang('dashboard') ?></a></li>
        <li class="breadcrumb-item"><a href="<?= admin_url('purchases') ?>"><?= lang('purchases') ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= lang('view_payments') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <button type="button" class="btn btn-outline-secondary" onclick="window.print();">
      <i class="ri ri-printer-line me-1" style="font-size:16px"></i><?= lang('print') ?>
    </button>
  </div>
</div>

<!-- Payments card -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
            <span class="icon-base ri ri-money-dollar-circle-line icon-20px me-2"></span>
            <?= lang('view_payments') ?>
            <?php if (!empty($inv)) { ?>
            <span class="badge bg-label-primary ms-2">
                <?= lang('purchase') . ' ' . lang('reference') . ': ' . $inv->reference_no ?>
            </span>
            <?php } ?>
        </h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table id="POPaymentsData" class="table table-bordered table-hover table-striped mb-0">
                <thead class="table-light">
                <tr>
                    <th><?= lang('date') ?></th>
                    <th><?= lang('reference_no') ?></th>
                    <th><?= lang('purchase_reference') ?></th>
                    <th><?= lang('supplier') ?></th>
                    <th class="text-end"><?= lang('amount') ?></th>
                    <th><?= lang('paying_by') ?></th>
                    <th style="width:30px; text-align:center;">
                        <span class="icon-base ri ri-attachment-2 icon-20px"></span>
                    </th>
                    <th class="text-center no-print" style="width:120px;"><?= lang('actions') ?></th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($payments)) {
                    foreach ($payments as $payment) { ?>
                <tr class="row<?= $payment->id ?>">
                    <td><?= $this->sma->hrld($payment->date) ?></td>
                    <td><?= $payment->reference_no ?></td>
                    <td>
                        <?php if (!empty($payment->purchase_reference)) { ?>
                        <a href="<?= admin_url('purchases/view/' . $payment->purchase_id) ?>">
                            <?= $payment->purchase_reference ?>
                        </a>
                        <?php } elseif (!empty($inv)) { ?>
                        <a href="<?= admin_url('purchases/view/' . $inv->id) ?>">
                            <?= $inv->reference_no ?>
                        </a>
                        <?php } else { echo '-'; } ?>
                    </td>
                    <td><?= !empty($payment->supplier_name) ? $payment->supplier_name : (!empty($inv) && !empty($inv->supplier_name) ? $inv->supplier_name : '-') ?></td>
                    <td class="text-end fw-bold"><?= $this->sma->formatMoney($payment->amount) ?></td>
                    <td>
                        <span class="badge bg-label-<?= ($payment->paid_by == 'cash') ? 'success' : (($payment->paid_by == 'CC') ? 'info' : (($payment->paid_by == 'Cheque') ? 'warning' : 'secondary')) ?>">
                            <?= lang($payment->paid_by) ?>
                        </span>
                    </td>
                    <td class="text-center">
                        <?php if ($payment->attachment) { ?>
                        <a href="<?= admin_url('welcome/download/' . $payment->attachment) ?>"
                           class="btn btn-sm btn-outline-secondary" title="<?= lang('attachment') ?>">
                            <span class="icon-base ri ri-attachment-2 icon-20px"></span>
                        </a>
                        <?php } else { echo '-'; } ?>
                    </td>
                    <td class="text-center no-print">
                        <div class="d-flex justify-content-center gap-1">
                            <a href="<?= admin_url('purchases/payment_note/' . $payment->id) ?>"
                               data-bs-toggle="modal" data-bs-target="#myModal2"
                               class="btn btn-sm btn-outline-secondary" title="<?= lang('note') ?>">
                                <span class="icon-base ri ri-file-text-line icon-20px"></span>
                            </a>
                            <a href="<?= admin_url('purchases/email_payment/' . $payment->id) ?>"
                               class="btn btn-sm btn-outline-info email_payment" title="<?= lang('email') ?>">
                                <span class="icon-base ri ri-mail-line icon-20px"></span>
                            </a>
                            <?php if ($Owner || $Admin) { ?>
                            <a href="<?= admin_url('purchases/edit_payment/' . $payment->id) ?>"
                               data-bs-toggle="modal" data-bs-target="#myModal2"
                               class="btn btn-sm btn-outline-primary" title="<?= lang('edit') ?>">
                                <span class="icon-base ri ri-edit-line icon-20px"></span>
                            </a>
                            <button type="button"
                                    class="btn btn-sm btn-outline-danger po-delete-btn"
                                    data-id="<?= $payment->id ?>"
                                    data-url="<?= admin_url('purchases/delete_payment/' . $payment->id) ?>"
                                    title="<?= lang('delete') ?>">
                                <span class="icon-base ri ri-delete-bin-line icon-20px"></span>
                            </button>
                            <?php } ?>
                        </div>
                    </td>
                </tr>
                    <?php }
                } else { ?>
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <span class="icon-base ri ri-inbox-line icon-20px me-2"></span><?= lang('no_data_available') ?>
                    </td>
                </tr>
                <?php } ?>
                </tbody>
                <?php if (!empty($payments)) { ?>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="4" class="text-end fw-bold"><?= lang('total') ?></td>
                        <td class="text-end fw-bold text-primary">
                            <?php
                            $total_paid = array_sum(array_column((array)$payments, 'amount'));
                            echo $this->sma->formatMoney($total_paid);
                            ?>
                        </td>
                        <td colspan="3"></td>
                    </tr>
                </tfoot>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
    if ($.fn.DataTable && $('#POPaymentsData').length) {
        $('#POPaymentsData').DataTable({
            order: [[0, 'desc']],
            columnDefs: [
                { orderable: false, targets: [6, 7] }
            ]
        });
    }

    $(document).on('click', '.email_payment', function (e) {
        e.preventDefault();
        var link = $(this).attr('href');
        $.get(link, function (data) { bootbox.alert(data.msg); });
        return false;
    });

    $(document).on('click', '.po-delete-btn', function () {
        var id  = $(this).data('id');
        var url = $(this).data('url');
        var row = $(this).closest('tr');
        bootbox.confirm('<?= lang('r_u_sure') ?>', function (result) {
            if (result) {
                $.get(url, function () { row.fadeOut(400, function () { $(this).remove(); }); });
            }
        });
    });
});
</script>
