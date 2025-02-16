<div class="modal fade" id="sortModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <form action="<?=Response::changeUrlParams($_GET)?>" method="get" class="modal-dialog">
    <?php foreach ($_GET as $key => $value): ?>
        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
    <?php endforeach; ?>
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-sort me-2"></i>Sort</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="mb-2">
          <label for="sortBy">Sort By</label>
          <select name="sortBy" id="sortBy" class="form-select"></select>
        </div>
        <div class="mb-2">
          <label for="sort">Sort Order</label>
          <select name="sort" id="sort" class="form-select" required>
            <option value="asc" <?=isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'selected' : ''?>>Ascending</option>
            <option value="desc" <?=isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'selected' : ''?>>Descending</option>
          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary toggle-loader" type="submit" id="delete-btn">Sort</button>
      </div>
    </div>
  </form>
</div>


<script>
    function initSortModal(sortOptions) {
        $sortModal = $("#sortModal");
        $sortBy = $("#sortBy").html("");
        _sortBy = '<?=isset($_GET['sortBy']) ? $_GET['sortBy'] : ""?>';
        sortOptions.map((option) => {
          $("#sortBy").append(`<option value="${option.key}" ${option.key == _sortBy ? 'selected' : ''}>${option.label}</option>`)
        });
        $sortModal.modal("show");
    }
</script>