<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <form action="<?=Response::changeUrlParams([])?>" method="get" class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel"><i class="fas fa-filter me-2"></i>Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="filterInputs">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button class="btn btn-outline-primary " onclick="clearFilter(event)" type="submit" >Clear</button>
        <button class="btn btn-primary toggle-loader" type="submit">Filter</button>
      </div>
    </div>
  </form>
</div>


<script>
    function initFilterModal(filterOptions = []) {
        $filterModal = $("#filterModal");
        $("#filterInputs").html("");
        filterOptions.map((option) => {
          switch (option.type) {
            case 'text':
                $("#filterInputs").append(`<div class="mb-2">
                    <label for="${option.key}">${option.label}</label>
                    <input type="text" name="${option.key}" id="${option.key}" value="${option.value}"  class="form-control filter-input">
                </div>`)
                break;
            case 'select':
                $("#filterInputs").append(`<div class="mb-2">
                    <label for="${option.key}">${option.label}</label>
                    <select name="${option.key}" id="${option.key}" class="form-select filter-input">
                    ${option.options.map((val) => {
                        return `<option value="${val.key}">${val.label}</option>`
                    })}
                    </select>
                </div>`)
                break;
            default:
                break;
          }
        })
        $filterModal.modal("show");
    }

    function clearFilter(e) {
      e.preventDefault();
      console.log("po")
      $filterModal = $("#filterModal");
      form = $filterModal.find("form");
      form.find(".filter-input").val(""); 
      form.submit(); 
    }
</script>