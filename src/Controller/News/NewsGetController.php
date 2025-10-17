<?php

use Src\Service\News\NewsFinderService;

final readonly class NewsGetController {
    
    private NewsFinderService $service;

    public function __construct() {
        $this->service = new NewsFinderService();
    }

    public function start(int $id): void
    {
        try {
            $news = $this->service->find($id);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => [
                    "id" => $news->id(),
                    "title" => $news->title(),
                    "description" => $news->description(),
                    "text" => $news->text(),
                    "date" => $news->date(),
                    "image" => $news->image()
                ],
                'message' => 'Noticia obtenida correctamente'
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al obtener la noticia: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }
}