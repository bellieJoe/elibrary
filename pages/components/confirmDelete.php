<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <form action="#" method="post" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <span id="message"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger toggle-loader" type="submit" id="delete-btn">Delete</button>
      </div>
    </div>
  </form>
</div>


<script>
    function confirmDelete(url, id, message) {
        $deleteModal = $("#deleteModal");
        $deleteModal.find("#id").val(id);
        $deleteModal.find("#message").html(message);
        $deleteModal.find("form").attr("action", url);
        $deleteModal.modal("show");
    }
</script>