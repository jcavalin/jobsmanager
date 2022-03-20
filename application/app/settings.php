<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'db'                  => [
                    'connection' => $_ENV['DB_CONNECTION'],
                    'host'       => $_ENV['DB_HOST'],
                    'database'   => $_ENV['DB_DATABASE'],
                    'username'   => $_ENV['DB_USERNAME'],
                    'password'   => $_ENV['DB_PASSWORD'],
                ]
            ]);
        }
    ]);
};
