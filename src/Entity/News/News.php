<?php

namespace Src\Entity\News;

use DateTime;

final class News {

    public function __construct(
        private readonly ?int $id,
        private string $title,
        private string $description,
        private string $text,
        private ?DateTime $date,
        private string $image
    ) {}

    public static function create(
        string $title,
        string $description,
        string $text,
        ?DateTime $date,
        string $image
    ): self {
        return new self(
            null,
            $title,
            $description,
            $text,
            $date,
            $image
        );
    }

    public function modify(
        string $title,
        string $description,
        string $text,
        ?DateTime $date,
        string $image
    ): void {
        $this->title = $title;
        $this->description = $description;
        $this->text = $text;
        $this->date = $date;
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

    public function date(): ?DateTime
    {
        return $this->date;
    }

    public function image(): ?string
    {
        return $this->image;
    }
}
