<?php 

declare(strict_types = 1);

namespace Src\Service\Carrera;

use Src\Model\Carrera\CarreraModel;
use Src\Entity\Carrera\Carrera;
use Src\Entity\Carrera\Exception\CarreraNotFoundException;

final readonly class CarreraFinderService {

    private CarreraModel $model;

    public function __construct() 
    {
        $this->model = new CarreraModel();
    }

    public function find(int $id): Carrera 
    {
        $carrera = $this->model->find($id);

        if ($carrera === null) {
            throw new CarreraNotFoundException($id);
        }

        return $carrera;
    }

}

