<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
// Helper : badge de statut Bootstrap 5
function row_status_mat($x)
{
    if ($x === null || $x === '') {
        return '';
    }
    $map = [
        'pending'     => 'warning',
        'completed'   => 'success',
        'paid'        => 'success',
        'sent'        => 'success',
        'received'    => 'success',
        'partial'     => 'info',
        'transferring'=> 'info',
        'due'         => 'danger',
    ];
    $color = isset($map[$x]) ? $map[$x] : 'secondary';
    return '<span class="badge bg-label-' . $color . '">' . lang($x) . '</span>';
}

// Préparation des données graphique mensuelles
$months      = [];
$msales      = [];
$mtax1       = [];
$mtax2       = [];
$mpurchases  = [];
$mtax3       = [];
$chartHasRealData = false;
if (($Owner || $Admin) && $chatData) {
    foreach ($chatData as $month_sale) {
        $months[]     = date('M Y', strtotime($month_sale->month));
        $msales[]     = (float) $month_sale->sales;
        $mtax1[]      = (float) $month_sale->tax1;
        $mtax2[]      = (float) $month_sale->tax2;
        $mpurchases[] = (float) $month_sale->purchases;
        $mtax3[]      = (float) $month_sale->ptax;
    }
    $chartHasRealData = !empty($months);
}

// Données fictives pour visualisation si aucune donnée réelle ou données insuffisantes (< 4 mois)
if (($Owner || $Admin) && (!$chartHasRealData || count($months) < 4)) {
    $demoMonths = [];
    for ($i = 5; $i >= 0; $i--) {
        $demoMonths[] = date('M Y', strtotime("-{$i} months"));
    }
    $months      = $demoMonths;
    $msales      = [1850000, 2340000, 1920000, 2780000, 3150000, 2640000];
    $mpurchases  = [1200000, 1580000, 1350000, 1890000, 2100000, 1760000];
    $mtax1       = [92500, 117000, 96000, 139000, 157500, 132000];
    $mtax2       = [55500, 70200, 57600, 83400, 94500, 79200];
    $mtax3       = [60000, 79000, 67500, 94500, 105000, 88000];
    $chartHasRealData = false; // flag chart as demo
}
$showChart = ($Owner || $Admin) && !empty($months);

// KPI calculs rapides
$total_sales_amount     = 0;
$total_purchases_amount = 0;
if (!empty($sales)) {
    foreach ($sales as $s) { $total_sales_amount += $s->grand_total; }
}
if (!empty($purchases)) {
    foreach ($purchases as $p) { $total_purchases_amount += $p->grand_total; }
}
$stock_by_price = isset($stock->stock_by_price) ? $stock->stock_by_price : 0;
$stock_by_cost  = isset($stock->stock_by_cost)  ? $stock->stock_by_cost  : 0;
$benefit        = $stock_by_price - $stock_by_cost;
?>

<?php
$_illu_dash  = base_url('themes/materialize/admin/assets/img/illustrations/');
$_firstname  = isset($current_user->first_name) && $current_user->first_name
               ? htmlspecialchars($current_user->first_name)
               : (isset($current_user->username) ? htmlspecialchars($current_user->username) : 'Patron');
$_gender_img = (!empty($current_user->gender) && strtolower($current_user->gender) === 'female')
               ? 'illustration-daisy-light.png' : 'illustration-john-light.png';
$_today_str  = $this->sma->formatMoney($heroStats->today_sales);
$_month_str  = $this->sma->formatMoney($heroStats->month_sales);
?>

<!-- ============================
     HEADER PAGE (style template Pixinvent)
     ============================ -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><?= lang('dashboard') ?></h4>
    <p class="mb-0 text-muted">Vue d'ensemble de votre activité commerciale — <?= date('d M Y') ?></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>"><?= lang('home') ?></a></li>
        <li class="breadcrumb-item active"><?= lang('dashboard') ?></li>
      </ol>
    </nav>
  </div>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <?php if ($Owner || $Admin): ?>
    <a href="<?= admin_url('reports') ?>" class="btn btn-outline-primary">
      <i class="ri ri-bar-chart-2-line me-1" style="font-size:16px"></i><?= lang('reports') ?>
    </a>
    <?php endif; ?>
    <a href="<?= admin_url('sales/add') ?>" class="btn btn-primary">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?= lang('new_sale') ?: 'Nouvelle vente' ?>
    </a>
  </div>
</div>

<!-- ============================
     HERO CARD + RATINGS/SESSIONS (style template Analytics)
     ============================ -->
