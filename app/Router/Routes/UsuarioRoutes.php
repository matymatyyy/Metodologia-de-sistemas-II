<?php 

final readonly class UsuarioRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "usuario_login",
        "url" => "/usuario",
        "controller" => "User/UserLoginController.php",
        "method" => "POST"
      ]
    ];
  }
}