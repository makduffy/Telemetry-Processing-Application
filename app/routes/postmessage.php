<?php
global $app;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

/***
 * Created by Mak Duffy
 *
 *
 */

$app->get('/postmessage', function (Request $request, Response $response) use ($app) {

    $container = $app->getContainer();
    $logger = $container->get('logger');
    $post_message_view = $container->get('postMessageView');
    $post_message_model = $container->get('postMessageModel');
    $settings = $container->get('settings');
    $view = $container->get('container');
    $soap_wrapper = $container->get('soapWrapper');

    $parsed_body = $request->getParsedBody();
    $message = $parsed_body('message');
    $post_message_view->showPostMessagePage($view, $settings, $response);
    $post_message_model->sendMessage($container, $response, $message, $settings, $soap_wrapper);

    $logger->info('Post message page created successfully');

    return $response;

});