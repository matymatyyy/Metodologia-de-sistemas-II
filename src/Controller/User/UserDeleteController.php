<?php 

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\User\UserDeleterService;

final readonly class UserDeleteController extends AuthMiddleware  {
    private UserDeleterService $service;

    public function __construct() {
        // parent::__construct();
        $this->service = new UserDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
