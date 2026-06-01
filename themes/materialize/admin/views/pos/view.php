<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if ($modal): ?>
<div class="modal-dialog modal-lg modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-receipt-line me-2 icon-20px"></span>
        <?= lang('sale_no'); ?> <?= $inv->reference_no; ?>
      </h5>
      <div class="d-flex gap-2 align-items-center no-print">
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
      </div>
    </div>
    <div class="modal-body p-0">
<?php else: ?>
<!doctype html>
<html dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
  <meta charset="utf-8">
  <title><?= $page_title . ' ' . lang('no') . ' ' . $inv->id; ?></title>
  <base href="<?= base_url(); ?>"/>
  <meta http-equiv="cache-control" content="max-age=0"/>
  <meta http-equiv="cache-control" content="no-cache"/>
  <meta http-equiv="expires" content="0"/>
  <meta http-equiv="pragma" content="no-cache"/>
  <link rel="shortcut icon" href="<?= $assets; ?>images/icon.png"/>
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/css/core.css'); ?>" />
  <link rel="stylesheet" href="<?= base_url('themes/materialize/assets/vendor/css/theme-default.css'); ?>" />
  <style>
    body { color: #000; background: #f5f5f5; }
    #wrapper { max-width: 480px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
    @media print {
      .no-print { display: none !important; }
      body { background: #fff; }
      #wrapper { max-width: 100%; margin: 0; padding: 5px; border-radius: 0; box-shadow: none; }
      table tfoot { display: table-row-group; }
    }
  </style>
</head>
<body>
<div id="wrapper">
<?php endif; ?>

  <div id="receiptData" class="p-3">
    <!-- Messages -->
    <?php if ($message): ?>
    <div class="alert alert-success alert-dismissible fade show no-print">
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      <?= is_array($message) ? print_r($message, true) : $message; ?>
    </div>
    <?php endif; ?>

    <!-- Receipt header -->
    <div id="receipt-data">
      <div class="text-center mb-3">
        <?= !empty($biller->logo) ? '<img src="' . base_url('assets/uploads/logos/' . $biller->logo) . '" alt="" style="max-height:80px; max-width:200px;" class="mb-2">' : ''; ?>
        <h5 class="fw-bold text-uppercase mb-1"><?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?></h5>
        <p class="mb-0 small text-muted">
          <?= $biller->address; ?> <?= $biller->city; ?> <?= $biller->postal_code; ?> <?= $biller->state; ?> <?= $biller->country; ?><br>
          <?= lang('tel'); ?>: <?= $biller->phone; ?>
          <?php
          foreach (['cf1' => 'bcf1', 'cf2' => 'bcf2', 'cf3' => 'bcf3', 'cf4' => 'bcf4', 'cf5' => 'bcf5', 'cf6' => 'bcf6'] as $field => $langKey):
            if (!empty($biller->$field) && $biller->$field != '-'):
              echo '<br>' . lang($langKey) . ': ' . $biller->$field;
            endif;
          endforeach;
          if ($pos_settings->cf_title1 != '' && $pos_settings->cf_value1 != '') echo '<br>' . $pos_settings->cf_title1 . ': ' . $pos_settings->cf_value1;
          if ($pos_settings->cf_title2 != '' && $pos_settings->cf_value2 != '') echo '<br>' . $pos_settings->cf_title2 . ': ' . $pos_settings->cf_value2;
          ?>
        </p>
      </div>

      <?php if ($Settings->invoice_view == 1 || $Settings->indian_gst): ?>
      <div class="text-center mb-2"><h6 class="fw-bold"><?= lang('tax_invoice'); ?></h6></div>
      <?php endif; ?>

      <div class="mb-2 small">
        <strong><?= lang('sale_number'); ?>:</strong> <?= $inv->id; ?><br>
        <strong><?= lang('date'); ?>:</strong> <?= $this->sma->hrld($inv->date); ?><br>
        <strong><?= lang('sale_ref'); ?>:</strong> <?= $inv->reference_no; ?><br>
        <?php if (!empty($inv->return_sale_ref)): ?>
        <strong><?= lang('return_ref'); ?>:</strong> <?= $inv->return_sale_ref; ?><br>
        <?php endif; ?>
        <strong><?= lang('sales_person'); ?>:</strong> <?= $created_by->first_name . ' ' . $created_by->last_name; ?>
      </div>

      <div class="mb-2 small">
        <strong><?= lang('customer'); ?>:</strong> <?= ($customer->company && $customer->company != '-' ? $customer->company : $customer->name); ?>
        <?php if ($pos_settings->customer_details):
          if ($customer->vat_no != '-' && $customer->vat_no != '') echo '<br>' . lang('vat_no') . ': ' . $customer->vat_no;
          if ($customer->gst_no != '-' && $customer->gst_no != '') echo '<br>' . lang('gst_no') . ': ' . $customer->gst_no;
          echo '<br>' . lang('tel') . ': ' . $customer->phone;
          echo '<br>' . lang('address') . ': ' . $customer->address;
        endif; ?>
      </div>

      <!-- Items table -->
      <table class="table table-sm table-condensed" style="font-size:0.85rem;">
        <tbody>
          <?php
          $r = 1; $category = 0; $tax_summary = [];
          foreach ($rows as $row):
            if ($pos_settings->item_order == 1 && $category != $row->category_id):
              $category = $row->category_id;
              echo '<tr><td colspan="2"><strong>' . $row->category_name . '</strong></td></tr>';
            endif;
            echo '<tr><td colspan="2">#' . $r . ': ' . product_name($row->product_name, ($printer ? $printer->char_per_line : null)) . ($row->variant ? ' (' . $row->variant . ')' : '') . ($row->serial_no ? '<br>' . $row->serial_no : '') . '<span class="float-end">' . ($row->tax_code ? '*' . $row->tax_code : '') . '</span></td></tr>';
            echo '<tr><td>' . $this->sma->formatQuantity($row->unit_quantity) . ($row->product_unit_code ?: '') . ' x ' . ($row->item_discount != 0 ? '(' . $this->sma->formatMoney($row->unit_price + ($row->item_discount / $row->unit_quantity)) . ' - ' . $this->sma->formatMoney($row->item_discount / $row->unit_quantity) . ')' : $this->sma->formatMoney($row->unit_price)) . ($row->item_tax != 0 ? ' [' . lang('tax') . ' ' . $this->sma->formatMoney($row->item_tax) . ']' : '') . '</td><td class="text-end">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
            $r++;
          endforeach;
          if ($return_rows):
            echo '<tr class="table-warning"><td colspan="2"><strong>' . lang('returned_items') . '</strong></td></tr>';
            foreach ($return_rows as $row):
              echo '<tr><td colspan="2">#' . $r . ': ' . product_name($row->product_name, ($printer ? $printer->char_per_line : null)) . ($row->variant ? ' (' . $row->variant . ')' : '') . '</td></tr>';
              echo '<tr><td>' . $this->sma->formatQuantity($row->unit_quantity) . ' x ' . $this->sma->formatMoney($row->unit_price) . '</td><td class="text-end">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
              $r++;
            endforeach;
          endif;
          ?>
        </tbody>
        <tfoot>
          <tr>
            <th class="border-top"><?= lang('total'); ?></th>
            <th class="text-end border-top"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></th>
          </tr>
          <?php if ($inv->order_tax != 0): ?>
          <tr><th><?= lang('tax'); ?></th><th class="text-end"><?= $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax); ?></th></tr>
          <?php endif; ?>
          <?php if ($inv->order_discount != 0): ?>
          <tr><th><?= lang('order_discount'); ?></th><th class="text-end"><?= $this->sma->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount); ?></th></tr>
          <?php endif; ?>
          <?php if ($inv->shipping != 0): ?>
          <tr><th><?= lang('shipping'); ?></th><th class="text-end"><?= $this->sma->formatMoney($inv->shipping); ?></th></tr>
          <?php endif; ?>
          <?php if ($pos_settings->rounding || $inv->rounding != 0): ?>
          <tr><th><?= lang('rounding'); ?></th><th class="text-end"><?= $this->sma->formatMoney($inv->rounding); ?></th></tr>
          <tr class="table-primary">
            <th class="fw-bold"><?= lang('grand_total'); ?></th>
            <th class="text-end fw-bold"><?= $this->sma->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding) + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding)); ?></th>
          </tr>
          <?php else: ?>
          <tr class="table-primary">
            <th class="fw-bold"><?= lang('grand_total'); ?></th>
            <th class="text-end fw-bold"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></th>
          </tr>
          <?php endif; ?>
          <?php if ($inv->paid < ($inv->grand_total + $inv->rounding)): ?>
          <tr><th><?= lang('paid_amount'); ?></th><th class="text-end"><?= $this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></th></tr>
          <tr class="table-warning">
            <th><?= lang('due_amount'); ?></th>
            <th class="text-end"><?= $this->sma->formatMoney((($return_sale ? ($inv->grand_total + $inv->rounding + $return_sale->grand_total) : ($inv->grand_total + $inv->rounding))) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></th>
          </tr>
          <?php endif; ?>
        </tfoot>
      </table>

      <!-- Payments -->
      <?php if ($payments): ?>
      <table class="table table-sm" style="font-size:0.82rem;">
        <tbody>
          <?php foreach ($payments as $payment):
            echo '<tr>';
            if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
              echo '<td>' . lang('paid_by') . ': <strong>' . lang($payment->paid_by) . '</strong></td>';
              echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
              echo '<td>' . lang('change') . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
            } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
              echo '<td>' . lang('paid_by') . ': <strong>' . lang($payment->paid_by) . '</strong></td>';
              echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid) . '</td>';
              echo '<td>xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
            } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
              echo '<td>' . lang('paid_by') . ': <strong>' . lang($payment->paid_by) . '</strong></td>';
              echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid) . '</td>';
              echo '<td>' . lang('cheque_no') . ': ' . $payment->cheque_no . '</td>';
            } elseif ($payment->paid_by == 'other' && $payment->amount) {
              echo '<td colspan="2">' . lang('paid_by') . ': <strong>' . lang($payment->paid_by) . '</strong></td>';
              echo '<td>' . lang('amount') . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . '</td>';
            }
            echo '</tr>';
          endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>

      <!-- Notes & footer -->
      <?php if ($inv->note): ?><p class="text-center small mt-2"><?= $this->sma->decode_html($inv->note); ?></p><?php endif; ?>
      <?php if ($biller->invoice_footer): ?><p class="text-center small text-muted"><?= $this->sma->decode_html($biller->invoice_footer); ?></p><?php endif; ?>

      <!-- Barcode & QR -->
      <div class="text-center mt-3 order_barcodes">
        <img src="<?= admin_url('misc/barcode/' . $this->sma->base64url_encode($inv->reference_no) . '/code128/74/0/1'); ?>" alt="<?= $inv->reference_no; ?>" class="img-fluid bcimg" />
        <br>
        <?php
        if ($Settings->ksa_qrcode) {
          $qrtext = $this->inv_qrcode->base64([
            'seller' => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
            'vat_no' => $biller->vat_no ?: $biller->get_no,
            'date' => $inv->date,
            'grand_total' => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
            'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
          ]);
          echo $this->sma->qrcode('text', $qrtext, 2);
        } else {
          echo $this->sma->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 2);
        }
        ?>
      </div>
    </div><!-- /receipt-data -->

    <!-- Action buttons -->
    <div class="d-flex gap-2 justify-content-center mt-3 no-print" id="buttons">
      <?php if ($modal): ?>
        <?php if ($pos->remote_printing == 1): ?>
        <button onclick="window.print();" class="btn btn-primary">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <?php else: ?>
        <button onclick="return printReceipt()" class="btn btn-primary">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <?php endif; ?>
        <a class="btn btn-success" href="#" id="email">
          <span class="icon-base ri ri-mail-send-line me-1 icon-16px"></span><?= lang('email'); ?>
        </a>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          <span class="icon-base ri ri-close-line me-1 icon-16px"></span><?= lang('close'); ?>
        </button>
      <?php else: ?>
        <?php if ($pos->remote_printing == 1): ?>
        <button onclick="window.print();" class="btn btn-primary">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <?php else: ?>
        <button onclick="return printReceipt()" class="btn btn-primary">
          <span class="icon-base ri ri-printer-line me-1 icon-16px"></span><?= lang('print'); ?>
        </button>
        <?php endif; ?>
        <a class="btn btn-success" href="#" id="email">
          <span class="icon-base ri ri-mail-send-line me-1 icon-16px"></span><?= lang('email'); ?>
        </a>
        <a class="btn btn-warning" href="<?= admin_url('pos'); ?>">
          <span class="icon-base ri ri-arrow-left-line me-1 icon-16px"></span><?= lang('back_to_pos'); ?>
        </a>
      <?php endif; ?>
    </div>
  </div><!-- /receiptData -->

