<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-price-tag-3-line icon-20px me-2 text-warning"></i><?= lang('edit_category') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <?php $attrib = ['role' => 'form', 'id' => 'editCategoryForm'];
        echo admin_form_open_multipart('system_settings/edit_category/' . $category->id, $attrib); ?>

        <div class="modal-body">
            <p class="text-muted small mb-3"><?= lang('update_info') ?></p>

            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('code', set_value('code', $category->code), 'class="form-control" id="code" placeholder="' . lang('category_code') . '" required="required"') ?>
                        <label for="code"><?= lang('category_code') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('name', set_value('name', $category->name), 'class="form-control gen_slug" id="name" placeholder="' . lang('category_name') . '" required="required"') ?>
                        <label for="name"><?= lang('category_name') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('slug', set_value('slug', $category->slug), 'class="form-control" id="slug" placeholder="' . lang('slug') . '" required="required"') ?>
                        <label for="slug"><?= lang('slug') ?> <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-12 all">
                    <div class="form-floating form-floating-outline mb-3">
                        <?= form_input('description', set_value('description', $category->description), 'class="form-control" id="description" placeholder="' . lang('description') . '"') ?>
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
                    echo form_dropdown('parent', $cat, (isset($_POST['parent']) ? $_POST['parent'] : $category->parent_id), 'class="form-select select2" id="parent" data-placeholder="' . lang('select') . ' ' . lang('parent_category') . '"');
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
            <?= form_submit('edit_category', lang('edit_category'), 'class="btn btn-warning"') ?>
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
