<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-team-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('customer_users') ?: 'Utilisateurs du client'; ?></h4>
    <p class="mb-0 text-muted">Client : <span class="text-primary fw-semibold"><?php echo htmlspecialchars($customer->name); ?></span></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers'); ?>"><?php echo lang('customers') ?: 'Clients'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('customers/view/' . $customer->id); ?>"><?php echo htmlspecialchars($customer->name); ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('users') ?: 'Utilisateurs'; ?></li>
      </ol>
    </nav>
  </div>
  <?php if ($Owner || $Admin): ?>
  <div class="d-flex align-content-center flex-wrap gap-2">
    <a href="<?php echo admin_url('customers/add_user/' . $customer->id); ?>" class="btn btn-primary sa-modal">
      <i class="ri ri-user-add-line me-1" style="font-size:16px"></i><?php echo lang('add_user') ?: 'Ajouter utilisateur'; ?>
    </a>
  </div>
  <?php endif; ?>
</div>

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover mb-0">
      <thead class="table-light">
        <tr>
          <th><?php echo lang('name') ?: 'Nom'; ?></th>
          <th><?php echo lang('email') ?: 'Email'; ?></th>
          <th><?php echo lang('phone') ?: 'Téléphone'; ?></th>
          <th class="text-center" style="width:100px;"><?php echo lang('status') ?: 'Statut'; ?></th>
          <th class="text-center" style="width:100px;"><?php echo lang('actions') ?: 'Actions'; ?></th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)): foreach ($users as $user): ?>
        <tr>
          <td class="align-middle">
            <?php if (!empty($user->avatar)): ?>
              <img src="<?php echo base_url('assets/uploads/avatars/' . $user->avatar); ?>"
                   class="rounded-circle me-2" width="32" height="32" alt="" />
            <?php endif; ?>
            <?php echo htmlspecialchars($user->first_name . ' ' . $user->last_name); ?>
          </td>
          <td class="align-middle"><?php echo htmlspecialchars($user->email); ?></td>
          <td class="align-middle"><?php echo htmlspecialchars($user->phone ?? ''); ?></td>
          <td class="text-center align-middle">
            <?php if ($user->active): ?>
              <span class="badge bg-label-success"><?php echo lang('active') ?: 'Actif'; ?></span>
            <?php else: ?>
              <span class="badge bg-label-danger"><?php echo lang('inactive') ?: 'Inactif'; ?></span>
            <?php endif; ?>
          </td>
          <td class="text-center align-middle">
            <div class="d-flex justify-content-center gap-1">
              <?php if ($Owner || $Admin): ?>
                <a href="<?php echo admin_url('auth/edit_user/' . $user->id); ?>"
                   class="btn btn-sm btn-icon btn-outline-warning sa-modal" title="<?php echo lang('edit'); ?>">
                  <span class="icon-base ri ri-edit-line icon-14px"></span>
                </a>
                <a href="<?php echo admin_url('auth/deactivate_user/' . $user->id); ?>"
                   class="btn btn-sm btn-icon btn-outline-secondary sa-modal" title="<?php echo $user->active ? lang('deactivate') : lang('activate'); ?>">
                  <span class="icon-base ri ri-<?php echo $user->active ? 'user-unfollow' : 'user-follow'; ?>-line icon-14px"></span>
                </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
          <td colspan="5" class="text-center py-4 text-muted">
            <span class="icon-base ri ri-team-line me-2 icon-20px"></span>
            <?php echo lang('no_users') ?: 'Aucun utilisateur'; ?>
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
