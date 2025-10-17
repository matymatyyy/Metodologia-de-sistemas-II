<?php 

declare(strict_types = 1);

namespace Src\Service\carrera;

use DateTime;
use Src\Model\carrera\carreraModel;

final readonly class carreraUpdaterService {

    private carreraModel $model;
    private carreraFinderService $finder;

    public function __construct() 
    {
        $this->model = new carreraModel();
        $this->finder = new carreraFinderService();
    }

    public function update(
        string $titulo,
        DateTime $duracion, 
        int $cupos, 
        ?int $activo, 
        int $id
    ): void 
    {
        $carrera = $this->finder->find($id);

        $carrera->modify($titulo, $duracion, $cupos, $activo);

        $this->model->update($carrera);
    }

}

