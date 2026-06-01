<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-shield-star-line icon-20px me-2 text-warning"></i><?= lang('edit_brand') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'editBrandForm'];
        echo admin_form_open_multipart('system_settings/edit_brand/' . $brand->id, $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('update_info') ?></p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', $brand->code, 'class="form-control" id="code" placeholder="' . lang('code') . '"') ?>
                        <label for="code"><?= lang('code') ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', $brand->name, 'class="form-control gen_slug" id="name" placeholder="' . lang('name') . '" required="required"') ?>
                        <label for="name"><?= lang('name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('slug', set_value('slug', $brand->slug), 'class="form-control" id="slug" placeholder="' . lang('slug') . '" required="required"') ?>
                        <label for="slug"><?= lang('slug') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('description', set_value('description', $brand->description), 'class="form-control" id="description" placeholder="' . lang('description') . '"') ?>
                        <label for="description"><?= lang('description') ?></label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="image" class="form-label"><?= lang('image') ?></label>
                    <input id="image" type="file" name="userfile" class="form-control"
                           data-browse-label="<?= lang('browse') ?>" data-show-upload="false" data-show-preview="false">
                </div>
                <?= form_hidden('id', $brand->id) ?>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_brand', lang('edit_brand'), 'class="btn btn-warning"') ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?= $modal_js ?>
<script>
$(document).ready(function () {
    $('.gen_slug').on('change', function () {
        getSlug($(this).val(), 'brand');
    });
});
</script>
