<?php

namespace App\Infrastructure\Command;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;

class CommandQueueMailer extends AbstractCommand
{
    private string $exchange;
    private string $queue;
    private AMQPStreamConnection $connection;
    private AMQPChannel $channel;

    public function __construct()
    {
        $this->exchange   = $_ENV['QUEUE_EXCHANGE'];
        $this->queue      = $_ENV['QUEUE_NAME'];
        $this->connection = new AMQPStreamConnection(
            $_ENV['QUEUE_HOST'],
            $_ENV['QUEUE_PORT'],
            $_ENV['QUEUE_USER'],
            $_ENV['QUEUE_PASSWORD']
        );

        $this->channel = $this->connection->channel();
        $this->channel->queue_declare($this->queue, false, true, false, false);
        $this->channel->exchange_declare(
            $this->exchange,
            AMQPExchangeType::DIRECT,
            false,
            true,
            false
        );

        $this->channel->queue_bind($this->queue, $this->exchange);
    }

    public function run(array $params): array
    {
        $payload = [
            'command' => CommandMailer::class,
            'params'  => [
                'subject' => $params['subject'],
                'body'    => $params['body'],
                'to'      => $params['to'],
                'from'    => $params['from']
            ]
        ];

        $messageBody = json_encode($payload);
        $message     = new AMQPMessage($messageBody, [
            'content_type'  => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);
        $this->channel->basic_publish($message, $this->exchange);

        $this->channel->close();
        $this->connection->close();

        return ['success' => true];
    }
}