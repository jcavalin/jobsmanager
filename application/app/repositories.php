<?php

declare(strict_types=1);

use App\Domain\Job\JobRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Job\DbJobRepository;
use App\Infrastructure\Persistence\User\DbUserRepository;
use DI\ContainerBuilder;

return function (ContainerBuilder $containerBuilder) {
    // Here we map our UserRepository interface to its in memory implementation
    $containerBuilder->addDefinitions([
        JobRepository::class  => \DI\autowire(DbJobRepository::class),
        UserRepository::class => \DI\autowire(DbUserRepository::class),
    ]);
};
