<?php
if ($attachments || (isset($inv) && $inv->attachment)) {
    ?>
    <div class="list-group no-print mt-2">
        <?php
        if (isset($inv) && $inv->attachment && strlen($inv->attachment) > 1) {
            ?>
            <a href="<?php echo admin_url('welcome/download/' . $inv->attachment); ?>"
               class="list-group-item list-group-item-action d-flex align-items-center gap-2">
                <span class="icon-base ri ri-attachment-2 text-primary icon-16px"></span>
                <span><?php echo lang('attachment') ?: 'Pièce jointe'; ?></span>
            </a>
            <?php
        }
        foreach ($attachments as $key => $attachment) {
            ?>
            <div class="list-group-item d-flex align-items-center justify-content-between gap-2">
                <a href="<?php echo admin_url('welcome/download/' . $attachment->file_name); ?>"
                   class="d-flex align-items-center gap-2 text-body text-decoration-none">
                    <span class="icon-base ri ri-file-line text-primary icon-16px"></span>
                    <span><?php echo htmlspecialchars($attachment->orig_name ?: (lang('attachment') ?: 'Pièce jointe') . ' ' . ($key + 1)); ?></span>
                </a>
                <?php if ($Owner || $Admin): ?>
                    <a href="<?php echo admin_url('welcome/delete/' . $attachment->id . '/' . $attachment->file_name); ?>"
                       class="btn btn-sm btn-icon btn-outline-danger"
                       title="<?php echo lang('delete') ?: 'Supprimer'; ?>"
                       onclick="return confirm('<?php echo lang('r_u_sure') ?: 'Supprimer cette pièce jointe ?'; ?>')">
                        <span class="icon-base ri ri-close-line icon-16px"></span>
                    </a>
                <?php endif; ?>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}
?>
