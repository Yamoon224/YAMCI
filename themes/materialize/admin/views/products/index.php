<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1">
      <i class="ri ri-barcode-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('products') ?: 'Produits'; ?>
      <span class="text-muted fw-normal ms-1 fs-6">(<?php echo $warehouse_id ? $warehouse->name : lang('all_warehouses'); ?>)</span>
    </h4>
    <p class="mb-0 text-muted">Catalogue produits, stocks et alertes</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url('welcome'); ?>">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo lang('products') ?: 'Produits'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<!-- ============================
     STATS WIDGETS (style Pixinvent)
     ============================ -->
<div class="card mb-6">
  <div class="card-widget-separator-wrapper">
    <div class="card-body card-widget-separator">
      <div class="row gy-4 gy-sm-1">

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('total_products') ?: 'Total Produits'; ?></p>
              <h4 class="mb-1"><?php echo number_format($stats->total_products); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-primary"><?php echo lang('items') ?: 'articles'; ?></span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-primary">
                <i class="ri ri-barcode-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none me-6" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-4 pb-sm-0">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('stock_value_by_price') ?: 'Valeur stock (vente)'; ?></p>
              <h4 class="mb-1"><?php echo $this->sma->formatMoney($stats->stock_by_price); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-success"><?php echo lang('selling_price') ?: 'prix vente'; ?></span></p>
            </div>
            <div class="avatar me-lg-6">
              <span class="avatar-initial rounded-3 bg-label-success">
                <i class="ri ri-archive-stack-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
          <hr class="d-none d-sm-block d-lg-none" />
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start border-end pb-4 pb-sm-0 card-widget-3">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('stock_value_by_cost') ?: 'Valeur stock (coût)'; ?></p>
              <h4 class="mb-1"><?php echo $this->sma->formatMoney($stats->stock_by_cost); ?></h4>
              <p class="mb-0"><span class="badge rounded-pill bg-label-info"><?php echo lang('cost_price') ?: 'prix coûtant'; ?></span></p>
            </div>
            <div class="avatar me-sm-6">
              <span class="avatar-initial rounded-3 bg-label-info">
                <i class="ri ri-coins-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="col-sm-6 col-lg-3">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <p class="mb-1 text-muted"><?php echo lang('low_stock_alerts') ?: 'Alertes stock'; ?></p>
              <h4 class="mb-1 <?php echo $stats->low_stock > 0 ? 'text-danger' : ''; ?>"><?php echo $stats->low_stock; ?></h4>
              <p class="mb-0">
                <?php if ($stats->low_stock > 0): ?>
                  <span class="badge rounded-pill bg-label-danger"><?php echo lang('action_required') ?: 'action requise'; ?></span>
                <?php else: ?>
                  <span class="badge rounded-pill bg-label-success"><?php echo lang('all_good') ?: 'tout va bien'; ?></span>
                <?php endif; ?>
              </p>
            </div>
            <div class="avatar">
              <span class="avatar-initial rounded-3 <?php echo $stats->low_stock > 0 ? 'bg-label-danger' : 'bg-label-secondary'; ?>">
                <i class="ri ri-alarm-warning-line" style="font-size:28px"></i>
              </span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])):
    echo admin_form_open('products/product_actions' . ($warehouse_id ? '/' . $warehouse_id : ''), 'id="action-form"');
endif; ?>

<!-- ============================
     CARTE LISTE PRODUITS
     ============================ -->
