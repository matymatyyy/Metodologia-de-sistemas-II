<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserLoginService;
use Src\Entity\User\Exception\UserNotFoundException;

/**
 * CONTROLADOR DE LOGIN PARA EL PANEL ADMINISTRATIVO
 * =================================================
 * 
 * Este controlador maneja la autenticación de usuarios para acceder al panel de administración.
 * Soporta tanto peticiones AJAX (para una experiencia fluida) como formularios tradicionales.
 * 
 * FUNCIONAMIENTO:
 * 1. Si la petición es AJAX → Responde con JSON (error o éxito)
 * 2. Si la petición es tradicional → Muestra página de éxito o redirige con error
 * 
 * RUTAS RELACIONADAS:
 * - GET /login → Muestra la página de login (LoginViewController)
 * - POST /usuario → Procesa el login (este controlador)
 * 
 * USUARIOS DISPONIBLES:
 * - admin@utn.edu.ar / admin123
 * - secretaria@utn.edu.ar / secretaria123
 * 
 * @author Tu Nombre
 * @version 1.0
 */
final readonly class UserLoginController {
    private UserLoginService $service;

    public function __construct() {
        $this->service = new UserLoginService();
    }

    /**
     * MÉTODO PRINCIPAL DEL CONTROLADOR
     * ================================
     * 
     * Detecta automáticamente si la petición es AJAX o tradicional:
     * - AJAX: Responde con JSON para mostrar errores en tiempo real
     * - Tradicional: Muestra páginas completas con redirect
     */
    public function start(): void 
    {
        // DETECCIÓN AUTOMÁTICA DE PETICIONES AJAX
        // Si el frontend envía X-Requested-With: XMLHttpRequest, es AJAX
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            $this->handleAjaxLogin();
            return;
        }
        
        // PROCESAMIENTO TRADICIONAL (FALLBACK)
        // Para navegadores que no soporten JavaScript o peticiones directas
        try {
            // OBTENER DATOS DEL FORMULARIO
            // Los datos vienen por POST desde el formulario de login
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // VALIDACIÓN BÁSICA DE CAMPOS REQUERIDOS
            if (empty($email) || empty($password)) {
                $_SESSION['login_error'] = "Por favor complete todos los campos.";
                header("Location: http://localhost:8080/login");
                exit;
            }
            
            // AUTENTICACIÓN DEL USUARIO
            // El service valida email/password contra la base de datos
            $user = $this->service->login($email, $password);
            
            // Login exitoso - guardar sesión (sin iniciarla ya que está iniciada)
            $_SESSION['user_token'] = $user->token();
            $_SESSION['user_id'] = $user->id();
            $_SESSION['user_email'] = $user->email();
            $_SESSION['user_name'] = $user->name();
            
            // Mostrar página de éxito con diseño igual al login
            $userName = htmlspecialchars($user->name());
            echo "<!DOCTYPE html>
            <html lang='es'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
                <title>Acceso Concedido - UTN Chacabuco</title>
                <link rel='icon' type='image/x-icon' href='/src/Dist/Image/UTN_logo.jpg'>
                <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css' rel='stylesheet'>
                <link href='https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap' rel='stylesheet'>
                <style>
                    * { margin: 0; padding: 0; box-sizing: border-box; }
                    body { 
                        font-family: 'Inter', sans-serif; 
                        background: #0f172a;
                        height: 100vh; 
                        overflow: hidden;
                        position: relative;
                        color: #ffffff;
                    }
                    .particles-container {
                        display: none; /* Ocultar partículas para look limpio */
                    }
                    .background-overlay {
                        display: none; /* Quitar overlay para look más limpio */
                    }
                    .success-container {
                        position: relative; z-index: 3; height: 100vh; display: flex; align-items: center; justify-content: center;
                    }
                    .success-card {
                        background: rgba(255, 255, 255, 0.15);
                        backdrop-filter: blur(20px);
                        border-radius: 25px;
                        padding: 50px 40px;
                        border: 1px solid rgba(255, 255, 255, 0.2);
                        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.1);
                        text-align: center;
                        max-width: 450px;
                        width: 90%;
                        animation: cardEnter 0.8s ease-out;
                    }
                    @keyframes cardEnter {
                        from { opacity: 0; transform: translateY(30px) scale(0.9); }
                        to { opacity: 1; transform: translateY(0) scale(1); }
                    }
                    .logo-container {
                        position: relative; margin-bottom: 25px;
                    }
                    .utn-logo {
                        width: 80px; height: 80px; border-radius: 50%; object-fit: cover;
                        border: 3px solid rgba(255,255,255,0.3); animation: logoGlow 2s ease-in-out infinite alternate;
                    }
                    @keyframes logoGlow {
                        from { box-shadow: 0 0 20px rgba(255,255,255,0.3); }
                        to { box-shadow: 0 0 30px rgba(255,255,255,0.6); }
                    }
                    .success-icon {
                        font-size: 4rem; color: #2ecc71; margin-bottom: 20px;
                        animation: successBounce 1.2s ease-out;
                    }
                    @keyframes successBounce {
                        0%, 20%, 60%, 100% { transform: translateY(0); }
                        40% { transform: translateY(-15px); }
                        80% { transform: translateY(-8px); }
                    }
                    h1 { color: white; font-size: 2rem; font-weight: 600; margin-bottom: 10px; text-shadow: 0 2px 10px rgba(0,0,0,0.2); }
                    .subtitle { color: rgba(255,255,255,0.9); font-size: 1.1rem; margin-bottom: 30px; font-weight: 300; }
                    .user-welcome { color: rgba(255,255,255,0.8); font-size: 1rem; margin-bottom: 25px; }
                    .progress-container { margin: 25px 0; }
                    .progress-bar {
                        width: 100%; height: 6px; background: rgba(255,255,255,0.2); border-radius: 3px; overflow: hidden;
                    }
                    .progress-fill {
                        height: 100%; background: linear-gradient(90deg, #2ecc71, #27ae60); border-radius: 3px;
                        animation: progress 2s ease-out;
                    }
                    @keyframes progress { from { width: 0%; } to { width: 100%; } }
                    .redirect-text {
                        color: rgba(255,255,255,0.7); font-size: 0.9rem; margin-top: 15px;
                    }
                    .copyright {
                        display: none; /* Quitar footer en pantalla de carga */
                    }
                </style>
            </head>
            <body>
                <div class='particles-container' id='particles'></div>
                <div class='background-overlay'></div>
                
                <div class='success-container'>
                    <div class='success-card'>
                        <div class='logo-container'>
                            <img src='/src/Dist/Image/UTN_logo.jpg' alt='UTN Logo' class='utn-logo'>
                        </div>
                        
                        <div class='success-icon'>
                            <i class='fas fa-check-circle'></i>
                        </div>
                        
                        <h1>UTN Chacabuco</h1>
                        <p class='subtitle'>Acceso Autorizado</p>
                        <p class='user-welcome'>Bienvenido/a, <strong>$userName</strong></p>
                        
                        <div class='progress-container'>
                            <div class='progress-bar'>
                                <div class='progress-fill'></div>
                            </div>
                            <p class='redirect-text'>Redirigiendo al Panel Administrativo...</p>
                        </div>
                    </div>
                </div>
                
                <div class='copyright'>© 2025 Universidad Tecnológica Nacional</div>
                
                <script>
                    // Redirect automático sin partículas para look limpio
                    setTimeout(function() {
                        window.location.href = 'http://localhost:8080/admin';
                    }, 2500);
                </script>
            </body>
            </html>";
            exit;
            
        } catch (UserNotFoundException $e) {
            // ❌ CREDENCIALES INCORRECTAS
            // Usuario no encontrado o contraseña incorrecta
            $_SESSION['login_error'] = "Credenciales incorrectas. Verifique su email y contraseña.";
            header("Location: http://localhost:8080/login");
            exit;
        } catch (Exception $e) {
            // ❌ ERROR DEL SISTEMA
            // Cualquier otro error inesperado
            $_SESSION['login_error'] = "Error del sistema. Inténtelo nuevamente.";
            header("Location: http://localhost:8080/login");
            exit;
        }
    }
    
    /**
     * MANEJO DE PETICIONES AJAX
     * =========================
     * 
     * Este método se ejecuta cuando el frontend envía peticiones AJAX.
     * Permite mostrar errores en tiempo real sin recargar la página.
     * 
     * RESPUESTAS JSON:
     * - Éxito: {"success": true, "user": "Nombre Usuario"}
     * - Error: {"error": "Mensaje de error"} + HTTP status code
     */
    private function handleAjaxLogin(): void
    {
        try {
            // OBTENER DATOS DEL FORMULARIO VIA AJAX
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // VALIDACIÓN DE CAMPOS REQUERIDOS
            if (empty($email) || empty($password)) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Por favor complete todos los campos']);
                exit;
            }
            
            // AUTENTICACIÓN DEL USUARIO
            $user = $this->service->login($email, $password);
            
            // ✅ LOGIN EXITOSO VIA AJAX
            // Crear sesión y responder con éxito
            $_SESSION['user_token'] = $user->token();
            $_SESSION['user_id'] = $user->id();
            $_SESSION['user_email'] = $user->email();
            $_SESSION['user_name'] = $user->name();
            
            // Respuesta JSON de éxito
            echo json_encode(['success' => true, 'user' => $user->name()]);
            exit;
            
        } catch (UserNotFoundException $e) {
            // ❌ CREDENCIALES INCORRECTAS VIA AJAX
            http_response_code(401); // Unauthorized
            echo json_encode(['error' => 'Credenciales incorrectas. Verifique su email y contraseña.']);
            exit;
        } catch (Exception $e) {
            // ❌ ERROR DEL SISTEMA VIA AJAX
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => 'Error del sistema. Inténtelo nuevamente.']);
            exit;
        }
    }
}
