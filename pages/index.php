<?php include (ROOT_PATH.'pages/layouts/guest/master-top.php'); ?>

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
        <form action="#">
            <div class="row ">
                <div class="col-sm mb-2">
                    <input type="search" class="form-control" placeholder="Search Books, Author etc.">
                </div>
                <div class="col-12 col-sm-auto ">
                    <button type="submit" class="btn btn-primary d-block w-100 toggle-loader">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include (ROOT_PATH.'pages/layouts/guest/master-bottom.php'); ?>