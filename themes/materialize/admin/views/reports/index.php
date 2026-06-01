<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-bar-chart-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('reports') ?: 'Rapports' ?></h4>
    <p class="mb-0 text-muted">Tableaux de bord analytiques de votre activité</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>"><?= lang('home') ?: 'Accueil' ?></a></li>
        <li class="breadcrumb-item active"><?= lang('reports') ?: 'Rapports' ?></li>
      </ol>
    </nav>
  </div>
</div>

<!-- Reports grid -->
<div class="row g-4 mb-5">

    <!-- Rapport ventes -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/sales') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="icon-base ri ri-shopping-cart-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('sales_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport achats -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/purchases') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-success">
                            <i class="icon-base ri ri-shopping-bag-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('purchases_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport bénéfices -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/profit_loss') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="icon-base ri ri-money-dollar-circle-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('profit_and_loss') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport stocks -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/warehouse_stock') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-info">
                            <i class="icon-base ri ri-archive-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('warehouse_stock') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport clients -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/customers') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-danger">
                            <i class="icon-base ri ri-user-star-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('customers_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport fournisseurs -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/suppliers') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-secondary">
                            <i class="icon-base ri ri-truck-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('suppliers_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport produits -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/products') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-primary">
                            <i class="icon-base ri ri-box-3-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('products_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

    <!-- Rapport dépenses -->
    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
        <a href="<?= admin_url('reports/payments') ?>" class="text-decoration-none">
            <div class="card h-100 border-0 shadow-sm card-hover-effect">
                <div class="card-body d-flex align-items-center gap-3 py-4">
                    <div class="avatar flex-shrink-0">
                        <span class="avatar-initial rounded bg-label-warning">
                            <i class="icon-base ri ri-bill-line icon-20px"></i>
                        </span>
                    </div>
                    <div>
                        <h6 class="card-title mb-1"><?= lang('payments_report') ?></h6>
                        <small class="text-muted"><?= lang('view_report') ?? 'Voir le rapport' ?></small>
                    </div>
                    <i class="icon-base ri ri-arrow-right-line icon-20px ms-auto text-muted"></i>
                </div>
            </div>
        </a>
    </div>

</div>

<!-- Additional quick links row -->
<div class="row g-3 mb-4">
    <div class="col-12">
        <h6 class="text-muted mb-3 text-uppercase" style="letter-spacing:.05rem; font-size:.75rem;">
            <i class="icon-base ri ri-links-line icon-20px me-1"></i><?= lang('quick_links') ?>
        </h6>
    </div>

    <?php
    $quick_links = [
        ['url' => 'reports/best_sellers',     'icon' => 'ri-line-chart-line',     'label' => lang('best_sellers'),             'color' => 'primary'],
        ['url' => 'reports/quantity_alerts',  'icon' => 'ri-alert-line',          'label' => lang('product_quantity_alerts'),  'color' => 'danger'],
        ['url' => 'reports/expiry_alerts',    'icon' => 'ri-time-line',           'label' => lang('product_expiry_alerts'),    'color' => 'warning'],
        ['url' => 'reports/daily_sales',      'icon' => 'ri-calendar-event-line', 'label' => lang('daily_sales'),              'color' => 'success'],
        ['url' => 'reports/monthly_sales',    'icon' => 'ri-calendar-2-line',     'label' => lang('monthly_sales'),            'color' => 'info'],
        ['url' => 'reports/staff_report',     'icon' => 'ri-team-line',           'label' => lang('staff_report'),             'color' => 'secondary'],
    ];
    foreach ($quick_links as $link): ?>
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
        <a href="<?= admin_url($link['url']) ?>" class="text-decoration-none">
            <div class="card text-center border-0 shadow-sm card-hover-effect">
                <div class="card-body py-3 px-2">
                    <div class="avatar mx-auto mb-2">
                        <span class="avatar-initial rounded-circle bg-label-<?= $link['color'] ?>">
                            <i class="icon-base ri <?= $link['icon'] ?> icon-20px"></i>
                        </span>
                    </div>
                    <small class="fw-medium text-body"><?= $link['label'] ?></small>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<?php if ($Owner || $Admin): ?>
