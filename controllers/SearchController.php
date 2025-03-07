<?php

require_once ROOT_PATH . "controllers/Controller.php";

class SearchController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index(){
        try {
            //code...
        } catch (Exception $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500); 
        }
    }
}