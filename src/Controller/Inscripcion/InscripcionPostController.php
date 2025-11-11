<?php 

use Src\Utils\ControllerUtils;
use Src\Middleware\AuthMiddleware;
use Src\Service\Inscripcion\InscripcionCreatorService;

final readonly class InscripcionPostController extends AuthMiddleware {
    private InscripcionCreatorService $service;

    public function __construct() {
        $this->service = new InscripcionCreatorService();
    }

    public function start(): void 
    {
        $idCarrera = ControllerUtils::getPost("id_carrera");
        $nombre = ControllerUtils::getPost("nombre");
        $apellido  = ControllerUtils::getPost("apellido");
        $email  = ControllerUtils::getPost("email");
        $telefono  = ControllerUtils::getPost("telefono");
        $dni = (int) ControllerUtils::getPost("dni");
        $fecha  = new \DateTime(ControllerUtils::getPost("fecha"));
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->create(
        $idCarrera,
        $nombre, 
        $apellido,
        $email,
        $telefono,
        $dni,
        $fecha,
        $activo
        );
    }
}