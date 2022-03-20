<?php

declare(strict_types=1);

namespace Tests\Application\Actions\Job;

use App\Domain\Job\JobRepository;
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
}
