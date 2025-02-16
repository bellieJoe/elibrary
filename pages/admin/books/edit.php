<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<?php $data = Response::getData(); ?>

<h1 class="mt-4">Books</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/books">Genres</a>
    </li>
    <li class="breadcrumb-item active">
        Edit Book
    </li>
</ol>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Edit Book Form
    </div>
    
    <div class="card-body">
        <form action="<?=APP_URL?>admin/books/update" method="post">
            <input type="hidden" name="id" value="<?=$data->book->id?>">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="name">Book Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" value="<?=$data->book->name?>">
                </div>
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="author">Book Author <span class="text-danger">*</span></label>
                    <input type="text" name="author" id="author" class="form-control" value="<?=$data->book->author?>">
                </div>
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="genre">Genre <span class="text-danger">*</span></label>
                    <select type="text" name="genre" id="genre" class="form-control">
                        <option value="<?=$data->book->genre_id?>" selected><?=$data->book->genre?></option>
                    </select>
                </div>
                <div class="col-12 col-md-8 col-sm-6 mb-2 ">
                    <label for="description">Book Description <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" class="form-control"><?=$data->book->description?></textarea>
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
        $('#genre').select2({
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