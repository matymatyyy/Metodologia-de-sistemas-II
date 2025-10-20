<?php

use Src\Entity\News\News;
use Src\Middleware\AuthMiddleware;
use Src\Service\News\NewsSearcherService;

final readonly class NewsGetAllController extends AuthMiddleware {
    private NewsSearcherService $service;

    public function __construct() {
        $this->service = new NewsSearcherService();
    }

    public function start(): void
    {
        $news = $this->service->getAll();
        echo json_encode([
            "data" => array_map($this->toResponse(), $news),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    protected function toResponse(): Closure 
    {
        return fn (News $news): array => [
            'id' => $news->id(),
            'title' => $news->title(),
            'description' => $news->description(),
            'text' => $news->text(),
            'publicationDate' => $news->publicationDate()->format("Y-m-d"),
            'image' => $news->image()
        ];
    }
}
