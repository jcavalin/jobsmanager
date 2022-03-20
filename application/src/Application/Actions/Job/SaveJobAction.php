<?php


namespace App\Application\Actions\Job;

use App\Application\Actions\ValidationException;
use App\Domain\Job\JobManagerNotifier;
use App\Domain\Job\JobRepository;
use App\Domain\Job\JobBuilder;
use App\Domain\User\UserNotFoundException;
use App\Domain\User\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class SaveJobAction extends JobAction
{
    private JobBuilder $jobBuilder;
    private JobManagerNotifier $jobManagerNotifier;

    public function __construct(
        JobRepository $jobRepository,
        UserRepository $userRepository,
        JobBuilder $jobBuilder,
        JobManagerNotifier $jobManagerNotifier
    ){
        parent::__construct($jobRepository, $userRepository);

        $this->jobBuilder         = $jobBuilder;
        $this->jobManagerNotifier = $jobManagerNotifier;
    }

    /**
     * @throws ValidationException|UserNotFoundException
     */
    #[OA\Post(path: '/jobs', description: "Creates a new jobs for the user", tags: ["Job"])]
    #[OA\Response(response: '200', description: 'Job saved')]
    #[OA\RequestBody(
        description: 'The user email who owns the jobs',
        required: true,
        content: [new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                required: ['user', 'title', 'description'],
                properties: [
                    new OA\Property(
                        property: 'user',
                        description: 'The user email who is saving the job',
                        type: 'string',
                        example: 'regular.1@jobsmapp.com'
                    ),
                    new OA\Property(
                        property: 'title',
                        description: 'Job title',
                        type: 'string',
                        maximum: 100,
                        example: 'Send the financial report'
                    ),
                    new OA\Property(
                        property: 'description',
                        description: 'Job description',
                        type: 'string',
                        example: 'John Doe needs the financial report for the month of July last year to send to the accountant'
                    ),
                ],
                type: 'object'
            )
        )]
    )]
    protected function action(): Response
    {
        $params = $this->getFormData();
        $this->validation->required($this->request, $params, 'user')
            ->required($this->request, $params, 'title')
            ->required($this->request, $params, 'description')
            ->maxLength($this->request, $params, 'title', 100);

        $user = $this->userRepository->findByEmail($params['user']);
        $job  = $this->jobBuilder->addTitle($params['title'])
            ->addDescription($params['description'])
            ->addUserId($user->id())
            ->build();

        $this->jobRepository->save($job);
        $this->jobManagerNotifier->notify($job);

        return $this->respondWithData(['id' => $job->id()]);
    }
}
