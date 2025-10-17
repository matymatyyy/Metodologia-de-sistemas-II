<?php 

declare(strict_types = 1);

namespace Src\Service\carrera;

use DateTime;
use Src\Model\carrera\CarreraModel;

final readonly class carreraUpdaterService {

    private CarreraModel $model;
    private CarreraFinderService $finder;

    public function __construct() 
    {
        $this->model = new CarreraModel();
        $this->finder = new CarreraFinderService();
    }

    public function update(
        string $titulo,
        DateTime $fecha_inicio, 
        DateTime $fecha_fin, 
        int $cupos, 
        ?int $activo, 
        int $id
    ): void 
    {
        $carrera = $this->finder->find($id);

        $carrera->modify($titulo, $fecha_inicio, $fecha_fin, $cupos, $activo);

        $this->model->update($carrera);
    }

}

