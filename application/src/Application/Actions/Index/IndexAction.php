<?php


namespace App\Application\Actions\Index;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use OpenApi\Attributes as OA;

#[OA\Info(version: "1.0.0", title: "Application")]
#[OA\Server(url: "http://localhost:8080")]
class IndexAction extends Action
{
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
