<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"><?= lang('pos'); ?> /</span> <?= lang('updates'); ?>
            </h4>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex align-items-center">
            <h5 class="card-title mb-0">
                <i class="ri-upload-cloud-line me-2"></i><?= lang('updates'); ?>
            </h5>
        </div>
        <div class="card-body">
            <p class="text-muted mb-4"><?= lang('update_heading'); ?></p>

            <?php
            if ($pos_settings->purchase_code == 'purchase_code' || $pos_settings->envato_username == 'envato_username'):
            ?>
            <?= admin_form_open('pos/updates'); ?>
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <?= form_input('purchase_code', '', 'class="form-control" id="purchase_code" placeholder="' . lang('purchase_code') . '" required="required"'); ?>
                        <label for="purchase_code"><?= lang('purchase_code'); ?></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline">
                        <?= form_input('envato_username', '', 'class="form-control" id="envato_username" placeholder="' . lang('envato_username') . '" required="required"'); ?>
                        <label for="envato_username"><?= lang('envato_username'); ?></label>
                    </div>
                </div>
                <div class="col-12">
                    <?= form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
                </div>
            </div>
            <?= form_close(); ?>

            <?php else:
                if (!empty($updates->data->updates)):
                    $c = 1;
                    foreach ($updates->data->updates as $update):
            ?>
            <div class="card border mb-3">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        <span class="badge bg-primary me-2"><?= lang('version'); ?> <?= htmlspecialchars($update->version); ?></span>
                    </h5>
                    <?php if ($c == 1 && $update->mversion != 315): ?>
                    <a href="<?= admin_url('pos/install_update/' . substr($update->filename, 0, -4) . '/' . (!empty($update->mversion) ? $update->mversion : 0) . '/' . $update->version); ?>"
                       class="btn btn-sm btn-primary">
                        <i class="ri-download-line me-1"></i><?= lang('install'); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h6 class="text-muted mb-2"><?= lang('changelog'); ?></h6>
                    <pre class="bg-light p-3 rounded" style="font-size:0.85rem; max-height:300px; overflow:auto;"><?= htmlspecialchars($update->changelog); ?></pre>
                </div>
            </div>
            <?php $c++; endforeach;
                else: ?>
            <div class="alert alert-success d-flex align-items-center" role="alert">
                <i class="ri-checkbox-circle-line me-2 ri-xl"></i>
                <strong><?= lang('using_latest_update'); ?></strong>
            </div>
            <?php endif;
            endif; ?>
        </div>
    </div>
</div>
