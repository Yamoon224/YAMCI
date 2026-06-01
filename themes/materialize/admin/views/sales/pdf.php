<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->lang->line('sale') . ' ' . $inv->reference_no; ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">
    <?php if ($Settings->user_rtl) {
        ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () { $('.pull-right, .pull-left').addClass('flip'); });
        </script>
        <?php
    } ?>
    
    
</head>

<body>
    
    <body>
    <!-- Bande noire en haut -->
    <div class="header-banner"></div>

    <div id="wrap">
        <!-- Le reste de votre contenu HTML ici -->

<div id="wrap">
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) {
                $path   = base_url() . 'assets/uploads/logos/' . $biller->logo;
                $type   = pathinfo($path, PATHINFO_EXTENSION);
                $data   = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= $base64; ?>" alt="<?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
                <?php
            }
            ?>
            <div class="clearfix"></div>
            <div class="padding10">
                <?php if ($Settings->invoice_view == 1) {
                    ?>tab
                    <div class="col-xs-12 text-center">
                        <h1><?= lang('tax_invoice'); ?></h1>
                    </div>
                    <?php
                } ?>

                <div class="col-xs-5">
                    <?php echo $this->lang->line('to'); ?>:
                    <h2 class=""><?= $customer->company && $customer->company != '-' ? $customer->company : $customer->name; ?></h2>
                   
              
                </div>

            </div>
           
                    <div class="clearfix"></div>
                </div>
                
                    <h1 class="text-center devis-title">
                Reçu de paiement

            </h1>
                <div class="col-xs-5">
                    <div class="bold">
                       
                        
                        <?= $inv->payment_method ? '<br>' . lang('payment_method') . ': ' . lang($inv->payment_method) : ''; ?>
                        <?php if ($inv->payment_status != 'paid' && $inv->due_date) {
                            echo '<br>' . lang('due_date') . ': ' . $this->sma->hrsd($inv->due_date);
                        } ?>
                        <?php if (!empty($inv->return_sale_ref)) {
                            echo lang('return_ref') . ': ' . $inv->return_sale_ref . '<br>';
                        } ?>
                       
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="clearfix"></div>
            <?php
                $col = $Settings->indian_gst ? 5 : 4;
            if ($Settings->product_discount && $inv->product_discount != 0) {
                $col++;
            }
            if ($Settings->tax1 && $inv->product_tax > 0) {
                $col++;
            }
            if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                $tcol = $col - 2;
            } elseif ($Settings->product_discount && $inv->product_discount != 0) {
                $tcol = $col - 1;
            } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                $tcol = $col - 1;
            } else {
                $tcol = $col;
            }
            
            
            
            ?>
            <div class="col-xs-12" style="margin-top: 15px;">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?= lang('No'); ?></th>
                        <th><?= lang('Désignation'); ?></th>
                        <?php if ($Settings->indian_gst) {
                            ?>
                            <th><?= lang('hsn_sac_code'); ?></th>
                            <?php
                        } ?>
                        <th><?= lang('quantity'); ?></th>
                        <th><?= lang('unit_price'); ?></th>
                        <?php
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            echo '<th>' . lang('tax') . '</th>';
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0) {
                            echo '<th>' . lang('discount') . '</th>';
                        }
                        ?>
                        <th><?= lang('subtotal'); ?></th>
                    </tr>
                    
               
               
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



    /* CSS pour afficher la date en haut à droite avec une marge basse de 50px */
    .invoice-header {
        text-align: right;         /* Aligne le texte à droite */
        margin-top: -250px;        /* Réduit la marge en haut pour la mettre plus haut */
        margin-bottom: 50px;       /* Ajoute une marge de 50px en bas */
        position: absolute;        /* Positionne l'élément de manière absolue par rapport au parent */
        top: 0;                    /* Place la date tout en haut */
        right: 50px;               /* Place la date tout à droite */
    }

    .bold {
        font-weight: bold;         /* Met le texte en gras */
    }

    .date {
        font-size: 12px;           /* Taille de la police de la date */
        font-weight: bold;         /* Met en gras la date */
    }

    /* Réduire l'espace entre les lignes dans l'élément .invoice-header */
    .invoice-header br {
        margin-bottom: 0;          /* Réduit la marge entre les lignes */
    }

    /* Style spécifique pour la référence afin d'assurer l'alignement avec les autres lignes */
    .invoice-header .reference {
        font-weight: normal;       /* La référence peut être en texte normal, pas en gras */
        font-size: 8px;           /* Taille de la police de la référence */
    }
    
    
    
