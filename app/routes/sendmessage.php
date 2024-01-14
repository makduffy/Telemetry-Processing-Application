<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app->get('/send_message', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $logger = $container->get('logger');
    $send_message_view = $container->get('sendMessageView');

    $send_message_view->showSendMessagePage($container, $request, $response);
    $logger->info('send message page created successfully');

    return $response;

});
