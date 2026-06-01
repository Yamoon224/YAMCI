<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<style>@media print { .no-print { display:none !important; } }</style>
<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">
        <span class="icon-base ri ri-survey-line me-2 text-primary icon-18px"></span>
        <?php echo lang('stock_count') ?: 'Inventaire'; ?>
      </h5>
      <div class="d-flex gap-2">
        <button class="btn btn-sm btn-outline-secondary no-print" onclick="window.print();">
          <span class="icon-base ri ri-printer-line me-1 icon-14px"></span><?php echo lang('print') ?: 'Imprimer'; ?>
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
    </div>
    <div class="modal-body">
      <!-- Count meta -->
      <div class="row mb-4">
        <div class="col-sm-6">
          <div class="bg-light rounded p-3">
            <p class="mb-1"><strong><?php echo lang('warehouse') ?: 'Entrepôt'; ?>:</strong>
              <?php echo htmlspecialchars($warehouse->name . ' (' . $warehouse->code . ')'); ?>
            </p>
            <p class="mb-1"><strong><?php echo lang('reference') ?: 'Référence'; ?>:</strong> <?php echo htmlspecialchars($stock_count->reference_no); ?></p>
            <p class="mb-1"><strong><?php echo lang('start_date') ?: 'Début'; ?>:</strong> <?php echo $this->sma->hrld($stock_count->date); ?></p>
            <p class="mb-0"><strong><?php echo lang('end_date') ?: 'Fin'; ?>:</strong> <?php echo $this->sma->hrld($stock_count->updated_at); ?></p>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="bg-light rounded p-3">
            <p class="mb-1"><strong><?php echo lang('type') ?: 'Type'; ?>:</strong> <?php echo lang($stock_count->type) ?: $stock_count->type; ?></p>
            <?php if ($stock_count->type == 'partial'): ?>
              <p class="mb-1"><strong><?php echo lang('categories') ?: 'Catégories'; ?>:</strong> <?php echo htmlspecialchars($stock_count->category_names ?? ''); ?></p>
              <p class="mb-0"><strong><?php echo lang('brands') ?: 'Marques'; ?>:</strong> <?php echo htmlspecialchars($stock_count->brand_names ?? ''); ?></p>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Download files -->
      <?php if (!empty($stock_count->initial_file) || !empty($stock_count->final_file)): ?>
      <div class="d-flex gap-2 mb-4">
        <?php if (!empty($stock_count->initial_file)): ?>
          <a href="<?php echo admin_url('welcome/download/' . $stock_count->initial_file); ?>" class="btn btn-sm btn-outline-primary">
            <span class="icon-base ri ri-download-line me-1 icon-14px"></span><?php echo lang('initial_file') ?: 'Fichier initial'; ?>
          </a>
        <?php endif; ?>
        <?php if (!empty($stock_count->final_file)): ?>
          <a href="<?php echo admin_url('welcome/download/' . $stock_count->final_file); ?>" class="btn btn-sm btn-outline-success">
            <span class="icon-base ri ri-download-line me-1 icon-14px"></span><?php echo lang('final_file') ?: 'Fichier final'; ?>
          </a>
        <?php endif; ?>
      </div>
      <?php endif; ?>

      <!-- Items table -->
      <?php if (!empty($rows)): ?>
      <div class="table-responsive">
        <table class="table table-bordered print-table">
          <thead class="table-light">
            <tr>
              <th><?php echo lang('product') ?: 'Produit'; ?></th>
              <th class="text-center"><?php echo lang('expected') ?: 'Attendu'; ?></th>
              <th class="text-center"><?php echo lang('counted') ?: 'Compté'; ?></th>
              <th class="text-center"><?php echo lang('difference') ?: 'Écart'; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $row): ?>
            <?php $diff = ($row->counted_qty ?? 0) - ($row->expected_qty ?? 0); ?>
            <tr>
              <td><?php echo htmlspecialchars($row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '')); ?></td>
              <td class="text-center"><?php echo $this->sma->formatQuantity($row->expected_qty ?? 0); ?></td>
              <td class="text-center"><?php echo $this->sma->formatQuantity($row->counted_qty ?? 0); ?></td>
              <td class="text-center">
                <span class="badge <?php echo $diff == 0 ? 'bg-label-success' : ($diff < 0 ? 'bg-label-danger' : 'bg-label-warning'); ?>">
                  <?php echo ($diff > 0 ? '+' : '') . $this->sma->formatQuantity($diff); ?>
                </span>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php endif; ?>
    </div>
    <div class="modal-footer no-print">
      <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo lang('close') ?: 'Fermer'; ?></button>
    </div>
  </div>
</div>
