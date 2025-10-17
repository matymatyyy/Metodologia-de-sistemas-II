<?php 

/**
 * RUTAS DE USUARIO - SISTEMA DE LOGIN UTN CHACABUCO
 * =================================================
 * 
 * Este archivo define las rutas relacionadas con la autenticación 
 * de usuarios del panel administrativo.
 * 
 * RUTAS DISPONIBLES:
 * 
 * 1. GET /login - Muestra el formulario de login
 *    - Controller: LoginViewController.php
 *    - Vista: src/Views/Login/index.php
 *    - Función: Renderizar la página de inicio de sesión
 * 
 * 2. POST /usuario - Procesa el login del usuario
 *    - Controller: UserLoginController.php  
 *    - Función: Validar credenciales y crear sesión
 *    - Respuesta: Redirección o respuesta JSON (AJAX)
 * 
 * FLUJO DE AUTENTICACIÓN:
 * 1. Usuario visita /login (GET)
 * 2. LoginViewController muestra formulario
 * 3. Usuario envía datos a /usuario (POST)
 * 4. UserLoginController valida credenciales
 * 5. Si es correcto: redirección a /admin
 * 6. Si es incorrecto: vuelta a /login con error
 * 
 * INTEGRACIÓN CON EL ROUTER:
 * - Estas rutas se cargan automáticamente en Routes.php
 * - El Router.php se encarga de dirigir las peticiones
 * - Los middlewares pueden agregarse en cada ruta si es necesario
 */

final readonly class UsuarioRoutes {
  /**
   * OBTENER CONFIGURACIÓN DE RUTAS
   * ==============================
   * 
   * Retorna un array con todas las rutas de usuario configuradas.
   * Cada ruta tiene: name, url, controller, method
   * 
   * @return array Array de configuraciones de rutas
   */
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
        "controller" => "User/UserLoginController.php",
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
      [
        "name" => "login_view",           // Nombre interno de la ruta
        "url" => "/login",                // URL que verá el usuario
        "controller" => "User/LoginViewController.php", // Controlador que maneja GET
        "method" => "GET"                 // Método HTTP
      ],
      [
        "name" => "usuario_login_post",   // Nombre interno para login POST
        "url" => "/usuario",              // URL de destino del formulario
        "controller" => "User/UserLoginController.php", // Controlador que procesa login
        "method" => "POST"                // Método HTTP para envío de formulario
      ]
    ];
  }
}