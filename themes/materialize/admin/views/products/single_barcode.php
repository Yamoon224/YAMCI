<?php defined('BASEPATH') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <base href="<?= base_url(); ?>"/>
    <title><?php echo $page_title . ' | ' . $Settings->site_name; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            font-size: 13px;
            text-align: center;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 0;
        }
        .tab-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding: 16px;
        }
        .action-bar {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 12px 16px;
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: flex-start;
        }
        .btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 16px; border-radius: 5px; border: none;
            font-size: 13px; cursor: pointer; text-decoration: none;
            font-family: inherit;
        }
        .btn-primary { background: #696cff; color: #fff; }
        .btn-primary:hover { background: #5b5ef0; }
        .btn-danger  { background: #ff3e1d; color: #fff; }
        .btn-danger:hover  { background: #e03215; }
        .btn-success { background: #71dd37; color: #fff; }
        .btn-success:hover { background: #59c120; }
        table td { text-align: center; padding: 4px; }
        h4 { margin: 5px; padding: 0; }
        @media print {
            .action-bar { display: none !important; }
            body { background: #fff; }
            h3 { margin-top: 0; }
            table td { border-color: #f9f9f9 !important; }
        }
    </style>
</head>
<body>
<div class="tab-wrapper">
    <div class="action-bar">
        <a class="btn btn-primary" href="#" onclick="window.print(); return false;">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z"/>
                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z"/>
            </svg>
            <?php echo $this->lang->line('print'); ?>
        </a>
        <a class="btn btn-danger" onclick="javascript:window.close()">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854z"/>
            </svg>
            <?= lang('close'); ?>
        </a>
    </div>

    <?= $table; ?>

    <div class="action-bar" style="margin-top:20px; margin-bottom:0;">
        <a class="btn btn-success" href="<?= admin_url(); ?>">
            <?= lang('home'); ?>
        </a>
        <a class="btn btn-primary" href="#" onclick="window.print(); return false;">
            <?php echo $this->lang->line('print'); ?>
        </a>
        <a class="btn btn-danger" onclick="javascript:window.close()">
            <?= lang('close'); ?>
        </a>
    </div>
</div>
</body>
</html>
