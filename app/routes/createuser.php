<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/***
 * Created by Flavio Moreira and Rory Mackarel
 *
 *
 */

$app->post('/createuser', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $logger = $container->get('logger');
    $register_user_controller = $container->get('registerUserController');
    $register_user_controller->createHtmlOutput($container, $request, $response);
    return $response;

});
