<?php

declare(strict_types = 1);

namespace Src\Service\Contacto;

use Src\Entity\Contacto\Contacto;
use Src\Model\Contacto\ContactoModel;

final readonly class ContactoCreatorService {
    private ContactoModel $model;

    public function __construct() {
        $this->model = new ContactoModel();
    }

    public function create(string $nombre, string $email, string $asunto, string $mensaje): void
    {
        $contacto = Contacto::create($nombre, $email, $asunto, $mensaje);

        $this->model->insert($contacto);
    }
}