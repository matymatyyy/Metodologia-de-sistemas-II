<?php

use Src\Entity\User\User;
use Src\Service\User\UsersSearcherService;
use Src\Middleware\AuthMiddleware;

final readonly class UsersGetController extends AuthMiddleware {
    private UsersSearcherService $service;

    public function __construct() {
        $this->service = new UsersSearcherService();
    }

    public function start(): void
    {
        $users = $this->service->search();
        echo json_encode([
            "data" => array_map($this->toResponse(), $users),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function toResponse(): Closure
    {
        return fn (User $user): array => [
            'id' => $user->id(),
            "name" => $user->name(),
            "email" => $user->email(),
            "password" => $user->password()
        ];
    }
}