<div class="row g-6 mb-6">
  <!-- Hero "Congratulations" card -->
  <div class="col-md-12 col-xxl-8">
    <div class="card overflow-hidden">
      <div class="d-flex align-items-end row">
        <div class="col-md-7 order-2 order-md-1">
          <div class="card-body">
            <h4 class="card-title mb-2">Bonjour <span class="fw-bold"><?= $_firstname ?></span> 👋</h4>
            <?php if ($heroStats->today_sales_count > 0): ?>
            <p class="mb-0"><?= $heroStats->today_sales_count ?> vente<?= $heroStats->today_sales_count > 1 ? 's' : '' ?> aujourd'hui — <span class="fw-semibold text-success"><?= $_today_str ?></span></p>
            <p class="mb-3">CA du mois en cours : <span class="fw-bold"><?= $_month_str ?></span></p>
            <?php else: ?>
            <p class="mb-0">Aucune vente aujourd'hui pour le moment.</p>
            <p class="mb-3">CA du mois en cours : <span class="fw-bold"><?= $_month_str ?></span></p>
            <?php endif; ?>
            <?php if ($Owner || $Admin): ?>
            <a href="<?= admin_url('reports') ?>" class="btn btn-primary">
              <i class="ri ri-line-chart-line me-1" style="font-size:16px"></i>Voir les rapports
            </a>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-md-5 text-center text-md-end order-1 order-md-2">
          <div class="card-body pb-0 px-0 pt-2">
            <img src="<?= $_illu_dash . $_gender_img ?>" height="180" class="img-fluid" alt="Hero illustration" />
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Customers + Transactions side cards -->
  <div class="col-md-6 col-xxl-2">
    <div class="card h-100">
      <div class="card-body d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h6 class="mb-1 text-muted">Clients</h6>
            <h3 class="mb-0 fw-bold"><?= number_format($heroStats->customers_count) ?></h3>
          </div>
          <span class="avatar">
            <span class="avatar-initial rounded-3 bg-label-primary">
              <i class="ri ri-group-line" style="font-size:22px"></i>
            </span>
          </span>
        </div>
        <div class="mt-3">
          <span class="badge bg-label-primary rounded-pill"><i class="ri ri-team-line me-1" style="font-size:12px"></i>Total clients</span>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xxl-2">
    <div class="card h-100">
      <div class="card-body d-flex flex-column justify-content-between">
        <div class="d-flex justify-content-between align-items-start">
          <div>
            <h6 class="mb-1 text-muted">Paiements</h6>
            <h3 class="mb-0 fw-bold"><?= number_format($heroStats->transactions) ?></h3>
          </div>
          <span class="avatar">
            <span class="avatar-initial rounded-3 bg-label-success">
              <i class="ri ri-bank-card-line" style="font-size:22px"></i>
            </span>
          </span>
        </div>
        <div class="mt-3">
          <span class="badge bg-label-success rounded-pill"><i class="ri ri-check-double-line me-1" style="font-size:12px"></i>Encaissements</span>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ============================
     KPI STATS CARDS
     ============================ -->
<?php if ($Owner || $Admin):
$_illu = base_url('themes/materialize/admin/assets/img/illustrations/');
?>
<div class="row g-6 mb-6">

    <!-- Ventes -->
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div class="content-left flex-grow-1">
                        <p class="mb-1 text-muted text-sm text-uppercase fw-semibold"><?= lang('sales') ?></p>
                        <h4 class="mb-1 fw-bold"><?= $this->sma->formatMoney($total_sales_amount) ?></h4>
                        <p class="mb-0 small">
                            <span class="badge bg-label-success rounded-pill"><i class="ri ri-shopping-cart-line me-1" style="font-size:12px"></i><?= count($sales) ?> <?= lang('latest_five') ?></span>
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar avatar-lg">
                            <span class="avatar-initial rounded-3 bg-label-success">
                                <i class="ri ri-shopping-cart-2-line" style="font-size:26px"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Achats -->
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div class="content-left flex-grow-1">
                        <p class="mb-1 text-muted text-sm text-uppercase fw-semibold"><?= lang('purchases') ?></p>
                        <h4 class="mb-1 fw-bold"><?= $this->sma->formatMoney($total_purchases_amount) ?></h4>
                        <p class="mb-0 small">
                            <span class="badge bg-label-warning rounded-pill"><i class="ri ri-store-2-line me-1" style="font-size:12px"></i><?= count($purchases) ?> <?= lang('latest_five') ?></span>
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar avatar-lg">
                            <span class="avatar-initial rounded-3 bg-label-warning">
                                <i class="ri ri-store-2-line" style="font-size:26px"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Valeur du stock -->
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div class="content-left flex-grow-1">
                        <p class="mb-1 text-muted text-sm text-uppercase fw-semibold"><?= lang('stock_value_by_price') ?></p>
                        <h4 class="mb-1 fw-bold"><?= $this->sma->formatMoney($stock_by_price) ?></h4>
                        <p class="mb-0 small text-muted">
                            <i class="ri ri-coins-line me-1" style="font-size:12px"></i><?= lang('stock_value_by_cost') ?>: <span class="fw-semibold"><?= $this->sma->formatMoney($stock_by_cost) ?></span>
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar avatar-lg">
                            <span class="avatar-initial rounded-3 bg-label-info">
                                <i class="ri ri-archive-stack-line" style="font-size:26px"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bénéfice potentiel -->
    <div class="col-sm-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start gap-3">
                    <div class="content-left flex-grow-1">
                        <p class="mb-1 text-muted text-sm text-uppercase fw-semibold"><?= lang('profit') ?></p>
                        <div class="d-flex align-items-end gap-2 mb-1">
                            <h4 class="mb-0 fw-bold <?= ($benefit >= 0) ? 'text-success' : 'text-danger' ?>">
                                <?= $this->sma->formatMoney($benefit) ?>
                            </h4>
                            <small class="<?= ($benefit >= 0) ? 'text-success' : 'text-danger' ?>">
                                <i class="ri <?= ($benefit >= 0) ? 'ri-arrow-up-line' : 'ri-arrow-down-line' ?>" style="font-size:14px"></i>
                            </small>
                        </div>
                        <p class="mb-0 small text-muted"><?= lang('price_vs_cost') ?></p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="avatar avatar-lg">
                            <span class="avatar-initial rounded-3 <?= ($benefit >= 0) ? 'bg-label-success' : 'bg-label-danger' ?>">
                                <i class="ri ri-money-dollar-circle-line" style="font-size:26px"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div><!-- /.row KPI -->
