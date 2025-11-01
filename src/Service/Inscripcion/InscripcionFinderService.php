<?php 

declare(strict_types = 1);

namespace Src\Service\Inscripcion;

use Src\Model\Inscripcion\InscripcionModel;
use Src\Entity\Inscripcion\Inscripcion;
use Src\Entity\Inscripcion\Exception\InscripcionNotFoundException;

final readonly class InscripcionFinderService {

    private InscripcionModel $model;

    public function __construct() 
    {
        $this->model = new InscripcionModel();
    }

    public function find(int $id): Inscripcion 
    {
        $inscripcion = $this->model->find($id);

        if ($inscripcion === null) {
            throw new InscripcionNotFoundException($id);
        }

        return $inscripcion;
    }

}

