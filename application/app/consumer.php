<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exception\AMQPIOException;
use PhpAmqpLib\Exchange\AMQPExchangeType;

function consumerStart()
{
    try {
        $exchange    = $_ENV['QUEUE_EXCHANGE'];
        $queue       = $_ENV['QUEUE_NAME'];
        $consumerTag = 'consumer';
        $connection  = new AMQPStreamConnection(
            $_ENV['QUEUE_HOST'],
            $_ENV['QUEUE_PORT'],
            $_ENV['QUEUE_USER'],
            $_ENV['QUEUE_PASSWORD']
        );
        $channel     = $connection->channel();

        $channel->queue_declare($queue, false, true, false, false);
        $channel->exchange_declare($exchange, AMQPExchangeType::DIRECT, false, true, false);

        $channel->queue_bind($queue, $exchange);

        echo "Starting consumer.\n";
        $channel->basic_consume($queue, $consumerTag, false, false, false, false, function ($message) {
            echo "\n###################################\n";
            echo "Getting message: \n\n {$message->body}\n\n";

            $payload = json_decode($message->body, true);
            $params  = json_encode($payload['params']);

            $result = exec("php ./app/console.php '{$payload['command']}' '{$params}'");

            echo "Command result:\n\n {$result} \n\n";

            $message->ack();

            echo "Finished\n";
            echo "###################################\n";

            // Send a message with the string "quit" to cancel the consumer.
            if ($message->body === 'quit') {
                $message->getChannel()->basic_cancel($message->getConsumerTag());
            }
        });

        register_shutdown_function(function ($channel, $connection) {
            echo "Finishing consumer.\n";

            $channel->close();
            $connection->close();
        }, $channel, $connection);

        $channel->consume();
    } catch (AMQPIOException $e) {
        echo "Connection failed.\n";
        echo $e->getMessage() . "\n";

        sleep(1);
        echo "Trying again...\n";
        consumerStart();
    }
}

consumerStart();