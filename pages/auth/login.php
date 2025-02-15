<?php include (ROOT_PATH.'pages/layouts/guest/master-top.php'); ?>
<div class="row justify-content-center">
    <div class="col-lg-5">
        <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header py-4 bg-main border-bottom-0" >
                <div class="row justify-content-center align-items-center w-100 mx-0">
                    <img src="<?=APP_URL?>assets/img/logo.png" class="img-fluid" style="width: 120px;" alt="MNHS Logo">
                </div>
                <br>
                <h5 class="card-subtitle text-center " >Marinduque National High School</h5>
                <h6 class="card-subtitle text-center " >Isok I, Boac, Marinduque, Philippines</h6>
                <br>
                <h3 class="card-title text-center text-primary glow-text">E-Library</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputUsername" name="username" type="username" placeholder="Username" />
                        <label for="inputEmail">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                        <label for="inputPassword">Password</label>
                    </div>
                    <div class="d-flex align-items-center justify-content-end mt-4 mb-0">
                        <a class="btn btn-primary" href="index.html">Login</a>
                    </div>
                </form>
            </div>
            <!-- <div class="card-footer text-center py-3">
                <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
            </div> -->
        </div>
    </div>
</div>
<?php include (ROOT_PATH.'pages/layouts/guest/master-bottom.php'); ?>