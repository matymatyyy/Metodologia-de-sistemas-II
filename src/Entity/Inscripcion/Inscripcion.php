<?php 

namespace Src\Entity\Inscripcion;
use DateTime;

final class Inscripcion {

    public function __construct(
        private readonly ?int $id,
        private int $idCarrera,
        private string $nombre,
        private string $apellido,
        private string $email,
        private string $telefono,
        private int $dni,
        private DateTime $fecha,
        private ?int $activo,
    ) {
    }

    public static function create(
        int $idCarrera,
        string $nombre,
        string $apellido,
        string $email,
        string $telefono,
        string $dni,
        DateTime $fecha,
        ?int $activo,
    ): self
    {
        $activo = $activo ?? 1;
        return new self(
            null,
            $idCarrera,
            $nombre,
            $apellido,
            $email,
            $telefono,
            $dni,
            $fecha,
            $activo
        );
    }

    public function modify(
        int $idCarrera,
        string $nombre,
        string $apellido,
        string $email,
        string $telefono,
        int $dni,
        DateTime $fecha,
        ?int $activo,
    ): void
    {
        $this->idCarrera = $idCarrera;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->dni = $dni;
        $this->fecha = $fecha;
        if ($activo !== null) {
            $this->activo = $activo;
        }
    } 

    public function delete(): void {$this->activo = 0;}
    
    public function id(): ?int 
    {
        return $this->id;
    }

    public function idCarrera(): int 
    {
        return $this->idCarrera;
    }

    public function nombre(): string 
    {
        return $this->nombre;
    }
        public function apellido(): string 
    {
        return $this->apellido;
    }

    public function email(): string 
    {
        return $this->email;
    }

    public function telefono(): string 
    {
        return $this->telefono;
    }
    
    public function dni(): int 
    {
        return $this->dni;
    }

    public function fecha(): DateTime 
    {
        return $this->fecha;
    }
    
    public function activo(): ?int 
    {
        return $this->activo;
    }

}