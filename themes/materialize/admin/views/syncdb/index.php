<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-database-2-line me-2" style="font-size:24px;vertical-align:-0.2em"></i>Synchronisation BDD</h4>
    <p class="mb-0 text-muted">Synchronisez la structure de la base de données</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item active">Sync Base de données</li>
      </ol>
    </nav>
  </div>
</div>

<div class="alert alert-warning d-flex align-items-start gap-2 mb-4" role="alert">
  <span class="icon-base ri ri-alert-line icon-20px mt-1"></span>
  <div>
    <strong>Attention :</strong> Utilisez ces actions pour synchroniser votre ancienne base de données avec la nouvelle version.
    Effectuez les actions <strong>une par une</strong>, en commençant par la première.
    Une fois terminé, visitez votre nouveau tableau de bord.
  </div>
</div>

<!-- Update section -->
<div class="card mb-4">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-refresh-line me-2 text-primary icon-18px"></span>
      Mise à jour des tables
    </h5>
  </div>
  <div class="card-body">
    <p class="text-muted mb-4">
      Pour conserver vos anciennes ventes, devis, achats et transferts, mettez à jour les enregistrements en cliquant sur les boutons ci-dessous.
    </p>
    <?php if ($Settings->version == '3.0'): ?>
    <div class="alert alert-danger small mb-3" role="alert">
      <span class="icon-base ri ri-information-line me-1 icon-16px"></span>
      Si vous avez ajouté de nouveaux enregistrements, ils seront également mis à jour.
    </div>
    <?php endif; ?>

    <div class="row g-3" id="update-actions">

      <?php
      $update_actions = [
        'update_sales'      => ['label' => 'Mettre à jour Ventes',    'icon' => 'ri-shopping-cart-line',  'key' => 'update_sales'],
        'update_quotes'     => ['label' => 'Mettre à jour Devis',     'icon' => 'ri-file-list-3-line',    'key' => 'update_quotes'],
        'update_purchases'  => ['label' => 'Mettre à jour Achats',    'icon' => 'ri-shopping-bag-line',   'key' => 'update_purchases'],
        'update_transfers'  => ['label' => 'Mettre à jour Transferts','icon' => 'ri-exchange-line',       'key' => 'update_transfers'],
      ];
      foreach ($update_actions as $id => $action): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card border shadow-none h-100">
          <div class="card-body text-center">
            <span class="icon-base ri <?php echo $action['icon']; ?> icon-24px text-primary mb-2 d-block"></span>
            <p class="fw-semibold mb-3"><?php echo $action['label']; ?></p>
            <button class="btn btn-primary btn-sm sync-btn w-100" data-action="<?php echo admin_url('sync/' . $id); ?>" id="<?php echo $id; ?>">
              <span class="icon-base ri ri-play-line me-1 icon-16px"></span>
              Exécuter
            </button>
            <div class="sync-result mt-2 text-muted small" style="display:none;"></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>

<!-- Reset section -->
<div class="card mb-4">
  <div class="card-header border-bottom">
    <h5 class="card-title mb-0">
      <span class="icon-base ri ri-delete-bin-line me-2 text-danger icon-18px"></span>
      Réinitialisation des tables
    </h5>
  </div>
  <div class="card-body">
    <p class="text-muted mb-4">
      Vous pouvez supprimer les anciennes données de ces tables si vous le souhaitez.
      <strong class="text-danger">Cette action est irréversible.</strong>
    </p>

    <div class="row g-3" id="reset-actions">

      <?php
      $reset_actions = [
        'reset_sales'           => ['label' => 'Réinitialiser Ventes',          'icon' => 'ri-shopping-cart-line',    'confirm' => 'Supprimer toutes les ventes et réinitialiser la table ?'],
        'reset_quotes'          => ['label' => 'Réinitialiser Devis',            'icon' => 'ri-file-list-3-line',      'confirm' => 'Supprimer tous les devis et réinitialiser la table ?'],
        'reset_purchases'       => ['label' => 'Réinitialiser Achats',           'icon' => 'ri-shopping-bag-line',     'confirm' => 'Supprimer tous les achats et réinitialiser la table ?'],
        'reset_transfers'       => ['label' => 'Réinitialiser Transferts',       'icon' => 'ri-exchange-line',         'confirm' => 'Supprimer tous les transferts et réinitialiser la table ?'],
        'reset_deliveries'      => ['label' => 'Réinitialiser Livraisons',       'icon' => 'ri-truck-line',            'confirm' => 'Supprimer toutes les livraisons et réinitialiser la table ?'],
        'reset_products'        => ['label' => 'Réinitialiser Produits',         'icon' => 'ri-box-line',              'confirm' => 'Supprimer tous les produits et réinitialiser la table ?'],
        'reset_damage_products' => ['label' => 'Réinitialiser Produits endommagés','icon' => 'ri-error-warning-line', 'confirm' => 'Supprimer tous les produits endommagés et réinitialiser la table ?'],
      ];
      foreach ($reset_actions as $id => $action): ?>
      <div class="col-md-6 col-lg-3">
        <div class="card border border-danger-subtle shadow-none h-100">
          <div class="card-body text-center">
            <span class="icon-base ri <?php echo $action['icon']; ?> icon-24px text-danger mb-2 d-block"></span>
            <p class="fw-semibold mb-3"><?php echo $action['label']; ?></p>
            <button class="btn btn-danger btn-sm sync-btn-confirm w-100"
                    data-action="<?php echo admin_url('sync/' . $id); ?>"
                    data-confirm="<?php echo htmlspecialchars($action['confirm']); ?>"
                    id="<?php echo $id; ?>">
              <span class="icon-base ri ri-delete-bin-line me-1 icon-16px"></span>
              Réinitialiser
            </button>
            <div class="sync-result mt-2 text-muted small" style="display:none;"></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>

<script>
(function () {
  'use strict';

  function runSync(btn, url) {
    var resultEl = btn.closest('.card-body').querySelector('.sync-result');
    if (!resultEl) {
      resultEl = btn.parentElement.querySelector('.sync-result');
    }
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> En cours...';
    if (resultEl) { resultEl.style.display = 'none'; resultEl.textContent = ''; }

    fetch(url, { method: 'GET', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
      .then(function (r) { return r.text(); })
      .then(function (msg) {
        btn.disabled = false;
        btn.innerHTML = '<span class="icon-base ri ri-check-line me-1 icon-16px"></span> Terminé';
        btn.classList.remove('btn-primary', 'btn-danger');
        btn.classList.add('btn-success');
        if (resultEl) { resultEl.textContent = msg; resultEl.style.display = 'block'; }
      })
      .catch(function () {
        btn.disabled = false;
        btn.innerHTML = '<span class="icon-base ri ri-close-line me-1 icon-16px"></span> Erreur';
        btn.classList.remove('btn-primary', 'btn-danger');
        btn.classList.add('btn-warning');
        if (resultEl) { resultEl.textContent = 'La requête a échoué.'; resultEl.style.display = 'block'; }
      });
  }

  // Update buttons — no confirmation needed
  document.querySelectorAll('.sync-btn').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      runSync(btn, btn.dataset.action);
    });
  });

  // Reset buttons — SweetAlert2 confirmation
  document.querySelectorAll('.sync-btn-confirm').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var url     = btn.dataset.action;
      var message = btn.dataset.confirm || 'Confirmer cette action ?';

      Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: message,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Oui, réinitialiser',
        cancelButtonText: 'Annuler'
      }).then(function (result) {
        if (result.isConfirmed) {
          runSync(btn, url);
        }
      });
    });
  });

})();
</script>
