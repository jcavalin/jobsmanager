<?php

namespace App\Infrastructure\Notifier;

interface NotifierInterface
{
    public function notify(string $title, string $message, array $to): bool;
}