<div class="card">

  <!-- card-header : filtres dropdowns -->
  <div class="card-header border-bottom">
    <h5 class="card-title mb-4"><?php echo lang('filter') ?: 'Filtre'; ?></h5>
    <div class="d-flex justify-content-between align-items-center row gap-3 gx-6 gap-md-0">
      <div class="col-md-4">
        <select id="filterCategory" class="form-select">
          <option value=""><?php echo lang('all_categories') ?: 'Toutes catégories'; ?></option>
          <?php if (!empty($categories)) foreach ($categories as $c): ?>
            <option value="<?php echo htmlspecialchars($c->name, ENT_QUOTES); ?>"><?php echo htmlspecialchars($c->name); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterBrand" class="form-select">
          <option value=""><?php echo lang('all_brands') ?: 'Toutes marques'; ?></option>
          <?php if (!empty($brands)) foreach ($brands as $b): ?>
            <option value="<?php echo htmlspecialchars($b->name, ENT_QUOTES); ?>"><?php echo htmlspecialchars($b->name); ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-4">
        <select id="filterStock" class="form-select">
          <option value=""><?php echo lang('all_stock_status') ?: 'Tout statut stock'; ?></option>
          <option value="in_stock"><?php echo lang('in_stock') ?: 'En stock'; ?></option>
          <option value="low_stock"><?php echo lang('low_stock') ?: 'Stock faible'; ?></option>
          <option value="out_of_stock"><?php echo lang('out_of_stock') ?: 'Rupture'; ?></option>
        </select>
      </div>
    </div>
  </div>

  <!-- toolbar : search + actions -->
  <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3 py-4 border-bottom">
    <div class="dt-search-custom">
      <input type="search" id="customDtSearch" class="form-control" placeholder="<?php echo lang('search') ?: 'Rechercher'; ?>" />
    </div>
    <div class="d-flex flex-wrap gap-2">
      <a href="<?php echo admin_url('products/add'); ?>" class="btn btn-primary">
        <span class="ri-add-line me-1" aria-hidden="true"></span>
        <?php echo lang('add_product') ?: 'Ajouter produit'; ?>
      </a>
      <?php if (!$warehouse_id): ?>
      <a href="<?php echo admin_url('products/update_price'); ?>" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#myModal">
        <span class="ri-price-tag-3-line me-1" aria-hidden="true"></span>
        <?php echo lang('update_price') ?: 'MAJ prix'; ?>
      </a>
      <?php endif; ?>
      <div class="dropdown">
        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <span class="ri-upload-2-line me-1"></span><?php echo lang('export') ?: 'Export'; ?>
        </button>
        <ul class="dropdown-menu dropdown-menu-end">
          <li>
            <a class="dropdown-item" href="#" id="excel" data-action="export_excel">
              <span class="ri-file-excel-2-line me-2"></span><?php echo lang('export_to_excel') ?: 'Excel'; ?>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#" id="labelProducts" data-action="labels">
              <span class="ri-printer-line me-2"></span><?php echo lang('print_barcode_label') ?: 'Imprimer codes-barres'; ?>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#" id="sync_quantity" data-action="sync_quantity">
              <span class="ri-refresh-line me-2"></span><?php echo lang('sync_quantity') ?: 'Sync quantités'; ?>
            </a>
          </li>
          <li>
            <a class="dropdown-item" href="#" id="set_avg_cost" data-action="set_avg_cost">
              <span class="ri-money-dollar-circle-line me-2"></span><?php echo lang('set_avg_cost') ?: 'Coût moyen'; ?>
            </a>
          </li>
          <?php if (!empty($warehouses)): ?>
          <li><hr class="dropdown-divider"></li>
          <li><h6 class="dropdown-header"><?php echo lang('warehouses') ?: 'Entrepôts'; ?></h6></li>
          <li>
            <a class="dropdown-item" href="<?php echo admin_url('products'); ?>">
              <span class="ri-building-line me-2"></span><?php echo lang('all_warehouses') ?: 'Tous'; ?>
            </a>
          </li>
          <?php foreach ($warehouses as $w): ?>
          <li>
            <a class="dropdown-item<?php echo ($warehouse_id == $w->id ? ' active' : ''); ?>" href="<?php echo admin_url('products/' . $w->id); ?>">
              <span class="ri-building-4-line me-2"></span><?php echo $w->name; ?>
            </a>
          </li>
          <?php endforeach; ?>
          <?php endif; ?>
          <li><hr class="dropdown-divider"></li>
          <li>
            <a class="dropdown-item text-danger bpo" href="#"
               title="<b><?php echo lang('delete_products'); ?></b>"
               data-content="<p><?php echo lang('r_u_sure'); ?></p><button type='button' class='btn btn-danger btn-sm' id='delete' data-action='delete'><?php echo lang('i_m_sure'); ?></button> <button class='btn btn-secondary btn-sm bpo-close'><?php echo lang('no'); ?></button>"
               data-html="true" data-placement="left">
              <span class="ri-delete-bin-line me-2"></span><?php echo lang('delete_products') ?: 'Supprimer'; ?>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- DataTable -->
  <div class="card-datatable table-responsive">
    <table id="PRData" class="datatables-products table table-hover" aria-label="<?php echo lang('products'); ?>">
      <thead>
        <tr>
          <th style="width:30px; text-align:center;">
            <input class="form-check-input checkbox checkth" type="checkbox" name="check" />
          </th>
          <th style="display:none;">img</th>
          <th><?php echo lang('code') ?: 'SKU'; ?></th>
          <th><?php echo lang('product') ?: 'Produit'; ?></th>
          <th style="display:none;">brand</th>
          <th><?php echo lang('category') ?: 'Catégorie'; ?></th>
          <?php
          if ($Owner || $Admin) {
              echo '<th class="text-end">' . lang('cost') . '</th>';
              echo '<th class="text-end">' . lang('price') . '</th>';
          } else {
              if ($this->session->userdata('show_cost'))  echo '<th class="text-end">' . lang('cost')  . '</th>';
              if ($this->session->userdata('show_price')) echo '<th class="text-end">' . lang('price') . '</th>';
          }
          ?>
          <th><?php echo lang('stock') ?: 'Stock'; ?></th>
          <th><?php echo lang('unit') ?: 'Unité'; ?></th>
          <?php if ($warehouse_id && $Settings->racks): ?>
          <th><?php echo lang('rack') ?: 'Rack'; ?></th>
          <?php else: ?>
          <th style="display:none;">rack</th>
          <?php endif; ?>
          <th style="display:none;">alert</th>
          <th style="min-width:90px; text-align:center;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td colspan="11" class="text-center dataTables_empty py-5">
            <div class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></div>
            <?php echo lang('loading_data_from_server') ?: 'Chargement...'; ?>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php if ($Owner || ($GP && $GP['bulk_actions'])): ?>
