<?php

declare(strict_types=1);

use App\Domain\Job\JobRepository;
use App\Domain\User\UserRepository;
use App\Infrastructure\Persistence\Job\DbJobRepository;
use App\Infrastructure\Persistence\User\DbUserRepository;
use DI\ContainerBuilder;
use function DI\autowire;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        JobRepository::class          => autowire(DbJobRepository::class),
        UserRepository::class         => autowire(DbUserRepository::class)
    ]);
};
