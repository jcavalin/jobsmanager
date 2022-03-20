<?php


namespace App\Domain\Job;

use App\Domain\User\UserNotFoundException;

interface JobRepository
{
    /**
     * @param int|null $userId
     * @return array
     */
    public function findAll(int $userId = null): array;

    /**
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array;

    /**
     * @param Job $job
     * @return Job
     * @throws UserNotFoundException
     */
    public function save(Job $job): Job;
}
