<?php 

use Src\Utils\ControllerUtils;
use Src\Service\Inscripcion\InscripcionUpdaterService;
use Src\Middleware\AuthMiddleware;

final readonly class InscripcionPutController extends AuthMiddleware {
    private InscripcionUpdaterService $service;

    public function __construct() {
        $this->service = new InscripcionUpdaterService();
    }

    public function start(int $id): void 
    {
        $idCarrera = ControllerUtils::getPost("id_carrera");
        $nombre = ControllerUtils::getPost("nombre");
        $apellido  = ControllerUtils::getPost("apellido");
        $email  = ControllerUtils::getPost("email");
        $telefono  = ControllerUtils::getPost("telefono");
        $dni = (int) ControllerUtils::getPost("dni");
        $fecha  = new \DateTime(ControllerUtils::getPost("fecha"));
        $activo = (int) ControllerUtils::getPost("activo", false);
        
        $this->service->update(
        $idCarrera,
        $nombre, 
        $apellido,
        $email,
        $telefono,
        $dni,
        $fecha,
        $activo,
        $id
        );
    }
}
