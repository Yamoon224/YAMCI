<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
foreach ($monthly_sales as $month_sale) {
    $months[]    = date('M-Y', strtotime($month_sale->month));
    $sales[]     = $month_sale->sales;
    $tax1[]      = $month_sale->tax1;
    $tax2[]      = $month_sale->tax2;
    $purchases[] = $month_sale->purchases;
    $tax3[]      = $month_sale->ptax;
}
?>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="ri-bar-chart-2-line me-2"></i>
            <?php echo $page_title; ?>
        </h5>
        <p class="text-muted mb-0 mt-1"><?php echo $this->lang->line('overview_chart_heading'); ?></p>
    </div>
    <div class="card-body">
        <div id="chart" style="width:100%; min-height:400px;"></div>
        <p class="text-center text-muted mt-2 small"><?php echo $this->lang->line('chart_lable_toggle'); ?></p>
    </div>
</div>

<script>
(function () {
    var months    = [<?php foreach ($months as $m) { echo "'" . $m . "',"; } ?>];
    var sales     = [<?php echo implode(',', $sales); ?>];
    var tax1      = [<?php echo implode(',', $tax1); ?>];
    var tax2      = [<?php echo implode(',', $tax2); ?>];
    var purchases = [<?php echo implode(',', $purchases); ?>];
    var tax3      = [<?php echo implode(',', $tax3); ?>];
    var currency  = '<?php echo $default_currency->code; ?>';

    var options = {
        chart: { type: 'bar', height: 400, stacked: false, toolbar: { show: true } },
        series: [
            { name: '<?php echo addslashes($this->lang->line('sp_tax')); ?>',    type: 'column', data: tax1 },
            { name: '<?php echo addslashes($this->lang->line('order_tax')); ?>', type: 'column', data: tax2 },
            { name: '<?php echo addslashes($this->lang->line('sales')); ?>',     type: 'column', data: sales },
            { name: '<?php echo addslashes($this->lang->line('purchases')); ?>', type: 'line',   data: purchases },
            { name: '<?php echo addslashes($this->lang->line('pp_tax')); ?>',    type: 'line',   data: tax3 }
        ],
        xaxis: { categories: months },
        yaxis: { title: { text: currency } },
        tooltip: {
            shared: true,
            y: {
                formatter: function (val) {
                    return currency + ' ' + parseFloat(val).toFixed(<?php echo $Settings->decimals ?? 2; ?>);
                }
            }
        },
        legend: { position: 'top' },
        dataLabels: { enabled: false },
        stroke: { width: [0, 0, 0, 2, 2], curve: 'smooth' },
        colors: ['#696cff', '#71dd37', '#0dcaf0', '#ff3e1d', '#ffd950'],
        plotOptions: { bar: { columnWidth: '60%', borderRadius: 3 } }
    };

    if (typeof ApexCharts !== 'undefined') {
        var chart = new ApexCharts(document.querySelector('#chart'), options);
        chart.render();
    } else if (typeof Highcharts !== 'undefined') {
        $('#chart').highcharts({
            chart: {},
            credits: { enabled: false },
            title: { text: '' },
            xAxis: { categories: months },
            yAxis: { min: 0, title: { text: '' } },
            series: [
                { type: 'column', name: '<?php echo addslashes($this->lang->line('sp_tax')); ?>', data: tax1 },
                { type: 'column', name: '<?php echo addslashes($this->lang->line('order_tax')); ?>', data: tax2 },
                { type: 'column', name: '<?php echo addslashes($this->lang->line('sales')); ?>', data: sales },
                { type: 'spline', name: '<?php echo addslashes($this->lang->line('purchases')); ?>', data: purchases },
                { type: 'spline', name: '<?php echo addslashes($this->lang->line('pp_tax')); ?>', data: tax3 }
            ]
        });
    }
})();
</script>
