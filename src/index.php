<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . "/../app/Router/Routes.php";

try {
    $router = startRouter();

    $url = $_SERVER['REQUEST_URI'];
    $method = $_SERVER['REQUEST_METHOD'];

    $router->resolve($url, $method);
} catch (Exception $e) {
    http_response_code(404);
    echo "<h1>Error 404</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    echo "<pre>URL: " . htmlspecialchars($url ?? 'N/A') . "</pre>";
    echo "<pre>Method: " . htmlspecialchars($method ?? 'N/A') . "</pre>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
}
