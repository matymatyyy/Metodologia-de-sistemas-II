<?php 

final readonly class AdminRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "admin_view",
        "url" => "/admin",
        "controller" => "Admin/AdminViewController.php",
        "method" => "GET"
      ],
         
    ];
  }
}