<?php 

namespace Src\Model\User;

use DateTime;
use Src\Entity\User\User;
use Src\Model\DatabaseModel;

final readonly class UserModel extends DatabaseModel {

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT U.* FROM usuarios U WHERE U.email = :email
                SELECT_QUERY;
        
        $result = $this->primitiveQuery($query, ['email' => $email]);
        $user = $this->toUser($result[0] ?? null); 
        
        if ($user === null) {
            return null;
        }
        
        if (hash('sha256', $password) === $user->password()) {
            return $user;
        }
        
        return null;
    }

    public function findByToken(string $token): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        U.*
                    FROM
                        usuarios U
                    WHERE
                        U.token = :token AND :date <= U.token_auth_date
                SELECT_QUERY;

        $parameters = [
            'token' => $token,
            'date' => date("Y-m-d H:i:s")
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toUser($result[0] ?? null);
    }

    public function find(int $id): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        U.id,
                        U.nombre,
                        U.email,
                        U.contraseña,
                        U.token,
                        U.token_auth_date
                    FROM
                        usuarios U
                    WHERE
                        U.id = :id
                SELECT_QUERY;

        $parameters = [
            'id' => $id
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        return $this->toUser($result[0] ?? null);
    }

    /** @return User[] */
    public function search(): array
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        C.id,
                        C.nombre,
                        C.email,
                        C.contraseña,
                        C.token,
                        C.token_auth_date
                    FROM 
                        usuarios C
                SELECT_QUERY;

        $primitiveResults = $this->primitiveQuery($query);

        $objectResults = [];
        
        foreach ($primitiveResults as $primitiveResult) {
            $objectResults[] = $this->toUser($primitiveResult);
        }

        return $objectResults;
    }

    public function insert(User $user): void
    {
        $query = <<<INSERT_QUERY
                INSERT INTO usuarios
                (nombre, email, contraseña, token, token_auth_date)
                VALUES
                (:nombre, :email, :contraseña, :token, :tokenAuthDate)
                INSERT_QUERY;

        $parameters = [
            "nombre" => $user->name(),
            "email" => $user->email(),
            "contraseña" => $user->password(),
            "token" => $user->token(),
            "tokenAuthDate" => $user->tokenAuthDate()?->format("Y-m-d H:i:s")
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function updateToken(User $client): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        usuarios
                    SET
                        token = :token,
                        token_auth_date = :date
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'token' => $client->token(),
            'date' => $client->tokenAuthDate()->format("Y-m-d H:i:s"),
            'id' => $client->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function update(User $user): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        usuarios
                    SET
                        nombre = :nombre,
                        email = :email,
                        contraseña = :contraseña
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'nombre' => $user->name(),
            'email' => $user->email(),
            'contraseña' => $user->password(),
            'id' => $user->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        usuarios 
                    WHERE
                        id = :id
                DELETE_QUERY;

        $parameters = [
            'id' => $id
        ];

        $this->primitiveQuery($query, $parameters);
    }

    private function toUser(?array $primitive): ?User
    {
        if ($primitive === null) {
            return null;
        }

        return new User(
            $primitive['id'],
            $primitive['nombre'],
            $primitive['email'],
            $primitive['contraseña'],
            $primitive['token'],
            empty($primitive['token_auth_date']) ? null : new DateTime($primitive['token_auth_date']),
        );
    }
}