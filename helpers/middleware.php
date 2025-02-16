<?php

class Middleware {

    public static function isAuth(bool $redirect, $url = APP_URL . "login"){
        $user = Response::getUser();
        if(!$user && $redirect){
            Response::redirectFail($url, 401, "You must be logged in to access this page");
            return false;
        }
        if(!$user){
            return false;
        }
        return true;
    }

    public static function isGuest(bool $redirect, $url = APP_URL . "admin", $errMessage = "You must be logged out to access this page"){
        $user = Response::getUser();
        $user = Response::getUser();
        if($user && $redirect){
            Response::redirectFail($url, 401, $errMessage);
            return false;
        }
        if($user){
            return false;
        }
        return true;
    }
}