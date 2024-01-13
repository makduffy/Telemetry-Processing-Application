<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/telemetrymain', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $telemetry_controller = $container->get('telemetryController');
    $logger = $container->get('logger');

    $telemetry_controller->fetchAndStoreData($container, $response);
    try {
        $telemetry_controller->createHtmlOutput($container, $request, $response);
        $logger->info('Telemetry main route accessed successfully');
    } catch (\Exception $e) {
        $logger->error('Error in telemetry main route: ' . $e->getMessage());
    }

    return $response;

});
