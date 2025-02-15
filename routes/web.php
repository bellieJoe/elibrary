<?php

require_once ROOT_PATH . "controllers/GenreController.php";

$genreController = new GenreController();

// // Get the current request URI
// $requestUri = trim($_SERVER['REQUEST_URI'], '/');

// // Remove "elibrary" from the URL (assuming "elibrary" is the project folder)
// $uri = str_replace("elibrary/", "", $requestUri);

// Get the current request URI and remove query parameters
$requestUri = explode("?", $_SERVER['REQUEST_URI'])[0];
$requestUri = ltrim($requestUri, '/');

// Dynamically get the project folder name
$projectFolder = basename(ROOT_PATH);

// Remove project folder from URI if applicable
$uri = str_replace("$projectFolder/", "", $requestUri);




switch ($uri) {
    case "":
    case null:
        include __DIR__ . "/../pages/index.php";
        break;
    case 'search':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;
    case 'test':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;

    case "login":
        include __DIR__ . "/../pages/auth/login.php";
        break;
    case "admin":
        include __DIR__ . "/../pages/admin/dashboard.php";
        break;


    /*
     * Shelves 
     */
    case "admin/shelves":
        include __DIR__ . "/../pages/admin/shelves.php";
        break;

    /*
     * Genres 
     */
    case "admin/genres":
        $genreController->index();
        break;
    case "admin/genres/create":
        $genreController->create();
        break;
    case "admin/genres/store":
        $genreController->store();
        break;
    case "admin/genres/delete":
        $genreController->delete();
        break;
    

    
    default:
        Response::redirectToError(404);
        break;
}