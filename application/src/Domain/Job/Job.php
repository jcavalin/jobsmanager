<?php


namespace App\Domain\Job;

use JsonSerializable;

class Job implements JsonSerializable
{
    private ?int $id;

    private string $title;

    private string $description;

    private int $userId;

    public function __construct(?int $id, string $title, string $description, int $userId)
    {
        $this->id          = $id;
        $this->title       = $title;
        $this->description = $description;
        $this->userId      = $userId;
    }

    public function jsonSerialize(): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'userId'      => $this->userId,
        ];
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function id(): ?int
    {
        return $this->id;
    }
}
