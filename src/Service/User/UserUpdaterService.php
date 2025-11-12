<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;

final readonly class UserUpdaterService {

    private UserModel $model;
    private UserFinderService $finder;

    public function __construct() 
    {
        $this->model = new UserModel();
        $this->finder = new UserFinderService();
    }

    public function update(
        string $name,
        string $email,
        string $password,
        int $id
    ): void 
    {
        $user = $this->finder->find($id);

        $user->modify(
            $name,
            $email,
            $password,
        );

        $this->model->update($user);
    }

}

