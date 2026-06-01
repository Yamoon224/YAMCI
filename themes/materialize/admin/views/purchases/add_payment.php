<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="icon-base ri ri-bank-card-line icon-20px me-2"></span><?= lang('add_payment') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
        </div>
        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('purchases/add_payment/' . $inv->id, $attrib);
        ?>
        <div class="modal-body">
            <div class="row g-3">
                <?php if ($Owner || $Admin) { ?>
                <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                        <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ''), 'class="form-control datetime" id="date" required placeholder=" "') ?>
                        <label for="date"><?= lang('date') ?></label>
                    </div>
                </div>
                <?php } ?>
                <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                        <?= form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $payment_ref), 'class="form-control" id="reference_no" placeholder=" "') ?>
                        <label for="reference_no"><?= lang('reference_no') ?></label>
                    </div>
                </div>
                <input type="hidden" value="<?= $inv->id ?>" name="purchase_id" />
            </div>

            <div class="row g-3 mt-1">
                <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                        <input name="amount-paid" type="text" id="amount_1"
                               value="<?= $this->sma->formatDecimal($inv->grand_total - $inv->paid) ?>"
                               class="pa form-control kb-pad amount" required placeholder=" " />
                        <label for="amount_1"><?= lang('amount') ?></label>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-floating form-floating-outline">
                        <select name="paid_by" id="paid_by_1" class="form-select paid_by" required>
                            <?= $this->sma->paid_opts(false, true) ?>
                        </select>
                        <label for="paid_by_1"><?= lang('paying_by') ?></label>
                    </div>
                </div>
            </div>

            <!-- Credit card fields -->
            <div class="pcc_1 mt-3" style="display:none;">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input name="pcc_no" type="text" id="pcc_no_1" class="form-control" placeholder="<?= lang('cc_no') ?>" />
                    </div>
                    <div class="col-md-6">
                        <input name="pcc_holder" type="text" id="pcc_holder_1" class="form-control" placeholder="<?= lang('cc_holder') ?>" />
                    </div>
                    <div class="col-md-3">
                        <select name="pcc_type" id="pcc_type_1" class="form-select pcc_type">
                            <option value="Visa"><?= lang('Visa') ?></option>
                            <option value="MasterCard"><?= lang('MasterCard') ?></option>
                            <option value="Amex"><?= lang('Amex') ?></option>
                            <option value="Discover"><?= lang('Discover') ?></option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input name="pcc_month" type="text" id="pcc_month_1" class="form-control" placeholder="<?= lang('month') ?>" />
                    </div>
                    <div class="col-md-3">
                        <input name="pcc_year" type="text" id="pcc_year_1" class="form-control" placeholder="<?= lang('year') ?>" />
                    </div>
                    <div class="col-md-3">
                        <input name="pcc_ccv" type="text" id="pcc_cvv2_1" class="form-control" placeholder="<?= lang('cvv2') ?>" />
                    </div>
                </div>
            </div>

            <!-- Cheque field -->
            <div class="pcheque_1 mt-3" style="display:none;">
                <div class="form-floating form-floating-outline">
                    <input name="cheque_no" type="text" id="cheque_no_1" class="form-control cheque_no" placeholder=" " />
                    <label for="cheque_no_1"><?= lang('cheque_no') ?></label>
                </div>
            </div>

            <!-- Attachment -->
            <div class="mt-3">
                <label for="attachment" class="form-label"><?= lang('attachment') ?></label>
                <input id="attachment" type="file" name="userfile" class="form-control"
                       data-show-upload="false" data-show-preview="false" />
            </div>

            <!-- Note -->
            <div class="mt-3">
                <div class="form-floating form-floating-outline">
                    <?= form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ''), 'class="form-control" id="note" style="height:80px;" placeholder=" "') ?>
                    <label for="note"><?= lang('note') ?></label>
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
            <?= form_submit('add_payment', lang('add_payment'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
        $.fn.datetimepicker.dates['sma'] = <?= $dp_lang ?>;
        $(document).on('change', '.paid_by', function () {
            var p_val = $(this).val();
            localStorage.setItem('paid_by', p_val);
            if (p_val == 'cash') {
                $('.pcheque_1').hide(); $('.pcc_1').hide(); $('.pcash_1').show(); $('#amount_1').focus();
            } else if (p_val == 'CC') {
                $('.pcheque_1').hide(); $('.pcash_1').hide(); $('.pcc_1').show(); $('#pcc_no_1').focus();
            } else if (p_val == 'Cheque') {
                $('.pcc_1').hide(); $('.pcash_1').hide(); $('.pcheque_1').show(); $('#cheque_no_1').focus();
            } else {
                $('.pcheque_1').hide(); $('.pcc_1').hide(); $('.pcash_1').hide();
            }
        });
        $('#pcc_no_1').change(function () {
            var ccn1 = $(this).val().charAt(0);
            var CardType = ccn1 == 4 ? 'Visa' : ccn1 == 5 ? 'MasterCard' : ccn1 == 3 ? 'Amex' : ccn1 == 6 ? 'Discover' : 'Visa';
            $('#pcc_type_1').val(CardType);
        });
        $("#date").datetimepicker({
            format: site.dateFormats.js_ldate, fontAwesome: true, language: 'sma',
            weekStart: 1, todayBtn: 1, autoclose: 1, todayHighlight: 1, startView: 2, forceParse: 0
        }).datetimepicker('update', new Date());
    });
</script>
