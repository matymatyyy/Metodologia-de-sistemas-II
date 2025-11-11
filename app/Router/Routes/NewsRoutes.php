<?php

final readonly class NewsRoutes
{
  public static function getRoutes(): array
  {
    return [
      [
        "name" => "news_get",
        "url" => "/news",
        "controller" => "News/NewsGetController.php",
        "method" => "GET",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int",
          ]
        ]
      ],
      [
        "name" => "news_get_all",
        "url" => "/news",
        "controller" => "News/NewsGetAllController.php",
        "method" => "GET"
      ],
      [
        "name" => "news_create",
        "url" => "/news",
        "controller" => "News/NewsPostController.php",
        "method" => "POST"
      ],
      [
        "name" => "news_update",
        "url" => "/news",
        "controller" => "News/NewsPutController.php",
        "method" => "PUT",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int",
          ]
        ]
      ],
      [
        "name" => "news_delete",
        "url" => "/news",
        "controller" => "News/NewsDeleteController.php",
        "method" => "DELETE",
        "parameters" => [
          [
            "name" => "id",
            "type" => "int",
          ]
        ]
      ],
      [
        "name" => "news_view",
        "url" => "/news",
        "controller" => "News/NewsViewController.php",
        "method" => "GET"
      ]
    ];
  }
}
