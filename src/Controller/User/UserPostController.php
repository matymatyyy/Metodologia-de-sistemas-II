<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\User\UserCreatorService;

final readonly class UserPostController extends AuthMiddleware {
    private UserCreatorService $service;

    public function __construct() {
        $this->service = new UserCreatorService();
    }

    public function start(): void 
    {
        $name = ControllerUtils::getPost("name");
        $email  = ControllerUtils::getPost("email");
        $password  = ControllerUtils::getPost("password");
        $habilitado  = ControllerUtils::getPost("habilitado", false);
        $activo  = ControllerUtils::getPost("activo", false);
        
        $this->service->create(
        $name,
        $email, 
        $password,
        $habilitado,
        $activo,
        );
    }
}