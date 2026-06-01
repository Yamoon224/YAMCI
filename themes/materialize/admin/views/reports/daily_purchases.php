<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>
    .cl_wday { text-align: center; font-weight: 600; background: var(--bs-primary); color: #fff; }
    .cl_equal { width: 14.28%; }
    td.day { width: 14.28%; padding: 0 !important; vertical-align: top !important; }
    .day_num { width: 100%; text-align: left; margin: 0; padding: 8px; cursor: pointer; font-weight: 600; }
    .day_num:hover { background: var(--bs-primary-bg-subtle); border-radius: 4px; }
    .content { width: 100%; text-align: left; color: var(--bs-primary); padding: 4px 8px; font-size: 0.8rem; }
    .highlight { color: var(--bs-primary); font-weight: bold; }
    .calendar-table td { border: 1px solid var(--bs-border-color); }
</style>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1"><i class="ri ri-calendar-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo $page_title ?? (lang('daily_purchases') ?: 'Achats journaliers'); ?></h4>
        <p class="mb-0 text-muted">Calendrier des achats journaliers <?= $sel_warehouse ? '(' . htmlspecialchars($sel_warehouse->name) . ')' : '(' . (lang('all_warehouses') ?: 'tous les entrepôts') . ')'; ?>.</p>
        <nav aria-label="breadcrumb" class="mt-2">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item"><a href="<?= admin_url(); ?>"><?= lang('home') ?: 'Accueil'; ?></a></li>
                <li class="breadcrumb-item"><a href="<?= admin_url('reports'); ?>"><?= lang('reports') ?: 'Rapports'; ?></a></li>
                <li class="breadcrumb-item active"><?= lang('daily_purchases') ?: 'Achats journaliers'; ?></li>
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
                    <a class="dropdown-item" href="<?= admin_url('reports/daily_purchases/0/' . $year . '/' . $month); ?>">
                        <i class="ri ri-building-2-line me-2"></i><?= lang('all_warehouses') ?: 'Tous les entrepôts'; ?>
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <?php foreach ($warehouses as $warehouse): ?>
                <li>
                    <a class="dropdown-item" href="<?= admin_url('reports/daily_purchases/' . $warehouse->id . '/' . $year . '/' . $month); ?>">
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
        <i class="ri ri-calendar-line" style="font-size:18px"></i>
        <h5 class="card-title mb-0"><?= lang('daily_purchases') ?: 'Achats journaliers'; ?></h5>
    </div>
    <div class="card-body">
        <p class="text-muted mb-3"><?= lang('get_day_profit') . ' ' . lang('reports_calendar_text'); ?></p>
        <div class="table-responsive">
            <?php echo $calender; ?>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('.table .day_num').on('click', function () {
        var day = $(this).text().trim();
        var date = '<?= $year . '-' . $month . '-'; ?>' + day;
        var href = '<?= admin_url('reports/profit'); ?>/' + date + '/<?= ($warehouse_id ? $warehouse_id : ''); ?>';
        $.get(href, function (data) {
            $('#myModal').html(data).modal('show');
        });
    });

    $('#pdf').on('click', function (event) {
        event.preventDefault();
        window.location.href = '<?= admin_url('reports/daily_purchases/' . ($warehouse_id ? $warehouse_id : 0) . '/' . $year . '/' . $month . '/pdf'); ?>';
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
