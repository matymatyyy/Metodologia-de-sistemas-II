<?php 

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\Inscripcion\InscripcionDeleterService;

final readonly class InscripcionDeleteController extends AuthMiddleware  {
    private InscripcionDeleterService $service;

    public function __construct() {
        $this->service = new InscripcionDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}
