<?php 

declare(strict_types = 1);

namespace src\Service\User;

use Src\Entity\User\Exception\UserNotFoundException;
use Src\Entity\User\User;
use Src\Model\User\UserModel;

final readonly class UserLoginService {

    private UserModel $model;
    private UserTokenGeneratorService $tokenGenerator;

    public function __construct() 
    {
        $this->model = new UserModel();
        $this->tokenGenerator = new UserTokenGeneratorService();
    }

    public function login(string $email, string $password): User
    {
        $user = $this->model->findByEmailAndPassword($email, $password);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        $this->tokenGenerator->generate($user);

        return $user;
    }
}
