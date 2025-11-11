<?php 

namespace Src\Model\Contacto;

use DateTime;
use Src\Entity\Contacto\Contacto;
use Src\Model\DatabaseModel;

final readonly class ContactoModel extends DatabaseModel {

    public function insert(Contacto $contacto): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO contacto
                (nombre, email, asunto, mensaje, fecha)
                VALUES
                (:nombre, :email, :asunto, :mensaje, NOW())
                INSERT_QUERY;

        $parameters = [
            "nombre" => $contacto->nombre(),
            "email" => $contacto->email(),
            "asunto" => $contacto->asunto(),
            "mensaje" => $contacto->mensaje()
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function find(int $id): ?Contacto
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.id,
                        C.nombre,
                        C.email,
                        C.asunto,
                        C.mensaje,
                        C.fecha
                    FROM
                        contacto C
                    WHERE
                        C.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toContacto($result[0] ?? null);
    }

    /** @return Contacto[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.id,
                        C.nombre,
                        C.email,
                        C.asunto,
                        C.mensaje,
                        C.fecha
                    FROM 
                        contacto C
                    ORDER BY C.fecha DESC
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toContacto($primitiveResult);
        }

        return $objectResults;
    }

    private function toContacto(?array $primitive): ?Contacto
    {
        if ($primitive === null) {
            return null;
        }

        return new Contacto(
            $primitive['id'],
            $primitive['nombre'],
            $primitive['email'],
            $primitive['asunto'],
            $primitive['mensaje'],
            $primitive['fecha'] ? new DateTime($primitive['fecha']) : null
        );
    }
}