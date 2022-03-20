<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Job;

use App\Domain\Job\JobManagerNotifier;
use App\Domain\Job\JobRepository;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Tests\TestCase;

class SaveJobActionTest extends TestCase
{
    public function testShouldSaveJob()
    {
        $app = $this->getAppInstance();

        $request  = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'        => 'regular.1@jobsmapp.com',
                'title'       => 'Job Title',
                'description' => 'Job Description',
            ]);
        $response = $app->handle($request);
        $payload  = json_decode((string) $response->getBody(), true);

        /** @var JobRepository $payload */
        $jobRepository = $app->getContainer()->get(JobRepository::class);
        $jobData       = $jobRepository->findById($payload['data']['id']);

        $this->assertNotEmpty($jobData);
    }

    public function testShouldNotifyManager()
    {
        $app = $this->getAppInstance();

        $notified            = false;
        $jobNotifierProphecy = $this->prophesize(JobManagerNotifier::class);
        /** @var ObjectProphecy */
        $jobNotifierProphecy->notify(Argument::any())->will(function () use (&$notified) {
            $notified = true;
        });
        $app->getContainer()->set(JobManagerNotifier::class, $jobNotifierProphecy->reveal());

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'        => 'regular.1@jobsmapp.com',
                'title'       => 'Job Title',
                'description' => 'Job Description',
            ]);
        $app->handle($request);

        $this->assertTrue($notified);
    }
}
