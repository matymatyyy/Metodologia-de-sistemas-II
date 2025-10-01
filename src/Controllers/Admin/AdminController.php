<?php

final class AdminController {
    public function __construct() {}

    public function start(): void
    {
        require __DIR__ . "/../../Views/Admin/admin.php";
    }
}