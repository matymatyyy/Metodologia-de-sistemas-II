<?php 

final readonly class AdminRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "admin_view",
        "url" => "/admin/home",
        "controller" => "Admin/AdminViewController.php",
        "method" => "GET"
      ],
      [
        "name" => "inscripcion_view",
        "url" => "/admin/inscripciones",
        "controller" => "Admin/InscripcionAdminViewController.php",
        "method" => "GET"
      ],
    ];
  }
}