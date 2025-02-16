<?php

require_once ROOT_PATH . "controllers/Controller.php";

class AuthController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        Middleware::isGuest(true, APP_URL . "admin"  ,"You must be logged out to access the login page");
        include __DIR__ . "/../pages/auth/login.php";
        exit();
    }

    public function logout() {
        Response::logout();
    }

    public function tryLogin(){
        Middleware::isGuest(true);
        $req = $this->postRequest();
        $username = property_exists($req, "username") ? $req->username : null;
        $password = property_exists($req, "password") ? $req->password : null;

        if(!$username || !$password) {
            Response::redirectFail(
                APP_URL . "login",
                401,
                "Missing username or password",
            );
        }

        $user = $this->db->getUserByUsername($username);
        if(!$user) {
            Response::redirectFail(
                APP_URL . "login",
                401,
                "Invalid username or password",
            );
        }

        if(!password_verify($password, $user->password)) {
            Response::redirectFail(
                APP_URL . "login",
                401,
                "Invalid username or password",
            );
        }

        Response::setUser($user);
        Response::redirectSuccess(
            APP_URL . "admin",
            200,
            "Login successful"
        );
    }
}