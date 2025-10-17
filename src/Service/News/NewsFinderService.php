<?php

declare(strict_types = 1);

namespace Src\Service\News;

use Src\Model\News\NewsModel;
use Src\Entity\News\News;
use Src\Entity\News\Exception\NewsNotFoundException;

final readonly class NewsFinderService {
    
    private NewsModel $model;

    public function __construct()
    {
        $this->model = new NewsModel();
    }

    public function find(int $id): News 
    {
        $news = $this->model->find($id);

        if ($news === null) {
            throw new NewsNotFoundException($id);
        }

        return $news;
    }
}
