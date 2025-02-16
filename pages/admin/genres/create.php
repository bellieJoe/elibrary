<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<h1 class="mt-4">Genres</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/genres">Genres</a>
    </li>
    <li class="breadcrumb-item active">
        Add Genre
    </li>
</ol>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Genre Form
    </div>
    
    <div class="card-body">
        <form action="<?=APP_URL?>admin/genres/store" method="post">
            <div class="row">
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="name">Genre Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="col-12 col-md-4 col-sm-6 mb-2 ">
                    <label for="code">Genre Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="code" class="form-control" required>
                </div>
                <div class="col-12 col-md-8 col-sm-6 mb-2 ">
                    <label for="description">Genre Description <span class="text-danger">*</span></label>
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