<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Modal wrapper (loaded via AJAX into #myModal) -->
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <span class="ri-user-line me-2"></span>
                <?= ($customer->company && $customer->company != '-') ? $customer->company : $customer->name ?>
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
                    <span class="avatar-initial rounded-circle bg-label-primary" style="font-size:1.5rem;">
                        <?= strtoupper(substr($customer->name ?? $customer->company, 0, 1)) ?>
                    </span>
                </div>
                <div>
                    <h5 class="mb-1 fw-bold"><?= ($customer->company && $customer->company != '-') ? $customer->company : $customer->name ?></h5>
                    <?php if ($customer->company && $customer->company != '-') { ?>
                    <p class="mb-0 text-muted"><?= $customer->name ?></p>
                    <?php } ?>
                    <small class="text-muted">
                        <span class="ri-group-line me-1"></span><?= $customer->customer_group_name ?>
                    </small>
                </div>
                <div class="ms-auto text-end">
                    <div class="text-muted small"><?= lang('deposit') ?></div>
                    <div class="fw-bold fs-5 text-success"><?= $this->sma->formatMoney($customer->deposit_amount) ?></div>
                    <div class="text-muted small mt-1"><?= lang('award_points') ?></div>
                    <div class="fw-bold text-primary"><?= $customer->award_points ?></div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" id="customerTabs" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane"
                            type="button" role="tab">
                        <span class="ri-information-line me-1"></span><?= lang('information') ?>
                    </button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="custom-tab" data-bs-toggle="tab" data-bs-target="#custom-pane"
                            type="button" role="tab">
                        <span class="ri-file-list-line me-1"></span><?= lang('custom_fields') ?>
                    </button>
                </li>
            </ul>

            <div class="tab-content" id="customerTabContent">
                <!-- Info tab -->
                <div class="tab-pane fade show active" id="info-pane" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted small"><?= lang('company') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->company ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('name') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->name ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('customer_group') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->customer_group_name ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('vat_no') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->vat_no ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('gst_no') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->gst_no ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('email') ?></dt>
                                <dd class="col-sm-7 small">
                                    <a href="mailto:<?= $customer->email ?>"><?= $customer->email ?></a>
                                </dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('phone') ?></dt>
                                <dd class="col-sm-7 small">
                                    <a href="tel:<?= $customer->phone ?>"><?= $customer->phone ?></a>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-6">
                            <dl class="row mb-0">
                                <dt class="col-sm-5 text-muted small"><?= lang('address') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->address ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('city') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->city ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('state') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->state ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('postal_code') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->postal_code ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('country') ?></dt>
                                <dd class="col-sm-7 small"><?= $customer->country ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('deposit') ?></dt>
                                <dd class="col-sm-7 small fw-bold text-success"><?= $this->sma->formatMoney($customer->deposit_amount) ?></dd>

                                <dt class="col-sm-5 text-muted small"><?= lang('award_points') ?></dt>
                                <dd class="col-sm-7 small fw-bold text-primary"><?= $customer->award_points ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <!-- Custom fields tab -->
                <div class="tab-pane fade" id="custom-pane" role="tabpanel">
                    <dl class="row mb-0">
                        <dt class="col-sm-4 text-muted small"><?= lang('ccf1') ?></dt>
                        <dd class="col-sm-8 small"><?= $customer->cf1 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('ccf2') ?></dt>
                        <dd class="col-sm-8 small"><?= $customer->cf2 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('ccf3') ?></dt>
                        <dd class="col-sm-8 small"><?= $customer->cf3 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('ccf4') ?></dt>
                        <dd class="col-sm-8 small"><?= $customer->cf4 ?></dd>

                        <dt class="col-sm-4 text-muted small"><?= lang('ccf5') ?></dt>
                        <dd class="col-sm-8 small"><?= $customer->cf5 ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="modal-footer no-print">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('close') ?></button>

            <?php if ($Owner || $Admin || $GP['reports-customers']) { ?>
            <a href="<?= admin_url('reports/customer_report/' . $customer->id) ?>" target="_blank"
               class="btn btn-outline-primary">
                <span class="ri-bar-chart-line me-1"></span><?= lang('customers_report') ?>
            </a>
            <?php } ?>

            <?php if ($Owner || $Admin || $GP['customers-edit']) { ?>
            <a href="<?= admin_url('customers/edit/' . $customer->id) ?>"
               data-bs-toggle="modal" data-bs-target="#myModal2"
               class="btn btn-primary">
                <span class="ri-edit-line me-1"></span><?= lang('edit_customer') ?>
            </a>
            <?php } ?>
        </div>
    </div>
</div>
