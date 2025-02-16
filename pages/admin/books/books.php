<?php 

include (ROOT_PATH.'pages/layouts/admin/master-top.php'); 

$response = Response::getData();

?>

<h1 class="mt-4">Books</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">
        <a href="<?=APP_URL?>admin/books">Books</a>
    </li>
</ol>



<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        List of Books
    </div>

    <div class="card-body ">
        <div class="d-flex justify-content-end mb-2">
            <a class="btn btn-sm btn-primary toggle-loader me-2" href="<?=APP_URL?>admin/books/create">
                <i class="fas fa-plus me-1"></i>
                Add Book
            </a>
            <button class="btn btn-sm btn-outline-primary me-2" 
                onclick="initSortModal([
                    {key:'name', label:'Name'},
                    {key:'author', label:'Author'},
                    {key:'is_active', label:'Status'},
                ])"
                >
                <i class="fas fa-sort me-1"></i>
                Sort
            </button>
            <button class="btn btn-sm btn-outline-primary " 
                onclick="initFilterModal([
                    {
                        type : 'text',
                        key : 'name',
                        label : 'Name',
                        value : '<?=isset($_GET['name']) ? $_GET['name'] : ''?>'
                    },
                    {
                        type : 'text',
                        key : 'author',
                        label : 'Author',
                        value : '<?=isset($_GET['author']) ? $_GET['author'] : ''?>'
                    },
                ])"
                >
                <i class="fas fa-filter me-1"></i>
                Filter
            </button>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th>Author</th>
                        <th>Genre</th>
                        <th>Description</th>
                        <th width="70px" class="text-center">Status</th>
                        <th width="200px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($response->books)) {
                        foreach ($response->books as $key => $value) {
                            $index = $key + 1;
                    ?>
                                <tr>
                                    <th class="text-center"><?=$index?></th>
                                    <td><?=$value->name?></td>
                                    <td><?=$value->author?></td>
                                    <td><?=$value->genre?></td>
                                    <td><?=$value->description?></td>
                                    <td class="text-center">
                                        <div class="form-check form-switch d-flex justify-content-center">
                                            <input class="form-check-input" type="checkbox" <?= $value->is_active ? 'checked' : '' ?> onclick="confirmToggle(this, '<?=APP_URL.'admin/books/toggle-status'?>', <?=$value->id?>, <?=$value->is_active == 1 ? 0 : 1?>, 'Are you sure you want to <?=$value->is_active == 1 ? 'deactivate' : 'activate'?> this genre status?')">
                                        </div>
                                    </td>
                                    <td class='text-center'>
                                        <a class='btn btn-sm btn-primary' href='<?=APP_URL."admin/books/edit?id=".$value->id?>'><i class='fas fa-edit me-1'></i>Edit</a>
                                        <button class='btn btn-sm btn-danger' onclick="confirmDelete('<?=APP_URL.'admin/books/delete'?>', '<?=$value->id?>', 'Are you sure you want to delete this book?')"><i class='fas fa-trash me-1'></i>Delete</button>
                                    </td>
                                </tr>
                    <?php
                        }
                    }
                    else {
                    ?>
                            <tr>
                                <td colspan='4' class='text-center'>No Data Found</td>
                            </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include (ROOT_PATH.'pages/components/pagination.php'); ?>
    </div>
</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>
