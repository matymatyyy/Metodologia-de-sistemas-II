<?php 

namespace Src\Entity\User;

use DateTime;

final class User {
    public function __construct(
        private readonly ?int $id,
        private string $name,
        private string $email,
        private ?string $password,
        private ?int $habilitado,
        private ?int $activo,
        private ?string $token,
        private ?DateTime $tokenAuthDate
    ) {
    }

    public static function create(
        string $name, 
        string $email, 
        string $password,
        ?string $habilitado,
        ?string $activo,
        ): self {
        return new self(
            null, 
            $name, 
            $email, 
            $password,
            $habilitado,
            $activo,
            null, 
            null);
    }

    public function modify(
        string $name, 
        string $email, 
        ?string $password,
        ?string $habilitado,
        ?string $activo,
        ): void {
        $this->name = $name;
        $this->email = $email;
        //$this->password = password_hash($password, PASSWORD_BCRYPT);
        if ($password !== null) {
            $this->password = $password;
        }
        if ($habilitado !== null) {
            $this->habilitado = $habilitado;
        }
        if ($activo !== null) {
            $this->activo = $activo;
        }
    } 

    public function delete(): void
    {
        $this->activo = 0;
    }   

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): ?string
    {
        return $this->password;
    }

    public function habilitado(): ?int
    {
        return $this->habilitado;
    }

    public function activo(): ?int
    {
        return $this->activo;
    }

    public function token(): ?string
    {
        return $this->token;
    }

    public function tokenAuthDate(): ?DateTime
    {
        return $this->tokenAuthDate;
    }

    public function generateToken(): void
    {
        $this->token = md5($this->id."-".$this->email.rand(1000, 9999).date("YmdHis"));
        $this->tokenAuthDate = new DateTime("+1 hours");
    }
}
