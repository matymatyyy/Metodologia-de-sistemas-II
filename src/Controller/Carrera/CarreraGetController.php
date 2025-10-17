<?php 

use Src\Middleware\AuthMiddleware;
use Src\Service\Carrera\CarreraFinderService;
use Src\Entity\Carrera\Carrera;

final readonly class CarreraGetController extends AuthMiddleware {
    private CarreraFinderService $service;

    public function __construct() {
        parent::__construct();
        $this->service = new CarreraFinderService();
    }

    public function start(int $id): void 
    {
        $carrera = $this->service->find($id);
     
        echo json_encode([
            'id' => $carrera->id(),
            'titulo' => $carrera->titulo(),
            'duracion' => $carrera->duracion()->format("Y-m-d H:m:s"),
            'cupos' => $carrera->cupos(),
            'activo' => $carrera->activo(),
        ]);
    }
}