<?php endif; ?>

<!-- ============================
     GRAPHIQUE VUE D'ENSEMBLE
     ============================ -->
<?php if ($showChart): ?>
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h5 class="card-title mb-1">
                        <span class="ri-bar-chart-grouped-line me-2"></span><?= lang('overview_chart') ?>
                        <?php if (!$chartHasRealData): ?>
                        <small class="text-muted fw-normal ms-1"><?= lang('demo_data') ?: '(données démo)' ?></small>
                        <?php endif; ?>
                    </h5>
                    <p class="card-subtitle mb-0 text-muted small"><?= lang('overview_chart_heading') ?></p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-label-success"><?= lang('sales') ?></span>
                    <span class="badge bg-label-warning"><?= lang('purchases') ?></span>
                    <span class="badge bg-label-info"><?= lang('sp_tax') ?></span>
                    <span class="badge bg-label-secondary"><?= lang('order_tax') ?></span>
                </div>
            </div>
            <div class="card-body">
                <div id="overviewChart"></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============================
     MEILLEURES VENTES (graphiques)
     ============================ -->
<?php
// Demo best sellers data when real data is empty
$demoBs = [];
if (($Owner || $Admin) && empty($bs)) {
    $demoItems = [
        ['product_name'=>'Tôle noire acier brut','product_code'=>'TNA-001','quantity'=>42],
        ['product_name'=>'Tube carré 40x40','product_code'=>'TC-040','quantity'=>38],
        ['product_name'=>'Fer plat 50x5','product_code'=>'FP-505','quantity'=>31],
        ['product_name'=>'Rond à béton Ø12','product_code'=>'RB-012','quantity'=>27],
        ['product_name'=>'Cornière 40x40x4','product_code'=>'CA-404','quantity'=>19],
    ];
    foreach ($demoItems as $d) {
        $obj = new stdClass();
        $obj->product_name = $d['product_name'];
        $obj->product_code = $d['product_code'];
        $obj->quantity = $d['quantity'];
        $demoBs[] = $obj;
    }
}
$bsData  = !empty($bs)    ? $bs    : $demoBs;
$showBs  = ($Owner || $Admin) && !empty($bsData);
$showLmbs= ($Owner || $Admin) && !empty($lmbs);
?>
<?php if ($showBs || $showLmbs): ?>
<div class="row g-6 mb-6">
    <?php if ($showBs): ?>
    <div class="col-md-<?= $showLmbs ? '6' : '7' ?>">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">
                        <i class="ri ri-trophy-line me-2 text-warning" style="font-size:20px;vertical-align:-0.2em"></i>Meilleures ventes
                    </h5>
                    <p class="card-subtitle mb-0 text-muted small">
                        <?= date('F Y') ?>
                        <?php if (empty($bs)): ?>
                        <span class="badge bg-label-secondary ms-1">données démo</span>
                        <?php endif; ?>
                    </p>
                </div>
                <a href="<?= admin_url('reports/products') ?>" class="btn btn-sm btn-text-secondary rounded-pill" title="<?= lang('reports') ?>">
                    <i class="ri ri-external-link-line" style="font-size:18px"></i>
                </a>
            </div>
            <div class="card-body">
                <div id="bestSellersChart"></div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php if ($showLmbs): ?>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-1">
                    <i class="ri ri-history-line me-2 text-info" style="font-size:20px;vertical-align:-0.2em"></i><?= lang('best_sellers') ?>
                </h5>
                <p class="card-subtitle mb-0 text-muted small"><?= date('F Y', strtotime('-1 month')) ?></p>
            </div>
            <div class="card-body">
                <div id="lastMonthBestSellersChart"></div>
            </div>
        </div>
    </div>
    <?php elseif ($showBs): ?>
    <!-- Pas de mois précédent : remplir avec "Derniers clients" -->
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1">
                        <i class="ri ri-user-star-line me-2 text-primary" style="font-size:20px;vertical-align:-0.2em"></i>Derniers clients
                    </h5>
                    <p class="card-subtitle mb-0 text-muted small">5 plus récents</p>
                </div>
                <?php if ($Owner || $Admin || (!empty($GP['customers-index']))): ?>
                <a href="<?= admin_url('customers') ?>" class="btn btn-sm btn-text-secondary rounded-pill" title="Voir tout">
                    <i class="ri ri-external-link-line" style="font-size:18px"></i>
                </a>
                <?php endif; ?>
            </div>
            <div class="card-body pt-2">
                <?php if (!empty($customers)): ?>
                <ul class="list-unstyled mb-0">
                    <?php
                    $cust_colors = ['primary','success','warning','info','danger','secondary'];
                    $ci = 0;
                    foreach (array_slice($customers, 0, 5) as $c):
                        $cname = $c->company ?: ($c->name ?? '—');
                        $initials = strtoupper(mb_substr($cname, 0, 2));
                        $color = $cust_colors[$ci % count($cust_colors)];
                        $ci++;
                    ?>
                    <li class="d-flex align-items-center mb-4">
                        <span class="avatar avatar-sm me-3 flex-shrink-0">
                            <span class="avatar-initial rounded-circle bg-label-<?= $color ?>"><?= htmlspecialchars($initials) ?></span>
                        </span>
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div class="me-2 overflow-hidden">
                                <h6 class="mb-0 text-truncate" style="max-width:200px;"><?= htmlspecialchars($cname) ?></h6>
                                <small class="text-muted"><?= htmlspecialchars($c->phone ?? ($c->email ?? '')) ?></small>
                            </div>
                            <?php if (!empty($c->id)): ?>
                            <a href="<?= admin_url('customers/view/' . $c->id) ?>" class="btn btn-icon btn-text-secondary rounded-pill" title="<?= lang('view') ?>">
                                <i class="ri ri-eye-line" style="font-size:16px"></i>
                            </a>
                            <?php endif; ?>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php else: ?>
                <div class="text-center text-muted py-5">
                    <i class="ri ri-user-line d-block mx-auto mb-2" style="font-size:36px;opacity:0.4"></i>
                    <?= lang('no_data') ?: 'Aucun client récent' ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php endif; ?>

