<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


$app->get(
    '/telemetrymain',
    function(Request $request, Response $response)
        use ($app)
    {
        $container = $app->getContainer();
        $telemetry_controller = $container->get('TelemetryController');

        $telemetry_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }
);
