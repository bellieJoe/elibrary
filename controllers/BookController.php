<?php

require_once ROOT_PATH . "controllers/Controller.php";

class BookController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->getRequest();
            $page = property_exists($req, "_page") ? $req->_page : 1;
            $name = property_exists($req, "name") ? $req->name : "";
            $author = property_exists($req, "author") ? $req->author : "";
            $sortBy = property_exists($req, "sortBy") ? $req->sortBy : null;
            $sort = property_exists($req, "sort") ? $req->sort : null;
            $books = $this->db->paginateBook($name, $author, $page, 10, $sortBy, $sort);
            Response::view("admin/books/books", [
                "books" => $books,
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
            Response::view("admin/books/create");
        } catch (Exception $e) {
            Response::redirectToError(500);
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
        }
    }

    public function delete() {
        try {
            Middleware::isAuth(true);
    
            $req = $this->postRequest();

            // optional check if can delete
    
            $res = $this->db->deleteBook($req->id);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/books",
                    500,
                    "Unexpected error occured while deleting the book."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/books",
                200,
                "Book deleted successfully"
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
            $res = $this->db->storeBook($req->name, $req->author, $req->genre, $req->description);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/books/create",
                    500,
                    "Unexpected error occured while saving the book."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/books",
                200,
                "Book created successfully"
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
    
            $book = $this->db->getBookById($req->id);
    
            Response::view("admin/books/edit", [
                "book" => $book
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
    
            $res = $this->db->updateBook($req->id, $req->name, $req->author, $req->genre, $req->description);
            if(!$res) {
                Response::redirectFail(
                    APP_URL . "admin/books/edit/" . $req->id,
                    500,
                    "Unexpected error occured while updating the book."
                );
            }
            Response::redirectSuccess(
                APP_URL . "admin/books",
                200,
                "Book updated successfully"
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
}