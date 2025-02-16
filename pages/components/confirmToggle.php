<div class="modal fade" id="toggleModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <form action="#" method="post" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Change Status Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="status" id="status">
        <span id="message"></span>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary toggle-loader" type="submit" >Continue</button>
      </div>
    </div>
  </form>
</div>


<script>
    function confirmToggle(el, url, id, status, message,) {
      $e = $(el);
      if(status == 1) {
        $e.prop("checked", false);
      }
      else {
        $e.prop("checked", true);
      }
      $toggleModal = $("#toggleModal");
      $toggleModal.find("#id").val(id);
      $toggleModal.find("#status").val(status);
      $toggleModal.find("#message").html(message);
      $toggleModal.find("form").attr("action", url);
      $toggleModal.modal("show");
    }
</script>