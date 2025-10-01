<?php 

include_once "Route.php";
include_once "Router.php";

function startRouter(): Router 
{
    $routes = [];

    include_once "Routes/UsuarioRoutes.php";
    $routes = array_merge($routes, UsuarioRoutes::getRoutes());

    include_once "Routes/AdminRoutes.php";
    $routes = array_merge($routes, AdminRoutes::getRoutes());


    $routesClass = [];
    foreach ($routes as $route) {
        $routesClass[] = Route::fromArray($route);
    }

    return new Router($routesClass);
}