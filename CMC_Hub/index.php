<?php

$routes = include 'router/routes.php';


function run($requestUri, $routes) {

    $path = parse_url($requestUri, PHP_URL_PATH);
    

    if (array_key_exists($path, $routes)) {

        $routes[$path]();
    } else {

        http_response_code(404);
        require './404.php'; 
    }
}


run($_SERVER['REQUEST_URI'], $routes);
?>
