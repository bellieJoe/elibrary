<?php include (ROOT_PATH.'pages/layouts/admin/master-top.php'); ?>

<?php 
    $data = Response::getData();
?>
<h1 class="mt-4">Settings</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Settings</li>
</ol>
<div class="mx-auto" style="max-width: 700px;">
    <div class="row">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-key me-1"></i>
                    Change Password
                </div>
                <div class="card-body">
                    <form action="<?=APP_URL?>admin/settings/change-password" method="POST">
                        <div class="mb-2">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        <div class="mb-2">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="mb-2">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include (ROOT_PATH.'pages/layouts/admin/master-bottom.php'); ?>