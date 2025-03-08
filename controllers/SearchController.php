<?php

require_once ROOT_PATH . "controllers/Controller.php";

class SearchController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        try {
            $req = $this->getRequest();
            $_page = property_exists($req, "_page") ? $req->_page : 1;
            $search = property_exists($req, "search") ? $req->search : "";

            $books = $this->db->search($search);
            Response::view("index", [
                "books" => $books,
                "_page" => $_page
            ]);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }
}