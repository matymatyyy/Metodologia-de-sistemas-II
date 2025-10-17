<?php

use Src\Utils\ControllerUtils;
use Src\Service\News\NewsDeleterService;

final readonly class NewsDeleteController {

    private NewsDeleterService $service;

    public function __construct() {
        $this->service = new NewsDeleterService();
    }

    public function start(): void 
    {
        try {
            $id = ControllerUtils::getPost("id");

            $this->service->delete($id);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'message' => 'Noticia eliminada correctamente',
                'data' => ['id' => $id]
            ]);
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al eliminar la noticia: ' . $e->getMessage(),
                'data' => null
            ]);
        }
    }
}