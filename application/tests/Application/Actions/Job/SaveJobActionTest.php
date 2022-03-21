<?php

namespace Tests\Application\Actions\Job;

use App\Application\Actions\ValidationException;
use App\Domain\Job\JobManagerNotifier;
use App\Domain\Job\JobRepository;
use Prophecy\Argument;
use Slim\Exception\HttpNotFoundException;
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

        $jobRepository = $app->getContainer()->get(JobRepository::class);
        $jobData       = $jobRepository->findById($payload['data']['id']);

        $this->assertNotEmpty($jobData);
    }

    public function testShouldNotifyManager()
    {
        $app = $this->getAppInstance();

        $notified            = false;
        $jobNotifierProphecy = $this->prophesize(JobManagerNotifier::class);
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

    public function testShouldValidateTitleMaxLength()
    {
        $app = $this->getAppInstance();

        $this->expectException(ValidationException::class);

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'        => 'regular.1@jobsmapp.com',
                'title'       => 'Job Title Job Title Job Title Job Title Job Title Job Title Job Title Job Title 
                                  Job Title Job Title Job Title Job Title Job Title Job Title Job Title Job Title',
                'description' => 'Job Description',
            ]);
        $app->handle($request);
    }

    public function testShouldValidateTitleRequirement()
    {
        $app = $this->getAppInstance();

        $this->expectException(ValidationException::class);

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'        => 'regular.1@jobsmapp.com',
                'description' => 'Job Description',
            ]);
        $app->handle($request);
    }

    public function testShouldValidateDescriptionRequirement()
    {
        $app = $this->getAppInstance();

        $this->expectException(ValidationException::class);

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'  => 'regular.1@jobsmapp.com',
                'title' => 'Job Title'
            ]);
        $app->handle($request);
    }

    public function testShouldValidateUserRequirement()
    {
        $app = $this->getAppInstance();

        $this->expectException(ValidationException::class);

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'title'       => 'Job Title',
                'description' => 'Job Description'
            ]);
        $app->handle($request);
    }

    public function testShouldValidateInvalidUser()
    {
        $app = $this->getAppInstance();

        $this->expectException(HttpNotFoundException::class);

        $request = $this->createRequest('POST', '/jobs')
            ->withParsedBody([
                'user'        => 'doesntexist@jobsmapp.com',
                'title'       => 'Job Title',
                'description' => 'Job Description'
            ]);
        $app->handle($request);
    }
}
