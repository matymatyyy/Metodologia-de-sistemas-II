<?php 

namespace Src\Entity\Carrera;
use DateTime;

final class Carrera {

    public function __construct(
        private readonly ?int $id,
        private string $titulo,
        private DateTime $fecha_inicio,
        private DateTime $fecha_fin,
        private int $cupos,
        private ?int $activo,
    ) {
    }

    public static function create(
        string $titulo,
        DateTime $fecha_inicio,
        DateTime $fecha_fin,
        int $cupos,
        ?int $activo,
    ): self
    {
        $activo = $activo ?? 1;
        return new self(null, $titulo, $fecha_inicio, $fecha_fin, $cupos, $activo);
    }

    public function modify(
        string $titulo,
        DateTime $fecha_inicio,
        DateTime $fecha_fin,
        int $cupos,
        ?int $activo
    ): void
    {
        $this->titulo = $titulo;
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->cupos = $cupos;
        if ($activo !== null) {
            $this->activo = $activo;
        }
    } 

    public function delete(): void {$this->activo = 0;}
    
    public function id(): ?int {return $this->id;}

    public function titulo(): string {return $this->titulo;}

    public function fechaInicio(): DateTime {return $this->fecha_inicio;}

    public function fechaFin(): DateTime {return $this->fecha_fin;}

    public function cupos(): int {return $this->cupos;}

    public function activo(): ?int {return $this->activo;}

}