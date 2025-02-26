<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>
<?php $data = Response::getData(); ?>
<h1 class="mt-4">Arrangements</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/shelves/arrangements">Arrangements</a>
    </li>
    <li class="breadcrumb-item active">
        <?= $data->arrangement->name ?>
    </li>
</ol>

<div class="card">
    <div class="card-header">
        <i class="fas fa-boxes"></i> Shelves
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2">
            <div class="dropdown me-2">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-map me-1"></i>Map
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <li><button class="dropdown-item" onclick="viewImage(`<?=APP_URL?>uploads/maps/<?=$data->arrangement->map?>`)">View</button></li>
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#changeMapModal">Change</a></li>
                </ul>
            </div>
            <button class="btn btn-sm btn-primary" data-bs-target="#addShelveModal" data-bs-toggle="modal">Add Shelve</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th width="100px" class="text-center">Books</th>
                        <th width="90px" class="text-center">Status</th>
                        <th width="150px" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data->shelves as $key => $value): ?>
                        <tr>
                            <td class="text-center"><?=$key+1?></td>
                            <td><?=$value->name?></td>
                            <td class="text-center">
                                <!-- <span class="badge text-bg-primary"><?=$value->book_count?></span> -->
                            </td>
                            <td class="text-center">
                                <span class="badge text-bg-<?=$value->is_active ? 'success' : 'danger'?>">
                                    <?=$value->is_active == 1 ? 'Active' : 'Inactive'?>
                                </span>
                            </td>  
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><h6 class="dropdown-header">Shelve</h6></li>
                                        <li><a class="dropdown-item" href="#" onclick="initUpdateShelve('<?=$value->id?>', '<?=$value->name?>', '<?=$value->arrangement_id?>')"><i class="fa fa-pen"></i> Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('<?=APP_URL?>admin/shelves/delete', '<?=$value->id?>', 'This action is irreversible. Are you sure you want to delete this shelve? ')"><i class="fa fa-trash"></i> Delete</a></li>
                                        <li><h6 class="dropdown-header">Books</h6></li>
                                        <li><a class="dropdown-item " href="<?=APP_URL?>admin/shelves/books?id=<?=$value->id?>" ><i class="fa fa-book"></i> Books</a></li>
                                    </ul>
                                </div>
                                
                            </td> 
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($data->shelves)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No shelves found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="changeMapModal">
    <form action="<?=APP_URL?>admin/shelves/arrangements/change-map" method="post" enctype="multipart/form-data" class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Map</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="">
                    <input type="hidden" name="id" value="<?=$data->shelves[0]->arrangement_id?>">
                    <input type="file" name="map" accept=".jpg, .jpeg, .png" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary toggle-loader" type="submit">Save</button>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="addShelveModal">
    <form action="<?=APP_URL?>admin/shelves/create" method="post"  class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shelve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="arrangement_id" value="<?=$data->arrangement->id?>">
                <div class="">
                    <label for="name">Shelve Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary toggle-loader" type="submit">Save</button>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="updateShelveModal">
    <form action="<?=APP_URL?>admin/shelves/update" method="post"  class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Shelve</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id" value="">
                <input type="hidden" name="arrangement_id" id="arrangement_id" value="">
                <div class="">
                    <label for="name">Shelve Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary toggle-loader" type="submit">Save</button>
            </div>
        </div>
    </form>
</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>

<script>
    function initUpdateShelve(id, name, arrangement_id) {
        $modal = $("#updateShelveModal");
        $modal.find("#id").val(id);
        $modal.find("#arrangement_id").val(arrangement_id);
        $modal.find("#name").val(name);
        $modal.modal("show");
    }
</script>

