<?php 

@session_start();

final readonly class UserLogoutController {

    public function __construct() {}

    public function start(): void 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Eliminar solo los datos del usuario
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
        }

        // Si ya no hay datos importantes en la sesión, destruirla por completo
        if (empty($_SESSION)) {
            // Eliminar cookie de sesión
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    '',
                    time() - 42000,
                    $params["path"],
                    $params["domain"],
                    $params["secure"],
                    $params["httponly"]
                );
            }

            // Destruir la sesión
            session_destroy();
        }

        // Si es una petición AJAX → responder en JSON
        if (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest'
        ) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode([
                "success" => true,
                "message" => "Sesión cerrada correctamente"
            ]);
            exit;
        }

        // Si viene desde el navegador → redirigir al login
        header("Location: /login");
        exit;
    }
}
