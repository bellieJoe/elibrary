<?php 

include (ROOT_PATH.'pages/layouts/admin/master-top.php'); 

$response = Response::getData();

?>

<h1 class="mt-4">Genres</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">
        <a href="<?=APP_URL?>admin/genres">Genres</a>
    </li>
</ol>

<div class="d-flex justify-content-end mb-2">
    <a class="btn btn-primary toggle-loader" href="<?=APP_URL?>admin/genres/create">
        <i class="fas fa-plus me-1"></i>
        Add Genre
    </a>
</div>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        List of Genres
    </div>

    <div class="card-body ">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>
                    <tr>
                        <th width="50px" class="text-center">#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th width="200px" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(!empty($response->genres)) {
                        foreach ($response->genres as $key => $value) {
                            $index = $key + 1;
                    ?>
                                <tr>
                                    <td class="text-center"><?=$index?></td>
                                    <td><?=$value->name?></td>
                                    <td><?=$value->code?></td>
                                    <td><?=$value->description?></td>
                                    <td class='text-center'>
                                        <a class='btn btn-sm btn-primary' href='<?=APP_URL."admin/genres/edit?id=".$value->id?>'><i class='fas fa-edit me-1'></i>Edit</a>
                                        <button class='btn btn-sm btn-danger' onclick="confirmDelete('<?=APP_URL.'admin/genres/delete'?>', '<?=$value->id?>', 'Are you sure you want to delete this genre?')"><i class='fas fa-trash me-1'></i>Delete</button>
                                    </td>
                                </tr>
                    <?php
                        }
                    }
                    else {
                    ?>
                            <tr>
                                <td colspan='5' class='text-center'>No Data Found</td>
                            </tr>
                        ";
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
