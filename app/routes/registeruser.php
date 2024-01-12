<?php

global $app, $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->post(
    '/registeruser',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $registeruser_controller = $container->get('registerUserController');
        $registeruser_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }
);