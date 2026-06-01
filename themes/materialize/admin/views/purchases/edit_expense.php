<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="icon-base ri ri-edit-line icon-20px me-2 text-warning"></span><?= lang('edit_expense') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
        </div>
        <?php
        $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('purchases/edit_expense/' . $expense->id, $attrib);
        ?>
        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <?php if ($Owner || $Admin) { ?>
            <div class="mb-3">
                <label for="date" class="form-label"><?= lang('date') ?> <span class="text-danger">*</span></label>
                <?= form_input('date', ($_POST['date'] ?? $this->sma->hrld($expense->date)), 'class="form-control datetime" id="date" required="required"'); ?>
            </div>
            <?php } ?>

            <div class="mb-3">
                <label for="reference" class="form-label"><?= lang('reference') ?> <span class="text-danger">*</span></label>
                <?= form_input('reference', ($_POST['reference'] ?? $expense->reference), 'class="form-control" id="reference" required="required"'); ?>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label"><?= lang('category') ?></label>
                <?php
                $ct[''] = lang('select') . ' ' . lang('category');
                foreach ($categories as $category) {
                    $ct[$category->id] = $category->name;
                }
                echo form_dropdown('category', $ct, set_value('category', $expense->category_id), 'class="form-select select2" id="category" data-placeholder="' . lang('select') . ' ' . lang('category') . '"');
                ?>
            </div>

            <div class="mb-3">
                <label for="warehouse" class="form-label"><?= lang('warehouse') ?></label>
                <?php
                $wh[''] = lang('select') . ' ' . lang('warehouse');
                foreach ($warehouses as $warehouse) {
                    $wh[$warehouse->id] = $warehouse->name;
                }
                echo form_dropdown('warehouse', $wh, set_value('warehouse', $expense->warehouse_id), 'id="warehouse" class="form-select select2" data-placeholder="' . lang('select') . ' ' . lang('warehouse') . '"');
                ?>
            </div>

            <div class="mb-3">
                <label for="amount" class="form-label"><?= lang('amount') ?> <span class="text-danger">*</span></label>
                <input name="amount" type="text" id="amount" value="<?= $this->sma->formatDecimal($expense->amount) ?>"
                       class="pa form-control kb-pad amount" required="required" />
            </div>

            <div class="mb-3">
                <label for="document" class="form-label"><?= lang('attachments') ?></label>
                <input id="document" type="file" name="attachments[]" multiple class="form-control"
                       data-show-upload="false" data-show-preview="false" />
            </div>

            <div class="mb-3">
                <label for="note" class="form-label"><?= lang('note') ?></label>
                <?= form_textarea('note', ($_POST['note'] ?? $expense->note), 'class="form-control" id="note" style="height:80px;"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>
            <?= form_submit('edit_expense', lang('edit_expense'), 'class="btn btn-warning"'); ?>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<?php echo $modal_js; ?>
