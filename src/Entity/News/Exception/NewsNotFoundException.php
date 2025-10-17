<?php 

namespace Src\Entity\News\Exception;

use Exception;

final class NewsNotFoundException extends Exception {
    public function __construct() {
        parent::__construct("No se pudo encontrar la noticia.");
    }
}
