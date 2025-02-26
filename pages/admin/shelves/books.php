<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>
<?php $data = Response::getData(); ?>
<h1 class="mt-4">Arrangements</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/shelves/arrangements">Arrangements</a>
    </li>
    <li class="breadcrumb-item">
        <a href="<?=APP_URL?>admin/shelves/arrangements">Shelves</a>
    </li>
    <li class="breadcrumb-item active">
        <?= $data->shelve->name ?>
    </li>
</ol>

<div class="card">
    <div class="card-header">
    <i class="fas fa-book"></i> <?= $data->shelve->name ?> - Books
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-2">
            <button class="btn btn-primary btn-sm" onclick="showAddBooksModal()"><i class="fas fa-plus me-1"></i>Add Books</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th width="100px" class="text-center">Status</th>
                        <th width="90px" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data->books as $key => $value): ?>
                        <tr>
                            <td class="text-center"><?=$value->id?></td>
                            <td><?=$value->name?></td>
                            <td class="text-center">
                                <span class="badge text-bg-<?=$value->is_active ? 'success' : 'danger'?>">
                                    <?=$value->is_active == 1 ? 'Active' : 'Inactive'?>
                                </span>
                            </td>
                            <td class="text-center">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if(empty($data->books)): ?>
                        <tr>
                            <td colspan="5" class="text-center">No books found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="addBooksModal" class="modal fade">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Books</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <label for="search" class="input-group-text">Search</label>
                    <input type="search" name="search" id="search" class="form-control">
                </div>

                <div class="mb-2" id="books"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary toggle-loader" type="submit">Save</button>
            </div>
        </div>
    </div>
</div>


<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>

<script>
    $(function () {

    });

    function searchBooks(search){
        $modal = $("#addBooksModal");
        $.get(
            "<?=APP_URL?>api/arrangements/books/unassigned",
            {
                search : search,
                arrangement_id : <?=$data->shelve->arrangement_id?>
            },
            (data) => {
                $modal = $("#addBooksModal").find("#books").html(data)
            }
        )
    }

    function showAddBooksModal() {
        $modal = $("#addBooksModal");
        searchBooks("");
        $modal.modal("show");
    }

    

</script>