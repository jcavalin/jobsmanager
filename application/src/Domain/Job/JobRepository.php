<?php


namespace App\Domain\Job;

use App\Domain\User\UserNotFoundException;

interface JobRepository
{
    /**
     * @return Job[]
     */
    public function findAll(int $userId = null): array;

    /**
     * @param Job $job
     * @return Job
     * @throws UserNotFoundException
     */
    public function save(Job $job): Job;
}
