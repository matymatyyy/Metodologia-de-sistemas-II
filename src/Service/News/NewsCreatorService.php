<?php

declare(strict_types = 1);

namespace Src\Service\News;

use DateTime;
use Src\Entity\News\News;
use Src\Model\News\NewsModel;

final readonly class NewsCreatorService {

    private NewsModel $model;

    public function __construct()
    {
        $this->model = new NewsModel();
    }

    public function create(string $title, string $description, string $text, ?DateTime $date, ?string $image): void
    {
        $news = News::create($title, $description, $text, $date, $image);
        
        $this->model->insert($news);
    }
}