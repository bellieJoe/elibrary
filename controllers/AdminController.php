<?php

require_once ROOT_PATH . "controllers/Controller.php";

class AdminController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function dashboard() {
        try {
            $bookCount = $this->db->countBooks();
            $genreCount = $this->db->countGenres();
            $arrangementCount = $this->db->countArrangements();
            $unassignedBooks = $this->db->countUnassignedBooks();
            Response::view("admin/dashboard", [
                "bookCount" => $bookCount,
                "genreCount" => $genreCount,
                "arrangementCount" => $arrangementCount,
                "unassignedBooks" => $unassignedBooks
            ]);
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

}