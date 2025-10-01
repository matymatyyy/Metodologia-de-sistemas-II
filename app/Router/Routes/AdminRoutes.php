<?php 

final readonly class AdminRoutes {
    public static function getRoutes(): array {
        return [
        [
            "name" => "admin_panel",
            "url" => "/admin",
            "controller" => "Admin/AdminController.php",
            "method" => "GET"
        ],

        ];
    }
}