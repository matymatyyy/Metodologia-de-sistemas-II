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
        $duracion  = new \DateTime(ControllerUtils::getPost("duracion"));
        $cupos = (int) ControllerUtils::getPost("cupos");
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->create($titulo, $duracion, $cupos, $activo);
    }
}