<!-- ============================
     LIENS RAPIDES — Bento grid Pixinvent
     ============================ -->
<?php
$_quick_links = [
    ['key' => 'products-index',  'url' => 'products',        'lang' => 'products',      'desc' => 'Gérer le catalogue',         'icon' => 'ri-archive-line',          'color' => 'primary'],
    ['key' => 'sales-index',     'url' => 'sales',           'lang' => 'sales',         'desc' => 'Factures et POS',            'icon' => 'ri-shopping-bag-3-line',   'color' => 'success'],
    ['key' => 'quotes-index',    'url' => 'quotes',          'lang' => 'quotes',        'desc' => 'Propositions commerciales',  'icon' => 'ri-file-list-3-line',      'color' => 'info'],
    ['key' => 'purchases-index', 'url' => 'purchases',       'lang' => 'purchases',     'desc' => 'Bons de commande',           'icon' => 'ri-store-2-line',          'color' => 'warning'],
    ['key' => 'transfers-index', 'url' => 'transfers',       'lang' => 'transfers',     'desc' => 'Mouvements entrepôts',       'icon' => 'ri-swap-box-line',         'color' => 'secondary'],
    ['key' => 'customers-index', 'url' => 'customers',       'lang' => 'customers',     'desc' => 'Carnet client',              'icon' => 'ri-group-line',            'color' => 'danger'],
    ['key' => 'suppliers-index', 'url' => 'suppliers',       'lang' => 'suppliers',     'desc' => 'Carnet fournisseur',         'icon' => 'ri-truck-line',            'color' => 'primary'],
    ['key' => '__admin',         'url' => 'notifications',   'lang' => 'notifications', 'desc' => 'Alertes système',            'icon' => 'ri-notification-3-line',   'color' => 'warning'],
    ['key' => '__owner',         'url' => 'auth/users',      'lang' => 'users',         'desc' => 'Équipe et permissions',      'icon' => 'ri-user-settings-line',    'color' => 'info'],
    ['key' => '__owner',         'url' => 'system_settings', 'lang' => 'settings',      'desc' => 'Paramètres système',         'icon' => 'ri-settings-3-line',       'color' => 'secondary'],
];
?>
<div class="row g-6 mb-6">
    <div class="col-12">
        <div class="card quick-actions-card overflow-hidden">
            <div class="card-header d-flex justify-content-between align-items-center pb-3">
                <div>
                    <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                        <span class="quick-actions-title-icon">
                            <i class="ri ri-flashlight-line"></i>
                        </span>
                        Liens rapides
                    </h5>
                    <p class="text-muted small mb-0">Accédez en un clic à vos modules les plus utilisés</p>
                </div>
            </div>
            <div class="card-body pt-3">
                <div class="row g-4 quick-actions-grid">
                    <?php foreach ($_quick_links as $ql):
                        $allowed = false;
                        if ($ql['key'] === '__owner')      $allowed = $Owner;
                        elseif ($ql['key'] === '__admin')  $allowed = ($Owner || $Admin);
                        else                                $allowed = ($Owner || $Admin || (!empty($GP[$ql['key']]) && $GP[$ql['key']]));
                        if (!$allowed) continue;
                    ?>
                    <div class="col-6 col-md-4 col-lg-3 col-xxl-2-4">
                        <a href="<?= admin_url($ql['url']) ?>" class="quick-action-tile quick-action-<?= $ql['color'] ?>">
                            <span class="quick-action-icon">
                                <i class="ri <?= $ql['icon'] ?>"></i>
                            </span>
                            <span class="quick-action-body">
                                <span class="quick-action-title"><?= lang($ql['lang']) ?: ucfirst($ql['lang']) ?></span>
                                <span class="quick-action-desc"><?= $ql['desc'] ?></span>
                            </span>
                            <span class="quick-action-arrow">
                                <i class="ri ri-arrow-right-up-line"></i>
                            </span>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ============================
     DERNIÈRES ACTIVITÉS — Pills tabs + tableau compact Pixinvent
     ============================ -->
