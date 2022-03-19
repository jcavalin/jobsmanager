<?php

declare(strict_types=1);

namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

#[OA\Info(version: "1.0.0", title: "Application")]
class IndexAction extends Action
{
    #[OA\Get(path: '/')]
    #[OA\Response(response: '200', description: 'Documentation for OpenApi')]
    protected function action(): Response
    {
        $filepath = realpath('../docs/openapi.json');
        $openApi  = [];

        if ($filepath) {
            $openApi = json_decode(file_get_contents($filepath));
        }

        return $this->respondWithData($openApi);
    }
}
