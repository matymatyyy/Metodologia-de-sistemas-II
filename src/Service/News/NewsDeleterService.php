<?php

namespace Src\Service\News;

use Src\Model\News\NewsModel;

final readonly class NewsDeleterService {
    private NewsModel $model;
    private NewsFinderService $finder;

    public function __construct()
    {
        $this->model = new NewsModel;
        $this->finder = new NewsFinderService;
    }

    public function delete(int $id): void
    {
        $news = $this->finder->find($id);

        $this->model->delete($news->id());
    }
}