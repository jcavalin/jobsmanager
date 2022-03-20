<?php

declare(strict_types=1);

namespace Tests\Application\Actions\User;

use App\Application\Actions\ActionPayload;
use App\Domain\Job\JobRepository;
use App\Domain\Job\Job;
use DI\Container;
use Tests\TestCase;

class ListUserActionTest extends TestCase
{
    public function testAction()
    {
        $app = $this->getAppInstance();

        /** @var Container $container */
        $container = $app->getContainer();

        $user = new Job(1, 'bill.gates', 'Bill', 'Gates');

        $userRepositoryProphecy = $this->prophesize(JobRepository::class);
        $userRepositoryProphecy
            ->findAll()
            ->willReturn([$user])
            ->shouldBeCalledOnce();

        $container->set(JobRepository::class, $userRepositoryProphecy->reveal());

        $request = $this->createRequest('GET', '/users');
        $response = $app->handle($request);

        $payload = (string) $response->getBody();
        $expectedPayload = new ActionPayload(200, [$user]);
        $serializedPayload = json_encode($expectedPayload, JSON_PRETTY_PRINT);

        $this->assertEquals($serializedPayload, $payload);
    }
}
