<?php 

use Src\Service\Inscripcion\InscripcionFinderService;
final readonly class InscripcionGetController {
    private InscripcionFinderService $service;

    public function __construct() {
        $this->service = new InscripcionFinderService();
    }

    public function start(int $id): void 
    {
        $inscripcion = $this->service->find($id);
     
        echo json_encode([
            'id' => $inscripcion->id(),
            "id_carrera" => $inscripcion->idCarrera(),
            "nombre" => $inscripcion->nombre(),
            "apellido" => $inscripcion->apellido(),
            "email" => $inscripcion->email(),
            "telefono" => $inscripcion->telefono(),
            "dni" => $inscripcion->dni(),
            "fecha" => $inscripcion->fecha()->format("Y-m-d"),
            "activo" => $inscripcion->activo()
        ]);
    }
}
