<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;

final readonly class UserDeleterService {

    private UserModel $model;
    private UserFinderService $finder;

    public function __construct() 
    {
        $this->model = new UserModel();
        $this->finder = new UserFinderService();
    }

    public function delete(
        int $id
    ): void 
    {
        $user = $this->finder->find($id);

        $user->delete();

        $this->model->update($user);
    }

}

