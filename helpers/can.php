<?php

class Can {
    public static function deleteGenre(Database $db, $id, $url = APP_URL . "admin/genres") {
        $count = $db->countBooksByGenreId($id);
        if($count->count > 0) {
            Response::redirectFail($url, 500, "Genre cannot be deleted because it has books.");
            return false;
            exit();
        }
        return true;
    }
}