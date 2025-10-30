<?php 

final readonly class HomeRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "home_view",
        "url" => "/",
        "controller" => "Home/HomeViewController.php",
        "method" => "GET"
      ],
         
    ];
  }
}