<?php if ($modal): ?>
    </div><!-- /.modal-body -->
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<?php else: ?>
</div><!-- /#wrapper -->
<?php if (!$modal): ?>
<script src="<?= $assets; ?>js/jquery-2.0.3.min.js"></script>
<script src="<?= $assets; ?>js/bootstrap.min.js"></script>
<script src="<?= $assets; ?>js/custom.js"></script>
<?php endif; ?>
</body>
</html>
<?php endif; ?>

<script>
$(document).ready(function () {
  $('#email').click(function () {
    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: '<?= lang('email_address'); ?>',
        input: 'email',
        inputValue: '<?= $customer->email; ?>',
        showCancelButton: true,
        confirmButtonText: '<?= lang('send'); ?>'
      }).then(function (result) {
        if (result.value) {
          $.ajax({
            type: "post",
            url: "<?= admin_url('pos/email_receipt'); ?>",
            data: { <?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: result.value, id: <?= $inv->id; ?> },
            dataType: "json",
            success: function (data) { Swal.fire({ icon: 'success', title: data.msg, timer: 2500, showConfirmButton: false }); },
            error: function () { Swal.fire({ icon: 'error', title: '<?= lang('ajax_request_failed'); ?>' }); }
          });
        }
      });
    } else if (typeof bootbox !== 'undefined') {
      bootbox.prompt({ title: "<?= lang('email_address'); ?>", inputType: 'email', value: "<?= $customer->email; ?>",
        callback: function (email) {
          if (email) {
            $.ajax({ type: "post", url: "<?= admin_url('pos/email_receipt'); ?>",
              data: { <?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: <?= $inv->id; ?> },
              dataType: "json", success: function (data) { bootbox.alert(data.msg); }
            });
          }
        }
      });
    }
    return false;
  });
});
<?php if ($pos_settings->remote_printing == 1): ?>
$(window).on('load', function () { window.print(); });
<?php endif; ?>
</script>
<?php include 'remote_printing.php'; ?>
<?php if ($modal): ?>
<?= $modal_js; ?>
<?php endif; ?>
