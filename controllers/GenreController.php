<?php

require_once ROOT_PATH . "controllers/Controller.php";

class GenreController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $req = $this->getRequest();
        $page = property_exists($req, "_page") ? $req->_page : 1;
        $name = property_exists($req, "name") ? $req->name : "";
        $code = property_exists($req, "code") ? $req->code : "";
        $genres = $this->db->paginateGenre($name, $code, $page, 10);
        Response::view("admin/genres/genres", [
            "genres" => $genres,
            "_page" => $page
        ]);
    }

    public function create() {
        Response::view("admin/genres/create");
    }

    public function delete() {
        $req = $this->postRequest();

        // check if has books

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
    }

    public function store() {
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
    }
}