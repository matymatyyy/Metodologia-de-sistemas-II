<?php 

declare(strict_types = 1);

namespace Src\Service\Carrera;

use Src\Model\Carrera\CarreraModel;

final readonly class CarreraDeleterService {

    private CarreraModel $model;
    private CarreraFinderService $finder;

    public function __construct() 
    {
        $this->model = new CarreraModel();
        $this->finder = new CarreraFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $carrera = $this->finder->find($id);

        $carrera->delete();

        $this->model->update($carrera);
    }

}

