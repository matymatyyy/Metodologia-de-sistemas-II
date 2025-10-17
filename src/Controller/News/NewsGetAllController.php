<?php

use Src\Service\News\NewsSearcherService;

final readonly class NewsGetAllController {
    
    private NewsSearcherService $service;

    public function __construct() {
        $this->service = new NewsSearcherService();
    }

    public function start(): void
    {
        try {
            $news = $this->service->getAll();

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => array_map(fn($n) => [
                    "id" => $n->id(),
                    "title" => $n->title(),
                    "description" => $n->description(),
                    "text" => $n->text(),
                    "date" => $n->date(),
                    "image" => $n->image()
                ], $news),
                'message' => 'Noticias obtenidas correctamente'
            ]);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener las noticias: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }
}
