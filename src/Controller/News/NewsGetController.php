<?php

use Src\Service\News\NewsFinderService;

final readonly class NewsGetController {
    private NewsFinderService $service;

    public function __construct() {
        $this->service = new NewsFinderService();
    }

    public function start(int $id): void
    {
        $news = $this->service->find($id);

        echo json_encode([
            "id" => $news->id(),
            "title" => $news->title(),
            "description" => $news->description(),
            "text" => $news->text(),
            "publicationDate" => $news->publicationDate()->format("Y-m-d"),
            "image" => $news->image()
        ]);
    }
}