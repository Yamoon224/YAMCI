<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<script>$(document).ready(function () {
        CURI = '<?= admin_url('reports/profit_loss'); ?>';
    });</script>
<style>@media print {
        .fa {
            color: #EEE;
            display: none;
        }

        .small-box {
            border: 1px solid #CCC;
        }
    }</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-bars"></i><?= lang('profit_loss'); ?></h2>

        <div class="box-icon">
            <div class="form-group choose-date hidden-xs">
                <div class="controls">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text"
                               value="<?= ($start ? $this->sma->hrld($start) : '') . ' - ' . ($end ? $this->sma->hrld($end) : ''); ?>"
                               id="daterange" class="form-control">
                        <span class="input-group-addon"><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('view_pl_report'); ?></p>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <div class="small-box padding1010 borange">
                                <h4 class="bold"><?= lang('purchases') ?></h4>
                                <i class="icon fa fa-clone"></i>

                                <h3 class="bold"><?= $this->sma->formatMoney($total_purchases->total_amount) ?></h3>

                                <p class="bold"><?= $total_purchases->total . ' ' . lang('purchases') ?> </p>

                                <p><?= $this->sma->formatMoney($total_purchases->paid) . ' ' . lang('F CFA') ?>
                                    </p>
                            </div>
                        </div>
                        
                        
                        <div class="col-sm-4">
                            <div class="small-box padding1010 bdarkGreen">
                                <h4 class="bold"><?= lang('Total Ventes réalisées') ?></h4>
                                <i class="icon fa fa-thumbs-up"></i>

                                 <h3 class="bold"><?= $this->sma->formatMoney($total_sales->total_amount) ?></h3>

                                <p class="bold"><?= $total_sales->total . ' ' . lang('Ventes réalisées') ?> </p>

                                <p><?= $this->sma->formatMoney($total_sales->total_amount) . ' ' . lang('F FCA') ?>
                                    </p>
                            </div>
                        </div>
                        
                        
                       <div class="col-sm-4">
    <div class="small-box padding1010 bred">
        <h4 class="bold"><?= lang('Retournés ou Annulés') ?></h4>
        <i class="icon fa fa-random"></i>

        <!-- Affiche la moitié du montant -->
        <h3 class="bold"><?= $this->sma->formatMoney($total_return_sales->total_amount / 2) ?></h3>

        <p class="bold"><?= $total_return_sales->total . ' ' . lang('Retournés avec 50% remboursés') ?> </p>

        <p><?= $this->sma->formatMoney($total_return_sales->total_amount / 2) . ' ' . lang('F CFA') ?> </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-6">
                            <div class="small-box padding1010 bdarkGreen">
                                <h4 class="bold"><?= lang('Paiement reçu') ?></h4>
                                <i class="icon fa fa-money"></i>

                                <h3 class="bold"><?= $this->sma->formatMoney($total_received->total_amount) ?></h3>

                                <p class="bold"><?= $total_received->total . ' ' . lang('Reçus') ?> </p>

                                <p><?= $this->sma->formatMoney($total_received->total_amount) . ' ' . lang('F CFA') ?>
                                    
                                   
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="small-box padding1010 borange">
                                <h4 class="bold"><?= lang('Total des Credits') ?></h4>
                                <i class="icon fa fa-calculator"></i>

                               <h3 class="bold"><?= $this->sma->formatMoney($total_sales->total_amount - $total_received->total_amount) ?></h3>


                               <p><?= lang('Crédit Restant à payer') ?></p>

                                <p>&nbsp;</p>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="small-box padding1010 bpurple">
                                <h4 class="bold"><?= lang('Dépenses effectuées') ?></h4>
                                <i class="icon fa fa-credit-card"></i>

                                <h3 class="bold"><?= $this->sma->formatMoney($total_expenses->total_amount) ?></h3>

                                <p class="bold"><?= $total_expenses->total . ' ' . lang('expenses') ?></p>

                                <p>&nbsp;</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-4">
                            <div class="small-box padding1010 bred">
                                <h4 class="bold"><?= lang('Bénéfice/Perte HT (Ventes - Achats)') ?></h4>
                                <i class="icon fa fa-flash"></i>

                                <h3 class="bold"><?= $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount) ?></h3>

                                <p><?= $this->sma->formatMoney($total_sales->total_amount) . ' ' . lang('sales') ?>
                                    - <?= $this->sma->formatMoney($total_purchases->total_amount) . ' ' . lang('purchases') ?></p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box padding1010 bpink">
                                <h4 class="bold"><?= lang('Bénéfice/Perte TTC (Ventes - Achats)') ?></h4>
                                <i class="icon fa fa-sort"></i>

                                <h3 class="bold"><?= $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount - $total_sales->tax) ?></h3>

                                <p><?= $this->sma->formatMoney($total_sales->total_amount) . ' ' . lang('sales') ?>
                                    - <?= $this->sma->formatMoney($total_sales->tax) . ' ' . lang('TVA') ?>
                                    - <?= $this->sma->formatMoney($total_purchases->total_amount) . ' ' . lang('purchases') ?> </p>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="small-box padding1010 bblue">
                                <h4 class="bold"><?= lang('Total TVA collectée') ?></h4>
                                <i class="icon fa fa-bank"></i>

                               <h3 class="bold"><?= $this->sma->formatMoney($total_sales->tax) ?></h3>

