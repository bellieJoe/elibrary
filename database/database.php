<?php

class Database {
    private $con;
    public function __construct()
    {
        try {
            $this->con = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USERNAME, DB_PASSWORD);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->con->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            Response::redirectToError(500);
        }
    }


    /**
     * GENRES
     */
    public function storeGenre($name, $code, $description){
        try {
            $stmt = $this->con->prepare("INSERT INTO genres (name, code, description) VALUES (?, ?, ?)");
            $stmt->execute([$name, $code, $description]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function paginateGenre($name = "", $code = "", $page = 1, $limit = 10) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM genres WHERE name LIKE ? AND code LIKE ? LIMIT ?, ?");
            
            // Bind parameters correctly
            $stmt->bindValue(1, "%$name%", PDO::PARAM_STR);
            $stmt->bindValue(2, "%$code%", PDO::PARAM_STR);
            $stmt->bindValue(3, ($page - 1) * $limit, PDO::PARAM_INT);
            $stmt->bindValue(4, $limit, PDO::PARAM_INT);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ); // Fetch as objects
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function deleteGenre($id) {
        try {
            $stmt = $this->con->prepare("DELETE FROM genres WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }
}