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

    protected function saveFile($file, $path) {
        try {
            $filename = rand(100,999) . '-' . time().".".pathinfo($file['name'], PATHINFO_EXTENSION);
            $file_tmp = $file['tmp_name'];
            $upload_path = $path . $filename;
            $uploadmove_file = move_uploaded_file($file_tmp, $upload_path);
            if(!$uploadmove_file) {
                return false;
            }
            return $filename;
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            return false;
        }
    }


}