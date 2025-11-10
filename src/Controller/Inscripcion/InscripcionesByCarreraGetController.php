<?php

use Src\Entity\Inscripcion\Inscripcion;
use Src\Service\Inscripcion\InscripcionesSearcherService;
use Src\Middleware\AuthMiddleware;

final readonly class InscripcionesByCarreraGetController extends AuthMiddleware {

    private InscripcionesSearcherService $service;

    public function __construct() {
        $this->service = new InscripcionesSearcherService();
    }

    // <-- recibir el id como INT
    public function start(int $id): void
    {
        $idCarrera = $_GET['id'] ?? 0;

        if ($idCarrera <= 0) {
            http_response_code(400);
            echo json_encode([
                "error" => "id es requerido y debe ser válido"
            ]);
            return;
        }

        $inscripciones = $this->service->searchByCarrera($idCarrera);

        echo json_encode([
            "data" => array_map($this->toResponse(), $inscripciones),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function toResponse(): Closure
    {
        return fn (Inscripcion $inscripcion): array => [
            'id' => $inscripcion->id(),
            "id_carrera" => $inscripcion->idCarrera(),
            "nombre" => $inscripcion->nombre(),
            "apellido" => $inscripcion->apellido(),
            "email" => $inscripcion->email(),
            "telefono" => $inscripcion->telefono(),
            "dni" => $inscripcion->dni(),
            "fecha" => $inscripcion->fecha()->format("Y-m-d"),
            "activo" => $inscripcion->activo()
        ];
    }
}

