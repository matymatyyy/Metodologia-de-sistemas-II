<?php

use Src\Middleware\AuthMiddleware;

include_once $_SERVER["DOCUMENT_ROOT"] . '/src/Controller/ViewController.php';

final readonly class UserAdminViewController extends ViewController
{
    public function __construct()
    {
        parent::__construct("Admin/usuarios");
    }

    public function start(): void
    {
        AuthMiddleware::handleSession(true);
        parent::call("");
    }
}
