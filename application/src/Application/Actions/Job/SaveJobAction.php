<?php


namespace App\Application\Actions\Job;

use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

class SaveJobAction extends JobAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user   = $this->jobRepository->findUserOfId($userId);

        return $this->respondWithData($user);
    }
}