<?php
$_safe_count = function ($v) { return is_array($v) ? count($v) : 0; };
$_recent_tabs = [];
if ($Owner || $Admin || !empty($GP['sales-index']))     $_recent_tabs[] = ['id'=>'sales',     'lang'=>'sales',     'icon'=>'ri-shopping-bag-3-line','count'=>$_safe_count($sales ?? null),    'color'=>'success'];
if ($Owner || $Admin || !empty($GP['quotes-index']))    $_recent_tabs[] = ['id'=>'quotes',    'lang'=>'quotes',    'icon'=>'ri-file-list-3-line',  'count'=>$_safe_count($quotes ?? null),   'color'=>'info'];
if ($Owner || $Admin || !empty($GP['purchases-index'])) $_recent_tabs[] = ['id'=>'purchases', 'lang'=>'purchases', 'icon'=>'ri-store-2-line',      'count'=>$_safe_count($purchases ?? null),'color'=>'warning'];
if ($Owner || $Admin || !empty($GP['transfers-index'])) $_recent_tabs[] = ['id'=>'transfers', 'lang'=>'transfers', 'icon'=>'ri-swap-box-line',     'count'=>$_safe_count($transfers ?? null),'color'=>'secondary'];
if ($Owner || $Admin || !empty($GP['customers-index'])) $_recent_tabs[] = ['id'=>'customers', 'lang'=>'customers', 'icon'=>'ri-group-line',        'count'=>$_safe_count($customers ?? null),'color'=>'danger'];
if ($Owner || $Admin || !empty($GP['suppliers-index'])) $_recent_tabs[] = ['id'=>'suppliers', 'lang'=>'suppliers', 'icon'=>'ri-truck-line',        'count'=>$_safe_count($suppliers ?? null),'color'=>'primary'];
?>
<div class="row mb-6">
    <div class="col-12">
        <div class="card recent-activity-card overflow-hidden">
            <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 pb-3">
                <div>
                    <h5 class="card-title mb-1 d-flex align-items-center gap-2">
                        <span class="recent-activity-title-icon">
                            <i class="ri ri-pulse-line"></i>
                        </span>
                        Activité récente
                    </h5>
                    <p class="text-muted small mb-0">Les 5 dernières entrées par module</p>
                </div>
                <ul class="nav nav-pills recent-activity-pills flex-wrap gap-2" role="tablist">
                    <?php foreach ($_recent_tabs as $i => $t): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?= $i === 0 ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#pane-<?= $t['id'] ?>" type="button" role="tab">
                            <i class="ri <?= $t['icon'] ?> me-1"></i>
                            <span><?= lang($t['lang']) ?></span>
                            <span class="badge bg-label-<?= $t['color'] ?> rounded-pill ms-1"><?= $t['count'] ?></span>
                        </button>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="card-body p-0">
                <div class="tab-content pt-0">

                    <!-- VENTES -->
                    <?php if ($Owner || $Admin || $GP['sales-index']): ?>
                    <div class="tab-pane fade show active" id="pane-sales" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('reference_no') ?></th>
                                        <th><?= lang('customer') ?></th>
                                        <th><?= lang('date') ?></th>
                                        <th class="text-center"><?= lang('status') ?></th>
                                        <th class="text-center"><?= lang('payment_status') ?></th>
                                        <th class="text-end pe-4"><?= lang('total') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($sales)): foreach ($sales as $order): ?>
                                    <tr class="<?= $order->pos ? 'receipt_link' : 'invoice_link' ?> cursor-pointer recent-row" id="<?= $order->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-row-icon bg-label-success"><i class="ri ri-shopping-bag-3-line"></i></span>
                                                <span class="fw-semibold text-primary"><?= $order->reference_no ?></span>
                                            </span>
                                        </td>
                                        <td><span class="fw-medium"><?= $order->customer ?></span></td>
                                        <td class="text-muted small"><?= $this->sma->hrld($order->date) ?></td>
                                        <td class="text-center"><?= row_status_mat($order->sale_status) ?></td>
                                        <td class="text-center"><?= row_status_mat($order->payment_status) ?></td>
                                        <td class="text-end pe-4 fw-bold"><?= $this->sma->formatMoney($order->grand_total) ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="6" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('sales') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- DEVIS -->
                    <?php if ($Owner || $Admin || $GP['quotes-index']): ?>
                    <div class="tab-pane fade" id="pane-quotes" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('reference_no') ?></th>
                                        <th><?= lang('customer') ?></th>
                                        <th><?= lang('date') ?></th>
                                        <th class="text-center"><?= lang('status') ?></th>
                                        <th class="text-end pe-4"><?= lang('amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($quotes)): foreach ($quotes as $quote): ?>
                                    <tr class="quote_link cursor-pointer recent-row" id="<?= $quote->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-row-icon bg-label-info"><i class="ri ri-file-list-3-line"></i></span>
                                                <span class="fw-semibold text-primary"><?= $quote->reference_no ?></span>
                                            </span>
                                        </td>
                                        <td class="fw-medium"><?= $quote->customer ?></td>
                                        <td class="text-muted small"><?= $this->sma->hrld($quote->date) ?></td>
                                        <td class="text-center"><?= row_status_mat($quote->status) ?></td>
                                        <td class="text-end pe-4 fw-bold"><?= $this->sma->formatMoney($quote->grand_total) ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('quotes') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- ACHATS -->
                    <?php if ($Owner || $Admin || $GP['purchases-index']): ?>
                    <div class="tab-pane fade" id="pane-purchases" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('reference_no') ?></th>
                                        <th><?= lang('supplier') ?></th>
                                        <th><?= lang('date') ?></th>
                                        <th class="text-center"><?= lang('status') ?></th>
                                        <th class="text-end pe-4"><?= lang('amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($purchases)): foreach ($purchases as $purchase): ?>
                                    <tr class="purchase_link cursor-pointer recent-row" id="<?= $purchase->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-row-icon bg-label-warning"><i class="ri ri-store-2-line"></i></span>
                                                <span class="fw-semibold text-primary"><?= $purchase->reference_no ?></span>
                                            </span>
                                        </td>
                                        <td class="fw-medium"><?= $purchase->supplier ?></td>
                                        <td class="text-muted small"><?= $this->sma->hrld($purchase->date) ?></td>
                                        <td class="text-center"><?= row_status_mat($purchase->status) ?></td>
                                        <td class="text-end pe-4 fw-bold"><?= $this->sma->formatMoney($purchase->grand_total) ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('purchases') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- TRANSFERTS -->
                    <?php if ($Owner || $Admin || $GP['transfers-index']): ?>
                    <div class="tab-pane fade" id="pane-transfers" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('reference_no') ?></th>
                                        <th><?= lang('from') ?> → <?= lang('to') ?></th>
                                        <th><?= lang('date') ?></th>
                                        <th class="text-center"><?= lang('status') ?></th>
                                        <th class="text-end pe-4"><?= lang('amount') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($transfers)): foreach ($transfers as $transfer): ?>
                                    <tr class="transfer_link cursor-pointer recent-row" id="<?= $transfer->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-row-icon bg-label-secondary"><i class="ri ri-swap-box-line"></i></span>
                                                <span class="fw-semibold text-primary"><?= $transfer->transfer_no ?></span>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="d-inline-flex align-items-center gap-1">
                                                <span class="badge bg-label-primary"><?= $transfer->from_warehouse_name ?></span>
                                                <i class="ri ri-arrow-right-line text-muted"></i>
                                                <span class="badge bg-label-info"><?= $transfer->to_warehouse_name ?></span>
                                            </span>
                                        </td>
                                        <td class="text-muted small"><?= $this->sma->hrld($transfer->date) ?></td>
                                        <td class="text-center"><?= row_status_mat($transfer->status) ?></td>
                                        <td class="text-end pe-4 fw-bold"><?= $this->sma->formatMoney($transfer->grand_total) ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('transfers') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- CLIENTS -->
                    <?php if ($Owner || $Admin || $GP['customers-index']): ?>
                    <div class="tab-pane fade" id="pane-customers" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('name') ?></th>
                                        <th><?= lang('company') ?></th>
                                        <th><?= lang('email') ?></th>
                                        <th><?= lang('phone') ?></th>
                                        <th><?= lang('city') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($customers)): foreach ($customers as $customer):
                                    $initial = strtoupper(mb_substr(trim($customer->name ?: '?'), 0, 1));
                                ?>
                                    <tr class="customer_link cursor-pointer recent-row" id="<?= $customer->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-avatar bg-label-danger"><?= $initial ?></span>
                                                <span class="fw-semibold"><?= $customer->name ?></span>
                                            </span>
                                        </td>
                                        <td class="fw-medium"><?= $customer->company ?: '<span class="text-muted small">—</span>' ?></td>
                                        <td class="text-muted small"><?= $customer->email ?></td>
                                        <td class="text-muted small"><?= $customer->phone ?></td>
                                        <td class="text-muted small"><?= $customer->city ?? '' ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('customers') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- FOURNISSEURS -->
                    <?php if ($Owner || $Admin || $GP['suppliers-index']): ?>
                    <div class="tab-pane fade" id="pane-suppliers" role="tabpanel">
                        <div class="table-responsive recent-table">
                            <table class="table table-borderless align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4"><?= lang('name') ?></th>
                                        <th><?= lang('company') ?></th>
                                        <th><?= lang('email') ?></th>
                                        <th><?= lang('phone') ?></th>
                                        <th><?= lang('city') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($suppliers)): foreach ($suppliers as $supplier):
                                    $initial = strtoupper(mb_substr(trim($supplier->name ?: '?'), 0, 1));
                                ?>
                                    <tr class="supplier_link cursor-pointer recent-row" id="<?= $supplier->id ?>">
                                        <td class="ps-4">
                                            <span class="d-inline-flex align-items-center gap-2">
                                                <span class="recent-avatar bg-label-primary"><?= $initial ?></span>
                                                <span class="fw-semibold"><?= $supplier->name ?></span>
                                            </span>
                                        </td>
                                        <td class="fw-medium"><?= $supplier->company ?: '<span class="text-muted small">—</span>' ?></td>
                                        <td class="text-muted small"><?= $supplier->email ?></td>
                                        <td class="text-muted small"><?= $supplier->phone ?></td>
                                        <td class="text-muted small"><?= $supplier->city ?? '' ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                    <tr><td colspan="5" class="text-center text-muted py-5">
                                        <i class="ri ri-inbox-2-line d-block mb-2" style="font-size:32px;opacity:.4"></i>
                                        <?= lang('no_data_available') ?>
                                    </td></tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer d-flex justify-content-end border-top-0 py-3">
                            <a href="<?= admin_url('suppliers') ?>" class="btn btn-sm btn-primary rounded-pill px-3">
                                Voir tout <i class="ri ri-arrow-right-line ms-1"></i>
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>

                </div><!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div><!-- /.card -->
    </div>
