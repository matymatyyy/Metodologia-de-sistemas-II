<?php 

include_once "Route.php";
include_once "Router.php";

function startRouter(): Router 
{
    $routes = [];

    $routes = array_merge($routes, );

    $routesClass = [];
    foreach ($routes as $route) {
        $routesClass[] = Route::fromArray($route);
    }

    return new Router($routesClass);
}