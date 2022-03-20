<?php

namespace App\Infrastructure\Notifier;

use App\Infrastructure\Email\EmailInterface;

class EmailNotifier implements NotifierInterface
{
    private EmailInterface $mailer;

    public function __construct(EmailInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(string $title, string $message, array $to): bool
    {
        return $this->mailer->send($title, $message, implode(',', $to));
    }
}