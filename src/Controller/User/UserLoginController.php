<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserLoginService;

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

            echo json_encode([
                "success" => true,
                "token" => $user->token(),
                "token_auth_date" => $user->tokenAuthDate()->format("Y-m-d H:i:s"),
                "user" => [
                    "id" => $user->id(),
                    "name" => $user->name(),
                    "email" => $user->email(),
                ]
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
