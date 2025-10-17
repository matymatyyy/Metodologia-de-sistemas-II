<?php 

namespace Src\Entity\Carrera;
use DateTime;

final class Carrera {

    public function __construct(
        private readonly ?int $id,
        private string $titulo,
        private DateTime $duracion,
        private int $cupos,
        private ?int $activo,
    ) {
    }

    public static function create(
        string $titulo,
        DateTime $duracion,
        int $cupos,
        ?int $activo,
    ): self
    {
        $activo = $activo ?? 1;
        return new self(null, $titulo, $duracion, $cupos, $activo);
    }

    public function modify(
        string $titulo,
        DateTime $duracion,
        int $cupos,
        ?int $activo
    ): void
    {
        $this->titulo = $titulo;
        $this->duracion = $duracion;
        $this->cupos = $cupos;
        if ($activo !== null) {
            $this->activo = $activo;
        }
    } 

    public function delete(): void {$this->activo = 0;}
    
    public function id(): ?int {return $this->id;}

    public function titulo(): string {return $this->titulo;}

    public function duracion(): DateTime {return $this->duracion;}

    public function cupos(): int {return $this->cupos;}

    public function activo(): ?int {return $this->activo;}

}