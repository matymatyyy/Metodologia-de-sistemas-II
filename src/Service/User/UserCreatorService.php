<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;
use Src\Entity\User\User;

final readonly class UserCreatorService {

    private UserModel $model;

    public function __construct() 
    {
        $this->model = new UserModel();
    }

    public function create(
        string $name,
        string $email,
        string $password,
        ?string $habilitado,
        ?string $activo,
    ): void 
    {
        $user = User::create(
            $name,
            $email,
            $password,
            $habilitado,
            $activo,
        );
        $this->model->insert($user);
    }

}

