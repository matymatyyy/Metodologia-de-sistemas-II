<?php

use Src\Utils\ControllerUtils;
use Src\Service\News\NewsCreatorService;

final readonly class NewsPostController {
    
    private NewsCreatorService $service;

    public function __construct() {
        $this->service = new NewsCreatorService();
    }

    public function start(): void
    {
        $title = ControllerUtils::getPost("title");
        $description = ControllerUtils::getPost("description");
        $text = ControllerUtils::getPost("text");
        $publicationDate = new \DateTime(ControllerUtils::getPost("publicationDate"));
        $image = ControllerUtils::getPost("image");

        $this->service->create($title, $description, $text, $publicationDate, $image);
    }
}