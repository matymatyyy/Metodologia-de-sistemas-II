<?php

use Src\Middleware\AuthMiddleware;
use Src\Service\News\NewsDeleterService;

final readonly class NewsDeleteController extends AuthMiddleware {
    private NewsDeleterService $service;

    public function __construct() {
        $this->service = new NewsDeleterService();
    }

    public function start(int $id): void 
    {
        $this->service->delete($id);
    }
}