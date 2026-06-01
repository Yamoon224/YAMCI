<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-map-pin-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('addresses') ?: 'Adresses'; ?></h4>
    <p class="mb-0 text-muted">Client : <span class="text-primary fw-semibold"><?php echo htmlspecialchars($customer->name); ?></span></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers'); ?>"><?php echo lang('customers') ?: 'Clients'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers/view/' . $customer->id); ?>"><?php echo htmlspecialchars($customer->name); ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('addresses') ?: 'Adresses'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin || !empty($GP['addresses']['add'])): ?>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('customers/add_address/' . $customer->id); ?>"
       class="btn btn-primary"
       data-bs-toggle="modal" data-bs-target="#myModal">
      <i class="ri ri-add-line me-1" style="font-size:16px"></i><?php echo lang('add_address') ?: 'Ajouter une adresse'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="card-datatable table-responsive">
    <table class="table table-hover border-top" id="AdrData">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('type') ?: 'Type'; ?></th>
          <th><?php echo lang('address') ?: 'Adresse'; ?></th>
          <th><?php echo lang('city') ?: 'Ville'; ?></th>
          <th><?php echo lang('state') ?: 'État / Région'; ?></th>
          <th><?php echo lang('country') ?: 'Pays'; ?></th>
          <th style="width:100px;" class="text-center"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($addresses)): ?>
          <?php foreach ($addresses as $address): ?>
          <tr>
            <td>
              <?php
              $type = $address->type ?? '';
              if ($type === 'billing'): ?>
                <span class="badge bg-label-info">
                  <span class="icon-base ri ri-bill-line me-1 icon-14px"></span>
                  <?php echo lang('billing') ?: 'Facturation'; ?>
                </span>
              <?php elseif ($type === 'shipping'): ?>
                <span class="badge bg-label-success">
                  <span class="icon-base ri ri-truck-line me-1 icon-14px"></span>
                  <?php echo lang('shipping') ?: 'Livraison'; ?>
                </span>
              <?php else: ?>
                <span class="badge bg-label-secondary"><?php echo htmlspecialchars($type); ?></span>
              <?php endif; ?>
            </td>
            <td>
              <?php echo htmlspecialchars($address->line1 ?? ''); ?>
              <?php if (!empty($address->line2)): ?>
                <br><small class="text-muted"><?php echo htmlspecialchars($address->line2); ?></small>
              <?php endif; ?>
              <?php if (!empty($address->postal_code)): ?>
                <br><small class="text-muted"><?php echo htmlspecialchars($address->postal_code); ?></small>
              <?php endif; ?>
            </td>
            <td><?php echo htmlspecialchars($address->city ?? ''); ?></td>
            <td><?php echo htmlspecialchars($address->state ?? ''); ?></td>
            <td><?php echo htmlspecialchars($address->country ?? ''); ?></td>
            <td class="text-center">
              <?php if ($Owner || $Admin || !empty($GP['addresses']['edit'])): ?>
              <a href="<?php echo admin_url('customers/edit_address/' . $address->id); ?>"
                 class="btn btn-sm btn-icon btn-outline-primary me-1"
                 data-bs-toggle="modal" data-bs-target="#myModal"
                 title="<?php echo lang('edit_address') ?: 'Modifier'; ?>">
                <span class="icon-base ri ri-edit-line icon-16px"></span>
              </a>
              <?php endif; ?>
              <?php if ($Owner || $Admin || !empty($GP['addresses']['delete'])): ?>
              <a href="<?php echo admin_url('customers/delete_address/' . $address->id); ?>"
                 class="btn btn-sm btn-icon btn-outline-danger"
                 title="<?php echo lang('delete_address') ?: 'Supprimer'; ?>"
                 onclick="return confirm('<?php echo addslashes(lang('r_u_sure') ?: 'Êtes-vous sûr ?'); ?>')">
                <span class="icon-base ri ri-delete-bin-line icon-16px"></span>
              </a>
              <?php endif; ?>
            </td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="6" class="text-center py-5 text-muted">
              <span class="icon-base ri ri-map-pin-2-line me-2 icon-24px d-block mb-2"></span>
              <?php echo lang('no_records_found') ?: 'Aucune adresse enregistrée.'; ?>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
$(document).ready(function () {
  $('#AdrData').DataTable({
    order: [[0, 'asc']],
    pageLength: <?php echo (int)$Settings->rows_per_page; ?>,
    lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, '<?php echo lang('all') ?: 'Tout'; ?>']],
    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>'
  });

  $('#myModal').on('hidden.bs.modal', function () {
    location.reload();
  });
});
</script>
