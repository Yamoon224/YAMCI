<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="myModalLabel">
                <i class="ri-money-dollar-circle-line me-2"></i>
                <?= lang('month_profit') . ' (' . $date . ')'; ?>
            </h5>
            <div class="ms-auto me-2 d-flex gap-2 align-items-center">
                <button type="button" class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
                    <i class="ri-printer-line me-1"></i><?= lang('print'); ?>
                </button>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <?php
                $opts[] = lang('all_warehouses');
                foreach ($warehouses as $warehouse) {
                    $opts[$warehouse->id] = $warehouse->name . ' (' . $warehouse->code . ')';
                }
                ?>
                <select name="warehouse" id="warehouse" class="form-select select2">
                    <?php foreach ($opts as $k => $v): ?>
                        <option value="<?= $k; ?>" <?= (set_value('warehouse', $swh) == $k ? 'selected' : ''); ?>><?= $v; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="table-responsive">
                <table class="table table-borderless mb-0">
                    <tbody>
                        <tr class="border-bottom">
                            <td><strong><?= lang('products_sale'); ?></strong></td>
                            <td class="text-end"><strong><?= $this->sma->formatMoney($costing->sales); ?></strong></td>
                        </tr>
                        <tr class="border-bottom">
                            <td><?= lang('order_discount'); ?></td>
                            <td class="text-end">
                                <?php $discount = $discount ? $discount->order_discount : 0; echo $this->sma->formatMoney($discount); ?>
                            </td>
                        </tr>
                        <tr class="border-bottom">
                            <td><?= lang('products_cost'); ?></td>
                            <td class="text-end"><?= $this->sma->formatMoney($costing->cost); ?></td>
                        </tr>
                        <tr class="border-bottom">
                            <td><?= lang('expenses'); ?></td>
                            <td class="text-end">
                                <?php $expense = $expenses ? $expenses->total : 0; echo $this->sma->formatMoney($expense); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><h5 class="mb-0 fw-bold"><?= lang('profit'); ?></h5></td>
                            <td class="text-end">
                                <h5 class="mb-0 fw-bold text-success">
                                    <?= $this->sma->formatMoney($costing->sales - $costing->cost - $discount - $expense); ?>
                                </h5>
                            </td>
                        </tr>
                        <?php if (isset($returns->total)): ?>
                        <tr class="border-top">
                            <td><strong><?= lang('return_sales'); ?></strong></td>
                            <td class="text-end text-danger"><strong><?= $this->sma->formatMoney($returns->total); ?></strong></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $('#warehouse').select2({ minimumResultsForSearch: 7, dropdownParent: $('#myModal') });
    $('#warehouse').on('change', function () {
        var wh = $(this).val();
        $.get('<?= admin_url('reports/monthly_profit/' . $year . '/' . $month); ?>/' + wh + '/1', function (data) {
            $('#myModal').empty().html(data);
            $('#warehouse').select2({ minimumResultsForSearch: 7, dropdownParent: $('#myModal') });
        });
    });
});
</script>
<?php echo $modal_js; ?>
