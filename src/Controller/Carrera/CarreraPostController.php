<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\Carrera\CarreraCreatorService;

final readonly class CarreraPostController extends AuthMiddleware {
    private CarreraCreatorService $service;

    public function __construct() {
        $this->service = new CarreraCreatorService();
    }

    public function start(): void 
    {
        $titulo = ControllerUtils::getPost("titulo");
        $duracion = ControllerUtils::getPost("duracion");
        $fecha_inicio  = new \DateTime(ControllerUtils::getPost("fecha_inicio"));
        $fecha_fin  = new \DateTime(ControllerUtils::getPost("fecha_fin"));
        $cupos = (int) ControllerUtils::getPost("cupos");
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->create($titulo, $duracion, $fecha_inicio, $fecha_fin, $cupos, $activo);
    }
}