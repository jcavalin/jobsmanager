<?php

declare(strict_types=1);

use App\Application\Settings\SettingsInterface;
use App\Infrastructure\Db\DatabaseInterface;
use App\Infrastructure\Db\PdoDatabase;
use App\Infrastructure\Email\AsyncMailer;
use App\Infrastructure\Email\EmailInterface;
use DI\ContainerBuilder;
use Psr\Container\ContainerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        DatabaseInterface::class => function (ContainerInterface $c) {
            $settings = $c->get(SettingsInterface::class);
            $db       = $settings->get('db');

            return new PdoDatabase($db['connection'], $db['host'], $db['database'], $db['username'], $db['password']);
        },
        EmailInterface::class    => function (ContainerInterface $c) {
            return new AsyncMailer();
        },
    ]);
};
