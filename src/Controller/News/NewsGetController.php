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
            "success" => true,
            "data" => [
                "id" => $news->id(),
                "titulo" => $news->title(),
                "contenido" => $news->description(),
                "texto" => $news->text(),
                "fecha_publicacion" => $news->publicationDate()->format("Y-m-d"),
                "imagen_url" => $news->image()
            ]
        ]);
    }
}