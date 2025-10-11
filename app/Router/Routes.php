<?php 

include_once "Route.php";
include_once "Router.php";

function startRouter(): Router 
{
    $routes = [];

    include_once "Routes/UsuarioRoutes.php";
    $routes = array_merge($routes, UsuarioRoutes::getRoutes());
    include_once "Routes/HomeRoutes.php";
    $routes = array_merge($routes, HomeRoutes::getRoutes());

    $routesClass = [];
    foreach ($routes as $route) {
        $routesClass[] = Route::fromArray($route);
    }

    return new Router($routesClass);
}