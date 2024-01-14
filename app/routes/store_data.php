<?php
global $app;

/**
 * date 12/01/14
 *
 * created by Mak Duffy
 *
 * defines routes to store data
 *
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post('/store_data', function (Request $request, Response $response) use ($app) {
    $container = $app->getContainer();
    $telemetryController = $container->get('telemetryController');
    $logger = $container->get('logger');

    try {
        $telemetryController->storeDataInDatabase($container, $request, $response);
        $logger->info('Data stored in database');
    } catch (\Exception $e) {
        $logger->error('Unable to store data in database'. $e->getMessage());
        $response = $response->withStatus(500)->withBody();
    }

    return $response;
});

