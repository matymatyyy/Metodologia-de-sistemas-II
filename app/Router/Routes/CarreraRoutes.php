<?php 

final readonly class CarreraRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "carrera_get",
        "url" => "/carreras",
        "controller" => "Carrera/CarreraGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "carreras_get",
        "url" => "/carreras",
        "controller" => "Carrera/CarrerasGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "carrera_create",
        "url" => "/carreras",
        "controller" => "Carrera/CarreraPostController.php",
        "method" => "POST",
      ],
      [
        "name" => "carrera_update",
        "url" => "/carreras",
        "controller" => "Carrera/CarreraPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "carrera_delete",
        "url" => "/carreras",
        "controller" => "Carrera/CarreraDeleteController.php",
        "method" => "DELETE",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ] ,     
      [
        "name" => "carrera_view",
        "url" => "/admin/carreras",
        "controller" => "Carrera/CarreraViewController.php",
        "method" => "GET"
      ],
    ];
  }
}
