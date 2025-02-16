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

    public function paginateGenre($name = "", $code = "", $page = 1, $limit = 10, $sortBy = null, $sort = null) {
        try {
            $q = "
            SELECT genres.id, genres.name, genres.code, genres.description, COUNT(books.id) AS book_count, genres.is_active FROM genres
            LEFT JOIN books ON books.genre_id = genres.id 
            WHERE genres.name LIKE ? AND genres.code LIKE ? 
            GROUP BY genres.id
            ";

            if($sortBy != null && $sort != null) {
                $q .= " ORDER BY $sortBy $sort";
            }

            $q .= " LIMIT ?, ?";

            $stmt = $this->con->prepare($q);
            
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

    public function countBooksByGenreId($id) {
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM books WHERE genre_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
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

    public function getGenreById($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM genres WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function updateGenre($id, $name, $code, $description) {
        try {
            $stmt = $this->con->prepare("UPDATE genres SET name = ?, code = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $code, $description, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function toggleGenreStatus($id, $status) {
        try {
            $stmt = $this->con->prepare("UPDATE genres SET is_active = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function searchGenre($keyword) {
        try {
            $stmt = $this->con->prepare("SELECT *, name as text FROM genres WHERE name LIKE ? OR code LIKE ?");
            $stmt->execute(["%$keyword%", "%$keyword%"]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    /**
     * USERS
     */
    public function getUserByUsername($username) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }    
    }

    /**
     * BOOKS
     */
    public function paginateBook($name = "", $author = "", $page = 1, $limit = 10, $sortBy = null, $sort = null) {
        try {
            $q = "
            SELECT books.id, books.name, books.author, books.description, books.is_active, genres.name AS genre FROM books
            LEFT JOIN genres ON genres.id = books.genre_id
            WHERE books.name LIKE ? AND books.author LIKE ? 
            GROUP BY books.id
            ";

            if($sortBy != null && $sort != null) {
                $q .= " ORDER BY $sortBy $sort";
            }

            $q .= " LIMIT ?, ?";

            $stmt = $this->con->prepare($q);
            
            // Bind parameters correctly
            $stmt->bindValue(1, "%$name%", PDO::PARAM_STR);
            $stmt->bindValue(2, "%$author%", PDO::PARAM_STR);
            $stmt->bindValue(3, ($page - 1) * $limit, PDO::PARAM_INT);
            $stmt->bindValue(4, $limit, PDO::PARAM_INT);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ); // Fetch as objects
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function storeBook($name, $author, $genre, $description){
        try {
            $stmt = $this->con->prepare("INSERT INTO books (name, author, genre_id, description) VALUES (?, ?, ?, ?)");
            $stmt->execute([$name, $author, $genre, $description]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function deleteBook($id) {
        try {
            $stmt = $this->con->prepare("DELETE FROM books WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getBookById($id) {
        try {
            $stmt = $this->con->prepare("SELECT books.*, genres.name AS genre FROM books LEFT JOIN genres ON genres.id = books.genre_id WHERE books.id = ? ");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function updateBook($id, $name, $author, $genre, $description) {
        try {
            $stmt = $this->con->prepare("UPDATE books SET name = ?, author = ?, genre_id = ?, description = ? WHERE id = ?");
            $stmt->execute([$name, $author, $genre, $description, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }
}