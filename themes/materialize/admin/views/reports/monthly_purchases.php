<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .monthly-table th, .monthly-table td { text-align: center; vertical-align: middle; }
    .monthly-table td { padding: 4px; }
    .monthly-table .data tr:nth-child(odd) td { color: var(--bs-primary); }
    .monthly-table .data tr:nth-child(even) td { text-align: right; }
    .year-nav th { background: var(--bs-primary); color: #fff; }
    .year-nav th a { color: #fff; text-decoration: none; font-weight: bold; }
</style>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-calendar-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('monthly_purchases') ?: 'Achats mensuels'); ?></h4>
        <p class="mb-0 text-muted">Vue annuelle des achats mensuels <?= $sel_warehouse ? '(' . htmlspecialchars($sel_warehouse->name) . ')' : '(' . (lang('all_warehouses') ?: 'tous les entrepôts') . ')'; ?>.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('reports'); ?>"><?= lang('reports') ?: 'Rapports'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('monthly_purchases') ?: 'Achats mensuels'; ?></li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2 align-content-center flex-wrap">
        <?php if (!empty($warehouses) && !$this->session->userdata('warehouse_id')): ?>
        <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="ri ri-building-line me-1"></i><?= lang('warehouses') ?: 'Entrepôts'; ?>
            </button>
            <ul class="dropdown-menu">
                <li>
                    <a class="dropdown-item" href="<?= admin_url('reports/monthly_purchases/0/' . $year); ?>">
                        <i class="ri ri-building-2-line me-2"></i><?= lang('all_warehouses') ?: 'Tous les entrepôts'; ?>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <?php foreach ($warehouses as $warehouse): ?>
                <li>
                    <a class="dropdown-item" href="<?= admin_url('reports/monthly_purchases/' . $warehouse->id . '/' . $year); ?>">
                        <i class="ri ri-building-line me-2"></i><?= $warehouse->name; ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
        <button id="image" class="btn btn-outline-secondary" title="<?= lang('save_image') ?: 'Enregistrer image'; ?>">
            <i class="ri ri-image-line me-1"></i><?= lang('save_image') ?: 'Image'; ?>
        </button>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="ri ri-calendar-2-line" style="font-size:18px"></i>
        <h5 class="card-title mb-0"><?= lang('monthly_purchases') ?: 'Achats mensuels'; ?></h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-4"><?= lang('reports_calendar_text'); ?></p>

        <div class="table-responsive">
            <table class="table table-bordered monthly-table">
                <thead>
                    <tr class="year-nav">
                        <th>
                            <a href="<?= admin_url('reports/monthly_purchases/' . ($warehouse_id ? $warehouse_id : 0) . '/' . ($year - 1)); ?>">
                                &laquo;
                            </a>
                        </th>
                        <th colspan="10"><?= $year; ?></th>
                        <th>
                            <a href="<?= admin_url('reports/monthly_purchases/' . ($warehouse_id ? $warehouse_id : 0) . '/' . ($year + 1)); ?>">
                                &raquo;
                            </a>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $months_arr = ['01' => 'cal_january', '02' => 'cal_february', '03' => 'cal_march',
                                       '04' => 'cal_april', '05' => 'cal_may', '06' => 'cal_june',
                                       '07' => 'cal_july', '08' => 'cal_august', '09' => 'cal_september',
                                       '10' => 'cal_october', '11' => 'cal_november', '12' => 'cal_december'];
                        foreach ($months_arr as $mnum => $mlang): ?>
                        <td class="fw-semibold text-center">
                            <a href="<?= admin_url('reports/monthly_profit/' . $year . '/' . $mnum); ?>"
                               data-bs-toggle="modal" data-bs-target="#myModal">
                                <?= lang($mlang); ?>
                            </a>
                        </td>
                        <?php endforeach; ?>
                    </tr>
                    <tr>
                        <?php
                        if (!empty($purchases)) {
                            foreach ($purchases as $value) {
                                $array[$value->date] = "<table class='table table-bordered table-sm data' style='margin:0;font-size:0.75rem;'><tbody>"
                                    . "<tr><td>" . $this->lang->line('discount') . "</td></tr>"
                                    . "<tr><td>" . $this->sma->formatMoney($value->discount) . "</td></tr>"
                                    . "<tr><td>" . $this->lang->line('shipping') . "</td></tr>"
                                    . "<tr><td>" . $this->sma->formatMoney($value->shipping) . "</td></tr>"
                                    . "<tr><td>" . $this->lang->line('product_tax') . "</td></tr>"
                                    . "<tr><td>" . $this->sma->formatMoney($value->tax1) . "</td></tr>"
                                    . "<tr><td>" . $this->lang->line('order_tax') . "</td></tr>"
                                    . "<tr><td>" . $this->sma->formatMoney($value->tax2) . "</td></tr>"
                                    . "<tr><td>" . $this->lang->line('total') . "</td></tr>"
                                    . "<tr><td>" . $this->sma->formatMoney($value->total) . "</td></tr>"
                                    . "</tbody></table>";
                            }
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<td style="width:8.3%; padding:0;">';
                                if (isset($array[$i])) {
                                    echo $array[$i];
                                } else {
                                    echo '<strong class="d-block text-center p-2">0</strong>';
                                }
                                echo '</td>';
                            }
                        } else {
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<td><strong class="d-block text-center p-2">0</strong></td>';
                            }
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#pdf').on('click', function (event) {
        event.preventDefault();
        window.location.href = '<?= admin_url('reports/monthly_purchases/' . ($warehouse_id ? $warehouse_id : 0) . '/' . $year . '/pdf'); ?>';
        return false;
    });

    $('#image').on('click', function (event) {
        event.preventDefault();
        html2canvas($('.card')[0], {
            onrendered: function (canvas) {
                openImg(canvas.toDataURL());
            }
        });
        return false;
    });
});
</script>