</div>


<!-- Quick Actions & Recent Activity styles now in sma-custom.css -->

<!-- ============================
     SCRIPTS : NAVIGATION CLICK + APEXCHARTS
     ============================ -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ---- Liens cliquables sur les lignes de tableau ---- */
    document.querySelectorAll('.invoice_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>sales/view/' + this.id;
        });
    });
    document.querySelectorAll('.receipt_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>sales/pos_view/' + this.id;
        });
    });
    document.querySelectorAll('.quote_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>quotes/view/' + this.id;
        });
    });
    document.querySelectorAll('.purchase_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>purchases/view/' + this.id;
        });
    });
    document.querySelectorAll('.transfer_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>transfers/view/' + this.id;
        });
    });
    document.querySelectorAll('.customer_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>customers/view/' + this.id;
        });
    });
    document.querySelectorAll('.supplier_link').forEach(function (row) {
        row.addEventListener('click', function () {
            window.location.href = '<?= admin_url() ?>suppliers/view/' + this.id;
        });
    });

    <?php if ($showChart): ?>
    /* ---- Graphique aperçu mensuel (ApexCharts) ---- */
    var isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
    var primaryColor  = '#0b91c5';
    var warningColor  = '#fd9e28';
    var infoColor     = '#03c3ec';
    var secondaryColor= '#8592a3';

    var overviewOptions = {
        series: [
            {
                name: '<?= lang('sales') ?>',
                type: 'column',
                data: <?= json_encode($msales) ?>
            },
            {
                name: '<?= lang('purchases') ?>',
                type: 'line',
                data: <?= json_encode($mpurchases) ?>
            },
            {
                name: '<?= lang('sp_tax') ?>',
                type: 'column',
                data: <?= json_encode($mtax1) ?>
            },
            {
                name: '<?= lang('order_tax') ?>',
                type: 'column',
                data: <?= json_encode($mtax2) ?>
            }
        ],
        chart: {
            height: 380,
            type: 'line',
            toolbar: { show: true },
            zoom: { enabled: false }
        },
        stroke: {
            width: [0, 3, 0, 0],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%',
                borderRadius: 4
            }
        },
        colors: [primaryColor, warningColor, infoColor, secondaryColor],
        xaxis: {
            categories: <?= json_encode($months) ?>,
            labels: {
                rotate: -45,
                style: { fontSize: '12px' }
            }
        },
        yaxis: {
            labels: {
                formatter: function (val) {
                    return val.toLocaleString();
                }
            }
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (val) {
                    return val.toLocaleString('<?= str_replace('_', '-', $Settings->default_language ?? 'fr') ?>');
                }
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right'
        },
        grid: {
            borderColor: isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.07)'
        }
    };
    var overviewChart = new ApexCharts(document.querySelector('#overviewChart'), overviewOptions);
    overviewChart.render();
    <?php endif; ?>

    <?php if ($showBs): ?>
    /* ---- Meilleurs vendeurs ce mois ---- */
    var bsLabels = [];
    var bsValues = [];
    <?php foreach ($bsData as $r):
        if ($r->quantity > 0): ?>
    bsLabels.push('<?= addslashes($r->product_name) ?> (<?= $r->product_code ?>)');
    bsValues.push(<?= (float) $r->quantity ?>);
    <?php endif; endforeach; ?>

    if (bsLabels.length > 0) {
        var bsOptions = {
            series: [{ name: '<?= lang('sold') ?>', data: bsValues }],
            chart: { type: 'bar', height: 350, toolbar: { show: false } },
            plotOptions: {
                bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } }
            },
            dataLabels: { enabled: true, offsetX: 14, style: { fontSize: '12px' } },
            xaxis: { categories: bsLabels },
            colors: ['#0b91c5'],
            grid: { borderColor: 'rgba(0,0,0,0.07)' }
        };
        var bsChart = new ApexCharts(document.querySelector('#bestSellersChart'), bsOptions);
        bsChart.render();
    }
    <?php endif; ?>

    <?php if (($Owner || $Admin) && !empty($lmbs)): ?>
    /* ---- Meilleurs vendeurs mois précédent ---- */
    var lmbsLabels = [];
    var lmbsData   = [];
    <?php foreach ($lmbs as $r):
        if ($r->quantity > 0): ?>
    lmbsLabels.push('<?= addslashes($r->product_name) ?> (<?= $r->product_code ?>)');
    lmbsData.push(<?= (float) $r->quantity ?>);
    <?php endif; endforeach; ?>

    if (lmbsLabels.length > 0) {
        var lmbsOptions = {
            series: [{ name: '<?= lang('sold') ?>', data: lmbsData }],
            chart: { type: 'bar', height: 350, toolbar: { show: false } },
            plotOptions: {
                bar: { horizontal: true, borderRadius: 4, dataLabels: { position: 'top' } }
            },
            dataLabels: { enabled: true, offsetX: 14, style: { fontSize: '12px' } },
            xaxis: { categories: lmbsLabels },
            colors: ['#fd9e28'],
            grid: { borderColor: 'rgba(0,0,0,0.07)' }
        };
        var lmbsChart = new ApexCharts(document.querySelector('#lastMonthBestSellersChart'), lmbsOptions);
        lmbsChart.render();
    }
    <?php endif; ?>

});
</script>
