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
        $fecha_inicio  = new \DateTime(ControllerUtils::getPost("fecha_inicio"));
        $fecha_fin  = new \DateTime(ControllerUtils::getPost("fecha_fin"));
        $cupos = (int) ControllerUtils::getPost("cupos");
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->update($titulo, $fecha_inicio, $fecha_fin, $cupos, $activo, $id);
    }
}