<!-- Overview Chart -->
<?php
$months = []; $sales = []; $tax1 = []; $tax2 = []; $purchases = []; $tax3 = [];
foreach ($monthly_sales as $month_sale) {
    $months[]    = date('M-Y', strtotime($month_sale->month));
    $sales[]     = $month_sale->sales;
    $tax1[]      = $month_sale->tax1;
    $tax2[]      = $month_sale->tax2;
    $purchases[] = $month_sale->purchases;
    $tax3[]      = $month_sale->ptax;
}
?>
<div class="card">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="icon-base ri ri-bar-chart-2-line icon-20px text-primary"></i>
        <h5 class="card-title mb-0"><?= lang('overview_chart') ?></h5>
    </div>
    <div class="card-body">
        <p class="text-muted small"><?= lang('overview_chart_heading') ?></p>
        <div id="overviewChart" style="width:100%; height:400px;"></div>
        <p class="text-center text-muted small mt-2"><?= lang('chart_lable_toggle') ?></p>
    </div>
</div>

<script src="<?= $assets ?>js/hc/highcharts.js"></script>
<script>
$(function () {
    Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
        return {
            radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
            stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
        };
    });
    $('#overviewChart').highcharts({
        chart: {},
        credits: {enabled: false},
        title: {text: ''},
        xAxis: {categories: <?= json_encode($months) ?>},
        yAxis: {min: 0, title: ""},
        tooltip: {
            shared: true, followPointer: true,
            formatter: function () {
                if (this.key) {
                    return '<div class="tooltip-inner hc-tip">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                } else {
                    var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped" style="margin-bottom:0;">';
                    $.each(this.points, function () {
                        s += '<tr><td style="padding:0">' + this.series.name + ': </td><td style="padding:0;text-align:right;"><b>' + currencyFormat(this.y) + '</b></td></tr>';
                    });
                    s += '</table></div>';
                    return s;
                }
            },
            useHTML: true, borderWidth: 0, shadow: false,
            valueDecimals: site.settings.decimals,
            style: {fontSize: '14px', padding: '0', color: '#000000'}
        },
        series: [
            {type: 'column', name: '<?= lang('sp_tax') ?>', data: [<?= implode(', ', $tax1) ?>]},
            {type: 'column', name: '<?= lang('order_tax') ?>', data: [<?= implode(', ', $tax2) ?>]},
            {type: 'column', name: '<?= lang('sales') ?>', data: [<?= implode(', ', $sales) ?>]},
            {type: 'spline', name: '<?= lang('purchases') ?>', data: [<?= implode(', ', $purchases) ?>],
                marker: {lineWidth: 2, lineColor: Highcharts.getOptions().colors[3], fillColor: 'white',
                    states: {hover: {lineWidth: 4}}}},
            {type: 'spline', name: '<?= lang('pp_tax') ?>', data: [<?= implode(', ', $tax3) ?>],
                marker: {lineWidth: 2, lineColor: Highcharts.getOptions().colors[3], fillColor: 'white',
                    states: {hover: {lineWidth: 4}}}},
            {type: 'pie', name: '<?= lang('stock_value') ?>',
                data: [['', 0], ['', 0],
                    ['<?= lang('stock_value_by_price') ?>', <?= $stock->stock_by_price ?>],
                    ['<?= lang('stock_value_by_cost') ?>', <?= $stock->stock_by_cost ?>]],
                center: [80, 42], size: 80, showInLegend: false,
                dataLabels: {enabled: false}}
        ]
    });
});
</script>
<?php endif; ?>

<style>
.card-hover-effect {
    transition: transform .15s ease, box-shadow .15s ease;
}
.card-hover-effect:hover {
    transform: translateY(-3px);
    box-shadow: 0 .5rem 1.5rem rgba(0,0,0,.1) !important;
}
</style>
