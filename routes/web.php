<?php

// Get the current request URI
$requestUri = trim($_SERVER['REQUEST_URI'], '/');

// Remove "elibrary" from the URL (assuming "elibrary" is the project folder)
$uri = str_replace("elibrary/", "", $requestUri);



switch ($uri) {
    case "home":
        include __DIR__ . "/../pages/index.php";
        break;
    case 'search':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;
    case 'test':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;
    
    default:
    include __DIR__ . "/../pages/errors/404.php";
    break;
}