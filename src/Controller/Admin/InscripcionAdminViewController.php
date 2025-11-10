<?php

use Src\Middleware\AuthMiddleware;

include_once $_SERVER["DOCUMENT_ROOT"] . '/src/Controller/ViewController.php';

final readonly class InscripcionAdminViewController extends ViewController
{
    public function __construct()
    {
        parent::__construct("Admin/inscripciones");
    }

    public function start(): void
    {
        AuthMiddleware::handleSession(true);
        parent::call("");
    }
}
