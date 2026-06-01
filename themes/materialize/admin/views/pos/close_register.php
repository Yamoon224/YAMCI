<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-store-3-line me-2 icon-20px"></span>
        <?= lang('close_register') . ' (' . $this->sma->hrld($register_open_time ? $register_open_time : $this->session->userdata('register_open_time')) . ' — ' . $this->sma->hrld(date('Y-m-d H:i:s')) . ')'; ?>
      </h5>
      <div class="d-flex gap-2 align-items-center">
        <button type="button" class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
      </div>
    </div>
    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
    echo admin_form_open_multipart('pos/close_register/' . $user_id, $attrib);
    ?>
    <div class="modal-body">
      <div id="alerts"></div>

      <!-- Register Summary Table -->
      <div class="table-responsive mb-3">
        <table class="table table-sm table-bordered align-middle">
          <tbody>
            <tr>
              <td class="fw-semibold"><?= lang('cash_in_hand'); ?></td>
              <td class="text-end fw-semibold"><?= $this->sma->formatMoney($this->session->userdata('cash_in_hand')); ?></td>
            </tr>
            <tr>
              <td><?= lang('cash_sale'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($cashsales->paid ? $cashsales->paid : '0.00') . ' (' . $this->sma->formatMoney($cashsales->total ? $cashsales->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('ch_sale'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($chsales->paid ? $chsales->paid : '0.00') . ' (' . $this->sma->formatMoney($chsales->total ? $chsales->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('cc_sale'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($ccsales->paid ? $ccsales->paid : '0.00') . ' (' . $this->sma->formatMoney($ccsales->total ? $ccsales->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('gc_sale'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($gcsales->paid ? $gcsales->paid : '0.00') . ' (' . $this->sma->formatMoney($gcsales->total ? $gcsales->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('other'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($othersales->paid ? $othersales->paid : '0.00') . ' (' . $this->sma->formatMoney($othersales->total ? $othersales->total : '0.00') . ')'; ?></td>
            </tr>
            <?php if ($pos_settings->paypal_pro): ?>
            <tr>
              <td><?= lang('paypal_pro'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($pppsales->paid ? $pppsales->paid : '0.00') . ' (' . $this->sma->formatMoney($pppsales->total ? $pppsales->total : '0.00') . ')'; ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($pos_settings->stripe): ?>
            <tr>
              <td><?= lang('stripe'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($stripesales->paid ? $stripesales->paid : '0.00') . ' (' . $this->sma->formatMoney($stripesales->total ? $stripesales->total : '0.00') . ')'; ?></td>
            </tr>
            <?php endif; ?>
            <?php if ($pos_settings->authorize): ?>
            <tr>
              <td><?= lang('authorize'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($authorizesales->paid ? $authorizesales->paid : '0.00') . ' (' . $this->sma->formatMoney($authorizesales->total ? $authorizesales->total : '0.00') . ')'; ?></td>
            </tr>
            <?php endif; ?>
            <tr class="table-primary">
              <td class="fw-bold"><?= lang('total_sales'); ?></td>
              <td class="text-end fw-bold"><?= $this->sma->formatMoney($totalsales->paid ? $totalsales->paid : '0.00') . ' (' . $this->sma->formatMoney($totalsales->total ? $totalsales->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('refunds'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($refunds->returned ? $refunds->returned : '0.00') . ' (' . $this->sma->formatMoney($refunds->total ? $refunds->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('Cash Refunds'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($cashrefunds->returned ? $cashrefunds->returned : '0.00') . ' (' . $this->sma->formatMoney($cashrefunds->total ? $cashrefunds->total : '0.00') . ')'; ?></td>
            </tr>
            <tr>
              <td><?= lang('returns'); ?></td>
              <td class="text-end"><?= $this->sma->formatMoney($returns->total ? '-' . $returns->total : '0.00'); ?></td>
            </tr>
            <tr>
              <td><?= lang('expenses'); ?></td>
              <td class="text-end"><?php $expense = $expenses ? $expenses->total : 0; echo $this->sma->formatMoney($expense); ?></td>
            </tr>
            <?php
            $total_cash_amount = $cashsales->paid
              ? (($cashsales->paid + $this->session->userdata('cash_in_hand')) + ($cashrefunds->returned ? $cashrefunds->returned : 0) - ($returns->total ? $returns->total : 0) - $expense)
              : ($this->session->userdata('cash_in_hand') - $expense - ($returns->total ? $returns->total : 0));
            ?>
            <tr class="table-success">
              <td class="fw-bold"><?= lang('total_cash'); ?></td>
              <td class="text-end fw-bold"><?= $this->sma->formatMoney($total_cash_amount); ?></td>
            </tr>
          </tbody>
        </table>
      </div>

      <?php if ($suspended_bills): ?>
      <div class="mb-3">
        <h6 class="fw-semibold"><?= lang('opened_bills'); ?></h6>
        <div class="table-responsive">
          <table class="table table-sm table-bordered table-hover">
            <thead class="table-light">
              <tr>
                <th><?= lang('customer'); ?></th>
                <th><?= lang('date'); ?></th>
                <th class="text-center"><?= lang('total_items'); ?></th>
                <th class="text-end"><?= lang('amount'); ?></th>
                <th style="width:40px;"></th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($suspended_bills as $bill): ?>
              <tr>
                <td><?= $bill->customer; ?></td>
                <td><?= $this->sma->hrld($bill->date); ?></td>
                <td class="text-center"><?= $bill->count; ?></td>
                <td class="text-end"><?= $bill->total; ?></td>
                <td class="text-center">
                  <a href="<?= admin_url('pos/delete/' . $bill->id); ?>"
                     class="btn btn-sm btn-outline-danger po-delete"
                     title="<?= lang('delete_bill'); ?>"
                     data-bill-id="<?= $bill->id; ?>">
                    <span class="icon-base ri ri-delete-bin-line icon-16px"></span>
                  </a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <?php endif; ?>

      <!-- Submission fields -->
      <div class="row g-3 no-print">
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?= form_hidden('total_cash', $total_cash_amount); ?>
            <?= form_input('total_cash_submitted', ($_POST['total_cash_submitted'] ?? $total_cash_amount), 'class="form-control" id="total_cash_submitted" required placeholder=" "'); ?>
            <label for="total_cash_submitted"><?= lang('total_cash'); ?></label>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?= form_hidden('total_cheques', $chsales->total_cheques ?? 0); ?>
            <?= form_input('total_cheques_submitted', ($_POST['total_cheques_submitted'] ?? $chsales->total_cheques ?? 0), 'class="form-control" id="total_cheques_submitted" required placeholder=" "'); ?>
            <label for="total_cheques_submitted"><?= lang('total_cheques'); ?></label>
          </div>
        </div>
        <?php if ($suspended_bills): ?>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?php
            $u = $user_id ? $user_id : $this->session->userdata('user_id');
            $usrs = [];
            if ($Owner || $Admin) { $usrs[-1] = lang('delete_all'); }
            $usrs[0] = lang('leave_opened');
            foreach ($users as $user) {
              if ($user->id != $u) {
                $usrs[$user->id] = $user->first_name . ' ' . $user->last_name;
              }
            }
            echo form_dropdown('transfer_opened_bills', $usrs, ($_POST['transfer_opened_bills'] ?? 0), 'class="form-select select2" id="transfer_opened_bills" data-placeholder="' . lang('transfer_opened_bills') . '"');
            ?>
            <label for="transfer_opened_bills"><?= lang('transfer_opened_bills'); ?></label>
          </div>
        </div>
        <?php endif; ?>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?= form_hidden('total_cc_slips', $ccsales->total_cc_slips ?? 0); ?>
            <?= form_input('total_cc_slips_submitted', ($_POST['total_cc_slips_submitted'] ?? $ccsales->total_cc_slips ?? 0), 'class="form-control" id="total_cc_slips_submitted" required placeholder=" "'); ?>
            <label for="total_cc_slips_submitted"><?= lang('total_cc_slips'); ?></label>
          </div>
        </div>
        <div class="col-12">
          <div class="form-floating form-floating-outline">
            <?= form_textarea('note', ($_POST['note'] ?? ''), 'class="form-control" id="note" style="height:90px;" placeholder=" "'); ?>
            <label for="note"><?= lang('note'); ?></label>
          </div>
        </div>
      </div>
    </div>

    <div class="modal-footer no-print">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <span class="icon-base ri ri-close-line me-1 icon-16px"></span><?= lang('cancel'); ?>
      </button>
      <?= form_submit('close_register', lang('close_register'), 'class="btn btn-danger"'); ?>
    </div>
    <?= form_close(); ?>
  </div>
</div>
<?= $modal_js ?>
<script>
$(document).ready(function () {
  $(document).on('click', '.po-delete', function (e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var link = $(this).attr('href');
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: '<?= lang('r_u_sure'); ?>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<?= lang('i_m_sure'); ?>',
        cancelButtonText: '<?= lang('no'); ?>'
      }).then(function (result) {
        if (result.isConfirmed) {
          $.ajax({
            type: "get", url: link,
            success: function (data) {
              row.remove();
              addAlert(data, 'success');
            },
            error: function () { addAlert('Failed', 'danger'); }
          });
        }
      });
    }
  });

  function addAlert(message, type) {
    var cls = type === 'success' ? 'alert-success' : 'alert-danger';
    $('#alerts').empty().append(
      '<div class="alert ' + cls + ' alert-dismissible fade show">' +
      '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
      message + '</div>'
    );
  }
});
</script>
