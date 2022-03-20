<?php

declare(strict_types=1);

use App\Application\Actions\Index\IndexAction;
use App\Application\Actions\Job\ListJobsAction;
use App\Application\Actions\Job\SaveJobAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
        // CORS Pre-Flight OPTIONS Request Handler
        return $response;
    });

    $app->get('/', IndexAction::class);

    $app->group('/jobs', function (Group $group) {
        $group->get('', ListJobsAction::class);
        $group->post('/', SaveJobAction::class);
    });
};
