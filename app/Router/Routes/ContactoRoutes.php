<?php 

final readonly class ContactoRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "contacto_view",
        "url" => "/contacto",
        "controller" => "Contacto/ContactoViewController.php",
        "method" => "GET"
      ],
      [
        "name" => "contacto_post",
        "url" => "/contacto",
        "controller" => "Contacto/ContactoPostController.php",
        "method" => "POST"
      ]
    ];
  }
}