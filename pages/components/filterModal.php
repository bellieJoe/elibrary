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
            case "select2":
                $("#filterInputs").append(`<div class="mb-2">
                    <label for="${option.key}">${option.label}</label>
                    <select name="${option.key}" id="${option.key}" class="form-select filter-input filterSelect2" data-url="${option.url}">
                      ${generateSelect2Options(option.url, option.value, `#${option.key}`)}
                    </select>
                </div>`)
                console.log(generateSelect2Options(option.url, option.value), "test");
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

        $(".filterSelect2").each(function() {
            $(this).select2({
                width: "100%",
                placeholder: "Select",
                theme: "bootstrap-5",
                ajax: {
                    url: $(this).data("url"),
                    dataType: "json",
                    delay: 250,
                    data : function(params) {
                        var query = {
                            keyword: params.term,
                            type: 'query'
                        }

                        return query;
                    },
                    processResults: function (data) {
                        return {
                            results: data
                        };
                    },  
                    cache: true
                }
            });
        })
    }

    function clearFilter(e) {
      e.preventDefault();
      console.log("po")
      $filterModal = $("#filterModal");
      form = $filterModal.find("form");
      form.find(".filter-input").val(""); 
      form.submit(); 
    }
 
    function generateSelect2Options(url, selected, element) {
        $data = [];
        $.ajax({
            url: url,
            data: {type: "query", keyword: ""},
            dataType: "json",
            success: function (data) {
              $el = $(element);
              $el.html("");
              $el.append(`<option value="">All</option>`);
              $el.append(data.map((val) => {
                  return `<option value="${val.id}" ${selected == val.id ? 'selected' : ''}>${val.text}</option>`
              }));
            }
        });
        return $data;
    }
</script>