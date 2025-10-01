<?php 

final readonly class UsuarioRoutes {
  public static function getRoutes(): array {
    return [
      [
        "name" => "usuario_login_view",
        "url" => "/usuario",
        "controller" => "Usuario/UsuarioLoginViewController.php",
        "method" => "GET"
      ],
      [
        "name" => "usuario_login",
        "url" => "/usuario/login",
        "controller" => "Usuario/UsuarioLoginController.php",
        "method" => "POST"
      ],
      [
        "name" => "usuario_logout",
        "url" => "/usuario/logout",
        "controller" => "Usuario/UsuarioLogoutController.php",
        "method" => "GET"
      ],
      [
        "name" => "usuario_panel_view",
        "url" => "/usuario/panel",
        "controller" => "Usuario/UsuarioPanelViewController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "page",
            "type" => "int"
          ]
        ]
      ],
         
    ];
  }
}