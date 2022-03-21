<?php

namespace App\Domain\Job;

use App\Domain\User\UserRepository;
use App\Infrastructure\Notifier\EmailNotifier;

class JobManagerNotifier
{
    private EmailNotifier $notifier;
    private UserRepository $userRepository;

    public function __construct(EmailNotifier $notifier, UserRepository $userRepository)
    {
        $this->notifier       = $notifier;
        $this->userRepository = $userRepository;
    }

    public function notify(Job $job): void
    {
        $emails = $this->userRepository->getManagerEmails();

        $message = <<<MESSAGE
            A new job has been created with the following details: \n\n
            ID: {$job->id()} \n
            Title: {$job->title()} \n
            Description: {$job->description()} \n
            User: {$job->userId()} \n
MESSAGE;

        $this->notifier->notify(
            "Job #{$job->id()} has been created",
            $message,
            $emails
        );
    }
}