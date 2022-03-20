<?php


namespace App\Application\Actions\Job;

use App\Application\Actions\ActionException;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class ListJobsAction extends JobAction
{
    /**
     * @throws ActionException
     */
    #[OA\Get(path: '/jobs', description: "Returns jobs according to the user", tags: ["Job"])]
    #[OA\Response(response: '200', description: 'Jobs list')]
    #[OA\Parameter(
        name: 'user',
        description: 'The user email who want to see the jobs',
        in: 'query',
        required: true,
        schema: new OA\Schema(
            type: 'string',
            example: 'regular.1@jobsmapp.com'
        )
    )]
    protected function action(): Response
    {
        $params = $this->getQueryParams();
        $this->validateRequired($params, 'user');

        $user = $this->userRepository->findByEmail($params['user']);
        $jobs = $this->jobRepository->findAll($user->isManager() ? null : $user->id());

        return $this->respondWithData($jobs);
    }
}
