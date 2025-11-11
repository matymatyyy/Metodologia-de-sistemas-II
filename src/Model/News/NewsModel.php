<?php 

namespace Src\Model\News;

use DateTime;
use Src\Entity\News\News;
use Src\Model\DatabaseModel;

final readonly class NewsModel extends DatabaseModel {

    public function find(int $id): ?News
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        N.id,
                        N.titulo,
                        N.descripcion,
                        N.texto,
                        N.fecha,
                        N.imagen
                    FROM
                        noticias N
                    WHERE
                        N.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toNews($result[0] ?? null);
    }

    /** @return News[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        N.id,
                        N.titulo,
                        N.descripcion,
                        N.texto,
                        N.fecha,
                        N.imagen
                    FROM 
                        noticias N
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toNews($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(News $news): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO noticias
                (titulo, descripcion, texto, fecha, imagen)
                VALUES
                (:titulo, :descripcion, :texto, :fecha, :imagen)
                INSERT_QUERY;

        $parameters = [
            "titulo" => $news->title(),
            "descripcion" => $news->description(),
            "texto" => $news->text(),
            "fecha" => $news->publicationDate()?->format("Y-m-d"),
            "imagen" => $news->image()
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function update(News $news): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        noticias
                    SET
                        titulo = :titulo,
                        descripcion = :descripcion,
                        texto = :texto,
                        fecha = :fecha,
                        imagen = :imagen
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'titulo' => $news->title(),
            'descripcion' => $news->description(),
            'texto' => $news->text(),
            'fecha' => $news->publicationDate()?->format("Y-m-d"),
            'imagen' => $news->image(),
            'id' => $news->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        noticias
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toNews(?array $primitive): ?News
    {
        if ($primitive === null) {
            return null;
        }

        return new News(
            $primitive['id'],
            $primitive['titulo'],
            $primitive['descripcion'],
            $primitive['texto'],
            $primitive['fecha'] ? new DateTime($primitive['fecha']) : null,
            $primitive['imagen']
        );
    }
}