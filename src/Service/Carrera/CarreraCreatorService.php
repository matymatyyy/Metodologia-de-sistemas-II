<?php 

declare(strict_types = 1);

namespace Src\Service\Carrera;

use DateTime;
use Src\Model\Carrera\CarreraModel;
use Src\Entity\Carrera\Carrera;

final readonly class CarreraCreatorService {

    private CarreraModel $model;

    public function __construct() 
    {
        $this->model = new CarreraModel();
    }

    public function create(string $titulo, string $duracion, DateTime $fecha_inicio, DateTime $fecha_fin, int $cupos, ?int $activo): void 
    {
        $carrera = Carrera::create($titulo, $duracion, $fecha_inicio, $fecha_fin, $cupos, $activo);
        $this->model->insert($carrera);
    }

}

