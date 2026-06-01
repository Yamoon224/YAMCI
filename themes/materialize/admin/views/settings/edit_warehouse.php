<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-store-2-line icon-20px me-2 text-warning"></i><?= lang('edit_warehouse') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'editWarehouseForm'];
        echo admin_form_open_multipart('system_settings/edit_warehouse/' . $id, $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', $warehouse->code, 'class="form-control" id="code" placeholder="' . lang('code') . '" required="required"') ?>
                        <label for="code"><?= lang('code') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', $warehouse->name, 'class="form-control" id="name" placeholder="' . lang('name') . '" required="required"') ?>
                        <label for="name"><?= lang('name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="price_group" class="form-label"><?= lang('price_group') ?></label>
                    <?php
                    $pgs[''] = lang('select') . ' ' . lang('price_group');
                    foreach ($price_groups as $price_group) {
                        $pgs[$price_group->id] = $price_group->name;
                    }
                    echo form_dropdown('price_group', $pgs, $warehouse->price_group_id, 'class="form-select select2" id="price_group" data-placeholder="' . lang('select') . ' ' . lang('price_group') . '"');
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="tel" name="phone" class="form-control" id="phone"
                               value="<?= htmlspecialchars($warehouse->phone) ?>"
                               placeholder="<?= lang('phone') ?>">
                        <label for="phone"><?= lang('phone') ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <input type="email" name="email" class="form-control" id="email"
                               value="<?= htmlspecialchars($warehouse->email) ?>"
                               placeholder="<?= lang('email') ?>">
                        <label for="email"><?= lang('email') ?></label>
                    </div>
                </div>
                <div class="col-12">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_textarea('address', $warehouse->address, 'class="form-control" id="address" placeholder="' . lang('address') . '" required="required" rows="3"') ?>
                        <label for="address"><?= lang('address') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="image" class="form-label"><?= lang('warehouse_map') ?></label>
                    <input id="image" type="file" name="userfile" class="form-control"
                           data-browse-label="<?= lang('browse') ?>" data-show-upload="false" data-show-preview="false">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_warehouse', lang('edit_warehouse'), 'class="btn btn-warning"') ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?= $modal_js ?>
