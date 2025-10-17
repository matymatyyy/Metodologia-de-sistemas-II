<?php 

namespace Src\Model\Carrera;

use Src\Model\DatabaseModel;
use Src\Entity\Carrera\Carrera;
use DateTime;

final readonly class CarreraModel extends DatabaseModel {

    public function find(int $id): ?Carrera
    {
        $query = <<<SELECT_QUERY
                    SELECT
                    C.id,
                    C.titulo,
                    C.duracion,
                    C.fecha_inicio,
                    C.fecha_fin,
                    C.cupos,
                    C.activo
                    FROM
                        carreras C
                    WHERE
                    C.id = :id AND C.activo = 1
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toCarrera($result[0] ?? null);
    }

    /** @return Carrera[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                    C.id,
                    C.titulo,
                    C.duracion,
                    C.fecha_inicio,
                    C.fecha_fin,
                    C.cupos,
                    C.activo
                    FROM 
                        carreras C
                    WHERE 
                        C.activo = 1
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toCarrera($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(Carrera $province): void
    {
        $query = <<<INSERT_QUERY
                        INSERT INTO
                            carreras
                        (titulo, duracion, fecha_inicio, fecha_fin, cupos, activo)
                            VALUES
                        (:titulo, :duracion, :fecha_inicio, :fecha_fin, :cupos, :activo)
                    INSERT_QUERY;

        $parameters = [
            "titulo" => $province->titulo(),
            "duracion" => $province->duracion(),
            "fecha_inicio" => $province->fechaInicio()->format("Y-m-d"),
            "fecha_fin" => $province->fechaFin()->format("Y-m-d"),
            "cupos" => $province->cupos(),
            "activo" => $province->activo()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(Carrera $province): void
    {
        $query = <<<UPDATE_QUERY
                    UPDATE
                        carreras
                    SET
                        titulo = :titulo,
                        duracion = :duracion,
                        fecha_inicio = :fecha_inicio,
                        fecha_fin = :fecha_fin,
                        cupos = :cupos,
                        activo = :activo
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "titulo" => $province->titulo(),
            "duracion" => $province->duracion(),
            "fecha_inicio" => $province->fechaInicio()->format("Y-m-d"),
            "fecha_fin" => $province->fechaFin()->format("Y-m-d"),
            "cupos" => $province->cupos(),
            "activo" => $province->activo(),
            "id" => $province->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toCarrera(?array $primitive): ?Carrera
    {
        if ($primitive === null) {
            return null;
        }

        return new Carrera(
            $primitive['id'],
            $primitive['titulo'],
            $primitive['duracion'],
            empty($primitive['fecha_inicio']) ? null : new DateTime($primitive['fecha_inicio']),
            empty($primitive['fecha_fin']) ? null : new DateTime($primitive['fecha_fin']),
            $primitive['cupos'],
            empty($primitive['activo']) ? null : $primitive['activo'],
        );
    }
}