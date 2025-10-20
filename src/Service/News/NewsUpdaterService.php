<?php

declare(strict_types = 1);

namespace Src\Service\News;

use DateTime;
use Src\Entity\News\News;
use Src\Model\News\NewsModel;

final readonly class NewsUpdaterService {
    private NewsModel $model;

    public function __construct() {
        $this->model = new NewsModel();
    }

    public function update(string $title, string $description, string $text, ?DateTime $publicationDate, ?string $image, int $id): void
    {
        $news = $this->model->find($id);

        $news->modify($title, $description, $text, $publicationDate, $image);

        $this->model->update($news);
    }
}