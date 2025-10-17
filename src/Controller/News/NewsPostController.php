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
        try {
            $title = ControllerUtils::getPost("title");
            $description = ControllerUtils::getPost("description");
            $text = ControllerUtils::getPost("text");
            $date = new \DateTime(ControllerUtils::getPost("date"));
            $image = ControllerUtils::getPost("image");

            $news = $this->service->create($title, $description, $text, $date, $image);

            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'data' => $news,
                'message' => 'Noticia creada con éxito'
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al crear la noticia: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }
}