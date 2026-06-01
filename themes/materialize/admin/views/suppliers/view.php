<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal wrapper (loaded via AJAX into #myModal) -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="ri-community-line me-2"></span>
                <?= ($supplier->company && $supplier->company != '-') ? $supplier->company : $supplier->name ?>
            </h5>
            <div class="ms-auto d-flex gap-2 me-3 no-print">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print();">
                    <span class="ri-printer-line me-1"></span><?= lang('print') ?>
                </button>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?= lang('close') ?>"></button>
        </div>

        <div class="modal-body">
            <!-- Profile summary header -->
            <div class="d-flex align-items-center gap-3 p-3 bg-light rounded mb-4">
                <div class="avatar avatar-lg flex-shrink-0">
                    <span class="avatar-initial rounded-circle bg-label-info" style="font-size:1.5rem;">
                        <?= strtoupper(substr($supplier->company ?? $supplier->name, 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold"><?= ($supplier->company && $supplier->company != '-') ? $supplier->company : $supplier->name ?></h5>
                    <?php if ($supplier->company && $supplier->company != '-') { ?>
                    <p class="mb-0 text-muted"><?= $supplier->name ?></p>
                    <?php } ?>
                    <?php if ($supplier->email) { ?>
                    <small class="text-muted">
                        <span class="ri-mail-line me-1"></span>
                        <a href="mailto:<?= $supplier->email ?>" class="text-muted"><?= $supplier->email ?></a>
                    </small>
                    <?php } ?>
                </div>
                <?php if ($supplier->phone) { ?>
                <div class="ms-auto text-end">
                    <div class="text-muted small"><?= lang('phone') ?></div>
                    <div class="fw-bold">
                        <a href="tel:<?= $supplier->phone ?>"><?= $supplier->phone ?></a>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="supplierTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="sup-info-tab" data-bs-toggle="tab"
                            data-bs-target="#sup-info-pane" type="button" role="tab">
                        <span class="ri-information-line me-1"></span><?= lang('information') ?>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="sup-custom-tab" data-bs-toggle="tab"
                            data-bs-target="#sup-custom-pane" type="button" role="tab">
                        <span class="ri-file-list-line me-1"></span><?= lang('custom_fields') ?>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="supplierTabContent">
                <!-- Info tab -->
                <div class="tab-pane fade show active" id="sup-info-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted small"><?= lang('company') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->company ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('name') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->name ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('vat_no') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->vat_no ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('gst_no') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->gst_no ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('email') ?></dt>
                                <dd class="col-sm-7 small">
                                    <?php if ($supplier->email) { ?>
                                    <a href="mailto:<?= $supplier->email ?>"><?= $supplier->email ?></a>
                                    <?php } ?>
                                </dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('phone') ?></dt>
                                <dd class="col-sm-7 small">
                                    <?php if ($supplier->phone) { ?>
                                    <a href="tel:<?= $supplier->phone ?>"><?= $supplier->phone ?></a>
                                    <?php } ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted small"><?= lang('address') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->address ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('city') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->city ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('state') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->state ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('postal_code') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->postal_code ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('country') ?></dt>
                                <dd class="col-sm-7 small"><?= $supplier->country ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Custom fields tab -->
                <div class="tab-pane fade" id="sup-custom-pane" role="tabpanel">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted small"><?= lang('scf1') ?></dt>
                        <dd class="col-sm-8 small"><?= $supplier->cf1 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('scf2') ?></dt>
                        <dd class="col-sm-8 small"><?= $supplier->cf2 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('scf3') ?></dt>
                        <dd class="col-sm-8 small"><?= $supplier->cf3 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('scf4') ?></dt>
                        <dd class="col-sm-8 small"><?= $supplier->cf4 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('scf5') ?></dt>
                        <dd class="col-sm-8 small"><?= $supplier->cf5 ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="modal-footer no-print">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>

            <?php if ($Owner || $Admin || $GP['reports-suppliers']) { ?>
            <a href="<?= admin_url('reports/supplier_report/' . $supplier->id) ?>" target="_blank"
               class="btn btn-outline-primary">
                <span class="ri-bar-chart-line me-1"></span><?= lang('suppliers_report') ?>
            </a>
            <?php } ?>

            <?php if ($Owner || $Admin || $GP['suppliers-edit']) { ?>
            <a href="<?= admin_url('suppliers/edit/' . $supplier->id) ?>"
               data-bs-toggle="modal" data-bs-target="#myModal2"
               class="btn btn-primary">
                <span class="ri-edit-line me-1"></span><?= lang('edit_supplier') ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
