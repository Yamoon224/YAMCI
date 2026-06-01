<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="myModalLabel">
        <span class="icon-base ri ri-bank-card-line me-2 icon-20px"></span><?= lang('add_payment'); ?>
      </h5>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close'); ?>"></button>
    </div>
    <?php
    $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
    echo admin_form_open_multipart('pos/add_payment/' . $inv->id, $attrib);
    ?>
    <div class="modal-body">
      <!-- Outstanding balance info -->
      <div class="alert alert-info d-flex align-items-center mb-3 py-2">
        <span class="icon-base ri ri-information-line me-2 icon-20px"></span>
        <div>
          <strong><?= lang('outstanding_balance'); ?>:</strong>
          <span class="ms-1 fw-bold"><?= $this->sma->formatMoney($inv->grand_total - $inv->paid); ?></span>
          &nbsp;|&nbsp;
          <strong><?= lang('grand_total'); ?>:</strong>
          <span class="ms-1"><?= $this->sma->formatMoney($inv->grand_total); ?></span>
        </div>
      </div>

      <input type="hidden" value="<?= $inv->id; ?>" name="sale_id" />

      <div class="row g-3">
        <?php if ($Owner || $Admin): ?>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ''), 'class="form-control datetime" id="date" required placeholder=" "'); ?>
            <label for="date">
              <span class="icon-base ri ri-calendar-line me-1 icon-16px"></span><?= lang('date'); ?>
            </label>
          </div>
        </div>
        <?php endif; ?>
        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <?= form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $payment_ref), 'class="form-control" id="reference_no" placeholder=" "'); ?>
            <label for="reference_no">
              <span class="icon-base ri ri-hashtag me-1 icon-16px"></span><?= lang('reference_no'); ?>
            </label>
          </div>
        </div>

        <!-- Amount & payment method -->
        <div class="col-sm-6">
          <div class="ngc">
            <div class="form-floating form-floating-outline">
              <input name="amount-paid" type="text" id="amount_1"
                     value="<?= $this->sma->formatDecimal($inv->grand_total - $inv->paid); ?>"
                     class="pa form-control kb-pad amount" required placeholder=" " />
              <label for="amount_1">
                <span class="icon-base ri ri-money-dollar-circle-line me-1 icon-16px"></span><?= lang('amount'); ?>
              </label>
            </div>
          </div>
          <div class="gc mt-2" style="display:none;">
            <div class="form-floating form-floating-outline">
              <input name="gift_card_no" type="text" id="gift_card_no" class="pa form-control kb-pad" placeholder=" " />
              <label for="gift_card_no"><?= lang('gift_card_no'); ?></label>
            </div>
            <div id="gc_details" class="mt-1 text-muted small"></div>
          </div>
        </div>

        <div class="col-sm-6">
          <div class="form-floating form-floating-outline">
            <select name="paid_by" id="paid_by_1" class="form-select paid_by" required>
              <?= $this->sma->paid_opts(); ?>
              <?= $pos_settings->paypal_pro ? '<option value="ppp">' . lang('paypal_pro') . '</option>' : ''; ?>
              <?= $pos_settings->stripe ? '<option value="stripe">' . lang('stripe') . '</option>' : ''; ?>
              <?= $pos_settings->authorize ? '<option value="authorize">' . lang('authorize') . '</option>' : ''; ?>
            </select>
            <label for="paid_by_1">
              <span class="icon-base ri ri-bank-card-line me-1 icon-16px"></span><?= lang('paying_by'); ?>
            </label>
          </div>
        </div>
      </div>

      <!-- Credit card fields -->
      <div class="pcc_1 mt-3" style="display:none;">
        <div class="row g-2">
          <div class="col-12">
            <input type="text" id="swipe_1" class="form-control swipe" placeholder="<?= lang('swipe'); ?>" />
          </div>
          <div class="col-6">
            <input name="pcc_no" type="text" id="pcc_no_1" class="form-control" placeholder="<?= lang('cc_no'); ?>" />
          </div>
          <div class="col-6">
            <input name="pcc_holder" type="text" id="pcc_holder_1" class="form-control" placeholder="<?= lang('cc_holder'); ?>" />
          </div>
          <div class="col-3">
            <select name="pcc_type" id="pcc_type_1" class="form-select pcc_type">
              <option value="Visa"><?= lang('Visa'); ?></option>
              <option value="MasterCard"><?= lang('MasterCard'); ?></option>
              <option value="Amex"><?= lang('Amex'); ?></option>
              <option value="Discover"><?= lang('Discover'); ?></option>
            </select>
          </div>
          <div class="col-3">
            <input name="pcc_month" type="text" id="pcc_month_1" class="form-control" placeholder="<?= lang('month'); ?>" />
          </div>
          <div class="col-3">
            <input name="pcc_year" type="text" id="pcc_year_1" class="form-control" placeholder="<?= lang('year'); ?>" />
          </div>
          <div class="col-3" id="ppp-stripe">
            <input name="pcc_ccv" type="text" id="pcc_cvv2_1" class="form-control" placeholder="<?= lang('cvv2'); ?>" />
          </div>
        </div>
      </div>

      <!-- Cheque field -->
      <div class="pcheque_1 mt-3" style="display:none;">
        <div class="form-floating form-floating-outline">
          <input name="cheque_no" type="text" id="cheque_no_1" class="form-control cheque_no" placeholder=" " />
          <label for="cheque_no_1"><?= lang('cheque_no'); ?></label>
        </div>
      </div>

      <!-- Attachment -->
      <div class="mt-3">
        <label for="attachment" class="form-label">
          <span class="icon-base ri ri-attachment-line me-1 icon-16px"></span><?= lang('attachment'); ?>
        </label>
        <input id="attachment" type="file" name="userfile" class="form-control"
               data-browse-label="<?= lang('browse'); ?>" data-show-upload="false" data-show-preview="false" />
      </div>

      <!-- Note -->
      <div class="mt-3">
        <div class="form-floating form-floating-outline">
          <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control" id="note" style="height:80px;" placeholder=" "'); ?>
          <label for="note">
            <span class="icon-base ri ri-file-text-line me-1 icon-16px"></span><?= lang('note'); ?>
          </label>
        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
        <span class="icon-base ri ri-close-line me-1 icon-16px"></span><?= lang('close'); ?>
      </button>
      <?= form_submit('add_payment', lang('add_payment'), 'class="btn btn-primary"'); ?>
    </div>
    <?= form_close(); ?>
  </div>
