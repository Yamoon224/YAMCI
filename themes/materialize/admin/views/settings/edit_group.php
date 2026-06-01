<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="icon-base ri ri-pencil-line icon-20px me-2"></i><?= lang('edit_group') ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-bs-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open('system_settings/edit_group/' . $group->id, $attrib); ?>
        <div class="modal-body">
            <p class="text-muted mb-4"><?= lang('enter_info') ?></p>

            <div class="mb-3">
                <label class="form-label" for="group_name"><?= lang('group_name') ?></label>
                <?= form_input('group_name', $group->name, 'class="form-control" id="group_name" required="required"') ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="description"><?= lang('description') ?></label>
                <?= form_input('description', $group->description, 'class="form-control" id="description" required="required"') ?>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                <?= lang('cancel') ?>
            </button>
            <?= form_submit('edit_group', lang('edit_group'), 'class="btn btn-primary"') ?>
        </div>
        <?= form_close() ?>
    </div>
</div>
<?= $modal_js ?>
