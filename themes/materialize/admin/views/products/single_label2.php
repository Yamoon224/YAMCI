<?php (defined('BASEPATH')) or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html lang="<?php echo $this->config->item('language'); ?>">
<head>
  <meta charset="UTF-8">
  <title><?php echo htmlspecialchars($page_title ?? '') . ' | ' . htmlspecialchars($Settings->site_name ?? ''); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <style>
    * { box-sizing: border-box; }
    body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 20px; background: #f5f5f5; }
    h4 { margin: 5px 0; padding: 0; }
    .price { font-size: 0.8em; font-weight: bold; }
    .btn-group { margin: 10px 0; }
    .btn { display: inline-block; padding: 6px 14px; margin: 2px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; border: none; }
    .btn-primary { background: #666cff; color: #fff; }
    .btn-secondary { background: #8592a3; color: #fff; }
    @media print {
      .container h4, .container p, .btn-group, .pagination { display: none !important; }
      .labels { text-align: center; font-size: 10pt; page-break-after: always; padding: 1px; }
      .labels img { max-width: 100%; }
      body { background: none; padding: 0; }
    }
  </style>
</head>
<body>
  <div class="container">
    <h4><?php echo htmlspecialchars($Settings->site_name ?? '') . '<br>' . htmlspecialchars($page_title ?? ''); ?></h4>
    <div class="btn-group">
      <a class="btn btn-primary" href="javascript:void(0);" onclick="window.print();">🖨 <?php echo lang('print') ?: 'Imprimer'; ?></a>
      <a class="btn btn-secondary" href="javascript:void(0);" onclick="window.close();">✕ <?php echo lang('close') ?: 'Fermer'; ?></a>
    </div>
    <?php echo (!empty($html)) ? $html : '<h4>' . (lang('no_product_found') ?: 'Produit introuvable') . '</h4>'; ?>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var cat = document.getElementById('category');
      if (cat) {
        cat.value = '<?php echo (int)($category_id ?? 0); ?>';
        cat.addEventListener('change', function() {
          window.location.replace('<?php echo admin_url('products/print_labels2'); ?>/' + this.value);
        });
      }
    });
  </script>
</body>
</html>