<div style="display:none;">
  <input type="hidden" name="form_action" value="" id="form_action" />
  <?php echo form_submit('performAction', 'performAction', 'id="action-form-submit"'); ?>
</div>
<?php echo form_close(); ?>
<?php endif; ?>

<script>
(function () {
  'use strict';
  var oTable;

  /* ─── Mapping catégorie → icône (style template Pixinvent) ─── */
  var categoryIcons = {
    'electroniques':'ri-smartphone-line', 'electronique':'ri-smartphone-line',
    'menager':'ri-home-6-line', 'ménager':'ri-home-6-line',
    'bureau':'ri-briefcase-line', 'office':'ri-briefcase-line',
    'chaussures':'ri-footprint-line', 'shoes':'ri-footprint-line',
    'accessoires':'ri-headphone-line',
    'jeux':'ri-gamepad-line',
    'toles':'ri-stack-line', 'tôles':'ri-stack-line', 'tôle':'ri-stack-line',
    'tubes':'ri-shape-line', 'tube':'ri-shape-line',
    'fers':'ri-magnet-line', 'fer':'ri-magnet-line'
  };
  var categoryColors = ['primary','success','warning','info','danger','secondary','dark'];
  function colorForCat(name) {
    var idx = 0;
    if (name) { for (var i = 0; i < name.length; i++) idx = (idx + name.charCodeAt(i)) % categoryColors.length; }
    return categoryColors[idx];
  }
  function iconForCat(name) {
    if (!name) return 'ri-price-tag-3-line';
    return categoryIcons[name.toLowerCase()] || 'ri-price-tag-3-line';
  }

  /* ─── Renderer "Produit" : avatar/img + nom + marque ─── */
  function renderProduct(data, type, row) {
    if (type !== 'display') return row[3] || '';
    var img    = row[1] || '';
    var code   = row[2] || '';
    var name   = row[3] || '';
    var brand  = row[4] || '';
    var imgHtml;
    if (img && img !== 'no_image.png') {
      imgHtml = '<img src="<?php echo base_url('assets/uploads/thumbs/'); ?>' + img + '" alt="" class="rounded">';
    } else {
      var initial = (name || code || '?').toString().substring(0, 2).toUpperCase();
      var color   = colorForCat(name);
      imgHtml = '<span class="avatar-initial rounded-2 bg-label-' + color + '">' + initial + '</span>';
    }
    return '<div class="d-flex justify-content-start align-items-center product-name">' +
             '<div class="avatar-wrapper me-3">' +
               '<div class="avatar rounded-2 bg-label-secondary">' + imgHtml + '</div>' +
             '</div>' +
             '<div class="d-flex flex-column">' +
               '<h6 class="text-nowrap mb-0">' + (name || '—') + '</h6>' +
               '<small class="text-muted">' + (brand ? brand + ' · ' : '') + code + '</small>' +
             '</div>' +
           '</div>';
  }

  /* ─── Renderer "Catégorie" : icône colorée + libellé ─── */
  function renderCategory(data) {
    if (!data) return '<span class="text-muted">—</span>';
    var color = colorForCat(data);
    var icon  = iconForCat(data);
    return '<span class="d-flex align-items-center text-heading">' +
             '<span class="w-px-30 h-px-30 rounded-circle d-flex justify-content-center align-items-center bg-label-' + color + ' me-3">' +
               '<i class="ri ' + icon + '" style="font-size:18px"></i>' +
             '</span>' + data +
           '</span>';
  }

  /* ─── Renderer "Stock" : quantité + badge statut ─── */
  function renderStock(data, type, row) {
    var qty = parseFloat(data) || 0;
    var alert = parseFloat(row[<?php echo ($Owner || $Admin) ? '11' : '10'; ?>]) || 0;
    if (type !== 'display') return qty;
    var badge = '';
    if (qty <= 0) {
      badge = '<span class="badge rounded-pill bg-label-danger ms-2"><?php echo lang('out_of_stock') ?: 'rupture'; ?></span>';
    } else if (alert > 0 && qty <= alert) {
      badge = '<span class="badge rounded-pill bg-label-warning ms-2"><?php echo lang('low') ?: 'faible'; ?></span>';
    } else {
      badge = '<span class="badge rounded-pill bg-label-success ms-2"><?php echo lang('ok') ?: 'ok'; ?></span>';
    }
    return '<span class="fw-semibold">' + (typeof formatQuantity === 'function' ? formatQuantity(qty) : qty) + '</span>' + badge;
  }

  /* ─── Renderer "Actions" : icône edit + dropdown 3-dots ─── */
  function renderActions(data, type, row) {
    var id = row[0];
    var img = row[1] || '';
    return '<div class="d-inline-block text-nowrap">' +
             '<a href="<?php echo admin_url('products/edit'); ?>/' + id + '" class="btn btn-icon btn-text-secondary rounded-pill" title="<?php echo lang('edit'); ?>">' +
               '<i class="ri ri-edit-box-line" style="font-size:20px"></i>' +
             '</a>' +
             '<div class="dropdown d-inline-block">' +
               '<button type="button" class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">' +
                 '<i class="ri ri-more-2-line" style="font-size:20px"></i>' +
               '</button>' +
               '<ul class="dropdown-menu dropdown-menu-end">' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('products/view'); ?>/' + id + '"><span class="ri-eye-line me-2"></span><?php echo lang('view'); ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('products/add'); ?>/' + id + '"><span class="ri-file-copy-line me-2"></span><?php echo lang('duplicate_product') ?: 'Dupliquer'; ?></a></li>' +
                 '<li><a class="dropdown-item" href="<?php echo admin_url('products/print_barcodes'); ?>/' + id + '"><span class="ri-barcode-line me-2"></span><?php echo lang('print_barcode_label') ?: 'Code-barres'; ?></a></li>' +
                 (img ? '<li><a class="dropdown-item" href="<?php echo base_url('assets/uploads/'); ?>' + img + '" data-type="image" data-bs-toggle="lightbox"><span class="ri-image-line me-2"></span><?php echo lang('view_image'); ?></a></li>' : '') +
                 '<li><hr class="dropdown-divider"></li>' +
                 '<li><a class="dropdown-item text-danger" href="#" data-id="' + id + '" data-action="row-delete"><span class="ri-delete-bin-line me-2"></span><?php echo lang('delete_product'); ?></a></li>' +
               '</ul>' +
             '</div>' +
           '</div>';
  }

  $(document).ready(function () {
    oTable = $('#PRData').dataTable({
      "aaSorting": [[2, "asc"], [3, "asc"]],
      "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?php echo lang('all'); ?>"]],
      "iDisplayLength": <?php echo $Settings->rows_per_page; ?>,
      "dom": "<'card-body p-0'tr><'dt-foot d-flex flex-wrap justify-content-between align-items-center px-4 py-3 border-top'<'small'i><'pagination-area'p>>",
      "bProcessing": true,
      "bServerSide": true,
      "sAjaxSource": "<?php echo admin_url('products/getProducts' . ($warehouse_id ? '/' . $warehouse_id : '') . ($supplier ? '?supplier=' . $supplier->id : '')); ?>",
      "fnServerData": function (sSource, aoData, fnCallback) {
        aoData.push({"name": "<?php echo $this->security->get_csrf_token_name(); ?>", "value": "<?php echo $this->security->get_csrf_hash(); ?>"});
        $.ajax({ dataType: "json", type: "POST", url: sSource, data: aoData, success: fnCallback });
      },
      "fnRowCallback": function (nRow, aData) {
        nRow.id = aData[0];
        nRow.className = "product_link";
        return nRow;
      },
      "aoColumns": [
        { "bSortable": false, "mRender": typeof checkbox === 'function' ? checkbox : function(d){ return '<input type="checkbox" class="form-check-input checkbox" value="'+d+'">'; } },
        { "bVisible": false }, /* image - hidden, used by renderProduct */
        null,                  /* code */
        { "mRender": renderProduct },
        { "bVisible": false }, /* brand - hidden, used by renderProduct */
        { "mRender": renderCategory },
        <?php
        if ($Owner || $Admin) {
            echo '{"mRender": currencyFormat}, {"mRender": currencyFormat},';
        } else {
            if ($this->session->userdata('show_cost'))  echo '{"mRender": currencyFormat},';
            if ($this->session->userdata('show_price')) echo '{"mRender": currencyFormat},';
        }
        ?>
        { "mRender": renderStock },
        null,                  /* unit */
        <?php if ($warehouse_id && $Settings->racks): ?>
        { "bSortable": true },
        <?php else: ?>
        { "bVisible": false },
        <?php endif; ?>
        { "bVisible": false }, /* alert_quantity - hidden, used by renderStock */
        { "bSortable": false, "mRender": renderActions }
      ]
    }).fnSetFilteringDelay();

    /* ─── Branchement des filtres custom (header dropdowns) ─── */
    var api = oTable.api ? oTable.api() : null;

    $('#filterCategory').on('change', function () {
      var v = $(this).val();
      // colonne 5 = category
      $('#PRData').dataTable().fnFilter(v, 5, false, false, true);
    });
    $('#filterBrand').on('change', function () {
      var v = $(this).val();
      // colonne 4 = brand
      $('#PRData').dataTable().fnFilter(v, 4, false, false, true);
    });
    $('#filterStock').on('change', function () {
      // filtre client-side : géré dans fnRowCallback ou via search custom
      // Note : server-side ne supporte pas le filtre composite ici, on filtre par range stocké
      $('#PRData').DataTable().draw();
    });
    $('#customDtSearch').on('keyup input', function () {
      var v = $(this).val();
      $('#PRData').dataTable().fnFilter(v);
    });
  });
})();
</script>