<p>
    <?= $this->sma->formatMoney($total_sales->tax) . ' ' . lang('TVA collectée sur ventes') ?>
</p>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="col-sm-12">
                            <div class="small-box padding1010 bmGreen">
                                <h4 class="bold"><?= lang('Bénéfice Net') ?></h4>
                                <i class="icon fa fa-smile-o"></i>
                               <!-- Calcul du bénéfice net -->
<h3 class="bold">
    <?= $this->sma->formatMoney(
        $total_received->total_amount 
        - $total_paid->total_amount 
        - $total_expenses->total_amount 
        - $total_sales->tax 
        - ($total_return_sales->total_amount / 2) // Moitié du montant retourné
    ) ?>
</h3>

<p class="bold">
    <?= $this->sma->formatMoney($total_received->total_amount) . ' ' . lang('Paiement reçu') ?>
    - <?= $this->sma->formatMoney($total_paid->total_amount) . ' ' . lang('Achats effectués') ?>
    - <?= $this->sma->formatMoney($total_expenses->total_amount) . ' ' . lang('Dépenses') ?>
    - <?= $this->sma->formatMoney($total_sales->tax) . ' ' . lang('Taxe sur ventes') ?>
    - <?= $this->sma->formatMoney($total_return_sales->total_amount / 2) . ' ' . lang('Retourné ou Annulé') ?>
</p>





                            </div>
                        </div>
                    </div>
                </div>
                
                
               <?php foreach ($warehouses_report as $warehouse_report) {
    ?>
                    <div class="col-sm-4">
                        <div class="small-box padding1010 bblue">
                            <h4 class="bold"><?= $warehouse_report['warehouse']->name . ' (' . $warehouse_report['warehouse']->code . ')'; ?></h4>
                            <i class="icon fa fa-building-o"></i>

 

                            
                     
               <?php
// Calcul de la moitié du montant retourné
$half_returned_amount = $warehouse_report['total_returns']->total_amount / 2; // Moitié du montant retourné

// Calcul de la taxe collectée sur les ventes
$total_sales_tax = $warehouse_report['total_sales']->tax; // Taxe collectée sur les ventes
?>

<!-- Ventes Réalisées -->
<h3 class="bold"><?= $this->sma->formatMoney($warehouse_report['total_sales']->total_amount) ?></h3>
<p><?= lang('Ventes réalisées') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">

<!-- Montants Perçus -->
<h3 class="bold"><?= $this->sma->formatMoney($warehouse_report['total_sales']->paid) ?></h3>
<p><?= lang('Paiement(s) Perçu(s)') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">

<?php
// Calcul du reliquat client
$reliquat_client = $warehouse_report['total_sales']->total_amount - $warehouse_report['total_sales']->paid;
?>

<!-- Affichage du reliquat client -->
<h3 class="bold"><?= $this->sma->formatMoney($reliquat_client) ?></h3>
<p><?= lang('Crédit à payer') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">

<!-- Affichage des Dépenses -->
<?php
// Calcul des dépenses totales (ici supposées comme le total des achats)
$total_expenses = $warehouse_report['total_expenses']->total_amount; // Dépenses = Achats
?>
<h3 class="bold"><?= $this->sma->formatMoney($total_expenses) ?></h3>
<p><?= lang('Total Dépenses effectuées') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">

<!-- Affichage de la moitié du total retourné -->
<h3 class="bold"><?= $this->sma->formatMoney($half_returned_amount) ?></h3>
<p><?= lang('Retourné ou Annulé') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">

<!-- Affichage de la taxe collectée sur les ventes -->
<h3 class="bold"><?= $this->sma->formatMoney($total_sales_tax) ?></h3>
<p><?= lang('TVA collectée sur ventes') ?></p>

<hr style="border-color: rgba(255, 255, 255, 0.4);">



<h3 class="bold text-center">
    <?= $this->sma->formatMoney(
        ($warehouse_report['total_sales']->paid 
        - $total_expenses 
        - $warehouse_report['total_sales']->tax 
        - ($warehouse_report['total_returns']->total_amount / 2)) // Moitié des retours
    ); ?>
</h3>
<p class="text-center"><?= lang('Résultat Net Filiale') ?></p>

            
     
      
            
            
            








                        </div>
                    </div>
                <?php
} ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=admin_url('reports/profit_loss_pdf')?>/" + encodeURIComponent('<?=$start?>') + "/" + encodeURIComponent('<?=$end?>');
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    openImg(canvas.toDataURL());
                }
            });
            return false;
        });
    });
</script>
