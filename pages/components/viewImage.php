<div class="modal fade" id="viewImageModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
        <h6 class="modal-title" >View Image</h6>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img id="image"  class="img-fluid"></img>
      </div>
    </div>
  </div>
</div>


<script>
    function viewImage(url) {
        console.log(url);
      $viewImageModal = $("#viewImageModal");
      $viewImageModal.find("#image").attr("src", url);
      $viewImageModal.modal("show");
    }
</script>