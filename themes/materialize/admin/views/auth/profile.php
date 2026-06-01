<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<!-- HEADER style template Pixinvent -->
<div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
  <div class="d-flex flex-column justify-content-center">
    <h4 class="mb-1"><i class="ri ri-account-circle-line me-2" style="font-size:24px;vertical-align:-0.2em"></i><?= lang('profile') ?: 'Mon profil' ?></h4>
    <p class="mb-0 text-muted"><?= htmlspecialchars($user->first_name . ' ' . $user->last_name) ?> — <span class="text-muted-2"><?= htmlspecialchars($user->email) ?></span></p>
    <nav aria-label="breadcrumb" class="mt-2">
      <ol class="breadcrumb breadcrumb-style1 mb-0">
        <li class="breadcrumb-item"><a href="<?= admin_url() ?>">Accueil</a></li>
        <li class="breadcrumb-item active"><?= lang('profile') ?: 'Profil' ?></li>
      </ol>
    </nav>
  </div>
</div>

<div class="row">
    <!-- Avatar sidebar -->
    <div class="col-xl-3 col-lg-4 col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center pt-4">
                <div class="mb-3 position-relative d-inline-block">
                    <?php if ($user->avatar): ?>
                        <img src="<?= base_url() ?>assets/uploads/avatars/thumbs/<?= $user->avatar ?>"
                             alt="<?= $user->first_name ?>"
                             class="rounded-circle img-fluid"
                             style="width: 100px; height: 100px; object-fit: cover;"
                             id="avatarPreview">
                    <?php else: ?>
                        <img src="<?= base_url() ?>assets/images/<?= $user->gender ?>.png"
                             alt="<?= $user->first_name ?>"
                             class="rounded-circle img-fluid"
                             style="width: 100px; height: 100px; object-fit: cover;"
                             id="avatarPreview">
                    <?php endif; ?>
                    <span class="position-absolute bottom-0 end-0 bg-label-primary rounded-circle p-1" style="cursor:pointer;" onclick="document.getElementById('quickAvatarInput').click()">
                        <i class="icon-base ri ri-camera-line icon-20px"></i>
                    </span>
                </div>
                <h5 class="card-title mb-1"><?= $user->first_name . ' ' . $user->last_name ?></h5>
                <small class="text-muted"><?= $this->session->userdata('username') ?></small>
                <div class="mt-2">
                    <span class="badge bg-label-primary"><?= $user->group_name ?? '' ?></span>
                </div>
                <hr>
                <div class="text-start">
                    <p class="mb-1 d-flex align-items-center gap-2">
                        <i class="icon-base ri ri-mail-line icon-20px text-primary"></i>
                        <small><?= $user->email ?></small>
                    </p>
                    <p class="mb-1 d-flex align-items-center gap-2">
                        <i class="icon-base ri ri-phone-line icon-20px text-primary"></i>
                        <small><?= $user->phone ?></small>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <div class="col-xl-9 col-lg-8 col-md-8">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab">
                    <i class="icon-base ri ri-user-settings-line icon-20px me-1"></i><?= lang('edit_profile') ?>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#cpassword" type="button" role="tab">
                    <i class="icon-base ri ri-lock-password-line icon-20px me-1"></i><?= lang('change_password') ?>
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="avatar-tab" data-bs-toggle="tab" data-bs-target="#avatar" type="button" role="tab">
                    <i class="icon-base ri ri-image-edit-line icon-20px me-1"></i><?= lang('avatar') ?>
                </button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">

            <!-- Edit Profile Tab -->
            <div class="tab-pane fade show active" id="edit" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-user-edit-line icon-20px me-2 text-primary"></i>
                        <h5 class="card-title mb-0"><?= lang('edit_profile') ?></h5>
                    </div>
                    <div class="card-body">
                        <?php $attrib = ['class' => 'row g-3', 'role' => 'form'];
                        echo admin_form_open('auth/edit_user/' . $user->id, $attrib); ?>

                        <div class="col-md-6">
                            <label for="first_name" class="form-label"><?= lang('first_name') ?></label>
                            <?php echo form_input('first_name', $user->first_name, 'class="form-control" id="first_name" required="required"'); ?>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label"><?= lang('last_name') ?></label>
                            <?php echo form_input('last_name', $user->last_name, 'class="form-control" id="last_name" required="required"'); ?>
                        </div>

                        <?php if (!$this->ion_auth->in_group('customer', $id) && !$this->ion_auth->in_group('supplier', $id)): ?>
                        <div class="col-md-6">
                            <label for="company" class="form-label"><?= lang('company') ?></label>
                            <?php echo form_input('company', $user->company, 'class="form-control" id="company"'); ?>
                        </div>
                        <?php else:
                            echo form_hidden('company', $user->company);
                        endif; ?>

                        <div class="col-md-6">
                            <label for="phone" class="form-label"><?= lang('phone') ?></label>
                            <input type="tel" name="phone" class="form-control" id="phone"
                                   value="<?= $user->phone ?>" required="required"/>
                        </div>

                        <div class="col-md-6">
                            <label for="gender" class="form-label"><?= lang('gender') ?></label>
                            <?php
                            $ge = ['male' => lang('male'), 'female' => lang('female')];
                            echo form_dropdown('gender', $ge, ($_POST['gender'] ?? $user->gender), 'class="form-select" id="gender" required="required"');
                            ?>
                        </div>

                        <?php if (($Owner || $Admin) && $id != $this->session->userdata('user_id')): ?>
                        <div class="col-md-6">
                            <label for="award_points" class="form-label"><?= lang('award_points') ?></label>
                            <?= form_input('award_points', set_value('award_points', $user->award_points), 'class="form-control" id="award_points"'); ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($Owner && $id != $this->session->userdata('user_id')): ?>
                        <div class="col-md-6">
                            <label for="username" class="form-label"><?= lang('username') ?></label>
                            <input type="text" name="username" class="form-control" id="username"
                                   value="<?= $user->username ?>" required="required"/>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label"><?= lang('email') ?></label>
                            <input type="email" name="email" class="form-control" id="email"
                                   value="<?= $user->email ?>" required="required"/>
                        </div>

                        <!-- User Options Panel -->
                        <div class="col-12">
                            <div class="card border">
                                <div class="card-header bg-label-warning">
                                    <h6 class="mb-0"><?= lang('user_options') ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label"><?= lang('status') ?></label>
                                            <?php $opt = [1 => lang('active'), 0 => lang('inactive')];
                                            echo form_dropdown('status', $opt, ($_POST['status'] ?? $user->active), 'class="form-select" id="status" required="required"'); ?>
                                        </div>
                                        <?php if (!$this->ion_auth->in_group('customer', $id) && !$this->ion_auth->in_group('supplier', $id)): ?>
                                        <div class="col-md-6">
                                            <label class="form-label"><?= lang('group') ?></label>
                                            <?php $gp = [''];
                                            foreach ($groups as $group) {
                                                if ($group['name'] != 'customer' && $group['name'] != 'supplier') {
                                                    $gp[$group['id']] = $group['name'];
                                                }
                                            }
                                            echo form_dropdown('group', $gp, ($_POST['group'] ?? $user->group_id), 'id="group" class="form-select"'); ?>
                                        </div>
                                        <div class="no">
                                            <div class="col-md-6">
                                                <label class="form-label"><?= lang('biller') ?></label>
                                                <?php $bl = ['' => lang('select') . ' ' . lang('biller')];
                                                foreach ($billers as $biller) {
                                                    $bl[$biller->id] = $biller->company && $biller->company != '-' ? $biller->company : $biller->name;
                                                }
                                                echo form_dropdown('biller', $bl, ($_POST['biller'] ?? $user->biller_id), 'id="biller" class="form-select"'); ?>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label"><?= lang('warehouse') ?></label>
                                                <?php $wh = ['' => lang('select') . ' ' . lang('warehouse')];
                                                foreach ($warehouses as $warehouse) {
                                                    $wh[$warehouse->id] = $warehouse->name;
                                                }
                                                echo form_dropdown('warehouse', $wh, ($_POST['warehouse'] ?? $user->warehouse_id), 'id="warehouse" class="form-select"'); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><?= lang('view_right') ?></label>
                                                <?php $vropts = [1 => lang('all_records'), 0 => lang('own_records')];
                                                echo form_dropdown('view_right', $vropts, ($_POST['view_right'] ?? $user->view_right), 'id="view_right" class="form-select"'); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><?= lang('edit_right') ?></label>
                                                <?php $opts = [1 => lang('yes'), 0 => lang('no')];
                                                echo form_dropdown('edit_right', $opts, ($_POST['edit_right'] ?? $user->edit_right), 'id="edit_right" class="form-select"'); ?>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><?= lang('allow_discount') ?></label>
                                                <?= form_dropdown('allow_discount', $opts, ($_POST['allow_discount'] ?? $user->allow_discount), 'id="allow_discount" class="form-select"'); ?>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php echo form_hidden('id', $id); ?>
                        <?php echo form_hidden($csrf); ?>

                        <div class="col-12">
                            <?php echo form_submit('update', lang('update'), 'class="btn btn-primary"'); ?>
                            <a href="<?= admin_url() ?>" class="btn btn-outline-secondary ms-2"><?= lang('cancel') ?></a>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Change Password Tab -->
            <div class="tab-pane fade" id="cpassword" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-lock-password-line icon-20px me-2 text-warning"></i>
                        <h5 class="card-title mb-0"><?= lang('change_password') ?></h5>
                    </div>
                    <div class="card-body">
                        <?php echo admin_form_open('auth/change_password', 'id="change-password-form" class="row g-3"'); ?>

                        <div class="col-md-6">
                            <label for="curr_password" class="form-label"><?= lang('old_password') ?></label>
                            <?php echo form_password('old_password', '', 'class="form-control" id="curr_password" required="required"'); ?>
                        </div>

                        <div class="col-12"></div>

                        <div class="col-md-6">
                            <label for="new_password" class="form-label">
                                <?php echo sprintf(lang('new_password'), $min_password_length); ?>
                            </label>
                            <?php echo form_password('new_password', '', 'class="form-control" id="new_password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"'); ?>
                            <div class="form-text text-muted"><?= lang('pasword_hint') ?></div>
                        </div>

                        <div class="col-md-6">
                            <label for="new_password_confirm" class="form-label"><?= lang('confirm_password') ?></label>
                            <?php echo form_password('new_password_confirm', '', 'class="form-control" id="new_password_confirm" required="required"'); ?>
                        </div>

                        <?php echo form_input($user_id); ?>

                        <div class="col-12">
                            <?php echo form_submit('change_password', lang('change_password'), 'class="btn btn-warning"'); ?>
                        </div>

                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>

            <!-- Avatar Tab -->
            <div class="tab-pane fade" id="avatar" role="tabpanel">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <i class="icon-base ri ri-image-edit-line icon-20px me-2 text-success"></i>
                        <h5 class="card-title mb-0"><?= lang('change_avatar') ?></h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4 text-center">
                                <div class="position-relative d-inline-block mb-3">
                                    <?php if ($user->avatar): ?>
                                        <img src="<?= base_url() ?>assets/uploads/avatars/<?= $user->avatar ?>"
                                             alt="<?= $user->first_name ?>"
                                             class="rounded-circle img-fluid border"
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             id="avatarPreviewLarge">
                                    <?php else: ?>
                                        <img src="<?= base_url() ?>assets/images/<?= $user->gender ?>.png"
                                             alt="<?= $user->first_name ?>"
                                             class="rounded-circle img-fluid border"
                                             style="width: 150px; height: 150px; object-fit: cover;"
                                             id="avatarPreviewLarge">
                                    <?php endif; ?>
                                </div>

                                <?php if ($user->avatar): ?>
                                <div class="mb-2">
                                    <a href="<?= admin_url('auth/delete_avatar/' . $id . '/' . $user->avatar) ?>"
                                       class="btn btn-outline-danger btn-sm"
                                       onclick="return confirm('<?= lang('r_u_sure') ?>')">
                                        <i class="icon-base ri ri-delete-bin-line icon-20px me-1"></i><?= lang('delete_avatar') ?>
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-8">
                                <?php echo admin_form_open_multipart('auth/update_avatar', 'class="row g-3"'); ?>

                                <div class="col-12">
                                    <label for="product_image" class="form-label"><?= lang('change_avatar') ?></label>
                                    <input type="file" name="avatar" id="product_image" accept="image/*"
                                           class="form-control" required="required"
                                           onchange="previewAvatar(this)"/>
                                    <div class="form-text"><?= lang('allowed_image_formats') ?? 'JPG, GIF, PNG. Max 2MB.' ?></div>
                                </div>

                                <?php echo form_hidden('id', $id); ?>
                                <?php echo form_hidden($csrf); ?>

                                <div class="col-12">
                                    <?php echo form_submit('update_avatar', lang('update_avatar'), 'class="btn btn-success"'); ?>
                                </div>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.tab-content -->
    </div>
</div>

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('avatarPreviewLarge') && (document.getElementById('avatarPreviewLarge').src = e.target.result);
            document.getElementById('avatarPreview') && (document.getElementById('avatarPreview').src = e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<?php if ($Owner && $id != $this->session->userdata('user_id')): ?>
<script>
$(document).ready(function () {
    $('#group').change(function () {
        var group = $(this).val();
        if (group == 1 || group == 2) {
            $('.no').slideUp();
        } else {
            $('.no').slideDown();
        }
    });
    var group = <?= $user->group_id ?>;
    if (group == 1 || group == 2) {
        $('.no').slideUp();
    } else {
        $('.no').slideDown();
    }
});
</script>
<?php endif; ?>
