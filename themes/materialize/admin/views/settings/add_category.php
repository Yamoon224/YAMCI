<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-price-tag-3-line icon-20px me-2 text-primary"></i><?= lang('add_category') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'addCategoryForm'];
        echo admin_form_open_multipart('system_settings/add_category', $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('enter_info') ?></p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', set_value('code'), 'class="form-control' . ($Settings->use_code_for_slug ? ' gen_slug' : '') . '" id="code" placeholder="' . lang('category_code') . '" required="required"') ?>
                        <label for="code"><?= lang('category_code') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', set_value('name'), 'class="form-control' . ($Settings->use_code_for_slug ? '' : ' gen_slug') . '" id="name" placeholder="' . lang('category_name') . '" required="required"') ?>
                        <label for="name"><?= lang('category_name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('slug', set_value('slug'), 'class="form-control" id="slug" placeholder="' . lang('slug') . '" required="required"') ?>
                        <label for="slug"><?= lang('slug') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('description', set_value('description'), 'class="form-control" id="description" placeholder="' . lang('description') . '"') ?>
                        <label for="description"><?= lang('description') ?></label>
                    </div>
                </div>
                <div class="col-12">
                    <label for="parent" class="form-label"><?= lang('parent_category') ?></label>
                    <?php
                    $cat[''] = lang('select') . ' ' . lang('parent_category');
                    foreach ($categories as $pcat) {
                        $cat[$pcat->id] = $pcat->name;
                    }
                    echo form_dropdown('parent', $cat, ($_POST['parent'] ?? ''), 'class="form-select select2" id="parent" data-placeholder="' . lang('select') . ' ' . lang('parent_category') . '"');
                    ?>
                </div>
                <div class="col-12">
                    <label for="image" class="form-label"><?= lang('category_image') ?></label>
                    <input id="image" type="file" name="userfile" class="form-control"
                           data-browse-label="<?= lang('browse') ?>" data-show-upload="false" data-show-preview="false">
                </div>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                <i class="icon-base ri ri-close-line icon-20px me-1"></i><?= lang('cancel') ?>
            </button>
            <?= form_submit('add_category', lang('add_category'), 'class="btn btn-primary"') ?>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

<?= $modal_js ?>
<script>
$(document).ready(function () {
    $('.gen_slug').on('change', function () {
        getSlug($(this).val(), 'category');
    });
});
</script>
