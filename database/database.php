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
            $stmt = $this->con->prepare("SELECT *, name as text FROM genres WHERE (name LIKE ? OR code LIKE ?) AND is_active = 1");
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
    public function paginateBook($name = "", $author = "", $genre_id = "", $page = 1, $limit = 10, $sortBy = null, $sort = null) {
        try {
            $q = "
            SELECT books.id, books.name, books.author, books.description, books.is_active, genres.name AS genre FROM books
            LEFT JOIN genres ON genres.id = books.genre_id
            WHERE books.name LIKE ? AND books.author LIKE ?AND books.genre_id LIKE ?
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
            $stmt->bindValue(3, "%$genre_id%", PDO::PARAM_STR);
            $stmt->bindValue(4, ($page - 1) * $limit, PDO::PARAM_INT);
            $stmt->bindValue(5, $limit, PDO::PARAM_INT);
    
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

    public function toggleBookStatus($id, $status) {
        try {
            $stmt = $this->con->prepare("UPDATE books SET is_active = ? WHERE id = ?");
            $stmt->execute([$status, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getUnassignedBooks($arrangement_id, $search) {
        try {
            $stmt = $this->con->prepare("
            SELECT 
                `books`.*, 
                `genres`.`name` AS `genre`, 
                `locations`.`id` AS `location_id`, 
                `arrangements`.`id` AS `arra_id`
            FROM `books` 
            LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
            LEFT JOIN `shelves` ON `locations`.`shelve_id` = `shelves`.`id`
            LEFT JOIN `arrangements` ON `arrangements`.`id` = `shelves`.`arrangement_id`
            LEFT JOIN `genres` ON `genres`.`id` = `books`.`genre_id`
            WHERE 
                (`locations`.`id` IS NULL OR `shelves`.`id` IS NULL) 
                AND (`arrangements`.`id` IS NULL OR `arrangements`.`id` <> ?)
                AND (`books`.`name` LIKE ? OR `genres`.`name` LIKE ?)
                AND `books`.`is_active` = 1
            ORDER BY `books`.`genre_id` ASC, `books`.`name` ASC;
            ");
            $stmt->bindValue(1, $arrangement_id, PDO::PARAM_INT);
            $stmt->bindValue(2, "%$search%", PDO::PARAM_STR);
            $stmt->bindValue(3, "%$search%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }


    /**
     * ARRANGEMENTS
     */
    public function storeArrangement($name, $description, $map, $shelves){
        try {
            $this->con->beginTransaction();

            $stmt = $this->con->prepare("INSERT INTO arrangements (name, description, map) VALUES (?, ?, ?)");
            $stmt->execute([$name, $description, $map]);
            $insertedId = $this->con->lastInsertId();

            $placeholders = implode(',', array_fill(0, count($shelves), '(?, ?)'));
            $values = [];
            foreach ($shelves as $shelve) {
                $values[] = $insertedId;
                $values[] = $shelve;
            }
            $stmt = $this->con->prepare("INSERT INTO shelves (arrangement_id, name) VALUES $placeholders");
            $stmt->execute($values);

            $this->con->commit();
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function paginateArrangement($name = "", $page = 1, $limit = 10, $sortBy = null, $sort = null) {
        try {
            $q = "
            SELECT arrangements.id, arrangements.name, arrangements.description, arrangements.map, arrangements.is_active, COUNT(shelves.id) AS shelve_count FROM arrangements
            LEFT JOIN shelves ON shelves.arrangement_id = arrangements.id 
            WHERE arrangements.name LIKE ? 
            GROUP BY arrangements.id
            ";

            if($sortBy != null && $sort != null) {
                $q .= " ORDER BY $sortBy $sort";
            }

            $q .= " LIMIT ?, ?";

            $stmt = $this->con->prepare($q);
            
            $stmt->bindValue(1, "%$name%", PDO::PARAM_STR);
            $stmt->bindValue(2, ($page - 1) * $limit, PDO::PARAM_INT);
            $stmt->bindValue(3, $limit, PDO::PARAM_INT);
    
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function changeMap($id, $map) {
        try {
            $stmt = $this->con->prepare("UPDATE arrangements SET map = ? WHERE id = ?");
            $stmt->execute([$map, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getArrangementById($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM arrangements WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function deleteArrangement($id) {
        try {
            $this->con->beginTransaction();
            $stmt = $this->con->prepare("DELETE FROM arrangements WHERE id = ?");
            $stmt2 = $this->con->prepare("SELECT id FROM shelves WHERE arrangement_id = ?");
            $stmt2->execute([$id]);
            $shelves = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            $shelves_id = array_map(function($arr) {
                return $arr['id'];
            }, $shelves);
            if (!empty($shelves_id)) {
                $placeholders = implode(',', array_fill(0, count($shelves_id), '?'));
                $stmt3 = $this->con->prepare("DELETE FROM locations WHERE shelve_id IN ($placeholders)");
                $stmt3->execute($shelves_id);
            }
            $stmt->execute([$id]);
            $this->con->commit();
            return true;
        } catch (PDOException $e) {
            $this->con->rollBack();
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function activateArrangement($id){
        try {
            $this->con->beginTransaction();
            $stmt = $this->con->prepare("UPDATE arrangements SET is_active = 0");
            $stmt->execute();
            $stmt = $this->con->prepare("UPDATE arrangements SET is_active = 1 WHERE id = ?");
            $stmt->execute([$id]);
            $this->con->commit();
            return true;
        } catch (PDOException $e) {
            $this->con->rollBack();
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);   
        }
    }

    public function getActiveArrangement() {
        try {
            $stmt = $this->con->prepare("SELECT * FROM arrangements WHERE is_active = 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); 
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }
    

    /**
     * SHELVES
     */
    public function getShelvesByArrangementId($id) {
        try {
            $stmt = $this->con->prepare("
                SELECT shelves.id, shelves.name, shelves.arrangement_id, shelves.is_active, 
                       arrangements.map AS map, arrangements.name AS arrangement, 
                       COUNT(locations.id) AS books_count 
                FROM shelves
                LEFT JOIN arrangements ON arrangements.id = shelves.arrangement_id
                LEFT JOIN locations ON locations.shelve_id = shelves.id
                WHERE shelves.arrangement_id = ?
                GROUP BY shelves.id, shelves.name, shelves.arrangement_id, shelves.is_active, 
                         arrangements.map, arrangements.name
            ");
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }
    

    public function deleteShelve($id) {
        try {
            $this->con->beginTransaction();
            $stmt = $this->con->prepare("DELETE FROM shelves WHERE id = ?");
            $stmt->execute([$id]);
            $stmt2 = $this->con->prepare("DELETE FROM locations WHERE shelve_id = ?");
            $stmt2->execute([$id]);
            $this->con->commit();
            return true;
        } catch (PDOException $e) {
            $this->con->rollBack();
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function createShelve($arrangement_id, $name){
        try {
            $stmt = $this->con->prepare("INSERT INTO shelves (name, arrangement_id) VALUES(?,?);");
            $stmt->execute([$name, $arrangement_id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function updateShelve($id, $name) {
        try {
            $stmt = $this->con->prepare("UPDATE shelves SET name = ? WHERE id = ?");
            $stmt->execute([$name, $id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getShelveBooks($id) {
        try {
            $stmt = $this->con->prepare("SELECT locations.*, books.name, books.is_active FROM locations LEFT JOIN books ON locations.book_id = books.id WHERE locations.shelve_id = ?");
            $stmt->execute([$id]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getShelve($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM shelves WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function removeBookFromShelve($id) {
        try {
            $stmt = $this->con->prepare("DELETE FROM locations WHERE id = ?");
            $stmt->execute([$id]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    /**
     *  LOCATIONS
    */
    public function assignBooksToShelve($shelve_id, $book_ids){
        try {
            $this->con->beginTransaction();

            $placeholders = implode(',', array_fill(0, count($book_ids), '(?, ?)'));
            $values = [];
            foreach ($book_ids as $book) {
                $values[] = $shelve_id;
                $values[] = $book;
            }
            $stmt = $this->con->prepare("INSERT INTO locations (shelve_id, book_id) VALUES $placeholders");
            $stmt->execute($values);

            $this->con->commit();
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getLocationById($id) {
        try {
            $stmt = $this->con->prepare("SELECT * FROM locations WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    /**
     * DASHBOARD QUERIES
     */
    public function countBooks(){
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM books WHERE is_active = 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function countShelves(){
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM shelves WHERE is_active = 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function countArrangements(){
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM arrangements");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function countGenres(){
        try {
            $stmt = $this->con->prepare("SELECT COUNT(*) AS count FROM genres WHERE is_active = 1");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ); // Fetch as object
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function countUnassignedBooks()
    {
        try {
            // Fetch active arrangement
            $stmt = $this->con->prepare("SELECT * FROM `arrangements` WHERE `is_active` = 1 LIMIT 1;");
            $stmt->execute();
            $arrangement = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$arrangement) {
                return 0; // No active arrangement found, return 0
            }

            // Fetch active shelves for the arrangement
            $stmt = $this->con->prepare("SELECT id FROM `shelves` WHERE `is_active` = 1 AND `arrangement_id` = ?;");
            $stmt->execute([$arrangement->id]);
            $shelves = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($shelves)) {
                return 0; // No shelves found, return 0
            }

            // Generate placeholders for `IN (?)`
            $placeholders = implode(',', array_fill(0, count($shelves), '?'));

            // Prepare and execute the query for counting unassigned books
            $stmt = $this->con->prepare("
                SELECT COUNT(*) AS count FROM `books` 
                LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
                WHERE 
                    (`locations`.`shelve_id` NOT IN ($placeholders) OR
                    `locations`.`id` IS NULL) AND
                    `books`.`is_active` = 1;
            ");
            
            $stmt->execute($shelves);
            return $stmt->fetch(PDO::FETCH_OBJ);
            
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function countUnassignedBooksByArrangementId($id)
    {
        try {
            // Fetch active arrangement
            $stmt = $this->con->prepare("SELECT id FROM `arrangements` WHERE `id` = ? AND `is_active` = 1 LIMIT 1;");
            $stmt->execute([$id]);
            $arrangement = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$arrangement) {
                return 0; // No active arrangement found, return 0
            }

            // Fetch active shelves for the arrangement
            $stmt = $this->con->prepare("SELECT id FROM `shelves` WHERE `is_active` = 1 AND `arrangement_id` = ?;");
            $stmt->execute([$arrangement->id]);
            $shelves = $stmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($shelves)) {
                // If no shelves exist, count all books with no assigned location
                $stmt = $this->con->prepare("
                    SELECT COUNT(*) AS count FROM `books` 
                    LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
                    WHERE `locations`.`id` IS NULL AND `books`.`is_active` = 1;
                ");
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_OBJ)->count ?? 0;
            }

            // Generate placeholders for `IN (?)`
            $placeholders = implode(',', array_fill(0, count($shelves), '?'));

            // Prepare and execute the query for counting unassigned books
            $stmt = $this->con->prepare("
                SELECT COUNT(*) AS count FROM `books` 
                LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
                WHERE 
                    (`locations`.`shelve_id` IS NULL OR `locations`.`shelve_id` NOT IN ($placeholders))
                    AND `books`.`is_active` = 1;
            ");
            
            $stmt->execute($shelves);
            return $stmt->fetch(PDO::FETCH_OBJ)->count ?? 0;
            
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function search($search, $page = 1, $limit = 10) {
        try {
            // Fetch active arrangement
            $stmt = $this->con->prepare("SELECT id FROM `arrangements` WHERE `is_active` = 1 LIMIT 1;");
            $stmt->execute();
            $arrangement = $stmt->fetch(PDO::FETCH_OBJ);
    
            if (!$arrangement) {
                return []; // No active arrangement found, return empty result
            }
    
            // Fetch active shelves for the arrangement
            $stmt = $this->con->prepare("SELECT id FROM `shelves` WHERE `is_active` = 1 AND `arrangement_id` = ?;");
            $stmt->execute([$arrangement->id]);
            $shelves = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
            // If no shelves exist, count all books with no assigned location
            if (empty($shelves)) {
                $stmt = $this->con->prepare("
                    SELECT COUNT(*) AS count FROM `books` 
                    LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
                    WHERE `locations`.`id` IS NULL AND `books`.`is_active` = 1;
                ");
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_OBJ)->count ?? 0;
            }
    
            // Create named placeholders like :shelf1, :shelf2, :shelf3
            $shelfPlaceholders = [];
            $shelfParams = [];
            foreach ($shelves as $index => $shelf) {
                $paramName = ":shelf" . $index;
                $shelfPlaceholders[] = $paramName;
                $shelfParams[$paramName] = $shelf;
            }
    
            // Construct the SQL query
            $sql = "
                SELECT books.*, genres.name AS genre, locations.shelve_id AS shelve_id, shelves.name AS shelve_name 
                FROM `books` 
                LEFT JOIN `locations` ON `locations`.`book_id` = `books`.`id`
                LEFT JOIN `shelves` ON `shelves`.`id` = `locations`.`shelve_id`
                LEFT JOIN `genres` ON `genres`.`id` = `books`.`genre_id`
                WHERE 
                    `books`.`is_active` = 1
                    AND (`books`.`name` LIKE :search
                    OR `genres`.`name` LIKE :search
                    OR `books`.`author` LIKE :search)
            ";
    
            // If shelves exist, add condition to filter by shelf ID
            if (!empty($shelves)) {
                $sql .= " AND (`locations`.`shelve_id` IN (" . implode(',', $shelfPlaceholders) . "))";
            }
    
            $sql .= " LIMIT :offset, :limit;";
    
            $stmt = $this->con->prepare($sql);
    
            // Bind shelf IDs
            foreach ($shelfParams as $paramName => $value) {
                $stmt->bindValue($paramName, $value, PDO::PARAM_INT);
            }
    
            // Bind search parameters
            $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
    
            // Bind LIMIT and OFFSET
            $offset = ($page - 1) * $limit;
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
    
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function getTopGenreChartData() {
        try {
            // Fetch top 5 genres
            $stmt = $this->con->prepare("
                SELECT genres.name AS genre, COUNT(*) AS count 
                FROM books 
                LEFT JOIN genres ON genres.id = books.genre_id 
                WHERE books.is_active = 1 
                GROUP BY genres.name 
                ORDER BY count DESC 
                LIMIT 5;
            ");
            $stmt->execute();
            $topGenres = $stmt->fetchAll(PDO::FETCH_OBJ);
    
            // Fetch the count of remaining genres (others)
            $stmt = $this->con->prepare("
                SELECT COUNT(*) AS count 
                FROM books 
                LEFT JOIN genres ON genres.id = books.genre_id 
                WHERE books.is_active = 1 
                AND genres.name NOT IN (
                    SELECT name FROM (
                        SELECT genres.name 
                        FROM books 
                        LEFT JOIN genres ON genres.id = books.genre_id 
                        WHERE books.is_active = 1 
                        GROUP BY genres.name 
                        ORDER BY COUNT(*) DESC 
                        LIMIT 5
                    ) AS top_genres
                );
            ");
            $stmt->execute();
            $othersCount = $stmt->fetch(PDO::FETCH_OBJ)->count ?? 0;
    
            // Add "Others" category if there are remaining books
            if ($othersCount > 0) {
                $topGenres[] = (object) ['genre' => 'Others', 'count' => $othersCount];
            }
    
            return $topGenres;
    
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }

    public function changePassword($password) {
        try {
            $stmt = $this->con->prepare("UPDATE users SET password = ? WHERE id = 1");
            $stmt->execute([$password]);
            return true;
        } catch (PDOException $e) {
            Misc::logError($e->getMessage(), __FILE__, __LINE__);
            Response::redirectToError(500);
        }
    }
    
    
}