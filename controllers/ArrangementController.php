<?php

require_once ROOT_PATH . "controllers/Controller.php";

class ArrangementController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        try {
            Middleware::isAuth(true);
            $req = $this->getRequest();
            $name = property_exists($req, "name") ? $req->name : "";
            $_page = property_exists($req, "_page") ? $req->_page : 1;
            $sortBy = property_exists($req, "sortBy") ? $req->sortBy : null;
            $sort = property_exists($req, "sort") ? $req->sort : null;
            $arrangements = $this->db->paginateArrangement($name, $_page, 10, $sortBy, $sort);
            Response::view("admin/arrangements/arrangements", [
                "arrangements" => $arrangements,
                "_page" => $_page
            ]);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function create() {
        try {
            Middleware::isAuth(true);
            Response::view("admin/arrangements/create", []);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function store() {
        try {
            Middleware::isAuth(true);
            $req = $this->postRequest();
            if (!isset($_FILES["map"]) || $_FILES["map"]["error"] !== UPLOAD_ERR_OK) {
                Response::redirectFail(APP_URL . "admin/shelves/arrangements", 400, "No file uploaded or upload error");
            }
            $file = $_FILES["map"];
            $filename = $this->saveFile($file, "uploads/maps/");
            if(!$filename) {
                Response::redirectFail(APP_URL . "admin/shelves/arrangements", 500, "Failed to upload file");
            }
            $res = $this->db->storeArrangement($req->name, $req->description, $filename, $req->shelves);
            if(!$res) {
                Response::redirectFail( APP_URL . "admin/shelves/arrangements/create", 500, "Failed to create Arrangement");
            }
            Response::redirectSuccess( APP_URL . "admin/shelves/arrangements", 200, "Arrangement created successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function view(){
        try {
            Middleware::isAuth(true);
            $req = $this->getRequest();
            $shelves = $this->db->getShelvesByArrangementId($req->id);
            Response::view("admin/arrangements/view", [
                "shelves" => $shelves
            ]);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function changeMap(){
        try {
            Middleware::isAuth(true);
            $req = $this->postRequest();
            $file = $_FILES["map"];
            $filename = $this->saveFile($file, "uploads/maps/");
            if(!$filename) {
                Response::redirectFail(APP_URL . "admin/shelves/arrangements/view?id=" . $req->id, 500, "Failed to upload file");
            }
            $res = $this->db->changeMap($req->id, $filename);
            if(!$res) {
                Response::redirectFail( APP_URL . "admin/shelves/arrangements/view?id=" . $req->id, 500, "Failed to change map");
            }
            Response::redirectSuccess( APP_URL . "admin/shelves/arrangements/view?id=" . $req->id, 200, "Map changed successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

}