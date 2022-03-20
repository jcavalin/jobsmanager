<?php

namespace App\Infrastructure\Email;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mailer implements EmailInterface
{
    protected PHPMailer $mailer;
    protected string $from;

    public function __construct(string $host, string $username, string $password, string $port, string $from)
    {
        $this->mailer = new PHPMailer();

        $this->mailer->isSMTP();
        $this->mailer->SMTPAuth = false;
        $this->mailer->Host     = $host;
        $this->mailer->Username = $username;
        $this->mailer->Password = $password;
        $this->mailer->Port     = $port;
        $this->from             = $from;
    }

    /**
     * @param string $subject
     * @param string $body
     * @param string $to
     * @param string|null $from
     * @return bool
     * @throws Exception
     */
    public function send(string $subject, string $body, string $to, string $from = null): bool
    {
        $this->mailer->Subject = $subject;
        $this->mailer->Body    = $body;
        $this->mailer->setFrom($from ?? $this->from);
        array_map(fn($address) => $this->mailer->addAddress($address), explode(',', $to));

        return $this->mailer->send();
    }
}