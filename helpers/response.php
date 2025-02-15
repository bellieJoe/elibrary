<?php

class Response {
    public static function view($name, $data = []) {
        $_SESSION["data"] = (Object)$data;
        include ROOT_PATH . "pages/" . $name . ".php";
    }

    public static function data() {
        return (Object)$_SESSION["data"];
    }

    public static function redirectSuccess($url, $status_code, $message){
        $_SESSION["success_message"] = $message;
        $_SESSION["status_code"] = $status_code;
        header("Location: " . $url);
        exit();
    }

    public static function redirectFail($url, $status_code, $message){
        $_SESSION["error_message"] = $message;
        $_SESSION["status_code"] = $status_code;
        header("Location: " . $url);
        exit();
    }

    public static function redirectToError($code) {
        $_GET["error_code"] = $code;
        include ROOT_PATH . "pages/errors/error.php";
        exit();
    }

    public static function getData() {
        return isset($_SESSION["data"]) ? $_SESSION["data"] : (object)[];
    }
}