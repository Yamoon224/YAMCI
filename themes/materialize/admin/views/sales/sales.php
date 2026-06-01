<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
foreach ($monthly_sales as $month_sale) {
    $months[] = $month_sale->month;
    $sales[]  = $month_sale->sales;
}
?>

<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h4 class="fw-bold py-3 mb-4">
                <span class="text-muted fw-light"><?= lang('reports'); ?> /</span> <?php echo $page_title; ?>
            </h4>
        </div>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-warning alert-dismissible mb-4" role="alert">
        <div><?php echo $message; ?></div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-1">
                <i class="ri-bar-chart-grouped-line me-2"></i>
                <?php echo $page_title; ?>
            </h5>
            <p class="text-muted mb-0"><?php echo $this->lang->line('chart_heading'); ?></p>
        </div>
        <div class="card-body">
            <div id="salesChart" style="min-height: 400px;"></div>
        </div>
    </div>
</div>

<script>
(function () {
    var months = [<?php foreach ($months as $month) { echo "'" . addslashes($month) . "',"; } ?>];
    var sales  = [<?php echo implode(', ', $sales); ?>];

    var options = {
        chart: {
            type: 'bar',
            height: 400,
            toolbar: { show: true },
            background: 'transparent'
        },
        series: [{
            name: '<?php echo addslashes($this->lang->line('sales')); ?>',
            data: sales
        }],
        xaxis: {
            categories: months,
            labels: { style: { fontSize: '12px' } }
        },
        yaxis: {
            title: { text: '<?php echo addslashes($this->lang->line('sales')); ?>' }
        },
        colors: ['#696cff'],
        plotOptions: {
            bar: {
                columnWidth: '55%',
                borderRadius: 4,
                dataLabels: { position: 'top' }
            }
        },
        dataLabels: {
            enabled: false
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return parseFloat(val).toLocaleString();
                }
            }
        },
        grid: { borderColor: 'rgba(0,0,0,0.1)' },
        legend: { position: 'top' }
    };

    if (typeof ApexCharts !== 'undefined') {
        var chart = new ApexCharts(document.querySelector('#salesChart'), options);
        chart.render();
    }
})();
</script>
