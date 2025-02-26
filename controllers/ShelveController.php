<?php

require_once ROOT_PATH . "controllers/Controller.php";

class ShelveController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function delete() {
        try {
            Middleware::isAuth(true);
            $req = $this->postRequest();
            $arrangement = $this->db->getArrangementById($req->id);
            $res = $this->db->deleteShelve($req->id);
            if(!$res) { 
                Response::redirectFail( APP_URL . "admin/shelves/arrangements/view?id=".$arrangement->id, 500, "Failed to delete Shelve");
            }
            Response::redirectSuccess( APP_URL . "admin/shelves/arrangements/view?id=".$arrangement->id, 200, "Shelve deleted successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function create() {
        try {
            $req = $this->postRequest();
            $res = $this->db->createShelve($req->arrangement_id, $req->name);
            if(!$res) {
                Response::redirectFail( APP_URL . "admin/shelves/arrangements/view?id=".$req->arrangement_id, 500, "Failed to create Shelve");
            }

            Response::redirectSuccess( APP_URL . "admin/shelves/arrangements/view?id=".$req->arrangement_id, 200, "Shelve created successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function update() {
        try {
            $req = $this->postRequest();
            $res = $this->db->updateShelve($req->id, $req->name);
            if(!$res) {
                Response::redirectFail( APP_URL . "admin/shelves/arrangements/view?id=".$req->arrangement_id, 500, "Failed to update Shelve");
            }
            Response::redirectSuccess( APP_URL . "admin/shelves/arrangements/view?id=".$req->arrangement_id, 200, "Shelve updated successfully");
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }

    public function books() {
        try {
            $req = $this->getRequest();
            $books = $this->db->getShelveBooks($req->id);
            $shelve = $this->db->getShelve($req->id);
            Response::view("admin/shelves/books", [
                "books" => $books,
                "shelve" => $shelve
            ]);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }
}