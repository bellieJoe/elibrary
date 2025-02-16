<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<h1 class="mt-4">Books</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/books">Books</a>
    </li>
    <li class="breadcrumb-item active">
        Add Book
    </li>
</ol>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Book Form
    </div>
    
    <div class="card-body">
        <form action="<?=APP_URL?>admin/books/store" method="post">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="name">Book Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control">
                </div>
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="author">Book Author <span class="text-danger">*</span></label>
                    <input type="text" name="author" id="author" class="form-control">
                </div>
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="genre">Genre <span class="text-danger">*</span></label>
                    <select type="text" name="genre" id="genre" class="form-control select2">
                    </select>
                </div>
                <div class="col-12 col-md-8 col-sm-6 mb-2 ">
                    <label for="description">Book Description <span class="text-danger">*</span></label>
                    <textarea  name="description" id="description" class="form-control"></textarea>
                </div>
                <div class="col-12 col-md-8 col-sm-6">
                    <button class="btn btn-primary toggle-loader" type="submit"><i class="fas fa-save me-1"></i>Save</button>
                </div>
            </div>
        </form>
    </div>

</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap-5',
            ajax : {
                url : '<?=APP_URL?>api/genres/search',
                dataType : 'json',
                delay : 250,
                data : function(params) {
                    console.log(params)
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
                }
            }
        });
    });
</script>