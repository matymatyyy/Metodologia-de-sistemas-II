<?php 

final readonly class InscripcionRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "inscripcion_get",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "inscripciones_get",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionesGetController.php",
        "method" => "GET"
      ],
      [
        "name" => "inscripcion_create",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionPostController.php",
        "method" => "POST",
      ],
      [
        "name" => "inscripcion_update",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ],
      [
        "name" => "inscripcion_delete",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionDeleteController.php",
        "method" => "DELETE",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int"
          ]
        ]
      ] ,     
      [
        "name" => "inscripcion_view",
        "url" => "/inscripciones",
        "controller" => "Inscripcion/InscripcionViewController.php",
        "method" => "GET"
      ],
    ];
  }
}
