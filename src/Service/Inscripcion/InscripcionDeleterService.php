<?php 

declare(strict_types = 1);

namespace Src\Service\Inscripcion;

use Src\Model\Inscripcion\InscripcionModel;

final readonly class InscripcionDeleterService {

    private InscripcionModel $model;
    private InscripcionFinderService $finder;

    public function __construct() 
    {
        $this->model = new InscripcionModel();
        $this->finder = new InscripcionFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $inscripcion = $this->finder->find($id);

        $inscripcion->delete();

        $this->model->update($inscripcion);
    }

}

