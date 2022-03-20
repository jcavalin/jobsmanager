<?php

namespace App\Domain\Job;

class JobBuilder
{
    private array $properties;

    public function __construct()
    {
        $this->properties = [];
    }

    public function addId(int $id): static
    {
        $this->properties['id'] = $id;
        return $this;
    }

    public function addTitle(string $title): static
    {
        $this->properties['title'] = $title;
        return $this;
    }

    public function addDescription(string $description): static
    {
        $this->properties['description'] = $description;
        return $this;
    }

    public function addUserId(int $userId): static
    {
        $this->properties['userId'] = $userId;
        return $this;
    }

    public function build(): Job
    {
        return new Job(
            $this->properties['id'] ?? null,
            $this->properties['title'],
            $this->properties['description'],
            $this->properties['userId']
        );
    }
}
