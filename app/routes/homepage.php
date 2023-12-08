<?php

global $app, $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get(
    '/',
    function(Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $home_page_controller = $container->get('homePageController');
        $home_page_controller->createHtmlOutput($container, $request, $response);
        return $response;
    }


);

$app->post('/',
    function (Request $request, Response $response)
    use ($app)
    {
        $container = $app->getContainer();

        $home_page_controller = $container->get('databaseWrapper');
        $home_page_controller->makeDatabaseConnection($container, $request, $response);
        return $response;
    // Handle your form submission logic here
});

