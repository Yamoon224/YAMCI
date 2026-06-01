<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('delivery') . ' ' . $delivery->do_reference_no; ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">
    <?php if ($Settings->user_rtl) { ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () { 
                $('.pull-right, .pull-left').addClass('flip'); 
            });
        </script>
    <?php } ?>
    <style>
        /* Ajustements généraux */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        #wrap {
            max-width: 100%;
            margin: 0 auto;
            padding-top: 50px; /* Ajuste la distance sous la barre jaune */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #000;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        h3 {
            margin-top: 20px;
            font-size: 16px;
            text-transform: uppercase;
        }

        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 30px;
            text-transform: uppercase;
        }

        .status-delivered {
            background-color: green;
            color: white;
        }

        .yellow-bar {
            background-color: yellow;
            width: 100%;
            height: 30px;
            margin: 0;
            padding: 0;
            position: fixed; /* Assure que la barre jaune est toujours au sommet */
            top: 0; /* L'ancre au sommet de la page */
            left: 0; /* Étend la barre sur toute la largeur de la page */
            z-index: 9999; /* La barre reste au-dessus de tout autre élément */
        }

        .clearfix::after {
            content: "";
            display: block;
            clear: both;
        }

        .row {
            margin-bottom: 20px;
        }

        .col-xs-4, .col-xs-3 {
            float: left;
            width: 33.33%;
            padding: 10px;
        }

        .col-xs-3.pull-right {
            width: 33.33%;
            text-align: right;
        }

        p {
            margin: 5px 0;
        }

        .text-center {
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .flip {
            direction: rtl;
        }
    </style>
</head>

<body>
<div id="wrap">

    <!-- Barre jaune en haut de la page -->
    <div class="yellow-bar"></div>

  
  
  
  
  
  <?php if ($logo) {
        $path   = base_url() . 'assets/uploads/logos/logo-delivery.png';  // Le nom du logo est facturier4.png
        $type   = pathinfo($path, PATHINFO_EXTENSION);
        $data   = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); ?>
        <div class="text-center" style="margin-bottom:20px; display: flex; justify-content: center; align-items: center;">
            <img src="<?= $base64; ?>" alt="<?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?>" style="max-width: 100%; height: auto;">
        </div>
<?php } ?>


    <!-- Titre Bon de Livraison centré -->
    <h2>Bon De Livraison</h2>

    <div class="table-responsive">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td width="30%"><?= $this->lang->line('date'); ?></td>
                <td width="70%"><?= $this->sma->hrld($delivery->date); ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('do_reference_no'); ?></td>
                <td><?= $delivery->do_reference_no; ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('sale_reference_no'); ?></td>
                <td><?= $delivery->sale_reference_no; ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('customer'); ?></td>
                <td><?= $delivery->customer; ?></td>
            </tr>
            <tr>
                <td><?= $this->lang->line('address'); ?></td>
                <td><?= $delivery->address; ?></td>
            </tr>
            <tr>
                <td><?= lang('Statut'); ?></td>
                <td class="<?= $delivery->status == 'delivered' ? 'status-delivered' : ''; ?>">
                    <?= lang($delivery->status); ?>
                </td>
            </tr>
            <?php if ($delivery->note) { ?>
                <tr>
                    <td><?= $this->lang->line('note'); ?></td>
                    <td><?= $this->sma->decode_html($delivery->note); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <h3><?= $this->lang->line('items'); ?></h3>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
                <tr>
                    <th style="text-align:center; vertical-align:middle;"><?= $this->lang->line('No'); ?></th>
                    <th style="vertical-align:middle;"><?= $this->lang->line('description'); ?></th>
                    <th style="text-align:center; vertical-align:middle;"><?= $this->lang->line('quantity'); ?></th>
                </tr>
            </thead>

            <tbody>
            <?php $r = 1;
            foreach ($rows as $row) : ?>
                <tr>
                    <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                    <td style="vertical-align:middle;">
                        <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '');
                        if ($row->details) {
                            echo '<br><strong>' . lang('product_details') . '</strong> ' . html_entity_decode($row->details);
                        }
                        ?>
                    </td>
                    <td style="width: 150px; text-align:center; vertical-align:middle;">
                        <?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code; ?>
                    </td>
                </tr>
            <?php $r++; endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="clearfix"></div>
    
    
    
    
    



    
               <?php
// Chemin de l'image de watermark
$logo_path = base_url('assets/uploads/logos/'); 
$logo_name = 'Abc'; 
$logo_extension = '.png'; 

$file_path = FCPATH . 'assets/uploads/logos/' . $logo_name . $logo_extension;
$logo_url = '';
if (file_exists($file_path)) {
    $logo_url = $logo_path . $logo_name . $logo_extension;
}

if (empty($logo_url)) {
    $logo_url = base_url('assets/uploads/logos/default_logo.png');
}
?>

<!-- Watermark au centre de la page -->
<div class="watermark">
    <img src="<?= $logo_url; ?>" alt="Logo Filigrane">
</div>

               
               <style>

		
		/* Style du watermark */
.watermark {
    position: absolute;
    top: 50%; /* Positionne au centre verticalement */
    left: 50%; /* Positionne au centre horizontalement */
    transform: translate(-50%, -50%); /* Centre parfaitement */
    z-index: -1; /* Assure que le watermark reste derrière le contenu */
    opacity: 0.1; /* Ajustez l'opacité pour que le watermark soit discret */
    pointer-events: none; /* Empêche le watermark d'interférer avec le clic sur la page */
}

.watermark img {
    max-width: 100%; /* Ajuste la largeur de l'image au contenu */
    max-height: 100%; /* Ajuste la hauteur de l'image au contenu */
}
    
    
    

    <?php if ($delivery->status == 'delivered') { ?>
        <div class="row">
            <div class="col-xs-4">
                <p><?= lang('prepared_by'); ?>:<br> <?= $user->first_name . ' ' . $user->last_name; ?></p>
            </div>
            <div class="col-xs-4">
                <p><?= lang('delivered_by'); ?>:<br> <?= $delivery->delivered_by; ?></p>
            </div>
            <div class="col-xs-4">
                <p><?= lang('received_by'); ?>:<br> <?= $delivery->received_by; ?></p>
            </div>
        </div>
    <?php } else { ?>
        <div class="row">
            <div class="col-xs-3">
                <p><?= lang('prepared_by'); ?>:</p>
                <p style="height:80px;"><?= $user->first_name . ' ' . $user->last_name; ?></p>
                <hr>
                <p><?= lang('stamp_sign'); ?></p>
            </div>
            <div class="col-xs-3">
                <p><?= lang('delivered_by'); ?>:</p>
                <p style="height:80px;">&nbsp;</p>
                <hr>
                <p><?= lang('stamp_sign'); ?></p>
            </div>
            <div class="col-xs-3 pull-right">
                <p><?= lang('received_by'); ?>:</p>
                <p style="height:80px;">&nbsp;</p>
                <hr>
                <p><?= lang('stamp_sign'); ?></p>
            </div>
        </div>
    <?php } ?>
</div>
</body>
</html>
