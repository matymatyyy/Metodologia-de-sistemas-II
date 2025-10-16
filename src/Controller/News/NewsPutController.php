<?php

use Src\Utils\ControllerUtils;
use Src\Service\News\NewsUpdaterService;

final readonly class NewsPutController {
    
    private NewsUpdaterService $service;

    public function __construct() {
        $this->service = new NewsUpdaterService();
    }

    public function start(): void 
    {
        try {
            $title = ControllerUtils::getPost("title");
            $description = ControllerUtils::getPost("description");
            $text = ControllerUtils::getPost("text");
            $date = new \DateTime(ControllerUtils::getPost("date"));
            $image = ControllerUtils::getPost("image");
            $id = ControllerUtils::getPost("id");

            $news = $this->service->update($title, $description, $text, $date, $image, $id);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $news,
                'message' => 'Noticia actualizada con éxito'
            ]);

        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar la noticia: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }
}
