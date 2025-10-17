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

    public function create(string $titulo, DateTime $duracion, int $cupos, ?int $activo): void 
    {
        $carrera = Carrera::create($titulo, $duracion, $cupos, $activo);
        $this->model->insert($carrera);
    }

}

