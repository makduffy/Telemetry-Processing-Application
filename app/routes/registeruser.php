<?php

global $app, $app;

/**
 * Defines a route for registering a user via POST request.
 *
 * @param Request $request The HTTP request object.
 * @param Response $response The HTTP response object.
 *
 * @return Response The HTTP response object after processing the user registration.
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/registeruser', function (Request $request, Response $response) use ($app) {
    $container = $app->getContainer();
    $register_user_controller = $container->get('registerUserController');
    // Delegate the creation of HTML output to the controller.
    $register_user_controller->createHtmlOutput($container, $request, $response);
    // Return the updated response.
    return $response;
});