<?php 

use Src\Utils\ControllerUtils;
use Src\Service\User\UserUpdaterService;
use Src\Middleware\AuthMiddleware;

final readonly class UserPutController extends AuthMiddleware {
    private UserUpdaterService $service;

    public function __construct() {
        $this->service = new UserUpdaterService();
    }

    public function start(int $id): void 
    {
        $name = ControllerUtils::getPost("name");
        $email  = ControllerUtils::getPost("email");
        $password  = ControllerUtils::getPost("password");
        
        $this->service->update(
        $name,
        $email, 
        $password,
        $id
        );
    }
}
