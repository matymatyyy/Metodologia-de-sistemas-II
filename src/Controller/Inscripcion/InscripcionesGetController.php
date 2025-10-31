<?php

use Src\Entity\Inscripcion\Inscripcion;
use Src\Service\Inscripcion\InscripcionesSearcherService;
use Src\Middleware\AuthMiddleware;

final readonly class InscripcionesGetController extends AuthMiddleware {
    private InscripcionesSearcherService $service;

    public function __construct() {
        $this->service = new InscripcionesSearcherService();
    }

    public function start(): void
    {
        $inscripciones = $this->service->search();
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