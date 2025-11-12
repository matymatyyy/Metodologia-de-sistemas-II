<?php 

declare(strict_types = 1);

namespace Src\Service\User;

use Src\Model\User\UserModel;
use Src\Entity\User\User;
use Src\Entity\User\Exception\UserNotFoundException;

final readonly class UserFinderService {

    private UserModel $model;

    public function __construct() 
    {
        $this->model = new UserModel();
    }

    public function find(int $id): User 
    {
        $user = $this->model->find($id);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        return $user;
    }

}

