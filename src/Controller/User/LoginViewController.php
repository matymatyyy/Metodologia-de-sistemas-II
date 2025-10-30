<?php

/**
 * CONTROLADOR DE VISTA DE LOGIN - UTN CHACABUCO
 * =============================================
 * 
 * Este controlador maneja las peticiones GET a la ruta /login
 * para mostrar el formulario de inicio de sesión.
 * 
 * RESPONSABILIDADES:
 * - Renderizar la vista de login (src/Views/Login/index.php)
 * - Manejar la carga inicial de la página de login
 * - NO procesa el login (eso lo hace UserLoginController)
 * 
 * RUTA ASOCIADA:
 * - GET /login -> LoginViewController::start()
 * 
 * CONFIGURACIÓN DE RUTA:
 * - Definida en: app/Router/Routes/UsuarioRoutes.php
 * - Nombre: "login_view"
 * - URL: "/login"
 * - Método: "GET"
 * 
 * FLUJO DE EJECUCIÓN:
 * 1. Usuario navega a /login
 * 2. Router detecta ruta GET /login
 * 3. Router instancia LoginViewController
 * 4. Router llama a start()
 * 5. start() llama a parent::call("")
 * 6. ViewController carga src/Views/Login/index.php
 * 7. Se muestra formulario de login al usuario
 * 
 * ARCHIVOS RELACIONADOS:
 * - Vista: src/Views/Login/index.php
 * - CSS: src/Dist/Login/login.css
 * - JS: src/Dist/Login/login.js
 * - Controller de procesamiento: UserLoginController.php
 */

include_once $_SERVER["DOCUMENT_ROOT"].'/src/Controller/ViewController.php';

final readonly class LoginViewController extends ViewController{

    /**
     * CONSTRUCTOR
     * ===========
     * 
     * Configura la ruta de la vista que se va a renderizar.
     * 
     * PARÁMETRO DEL CONSTRUCTOR:
     * - "Login/index" -> se traduce a src/Views/Login/index.php
     * 
     * HERENCIA:
     * - Extiende ViewController que proporciona funcionalidad base
     * - parent::__construct() inicializa la ruta de la vista
     */
    public function __construct(){
        parent::__construct("Login/index");
    }

    /**
     * MÉTODO PRINCIPAL DE EJECUCIÓN
     * =============================
     * 
     * Este método se ejecuta cuando se accede a la ruta /login
     * 
     * FUNCIONAMIENTO:
     * - parent::call("") renderiza la vista especificada en constructor
     * - El parámetro "" indica que no se pasan datos adicionales a la vista
     * - La vista se renderiza con las variables de sesión disponibles
     * 
     * RESULTADO:
     * - Se carga y muestra src/Views/Login/index.php
     * - El usuario ve el formulario de login con todos sus estilos y scripts
     */
    public function start(): void{
        parent::call("");
    }
}