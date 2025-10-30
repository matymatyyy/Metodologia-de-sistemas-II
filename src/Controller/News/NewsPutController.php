<?php

use Src\Middleware\AuthMiddleware;
use Src\Utils\ControllerUtils;
use Src\Service\News\NewsUpdaterService;

final readonly class NewsPutController extends AuthMiddleware {
    private NewsUpdaterService $service;

    public function __construct() {
        $this->service = new NewsUpdaterService();
    }

    public function start(int $id): void
    {
        
        $title = ControllerUtils::getPost("title");
        $description = ControllerUtils::getPost("description");
        $text = ControllerUtils::getPost("text");
        $publicationDate = new \DateTime(ControllerUtils::getPost("publicationDate"));
        $image = ControllerUtils::getPost("image");

        $this->service->update($title, $description, $text, $publicationDate, $image, $id);
    }
}