</div>

<script type="text/javascript" src="<?= $assets; ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
  if (typeof $.fn.datetimepicker !== 'undefined') {
    $.fn.datetimepicker.dates['sma'] = <?= $dp_lang; ?>;
  }
</script>
<script type="text/javascript" src="<?= $assets; ?>pos/js/parse-track-data.js"></script>
<?= $modal_js; ?>
<script>
$(document).ready(function () {
  $(document).on('change', '#gift_card_no', function () {
    var cn = $(this).val();
    if (cn) {
      $.ajax({
        type: "get", async: false,
        url: site.base_url + "sales/validate_gift_card/" + cn,
        dataType: "json",
        success: function (data) {
          if (data === false) {
            bootbox && bootbox.alert('<?= lang('incorrect_gift_card'); ?>');
          } else if (data.customer_id !== null && data.customer_id != <?= $inv->customer_id; ?>) {
            bootbox && bootbox.alert('<?= lang('gift_card_not_for_customer'); ?>');
          } else {
            var due = <?= $inv->grand_total - $inv->paid; ?>;
            if (due > data.balance) { $('#amount_1').val(formatDecimal(data.balance)); }
            $('#gc_details').html('<small>Card No: <strong>' + data.card_no + '</strong> | Value: ' + currencyFormat(data.value) + ' | Balance: ' + currencyFormat(data.balance) + '</small>');
          }
        }
      });
    }
  });

  $(document).on('change', '.paid_by', function () {
    var p = $(this).val();
    localStorage.setItem('paid_by', p);
    $('#rpaidby').val(p);
    $('.pcash_1,.pcc_1,.pcheque_1').hide();
    $('.ngc').show(); $('.gc').hide();
    if (p === 'cash' || p === 'deposit' || p === 'other') {
      $('.pcash_1').show(); $('#amount_1').focus();
    } else if (p === 'CC' || p === 'stripe' || p === 'ppp' || p === 'authorize') {
      if (p === 'CC') { $('#ppp-stripe').hide(); } else { $('#ppp-stripe').show(); }
      $('.pcc_1').show(); $('#swipe_1').focus();
    } else if (p === 'Cheque') {
      $('.pcheque_1').show(); $('#cheque_no_1').focus();
    } else if (p === 'gift_card') {
      $('.ngc').hide(); $('.gc').show(); $('#gift_card_no').focus();
    }
  });

  $('#pcc_no_1').on('change', function () {
    var c = $(this).val().charAt(0);
    var t = c == 4 ? 'Visa' : c == 5 ? 'MasterCard' : c == 3 ? 'Amex' : c == 6 ? 'Discover' : 'Visa';
    $('#pcc_type_1').val(t);
  });

  $('.swipe').on('keypress', function (e) {
    if (e.keyCode == 13) {
      e.preventDefault();
      var p = new SwipeParserObj($(this).val());
      if (p.hasTrack1) {
        var c = p.account.charAt(0);
        var t = c == 4 ? 'Visa' : c == 5 ? 'MasterCard' : c == 3 ? 'Amex' : 'Discover';
        $('#pcc_no_1').val(p.account);
        $('#pcc_holder_1').val(p.account_name);
        $('#pcc_month_1').val(p.exp_month);
        $('#pcc_year_1').val(p.exp_year);
        $('#pcc_type_1').val(t);
        $(this).val('');
      }
    }
  }).on('blur focus', function () { $(this).val(''); });

  if (typeof $.fn.datetimepicker !== 'undefined') {
    $("#date").datetimepicker({
      format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma',
      weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0
    }).datetimepicker('update', new Date());
  }
});
</script>
