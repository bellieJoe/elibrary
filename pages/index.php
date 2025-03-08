<?php include (ROOT_PATH.'pages/layouts/guest/master-top.php'); ?>

<?php 
    $response = Response::getData();
?>

<div class="row justify-content-center">
    <div class="col-12 col-sm-9 col-md-8 col-lg-7 py-3 m-0">
        <div class="card bg-main border-0 p-2 mb-3">
            <div class="row justify-content-center align-items-center w-100 mx-0">
                <img src="<?=APP_URL?>assets/img/logo.png" class="img-fluid" style="width: 120px;" alt="MNHS Logo">
            </div>
            <h5 class="card-subtitle text-center " >Marinduque National High School</h5>
            <h6 class="card-subtitle text-center " >Isok I, Boac, Marinduque, Philippines</h6>
            <br>
            <h3 class="card-title text-center text-primary glow-text">E-Library Portal</h3>
        </div>
        <form action="" method="get">
            <div class="row ">
                <div class="col-sm mb-2">
                    <input type="search" class="form-control" name="search" value="<?=(isset($_GET['search']) ? $_GET['search'] : '')?>" placeholder="Search Books, Author etc.">
                </div>
                <div class="col-12 col-sm-auto ">
                    <button type="submit" class="btn btn-primary d-block w-100 toggle-loader">Search</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Genre</th>
                        <th scope="col">Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(property_exists($response, 'books') && !empty($response->books)): ?>
                        <?php foreach($response->books as $book): ?>
                            <tr>
                                <td><?=$book->name?></td>
                                <td><?=$book->author?></td>
                                <td><?=$book->genre?></td>
                                <td><?=$book->shelve_name?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No results found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php include (ROOT_PATH.'pages/components/pagination.php'); ?>
    </div>
</div>

<?php include (ROOT_PATH.'pages/layouts/guest/master-bottom.php'); ?>