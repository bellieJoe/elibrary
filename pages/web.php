<?php

// Get the current request URI
$requestUri = trim($_SERVER['REQUEST_URI'], '/');

// Remove "elibrary" from the URL (assuming "elibrary" is the project folder)
$uri = str_replace("elibrary/", "", $requestUri);


echo "test";

switch ($uri) {
    case 'search':
        include __DIR__ . "/../pages/"."$uri".".php";
        break;
    
    default:
        # code...
        break;
}