<?php 

declare(strict_types = 1);

namespace Src\Service\Inscripcion;

use DateTime;
use Src\Model\Inscripcion\InscripcionModel;
use Src\Entity\Inscripcion\Inscripcion;

final readonly class InscripcionCreatorService {

    private InscripcionModel $model;

    public function __construct() 
    {
        $this->model = new InscripcionModel();
    }

    public function create(
        int $idCarrera,
        string $nombre,
        string $apellido,
        string $email,
        string $telefono,
        string $dni,
        DateTime $fecha,
        ?int $activo,
    ): void 
    {
        $inscripcion = Inscripcion::create(
            $idCarrera,
            $nombre,
            $apellido,
            $email,
            $telefono,
            $dni,
            $fecha,
            $activo
            );
        $this->model->insert($inscripcion);
    }

}

