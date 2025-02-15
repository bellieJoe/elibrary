<?php

require_once ROOT_PATH . "database/database.php";

class Controller {
    protected $db;

    protected function __construct() {
        $this->db = new Database();
    }

    protected function getRequest() {
        $request = [];
        foreach($_GET as $key => $value) {
            $request[$key] = Misc::sanitizeInput($value);
        }
        return (Object)$request;
    }

    protected function postRequest() {
        $request = [];
        foreach($_POST as $key => $value) {
            $request[$key] = Misc::sanitizeInput($value);
        }
        return (Object)$request;
    }

}