<?php 

namespace Src\Service\User;

use Src\Entity\User\User;
use Src\Model\User\UserModel;

final readonly class UsersSearcherService {
    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    /** @return User[] */
    public function search(): array
    {
        return $this->userModel->search();
    }
}