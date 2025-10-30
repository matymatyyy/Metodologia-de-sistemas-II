<?php 

namespace Src\Service\Inscripcion;

use Src\Entity\Inscripcion\Inscripcion;
use Src\Model\Inscripcion\InscripcionModel;

final readonly class InscripcionesSearcherService {
    private InscripcionModel $inscripcionModel;

    public function __construct() {
        $this->inscripcionModel = new InscripcionModel();
    }

    /** @return Inscripcion[] */
    public function search(): array
    {
        return $this->inscripcionModel->search();
    }
}