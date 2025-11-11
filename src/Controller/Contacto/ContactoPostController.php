<?php

use Src\Utils\ControllerUtils;
use Src\Service\Contacto\ContactoCreatorService;

final readonly class ContactoPostController {
    
    private ContactoCreatorService $service;

    public function __construct() {
        $this->service = new ContactoCreatorService();
    }

    public function start(): void
    {
        header('Content-Type: application/json');
        
        try {
            $nombre = ControllerUtils::getPost("nombre");
            $email = ControllerUtils::getPost("email");
            $asunto = ControllerUtils::getPost("asunto");
            $mensaje = ControllerUtils::getPost("mensaje");

            // Validaciones básicas del lado servidor
            if (empty($nombre) || strlen($nombre) < 5) {
                http_response_code(400);
                echo json_encode(['error' => 'El nombre debe tener al menos 5 caracteres']);
                return;
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                http_response_code(400);
                echo json_encode(['error' => 'Email inválido']);
                return;
            }

            if (empty($asunto)) {
                http_response_code(400);
                echo json_encode(['error' => 'Debe seleccionar un asunto']);
                return;
            }

            if (empty($mensaje) || strlen($mensaje) < 10) {
                http_response_code(400);
                echo json_encode(['error' => 'El mensaje debe tener al menos 10 caracteres']);
                return;
            }

            $this->service->create($nombre, $email, $asunto, $mensaje);

            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Contacto guardado correctamente']);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
        }
    }
}