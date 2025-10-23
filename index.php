<?php

// Validacion para externos
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, x-api-key");


if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once dirname(__DIR__).'/html/vendor/autoload.php';

require_once dirname(__DIR__).'/html/app/Router/Routes.php';

require_once dirname(__DIR__).'/html/app/Autoloader/Autoloader.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); 


spl_autoload_register(
    function ($class): void {
        Autoloader::register($class, [
            "src/Service",
            "src/Infrastructure",
            "src/Middleware",
            "src/Model",
            "src/Entity",
            "src/Utils"
        ]);
    }
);

@session_start();


$router = startRouter();


$url = $_SERVER["REQUEST_URI"];

try {
    
    $router->resolve(
        $url,
        $_SERVER['REQUEST_METHOD']
    );
} catch (Exception $e) {   
    
    header("HTTP/1.0 404 Not Found");
    echo json_encode([
        "status" => 404,
        "message"=> $e->getMessage()
    ]);
}