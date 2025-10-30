<?php 

namespace Src\Model\Inscripcion;

use Src\Model\DatabaseModel;
use Src\Entity\Inscripcion\Inscripcion;
use DateTime;

final readonly class InscripcionModel extends DatabaseModel {

    public function find(int $id): ?Inscripcion
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        I.id,
                        I.id_carrera,
                        I.nombre,
                        I.apellido,
                        I.email,
                        I.telefono,
                        I.dni,
                        I.fecha,
                        I.activo
                    FROM
                        inscripciones I
                    WHERE
                    I.id = :id AND I.activo = 1
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toInscripcion($result[0] ?? null);
    }

    /** @return Inscripcion[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        I.id,
                        I.id_carrera,
                        I.nombre,
                        I.apellido,
                        I.email,
                        I.telefono,
                        I.dni,
                        I.fecha,
                        I.activo
                    FROM 
                        inscripciones I
                    WHERE 
                        I.activo = 1
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toInscripcion($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Inscripcion $inscripcion): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            inscripciones
                        (id_carrera, nombre, apellido, email, telefono, dni, fecha, activo)
                            VALUES
                        (:id_carrera, :nombre, :apellido, :email, :telefono, :dni, :fecha, :activo)
                    INSERT_QUERY;

        $parameters = [
            "id_carrera" => $inscripcion->idCarrera(),
            "nombre" => $inscripcion->nombre(),
            "apellido" => $inscripcion->apellido(),
            "email" => $inscripcion->email(),
            "telefono" => $inscripcion->telefono(),
            "dni" => $inscripcion->dni(),
            "fecha" => $inscripcion->fecha()->format("Y-m-d"),
            "activo" => $inscripcion->activo()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Inscripcion $inscripcion): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        inscripciones
                    SET
                        id_carrera = :id_carrera,
                        nombre = :nombre,
                        apellido = :apellido,
                        email = :email,
                        telefono = :telefono,
                        dni = :dni,
                        fecha = :fecha,
                        activo = :activo
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "id_carrera" => $inscripcion->idCarrera(),
            "nombre" => $inscripcion->nombre(),
            "apellido" => $inscripcion->apellido(),
            "email" => $inscripcion->email(),
            "telefono" => $inscripcion->telefono(),
            "dni" => $inscripcion->dni(),
            "fecha" => $inscripcion->fecha()->format("Y-m-d"),
            "activo" => $inscripcion->activo(),
            "id" => $inscripcion->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toInscripcion(?array $primitive): ?Inscripcion
    {
        if ($primitive === null) {
            return null;
        }

        return new Inscripcion(
            $primitive['id'],
            $primitive['id_carrera'],
            $primitive['nombre'],
            $primitive['apellido'],
            $primitive['email'],
            $primitive['telefono'],
            $primitive['dni'],
            empty($primitive['fecha']) ? null : new DateTime($primitive['fecha']),
            empty($primitive['activo']) ? null : $primitive['activo'],
        );
    }
}