<?php 

namespace Src\Entity\Inscripcion\Exception;

use Exception;

final class InscripcionNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro la incripcion correspondiente. Id: ".$id);
    }
}