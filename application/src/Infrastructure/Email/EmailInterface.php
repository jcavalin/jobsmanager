<?php

namespace App\Infrastructure\Email;

interface EmailInterface
{
    public function send(string $subject, string $body, string $to, string $from = null): bool;
}