<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">
                <span class="icon-base ri ri-refresh-line me-1 icon-16px"></span><?= lang('update_status'); ?>
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <?php $attrib = ['data-toggle' => 'validator', 'role' => 'form'];
        echo admin_form_open_multipart('purchases/update_status/' . $inv->id, $attrib); ?>
        <div class="modal-body">
            <p class="text-muted small"><?= lang('enter_info'); ?></p>

            <!-- Purchase info -->
            <div class="card border-0 bg-light mb-4">
                <div class="card-header bg-light fw-semibold py-2">
                    <span class="icon-base ri ri-file-list-3-line me-1 icon-16px"></span><?= lang('purchase_details'); ?>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-borderless mb-0">
                        <tbody>
                            <tr>
                                <td class="fw-semibold text-muted ps-3" style="width:45%;"><?= lang('reference_no'); ?></td>
                                <td><code><?= $inv->reference_no; ?></code></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted ps-3"><?= lang('supplier'); ?></td>
                                <td><?= $inv->supplier; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted ps-3"><?= lang('warehouse'); ?></td>
                                <td><?= $inv->warehouse_id; ?></td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted ps-3"><?= lang('status'); ?></td>
                                <td>
                                    <?php
                                    $st = $inv->status;
                                    $sbadge = ($st == 'received') ? 'bg-label-success' : (($st == 'partial') ? 'bg-label-warning' : 'bg-label-info');
                                    echo '<span class="badge ' . $sbadge . '">' . lang($st) . '</span>';
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-semibold text-muted ps-3"><?= lang('payment_status'); ?></td>
                                <td>
                                    <?php
                                    $ps = $inv->payment_status;
                                    $pbadge = ($ps == 'paid') ? 'bg-label-success' : (($ps == 'partial') ? 'bg-label-warning' : 'bg-label-danger');
                                    echo '<span class="badge ' . $pbadge . '">' . lang($ps) . '</span>';
                                    ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php if ($returned): ?>
            <div class="alert alert-warning">
                <span class="icon-base ri ri-information-line me-1 icon-16px"></span>
                <?= lang('purchase_x_action'); ?>
            </div>
            <?php else: ?>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="poStatus"><?= lang('status'); ?></label>
                <?php $opts = ['received' => lang('received'), 'pending' => lang('pending'), 'ordered' => lang('ordered')]; ?>
                <?= form_dropdown('status', $opts, $inv->status, 'class="form-select" id="poStatus" required="required"'); ?>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" for="poNote"><?= lang('note'); ?></label>
                <?= form_textarea('note', isset($_POST['note']) ? $_POST['note'] : $this->sma->decode_html($inv->note), 'class="form-control" id="poNote" rows="3"'); ?>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!$returned): ?>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?= lang('cancel'); ?></button>
            <?= form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
        </div>
        <?php endif; ?>
        <?= form_close(); ?>
    </div>
</div>
<?= $modal_js ?>
