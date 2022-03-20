<?php


namespace App\Infrastructure\Persistence\Job;

use App\Domain\Job\Job;
use App\Domain\Job\JobRepository;

class InMemoryJobRepository implements JobRepository
{
    /**
     * @var Job[]
     */
    private array $jobs;

    /**
     * @param Job[]|null $jobs
     */
    public function __construct(array $jobs = null)
    {
        $this->jobs = $jobs ?? [
                1 => new Job(1, 'Title of Job 1', 'Description of Job 1', 1),
                2 => new Job(2, 'Title of Job 2', 'Description of Job 2', 2),
                3 => new Job(3, 'Title of Job 3', 'Description of Job 3', 3),
            ];
    }

    public function findAll(int $userId = null): array
    {
        $jobs = $this->jobs;
        if (!is_null($userId)) {
            $jobs = array_filter($jobs, fn(Job $job) => $job->id() == $userId);
        }

        return array_values($jobs);
    }

    public function save(Job $job): Job
    {
        $id = count($this->jobs) + 1;
        $job->setId($id);

        $this->jobs[$id] = $job;

        return $job;
    }
}
