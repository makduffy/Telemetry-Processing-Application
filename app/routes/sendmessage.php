<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/***
 * Created by Mak Duffy
 *
 *
 */

$app->get('/sendmessage', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $logger = $container->get('logger');
    $send_message_view = $container->get('sendMessageView');
    $view = $container->get('view');
    $settings = $container->get('settings');

    $send_message_view->showSendMessagePage($view, $settings, $response);
    $logger->info('send message page created successfully');

    return $response;

});
