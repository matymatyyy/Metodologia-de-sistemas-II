<?php

namespace Src\Entity\News;

use DateTime;

final class News {

    public function __construct(
        private readonly ?int $id,
        private string $title,
        private string $description,
        private string $text,
        private ?DateTime $publicationDate,
        private string $image
    ) {}

    public static function create(
        string $title,
        string $description,
        string $text,
        ?DateTime $publicationDate,
        string $image
    ): self {
        return new self(
            null,
            $title,
            $description,
            $text,
            $publicationDate,
            $image
        );
    }

    public function modify(
        string $title,
        string $description,
        string $text,
        ?DateTime $publicationDate,
        string $image
    ): void {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->publicationDate = $publicationDate;
        $this->image = $image;
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function text(): string
    {
        return $this->text;
    }

    public function publicationDate(): ?DateTime
    {
        return $this->publicationDate;
    }

    public function image(): ?string
    {
        return $this->image;
    }
}