/* Bande noire en haut */
.header-banner {
    background-color: #FFFD55;
    height: 20px;
    width: 100%;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000; /* Assurez-vous que la bande est au-dessus des autres éléments */
}

    
    .table-responsive {
            margin-left: auto;
            margin-right: auto;
            padding-right: 25px; /* Ajouter une marge de 2px à droite */
        }
    
    
       table th, table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        /* Espacement entre les lignes du tableau */
        table th {
            background-color: #f0f0f0;
        }
		
		
		
	 .devis-title {
            text-transform: uppercase;
            font-size: 11px;
            font-weight: bold;
            font-style: italic;
        }	
		
		
		
		body { font-size: 10px; }
		
		
		
		
		
	

		
    
</style>










<div class="invoice-header">
    <div class="bold">
        <?= lang('date'); ?>: <?= $this->sma->hrld($inv->date); ?><br>
        
        <?= $inv->payment_method ? lang('payment_method') . ': ' . lang($inv->payment_method) : ''; ?>
        
        <?php if ($inv->payment_status != 'paid' && $inv->due_date) { ?>
            <br><?= lang('due_date'); ?>: <?= $this->sma->hrsd($inv->due_date); ?>
        <?php } ?>
        
        <?php if (!empty($inv->return_sale_ref)) { ?>
            <br><?= lang('return_ref'); ?>: <?= $inv->return_sale_ref; ?>
        <?php } ?>

        <!-- Référence juste en dessous avec un style spécifique -->
        <br class="reference"><?= lang('ref'); ?>: <?= $inv->reference_no; ?>
        
        
       <div class="order_barcodes" style="position: absolute; top: 0; right: 50px; margin-top: 100px;">
    <!-- QR Code avec taille plus petite -->
    <div style="position: relative; top: 0; width: 5px; height: 5px;">
        <!-- QR code content here -->
    </div>
</div>

        <?php
        // Logic for QR code generation
        if ($Settings->pdf_lib == 'dompdf') {
            if ($Settings->ksa_qrcode) {
                $qrtext = $this->inv_qrcode->base64([
                    'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
                    'vat_no'           => $biller->vat_no ?: $biller->get_no,
                    'date'             => $inv->date,
                    'grand_total'      => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
                    'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
                ]);
                echo $this->sma->qrcode('text', $qrtext, 1);  // QR code with smaller size
            } else {
                echo $this->sma->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 1);  // Link-based QR code
            }
        } else {
            if ($Settings->ksa_qrcode) {
                $qrtext = $this->inv_qrcode->base64([
                    'seller'           => $biller->company && $biller->company != '-' ? $biller->company : $biller->name,
                    'vat_no'           => $biller->vat_no ?: $biller->get_no,
                    'date'             => $inv->date,
                    'grand_total'      => $return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total,
                    'total_tax_amount' => $return_sale ? ($inv->total_tax + $return_sale->total_tax) : $inv->total_tax,
                ]);
                $svg = $this->sma->qrcode('text', $qrtext, 1, null, null, true);  // QR code with SVG
                echo '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="15" height="15" />';  // Display QR code with smaller size
            } else {
                $svg = $this->sma->qrcode('link', urlencode(site_url('view/sale/' . $inv->hash)), 1, null, null, true);  // Link-based QR code
                echo '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="15" height="15" />';  // Display QR code with smaller size
            }
        }
        ?>
    </div>

  
</div>

    </div>
</div>

               

<div class="invoice-header">
    <div class="bold">
        <?= lang('date'); ?>: <?= $this->sma->hrld($inv->date); ?><br>
        
        <?= $inv->payment_method ? '<br>' . lang('payment_method') . ': ' . lang($inv->payment_method) : ''; ?>
        <?php if ($inv->payment_status != 'paid' && $inv->due_date) {
            echo '<br>' . lang('due_date') . ': ' . $this->sma->hrsd($inv->due_date);
        } ?>
        <?php if (!empty($inv->return_sale_ref)) {
            echo lang('return_ref') . ': ' . $inv->return_sale_ref . '<br>';
        } ?>
    </div>
