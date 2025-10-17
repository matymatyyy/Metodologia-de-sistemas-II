<?php 

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Carrera\CarreraDeleterService;

final readonly class CarreraDeleteController extends AuthMiddleware  {
    private CarreraDeleterService $service;

    public function __construct() {
        $this->service = new CarreraDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
