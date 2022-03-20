<?php

namespace App\Infrastructure\Command;

interface CommandInterface
{
    public function run(array $params): array;
}