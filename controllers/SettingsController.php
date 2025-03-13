<?php

require_once ROOT_PATH . "controllers/Controller.php";

class SettingsController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        try {
            Middleware::isAuth(true);
            Response::view("settings/index", []);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function changePassword() {
        try {
            Middleware::isAuth(true);
            $req = $this->getRequest();
            $user = $this->db->getUserByUsername("admin");
            if(!$user) {
                Response::redirectFail(APP_URL . "admin/settings", 404, "User not found");
            }
            if(!password_verify($req->current_password, $user->password)) {
                Response::redirectFail(APP_URL . "admin/settings", 400, "Current password is incorrect");
            }
            if(!$req->current_password || !$req->new_password || $req->new_password !== $req->new_password_confirmation) {
                Response::redirectFail(APP_URL . "admin/settings", 400, "Passwords do not match");
            }

            if(!$this->db->changePassword($req->new_password)) {
                Response::redirectFail(APP_URL . "admin/settings", 500, "Failed to change password");
            }
            Response::redirectSuccess(APP_URL . "admin/settings", 200, "Password changed successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }
}