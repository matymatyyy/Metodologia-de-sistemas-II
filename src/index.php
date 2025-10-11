<?php

require_once dirname(__DIR__).'/html/vendor/autoload.php';

require_once dirname(__DIR__).'/html/app/Router/Routes.php';

require_once dirname(__DIR__).'/html/app/Autoloader/Autoloader.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); 


spl_autoload_register(
    function ($class): void {
        Autoloader::register($class, [
            "src/Services",
            "src/Infrastructure",
            "src/Models",
            "src/Entity"
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