<?php

class Response {
    public static function view($name, $data = []) {
        $_SESSION["data"] = (Object)$data;
        include ROOT_PATH . "pages/" . $name . ".php";
    }

    public static function data() {
        return (Object)$_SESSION["data"];
    }

    public static function redirectToUrl($url){
        header("Location: " . $url);
        exit();
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

    public static function getUser() {
        $user = isset($_SESSION["user"]) ? (Object)$_SESSION["user"] : null;

        return $user;
    }

    public static function setUser($user){
        $_SESSION["user"] = $user;
    }

    public static function logout() {
        unset($_SESSION["user"]);
        self::redirectToUrl(APP_URL . "login");
        exit();
    }

    public static function changeUrlParams($newParams = []) {
        // Get the current URL
        $scheme = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $requestUri = $_SERVER['REQUEST_URI']; // Includes query string in rewritten URLs
    
        // Parse URL components
        $parsedUrl = parse_url("$scheme://$host$requestUri");
    
        // Extract existing query parameters
        parse_str($parsedUrl['query'] ?? '', $queryParams);
    
        // Merge with new parameters (existing params get overwritten)
        $queryParams = array_merge($queryParams, $newParams);
    
        // Rebuild the query string
        $newQuery = http_build_query($queryParams);
    
        // Reconstruct the new URL
        $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        if (!empty($newQuery)) {
            $newUrl .= '?' . $newQuery;
        }
    
        return $newUrl;
    }
}