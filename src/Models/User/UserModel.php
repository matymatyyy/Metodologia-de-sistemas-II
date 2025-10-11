<?php 

namespace Src\Model\User;

use DateTime;
use Src\Entity\User\User;
use Src\Model\DatabaseModel;

final readonly class UserModel extends DatabaseModel {

    public function findByEmailAndPassword(string $email, string $password): ?User
    {
        $query = <<<SELECT_QUERY
                    SELECT
                        U.*
                    FROM
                        users U
                    WHERE
                        U.email = :email
                SELECT_QUERY;

        $parameters = [
            'email' => $email,
        ];

        $result = $this->primitiveQuery($query, $parameters);
        
        $user = $this->toUser($result[0] ?? null); 

        if ($user === null) {
            return null;
        }

        if (password_verify($password, $user->password())) {
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
                        users U
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
                        U.name,
                        U.email,
                        U.password,
                        U.token,
                        U.token_auth_date
                    FROM
                        users U
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
                        C.name,
                        C.email,
                        C.password,
                        C.token,
                        C.token_auth_date
                    FROM 
                        users C
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
                INSERT INTO users
                (name, email, password, token, token_auth_date)
                VALUES
                (:name, :email, :password, :token, :tokenAuthDate)
                INSERT_QUERY;

        $parameters = [
            "name" => $user->name(),
            "email" => $user->email(),
            "password" => $user->password(),
            "token" => $user->token(),
            "tokenAuthDate" => $user->tokenAuthDate()?->format("Y-m-d H:i:s")
        ];
        
        $this->primitiveQuery($query, $parameters);
    }

    public function updateToken(User $client): void
    {
        $query = <<<SELECT_QUERY
                    UPDATE
                        users
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
                        users
                    SET
                        name = :name,
                        email = :email,
                        password = :password
                    WHERE
                        id = :id
                SELECT_QUERY;

        $parameters = [
            'name' => $user->name(),
            'email' => $user->email(),
            'password' => $user->password(),
            'id' => $user->id()
        ];

        $this->primitiveQuery($query, $parameters);
    }

    public function delete(int $id): void
    {
        $query = <<<DELETE_QUERY
                    DELETE FROM
                        users 
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
            $primitive['name'],
            $primitive['email'],
            $primitive['password'],
            $primitive['token'],
            empty($primitive['token_auth_date']) ? null : new DateTime($primitive['token_auth_date']),
        );
    }
}