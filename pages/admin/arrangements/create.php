<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<h1 class="mt-4">Arrangements</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/shelves/arrangements">Arrangements</a>
    </li>
    <li class="breadcrumb-item active">
        Add Arrangement
    </li>
</ol>


<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Create Arrangement Form
    </div>
    
    <div class="card-body">
        <form action="<?=APP_URL?>admin/shelves/arrangements/store" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="mb-2">
                        <label for="name">Arrangement Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="name">Library Map <span class="text-danger">*</span></label>
                        <input type="file" accept=".jpg, .jpeg, .png" name="map" id="map" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label for="description">Description <span class="text-danger">*</span></label>
                        <textarea  name="description" id="description" class="form-control"></textarea>
                    </div>
                </div>

                <div class="col-12 col-md-8 ">
                    <label for="shelves">Shelves <span class="text-danger">*</span></label>
                    <div id="shelves" class="row">
                        <div class="mb-2 col-lg-6 col-12" id="firstShelve">
                            <div class="input-group">
                                <input type="text" name="shelves[]"  class="form-control" placeholder="Enter Shelve Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-outline-primary me-2" onclick="addShelve()" type="button"><i class="fas fa-plus me-1"></i>Add Shelve</button>
                    </div>
                </div>

                <div class="col-12">
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary toggle-loader" type="submit"><i class="fas fa-save me-1"></i>Save</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>

<script>
    function addShelve() {
        $('#shelves').append(`
            <div class="mb-2 col-lg-6 col-12">
                <div class="input-group">
                    <input type="text" name="shelves[]" class="form-control" placeholder="Enter Shelve Name" required>
                    <button class="input-group-text btn btn-primary" onclick="$(this).parent().parent().remove()"><i class="fas fa-times " ></i></button>
                </div>
            </div>
        `);
    }
</script>   