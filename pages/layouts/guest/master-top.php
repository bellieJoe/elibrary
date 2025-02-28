<!DOCTYPE html>
<html lang="en">
    <?php include (ROOT_PATH.'pages/layouts/guest/head.php'); ?>
    <body class="sb-nav-fixed">
        <?php include (ROOT_PATH.'pages/layouts/guest/nav.php'); ?>
            <main>
                <div class="container-fluid px-4" style="min-height: calc(100vh - 69px); padding-top: 56px;">
                        <?php
                            if(isset($_SESSION['success_message'])) {
                        ?>
                            <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                                <strong>Success!</strong> <?=$_SESSION['success_message']?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['success_message']);
                            }
                        ?>
                        <?php
                            if(isset($_SESSION['error_message'])) {
                        ?>
                            <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                                <strong>Error!</strong> <?=$_SESSION['error_message']?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php
                            unset($_SESSION['error_message']);
                            }
                        ?>