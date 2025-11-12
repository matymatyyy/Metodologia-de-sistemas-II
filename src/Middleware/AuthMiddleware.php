<?php

namespace Src\Middleware;

use Src\Service\User\UserTokenValidatorService;

readonly class AuthMiddleware {
	private UserTokenValidatorService $tokenValidator;
	public function __construct() {
		$this->tokenValidator = new UserTokenValidatorService();
		$this->validate();
	}
    /**
     * Modo API: valida token desde el header X-API-KEY
     */
		private function validate(): void
		{
			$token = $_SERVER["HTTP_X_API_KEY"] ?? '';
			$this->tokenValidator->validate($token);
		}
		
	 /**
     * Modo Sesión: valida que el usuario esté logueado
     * Si $redirect = true → redirige al login
     * Si $redirect = false → devuelve error JSON
     */
    public static function handleSession(bool $redirect = true): void
    {
        @session_start();

        if (!isset($_SESSION["user"])) {
            if ($redirect) {
                header("Location: /login");
                exit;
            } else {
                http_response_code(401);
                echo json_encode([
                    "success" => false,
                    "error" => "No esta ogueado - debera loguearse."
                ]);
                exit;
            }
        }
    }
}