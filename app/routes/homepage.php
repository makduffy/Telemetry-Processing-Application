<?php

global $app, $app;

/**
 * Created by Mak Duffy
 *
 * Defines a route for the home page.
 *
 */

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();


        /**
         * Retrieves the home page controller from the container.
         *
         * @var HomePageController $home_page_controller
         */

        $home_page_controller = $container->get('homePageController');
        $home_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }


);

