<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserLoginService;

@session_start();

final readonly class UserLoginController {
    private UserLoginService $service;

    public function __construct() {
        $this->service = new UserLoginService();
    }

    public function start(): void 
    {
        try {
            $email = ControllerUtils::getPost("email");
            $password = ControllerUtils::getPost("password");

            $user = $this->service->login($email, $password);

            // Guardar usuario en la sesión
            $_SESSION["user"] = [
                "id" => $user->id(),
                "name" => $user->name(),
                "email" => $user->email(),
                "habilitado" => $user->habilitado(),
                "activo" => $user->activo(),
                "token" => $user->token(),
                "token_auth_date" => $user->tokenAuthDate()->format("Y-m-d H:i:s")
            ];

            echo json_encode([
                "success" => true,
                "user" => $_SESSION["user"]
            ]);

        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }

}
