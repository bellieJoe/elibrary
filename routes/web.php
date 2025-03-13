<?php

require_once ROOT_PATH . "controllers/GenreController.php";
require_once ROOT_PATH . "controllers/AuthController.php";
require_once ROOT_PATH . "controllers/BookController.php";
require_once ROOT_PATH . "controllers/ArrangementController.php";
require_once ROOT_PATH . "controllers/ShelveController.php";
require_once ROOT_PATH . "controllers/AdminController.php";
require_once ROOT_PATH . "controllers/SearchController.php";
require_once ROOT_PATH . "controllers/SettingsController.php";

$genreController = new GenreController();
$authController = new AuthController();
$bookController = new BookController();
$arrangementController = new ArrangementController();
$shelveController = new ShelveController();
$adminController = new AdminController();
$searchController = new SearchController();
$settingsController = new SettingsController();

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
        $searchController->index();
        break;
    case 'search':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;
    case 'test':
        echo password_hash("password", PASSWORD_DEFAULT);
        break;

    case "admin":
        Middleware::isAuth(true);
        $adminController->dashboard();
        break;

    /**
     * Settings
     */
    case "admin/settings":
        Middleware::isAuth(true);
        $settingsController->index();
        break;
    case "admin/settings/change-password":
        Middleware::isAuth(true);
        $settingsController->changePassword();
        break;

    /**
     * Auth
     */
    case "login":
        $authController->login();
        break;
    case "logout":
        Middleware::isAuth(true);
        $authController->logout();
        break;
    case "tryLogin":
        $authController->tryLogin();
        break;


    /*
     * Shelves 
     */
    case "admin/shelves":
        include __DIR__ . "/../pages/admin/shelves.php";
        break;
    case "admin/shelves/delete":
        $shelveController->delete();
        break;
    case "admin/shelves/create":
        $shelveController->create();
        break;
    case "admin/shelves/update":
        $shelveController->update();
        break;
    case "admin/shelves/books":
        $shelveController->books();
        break;
    case "admin/shelves/books/remove":
        $shelveController->removeBook();
        break;
    case "admin/shelves/assign-books":
        $shelveController->assignBooks();
        break;
    case "admin/shelves/arrangements":
        $arrangementController->index();
        break;
    case "admin/shelves/arrangements/create":
        $arrangementController->create();
        break;
    case "admin/shelves/arrangements/store":
        $arrangementController->store();
        break;
    case "admin/shelves/arrangements/view":
        $arrangementController->view();
        break;
    case "admin/shelves/arrangements/delete":
        $arrangementController->delete();
        break;
    case "admin/shelves/arrangements/change-map":
        $arrangementController->changeMap();
        break;
    case "admin/shelves/arrangements/activate":
        $arrangementController->activate();
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
    case "admin/genres/edit":
        $genreController->edit();
        break;
    case "admin/genres/update":
        $genreController->update();
        break;
    case "admin/genres/toggle-status":
        $genreController->toggleStatus();
        break;
    
    /*
     * Books 
     */
    case "admin/books":
        $bookController->index();
        break;
    case "admin/books/create":
        $bookController->create();
        break;
    case "admin/books/store":
        $bookController->store();
        break;
    case "admin/books/delete":
        $bookController->delete();
        break;
    case "admin/books/edit":
        $bookController->edit();
        break;
    case "admin/books/update":
        $bookController->update();
        break;
    case "admin/books/toggle-status":
        $bookController->toggleStatus();
        break;

    /**
     * API
     */
    case "api/genres/search":
        $genreController->search();
        break;
    case "api/arrangements/books/unassigned":
        $arrangementController->apiUnassignedBooks();
        break;


    default:
        Response::redirectToError(404);
        break;
}