<?php


namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class SaveJobAction extends JobAction
{
    /**
     * @throws ActionException
     */
    #[OA\Post(path: '/jobs', description: "Creates a new jobs for the user", tags: ["Job"])]
    #[OA\Response(response: '200', description: 'Job saved')]
    #[OA\RequestBody(
        description: 'The user email who owns the jobs',
        required: true,
//        content: new OA\JsonContent(
//            type: 'array',
//            items: new OA\Items(
//                properties: [
//                    new OA\Property(property: 'usuario', type: 'string')
//                ],
//                type: 'object'
//            )
//        )
        content: [new OA\MediaType(
            mediaType: 'multipart/form-data',
            schema: new OA\Schema(
                properties: [
                    new OA\Property(property: 'usuario', type: 'string')
                ],
                type: 'object'
            )
        )]
    )]
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user   = $this->jobRepository->findUserOfId($userId);

        return $this->respondWithData($user);
    }
}
