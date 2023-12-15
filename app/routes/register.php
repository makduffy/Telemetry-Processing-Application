<?php

global $app, $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/register',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $home_page_controller = $container->get('registerController');
        $home_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }


);