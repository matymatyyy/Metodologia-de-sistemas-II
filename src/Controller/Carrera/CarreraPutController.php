<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Carrera\CarreraUpdaterService;
use Src\Middleware\AuthMiddleware;

final readonly class CarreraPutController extends AuthMiddleware {
    private CarreraUpdaterService $service;

    public function __construct() {
        $this->service = new CarreraUpdaterService();
    }

    public function start(int $id): void 
    {
        $titulo = ControllerUtils::getPost("titulo");
        $duracion  = new \DateTime(ControllerUtils::getPost("duracion"));
        $cupos = (int) ControllerUtils::getPost("cupos");
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->update($titulo, $duracion, $cupos, $activo, $id);
    }
}