</div>

                    
                    
                    </thead>
               
               
               
               
               
               
                    




<tbody>
    <?php
    $r   = 1;
    $qty = 0;
    foreach ($rows as $row) :
    ?>
        <tr>
            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
            <td style="vertical-align:middle; text-align:left;">
                <!-- Affichage du nom du produit et d'autres informations si présentes -->
                <?= $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                <?= $row->details ? '<br>' . $this->sma->decode_html($row->details) : ''; ?>
                <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
            </td>
            <?php if ($Settings->indian_gst) { ?>
                <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->hsn_code ?: ''; ?></td>
            <?php } ?>
            <td style="width: 80px; text-align:center; vertical-align:middle;">
                <?php 
                // Vérification de la condition pour afficher la quantité ou laisser vide
                if ($row->unit_quantity == 1 && $row->unit_price == 0) {
                    echo ''; // La cellule reste vide si quantité=1 et prix=0
                } else {
                    echo $this->sma->formatQuantity($row->unit_quantity) . ' ' . ($inv->sale_status == 'returned' ? $row->base_unit_code : $row->product_unit_code); 
                }
                ?>
            </td>
            <td class="text-right" style="width:100px;">
                <?php
                // Affichage du prix, mais si le prix unitaire est 0, on affiche vide
                if ($row->unit_price == 0) {
                    echo ''; // La cellule reste vide si le prix est 0
                } else {
                    // Si le prix unitaire est différent du prix réel, on affiche le prix barré
                    echo $row->unit_price != $row->real_unit_price && $row->item_discount > 0 ? '<del>' . $this->sma->formatMoney($row->real_unit_price) . '</del>' : '';
                    echo $this->sma->formatMoney($row->unit_price); // Affichage du prix unitaire
                }
                ?>
            </td>
            <?php
            // Affichage de la taxe si définie
            if ($Settings->tax1 && $inv->product_tax > 0) {
                echo '<td class="text-right" style="width: 90px; vertical-align:middle;">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
            }
            // Affichage du discount produit si applicable
            if ($Settings->product_discount && $inv->product_discount != 0) {
                echo '<td class="text-right" style="width: 90px; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
            }
            ?>
            <td class="text-right" style="vertical-align:middle; width:110px;">
                <?php 
                // Affichage du sous-total, si le prix est 0, la cellule reste vide
                if ($row->unit_price == 0) {
                    echo ''; // La cellule reste vide si le prix unitaire est 0
                } else {
                    echo $this->sma->formatMoney($row->subtotal); // Affichage du sous-total
                }
                ?>
            </td>
        </tr>
    <?php
        $r++;
    endforeach;

    // Traitement des articles retournés
    if ($return_rows) {
        echo '<tr class="warning"><td colspan="' . ($col + 1) . '" class="no-border"><strong>' . lang('returned_items') . '</strong></td></tr>';
        foreach ($return_rows as $row) :
    ?>
            <tr class="warning">
                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                <td style="vertical-align:middle; text-align:left;">
                    <!-- Affichage des articles retournés -->
                    <?= $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                    <?= $row->second_name ? '<br>' . $row->second_name : ''; ?>
                    <?= $row->details ? '<br>' . $this->sma->decode_html($row->details) : ''; ?>
                    <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                </td>
                <?php if ($Settings->indian_gst) { ?>
                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $row->hsn_code ?: ''; ?></td>
                <?php } ?>
                <td style="width: 80px; text-align:center; vertical-align:middle;">
                    <?= $this->sma->formatQuantity($row->quantity) . ' ' . $row->base_unit_code; ?>
                </td>
                <td class="text-right" style="width:90px;">
                    <?php
                    // Affichage du prix de l'article retourné, mais vide si le prix est 0
                    if ($row->unit_price == 0) {
                        echo ''; // La cellule reste vide si le prix est 0
                    } else {
                        echo $this->sma->formatMoney($row->unit_price); // Affichage du prix unitaire
                    }
                    ?>
                </td>
                <?php
                // Affichage de la taxe si définie pour l'article retourné
                if ($Settings->tax1 && $inv->product_tax > 0) {
                    echo '<td class="text-right" style="vertical-align:middle;">' . ($row->item_tax != 0 ? '<small>(' . ($Settings->indian_gst ? $row->tax : $row->tax_code) . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                }
                // Affichage du discount pour l'article retourné si applicable
                if ($Settings->product_discount && $inv->product_discount != 0) {
                    echo '<td class="text-right" style="vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                }
                ?>
                <td class="text-right" style="width:110px;">
                    <?php 
                    // Affichage du sous-total de l'article retourné, mais vide si le prix est 0
                    if ($row->unit_price == 0) {
                        echo ''; // La cellule reste vide si le prix unitaire est 0
                    } else {
                        echo $this->sma->formatMoney($row->subtotal); // Affichage du sous-total
                    }
                    ?>
                </td>
            </tr>
    <?php
            $r++;
        endforeach;
    }
    ?>
</tbody>





<tfoot>
    <?php if ($inv->grand_total != $inv->total) { ?>
        <tr>
            <td class="text-right" colspan="<?= $tcol; ?>"><?= lang('total'); ?> (<?= $default_currency->code; ?>)</td>
            <?php
            if ($Settings->tax1 && $inv->product_tax > 0) {
                echo '<td class="text-right">' . $this->sma->formatMoney($return_sale ? ($inv->product_tax + $return_sale->product_tax) : $inv->product_tax) . '</td>';
            }
            if ($Settings->product_discount && $inv->product_discount != 0) {
                echo '<td class="text-right">' . $this->sma->formatMoney($return_sale ? ($inv->product_discount + $return_sale->product_discount) : $inv->product_discount) . '</td>';
            } ?>
            <td class="text-right"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax) + ($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
        </tr>
    <?php } ?>
    
    <?php if ($return_sale) {
        echo '<tr><td class="text-right" colspan="' . $col . '">' . lang('return_total') . ' (' . $default_currency->code . ')</td><td class="text-right">' . $this->sma->formatMoney($return_sale->grand_total) . '</td></tr>';
    } ?>
    
    <?php if ($inv->surcharge != 0) {
        echo '<tr><td class="text-right" colspan="' . $col . '">' . lang('return_surcharge') . ' (' . $default_currency->code . ')</td><td class="text-right">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
    } ?>
    
    <?php if ($Settings->indian_gst) {
        if ($inv->cgst > 0) {
            $cgst = $return_sale ? $inv->cgst + $return_sale->cgst : $inv->cgst;
            echo '<tr><td colspan="' . $col . '" class="text-right">' . lang('cgst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ($Settings->format_gst ? $this->sma->formatMoney($cgst) : $cgst) . '</td></tr>';
        }
        if ($inv->sgst > 0) {
            $sgst = $return_sale ? $inv->sgst + $return_sale->sgst : $inv->sgst;
            echo '<tr><td colspan="' . $col . '" class="text-right">' . lang('sgst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ($Settings->format_gst ? $this->sma->formatMoney($sgst) : $sgst) . '</td></tr>';
        }
        if ($inv->igst > 0) {
            $igst = $return_sale ? $inv->igst + $return_sale->igst : $inv->igst;
            echo '<tr><td colspan="' . $col . '" class="text-right">' . lang('igst') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ($Settings->format_gst ? $this->sma->formatMoney($igst) : $igst) . '</td></tr>';
        }
    } ?>
    
    <?php if ($inv->order_discount != 0) {
        echo '<tr><td class="text-right" colspan="' . $col . '">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td class="text-right">' . ($inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount + $return_sale->order_discount) : $inv->order_discount) . '</td></tr>';
    } ?>
    
    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
        echo '<tr><td class="text-right" colspan="' . $col . '">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td class="text-right">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax + $return_sale->order_tax) : $inv->order_tax) . '</td></tr>';
    } ?>
    
    <?php if ($inv->shipping != 0) {
        echo '<tr><td class="text-right" colspan="' . $col . '">' . lang('shipping') . ' (' . $default_currency->code . ')</td><td class="text-right">' . $this->sma->formatMoney($inv->shipping - ($return_sale && $return_sale->shipping ? $return_sale->shipping : 0)) . '</td></tr>';
    } ?>
    
    <tr>
        <td class="text-right" colspan="<?= $col; ?>" style="font-weight:bold;"><?= lang('total_amount'); ?> (<?= $default_currency->code; ?>)</td>
        <td class="text-right" style="font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total); ?></td>
    </tr>

    <tr>
        <td class="text-right" colspan="<?= $col; ?>" style="font-weight:bold;"><?= lang('paid'); ?> (<?= $default_currency->code; ?>)</td>
        <td class="text-right" style="font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid); ?></td>
    </tr>
    <tr>
        <td class="text-right" colspan="<?= $col; ?>" style="font-weight:bold;"><?= lang('Reste à payer'); ?> (<?= $default_currency->code; ?>)</td>
        <td class="text-right" style="font-weight:bold;"><?= $this->sma->formatMoney(($return_sale ? ($inv->grand_total + $return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid + $return_sale->paid) : $inv->paid)); ?></td>
    </tr>
</tfoot>
</table>

</div>
</div>
</div>

<!-- Section for the amount in words below the table -->
<div class="mentions" style="margin-left: 90px;">
    <?php
    // Function to convert integer to words
    function convertirEntierEnLettres($nombre) {
        $unites = [
            0 => "zéro", 1 => "un", 2 => "deux", 3 => "trois", 4 => "quatre", 5 => "cinq", 6 => "six", 
            7 => "sept", 8 => "huit", 9 => "neuf", 10 => "dix", 11 => "onze", 12 => "douze", 13 => "treize", 
            14 => "quatorze", 15 => "quinze", 16 => "seize", 17 => "dix-sept", 18 => "dix-huit", 19 => "dix-neuf"
        ];
        $dizaines = [
            20 => "vingt", 30 => "trente", 40 => "quarante", 50 => "cinquante", 60 => "soixante", 
            70 => "soixante-dix", 80 => "quatre-vingts", 90 => "quatre-vingt-dix"
        ];

        $puissances = [
            1000000000 => "milliard", 1000000 => "million", 1000 => "mille", 100 => "cent"
        ];

        if ($nombre < 20) {
            return $unites[$nombre];
        }

        if ($nombre < 100) {
            $dizaine = floor($nombre / 10) * 10;
            $unite = $nombre % 10;
            if ($unite == 0) {
                return $dizaines[$dizaine];
            } else {
                return $dizaines[$dizaine] . "-" . $unites[$unite];
            }
        }

        $resultat = "";
        foreach ($puissances as $valeur => $nom) {
            if ($nombre >= $valeur) {
                $quotient = floor($nombre / $valeur);
                $reste = $nombre % $valeur;

                if ($quotient == 1 && $valeur == 100) {
                    $resultat .= "cent ";
                } else {
                    $resultat .= convertirEntierEnLettres($quotient) . " " . $nom . " ";
                }

                if ($reste > 0) {
                    $resultat .= "et " . convertirEntierEnLettres($reste);
                }

                break;
            }
        }

        return trim($resultat);
    }

  // Fonction pour convertir le montant payé en lettres (y compris centimes)
function convertirMontantEnLettres($montant) {
    $fcfa = floor($montant);  // Partie entière (les francs)
    $centimes = round(($montant - $fcfa) * 100);  // Partie décimale (les centimes)
    $lettresFCFA = convertirEntierEnLettres($fcfa);  // Conversion des francs en lettres
    $lettresCentimes = ($centimes > 0) ? convertirEntierEnLettres($centimes) . " centimes" : '';  // Conversion des centimes en lettres si > 0

    // Construction de la phrase avec la partie entière et les centimes (si présents)
    if ($lettresCentimes) {
        return ucfirst($lettresFCFA) . " francs CFA et " . $lettresCentimes . " francs CFA";  // Ajout "francs CFA" à la fin des centimes
    }

    return ucfirst($lettresFCFA) . " francs CFA";  // Si pas de centimes, retour du montant en francs avec "francs CFA"
}

// Récupérer le montant payé et le convertir en lettres
$totalPaye = $inv->paid;  // Utilisez le montant payé ici
$totalPayeLettres = convertirMontantEnLettres($totalPaye);
?>

<!-- Afficher le montant payé en chiffres et en lettres -->
<p><strong>Cette facture a été réglée à la somme de : <?= $this->sma->formatMoney($totalPaye); ?> F CFA (<?= $totalPayeLettres; ?>)</strong></p>


   
</div>



<!-- Modalités de paiement -->
<div style="margin-bottom: 20px; margin-left: 80px; font-size: 8px;">
    <strong>Modalité de paiement :</strong> 
    <p style="text-align: center;">
        <div style="display: inline-block; margin-left: 30px; margin-right: 10px;">
            <input type="checkbox" id="espèce" name="modalite" value="espece">
            <label for="espèce">Espèce</label>
        </div>
        <div style="display: inline-block; margin-left: 30px; margin-right: 10px;">
            <input type="checkbox" id="virement" name="modalite" value="virement">
            <label for="virement">Virement</label>
        </div>
        <div style="display: inline-block; margin-left: 30px; margin-right: 10px;">
            <input type="checkbox" id="cheque" name="modalite" value="cheque">
            <label for="cheque">Cheque</label>
        </div>
        <div style="display: inline-block; margin-left: 30px; margin-right: 10px;">
            <input type="checkbox" id="mobile_money" name="modalite" value="mobile_money">
            <label for="mobile_money">Mobile Money</label>
        </div>
    </p>
</div>




<!-- Signature zones -->
<div style="margin-top: 20px;">
    <!-- Signature Fournisseur -->
    <div style="width: 40%; float: left; text-align: center; border: 1px solid #000; padding: 10px; font-size: 12px;">
        <strong>Signature Fournisseur</strong>
        <div style="border-top: 1px solid #000; margin-top: 20px;"></div>
    </div> 

    <!-- Signature Client -->
    <div style="width: 40%; float: right; text-align: center; border: 1px solid #000; padding: 10px; font-size: 12px;">
        <strong>Signature Client</strong>
        <div style="border-top: 1px solid #000; margin-top: 20px;"></div>
    </div>
</div>


<!-- Footer watermark (optionnel, si tu veux un watermark dans le footer) -->
<div class="footer-watermark" style="position: fixed; bottom: 0; left: 0; width: 100%; height: 80px; z-index: -1; pointer-events: none;">
    <!-- Texte en haut à droite -->
    <div style="position: absolute; bottom: 100px; right: 10px; font-size: 10px; font-weight: bold; color: #000;">
        
Avec LTE GROUPE, votre SATISFACTION est notre PRIORITE 

    </div>

    <!-- Texte sous le premier texte avec des lignes colorées -->
    <div style="position: absolute; bottom: 10px; left: 0; width: 100%; font-size: 9px; color: #000; text-align: center;">
        <!-- Ligne bleue en haut du texte -->
        <div style="width: 100%; height: 4px; background-color: #0c80ae;"></div>

        <!-- Contenu du texte -->
        <div style="padding: 5px;">
            Siège Social Abidjan - Cocody - Riviéra 3 non loin de la Pharmacie ST Agathe - N° RC : CI-TDI-2021-B-325 - N°CC 2116775 Y Centre des Impôts : Cocody-Djeni statut juridique: SARL Compte Bancaire : BDU N° CI 93 C/180 01010 02040141222 94
            Côte d'Ivoire : +225 07 49 00 09 61 / 07 48 53 53 57 - Whatsapp : 07 77 03 03 52 - Site Web: WWW.LTE.Cl
            Mali - Ouagadougou (Burkina -Faso) - Guinée-Conakry.
        </div>
        
        <!-- Deux lignes bleues en bas du texte -->
        <div style="width: 100%; height: 6px; background-color: #0c80ae; margin-top: 5px;"></div>
        <div style="width: 100%; height: 6px; background-color: #0c80ae; margin-top: 5px;"></div>
    </div>




                    </tbody>
                   
                </table>
                
                
                
                
            </div>
            <?= $Settings->invoice_view > 0 ? $this->gst->summary($rows, $return_rows, ($return_sale ? $inv->product_tax + $return_sale->product_tax : $inv->product_tax)) : ''; ?>
            </div>
           
           
        


   
</div>

           
           
           
           
           
        </div>
    </div>
</div>
</body>
</html>
