<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-mail-settings-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?php echo lang('email_templates') ?: 'Modèles d\'email'; ?></h4>
    <p class="mb-0 text-muted">Personnalisez les emails transactionnels envoyés par l'application</p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?php echo admin_url(); ?>"><?php echo lang('home') ?: 'Accueil'; ?></a></li>
        <li class="breadcrumb-item"><a href="<?php echo admin_url('system_settings'); ?>"><?php echo lang('settings') ?: 'Paramètres'; ?></a></li>
        <li class="breadcrumb-item active"><?php echo lang('email_templates') ?: 'Modèles d\'email'; ?></li>
      </ol>
    </nav>
  </div>
</div>

<div class="row">
  <div class="col-md-3">
    <!-- Tab nav -->
    <div class="card">
      <div class="card-header">
        <h6 class="card-title mb-0"><?php echo lang('templates') ?: 'Modèles'; ?></h6>
      </div>
      <div class="list-group list-group-flush" id="emailTemplateTabs" role="tablist">
        <a class="list-group-item list-group-item-action active" data-bs-toggle="tab" href="#tab-credentials" role="tab">
          <span class="icon-base ri ri-user-add-line me-2 icon-16px"></span>
          <?php echo lang('new_user') ?: 'Nouvel utilisateur'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-activate" role="tab">
          <span class="icon-base ri ri-mail-check-line me-2 icon-16px"></span>
          <?php echo lang('activate_email') ?: 'Activation email'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-forgot" role="tab">
          <span class="icon-base ri ri-lock-unlock-line me-2 icon-16px"></span>
          <?php echo lang('forgot_password') ?: 'Mot de passe oublié'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-sale" role="tab">
          <span class="icon-base ri ri-shopping-cart-line me-2 icon-16px"></span>
          <?php echo lang('sale') ?: 'Vente'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-quote" role="tab">
          <span class="icon-base ri ri-file-list-3-line me-2 icon-16px"></span>
          <?php echo lang('quote') ?: 'Devis'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-purchase" role="tab">
          <span class="icon-base ri ri-shopping-bag-line me-2 icon-16px"></span>
          <?php echo lang('purchase') ?: 'Achat'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-transfer" role="tab">
          <span class="icon-base ri ri-swap-box-line me-2 icon-16px"></span>
          <?php echo lang('transfer') ?: 'Transfert'; ?>
        </a>
        <a class="list-group-item list-group-item-action" data-bs-toggle="tab" href="#tab-payment" role="tab">
          <span class="icon-base ri ri-bank-card-line me-2 icon-16px"></span>
          <?php echo lang('payment') ?: 'Paiement'; ?>
        </a>
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <div class="tab-content">

      <?php
      $templates = [
        ['id' => 'tab-credentials',  'action' => 'system_settings/email_templates',           'var' => $credentials ?? '',   'label' => lang('new_user') ?: 'Nouvel utilisateur'],
        ['id' => 'tab-activate',     'action' => 'system_settings/email_templates/activate_email', 'var' => $activate_email ?? '', 'label' => lang('activate_email') ?: 'Activation email'],
        ['id' => 'tab-forgot',       'action' => 'system_settings/email_templates/forgot_password', 'var' => $forgot_password ?? '', 'label' => lang('forgot_password') ?: 'Mot de passe oublié'],
        ['id' => 'tab-sale',         'action' => 'system_settings/email_templates/sale',       'var' => $sale ?? '',          'label' => lang('sale') ?: 'Vente'],
        ['id' => 'tab-quote',        'action' => 'system_settings/email_templates/quote',      'var' => $quote ?? '',         'label' => lang('quote') ?: 'Devis'],
        ['id' => 'tab-purchase',     'action' => 'system_settings/email_templates/purchase',   'var' => $purchase ?? '',      'label' => lang('purchase') ?: 'Achat'],
        ['id' => 'tab-transfer',     'action' => 'system_settings/email_templates/transfer',   'var' => $transfer ?? '',      'label' => lang('transfer') ?: 'Transfert'],
        ['id' => 'tab-payment',      'action' => 'system_settings/email_templates/payment',    'var' => $payment ?? '',       'label' => lang('payment') ?: 'Paiement'],
      ];
      foreach ($templates as $i => $tpl):
      ?>
      <div class="tab-pane fade <?php echo $i === 0 ? 'show active' : ''; ?>" id="<?php echo $tpl['id']; ?>" role="tabpanel">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0"><?php echo $tpl['label']; ?></h5>
          </div>
          <div class="card-body">
            <?php echo admin_form_open($tpl['action'], ['id' => 'form-' . $tpl['id']]); ?>
            <div class="mb-4">
              <label class="form-label"><?php echo lang('email_body') ?: 'Corps de l\'email'; ?></label>
              <?php echo form_textarea('mail_body', html_entity_decode(isset($_POST['mail_body']) ? $_POST['mail_body'] : $tpl['var']),
                'class="form-control" id="tpl-' . $tpl['id'] . '" rows="12" style="font-family:monospace;"'); ?>
              <small class="text-muted"><?php echo lang('email_template_hint') ?: 'Utilisez les variables {{nom}}, {{email}}, etc.'; ?></small>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">
              <span class="icon-base ri ri-save-line me-1 icon-16px"></span>
              <?php echo lang('save') ?: 'Enregistrer'; ?>
            </button>
            <?php echo form_close(); ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
</div>
