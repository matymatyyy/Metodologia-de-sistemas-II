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
                    C.cupos
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
                    C.cupos
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
                        (titulo, duracion, cupos, activo)
                            VALUES
                        (:titulo, :duracion, :cupos, :activo)
                    INSERT_QUERY;

        $parameters = [
            "titulo" => $province->titulo(),
            "duracion" => $province->duracion()->format("Y-m-d H:i:s"),
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
                        cupos = :cupos,
                        activo = :activo
                    WHERE
                        id = :id
                    UPDATE_QUERY;
            
        $parameters = [
            "titulo" => $province->titulo(),
            "duracion" => $province->duracion()->format("Y-m-d H:i:s"),
            "cupos" => $province->cupos(),
            "activo" => $province->activo()
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
            empty($primitive['duracion']) ? null : new DateTime($primitive['duracion']),
            $primitive['cupos'],
            empty($primitive['activo']) ? null : $primitive['activo'],
        );
    }
}