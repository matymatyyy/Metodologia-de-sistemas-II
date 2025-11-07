<?php

namespace Src\Entity\Contacto;

use DateTime;

final class Contacto {

    public function __construct(
        private readonly ?int $id,
        private string $nombre,
        private string $email,
        private string $asunto,
        private string $mensaje,
        private ?DateTime $fecha
    ) {}

    public static function create(
        string $nombre,
        string $email,
        string $asunto,
        string $mensaje
    ): self {
        return new self(
            null,
            $nombre,
            $email,
            $asunto,
            $mensaje,
            null // La fecha se setea automáticamente en la DB
        );
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function asunto(): string
    {
        return $this->asunto;
    }

    public function mensaje(): string
    {
        return $this->mensaje;
    }

    public function fecha(): ?DateTime
    {
        return $this->fecha;
    }
}