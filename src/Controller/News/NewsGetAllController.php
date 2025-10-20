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
            "success" => true,
            "data" => array_map($this->toResponse(), $news),
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
    
    protected function toResponse(): Closure 
    {
        return fn (News $news): array => [
            'id' => $news->id(),
            'titulo' => $news->title(),
            'contenido' => $news->description(),
            'texto' => $news->text(),
            'fecha_publicacion' => $news->publicationDate()->format("Y-m-d"),
            'publicado' => 1, // Por defecto publicado, ya que no hay campo en BD
            'imagen_url' => $news->image() ? $news->image() : null
        ];
    }
}
