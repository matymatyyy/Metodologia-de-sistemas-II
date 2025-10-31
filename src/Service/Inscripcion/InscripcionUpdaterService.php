<?php 

declare(strict_types = 1);

namespace Src\Service\Inscripcion;

use DateTime;
use Src\Model\Inscripcion\InscripcionModel;

final readonly class InscripcionUpdaterService {

    private InscripcionModel $model;
    private InscripcionFinderService $finder;

    public function __construct() 
    {
        $this->model = new InscripcionModel();
        $this->finder = new InscripcionFinderService();
    }

    public function update(
        int $idCarrera,
        string $nombre,
        string $apellido,
        string $email,
        string $telefono,
        int $dni,
        DateTime $fecha,
        ?int $activo,
        int $id
    ): void 
    {
        $inscripcion = $this->finder->find($id);

        $inscripcion->modify(
            $idCarrera,
            $nombre,
            $apellido,
            $email,
            $telefono,
            $dni,
            $fecha,
            $activo
        );

        $this->model->update($inscripcion);
    }

}

