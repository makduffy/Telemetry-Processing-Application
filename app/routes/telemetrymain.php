<?php
global $app;
/**
 * Defines a route for the telemetry main page.
 *
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 *
 * @return Response The HTTP response object after processing the telemetry main page.
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/telemetrymain', function (Request $request, Response $response) use ($app) {
    $container = $app->getContainer();
    /**
     * Retrieves the telemetry controller from the container.
     *
     * @var TelemetryController $telemetry_controller
     */
    $telemetry_controller = $container->get('telemetryController');
    /**
     * Retrieves the logger from the container.
     *
     * @var Logger $logger
     */
    $logger = $container->get('logger');

    try {
        // Invokes the method to create HTML output for the telemetry main page.
        $telemetry_controller->createHtmlOutput($container, $request, $response);
        // Logs a successful access to the telemetry main route.
        $logger->info('Telemetry main route accessed successfully');
    } catch (\Exception $e) {
        // Logs an error if an exception is caught during processing.
        $logger->error('Error in telemetry main route: ' . $e->getMessage());
    }
    // Returns the HTTP response.
    return $response;

});
