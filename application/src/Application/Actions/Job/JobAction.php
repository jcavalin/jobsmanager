<?php


namespace App\Application\Actions\Job;

use App\Application\Actions\Action;
use App\Domain\Job\JobRepository;
use App\Domain\User\UserRepository;

abstract class JobAction extends Action
{
    protected JobRepository $jobRepository;
    protected UserRepository $userRepository;

    public function __construct(JobRepository $jobRepository, UserRepository $userRepository)
    {
        parent::__construct();
        $this->jobRepository  = $jobRepository;
        $this->userRepository = $userRepository;
    }
}
