<?php

namespace App\Infrastructure\Email;

use App\Infrastructure\Command\CommandQueueMailer;

class AsyncMailer implements EmailInterface
{
    /**
     * @param string $subject
     * @param string $body
     * @param string $to
     * @param string|null $from
     * @return bool
     */
    public function send(string $subject, string $body, string $to, string $from = null): bool
    {
        $commandClass = CommandQueueMailer::class;
        $params       = json_encode([
            'subject' => $subject,
            'body'    => $body,
            'to'      => $to,
            'from'    => $from,
        ]);

        return exec("php ../app/console.php '{$commandClass}' '{$params}'");
    }
}