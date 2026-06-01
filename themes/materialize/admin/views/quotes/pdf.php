<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html dir="<?= $Settings->user_rtl ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= lang('quote') . ' ' . $inv->reference_no; ?></title>
    <link href="<?= $assets ?>styles/pdf/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $assets ?>styles/pdf/pdf.css" rel="stylesheet">

    <?php if ($Settings->user_rtl) { ?>
        <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () { $('.pull-right, .pull-left').addClass('flip'); });
        </script>
    <?php } ?>

    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            margin: 0;
            padding: 0;
            position: relative;
        }

        #header-bar {
            background-color: #fff727;
            width: 100%;
            height: 9px;
            color: white;
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            padding-top: 5px;
            margin: 0;
        }

        .header-right {
            position: absolute;
            right: 200px;
            top: 10px;
            font-size: 10px;
            font-weight: bold;
            text-align: right;
            margin-top: 105px;
        }

        .table th, .table td {
            font-size: 11px !important;
            padding: 2px;
        }

        .bold {
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .order_barcodes img {
            width: 100px;
            height: 100px;
        }

        .well-sm {
            font-size: 10px;
        }

        h1, h2 {
            font-size: 14px;
        }

        h2 {
            font-size: 12px;
        }

        .padding10 {
            padding: 10px;
        }

        .table-container {
            width: 85%;
            margin: 0 auto;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.1;
            pointer-events: none;
        }

        .watermark img {
            width: auto;
            height: auto;
            max-width: 100%;
            max-height: 100%;
        }

        .footer-watermark {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: -1;
            pointer-events: none;
        }

        .footer-watermark img {
            width: 100%;
            height: 100%;
        }

        .table th {
            background-color: #9cc2e6;
            color: white;
        }

        .table tfoot tr {
            background-color: #9cc2e6;
            color: white;
        }

        .company-info,
        .company-info .address,
        .company-info .city,
        .company-info .country,
        .company-info .phone,
        .company-info .email {
            display: none;
        }

        .devis-title {
            text-transform: uppercase;
            font-size: 16px;
            font-weight: bold;
            font-style: italic;
        }

        .mentions {
            margin-top: 20px;
            font-size: 11px;
            margin-right: 20px;
            font-style: italic;
        }

        .mention-credit {
            color: red;
            font-style: italic;
            font-weight: bold;
            margin-right: 20px;
        }
    </style>
</head>

<body>
<div id="wrap">
    <div id="header-bar"></div>

    <?php 
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

    <div class="watermark">
        <img src="<?= $logo_url; ?>" alt="Logo Filigrane">
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-lg-12">
            <?php if ($logo) {
                $path = base_url() . 'assets/uploads/logos/' . $biller->logo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data); ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= $base64; ?>" alt="<?= $biller->company && $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
            <?php } ?>
            <div class="clearfix"></div>

            <h1 class="text-center devis-title">
                DEVIS
            </h1>
            
            <div class="header-right">
                <p><?= lang('   DEVIS No'); ?>: <?= $inv->reference_no; ?></p>
                <p><?= lang('   DATE'); ?>: <?= $this->sma->hrld($inv->date); ?></p>
            </div>

            <div class="padding10">
                <div class="col-xs-5" style="margin-left: 40px;">
                    <?php echo $this->lang->line('to'); ?>:<br/>
                    <h2 class=""><?= $customer->company && $customer->company != '-' ? $customer->company : $customer->name; ?></h2>
                    <?= $customer->company && $customer->company != '-' ? '' : 'Attn: ' . $customer->name ?>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="table-container">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped print-table order-table" style="margin-top: 15px;">
                        <thead>
                        <tr>
                            <th><?= lang('no.'); ?></th>
                            <th><?= lang('Désignation'); ?></th>
                            <?php if ($Settings->indian_gst) { ?>
                                <th><?= lang('hsn_sac_code'); ?></th>
                            <?php } ?>
                            <th><?= lang('Qte.'); ?></th>
                            <th><?= lang('Prix unitaire'); ?></th>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<th>' . lang('tax') . '</th>';
                            }
                            if ($Settings->product_discount) {
                                echo '<th>' . lang('discount') . '</th>';
                            }
                            ?>
                            <th><?= lang('subtotal'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $r = 1;
                        foreach ($rows as $row) : ?>
                            <tr>
                                <td style="vertical-align:middle;"><?= $r; ?></td>
                                <td>
    <?= $row->product_name; // Affiche uniquement le nom du produit ?>
    <?= $row->details ? '<br>' . $this->sma->decode_html($row->details) : ''; ?>
</td>

                                <?php if ($Settings->indian_gst) {
                                    echo '<td class="text-center">' . $row->hsn_sac_code . '</td>';
                                } ?>
                                <td style="text-align:center; width:60px; vertical-align:middle;">
                                    <?php 
                                    if ($row->unit_quantity == 1 && $row->unit_price == 0) {
                                        echo ''; // La cellule est vide si quantité=1 et prix=0
                                    } else {
                                        echo $this->sma->formatQuantity($row->unit_quantity); // Affiche la quantité sinon
                                    }
                                    ?>
                                </td>
                                <td class="text-right" style="vertical-align:middle;">
                                    <?= $row->unit_price != 0 ? $this->sma->formatMoney($row->unit_price) : ''; ?>
                                </td>
                                <?php if ($Settings->tax1 && $row->product_tax != 0) { ?>
                                    <td class="text-right"><?= $this->sma->formatMoney($row->product_tax); ?></td>
                                <?php } ?>
                                <?php if ($Settings->product_discount) { ?>
                                    <td class="text-right"><?= $row->product_discount != 0 ? $this->sma->formatMoney($row->product_discount) : ''; ?></td>
                                <?php } ?>
                                <td class="text-right" style="vertical-align:middle;">
                                    <?= $row->subtotal != 0 ? $this->sma->formatMoney($row->subtotal) : ''; ?>
                                </td>
                            </tr>
                        <?php $r++; endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="5" class="text-right"><?= lang('TOTAL'); ?> (<?= $default_currency->code; ?>)</td>
                            <td class="text-right"><?= $this->sma->formatMoney($inv->grand_total); ?></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="mentions" style="margin-left: 90px;">
            <?php
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

            function convertirMontantEnLettres($montant) {
                $fcfa = floor($montant);
                $centimes = round(($montant - $fcfa) * 100);
                $lettresFCFA = convertirEntierEnLettres($fcfa);
                $lettresCentimes = ($centimes > 0) ? convertirEntierEnLettres($centimes) . " centimes" : '';

                if ($lettresCentimes) {
                    return ucfirst($lettresFCFA) . " francs CFA et " . $lettresCentimes;
                }

                return ucfirst($lettresFCFA) . " francs CFA";
            }

            $total = $inv->grand_total;
            $totalLettres = convertirMontantEnLettres($total);
            ?>

           <p><strong>Cette présente pro-forma est arrêtée à la somme de : <?= $this->sma->formatMoney($total); ?> F CFA (<?= $totalLettres; ?>)</strong></p>
            <p class="mention-credit"><em>NB : Possibilité de paiement à crédit sur 24 mois.</em></p>
        </div>
    </div>

   <!-- Footer watermark (optionnel, si tu veux un watermark dans le footer) -->
<div class="footer-watermark" style="position: fixed; bottom: 0; left: 0; width: 100%; height: 80px; z-index: -1; pointer-events: none;">
    <!-- Texte en haut à droite -->
    <div style="position: absolute; bottom: 100px; right: 10px; font-size: 10px; font-weight: bold; color: #000;">
        
Avec LTE GROUPE, votre SATISFACTION est notre PRIORRITE 

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
</div>
</body>
</html>
