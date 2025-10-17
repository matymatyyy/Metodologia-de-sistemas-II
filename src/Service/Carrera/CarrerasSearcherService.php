<?php 

namespace Src\Service\Carrera;

use Src\Entity\Carrera\Carrera;
use Src\Model\Carrera\CarreraModel;

final readonly class CarrerasSearcherService {
    private CarreraModel $carreraModel;

    public function __construct() {
        $this->carreraModel = new CarreraModel();
    }

    /** @return Carrera[] */
    public function search(): array
    {
        return $this->carreraModel->search();
    }
}