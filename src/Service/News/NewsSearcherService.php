<?php

namespace Src\Service\News;

use Src\Model\News\NewsModel;
use Src\Entity\News\News;

final readonly class NewsSearcherService {
    private NewsModel $model;

    public function __construct() {
        $this->model = new NewsModel();
    }

    /** @return News[] */
    public function getAll(): array
    {
        return $this->model->search();
    }
}