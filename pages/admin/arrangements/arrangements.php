<?php 

include (ROOT_PATH.'pages/layouts/admin/master-top.php'); 

$response = Response::getData();

?>

<h1 class="mt-4">Arrangements</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">
        <a href="<?=APP_URL?>admin/arrangements">Arrangements</a>
    </li>
</ol>

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-end mb-2">
                <a class="btn btn-sm btn-primary toggle-loader me-2" href="<?=APP_URL?>admin/shelves/arrangements/create"><i class="fas fa-plus me-1"></i>New Arrangement</a>
                <button class="btn btn-sm btn-outline-primary me-2" 
                    onclick="initSortModal([
                        {key:'name', label:'Name'},
                        {key:'shelve_count', label:'No. of Shelves'},
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
                    ])"
                    >
                    <i class="fas fa-filter me-1"></i>
                    Filter
                </button>
            </div>
            <?php if(!property_exists($response, 'arrangements') || empty($response->arrangements)): ?>
                <div class="row justify-content-center">
                    <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                        <img src="<?=APP_URL?>assets/img/nodata.svg" alt="">
                    </div>
                </div>
            <?php endif; ?>
            <?php if(property_exists($response, 'arrangements') && !empty($response->arrangements)): ?>
                <div class="row justify-content-start">
                    <?php foreach($response->arrangements as $key => $value): ?>
                        <div class="col-12 col-sm-8 col-md-6 col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h5><?=$value->name?></h5>
                                    <p><?=$value->description ? $value->description : '<span class="text-secondary">No Description</span>'?></p>
                                    <p>
                                        <span class="badge text-bg-primary"><?=$value->shelve_count?> Shelves</span>
                                        <span class="badge text-bg-<?=$value->is_active ? 'success' : 'secondary'?>"><?=$value->is_active == 1 ? 'Active' : 'Inactive'?></span>
                                    </p>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-outline-primary me-2" onclick="viewImage(`<?=APP_URL.'uploads/maps/'.$value->map?>`)"><i class="fas fa-map me-1"></i>Map</button>
                                        <button 
                                            class="btn btn-sm btn-danger toggle-loader me-2" 
                                            onclick="confirmDelete(`<?=APP_URL.'admin/shelves/arrangements/delete'?>`, <?=$value->id?>, 'This action is irreversible. Are you sure you want to delete this arrangement? ')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                        <a class="btn btn-sm btn-primary toggle-loader" href="<?=APP_URL."admin/shelves/arrangements/view?id=".$value->id?>"><i class="fas fa-eye me-1"></i>View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <br>
            <?php include (ROOT_PATH.'pages/components/pagination.php'); ?>
        </div>
    </div>
</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>
