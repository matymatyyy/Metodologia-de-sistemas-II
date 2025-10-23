<?php 

namespace Src\Entity\Carrera\Exception;

use Exception;

final class CarreraNotFoundException extends Exception {
    public function __construct(int $id) {
        parent::__construct("No se encontro la carrera correspondiente. Id: ".$id);
    }
}