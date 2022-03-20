<?php

namespace App\Infrastructure\Command;

use App\Infrastructure\Email\Mailer;

class CommandMailer extends AbstractCommand
{
    private Mailer $mailer;

    public function __construct()
    {
        $this->mailer = new Mailer(
            $_ENV['EMAIL_HOST'],
            $_ENV['EMAIL_USERNAME'],
            $_ENV['EMAIL_PASSWORD'],
            $_ENV['EMAIL_PORT'],
            $_ENV['EMAIL_FROM']
        );
    }

    public function run(array $params): array
    {
        $success = $this->mailer->send(
            $params['subject'],
            $params['body'],
            $params['to'],
            $params['from']
        );
        return ['success' => $success];
    }
}