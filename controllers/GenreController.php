<?php

require_once ROOT_PATH . "controllers/Controller.php";

class GenreController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->getRequest();
            $page = property_exists($req, "_page") ? $req->_page : 1;
            $name = property_exists($req, "name") ? $req->name : "";
            $code = property_exists($req, "code") ? $req->code : "";
            $sortBy = property_exists($req, "sortBy") ? $req->sortBy : null;
            $sort = property_exists($req, "sort") ? $req->sort : null;
            $genres = $this->db->paginateGenre($name, $code, $page, 10, $sortBy, $sort);
            Response::view("admin/genres/genres", [
                "genres" => $genres,
                "_page" => $page
            ]);
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function create() {
        try {
            Middleware::isAuth(true);
            Response::view("admin/genres/create");
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function delete() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->postRequest();
    
            Can::deleteGenre($this->db, $req->id);
    
            $res = $this->db->deleteGenre($req->id);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/genres",
                    500,
                    "Unexpected error occured while deleting the genre."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/genres",
                200,
                "Genre deleted successfully"
            );
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function store() {
        try {
            Middleware::isAuth(true);
            $req = $this->postRequest();
            $res = $this->db->storeGenre($req->name, $req->code, $req->description);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/genres/create",
                    500,
                    "Unexpected error occured while saving the genre."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/genres",
                200,
                "Genre created successfully"
            );
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function edit() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->getRequest();
    
            $genre = $this->db->getGenreById($req->id);
    
            Response::view("admin/genres/edit", [
                "genre" => $genre
            ]);
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function update() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->postRequest();
    
            $res = $this->db->updateGenre($req->id, $req->name, $req->code, $req->description);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/genres/edit/" . $req->id,
                    500,
                    "Unexpected error occured while updating the genre."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/genres",
                200,
                "Genre updated successfully"
            );

        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function toggleStatus(){
        try {
            Middleware::isAuth(true);
    
            $req = $this->postRequest();
    
            $res = $this->db->toggleGenreStatus($req->id, $req->status);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/genres",
                    500,
                    "Unexpected error occured while updating the genre status."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/genres",
                200,
                "Genre status updated successfully"
            );
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function search() {
        try {
            $req = $this->getRequest();
            $keyword = property_exists($req, "keyword") ? $req->keyword : null;
            $genres = $this->db->searchGenre($keyword);
            echo json_encode($genres);
            exit();
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }
}