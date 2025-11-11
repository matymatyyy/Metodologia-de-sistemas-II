<?php

use Src\Entity\Carrera\Carrera;
use Src\Service\Carrera\CarrerasSearcherService;
use Src\Middleware\AuthMiddleware;

final readonly class CarrerasGetController extends AuthMiddleware {
    private CarrerasSearcherService $service;

    public function __construct() {
        $this->service = new CarrerasSearcherService();
    }

    public function start(): void
    {
        $carreras = $this->service->search();
        echo json_encode([
            "data" => array_map($this->toResponse(), $carreras),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function toResponse(): Closure
    {
        return fn (Carrera $carrera): array => [
            'id' => $carrera->id(),
            'titulo' => $carrera->titulo(),
            'duracion' => $carrera->duracion(),
            'fecha_inicio' => $carrera->fechaInicio()->format("Y-m-d"),
            'fecha_fin' => $carrera->fechaFin()->format("Y-m-d"),
            'cupos' => $carrera->cupos(),
            'activo' => $carrera->activo(),
        ];
    }
}